<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Clinic | Annual Report</title>

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
	    <script
	  	src="https://code.jquery.com/jquery-3.4.1.min.js"
	  	integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
	  	crossorigin="anonymous"></script>

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
			.table-wrap{
				margin-bottom: 1em;
				position: relative;
			}
			.table-wrap:before {content: '';position: absolute;background: transparent;width: 95%;height: 0px;bottom: 0;left: 0;right: 0;margin: auto;border-bottom: 2px dashed #e0e0e0;}
			.table-wrap .table-responsive {background-color: #fff;box-shadow: 0px 1px 4px #ddd;border-left: 4px solid #00988D;margin-bottom: 1.75em;}
			.table-wrap .table-responsive table.table {margin-bottom: 0;}
			.table-wrap:nth-child(even) .table-responsive{
				border-left-color: #343a40;
			}
			.table-wrap .table-sm th, .table-sm td{ padding: 0.5rem; }
			.printable-title {
			    font-size: 18px;
			    line-height: 1.5;
			    font-weight: 600;
			}
			.printable-title span {
			    font-weight: 500;
			    color: #353535;
			}
	    </style>
	</head>
	<body>
		<div id="printable">
			{{-- <div class="print-sidebar">sidebar</div> --}}
			<div class="print-content">
				<div class="text-center">	
					<img src="{{url( '/images/logo.png' )}}" alt="Zapport">
				</div>
				<div class="container">
					<div class="col-12 text-right d-flex justify-content-end">
						<button id="printThatText" name="printThatText" onclick="printPage();" class="btn btn-outline-info">Print</button>
					</div>			
					<div class="col-12 text-center mb-4 mt-4">
						<h1 id="CurrDate" class="text-secondary" style="font-size: 22px;">Annual Report</h1>
					</div>
				</div>
				<div id="annualReport" class="container">
					<div id="annualFilter" class="form-group">
						<select name="select_date" id="select_date" class="form-control">
							<option selected="true" disabled="true" value="">Select Year</option>
							@foreach ($emps as $key => $emp)
								<option value="{{ $key }}"><h3>{{ $key }}</h3></option>
							@endforeach
						</select>
					</div>
					@foreach ($emps as $key => $emp)
						<div id="year-{{ $key }}" class="ol row d-none">
							@foreach ($emp->unique('diagnosis') as $filter)
								<div class="col-12 table-wrap">
									<h2 class="text-muted printable-title">Illness: <span>{{ ucfirst($filter->diagnosis) }}</span></h2>
									<div class="table-responsive">
										<table class="table table-sm">
											<thead>
												<tr>
													<th>Illness</th>
													<th>Gender</th>
													<th>Age</th>
													<th>Total of Person</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($emp->unique('age') as $age)
													@if ($emp->where('gender', 0)->where('diagnosis', $filter->diagnosis)->where('age', $age->age)->count() > 0 || $emp->where('gender', 1)->where('diagnosis', $filter->diagnosis)->where('age', $age->age)->count() > 0)
													<tr>
														{{-- @if ($loop->first) --}}
														<td  rowspan="{{ ($loop->first) ? $emp->where('diagnosis', $filter->diagnosis)->count() : '' }}" >
															@if ($filter->diagnosis == $age->diagnosis)
																{{ $filter->diagnosis }}
															@endif
														</td>
														{{-- @endif --}}

														<td>{{ ( $age->gender  === 0 ) ? 'Male' : 'Female'}}</td>
														<td> {{  $age->age  }} </td>
														<td>
															@if ($age->gender === 0)
																{{ $emp->where('gender', 0)->where('diagnosis', $filter->diagnosis)->where('age', $age->age)->count() }}
															@else
																{{ $emp->where('gender', 1)->where('diagnosis', $filter->diagnosis)->where('age', $age->age)->count() }}
															@endif
														</td>
													</tr>
													@endif
												@endforeach
											</tbody>
											<tfoot>
												<tr>
													<td>Total of Female : {{ $emp->where('gender', 1)->where('diagnosis', $filter->diagnosis)->count() }}</td>
													<td>Total of Male : {{ $emp->where('gender', 0)->where('diagnosis', $filter->diagnosis)->count() }}</td>
													<td>Total Employee : {{ $emp->where('diagnosis', $filter->diagnosis)->count() }}</td>
												</tr>
											</tfoot>
										</table>								
									</div>
								</div>								
							@endforeach
						</div>

					@endforeach
				</div>
			</div>
		</div>
		<script type="text/javascript">

			function printPage()
			{
			    var myDropDown = document.getElementById('printThatText');
			    var annualFilter = document.getElementById('annualFilter');
			    myDropDown.style.display = "none";
			    annualFilter.style.display = "none";
			    window.print();
			    myDropDown.style.display = "block";
			    annualFilter.style.display = "block";
			    return true;
			}

			jQuery(document).ready(function($){

				var yearNow = new Date().getFullYear();

				$("#year-"+yearNow+"").removeClass('d-none');

				$("#CurrDate").append(' '+yearNow);

				$('select[name="select_date"]').on('change',function(){
					document.getElementById("CurrDate").innerHTML = '';
					var date_selected = $(this).val();
					$("#annualReport").each(function() {
						$(this).find('.ol').addClass('d-none');
					});
					$("#year-"+date_selected+"").removeClass('d-none');
					$("#CurrDate").append('Annual Report '+date_selected);
				});

			});
		</script>
	</body>
</html>