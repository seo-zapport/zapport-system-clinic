<?php

namespace App\Http\Controllers;

use App\Generic;
use App\Medbrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GenericController extends Controller
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
        if (Gate::allows('isAdmin') || Gate::allows('isHr') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $gens = Generic::orderBy('gname', 'asc')->paginate(10);
            $brands = Medbrand::get();
            return view('inventory.genericname.index', compact('gens', 'brands'));
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
            $atts = $this->genericValidation();
            Generic::create($atts);
            // $atts = $request->except('medbrand_id');
            // $data = Generic::create($atts);
            // $lastID = $data->id;
            // $genID['generic_id'] = $lastID;
            // $bndID = $request->input('medbrand_id');
            // $bnd = Medbrand::find($bndID);
            // $bnd->generic()->attach($genID);
            return back();
        }else{
            return back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Generic  $generic
     * @return \Illuminate\Http\Response
     */
    public function show(Generic $generic)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $unique = $generic->medicines->unique(function($item){
                return $item['generic_id'].$item['brand_id'].$item['created_at']->format('M d, Y H:i');
            });

            $allBrands = $unique->values()->all();

            return view('inventory.genericname.show', compact('generic', 'allBrands'));
        }else{
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Generic  $generic
     * @return \Illuminate\Http\Response
     */
    public function edit(Generic $generic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Generic  $generic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Generic $generic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Generic  $generic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Generic $generic)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            if (count($generic->medbrand) > 0) {
                return back()->with('generic_message', 'You cannot delete a Generic name registered with Brand');
            }
            $generic->delete();
            return back();
        }else{
            return back();
        }
    }

    public function genericValidation()
    {
        return request()->validate([
            'gname'            =>  ['required', 'unique:generics'],
        ]);
    }
}
