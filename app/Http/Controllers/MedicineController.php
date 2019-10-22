<?php

namespace App\Http\Controllers;

use App\Generic;
use App\Medbrand;
use App\Medicine;
use App\Employeesmedical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\MedicineRequest;
use File;

class MedicineController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            if ($request->has('search')) {
                $searchGen = Generic::where('gname', $request->search)->first();
                if ($searchGen != null) {
                    $meds = Medicine::select('brand_id', 'generic_id')->groupBy('brand_id', 'generic_id')->where('generic_id', $searchGen->id)->orderBy('id', 'desc')->paginate(10);
                    $meds->appends(['search' => $request->search]);
                }else{
                    $meds = null;
                }
                $search = $request->search;
            }else{
                $meds = Medicine::select('brand_id', 'generic_id')->groupBy('brand_id', 'generic_id')->orderBy('id', 'desc')->paginate(10);
            }
            $gens = Generic::orderBy('gname', 'asc')->get();

             if(count($meds)>0){
                 $this->PrintMedCSV($meds,'index','',''); 
             }

            return view('inventory.medicine.index', compact('meds', 'gens', 'search'));
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{

           return back();

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MedicineRequest $request)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $atts = $this->validate($request, $request->rules(), $request->messages());
            $atts = $request->except('qty_input');
            $multiplier = $request->input('qty_input');
            $atts['qty_stock'] = $request->input('qty_input');

            $meds = Medicine::where('brand_id', $request->brand_id)->where('generic_id', $request->generic_id)->get();

            if (count($meds) > 0) {

                // foreach ($meds as $med) {
                //     dd($med->qty_stock + $request->qty_input);
                //     $med->qty_stock = $med->qty_stock + $request->qty_input;
                //     $med->save();
                // }

                 $arr = array();
                for ($i=1; $i <= $multiplier; $i++) { 
                    $arr[] = $request;
                }

                foreach ($arr as $data) {
                    $newMeds = new Medicine;
                    $newMeds->qty_stock       = $request->qty_input;
                    $newMeds->expiration_date = $data->expiration_date;
                    $newMeds->generic_id      = $data->generic_id;
                    $newMeds->brand_id        = $data->brand_id;
                    $newMeds->availability    = 0;
                    $newMeds->user_id         = auth()->user()->id;
                    $newMeds->save();
                }

            }else{

                $arr = array();
                for ($i=1; $i <= $multiplier; $i++) { 
                    $arr[] = $request;
                }

                foreach ($arr as $data) {
                    $newMeds = new Medicine;
                    $newMeds->qty_stock       = $data->qty_input;
                    $newMeds->expiration_date = $data->expiration_date;
                    $newMeds->generic_id      = $data->generic_id;
                    $newMeds->brand_id        = $data->brand_id;
                    $newMeds->availability    = 0;
                    $newMeds->user_id         = auth()->user()->id;
                    $newMeds->save();
                }

            }

            return back();

        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{

           return back();

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Medbrand $medbrand, Generic $generic, $inputDate, $expDate)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $meds = Medicine::join('employeesmedical_medicine_users', 'medicines.id', 'employeesmedical_medicine_users.medicine_id')
                            ->join('users as users1', 'users1.id', 'employeesmedical_medicine_users.user_id')
                            ->join('employeesmedicals', 'employeesmedicals.id', 'employeesmedical_medicine_users.employeesmedical_id')
                            ->join('employees', 'employees.id', 'employeesmedicals.employee_id')
                            ->join('employees as attendant', 'users1.id', 'attendant.user_id')
                            ->select('employeesmedicals.id as empMeds_id', 'employeesmedicals.employee_id as patient', 'employees.first_name', 'employees.last_name', 'employeesmedical_medicine_users.quantity', 'availability', 'employeesmedical_medicine_users.user_id as distinct_user_id', 'users1.name as givenBy', 'attendant.first_name as givenFname', 'attendant.last_name as givenLname', 'employeesmedical_medicine_users.created_at as Distinct_date', \DB::raw('COUNT(employeesmedical_medicine_users.created_at) as distCount'))
                            ->groupBy('employeesmedicals.id', 'employeesmedicals.employee_id', 'employees.first_name', 'employees.last_name', 'employeesmedical_medicine_users.quantity', 'availability', 'employeesmedical_medicine_users.user_id', 'users1.name', 'attendant.first_name', 'attendant.last_name', 'employeesmedical_medicine_users.created_at')
                            ->distinct('Distinct_date', 'distinct_user_id')
                            ->where('brand_id', $medbrand->id)
                            ->where('generic_id', $generic->id)
                            ->where('medicines.created_at', $inputDate)
                            ->where('expiration_date', $expDate)
                            ->where('availability', 1);
                            // ->orderBy('medicines.id', 'asc')->paginate(10);
            $countMeds = Employeesmedical::join('employeesmedical_medicine_users', 'employeesmedicals.id', 'employeesmedical_medicine_users.employeesmedical_id')
                                         ->join('medicines', 'medicines.id', 'employeesmedical_medicine_users.medicine_id')
                                         ->join('users as users1', 'users1.id', 'employeesmedical_medicine_users.user_id')
                                         ->join('employees as attendant', 'users1.id', 'attendant.user_id')
                                         ->select('employeesmedicals.id as empMeds_id', 'employeesmedicals.employee_id as patient', 'employeesmedical_medicine_users.quantity', 'availability', 'employeesmedical_medicine_users.user_id as distinct_user_id', 'users1.name as givenBy', 'attendant.first_name as givenFname', 'attendant.last_name as givenLname', 'employeesmedical_medicine_users.created_at as Distinct_date')
                                         ->where('brand_id', $medbrand->id)
                                         ->where('generic_id', $generic->id)
                                         ->where('medicines.created_at', $inputDate)
                                         ->where('expiration_date', $expDate)
                                         ->where('availability', 1)
                                         ->get();

            if ($request->search_name && $request->search_date == null) {
                $search_name = $request->search_name;
                $meds = $meds->where(\DB::raw("concat(employees.last_name, ' ', employees.first_name)"), "LIKE", '%'.$request->search_name.'%')
                             ->orderBy('medicines.id', 'desc')->paginate(10);
            }
            elseif ($request->search_name == null && $request->search_date) {
                $search_date = $request->search_date;
                $meds = $meds->where('employeesmedical_medicine_users.created_at', $request->search_date)
                             ->orderBy('medicines.id', 'desc')->paginate(10);
            }
            elseif ($request->search_name && $request->search_date) {
                $search_name = $request->search_name;
                $search_date = $request->search_date;
                $meds = $meds->where(\DB::raw("concat(employees.last_name, ' ', employees.first_name)"), "LIKE", '%'.$request->search_name.'%')
                             ->where('employeesmedical_medicine_users.created_at', $request->search_date)
                             ->orderBy('medicines.id', 'desc')->paginate(10);
            }else{
                $meds = $meds->orderBy('medicines.id', 'desc')->paginate(10);
                // return $countMeds;
            }

        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{

           return back();

        }

        $medlogs = ['meds'=> $meds->getCollection(), 'countMeds' => $countMeds];

        $this->PrintMedCSV($medlogs,'logsinput',$medbrand->bname, $generic->gname); 

        return view('inventory.medicine.medicine_history', compact('medbrand', 'generic', 'empsMeds', 'arr', 'meds', 'inputDate', 'expDate', 'search_name', 'search_date', 'countMeds'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function edit(Medicine $medicine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Medicine $medicine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medicine $medicine)
    {
        //
    }

    public function getBrand($id)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $gen = Generic::find($id);
            $brand_id = $gen->medbrand->pluck('bname', 'id');
            return json_encode($brand_id);
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{

           return back();

        }
    }

    public function logs(Request $request, Medbrand $medbrand, Generic $generic)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $log1 = Medicine::where('brand_id', $medbrand->id)->where('generic_id', $generic->id)->orderBy('created_at', 'desc')->get();
            // dd($log1);
            $logs = Medicine::join('generics', 'generics.id', '=', 'medicines.generic_id')
                            ->join('medbrands', 'medbrands.id', '=', 'medicines.brand_id')
                            ->join('users', 'users.id', '=', 'medicines.user_id')
                            ->select('bname', 'gname', 'expiration_date', 'user_id', \DB::raw('DATE_FORMAT(medicines.created_at, "%Y-%m-%d") as formatted_at'), 'medicines.created_at as orig', 'generic_id', 'brand_id', \DB::raw('COUNT(expiration_date) as expCount'))
                            ->groupBy('bname', 'gname', 'expiration_date', 'user_id', 'medicines.created_at', 'generic_id', 'brand_id')
                            ->distinct('expiration_date', 'medicines.created_at')
                            ->where('brand_id', $medbrand->id)
                            ->where('generic_id', $generic->id);
            $loglist = $logs->orderBy('medicines.created_at', 'desc')->get();
            if ($request->has('expired') && $request->has('search')) {
                $search = $request->search;
                $logsearch = $logs->where('medicines.expiration_date', '<=', NOW())->orderBy('medicines.created_at', 'desc')->get();
            }
            if ($request->has('search') && $request->has('expired') == null) {
                $search = $request->search;
                $logs = $logs->where(\DB::raw('DATE_FORMAT(medicines.created_at, "%Y-%m-%d")'), $request->search)
                             ->orderBy('medicines.created_at', 'desc')->paginate(10);
                             $logs->appends(['search' => $request->search]);
            }
            elseif ($request->has('expired') && $request->has('search') == null) {
                $logs = $logs->where('medicines.expiration_date', '<=', NOW())
                             ->orderBy('medicines.created_at', 'desc')->paginate(10);
                             $logs->appends(['expired' => $request->expired]);
            }
            elseif ($request->has('expired') && $request->has('search')) {
                $logs = $logs->where(\DB::raw('DATE_FORMAT(medicines.created_at, "%Y-%m-%d")'), $request->search)
                             ->where('medicines.expiration_date', '<=', NOW())
                             ->orderBy('medicines.created_at', 'desc')->paginate(10);
                             $logs->appends(['search' => $request->search]);
            }else{
                $logs = $logs->orderBy('medicines.created_at', 'desc')->paginate(10);
                $logs->appends(['search' => $request->search]);
                }
                 //dd($logs);
             $this->PrintMedCSV($logs->getCollection(),'logs',$medbrand->bname, $generic->gname); 
           
            return view('inventory.medicine.logs', compact('logs', 'medbrand', 'generic', 'log1', 'search', 'loglist', 'logsearch'));
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
           return back();

        }
    }

    public function PrintMedCSV($meds,$typecsv,$medbrand,$generic){

        $relPath = 'storage/uploaded/print';
        if (!file_exists($relPath)) {
            mkdir($relPath, 777, true);
        }

        $medicine = $meds;    
        $dataemp = view('inventory.medicine.csv',compact('medicine','typecsv','medbrand','generic'))->render();

        $fileName = "inventory_medicine";

        File::put(public_path('/storage/uploaded/print/'.$fileName.'.csv'),$dataemp);   


    }
}
