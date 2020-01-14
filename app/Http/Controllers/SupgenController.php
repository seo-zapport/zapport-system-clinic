<?php

namespace App\Http\Controllers;

use App\Supgen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\SupgenRequest;

class SupgenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supgens = Supgen::orderBy('id', 'desc')->get();
        return view('inventory.supply.supply_generic.index', compact('supgens'));
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
    public function store(SupgenRequest $request)
    {
        $atts = $this->validate($request, $request->rules(), $request->messages());
        $atts['slug'] = Str::slug($request->name, '-');
        Supgen::create($atts);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supgen  $supgen
     * @return \Illuminate\Http\Response
     */
    public function show(Supgen $supgen)
    {
        return view('inventory.supply.supply_generic.show', compact('supgen'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supgen  $supgen
     * @return \Illuminate\Http\Response
     */
    public function edit(Supgen $supgen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supgen  $supgen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supgen $supgen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supgen  $supgen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supgen $supgen)
    {
        if ($supgen->supbrands->count() < 1) {
            $supgen->delete();
            return back();
        }
        return back();
    }
}
