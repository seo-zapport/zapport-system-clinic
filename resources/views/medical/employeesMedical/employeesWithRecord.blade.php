@extends('layouts.app')
@section('title', '| Lists of Employee')
@section('employeesWithRecord', 'active')
{{-- @section('dash-title', 'Lists of Employee') --}}
@section('heading-title')
	<i class="fas fa-list text-secondary"></i> Employees With Medical Records
@endsection
@section('dash-content')

<a href="{{ route('medical.fullReport') }}" class="btn btn-outline-info float-right" target="_blank">Full Report</a>

<form method="get">
	<div class="form-row">
		<div class="form-group col-md-4">
			<input type="search" name="search" class="form-control" value="{{ (!empty($search)) ? $search : '' }}" placeholder="Search for Employee ID | Name of Employee">
		</div>
		<div class="form-group col-md-1 d-inline-flex">
			<button type="submit" class="btn btn-success mr-2">Search</button>
			<a href="{{ route('medical.empsRecords') }}" class="btn btn-info text-white">Clear</a>
		</div>
	</div>
</form>

<div class="card mb-5">
	<div class="card-body" id="medical_employee_list">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Employee ID</th>
					<th>Name</th>
					<th>Department - Positon</th>
					<th>Action</th>
				</thead>
				<tbody>
					@forelse(@$emps->unique('emp_id') as $emp)
						<tr>
							<td>{{ $emp->emp_id }}</td>
							<td>{{ ucwords($emp->last_name . " " . $emp->first_name . " " . $emp->middle_name) }}</td>
							<td>{{ strtoupper($emp->departments->department) . " - " . ucwords( $emp->positions->position) }}</td>
							<td class="w-15 px-0">
								<a href="{{ route('medical.employeeInfo', ['employee' => $emp->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i> View</a>
							</td>
						</tr>
						@empty
							<tr>
								<td colspan="4" class="text-center"> No Records Found! </td>
							</tr>
					@endforelse
				</tbody>
			</table>			
		</div>
	</div>
</div>

{{ $emps->links() }}

@endsection