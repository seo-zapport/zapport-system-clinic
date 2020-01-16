<?php

namespace App\Http\Controllers;

use App\Supgen;
use App\Supbrand;
use App\SupbrandSupgen;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\SupbrandRequest;

class SupbrandController extends Controller
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
        if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse')) {
            $atts = $this->validate($request, $request->rules(), $request->messages());
            $atts = $request->except('supgen_id');
            $find = Supbrand::where('name', $request->name)->first();
            if ($find) {
                    $brand = $find;
            }else{
                $atts['slug'] = Str::slug($request->name, '-');
                $brand = Supbrand::create($atts);
            }
            $check = SupbrandSupgen::where('supbrand_id', $brand->id)->where('supgen_id', $request->supgen_id)->first();
            if (!$check) {
                $brand->supgens()->attach($request->supgen_id);
            }else{
                return back()->with('duplicate', 'Brand already registered!');
            }
            return back();
        }elseif (Gate::check('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
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
    public function update(Request $request, Supgen $supgen, Supbrand $supbrand)
    {
        if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse')) {
            $atts = $request->validate(
                [
                    'name' => ['required', 'unique:supbrands,name,'.$supbrand->id],
                ],
                [
                    'name.required' => 'This field is required!',
                    'name.unique'   => 'Name Already Taken!',
                ]
            );
            $atts['slug'] = Str::slug($request->name, '-');
            $supbrand->update($atts);
            return back();
        }elseif (Gate::check('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supbrand  $supbrand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supgen $supgen, Supbrand $supbrand)
    {
        if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse')) {
            $count = $supbrand->supplies->where('supgen_id', $supgen->id)->count();
            $count2 = $supbrand->supgens->count();
            if ($count < 1 && $count2 <= 1) {
                $supbrand->delete();
                return back();
            }
            return back()->with('delete_error', 'You cannot delete a brand with more than one Supply name and quantity more than one!');
        }elseif (Gate::check('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }

    /**
     * Fetch by AJAX the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            $search = Supbrand::where('name', 'like', '%'.$request->name.'%')->orderBy('created_at')->get();
            $output = '';
            $output .= '<ul class="list-group m-0" style="display: block; position: absolute; z-index: 100; width:94%">';
            if (count($search) > 0) {
                foreach ($search as $result) {
                    $output .= '<li class="list-group-item list-group-item-action">'.$result->name.'</li>';
                }
            }
            $output .= '</ul>';
            return response($output);
        }
    }
}