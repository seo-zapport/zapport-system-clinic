<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

<button id="printThatText" name="printThatText" onclick="printPage();">Print this page</button>


<div id="printable">
<img src="{{url( '/images/logo.png' )}}" alt="Zapport">
<h1 class="text-center">Employees List</h1>

<div class="container-fluid">
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

<p class="text-right mr-5 mt-5">Printed by: {{ Auth::user()->employee->first_name }} {{ Auth::user()->employee->last_name }} {{ Auth::user()->employee->middle_name }}</p>
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