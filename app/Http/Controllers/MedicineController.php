<?php

namespace App\Http\Controllers;

use App\Medicine;
use App\Medbrand;
use App\Generic;
use Illuminate\Http\Request;

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
    public function index()
    {
        $meds = Medicine::select('brand_id', 'generic_id', 'qty_stock')->groupBy('brand_id', 'generic_id', 'qty_stock')->orderBy('id', 'desc')->paginate(10);
        $gens = Generic::orderBy('gname', 'asc')->get();
        return view('inventory.medicine.index', compact('meds', 'gens'));
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
        $atts = $this->medicineValidation();
        $atts = $request->except('qty_input');
        $multiplier = $request->input('qty_input');
        $atts['qty_stock'] = $request->input('qty_input');

        $meds = Medicine::where('brand_id', $request->brand_id)->where('generic_id', $request->generic_id)->get();

        if (count($meds) > 0) {

            // $logsArr = array();
            foreach ($meds as $med) {
                $med->qty_stock = $med->qty_stock + $request->qty_input;
                $med->save();
                // $logsArr[] = $med->qty_stock + $request->qty_input;
            }

             $arr = array();
            for ($i=1; $i <= $multiplier; $i++) { 
                $arr[] = $request;
            }

            foreach ($arr as $data) {
                $newMeds = new Medicine;
                $newMeds->qty_stock       = count($meds) + $request->qty_input;
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Medicine  $medicine
     * @return \Illuminate\Http\Response
     */
    public function show(Medicine $medicine)
    {
        //
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
        $gen = Generic::find($id);
        $brand_id = $gen->medbrand->pluck('bname', 'id');
        return json_encode($brand_id);
    }

    public function logs(Medbrand $medbrand, Generic $generic)
    {
        $logs = Medicine::where('brand_id', $medbrand->id)->where('generic_id', $generic->id)->get();
        // dd($logs);
        return view('inventory.medicine.logs', compact('logs', 'medbrand', 'generic'));
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
