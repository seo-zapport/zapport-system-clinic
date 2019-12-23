<?php

namespace App\Http\Controllers;

use File;
use App\Generic;
use App\Medbrand;
use App\Medicine;
use App\Employeesmedical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\EmployeesmedicalMedicineUser;
use App\Http\Requests\MedicineRequest;

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
                    $rawmeds = Medicine::select('brand_id', 'generic_id')->groupBy('brand_id', 'generic_id')->where('generic_id', $searchGen->id)->orderBy('id', 'desc');
                    $printmeds = $rawmeds->get();
                    $meds = $rawmeds->paginate(10)->appends(['search' => $request->search]);

                }else{
                    $meds = null;
                    $printmeds = null;
                }
                $search = $request->search;
            }else{
                $rawmeds = Medicine::select('brand_id', 'generic_id')->groupBy('brand_id', 'generic_id')->orderBy('id', 'desc');
                $countsmed = $rawmeds->count();
                $printmeds = $rawmeds->get();
                $meds = $rawmeds->paginate(10);
            }

            $gens = Generic::orderBy('gname', 'asc')->get();
              
            //dd($printmeds);
            // if(count(@$printmeds)>0){
                 $this->PrintMedCSV($printmeds,'index','','');
           //  } 

            if ($printmeds != null) {
                $countMeds = Medicine::select('brand_id', 'generic_id')->groupBy('brand_id', 'generic_id')->orderBy('id', 'desc')->get();
                $total_meds = $countMeds->count();
            }else{
                $countMeds = Medicine::select('brand_id', 'generic_id')->groupBy('brand_id', 'generic_id')->orderBy('id', 'desc')->get();
                $total_meds = $countMeds->count();
            }

            $class = ( request()->is('inventory/medicine*') ) ?'admin-inventory admin-medicine' : '';//**add Class in the body*/

            return view('inventory.medicine.index', compact('class', 'meds', 'gens', 'search', 'total_meds'));
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
            $rawmeds = Medicine::join('employeesmedical_medicine_users', 'medicines.id', 'employeesmedical_medicine_users.medicine_id')
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

            $dates = EmployeesmedicalMedicineUser::join('medicines', 'employeesmedical_medicine_users.medicine_id', 'medicines.id')
                                                 ->select(\DB::raw('DATE(employeesmedical_medicine_users.created_at) as medical_date'), 'medicines.brand_id', 'medicines.generic_id')
                                                 ->where('brand_id', $medbrand->id)
                                                 ->where('generic_id', $generic->id)
                                                 ->distinct('medical_date')
                                                 ->get();

            if ($request->search_name && $request->search_date == null) {
                $search_name = $request->search_name;
                $fmeds = $rawmeds->where(\DB::raw("concat(employees.last_name, ' ', employees.first_name)"), "LIKE", '%'.$request->search_name.'%')
                             ->orderBy('medicines.id', 'desc');
                    $printmeds = $fmeds->get();
                    $meds = $fmeds->paginate(10);

            }elseif ($request->search_name == null && $request->search_date) {
                $search_date = $request->search_date;
                $fmeds = $rawmeds->where(\DB::raw('DATE(employeesmedical_medicine_users.created_at)'), $request->search_date)
                             ->orderBy('medicines.id', 'desc');
                      $printmeds = $fmeds->get();
                      $meds = $fmeds->paginate(10);
            }elseif ($request->search_name && $request->search_date) {
                $search_name = $request->search_name;
                $search_date = $request->search_date;
                $fmeds = $rawmeds->where(\DB::raw("concat(employees.last_name, ' ', employees.first_name)"), "LIKE", '%'.$request->search_name.'%')
                             ->where(\DB::raw('DATE(employeesmedical_medicine_users.created_at)'), $request->search_date)
                             ->orderBy('medicines.id', 'desc');
                    $printmeds = $fmeds->get();
                    $meds = $fmeds->paginate(10);
                        
            }else {
                    $fmeds = $rawmeds->orderBy('medicines.id', 'desc');
                    $printmeds = $fmeds->get();
                    $meds = $fmeds->paginate(10);
            }

        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{

           return back();

        }

        $medlogs = ['meds'=> $printmeds, 'countMeds' => $countMeds];

        $this->PrintMedCSV($medlogs,'logsinput',$medbrand->bname, $generic->gname); 

        $class = ( request()->is('inventory/medicine*') ) ?'admin-inventory admin-medicine' : '';//**add Class in the body*/

        return view('inventory.medicine.medicine_history', compact('class', 'medbrand', 'generic', 'empsMeds', 'arr', 'meds', 'inputDate', 'expDate', 'search_name', 'search_date', 'countMeds', 'dates'));
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
            $rawlogs = Medicine::join('generics', 'generics.id', '=', 'medicines.generic_id')
                            ->join('medbrands', 'medbrands.id', '=', 'medicines.brand_id')
                            ->join('users', 'users.id', '=', 'medicines.user_id')
                            ->select('bname', 'bname_slug', 'gname', 'gname_slug', 'expiration_date', 'user_id', \DB::raw('DATE_FORMAT(medicines.created_at, "%Y-%m-%d") as formatted_at'), 'medicines.created_at as orig', 'generic_id', 'brand_id', \DB::raw('COUNT(expiration_date) as expCount'))
                            ->groupBy('bname', 'bname_slug', 'gname', 'gname_slug', 'expiration_date', 'user_id', 'medicines.created_at', 'generic_id', 'brand_id')
                            ->distinct('expiration_date', 'medicines.created_at')
                            ->where('brand_id', $medbrand->id)
                            ->where('generic_id', $generic->id);
            $loglist = $rawlogs->orderBy('medicines.created_at', 'desc')->get();
            if ($request->has('expired') && $request->has('search')) {
                $search = $request->search;
                $logsearch = $rawlogs->where('medicines.expiration_date', '<=', NOW())->orderBy('medicines.created_at', 'desc')->get();
            }
            if ($request->has('search') && $request->has('expired') == null) {
                $search = $request->search;
                $logs = $rawlogs->where(\DB::raw('DATE_FORMAT(medicines.created_at, "%Y-%m-%d")'), $request->search)
                             ->orderBy('medicines.created_at', 'desc');
                          $printlogs = $logs->get();  
                          $logs = $logs->paginate(10)->appends(['search' => $request->search]);
            }
            elseif ($request->has('expired') && $request->has('search') == null) {
                $logs = $rawlogs->where('medicines.expiration_date', '<=', NOW())
                             ->orderBy('medicines.created_at', 'desc');
                            $printlogs = $logs->get();
                            $logs = $logs->paginate(10)->appends(['expired' => $request->expired]);
            }
            elseif ($request->has('expired') && $request->has('search')) {
                $logs = $rawlogs->where(\DB::raw('DATE_FORMAT(medicines.created_at, "%Y-%m-%d")'), $request->search)
                             ->where('medicines.expiration_date', '<=', NOW())
                             ->orderBy('medicines.created_at', 'desc');
                        $printlogs = $logs->get();     
                        $logs = $logs->paginate(10)->appends(['search' => $request->search]);
            }else{
                $logs = $rawlogs->orderBy('medicines.created_at', 'desc');
                        $printlogs = $logs->get();
                        $logs = $logs->paginate(10)->appends(['search' => $request->search]);
                
            }

            $this->PrintMedCSV($printlogs,'viewlogs',$medbrand->bname, $generic->gname); 
    
            $class = ( request()->is('inventory/medicine*') ) ?'admin-inventory admin-medicine' : '';//**add Class in the body*/

            // dd($logs);

            return view('inventory.medicine.logs', compact('class','logs', 'medbrand', 'generic', 'log1', 'search', 'loglist', 'logsearch'));
        
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
           return back();
        }
    }

    public function PrintMedCSV($meds,$typeprint,$medbrand,$generic){

        $relPath = 'storage/uploaded/print/inventory';
        if (!file_exists($relPath)) {
            mkdir($relPath, 777, true);
        }

        $expired = array();
        $availmeds = array();

        $explog = $meds;
        $medicine = $meds;
        $typecsv = $typeprint;
        $fileName = "inventory_medicine";
        
        if ($meds != null) {
            if($typeprint == 'logsinput'){
                $countmed = $meds['meds']->count();
            }else{
                $countmed = $meds->count();
            }
        }

        if($typeprint == 'viewlogs'){
            foreach ($explog as $medlog) {
                if($medlog->expiration_date <= NOW()){
                        $expired[] = $medlog;
                }
                if($medlog->expiration_date >= NOW()){
                        $availmeds[] = $medlog;
                }  
            }

            $datamedsexpired = view('inventory.medicine.expiredcsv',compact('expired','typecsv','medbrand','generic'))->render();
            $datamedslog = view('inventory.medicine.logcsv',compact('availmeds','typeprint','medbrand','generic','countmed'))->render();

            File::put(public_path('/storage/uploaded/print/inventory/'.$fileName.'_expired.csv'),$datamedsexpired);   
            File::put(public_path('/storage/uploaded/print/inventory/'.$fileName.'_log.csv'),$datamedslog);   

            $datamedsprintexp = view('inventory.medicine.printmedsexp',compact('expired','typeprint','medbrand','generic','countmed'))->render();
            $datamedsprintlog = view('inventory.medicine.printmedslog',compact('availmeds','typeprint','medbrand','generic','countmed'))->render();

            File::put(public_path('/storage/uploaded/print/inventory/'.$fileName.'_printexp.html'),$datamedsprintexp);
            File::put(public_path('/storage/uploaded/print/inventory/'.$fileName.'_printlog.html'),$datamedsprintlog);
            
        }

        $datameds = view('inventory.medicine.csv',compact('medicine','typecsv','medbrand','generic'))->render();
        $datamedsprint = view('inventory.medicine.printmeds',compact('meds','typeprint','medbrand','generic','countmed'))->render();

        File::put(public_path('/storage/uploaded/print/inventory/'.$fileName.'.csv'),$datameds);   
        File::put(public_path('/storage/uploaded/print/inventory/'.$fileName.'.html'),$datamedsprint);   
    }

    public function inventoryMonitoring()
    {
        $meds = Medicine::select('brand_id', 'generic_id', 'expiration_date', 'created_at', 'qty_stock', 'user_id')
                        ->groupBy('brand_id', 'generic_id', 'expiration_date', 'created_at', 'qty_stock', 'user_id')
                        ->distinct('expiration_date')
                        ->orderBy('updated_at', 'desc')
                        ->paginate(10);
        return view('admin.inventory.index', compact('meds'));
    }
}
