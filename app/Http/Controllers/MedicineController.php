<?php

namespace App\Http\Controllers;

use App\Medicine;
use App\Medbrand;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meds = Medicine::orderBy('generic_name', 'asc')->get();
        $brands = Medbrand::orderBy('bname', 'asc')->get();
        return view('inventory.medicine.index', compact('meds', 'brands'));
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
        // dd($multiplier);
        $arr = array();
        for ($i=1; $i <= $multiplier; $i++) { 
            $arr[] = $atts;
        }

        foreach ($arr as $data) {
            auth()->user()->addMeds(
                new Medicine($data)
            );
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

    public function medicineValidation()
    {
        return request()->validate([
            'brand_id'          =>  ['required'],
            'generic_name'      =>  ['required'],
            'expiration_date'   =>  ['required'],
            'qty_input'         =>  ['required']
        ]);
    }
}
