<?php

namespace App\Http\Controllers;

use App\Generic;
use App\Medbrand;
use App\MedbrandGeneric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\MedbrandRequest;

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
        if (Gate::allows('isAdmin') || Gate::allows('isHr') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $gens = Generic::get();
            $brands = Medbrand::orderBy('bname', 'asc')->paginate(10);
            $brandCount = Medbrand::orderBy('bname', 'asc')->get();

            $class = ( request()->is('inventory/medicine/brandname*') ) ?'admin-inventory admin-med-brand' : '';//**add Class in the body*/

            return view('inventory.brandname.index', compact('class', 'brands', 'gens', 'brandCount'));
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
    public function store(MedbrandRequest $request)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $this->validate($request, $request->rules(), $request->messages());
            $atts = $request->except('generic_id');

            $check = Medbrand::where('bname', $request->bname)->first();
            if (!empty($check)) {
                $data = $check;
            }else{
                $rep = str_replace([" & ", " / ", "-", " - "], '-', $request->bname);
                $rep2 = str_replace(['( ', ' )', "'", "(", ")", " ( ", " ) "], "", $rep);
                $replaced = str_replace([' ', '/'], '-', $rep2);
                $atts['bname_slug'] = strtolower($replaced);
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
     * @param  \App\Medbrand  $medbrand
     * @return \Illuminate\Http\Response
     */
    public function show(Medbrand $medbrand)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {

            $class = ( request()->is('inventory/medicine/brandname*') ) ?'admin-inventory admin-med-brand' : '';//**add Class in the body*/

            return view('inventory.brandname.show', compact('class','medbrand'));
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
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $atts = $request->validate([
                    'bname' => ['required', 'unique:medbrands,bname,'.$medbrand->id],
                ]);
            $rep = str_replace([" & ", " / ", "-", " - "], '-', $request->bname);
            $rep2 = str_replace(['( ', ' )', "'", "(", ")", " ( ", " ) "], "", $rep);
            $replaced = str_replace([' ', '/'], '-', $rep2);
            $atts['bname_slug'] = strtolower($replaced);
            $medbrand->update($atts);
            return redirect()->route('brandname.update', ['medbrand' => $medbrand->bname_slug]);
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
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
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            if (count($medbrand->medicines) > 0) {
                return back()->with('brand_message', 'You cannot delete a brand with record in inventory');
            }
            $medbrand->delete();
            return back();
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }
}
