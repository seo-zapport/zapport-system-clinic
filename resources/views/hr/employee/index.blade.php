@extends('layouts.app')
@section('title', '| All Employee')
@section('employees', 'active')
{{-- @section('dash-title', 'All Employees') --}}

@section('heading-title')
	<i class="fas fas fa-users text-secondary"></i> All Employees
@endsection
@section('dash-content')

{{-- <a href="{{ route('print.emp') }}" class="btn btn-outline-info float-right" target="_blank">Print</a> --}}
<button onclick="clicked()" class="btn btn-outline-info float-right">Print</button>

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
<span id="showFilter" class="text-info font-weight-bold" style="cursor: pointer;">Advanced filter <i class="fas fa-user-cog"></i></span>
<form id="advncfilter" method="get" class="{{ (@$filter_gender == null && @$filter_both == null && @$filter_all == null && @$filter_g_a == null && @$filter_g_s == null && @$filter_g_t_s == null && @$filter_g_a_s == null && @$filter_super == null && @$filter_empType == null && @$filter_e_a == null && @$filter_t_s == null && @$filter_t_a_s == null && @$filter_status == null && @$filter_age == null && @$filter_s_a == null) ? 'd-none' : '' }}">
	<div class="form-row">
		<div class="form-group col-md-2">
			<select name="filter_gender" id="" class="form-control">
				<option selected="true" disabled="True" value="">Filter by Gender:</option>
				<option {{ 
					(
						@$filter_gender == 0 && @$filter_gender != null 
						|| @$filter_both['gender'] == 0 && @$filter_both != null 
						|| @$filter_all['gender'] == 0 && @$filter_all != null 
						|| @$filter_g_a['gender'] == 0 && @$filter_g_a != null 
						|| @$filter_g_s['gender'] == 0 && @$filter_g_s != null
						|| @$filter_g_t_s['gender'] == 0 && @$filter_g_t_s != null
						|| @$filter_g_a_s['gender'] == 0 && @$filter_g_a_s != null
						|| @$filter_super['gender'] == 0 && @$filter_super != null
					) 
					? 'selected' : '' 
				}} value="0">Male</option>
				<option {{ 
					(
						@$filter_gender == 1 && @$filter_gender != null 
						|| @$filter_both['gender'] == 1 && @$filter_both != null 
						|| @$filter_all['gender'] == 1 && @$filter_all != null 
						|| @$filter_g_a['gender'] == 1 && @$filter_g_a != null 
						|| @$filter_g_s['gender'] == 1 && @$filter_g_s != null
						|| @$filter_g_t_s['gender'] == 1 && @$filter_g_t_s != null
						|| @$filter_g_a_s['gender'] == 1 && @$filter_g_a_s != null
						|| @$filter_super['gender'] == 1 && @$filter_super != null
					) 
					? 'selected' : '' 
				}} value="1">Female</option>
			</select>
		</div>
		<div class="form-group col-md-2">
			<select name="filter_empType" id="" class="form-control">
				<option selected="true" disabled="True" value="">Filter by Employee Type:</option>
				<option {{ 
					(
						@$filter_empType == 0 && @$filter_empType != null 
						|| @$filter_both['type'] == 0 && @$filter_both != null 
						|| @$filter_all['type'] == 0 && @$filter_all != null 
						|| @$filter_e_a['type'] == 0 && @$filter_e_a != null 
						|| @$filter_t_s['type'] == 0 && @$filter_t_s != null
						|| @$filter_g_t_s['type'] == 0 && @$filter_g_t_s != null
						|| @$filter_t_a_s['type'] == 0 && @$filter_t_a_s != null
						|| @$filter_super['type'] == 0 && @$filter_super != null
					) 
					? 'selected' : '' }} value="0">Probationary Employees</option>
				<option {{ 
					(
						@$filter_empType == 1 && @$filter_empType != null 
						|| @$filter_both['type'] == 1 && @$filter_both != null 
						|| @$filter_all['type'] == 1 && @$filter_all != null 
						|| @$filter_e_a['type'] == 1 && @$filter_e_a != null 
						|| @$filter_t_s['type'] == 1 && @$filter_t_s != null
						|| @$filter_g_t_s['type'] == 1 && @$filter_g_t_s != null
						|| @$filter_t_a_s['type'] == 1 && @$filter_t_a_s != null
						|| @$filter_super['type'] == 1 && @$filter_super != null
					) 
					? 'selected' : '' 
				}} value="1">Regular Employees</option>
			</select>
		</div>
		<div class="form-group col-md-2">
			<select name="filter_age" id="" class="form-control">
				<option selected="true" disabled="True" value="">Filter by Age:</option>
				@foreach ($emp_age->unique('age') as $ea)
					<option {{ 
						(
							@$filter_age == $ea->age && @$filter_age != null 
							|| @$filter_all['age'] == $ea->age && @$filter_all != null 
							|| @$filter_g_a['age'] == $ea->age && @$filter_g_a != null 
							|| @$filter_e_a['age'] == $ea->age && @$filter_e_a != null
							|| @$filter_s_a['age'] == $ea->age && @$filter_s_a != null
							|| @$filter_t_a_s['age'] == $ea->age && @$filter_t_a_s != null
							|| @$filter_g_a_s['age'] == $ea->age && @$filter_g_a_s != null
							|| @$filter_super['age'] == $ea->age && @$filter_super != null
						) 
						? 'selected' : '' 
					}} value="{{ $ea->age }}">{{ $ea->age }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-md-2">
			<select name="filter_status" id="" class="form-control">
				<option value="" selected disabled="">Civil Status</option>
				<option {{ 
					(
						@$filter_status == 'single' && @$filter_status != null 
						|| @$filter_g_s['status'] == 'single' && @$filter_g_s != null 
						|| @$filter_t_s['status'] == 'single' && @$filter_t_s != null 
						|| @$filter_s_a['status'] == 'single' && @$filter_s_a != null
						|| @$filter_g_t_s['status'] == 'single' && @$filter_g_t_s != null
						|| @$filter_t_a_s['status'] == 'single' && @$filter_t_a_s != null
						|| @$filter_g_a_s['status'] == 'single' && @$filter_g_a_s != null
						|| @$filter_super['status'] == 'single' && @$filter_super != null
					) 
					? 'Selected' : '' 
				}} value="single">Single</option>

				<option {{ 
					(
						@$filter_status == 'married' && @$filter_status != null 
						|| @$filter_g_s['status'] == 'married' && @$filter_g_s != null 
						|| @$filter_t_s['status'] == 'married' && @$filter_t_s != null 
						|| @$filter_s_a['status'] == 'married' && @$filter_s_a != null
						|| @$filter_g_t_s['status'] == 'married' && @$filter_g_t_s != null
						|| @$filter_t_a_s['status'] == 'married' && @$filter_t_a_s != null
						|| @$filter_g_a_s['status'] == 'married' && @$filter_g_a_s != null
						|| @$filter_super['status'] == 'married' && @$filter_super != null
					) 
					? 'Selected' : '' 
				}} value="married">Married</option>

				<option {{ 
					(
						@$filter_status == 'widowed' && @$filter_status != null 
						|| @$filter_g_s['status'] == 'widowed' && @$filter_g_s != null 
						|| @$filter_t_s['status'] == 'widowed' && @$filter_t_s != null 
						|| @$filter_s_a['status'] == 'widowed' && @$filter_s_a != null
						|| @$filter_g_t_s['status'] == 'widowed' && @$filter_g_t_s != null
						|| @$filter_t_a_s['status'] == 'widowed' && @$filter_t_a_s != null
						|| @$filter_g_a_s['status'] == 'widowed' && @$filter_g_a_s != null
						|| @$filter_super['status'] == 'widowed' && @$filter_super != null
					) 
					? 'Selected' : '' 
				}} value="widowed">Widowed</option>

				<option {{ 
					(
						@$filter_status == 'divorced' && @$filter_status != null 
						|| @$filter_g_s['status'] == 'divorced' && @$filter_g_s != null 
						|| @$filter_t_s['status'] == 'divorced' && @$filter_t_s != null 
						|| @$filter_s_a['status'] == 'divorced' && @$filter_s_a != null
						|| @$filter_g_t_s['status'] == 'divorced' && @$filter_g_t_s != null
						|| @$filter_t_a_s['status'] == 'divorced' && @$filter_t_a_s != null
						|| @$filter_g_a_s['status'] == 'divorced' && @$filter_g_a_s != null
						|| @$filter_super['status'] == 'divorced' && @$filter_super != null
					) 
					? 'Selected' : '' 
				}} value="divorced">Divorced</option>

				<option {{ 
					(
						@$filter_status == 'separated' && @$filter_status != null 
						|| @$filter_g_s['status'] == 'separated' && @$filter_g_s != null 
						|| @$filter_t_s['status'] == 'separated' && @$filter_t_s != null 
						|| @$filter_s_a['status'] == 'separated' && @$filter_s_a != null
						|| @$filter_g_t_s['status'] == 'separated' && @$filter_g_t_s != null
						|| @$filter_t_a_s['status'] == 'separated' && @$filter_t_a_s != null
						|| @$filter_g_a_s['status'] == 'separated' && @$filter_g_a_s != null
						|| @$filter_super['status'] == 'separated' && @$filter_super != null
					) 
					? 'Selected' : '' 
				}} value="separated">Separated</option>
			</select>
		</div>
		<div class="form-group col-md-1 d-inline-flex">
			<button type="submit" class="btn btn-success mr-2">Filter</button>
			<a href="{{ route('hr.employees') }}" class="btn btn-info text-white">Clear</a>
		</div>
	</div>
</form>

<div class="card mb-5">
	<div class="card-body">
		<div class="table-responsive">
			<table id="empTable" class="table table-hover">
				<thead class="thead-dark">
					<th>Employee No.</th>
					<th>Name</th>
					<th>Department - Position</th>
					<th>Action</th>
				</thead>
				<tbody>

					<div id="empCount"></div>

					@forelse ($employees as $employee)
						@if (@$filter_age != NULL && @$employee->age == @$filter_age)
							<tr id="empRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
								<td> <a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i>View</a></td>
							</tr>
						@elseif (@$filter_all != NULL && @$employee->age == @$filter_all['age'])
							<tr id="empRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
								<td> <a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i>View</a></td>
							</tr>
						@elseif (@$filter_g_a != NULL && @$employee->age == @$filter_g_a['age'])
							<tr id="empRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
								<td> <a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i>View</a></td>
							</tr>
						@elseif (@$filter_e_a != NULL && @$employee->age == @$filter_e_a['age'])
							<tr id="empRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
								<td> <a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i>View</a></td>
							</tr>
						@elseif (@$filter_s_a != NULL && @$employee->age == @$filter_s_a['age'] && @$employee->civil_status == @$filter_s_a['status'])
							<tr id="empRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
								<td> <a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i>View</a></td>
							</tr>
						@elseif (@$filter_t_a_s != NULL && @$employee->age == @$filter_t_a_s['age'])
							<tr id="empRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
								<td> <a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i>View</a></td>
							</tr>
						@elseif (@$filter_g_a_s != NULL && @$employee->age == @$filter_g_a_s['age'])
							<tr id="empRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
								<td> <a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i>View</a></td>
							</tr>
						@elseif (@$filter_super != NULL && @$employee->age == @$filter_super['age'])
							<tr id="empRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
								<td> <a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i>View</a></td>
							</tr>
						@elseif (@$filter_age == NULL && @$filter_all == NULL && @$filter_g_a == NULL && @$filter_e_a == NULL && @$filter_s_a == NULL && @$filter_t_a_s == NULL && @$filter_g_a_s == NULL && @$filter_super == NULL)
							<tr id="empRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
								<td> <a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i>View</a></td>
							</tr>
						@endif

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
<div id="forPRNT" class="d-none">
	@php
		echo $print;
	@endphp
</div>
<script type="application/javascript">

	function clicked(){
		var iframe = document.getElementById('printable');
		var WinPrint = window.open('', '', 'left=0,top=0,width=1600,height=1800,toolbar=0,scrollbars=0,status=0');
		WinPrint.document.write('<html><head>'+'</head><body>'+iframe.innerHTML+'</body></html>');
		WinPrint.document.close();
		WinPrint.focus();
		WinPrint.print();
		WinPrint.close();
	}

	jQuery(document).ready(function($){
		var countTR = $("#prntEmpCount tbody #prntEmpRow").length;
		$("#empCount").append('<span class="font-weight-bold">Result: '+ countTR +'</span>');
	});

</script>

@endsection