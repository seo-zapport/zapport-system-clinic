<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupbrandRequest;
use App\Supbrand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SupbrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(SupbrandRequest $request)
    {
        $atts = $this->validate($request, $request->rules(), $request->messages());
        $atts = $request->except('supgen_id');
        $atts['slug'] = Str::slug($request->name, '-');
        $brand = Supbrand::create($atts);
        $brand->supgens()->attach($request->supgen_id);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supbrand  $supbrand
     * @return \Illuminate\Http\Response
     */
    public function show(Supbrand $supbrand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supbrand  $supbrand
     * @return \Illuminate\Http\Response
     */
    public function edit(Supbrand $supbrand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supbrand  $supbrand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supbrand $supbrand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supbrand  $supbrand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supbrand $supbrand)
    {
        //
    }
}
