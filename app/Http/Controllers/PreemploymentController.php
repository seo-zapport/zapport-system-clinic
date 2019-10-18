<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Preemployment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PreemploymentRequest;

class PreemploymentController extends Controller
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
    public function store(PreemploymentRequest $request, $employee)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            if ($request->ajax()) {
                $atts = $request->validated();
                $atts['employee_id'] = $employee;
                if ($request->hasFile('pre_employment_med')) {
                    $filepath = 'public/uploaded/pre-employment';
                    $orig_filename = pathinfo($request->pre_employment_med->getClientOriginalName(), PATHINFO_FILENAME).'-'.date("Y-m-d");
                    $fileExtension = $request->file('pre_employment_med')->getClientOriginalExtension();
                    $filename = $orig_filename.'.'.$fileExtension;
                    $request->file('pre_employment_med')->storeAs($filepath, $filename);
                }else{
                    $filename = NULL;
                }

                $newPreEmp = new Preemployment;
                $newPreEmp->pre_employment_med = $filename;
                $newPreEmp->employee_id = $employee;
                $newPreEmp->save();

                return response()->json(['success' => 'File uploaded!']);
            }elseif (Gate::allows('isBanned')) {
                Auth::logout();
                return back()->with('message', 'You\'re not employee!');
            }else{
                return back();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Preemployment  $preemployment
     * @return \Illuminate\Http\Response
     */
    public function show(Preemployment $preemployment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Preemployment  $preemployment
     * @return \Illuminate\Http\Response
     */
    public function edit(Preemployment $preemployment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Preemployment  $preemployment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Preemployment $preemployment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Preemployment  $preemployment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Preemployment $preemployment)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            Storage::delete('public/uploaded/pre-employment/'.$preemployment->pre_employment_med);
            $preemployment->delete();
            return back();
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }

    public function download($pre_emp)
    {
        if (Gate::allows('isAdmin') || Gate::allows('isDoctor') || Gate::allows('isNurse')) {
            return response()->download(storage_path("app/public/uploaded/pre-employment/".$pre_emp));
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }
}
