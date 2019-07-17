<?php

namespace App\Http\Controllers;

use App\Medbrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MedbrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr') || Gate::allows('isDoctor')) {
            $brands = Medbrand::orderBy('bname', 'asc')->get();
            return view('inventory.brandname.index', compact('brands'));
        }else{
            abort(403, 'You are not Authorized on this page!');
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
        if (Gate::allows('isAdmin') || Gate::allows('isHr') || Gate::allows('isDoctor')) {
            $atts = $this->brandNameValidation();
            Medbrand::create($atts);
            return back();
        }else{
            abort(403, 'You are not Authorized on this page!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Medbrand  $medbrand
     * @return \Illuminate\Http\Response
     */
    public function show(Medbrand $medbrand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Medbrand  $medbrand
     * @return \Illuminate\Http\Response
     */
    public function edit(Medbrand $medbrand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Medbrand  $medbrand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Medbrand $medbrand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Medbrand  $medbrand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medbrand $medbrand)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr') || Gate::allows('isDoctor')) {
            $medbrand->delete();
            return back();
        }else{
            abort(403, 'You are not Authorized on this page!');
        }
    }

    public function brandNameValidation()
    {
        return request()->validate([
            'bname' =>  ['required', 'unique:medbrands']
        ]);
    }
}
