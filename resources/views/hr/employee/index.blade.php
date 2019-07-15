@extends('layouts.app')
@section('title', 'Add Employee')
@section('employees', 'active')
@section('dash-title', 'All Employees')
@section('dash-content')

<table class="table table-hover">
	<thead class="thead-dark">
		<th>Employee Number</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Middle Name</th>
		<th></th>
	</thead>
	<tbody>
		@foreach ($employees as $employee)
			<tr>
				<td>{{ $employee->emp_id }}</td>
				<td>{{ ucwords($employee->first_name) }}</td>
				<td>{{ ucwords($employee->last_name) }}</td>
				<td>{{ ucwords($employee->middle_name) }}</td>
				<td><a href="{{ route('hr.emp.show', ['employee' => $employee->id]) }}" class="btn btn-info text-white">View</a></td>
			</tr>
		@endforeach
	</tbody>
</table>

@endsection