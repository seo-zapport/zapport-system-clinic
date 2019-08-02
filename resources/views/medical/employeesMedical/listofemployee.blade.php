@extends('layouts.app')
@section('title', 'Lists of Employee')
@section('employeesMedical', 'active')
@section('dash-title', 'Lists of Employee')
@section('dash-content')

<form method="get">
	<div class="form-row">
		<div class="form-group col-md-4">
			<input type="search" name="search" class="form-control" value="{{ (!empty($search)) ? $search : '' }}" placeholder="Search for Employee ID or Name of Employee">
		</div>
		<div class="form-group col-md-1 d-inline-flex">
			<button type="submit" class="btn btn-success mr-2">Search</button>
			<a href="{{ route('medical.listsofemployees') }}" class="btn btn-info text-white">Clear</a>
		</div>
	</div>
</form>

<table class="table table-hover">
	<thead class="thead-dark">
		<th>Employee ID</th>
		<th>Name</th>
		<th>Department - Positon</th>
		<th>Action</th>
	</thead>
	<tbody>
		@forelse(@$emps as $emp)
			<tr>
				<td>{{ $emp->emp_id }}</td>
				<td>{{ ucwords($emp->last_name . " " . $emp->first_name . " " . $emp->middle_name) }}</td>
				<td>{{ strtoupper($emp->departments->department) . " - " . ucwords( $emp->positions->position) }}</td>
				<td>
					<a href="{{ route('medical.employeeInfo', ['employee' => $emp->id]) }}" class="btn btn-info text-white">View</a>
				</td>
			</tr>
			@empty
				<tr>
					<td colspan="4" class="text-center"> No Records Found! </td>
				</tr>
		@endforelse
	</tbody>
</table>
{{-- {{ $emps->links() }} --}}

@endsection