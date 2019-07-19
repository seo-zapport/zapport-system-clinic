<?php

namespace App\Http\Controllers;

use App\Generic;
use App\Medbrand;
use App\MedbrandGeneric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MedbrandController extends Controller
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
        if (Gate::allows('isAdmin') || Gate::allows('isHr') || Gate::allows('isDoctor')) {
            $gens = Generic::get();
            $brands = Medbrand::orderBy('bname', 'asc')->paginate(10);
            return view('inventory.brandname.index', compact('brands', 'gens'));
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
            $this->brandNameValidation();
            $atts = $request->except('generic_id');

            $check = Medbrand::where('bname', $request->bname)->first();
            if (!empty($check)) {
                $data = $check;
            }else{
                $data = Medbrand::create($atts);
            }

            $check2 = MedbrandGeneric::where('medbrand_id', $data->id)->where('generic_id', $request->generic_id)->first();
            if (!empty($check2)) {
                return back()->with('pivot_validation', 'Brand Name and Generic Name already exists!');
            }
            $lastID = $data->id;
            $brndID['medbrand_id'] = $lastID;
            $genID = $request->input('generic_id');
            $gen = Generic::find($genID);
            $gen->medbrand()->attach($brndID);
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
        if (Gate::allows('isAdmin') || Gate::allows('isHr') || Gate::allows('isDoctor')) {
            return view('inventory.brandname.show', compact('medbrand'));
        }else{
            abort(403, 'You are not Authorized on this page!');
        }
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
        if (Gate::allows('isAdmin') || Gate::allows('isHr') || Gate::allows('isDoctor')) {
            $atts = $request->validate([
                    'bname' => ['required', 'unique:medbrands,bname,'.$medbrand->id],
                ]);
            $medbrand->update($atts);
            return back();
        }else{
            abort(403, 'You are not Authorized on this page!');
        }
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
            if (count($medbrand->medicines) > 0) {
                return back()->with('brand_message', 'You cannot delete a brand with record in inventory');
            }
            $medbrand->delete();
            return back();
        }else{
            abort(403, 'You are not Authorized on this page!');
        }
    }

    public function brandNameValidation()
    {
        return request()->validate([
            'bname'         =>  ['required'],
            'generic_id'    =>  ['required']
        ]);
    }
}
