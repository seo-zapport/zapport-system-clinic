<?php

namespace App\Http\Controllers;

use App\Supgen;
use App\Supply;
use Illuminate\Http\Request;
use App\Http\Requests\SupplyRequest;

class SupplyController extends Controller
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
        $supgens = Supgen::orderBy('name')->get();
        $supplies = Supply::select('supbrand_id', 'supgen_id')
                          ->groupBy('supbrand_id', 'supgen_id')
                          ->orderBy('id', 'desc')
                          ->paginate(10);
        return view('inventory.supply.supplies.index', compact('supgens', 'supplies'));
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
    public function store(SupplyRequest $request)
    {
        $atts = $this->validate($request, $request->rules(), $request->messages());
        $dtm = \Carbon\carbon::now();
        for ($i=1; $i <= $request->quantity; $i++) { 
            $newsupply                  = new Supply;
            $newsupply->user_id         = auth()->id();
            $newsupply->supbrand_id     = $request->supbrand_id;
            $newsupply->supgen_id       = $request->supgen_id;
            $newsupply->quantity        = $request->quantity;
            $newsupply->expiration_date = $request->expiration_date;
            $newsupply->availability    = 0;
            $newsupply->created_at      = $dtm;
            $newsupply->updated_at      = $dtm;
            $newsupply->save();
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function show(Supply $supply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function edit(Supply $supply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supply $supply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supply $supply)
    {
        //
    }

    /**
     * Ajax the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            $supGen = Supgen::find($request->supgen_id);
            $getSupBrand = $supGen->supbrands->pluck('name', 'id');
            return json_encode($getSupBrand);
        }
    }
}
