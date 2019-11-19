@extends('layouts.app')
@section('title', '| Lists of Employee')
@section('employeesMedical', 'active')
{{-- @section('dash-title', 'Lists of Employee') --}}
@section('heading-title')
	<i class="fas fa-list text-secondary"></i> Lists of Employee
@endsection
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
<div class="card mb-5">
	<div class="card-body" id="medical_employee_list">
		<div class="d-flex mb-3">
			<div class="col-12 col-md-6">
				<span class="text-primary">Total number of Employee: {{ $countEmp->count() }}</span>
			</div>
			<div class="col-12 col-md-6 count_items"><span>{{ $emps->count() }} items</span></div>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th width="10%">ID No.</th>
					<th>Name</th>
					<th width="25%" class="">Department - Positon</th>
				</thead>
				<tbody>
					@forelse(@$emps as $emp)
						<tr>
							<td>{{ $emp->emp_id }}</td>
							<td>{{ ucwords($emp->last_name . " " . $emp->first_name . " " . $emp->middle_name) }}
								<div class="row-actions">
									<a href="{{ route('medical.employeeInfo', ['employee' => $emp->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i> View</a>
								</div>
							</td>
							<td>{{ strtoupper($emp->departments->department) . " - " . ucwords( $emp->positions->position) }}</td>
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