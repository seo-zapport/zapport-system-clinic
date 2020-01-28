<?php

namespace App\Http\Controllers;

use App\Disease;
use App\Bodypart;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\DiseaseRequest;

class DiseaseController extends Controller
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
    public function store(DiseaseRequest $request)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            
            $atts = $this->validate($request, $request->rules(), $request->messages());
            $replaced = Str::slug($request->disease, '-');
            $newDisease                 = new Disease;
            $newDisease->bodypart_id    = $request->bodypart_id;
            $newDisease->disease_slug   = $replaced;
            $newDisease->disease        = $request->disease;
            $newDisease->save();

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
     * @param  \App\Disease  $disease
     * @return \Illuminate\Http\Response
     */
    public function show(Disease $disease)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse') || Gate::allows('isHr')) {
            return view('medical.employeesMedical.diagnoses.disease_show', compact('disease'));
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
     * @param  \App\Disease  $disease
     * @return \Illuminate\Http\Response
     */
    public function edit(Disease $disease)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Disease  $disease
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Disease $disease)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $atts = $request->validate([
                'bodypart_id'   =>  'required',
                'disease'   =>  'required|unique:diseases,disease,'.$disease->id,
            ]);
            $atts['disease_slug'] = Str::slug($request->disease, '-');
            $disease->update($atts);
            return back();
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
     * @param  \App\Disease  $disease
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disease $disease)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            if (count($disease->diagnoses) > 0) {
                return back()->with('disease_error', 'You cannot delete a Disease with Diagnosis');
            }else{
                $disease->delete();
                return back();
            }
        }elseif (Gate::allows('isBanned')) {

            Auth::logout();
            return back()->with('message', 'You\'re not employee!');

        }else{

            return back();
        }
    }
}
