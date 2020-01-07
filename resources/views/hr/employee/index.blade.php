@extends('layouts.app')
@section('title', '| All Employee')
@section('employees', 'active')
{{-- @section('dash-title', 'All Employees') --}}

@section('heading-title')
	<i class="fas fas fa-users text-secondary"></i> All Employees
@endsection
@section('dash-content')

{{-- <a href="{{ route('print.emp') }}" class="btn btn-outline-info float-right" target="_blank">Print</a> --}}
<div class="zp-filters">
	<div class="row">
		<div class="col-12 col-md-6">
			<form method="get">
				<div class="form-row">
					<div class="form-group col-12 col-md-8">
				        <div class="input-group">
				            <input type="search" name="search" class="form-control" value="{{ (!empty($search)) ? $search : '' }}" placeholder="Search for Employee">
				            <div class="input-group-append">
				                <button type="submit" class="btn btn-success mr-2">Search</button>
				                <a href="{{ route('hr.employees') }}" class="btn btn-info text-white">Clear</a>
				            </div>
				        </div>
					</div>
				</div>
			</form>
		</div>
		<div class="col-12 col-md-6 text-right">
			<!--- PRINT --->
			<div class="form-group">
				<button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">PRINT <span class="caret"></span>
				</button>
				@php 
					$filter_age = app('request')->input('filter_age');
					$filter_gender = app('request')->input('filter_gender');
					$filter_empType = app('request')->input('filter_empType');
					$filter_status = app('request')->input('filter_status');  
					
					if($filter_gender != null){
					    $gender = (app('request')->input('filter_gender') == 0) ? "male": "female";
					}
					if($filter_empType != null){
					    $emptype = (app('request')->input('filter_empType') == 0) ? "probationary" : "regular"; 
					}

					if($filter_age != null && $filter_gender != null && $filter_empType != null && $filter_status != null ){
					    $fileName = 'employee-'.$gender.'-'.$emptype.'-'.$filter_age.'-'.ucwords($filter_status);
					}elseif($filter_age != null && $filter_gender != null && $filter_empType != null ){
					     $fileName = 'employee-'.$gender.'-'.$filter_age.'-'.ucwords($filter_status);
					}elseif($filter_age != null && $filter_gender != null && $filter_status != null ){
					     $fileName = 'employee-'.$gender.'-'.$filter_age.'-'.ucwords($filter_status);
					}elseif($filter_age != null && $filter_empType != null && $filter_status != null ){
					     $fileName = 'employee-'.$filter_age.'-'.$emptype.'-'.ucwords($filter_status);
					}elseif($filter_gender != null && $filter_empType != null && $filter_status != null ){
					     $fileName = 'employee-'.$gender.'-'.$emptype.'-'.ucwords($filter_status);
					}elseif($filter_gender != null && $filter_empType != null){
					     $fileName = 'employee-'.$gender.'-'.$emptype; 
					}elseif($filter_gender != null && $filter_status != null){
					     $fileName = 'employee-'.$gender.'-'.ucwords($filter_status);
					}elseif($filter_age != null && $filter_gender != null){
					     $fileName = 'employee-'.$gender.'-'.$filter_age; 
					}elseif($filter_age != null && $filter_empType != null){
					     $fileName = 'employee-'.$filter_age.'-'.$emptype; 
					}elseif($filter_age != null && $filter_status != null){
					     $fileName = 'employee-'.$filter_age.'-'.ucwords($filter_status);
					}elseif($filter_age != null){
					     $fileName = 'employee-'.$filter_age;
					}elseif($filter_gender != null){
					     $fileName = 'employee-'.$gender; 
					}elseif($filter_empType != null){
					     $fileName = 'employee-'.$emptype; 
					}elseif($filter_status != null){
					     $fileName = 'employee-'.ucwords($filter_status);
					}elseif(@$request->search != null){
					     $fileName = 'employee-'.@$request->search; 
					}else{
					    $fileName ='employee';
					} 
				@endphp
				
				<div id="printbtndiv" class="dropdown-menu print_dropdown">
					<a href="#" class="btnPrint dropdown-item"><i class="fas fa-print text-secondary"></i> PRINT</a>
					<a href="{{ asset('storage/uploaded/print/employees/'.$fileName.'.csv')}}" class="dropdown-item" download="{{ $fileName.'.csv'}}" target="_blank"><i class="fas fa-file-csv text-secondary"></i> CSV</a>
				</div>
			</div>
		</div>
	</div>
</div>

<span id="showFilter" class="text-secondary font-weight-bold mb-3 d-inline-block" style="cursor: pointer;">Advanced filter <i class="fas fa-user-cog"></i></span>
<form id="advncfilter" method="get" class="{{ (@$filter_gender == null && @$filter_both == null && @$filter_all == null && @$filter_g_a == null && @$filter_g_s == null && @$filter_g_t_s == null && @$filter_g_a_s == null && @$filter_super == null && @$filter_empType == null && @$filter_e_a == null && @$filter_t_s == null && @$filter_t_a_s == null && @$filter_status == null && @$filter_age == null && @$filter_s_a == null) ? 'd-none' : '' }}">
	<div class="form-row mb-2">
		<div class="form-group col-md-2 position-relative">
			<select name="filter_gender" id="gender" class="form-control">
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
			<span id="clear_gender" class="d-none font-weight-bold zp-filter-clear" ><i class="fas fa-times"></i></span>
		</div>
		<div class="form-group col-md-2 position-relative">
			<select name="filter_empType" id="typeOfEmp" class="form-control">
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
			<span id="clear_type" class="d-none font-weight-bold zp-filter-clear"><i class="fas fa-times"></i></span>
		</div>
		<div class="form-group col-md-2 position-relative">
			<select name="filter_age" id="age" class="form-control">
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
			<span id="clear_age" class="d-none font-weight-bold zp-filter-clear"><i class="fas fa-times"></i></span>
		</div>
		<div class="form-group col-md-2 position-relative">
			<select name="filter_status" id="civil_status" class="form-control">
				<option value="" selected disabled="">Filter by Civil Status:</option>
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
			<span id="clear_status" class="d-none font-weight-bold zp-filter-clear"><i class="fas fa-times"></i></span>
		</div>
		<div class="form-group col-md-1 d-inline-flex">
			<button type="submit" class="btn btn-success mr-2">Filter</button>
			<a href="{{ route('hr.employees') }}" class="btn btn-info text-white">Clear</a>
		</div>
	</div>
