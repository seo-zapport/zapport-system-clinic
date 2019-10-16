<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style type="text/css">
    	#printable{
		    padding: 0.5rem 0.2rem;
		    margin: 0.7rem 0;		
    	}
    	#printable .btn.btn-outline-info:hover{
    		color:#fff;
    	}
    	.wrap{
    		padding:0 15px;
    	}
    	.wrap p{
    		margin:0;
    		padding:0;
    		font-size: 12px;
    		color: #6b6b6b;
    		text-transform: uppercase;
    		font-weight: 600;
    	}
    	.wrap p > span {
		    font-size: 16px;
		    color: #089c9c;
		}
    </style>
</head>
<body>

	<div id="printable">
		<div class="text-center">	
			<img src="{{url( '/images/logo.png' )}}" alt="Zapport">
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-12 col-md-6 mb-4 mt-4">
					<h1 class="text-secondary" style="font-size: 22px;">Full Report</h1>
				</div>
				<div class="col-12 col-md-6 mb-4 mt-4 text-right d-flex justify-content-end">
					<button id="printThatText" name="printThatText" onclick="printPage();" class="btn btn-outline-info">Print</button>
				</div>			
			</div>
			<div class="row">
				<div class="col-12">
					<h5>Diagnosis</h5>
					<ol>
{{-- 						@foreach ($diagnoses as $diagnosis)
							<li>{{ $diagnosis->diagnosis }}</li>
							<ul>
								<li>Male
									{{ $diagnosis->join('employeesmedicals', 'diagnoses.id', 'employeesmedicals.diagnosis_id')
												 ->join('employees', 'employees.id', 'employeesmedicals.employee_id')
												 ->select('diagnosis', 'employees.gender as gender')
												 ->groupBy('diagnosis', 'gender')
												 ->where('diagnosis', $diagnosis->diagnosis)
												 ->where('gender', 0)
												 ->count() }}
								</li>
								<li>Female
									{{ $diagnosis->join('employeesmedicals', 'diagnoses.id', 'employeesmedicals.diagnosis_id')
												 ->join('employees', 'employees.id', 'employeesmedicals.employee_id')
												 ->select('diagnosis', 'employees.gender as gender')
												 ->groupBy('diagnosis', 'gender')
												 ->where('diagnosis', $diagnosis->diagnosis)
												 ->where('gender', 1)
												 ->count() }}
								</li>
								<li>Total
									{{ dd($diagnosis->join('employeesmedicals', 'diagnoses.id', 'employeesmedicals.diagnosis_id')
												 ->join('employees', 'employees.id', 'employeesmedicals.employee_id')
												 ->select('diagnosis', 'employees.gender', DB::raw('WEEK(employeesmedicals.created_at)'), DB::raw('COUNT(employees.gender) as gender_count'))
												 ->groupBy('diagnosis', 'employees.gender', DB::raw('WEEK(employeesmedicals.created_at)'))
												 ->where('diagnosis', $diagnosis->diagnosis)
												 ->get()) }}
								</li>
								<li>Total
									{{ dd($diagnosis->join('employeesmedicals', 'diagnoses.id', 'employeesmedicals.diagnosis_id')
												 ->join('employees', 'employees.id', 'employeesmedicals.employee_id')
												 ->select('diagnosis', 'employees.gender', 'employeesmedicals.created_at as created_at')
												 ->where('diagnosis', $diagnosis->diagnosis)
												 ->get()
											     ->groupBy(function($date) {
											         return Carbon\carbon::parse($date->created_at)->format('Y-m');
											       }))
												  }}


									{{	$collections = $diagnosis->join('employeesmedicals', 'diagnoses.id', 'employeesmedicals.diagnosis_id')
																 ->join('employees', 'employees.id', 'employeesmedicals.employee_id')
																 ->select('diagnosis', 'employees.gender', DB::raw('WEEK(employeesmedicals.created_at) as per_month'), DB::raw('COUNT(employees.gender) as gender_count'))
																 ->groupBy('diagnosis', 'employees.gender', DB::raw('WEEK(employeesmedicals.created_at)'))
																 ->where('diagnosis', $diagnosis->diagnosis)
																 ->get()
																 ->groupBy(function($date) {
															         return Carbon\carbon::parse($date->created_at)->format('Y-m');
															       })
									}}

								</li>
							</ul>
						@endforeach --}}

{{-- 						@for ($i = 0; $i < $arr_count ; $i++)
							@foreach ($arr[$i] as $key => $value)
								{{ $key }} <br>
								@foreach ($value as $d)
									@if ($loop->first)
									<ul>
										<li>{{ ucfirst($d->diagnosis) }}</li>
										<ul>
											<li>Number of Male: {{ $value->where('gender', 0)->count() }}</li>
											<li>Number of Female: {{ $value->where('gender', 1)->count() }}</li>
											<li>Total: {{ count($value) }}</li>
										</ul>
									</ul>
									@endif
								@endforeach
							@endforeach
						@endfor --}}

						@foreach ($emps as $key => $emp)
							{{ $key }} <br>
							@foreach ($emp->unique('diagnosis') as $filter)
								<ul>
									<li>{{ ucfirst($filter->diagnosis) }}</li>
									<ul>
										<li>Male: {{ $emp->where('gender', 0)->where('diagnosis', $filter->diagnosis)->count() }}</li>
										<li>Female: {{ $emp->where('gender', 1)->where('diagnosis', $filter->diagnosis)->count() }}</li>
										<li>Total: {{ $emp->where('diagnosis', $filter->diagnosis)->count() }}</li>
									</ul>
								</ul>
							@endforeach
						@endforeach

					</ol>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
	function printPage()
	{
	    var myDropDown = document.getElementById('printThatText');
	    myDropDown.style.display = "none";
	    window.print();
	    myDropDown.style.display = "block";
	    return true;
	}
	</script>

</body>
</html>