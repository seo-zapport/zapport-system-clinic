<?php

namespace App\Http\Controllers;

use App\Supply;
use App\Supgen;
use App\Supbrand;
use Illuminate\Http\Request;
use App\EmployeesmedicalSupplyUser;
use App\Http\Requests\SupplyRequest;
use Illuminate\Support\Facades\Gate;

class SupplyController extends Controller
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
        if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse') || Gate::check('isHr')) {
            $supgens = Supgen::orderBy('name')->get();
            $raw = Supply::join('supgens', 'supgens.id', '=', 'supplies.supgen_id')
                         ->join('supbrands', 'supbrands.id', '=', 'supplies.supbrand_id')
                         ->select('supbrand_id', 'supgen_id', 'supgens.name', 'supbrands.name')
                         ->groupBy('supbrand_id', 'supgen_id', 'supgens.name', 'supbrands.name')
                         ->orderBy('supplies.id', 'desc');
            if ($request->search) {
                $supplies = $raw->where('supgens.name', 'like', '%'.$request->search.'%')
                                ->orWhere('supbrands.name', 'like', '%'.$request->search.'%')
                                ->paginate(10);
            }
            $supplies = $raw->paginate(10)->appends(['search' => $request->search]);
            $search = $request->search;
            return view('inventory.supply.supplies.index', compact('supgens', 'supplies', 'search'));
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
    public function store(SupplyRequest $request)
    {
        if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse')) {
            $atts = $this->validate($request, $request->rules(), $request->messages());
            $dtm = \Carbon\carbon::now();
            for ($i=1; $i <= $request->quantity; $i++) { 
                $newsupply                  = new Supply;
                $newsupply->user_id         = auth()->id();
                $newsupply->supbrand_id     = $request->supbrand_id;
                $newsupply->supgen_id       = $request->supgen_id;
                $newsupply->quantity        = $request->quantity;
                $newsupply->expiration_date = $request->expiration_date;
                $newsupply->availability    = 0;
                $newsupply->created_at      = $dtm;
                $newsupply->updated_at      = $dtm;
                $newsupply->save();
            }
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
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Supply $supply, Supgen $supgen, Supbrand $supbrand)
    {
        if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse') || Gate::check('isHr')) {
            $raw = Supply::select('user_id', 'supbrand_id', 'supgen_id', 'expiration_date', 'quantity', 'created_at')
                         ->where('supgen_id', $supgen->id)
                         ->where('supbrand_id', $supbrand->id)
                         ->orderBy('created_at', 'desc')
                         ->groupBy('user_id', 'supbrand_id', 'supgen_id', 'expiration_date', 'quantity', 'created_at')
                         ->distinct('created_at');
            $rawDates = Supply::select('user_id', 'supbrand_id', 'supgen_id', 'expiration_date', 'quantity', \DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as fdate"))
                              ->groupBy('user_id', 'supbrand_id', 'supgen_id', 'expiration_date', 'quantity','created_at')
                              ->where('supgen_id', $supgen->id)
                              ->where('supbrand_id', $supbrand->id)
                              ->orderBy('created_at');
            if ($request->search && $request->expired == null) {
                $rawSup = $raw->where('created_at', 'like', '%'.$request->search.'%')
                              ->paginate(10)
                              ->appends(['search' => $request->search]);
                $dates = $rawDates->where('created_at', '!=', $request->search)
                                  ->get();
            }elseif ($request->expired && $request->search == null) {
                $rawSup = $raw->where('expiration_date', '<=', NOW())
                              ->paginate(10);
                $dates = $rawDates->where('created_at', '!=', $request->search)
                                  ->get();
            }elseif ($request->search && $request->expired) {
                $rawSup = $raw->where('created_at', 'like', '%'.$request->search.'%')
                              ->where('expiration_date', '<=', NOW())
                              ->paginate(10);
                $dates = $rawDates->where('created_at', '!=', $request->search)
                                  ->get();
            }
            $rawSup = $raw->paginate(10);
            $dates = $rawDates->get();
            return view('inventory.supply.supplies.show', compact('rawSup', 'dates', 'supgen', 'supbrand'));
        }elseif (Gate::check('isBanned')) {
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function edit(Supply $supply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supply $supply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supply $supply)
    {
        //
    }

    /**
     * Show logs the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showLog(Request $request, Supply $supply, Supgen $supgen, Supbrand $supbrand, $created)
    {
        if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse') || Gate::check('isHr')) {
            $rawQry = EmployeesmedicalSupplyUser::join('users', 'users.id', '=', 'employeesmedical_supply_users.user_id')
                                                ->join('employeesmedicals', 'employeesmedicals.id', '=', 'employeesmedical_supply_users.employeesmedical_id')
                                                ->join('supplies', 'supplies.id', '=', 'employeesmedical_supply_users.supply_id')
                                                ->join('supbrands', 'supbrands.id', '=', 'supplies.supbrand_id')
                                                ->join('supgens', 'supgens.id', '=', 'supplies.supgen_id')
                                                ->join('employees as requested', 'requested.id', '=', 'employeesmedicals.employee_id')
                                                ->join('employees as givenBy', 'users.id', '=', 'givenBy.user_id')
                                                ->select(
                                                   'employeesmedical_supply_users.supqty as given_quantity', 'employeesmedical_supply_users.created_at as date_given',
                                                   'requested.first_name as requested_Fname', 'requested.last_name as requested_Lname',
                                                   'givenBy.first_name as givenBy_Fname', 'givenBy.last_name as givenBy_Lname',
                                                   'supplies.created_at as date_input', \DB::raw('COUNT(supplies.availability) as sup_avail'), 'supplies.quantity as sup_qty',
                                                   'supbrands.name as brand_name',
                                                   'supgens.name as supply_name'
                                                )
                                                ->groupBy(
                                                   'employeesmedical_supply_users.supqty', 'employeesmedical_supply_users.created_at',
                                                   'requested.first_name', 'requested.last_name',
                                                   'givenBy.first_name', 'givenBy.last_name',
                                                   'supplies.created_at', 'supplies.availability', 'supplies.quantity',
                                                   'supbrands.name',
                                                   'supgens.name'
                                                )
                                                ->where('supplies.created_at', $created)
                                                ->where('supbrands.id', $supbrand->id)
                                                ->where('supgens.id', $supgen->id);

            $rawDates = EmployeesmedicalSupplyUser::join('supplies', 'supplies.id', '=', 'employeesmedical_supply_users.supply_id')
                                                  ->join('supbrands', 'supbrands.id', '=', 'supplies.supbrand_id')
                                                  ->join('supgens', 'supgens.id', '=', 'supplies.supgen_id')
                                                  ->select(
                                                    'employeesmedical_supply_users.created_at', \DB::raw("DATE_FORMAT(employeesmedical_supply_users.created_at, '%Y-%m-%d') as fdate"),
                                                    'supplies.created_at as input_date',
                                                    'supbrands.id',
                                                    'supgens.id'
                                                  )
                                                  ->groupBy(
                                                    'employeesmedical_supply_users.created_at',
                                                    'supplies.created_at',
                                                    'supbrands.id',
                                                    'supgens.id'
                                                  )
                                                  ->where('supbrands.id', $supbrand->id)
                                                  ->where('supgens.id', $supgen->id)
                                                  ->where('supplies.created_at', $created)
                                                  ->orderBy('created_at', 'desc');

            if ($request->search_name && $request->search_date == NULL) {
                $raw = $rawQry->where(\DB::raw("concat(requested.first_name, ' ', requested.last_name)"), 'like', '%'.$request->search_name.'%')
                              ->paginate(10);
            }elseif ($request->search_name == NULL && $request->search_date) {
                $raw = $rawQry->where('employeesmedical_supply_users.created_at', 'like', '%'.$request->search_date.'%')
                              ->get();
                $dates = $rawDates->where('employeesmedical_supply_users.created_at', '!=', $request->search_date)
                                  ->get();
            }elseif ($request->search_name && $request->search_date) {
                $raw = $rawQry->where(\DB::raw("concat(requested.first_name, ' ', requested.last_name)"), 'like', '%'.$request->search_name.'%')
                              ->where('employeesmedical_supply_users.created_at', 'like', '%'.$request->search_date.'%')
                              ->get();
                $dates = $rawDates->where('employeesmedical_supply_users.created_at', '!=', $request->search_date)
                                  ->get();
            }
            $raw = $rawQry->paginate(10);
            $dates = $rawDates->get();
            return view('inventory.supply.supplies.logs', compact('raw', 'supgen', 'supbrand', 'created', 'dates'));
        }elseif (Gate::check('isBanned')) {
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }

    /**
     * Ajax the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            $supGen = Supgen::find($request->supgen_id);
            $getSupBrand = $supGen->supbrands->pluck('name', 'id');
            return json_encode($getSupBrand);
        }
    }
}
