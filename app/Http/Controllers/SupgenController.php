<?php

namespace App\Http\Controllers;

use App\Supgen;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\SupgenRequest;

class SupgenController extends Controller
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
        if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse') || Gate::check('isHr')) {
            $supgens = Supgen::orderBy('id', 'desc')->paginate(10);
            return view('inventory.supply.supply_generic.index', compact('supgens'));
        }elseif (Gate::check('isBanned')) {
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
    public function store(SupgenRequest $request)
    {
        if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse')) {
            $atts = $this->validate($request, $request->rules(), $request->messages());
            $atts['slug'] = Str::slug($request->name, '-');
            Supgen::create($atts);
            return back();
        }elseif (Gate::check('isBanned')) {
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supgen  $supgen
     * @return \Illuminate\Http\Response
     */
    public function show(Supgen $supgen)
    {
        if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse') || Gate::check('isHr')) {
            return view('inventory.supply.supply_generic.show', compact('supgen'));
        }elseif(Gate::check('isBanned')){
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
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
        if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse')) {
            $atts = $request->validate(
                [
                    'name'  =>  ['required', 'unique:supgens,name,'.$supgen->id],
                ],
                [
                    'name.required' =>  'This field is required!',
                    'name.unique'   =>  'Name is already taken!',
                ]
            );
            $atts['slug'] = Str::slug($request->name, '-');
            $supgen->update($atts);
            return back();
        }elseif (Gate::check('isBanned')) {
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supgen  $supgen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supgen $supgen)
    {
        if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse')) {
            if ($supgen->supbrands->count() < 1) {
                $supgen->delete();
                return back();
            }
            return back()->with('supgen_error', 'You Cannot delete a Supply Name with more than 1 quantity!');
        }elseif (Gate::check('isBanned')) {
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }
}
