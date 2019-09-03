<?php

namespace App\Http\Controllers;

use App\Generic;
use App\Medbrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\genericRequest;

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
    public function store(genericRequest $request)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $atts = $this->validate($request, $request->rules(), $request->messages());
            Generic::create($atts);
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
     * @param  \App\Generic  $generic
     * @return \Illuminate\Http\Response
     */
    public function show(Generic $generic)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $unique = $generic->medicines->unique(function($item){
                return $item['generic_id'].$item['brand_id'];
            });

            $allBrands = $unique->values()->all();
            // dd($allBrands);

            return view('inventory.genericname.show', compact('generic', 'allBrands'));
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
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
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }
}