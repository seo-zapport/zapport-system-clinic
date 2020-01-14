<?php

namespace App\Http\Controllers;

use App\Generic;
use App\Http\Requests\genericRequest;
use App\Medbrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

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
    public function index(Request $request)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isHr') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            if ($request->search) {
                $rawgens = Generic::where('gname', 'like', '%'.$request->search.'%')->orderBy('gname', 'asc');
                $gens = $rawgens->paginate(10)->appends(['search' => $request->search]);
                $gensCount = Generic::where('gname', 'like', '%'.$request->search.'%')->orderBy('gname', 'asc')->get();
                $search = $request->search;
            }else{
                $gens = Generic::orderBy('gname', 'asc')->paginate(10);
                $gensCount = Generic::orderBy('gname', 'asc')->get();
            }

            $class = ( request()->is('inventory/medicine/generic*') ) ?'admin-inventory admin-med-generic' : '';//**add Class in the body*/

            return view('inventory.genericname.index', compact('class', 'gens', 'gensCount', 'search'));
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
            $replaced = Str::slug($request->gname, '-');
            $atts['gname_slug'] = strtolower($replaced);
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

            $class = ( request()->is('inventory/medicine/generic*') ) ?'admin-inventory admin-med-generic' : '';//**add Class in the body*/

            return view('inventory.genericname.show', compact('class','generic', 'allBrands'));
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
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $atts = $request->validate([
                    'gname' => ['required', 'unique:generics,gname,'.$generic->id],
                ],
                [
                    'gname.required'    =>  'The Generic name is required!',
                    'gname.unique'      =>  'The Generic name is already taken!',
                ]);
            $replaced = Str::slug($request->gname, '-');
            $atts['gname_slug'] = strtolower($replaced);
            $generic->update($atts);
            return redirect()->route('genericname.show', ['generic' => $generic->gname_slug]);
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

    public function genericSuggestions(Request $request, $generic)
    {
        if ($request->ajax()) {
            $data = Generic::where('gname', 'like', '%'.$generic.'%')->get();
            $output = '';
            if (count($data) > 0) {
                $output = '<ul class="list-group m-0" style="display: block; position: relative; z-index: 1; cursor: pointer">';
                foreach ($data as $row) {
                    $output .= '<li class="list-group-item list-group-item-action">'.$row->gname.'</li>';
                }
                $output .= '</ul>';
            }
            return $output;
        }
    }

}