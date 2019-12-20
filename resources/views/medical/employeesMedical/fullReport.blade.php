<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style type="text/css">
    	.custom-bg{
    		background-color: #fff;
    		box-shadow: 2px 3px 8px 0px #888888;
    	}
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
			.border-top-transparent{
				border-top-color: transparent;
			}
			.branch-list{
				position: relative;
			}
			.branch-list:before{
				background: #e4e4e4;
				content: '';
				display: block;
				height: 100%;
				position: absolute;
				left: -15px;
				bottom: -22px;
				width: 1px;
			}
			.branch-list.branch-list-child:before{
				//font-family: 'fontAwesome';
				//content:'\f069';
				bottom: 0;
				color:red;
				height: 90%;
				left: 25px;
			}
    </style>
</head>
<body>

	<div id="printable">
		<div class="text-center">	
			<img src="{{url( '/images/logo.png' )}}" alt="Zapport">
			<div style="margin-top: 20px; margin-bottom: 20px;">
				<p class="text-center text-secondary" style="line-height:0px;">14/F UNIT 14-G BURGUNDY CORPORATE TOWER</p>
				<p class="text-center text-secondary" style="line-height:0px;">Sen Gil Puyat Ave., San Lorenzo</p>
				<p class="text-center text-secondary" style="line-height:0px;">Makati City Philippines</p>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-12 float-right text-right d-flex justify-content-end">
					<button id="printThatText" name="printThatText" onclick="printPage();" class="btn btn-outline-info">Print</button>
				</div>			
				<div class="col-12 text-center mb-4 mt-4">
					<h1 id="CurrDate" class="text-secondary" style="font-size: 22px;">Illness Annual Report</h1>
				</div>
			</div>
			<div class="row">
				<div id="annualReport" class="col-12">
					<div id="annualFilter" class="form-group">
						<select name="select_date" id="select_date" class="form-control">
							<option selected="true" disabled="true" value="">Select Year</option>
							@foreach ($emps as $key => $emp)
								<option value="{{ $key }}"><h3>{{ $key }}</h3></option>
							@endforeach
						</select>
					</div>
					@foreach ($emps as $key => $emp)
						<ol id="year-{{ $key }}" class="d-none">
							{{-- <h3 class="text-secondary">{{ $key }}</h3> --}}
							@foreach ($emp->unique('bodypart') as $filter)
								<ul class="mb-4 p-0">
									<li class="branch-list">
										{{-- <h3 class="h4">{{ ucfirst($filter->bodypart) }}</h3> dito --}}
										<a class="btn btn-link" data-toggle="collapse" href="#diagnosis_{{ $filter->id }}" role="button" aria-expanded="false" aria-controls="diagnosis_{{ $filter->id }}">{{ ucfirst($filter->bodypart) }}</a>
										@foreach ($emp->unique('disease') as $disease)
											<ul >
												@if ($emp->where('disease', $disease->disease)->where('bodypart', $filter->bodypart)->count() > 0)
													<li class="collapse multi-collapse" id="diagnosis_{{ $filter->id }}">
														{{-- <h4 class="h5">{{ strtoupper($disease->disease) }}</h4> --}}
														<a class="btn btn-link" data-toggle="collapse" href="#disease_{{ $disease->id }}" role="button" aria-expanded="false" aria-controls="disease_{{ $disease->id }}">{{ strtoupper($disease->disease) }}</a>
														<div class="collapse multi-collapse" id="disease_{{ $disease->id }}">
															<div class="card border-top-transparent mb-3">
																<div class="card-body p-0 table-responsive">
																	<table class="table table-striped mb-0">
																		<thead>
																			<th>Gender</th>
																			<th>Age</th>
																			<th>No. of Cases per Age & Gender</th>
																		</thead>
																		<tbody>
																			@foreach ($emp->unique('age') as $age)
																				<tr>
																				@if ($emp->where('gender', 0)->where('disease', $disease->disease)->where('bodypart', $filter->bodypart)->where('age', $age->age)->count() > 0)
																					<td>
																						Male
																					</td>
																					<td>
																						{{ $age->age }}
																					</td>
																					<td>
																						{{ $emp->where('gender', 0)->where('disease', $disease->disease)->where('bodypart', $filter->bodypart)->where('age', $age->age)->count() }}
																					</td>
																				@endif
																				</tr>
																				<tr>
																				@if ($emp->where('gender', 1)->where('disease', $disease->disease)->where('bodypart', $filter->bodypart)->where('age', $age->age)->count() > 0)
																					<td>
																						Female
																					</td>
																					<td>
																						{{ $age->age }}
																					</td>
																					<td>
																						{{ $emp->where('gender', 1)->where('disease', $disease->disease)->where('bodypart', $filter->bodypart)->where('age', $age->age)->count() }}
																					</td>
																				@endif
																				</tr>
																			@endforeach
																		</tbody>
																		<tfoot>
																			<tr>
																				<td>Total of Male: {{ $emp->where('gender', 0)->where('disease', $disease->disease)->where('bodypart', $filter->bodypart)->count() }}</td>
																				<td>Total of Female: {{ $emp->where('gender', 1)->where('disease', $disease->disease)->where('bodypart', $filter->bodypart)->count() }}</td>
																				<td>Total No. of Cases: {{ $emp->where('disease', $disease->disease)->where('bodypart', $filter->bodypart)->count() }}</td>
																			</tr>
																			<tr>
																				<td colspan="3">
																					<b>List of Diagnosis:</b>
																					<ul>
																						@php
																							$colletion = $emp->where('bodypart', $filter->bodypart)->where('disease', $disease->disease);
																						@endphp
																						@foreach ($colletion->unique('diagnosis') as $result)
																							<li>
																								{{ ucfirst($result->diagnosis) }}
																							</li>
																						@endforeach
																					</ul>
																				</td>
																			</tr>
																		</tfoot>
																	</table>
																</div>
															</div>
														</div>
													</li>
												@endif
											</ul>
										@endforeach
									</li>
								</ul>
							@endforeach
						</ol>
					@endforeach
				</div>
			</div>
		</div>
	</div>

	<script src="{{ asset('js/app.js') }}"></script>
	<script type="application/javascript">
	function printPage()
	{
	    var myDropDown = document.getElementById('printThatText');
			var annualFilter = document.getElementById('annualFilter');

			/**add-class*/
			collapseClass('.multi-collapse','show');

	    myDropDown.style.display = "none";
	    annualFilter.style.display = "none";
	    window.print();
	    myDropDown.style.display = "block";
			annualFilter.style.display = "block";
			
			
			return true;
			
	}

	/**function-for-adding-class*/
	const collapseClass = (selector, classAdded) => {		
		/**adding-class-show*/
		let addCollapseClass = document.querySelectorAll(selector);
		
		/**checking-if-class-is-available*/
		if(addCollapseClass){
			/**Loop*/
			for(let i = 0; i < addCollapseClass.length; i++){
				/**Add-Class-Show*/
				addCollapseClass[i].classList.add(classAdded);
			}
		}

		/**jQuery-Method-adding-class*/
		{{-- $(selector).addClass(classAdded);  --}}
	}



	jQuery(document).ready(function($){
		var yearNow = new Date().getFullYear();
		$("#year-"+yearNow+"").removeClass('d-none');
		$("#CurrDate").append(' '+yearNow);
		$('select[name="select_date"]').on('change',function(){
			document.getElementById("CurrDate").innerHTML = '';
			var date_selected = $(this).val();
			$("#annualReport").each(function() {
				$(this).find('ol').addClass('d-none');
			});
			$("#year-"+date_selected+"").removeClass('d-none');
			$("#CurrDate").append('Illness Annual Report '+date_selected);
		});
	});
	</script>

</body>
</html>