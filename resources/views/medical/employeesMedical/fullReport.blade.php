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
				<div class="col-12 float-right text-right d-flex justify-content-end">
					<button id="printThatText" name="printThatText" onclick="printPage();" class="btn btn-outline-info">Print</button>
				</div>			
				<div class="col-12 text-center mb-4 mt-4">
					<h1 id="CurrDate" class="text-secondary" style="font-size: 22px;">Annual Report</h1>
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
							@foreach ($emp->unique('diagnosis') as $filter)
								<ul class="mb-4 p-0">
									<li><h3 class="h4">{{ ucfirst($filter->diagnosis) }}</h3></li>
									<ul>
										<li class="mb-2 font-weight-bold">Male:</li>
											{{-- <ul class="p-0"> --}}
												@foreach ($emp->unique('age') as $age)
													
														{!! 
															( $emp->where('gender', 0)->where('diagnosis', $filter->diagnosis)->where('age', $age->age)->count() > 0 ) 
																?
															  		'- ' . 'Age: ' . $age->age . ' : ' . $emp->where('gender', 0)->where('diagnosis', $filter->diagnosis)->where('age', $age->age)->count() . '<br>'
															  	: 
															  		''
														!!}
													
												@endforeach
											{{-- </ul> --}}
											<div class="font-weight-bold">Total number of Male: <span>{{ $emp->where('gender', 0)->where('diagnosis', $filter->diagnosis)->count() }}</span></div>

										<li class="mb-2 mt-2 font-weight-bold">Female:</li>
											{{-- <ul class="p-0"> --}}
												@foreach ($emp->unique('age') as $age)
													
														{!! 
															( $emp->where('gender', 1)->where('diagnosis', $filter->diagnosis)->where('age', $age->age)->count() > 0 ) 
																?
															  		'- ' . 'Age: ' . $age->age . ' : ' . $emp->where('gender', 1)->where('diagnosis', $filter->diagnosis)->where('age', $age->age)->count() . '<br>'
															  	: 
															  		''
														!!}
													
												@endforeach
											{{-- </ul> --}}
											<div class="font-weight-bold">Total number of Female:  <span>{{ $emp->where('gender', 1)->where('diagnosis', $filter->diagnosis)->count() }}</span></div><br>
									</ul>
									<div class="font-weight-bold">Total: {{ $emp->where('diagnosis', $filter->diagnosis)->count() }}</div>
								</ul>
							@endforeach
						</ol>
						@endforeach
				</div>
			</div>
		</div>
	</div>

	<script type="application/javascript">

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
				$(this).find('ol').addClass('d-none');
			});
			$("#year-"+date_selected+"").removeClass('d-none');
			$("#CurrDate").append('Annual Report '+date_selected);
		});

	});

	</script>

</body>
</html>