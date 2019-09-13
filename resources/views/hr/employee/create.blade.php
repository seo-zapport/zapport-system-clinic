@extends('layouts.app')
@section('title', '| Add Employee')
@section('reg_emp', 'active')
{{-- @section('dash-title', 'Add Employee') --}}
@section('heading-title')
	<i class="fas fa-user-plus"></i> Add Employee
@endsection
@section('dash-content')

<div class="card">
	<div class="card-body">
		<form id="empForm" enctype="multipart/form-data" method="post" action="@yield('action', route('hr.emp.addEmp'))">
			@csrf
			@yield('editMethod')
			<h3>Employees Information</h3>
			<hr>
			<div class="form-row">
				<div class="form-group col-md-3">
					<label for="emp_id">Employee ID <span id="emp_id_warning" class="text-danger d-none">is already taken</span></label>
					<input type="text" name="emp_id" value="@yield('editEmpID', old('emp_id'))" class="form-control" placeholder="Employee ID" required oninvalid="this.setCustomValidity('Please Enter Employee ID')"
	 oninput="setCustomValidity('')">
				</div>

				@if (substr(url()->current(), 27) == 'create')
					<div class="form-group col-md-3">
						<label for="department_id">Department</label>
						<select name="department_id" id="department_id" class="form-control" required>
							<option selected="true" disabled="disabled" value=""> Select Department </option>
							@foreach ($departments as $department)
								<option value="{{ $department->id }}">{{ $department->department }}</option>
							@endforeach
						</select>
					</div>
			
					<div class="form-group col-md-3">
						<label for="position">Position</label>
						<select name="position_id" id="position_id" class="form-control" required>
							<option selected="true" disabled="disabled" value=""> Select Posotion </option>
						</select>
					</div>
					@else
						@yield('editDept')
				@endif

				<div class="form-group col-md-3">
					<label for="hired_date">Hired Date</label>
					<input type="date" name="hired_date" value="@yield('editHiredDate', old('hired_date'))" class="form-control" placeholder="Employee's Hired Date" required>
				</div>

			</div>
			<hr>
			<h3>Personal Information</h3>
			<hr>
			<div class="form-row">
				<div class="form-group">
					@yield('img')
					<input type="file" name="profile_img" class="form-control-file">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="first_name">First Name</label>
					<input type="text" name="first_name" value="@yield('editFname', old('first_name'))" class="form-control" placeholder="First Name" required oninvalid="this.setCustomValidity('Please Enter First Name')" oninput="setCustomValidity('')">
				</div>
				<div class="form-group col-md-4">
					<label for="last_name">Last Name</label>
					<input type="text" name="last_name" value="@yield('editLname', old('last_name'))" class="form-control" placeholder="Last Name" required oninvalid="this.setCustomValidity('Please Enter Last Name')" oninput="setCustomValidity('')">
				</div>
				<div class="form-group col-md-4">
					<label for="middle_name">Middle Name</label>
					<input type="text" name="middle_name" value="@yield('editMname', old('middle_name'))" class="form-control" placeholder="Middle Name" required oninvalid="this.setCustomValidity('Please Enter Last Name')" oninput="setCustomValidity('')">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="present_address">Present Address</label>
					<input type="text" name="present_address" value="@yield('editPresentAddress', old('present_address'))" class="form-control" placeholder="Present Address" required oninvalid="this.setCustomValidity('Please Enter Present Address')" oninput="setCustomValidity('')">
				</div>
				<div class="form-group col-md-4">
					<label for="permanent_address">Permanent Address</label>
					<input type="text" name="permanent_address" value="@yield('editPermanentAddress', old('permanent_address'))" class="form-control" placeholder="Permanent Address" required oninvalid="this.setCustomValidity('Please Enter Permanent Address')" oninput="setCustomValidity('')">
				</div>

				<div class="form-group col-md-2">
					<label for="contact">contact</label>
					<input type="number" name="contact" value="@yield('editContact', old('contact'))" class="form-control" placeholder="Contact Number" required oninvalid="this.setCustomValidity('Please Enter Contact Number')" oninput="setCustomValidity('')">
				</div>
			</div>

			<hr>
			<h3>Education</h3>
			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="college">Tertiary / College</label>
					<input type="text" name="college" value="@yield('editCollege', old('college'))" class="form-control" placeholder="Tertiary / College">
				</div>
				<div class="form-group col-md-4">
					<label for="college_grad_date">Year Graduated</label>
					<input type="date" name="college_grad_date" value="@yield('editCollegeGrad', old('college_grad_date'))" class="form-control">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="highschool">Secondary / High School</label>
					<input type="text" name="highschool" value="@yield('editHighschool', old('highschool'))" class="form-control" placeholder="Secondary / High School" required oninvalid="this.setCustomValidity('Please Enter Secondary Education')" oninput="setCustomValidity('')">
				</div>
				<div class="form-group col-md-4">
					<label for="highschool_grad_date">Year Graduated</label>
					<input type="date" name="highschool_grad_date" value="@yield('editHighschoolGrad', old('highschool_grad_date'))" class="form-control" required oninvalid="this.setCustomValidity('Please Enter Year Graduated')" oninput="setCustomValidity('')">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="elementary">Primary / Elementary</label>
					<input type="text" name="elementary" value="@yield('editElementary', old('elementary'))" class="form-control" placeholder="Primary / Elementary" required oninvalid="this.setCustomValidity('Please Enter Primary Education')" oninput="setCustomValidity('')">
				</div>
				<div class="form-group col-md-4">
					<label for="elementary_grad_date">Year Graduated</label>
					<input type="date" name="elementary_grad_date" value="@yield('editElementaryGrad', old('elementary_grad_date'))" class="form-control" required oninvalid="this.setCustomValidity('Please Enter Year Graduated')" oninput="setCustomValidity('')">
				</div>
			</div>

			<hr>
			<h3>Work Experience(s)</h3>
			@if(substr(url()->current(),27) =="create")
			<a id="addWork" class="btn btn-success text-white mb-2"><i class="fa fa-plus"></i> Add more Work Experience</a>
			<div class="form-row">
			<div id="work" class="form-row align-items-center">
				<div class="col-auto my-1 form-inline">
					{{-- <div class="form-group col-md-4"> --}}
						<label for="experience" class="mr-2">Name of Company</label>
						<input type="text" class="form-control mr-2" name="experience[0][]" placeholder="Name of Company">
					{{-- </div> --}}
					{{-- <div class="form-group col-md-4"> --}}
						<label for="experience" class="mr-2">Position</label>
						<input type="text" class="form-control mr-2" name="experience[0][]" placeholder="Position">
					{{-- </div> --}}
					{{-- <div class="form-group col-md-4"> --}}
						<label for="experience" class="mr-2">Period Covered</label>
						<input type="date" class="form-control " name="experience[0][]">
					{{-- </div> --}}
					{{-- <div class="form-group col-md-4"> --}}
						<label for="experience" class="ml-2 mr-2">To</label>
						<input type="date" class="form-control " name="experience[0][]">
					{{-- </div> --}}
				</div>
			</div>
			</div>
			@else
			    @yield('editExp')
			@endif	

			<hr>
			<h3>Personal Data</h3>
			<hr>
			<div class="form-row">
				<div class="form-group col-md-2">
					<label for="birthday">Birthday</label>
					<input type="date" name="birthday" value="@yield('editBday', old('birthday'))" class="form-control" required oninvalid="this.setCustomValidity('Please Enter Birthday')" oninput="setCustomValidity('')">
				</div>
				<div class="form-group col-md-4">
					<label for="birth_place">Birth Place</label>
					<input type="text" name="birth_place" value="@yield('editBplace', old('birth_place'))" class="form-control" placeholder="Birth Place" required oninvalid="this.setCustomValidity('Please Enter Birth Place')" oninput="setCustomValidity('')">
				</div>

				@if (substr(url()->current(), 27) == 'create')
					<div class="form-group col-md-2">
						<label for="birth_place">Gender</label>
						<select name="gender" id="gender" class="form-control" required oninvalid="this.setCustomValidity('Please Select Gender')" oninput="setCustomValidity('')">
							<option value="" selected disabled="">Gender</option>
							<option value="0">Male</option>
							<option value="1">Female</option>
						</select>
					</div>
				@else
					@yield('editGender')
				@endif
				<div class="form-group col-md-2">
					<label for="height">Height</label>
					<input type="text" name="height" value="@yield('editHeight', old('height'))" class="form-control" placeholder="Height" required oninvalid="this.setCustomValidity('Please Enter Height')" oninput="setCustomValidity('')">
				</div>
				<div class="form-group col-md-2">
					<label for="weight">Weight</label>
					<input type="text" name="weight" value="@yield('editWeight', old('weight'))" class="form-control" placeholder="Weight" required oninvalid="this.setCustomValidity('Please Enter Weight')" oninput="setCustomValidity('')">
				</div>
			</div>

			<div class="form-row">
				@if (substr(url()->current(), 27) == 'create')
					<div class="form-group col-md-2">
						<label for="civil_status">Civil Status</label>
						<select name="civil_status" id="civil_status" class="form-control" required oninvalid="this.setCustomValidity('Please Select Civil Status')" oninput="setCustomValidity('')">
							<option value="" selected disabled="">Civil Status</option>
							<option value="single">Single</option>
							<option value="married">Married</option>
							<option value="widowed">Widowed</option>
							<option value="divorced">Divorced</option>
							<option value="separated">Separated</option>
						</select>
					</div>
					@else
						@yield('editCivilStats')
				@endif

				<div class="form-group col-md-2">
					<label for="citizenship">Citizenship</label>
					<input type="text" name="citizenship" value="@yield('editNationality', old('citizenship'))" class="form-control" placeholder="Citizenship" required oninvalid="this.setCustomValidity('Please Enter Citizenship')" oninput="setCustomValidity('')">
				</div>
				<div class="form-group col-md-2">
					<label for="religion">Religion</label>
					<input type="text" name="religion" value="@yield('editReligion', old('religion'))" class="form-control" placeholder="Religion" required oninvalid="this.setCustomValidity('Please Enter Religion')" oninput="setCustomValidity('')">
				</div>
			</div>

			<hr>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="father_name">Father's Name</label>
					<input type="text" name="father_name" value="@yield('editFatherName', old('father_name'))" class="form-control" placeholder="Father's Name" required oninvalid="this.setCustomValidity('Please Enter Father\'s Name')" oninput="setCustomValidity('')">
				</div>
				<div class="form-group col-md-4">
					<label for="father_birthday">Father's Birthday</label>
					<input type="date" name="father_birthday" value="@yield('editFatherBday', old('father_birthday'))" class="form-control" required oninvalid="this.setCustomValidity('Please Enter Father\'s Birthday')" oninput="setCustomValidity('')">
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="mother_name">Mother's Name</label>
					<input type="text" name="mother_name" value="@yield('editMotherName', old('mother_name'))" class="form-control" placeholder="Mother's Name" required oninvalid="this.setCustomValidity('Please Enter Mother\'s Name')" oninput="setCustomValidity('')">
				</div>
				<div class="form-group col-md-4">
					<label for="mother_birthday">Mother's Birthday</label>
					<input type="date" name="mother_birthday" value="@yield('editMotherBday', old('mother_birthday'))" class="form-control" required oninvalid="this.setCustomValidity('Please Enter Mother\'s Birthday')" oninput="setCustomValidity('')">
				</div>
			</div>

			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="mother_name">Spouse Name</label>
					<input type="text" name="spouse_name" value="@yield('editSpouse', old('spouse_name'))" class="form-control" placeholder="Spouse Name">
				</div>
				<div class="form-group col-md-4">
					<label for="mother_birthday">Date of marriage</label>
					<input type="date" name="date_of_merriage" value="@yield('editMarriageDate', old('date_of_marriage'))" class="form-control">
				</div>
			</div>
			<hr>
			<h4>Add Children if any</h4>
			@if(substr(url()->current(),27) =="create")
			<a id="addChildren" class="btn btn-success text-white mb-2"><i class="fa fa-plus"></i> Add more children</a>
			<div class="form-row">
			<div id="children" class="form-row align-items-center">
				<div class="col-auto my-1 form-inline">
					{{-- <div class="form-group col-md-4"> --}}
						<label for="children" class="mr-2">Child's Name</label>
						<input type="text" class="form-control mr-2" name="children[0][]" placeholder="Children's Name">
					{{-- </div> --}}
					{{-- <div class="form-group col-md-4"> --}}
						<label for="children" class="mr-2">Birthday</label>
						<input type="date" class="form-control mr-2" name="children[0][]" placeholder="Add children description">
					{{-- </div> --}}
					{{-- <div class="form-group col-md-4"> --}}
						<label for="children" class="mr-2">Gender</label>
						<input type="text" class="form-control " name="children[0][]" placeholder="Gender">
					{{-- </div> --}}
				</div>
			</div>
			</div>
			@else
			    @yield('editChildren')
			@endif	

			<hr>
			<h3>Notify in case of emergency</h3>
			<hr>
			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="person_to_contact">Name</label>
					<input type="text" name="person_to_contact" value="@yield('editPersonContactName', old('person_to_contact'))" class="form-control" placeholder="Name" required oninvalid="this.setCustomValidity('Please Enter Name')" oninput="setCustomValidity('')">
				</div>
				<div class="form-group col-md-4">
					<label for="person_to_contact_address">Address</label>
					<input type="text" name="person_to_contact_address" value="@yield('editPersonContactAddress', old('person_to_contact_address'))" class="form-control" placeholder="Address" required oninvalid="this.setCustomValidity('Please Enter Address')" oninput="setCustomValidity('')">
				</div>
				<div class="form-group col-md-4">
					<label for="person_to_contact_number">Contact Number</label>
					<input type="number" name="person_to_contact_number" value="@yield('editPersonContactNumber', old('person_to_contact_number'))" class="form-control" placeholder="Contact Number" required oninvalid="this.setCustomValidity('Please Enter Contact Number')" oninput="setCustomValidity('')">
				</div>
			</div>
			<hr>
			<h3>Others</h3>
			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="tin_no">TIN Number</label>
					<input type="number" name="tin_no" value="@yield('editTin', old('tin_no'))" class="form-control" placeholder="TIN Number">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="sss_no">SSS Number</label>
					<input type="number" name="sss_no" value="@yield('editSSS', old('sss_no'))" class="form-control" placeholder="SSS Number">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="philhealth_no">Philhealth Number</label>
					<input type="number" name="philhealth_no" value="@yield('editPhilhealth', old('philhealth_no'))" class="form-control" placeholder="Philhealth Number">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="hdmf_no">HDMF Number</label>
					<input type="number" name="hdmf_no" value="@yield('editHdmf', old('hdmf_no'))" class="form-control" placeholder="HDMF Number">
				</div>
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
	</div>
</div>

	@include('layouts.errors')

<script type="application/javascript">
	jQuery(document).ready(function($) {
		$("#empForm input[name='emp_id']").on('change', function(){
			var empID = $(this).val();
			var url = 'create/EmpID/';
			if (empID) {
				$.ajax({
					url: url + empID,
					type: 'GET',
					dataType: "json",
					success:function(data){
						if (data > 0) {
							$("input[name='emp_id']").addClass('border border-danger');
							$("#emp_id_warning").removeClass('d-none')
						}else{
							$("input[name='emp_id']").removeClass('border border-danger');
							$("#emp_id_warning").addClass('d-none')
						}
					}
				});
			}else{
				$("input[name='emp_id']").removeClass('border border-danger');
				$("#emp_id_warning").addClass('d-none')
			}

		});
	});
</script>

@endsection