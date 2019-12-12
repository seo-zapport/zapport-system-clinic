<?php

namespace App\Http\Controllers;

use App\Diagnosis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DiagnosisController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Diagnosis  $diagnosis
     * @return \Illuminate\Http\Response
     */
    public function show(Diagnosis $diagnosis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Diagnosis  $diagnosis
     * @return \Illuminate\Http\Response
     */
    public function edit(Diagnosis $diagnosis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Diagnosis  $diagnosis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Diagnosis $diagnosis)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            $atts = $request->validate([
                'disease_id'    =>  'required',
                'diagnosis'       =>  'required|unique:diagnoses,diagnosis,'.$diagnosis->id
            ]);
            $diagnosis->update($atts);
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
     * @param  \App\Diagnosis  $diagnosis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Diagnosis $diagnosis)
    {
        //
    }

    public function fetchDiagnosis(Request $request, $diagnosis)
    {
        if ($request->ajax()) {
            $data = Diagnosis::where('diagnosis', 'like', '%'.$request->diagnosis.'%')->take(6)->get();
            $output = '';
            if (count($data) > 0) {
                $output = '<ul id="diag" class="list-group" style="display: block; position: relative; z-index: 100">';
                foreach ($data as $row) {
                    $output .= '<li class="list-group-item list-group-item-action" style="cursor:pointer">'.$row->diagnosis.'</li>';
                }
                $output .= '</ul>';
            }
            return $output;
        }
    }
}
