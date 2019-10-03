@extends('layouts.app')
@section('title', '| All Employee')
@section('employees', 'active')
{{-- @section('dash-title', 'All Employees') --}}

@section('heading-title')
	<i class="fas fas fa-users text-secondary"></i> All Employees
@endsection
@section('dash-content')

<a href="{{ route('print.emp') }}" class="btn btn-outline-info float-right" target="_blank">Print</a>
<form method="get">
	<div class="form-row">
		<div class="form-group col-md-4">
			<input type="search" name="search" class="form-control" value="{{ (!empty($search)) ? $search : '' }}" placeholder="Search for Employee">
		</div>
		<div class="form-group col-md-1 d-inline-flex">
			<button type="submit" class="btn btn-success mr-2">Search</button>
			<a href="{{ route('hr.employees') }}" class="btn btn-info text-white">Clear</a>
		</div>
	</div>
</form>
<div class="card mb-5">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Employee No.</th>
					<th>Name</th>
					<th>Department - Position</th>
					<th>Action</th>
				</thead>
				<tbody>
					@forelse ($employees as $employee)
						<tr>
							<td>{{ $employee->emp_id }}</td>
							<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
							<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							<td> <a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i>View</a></td>

						</tr>
						@empty
							<tr>
								<td colspan="4" class="text-center">{{ "No registered Employee yet!" }}</td>
							</tr>
					@endforelse
				</tbody>
			</table>
			{{ $employees->links() }}				
		</div>
	
	</div>
</div>


@endsection