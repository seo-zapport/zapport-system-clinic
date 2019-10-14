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
	<div class="form-group col-md-1 d-inline-flex">
		<button type="button" id="printcsv" class="btn btn-success mr-2">Print</button>
	</div>
</form>
<form id="advncfilter" method="get">
	<p>Advanced filter</p>
	<div class="form-row">
		<div class="form-group col-md-2">
			<select name="filter_gender" id="" class="form-control">
				<option selected="true" disabled="True" value="">Filter by Gender:</option>
				<option {{ (@$filter_gender == 0 && @$filter_gender != null || @$filter_both['gender'] == 0 && @$filter_both != null || @$filter_all['gender'] == 0 && @$filter_all != null || @$filter_g_a['gender'] == 0 && @$filter_g_a != null) ? 'selected' : '' }} value="0">Male</option>
				<option {{ (@$filter_gender == 1 && @$filter_gender != null || @$filter_both['gender'] == 1 && @$filter_both != null || @$filter_all['gender'] == 1 && @$filter_all != null || @$filter_g_a['gender'] == 1 && @$filter_g_a != null) ? 'selected' : '' }} value="1">Female</option>
			</select>
		</div>
		<div class="form-group col-md-2">
			<select name="filter_empType" id="" class="form-control">
				<option selected="true" disabled="True" value="">Filter by Employee Type:</option>
				<option {{ (@$filter_empType == 0 && @$filter_empType != null || @$filter_both['type'] == 0 && @$filter_both != null || @$filter_all['type'] == 0 && @$filter_all != null || @$filter_e_a['type'] == 0 && @$filter_e_a != null) ? 'selected' : '' }} value="0">Probationary Employees</option>
				<option {{ (@$filter_empType == 1 && @$filter_empType != null || @$filter_both['type'] == 1 && @$filter_both != null || @$filter_all['type'] == 1 && @$filter_all != null || @$filter_e_a['type'] == 1 && @$filter_e_a != null) ? 'selected' : '' }} value="1">Regular Employees</option>
			</select>
		</div>
		<div class="form-group col-md-2">
			<select name="filter_age" id="" class="form-control">
				<option selected="true" disabled="True" value="">Filter by Age:</option>
				@foreach ($emp_age->unique('age') as $ea)
					<option {{ (@$filter_age == $ea->age && @$filter_age != null || @$filter_all['age'] == $ea->age && @$filter_all != null || @$filter_g_a['age'] == $ea->age && @$filter_g_a != null || @$filter_e_a['age'] == $ea->age && @$filter_e_a != null) ? 'selected' : '' }} value="{{ $ea->age }}">{{ $ea->age }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-md-1 d-inline-flex">
			<button type="submit" class="btn btn-success mr-2">Filter</button>
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
							<tr>
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
								<td> <a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i>View</a></td>
							</tr>
						@elseif (@$filter_all != NULL && @$employee->age == @$filter_all['age'])
							<tr>
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
								<td> <a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i>View</a></td>
							</tr>
						@elseif (@$filter_g_a != NULL && @$employee->age == @$filter_g_a['age'])
							<tr>
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
								<td> <a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i>View</a></td>
							</tr>
						@elseif (@$filter_e_a != NULL && @$employee->age == @$filter_e_a['age'])
							<tr>
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
								<td> <a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i>View</a></td>
							</tr>
						@elseif (@$filter_age == NULL && @$filter_all == NULL && @$filter_g_a == NULL && @$filter_e_a == NULL)
							<tr>
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
		WinPrint.document.write(iframe.innerHTML);
    	WinPrint.document.write('<link href="{{ asset('css/app.css') }}" rel="stylesheet">');
		WinPrint.document.close();
		WinPrint.focus();
		WinPrint.print();
		WinPrint.close();
	}

	jQuery(document).ready(function($){
		var countTR = $("#empTable tbody tr").length;
		$("#empCount").append('<span class="font-weight-bold">Result: '+ countTR +'</span>');
	});

</script>

<script type="application/javascript">
	jQuery(document).ready( function () {
		jQuery(document).on('click', '#printcsv', function(event){

	    	var type = "GET";
	    	var token = jQuery("input[name='_token']").val();

	    	var my_url =  '/printCsv';
	    	var eresult = 'All';

	    	var formData = {
	    	 	'gresult': eresult,
	    	 	'token' :  token,
	    	 }
		  	
		  	 console.log(formData);
		  	 console.log(my_url);

	    	$.ajax({
	    	    type: type,
	    	    url: my_url,
	    	    data: formData,
	    	    dataType: 'json',
	    	    success: function(data) {
		    	    if(data.success == true)
		   			{
		   				
		   			}         	   
	    	    },
	    	    error: function (xhr,textStatus,thrownError,data) {
	    	        console.log(xhr + "\n" + textStatus + "\n" + thrownError);
	                
	    	    }
	    	});
		});
	});
</script>

@endsection