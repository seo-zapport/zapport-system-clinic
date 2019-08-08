<?php

namespace App\Http\Controllers;

use App\Employeesmedical;
use App\Generic;
use App\Medbrand;
use App\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
            return view('inventory.medicine.index', compact('meds', 'gens', 'search'));
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
    public function store(Request $request)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $atts = $this->medicineValidation();
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
    public function show(Medbrand $medbrand, Generic $generic, $inputDate, $expDate)
    {
        $meds = Medicine::where('brand_id', $medbrand->id)
                               ->where('generic_id', $generic->id)
                               ->where('created_at', $inputDate)
                               ->where('expiration_date', $expDate)
                               ->where('availability', 1)
                               ->orderBy('id', 'asc')->get();

        $empsMeds = null;
        $medsHistory = Medicine::with(['employeesMedical' => function($q) use (&$empsMeds){
            $empsMeds = $q->get();
        }])->where('brand_id', $medbrand->id)
           ->where('generic_id', $generic->id)
           ->where('created_at', $inputDate)
           ->where('expiration_date', $expDate)
           ->where('availability', 1)
           ->orderBy('id', 'asc')->get();

        if ($empsMeds != null) {
            $empsMeds = $empsMeds->unique(function($item){
                return $item['employeesmedical_id'].$item->pivot['created_at'];
            });
        }

        $arr = [];
        foreach ($meds as $logs) {
            $arr[] = $logs->load('employeesMedical', 'users');
            // foreach ($logs->load('employeesMedical') as $item) {
            //     $arr[] = $item;
            // }
        }
        $arr2 = [];
        $temp_id  = 0;
        foreach ($arr as $item) {
            foreach ($item->users as $ids) {
                
                if($temp_id != $ids->id){
                    $arr2[] = $item;
                }
                    $temp_id = $ids->id;
            }
        }


        return view('inventory.medicine.medicine_history', compact('medbrand', 'generic', 'empsMeds', 'arr'));
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
        }else{

           return back();

        }
    }

    public function logs(Medbrand $medbrand, Generic $generic)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $logs = Medicine::where('brand_id', $medbrand->id)->where('generic_id', $generic->id)->orderBy('id', 'asc')->get();
            // dd($logs);
            return view('inventory.medicine.logs', compact('logs', 'medbrand', 'generic'));
        }else{

           return back();

        }
    }

    public function medicineValidation()
    {
        return request()->validate([
            'brand_id'          =>  ['required'],
            'generic_id'        =>  ['required'],
            'expiration_date'   =>  ['required'],
            'qty_input'         =>  ['required']
        ]);
    }
}