</form>

<div class="card mb-3">
	<div class="card-body">
		<div id="empCount"  class="zp-countable"></div>
		<div class="table-responsive">
			<table id="empTable" class="table table-hover">
				<thead class="thead-dark">
					<th width="10%">Employee No.</th>
					<th>Name</th>
					<th width="20%">Department - Position</th>
				</thead>
				<tbody>
					@forelse ($employees as $employee)
						@if(@$filter_search != null)
							<tr id="empRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }}, {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}
									<div class="row-actions"><a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i> View</a></div></td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_age != NULL && @$employee->age == @$filter_age)
							<tr id="empRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }}, {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}
									<div class="row-actions"><a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i> View</a></div></td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_all != NULL && @$employee->age == @$filter_all['age'])
							<tr id="empRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }}, {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}
									<div class="row-actions"><a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i> View</a></div></td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_g_a != NULL && @$employee->age == @$filter_g_a['age'])
							<tr id="empRow">

								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }}, {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}
									<div class="row-actions"><a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i> View</a></div></td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_e_a != NULL && @$employee->age == @$filter_e_a['age'])
							<tr id="empRow">

								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }}, {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}
									<div class="row-actions"><a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i> View</a></div></td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_s_a != NULL && @$employee->age == @$filter_s_a['age'] && @$employee->civil_status == @$filter_s_a['status'])
							<tr id="empRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }}, {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}
									<div class="row-actions"><a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i> View</a></div></td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_t_a_s != NULL && @$employee->age == @$filter_t_a_s['age'])
							<tr id="empRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }}, {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}
									<div class="row-actions"><a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i> View</a></div></td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_g_a_s != NULL && @$employee->age == @$filter_g_a_s['age'])
							<tr id="empRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }}, {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}
									<div class="row-actions"><a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i> View</a></div></td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_super != NULL && @$employee->age == @$filter_super['age'])
							<tr id="empRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }}, {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}
									<div class="row-actions"><a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i> View</a></div></td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_age == NULL && @$filter_all == NULL && @$filter_g_a == NULL && @$filter_e_a == NULL && @$filter_s_a == NULL && @$filter_t_a_s == NULL && @$filter_g_a_s == NULL && @$filter_super == NULL)
							<tr id="empRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }}, {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}
									<div class="row-actions"><a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i> View</a></div></td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@else
								@if ($loop->first) 
								 <tr>
									<td colspan="3" class="text-center">{{ "0 Matches Found!" }}</td>
								 </tr>
								@endif
						@endif

						@empty
							<tr>
								<td colspan="3" class="text-center">{{ "0 Matches Found!" }}</td>
							</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="pagination-wrap">{{ $employees->links() }}</div>
<div id="forPRNT" class="d-none">
	@php
		echo $print;
	@endphp
</div>

@endsection

@section('scripts')
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

		jQuery(window).on('hashchange', function(e){
		    history.replaceState ("", document.title, e.originalEvent.oldURL);
		});

		var countTR = $("#prntEmpCount tbody #prntEmpRow").length;
		$("#empCount").html('');
		$("#empCount").append('<p class="count_items"><span class="zp-tct">Total Items: </span>'+ countTR +' <span  class="zp-ct"> Items</span></p>');

		$('.btnPrint').printPage({ 
			attr: "href",
			url: "{{ asset('storage/uploaded/print/employees/employee-print.html') }}",
			message:"Your document is being created",
		});

		var countTR2 = $("#prntEmpCount tbody #prntEmpRow").length;
		$("#prntEmpRslt").html('');
		$("#prntEmpRslt").append('<p class="font-weight-bold zp-2a9" style="font-family: arial; font-size: 10px; color: #212529;">Total number of employees: '+ countTR2 +'</p>');

		/**for-addition-of-class-apperance*/
		zpApperanceClass('gender');
		zpApperanceClass('typeOfEmp');
		zpApperanceClass('age');
		zpApperanceClass('civil_status');
		
		/**for-remove-of-class-added*/
		zpRemoveClass('gender','gender');
		zpRemoveClass('type','typeOfEmp');
		zpRemoveClass('age','age');
		zpRemoveClass('status','civil_status');
	});

	/**adding-of-class*/
	const zpApperanceClass = (param) => {
		jQuery('#' + param).on('change', function(){
			$(this).addClass('apperance-none');
		});
	}
	
	/**Remover-of-class*/
	const zpRemoveClass = (param1,param2) => {
		jQuery('#clear_' + param1).on('click', function(){
			$('#' + param2).removeClass('apperance-none');
		});
	}

</script>
@endsection