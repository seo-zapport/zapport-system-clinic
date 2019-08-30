@extends('hr.employee.create')
@section('title', '| Edit Employees Profile')
{{-- @section('employees', 'active') --}}
@section('dash-title', 'Edit Employees Profile')
@section('dash-content')

@section('action', route('hr.emp.store', ['employee' => $employee->id]))
@section('editMethod')
@method('PUT')
@endsection
@section('img')
@if (@$employee->profile_img != null)
	<img src="{{ asset('storage/uploaded/'.@$employee->profile_img) }}" alt="{{ @$employee->profile_img }}" class="img-fluid">
@endif
@endsection
@section('editFname', ucwords($employee->first_name))
@section('editLname', ucwords($employee->last_name))
@section('editMname', ucwords($employee->middle_name))
@section('editBday', $employee->birthday->format('Y-m-d'))
@section('editBplace', ucwords($employee->birth_place))
@section('editNationality', ucwords($employee->citizenship))
@section('editPresentAddress', ucwords($employee->present_address))
@section('editPermanentAddress', ucwords($employee->permanent_address))
@section('editContact', $employee->contact)
@section('editEmpID', $employee->emp_id)
@section('editTin', $employee->tin_no)
@section('editSSS', $employee->sss_no)
@section('editPhilhealth', $employee->philhealth_no)
@section('editHdmf', $employee->hdmf_no)
@section('editCollege', strtoupper($employee->college))
@section('editCollegeGrad', ($employee->college_grad_date != null) ? $employee->college_grad_date->format('Y-m-d') : $employee->college_grad_date)
@section('editHighschool', strtoupper($employee->highschool))
@section('editHighschoolGrad', $employee->highschool_grad_date->format('Y-m-d'))
@section('editElementary', strtoupper($employee->elementary))
@section('editElementaryGrad', $employee->elementary_grad_date->format('Y-m-d'))
@section('editHeight', $employee->height)
@section('editWeight', $employee->weight)
@section('editReligion', ucwords($employee->religion))
@section('editHiredDate', $employee->hired_date->format('Y-m-d'))

@section('editFatherName', ucwords($employee->father_name))
@section('editFatherBday', $employee->father_birthday->format('Y-m-d'))
@section('editMotherName', ucwords($employee->mother_name))
@section('editMotherBday', $employee->mother_birthday->format('Y-m-d'))
@section('editSpouse', ucwords($employee->spouse_name))
@section('editMarriageDate', ( $employee->date_of_marriage != null ) ? $employee->date_of_marriage->format('Y-m-d') : "")

@section('editPersonContactName', ucwords($employee->person_to_contact))
@section('editPersonContactAddress', ucwords($employee->person_to_contact_address))
@section('editPersonContactNumber', ucwords($employee->person_to_contact_number))

@section('editCivilStats')
	<div class="form-group col-md-2">
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
	<div class="form-group col-md-2">
		<label for="birth_place">Gender</label>
		<select name="gender" id="gender" class="form-control">
			<option value="{{ $employee->gender }}">{{ ($employee->gender == 0) ? "Male" : "Female" }}</option>
			<option value="0">Male</option>
			<option value="1">Female</option>
		</select>
	</div>
@endsection

@section('editDept')
	<div class="form-group col-md-3">
		<label for="department_id">Department</label>
		<select name="department_id" id="department_id" class="form-control">
			<option value="{{ $employee->department_id }}">{{ $employee->departments->department }}</option>
			@foreach ($uniqDep as $department)
				<option value="{{ $department->id }}">{{ $department->department }}</option>
			@endforeach
		</select>
	</div>
	<div class="form-group col-md-3">
		<label for="position">Position</label>
		<select name="position_id" id="position_id" class="form-control">
			<option value="{{ $employee->position_id }}">{{ $employee->positions->position }}</option>
			{{-- <option> Select Posotion </option> --}}
		</select>
	</div>
@endsection

@section('editExp')
	@php
		$arr = unserialize($employee->experience);
	@endphp
	<a id="editWork" class="btn btn-success text-white mb-2"><i class="fa fa-plus"></i> Add more Work Experience</a>
	<div class="form-row">
	<div id="work" class="form-row align-items-center">
		@php
		$i = 0;
		foreach ($arr as $exp) {
		@endphp
			<div id="workField" class="col-auto my-1 form-inline editwork">
				<label for="experience" class="mr-2">Name of Company</label>
				<input type="text" class="form-control mr-2" name="experience[@php echo $i; @endphp][]" placeholder="Name of Company" value="{{ $exp[0] }}">
				<label for="experience" class="mr-2">Position</label>
				<input type="text" class="form-control mr-2" name="experience[@php echo $i; @endphp][]" placeholder="Position" value="{{ $exp[1] }}">
				<label for="experience" class="mr-2">Period Covered</label>
				<input type="date" class="form-control mr-2" name="experience[@php echo $i; @endphp][]" value="{{ $exp[2] }}">
				<label for="experience" class="ml-2 mr-2">To</label>
				<input type="date" class="form-control ml-2 mr-2" name="experience[@php echo $i; @endphp][]" value="{{ $exp[3] }}">
				<a id="removeWork" class="btn btn-danger text-white"><i class="fa fa-times"></i></a>
			</div>
		@php
		$i++;
		}
		@endphp
	</div>
	</div>
@endsection


@section('editChildren')
	@php
		$arr = unserialize($employee->children);
	@endphp
	<a id="editChildren" class="btn btn-success text-white mb-2"><i class="fa fa-plus"></i> Add more children</a>
	<div class="form-row">
	<div id="children" class="form-row align-items-center">
		@php
		$e = 0;
		foreach ($arr as $child) {
		@endphp
			<div id="childrenField" class="col-auto my-1 form-inline editchildren">
				<label for="children" class="mr-2">Child's Name</label>
				<input type="text" class="form-control mr-2" name="children[@php echo $e; @endphp][]" placeholder="Child's Name" value="{{ $child[0] }}">
				<label for="children" class="mr-2">Birthday</label>
				<input type="date" class="form-control mr-2" name="children[@php echo $e; @endphp][]" value="{{ $child[1] }}">
				<label for="children" class="mr-2">Gender</label>
				<input type="text" class="form-control mr-2" name="children[@php echo $e; @endphp][]" placeholder="Gender" value="{{ $child[2] }}">
				<a id="removeChildren" class="btn btn-danger text-white"><i class="fa fa-times"></i></a>
			</div>
		@php
		$e++;
		}
		@endphp
	</div>
	</div>
@endsection