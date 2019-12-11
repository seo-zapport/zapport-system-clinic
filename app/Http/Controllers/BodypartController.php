<?php

namespace App\Http\Controllers;

use App\Bodypart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\BodypartRequest;

class BodypartController extends Controller
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
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {

            $bparts = Bodypart::paginate(10);
            return view('medical.employeesMedical.diagnoses.bodypart', compact('bparts'));
            
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
    public function store(BodypartRequest $request)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
        
            $atts = $this->validate($request, $request->rules(), $request->messages());
            $replaced = str_replace(' ', '-', $request->bodypart);
            $atts['bodypart_slug'] = strtolower($replaced);
            $id = Bodypart::create($atts);
            $atts['id'] = $id->id;
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
     * @param  \App\Bodypart  $bodypart
     * @return \Illuminate\Http\Response
     */
    public function show(Bodypart $bodypart)
    {
<<<<<<< HEAD
        dd('dsadasdasdas');
=======
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            return view('medical.employeesMedical.diagnoses.bodypart_show', compact('bodypart'));
        }elseif (Gate::allows('isBanned')) {

            Auth::logout();
            return back()->with('message', 'You\'re not employee!');

        }else{

            return back();
        }
>>>>>>> 317c7a1a80c2ad91262e1df3c531beb093284876
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bodypart  $bodypart
     * @return \Illuminate\Http\Response
     */
    public function edit(Bodypart $bodypart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bodypart  $bodypart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bodypart $bodypart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bodypart  $bodypart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bodypart $bodypart)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            if (count($bodypart->diseases) > 0) {
                return back()->with('bpart_error', 'You cannot delete a Body part with disease');
            }else{
                $bodypart->delete();
                return back();
            }
        }elseif (Gate::allows('isBanned')) {

            Auth::logout();
            return back()->with('message', 'You\'re not employee!');

        }else{

            return back();
        }
    }

    public function fetchBodyparts(Request $request, $bodypart)
    {
        if ($request->ajax()) {
            $data = Bodypart::where('bodypart', 'like', '%'.$request->bodypart.'%')->take(6)->get();
            $output = '';
            if (count($data) > 0) {
                $output = '<ul id="bpart" class="list-group" style="display: block; position: relative; z-index: 1">';
                foreach ($data as $row) {
                    $output .= '<li class="list-group-item list-group-item-action">'.$row->bodypart.'</li>';
                }
                $output .= '</ul>';
            }
            return $output;
        }
    }
}
