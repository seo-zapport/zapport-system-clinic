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
				<h1 class="text-secondary" style="font-size: 22px;">Employees List</h1>
			</div>
			<div class="col-12 col-md-6 mb-4 mt-4 text-right d-flex justify-content-end">
				<button id="printThatText" name="printThatText" onclick="printPage();" class="btn btn-outline-info">Print</button>
			</div>			
		</div>
		<div class="table-responsive">
			<table class="table">
				<thead>
					<th>Employee Number</th>
					<th>Name</th>
					<th>Department - Position</th>
				</thead>
				<tbody>
					@forelse ($employees as $employee)
						<tr>
							<td>{{ $employee->emp_id }}</td>
							<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
							<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
						</tr>
						@empty
							<tr>
								<td colspan="4" class="text-center">{{ "No registered Employee yet!" }}</td>
							</tr>
					@endforelse
				</tbody>
			</table>	
		</div>
	</div>
	<div class="wrap text-right">
		<p>Total number of employees: <span>{{ $employees->count() }}</span></p>
		<p>Printed by: <span>{{ Auth::user()->employee->first_name }} {{ Auth::user()->employee->last_name }} {{ Auth::user()->employee->middle_name }}</span></p>
	</div>
</div>

<script type="text/javascript">
function printPage()
{
    var myDropDown = document.getElementById('printThatText');
    myDropDown.style.display = "none";
    //Whatever other elements to hide.
    window.print();
    myDropDown.style.display = "block";
    return true;
}
</script>

</body>
</html>