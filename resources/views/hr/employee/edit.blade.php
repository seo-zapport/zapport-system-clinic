@extends('hr.employee.create')
@section('title', 'Add Employee')
{{-- @section('employees', 'active') --}}
@section('dash-title', 'Edit Employees Profile')
@section('dash-content')

@section('action', route('hr.emp.store', ['employee' => $employee->id]))
@section('editMethod')
@method('PUT')
@endsection
@section('img')
<img src="{{ asset('storage/uploaded/'.@$employee->profile_img) }}" alt="{{ @$employee->profile_img }}" class="img-fluid">
@endsection
@section('editFname', ucwords($employee->first_name))
@section('editLname', ucwords($employee->last_name))
@section('editMname', ucwords($employee->middle_name))
@section('editBday', $employee->birthday->format('Y-m-d'))
@section('editBplace', ucwords($employee->birth_place))
@section('editNationality', ucwords($employee->nationality))
@section('editAddress', ucwords($employee->address))
@section('editContact', $employee->contact)
@section('editEmpID', $employee->emp_id)

@section('editCivilStats')
	<div class="form-group col-md-4">
		<label for="civil_status">Civil Status</label>
		<select name="civil_status" id="civil_status" class="form-control">
			<option value="{{ $employee->civil_status }}">{{ ucwords($employee->civil_status) }}</option>
			<option value="single">Single</option>
			<option value="married">Married</option>
			<option value="widowed">Widowed</option>
			<option value="divorced">Divorced</option>
			<option value="separated">Separated</option>
		</select>
	</div>
@endsection

@section('editGender')
	<div class="form-row">
		<div class="form-group col-md-4">
			<label for="birth_place">Gender</label>
			<select name="gender" id="gender" class="form-control">
				<option value="{{ $employee->gender }}">{{ ($employee->gender == 0) ? "Male" : "Female" }}</option>
				<option value="0">Male</option>
				<option value="1">Female</option>
			</select>
		</div>
	</div>
@endsection

@section('editDept')
	<div class="form-group col-md-4">
		<label for="department_id">Department</label>
		<select name="department_id" id="department_id" class="form-control">
			<option value="{{ $employee->department_id }}">{{ $employee->departments->department }}</option>
			@foreach ($uniqDep as $department)
				<option value="{{ $department->id }}">{{ $department->department }}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group col-md-4">
		<label for="position">Position</label>
		<select name="position_id" id="position_id" class="form-control">
			<option value="{{ $employee->position_id }}">{{ $employee->positions->position }}</option>
			{{-- <option> Select Posotion </option> --}}
		</select>
	</div>
@endsection