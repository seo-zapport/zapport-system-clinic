@extends('layouts.app')
@section('title', '| Employees Profile')
@section('employees', 'active')
{{-- @section('dash-title', 'Employees Profile') --}}
@section('heading-title')
	<i class="fas fa-user-plus text-secondary"></i> Employee
@endsection
@section('dash-content')
@section('back')
<a href="{{ route('hr.employees') }}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection

<div class="row">
	<div class="col-12 col-lg-2">
		<div class="employee_wrap">
			<div class="panel employee-photo d-flex justify-content-center align-items-center">
				@if (@$employee->profile_img != null)
					<img src="{{ asset('storage/uploaded/'.@$employee->profile_img) }}" alt="{{ @$employee->profile_img }}" class="img-fluid" onerror="javascript:this.src='{{url( '/images/default.png' )}}'">
				@endif
				<div class="upload-hover d-flex justify-content-center align-items-center">
					<a href="{{ route('hr.emp.edit', ['employee' => @$employee->emp_id]) }}" class="d-block d-flex justify-content-center flex-column text-white">
						<i class="fas fa-camera-retro fa-lg mb-1"></i>
						<span clas>Edit picture</span>
					</a>
				</div>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-12">
				<label for="emp_id" class="text-muted">Employee ID</label>
				<p class="h5">{{ ucwords(@$employee->emp_id) }}</p>
			</div>
			<div class="form-group col-md-12">
				<label for="department_id" class="text-muted">Department</label>
				<p class="h5">{{ ucwords(@$employee->departments->department) }}</p>
			</div>
			<div class="form-group col-md-12">
				<label for="position" class="text-muted">Position</label>
				<p class="h5">{{ ucwords(@$employee->positions->position) }}</p>
			</div>
			<div class="form-group col-md-12">
				<label for="hired_date" class="text-muted">Hired Date</label>
				<p class="h5">{{ @$employee->hired_date->format('M d, Y') }} ( {{ @$employee->hired_date->diffForHumans() }} )</p>
			</div>
			<div class="form-group col-md-12">
				<label for="hired_date" class="text-muted">Employee Type</label>
				<p class="h5">{{ (@$employee->employee_type == 1) ? 'Regular Employee' : 'Probationary' }} </p>
			</div>
		</div>
	</div>
	<div class="col-12 col-lg-8">
		<div class="card mb-5 employee_wraps">
			<div class="card-body">
					<h5 class="text-muted"><i class="fas fa-user"></i> Personal Information</h5>
					<hr>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="first_name" class="text-muted">First Name</label>
							<p class="h5">{{ ucwords(@$employee->first_name) }}</p>
						</div>
						<div class="form-group col-md-4">
							<label for="last_name" class="text-muted">Last Name</label>
							<p class="h5">{{ ucwords(@$employee->last_name) }}</p>
						</div>
						<div class="form-group col-md-4">
							<label for="middle_name" class="text-muted">Middle Name</label>
							<p class="h5">{{ ucwords(@$employee->middle_name) }}</p>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-5">
							<label for="present_address" class="text-muted">Present Address</label>
							<p class="h5">{{ ucwords(@$employee->present_address) }}</p>
						</div>
						<div class="form-group col-md-5">
							<label for="permanent_address" class="text-muted">Permanent Address</label>
							<p class="h5">{{ ucwords(@$employee->permanent_address) }}</p>
						</div>
						<div class="form-group col-md-2">
							<label for="contact" class="text-muted">Contact</label>
							<p class="h5">{{ "+63" . @$employee->contact }}</p>
						</div>
					</div>

					<hr>
					<h5 class="text-muted"><i class="fas fa-user-graduate"></i> Education</h5>
					<hr>

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="college">Tertiary / College</label>
							<p class="h5">{{ strtoupper(@$employee->college) }}</p>
						</div>
						<div class="form-group col-md-4">
							<label for="course">Course</label>
							<p class="h5">{{ strtoupper(@$employee->course) }}</p>
						</div>
						<div class="form-group col-md-4">
							<label for="college_grad_date">Year Graduated</label>
							<p class="h5">{{ ($employee->college_grad_date != null) ? Carbon\carbon::parse($employee->college_grad_date)->format("M d, Y") : @$employee->college_grad_date }}</p>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="college">Tertiary / Highschool</label>
							<p class="h5">{{ strtoupper(@$employee->highschool) }}</p>
						</div>
						<div class="form-group col-md-6">
							<label for="highschool_grad_date">Year Graduated</label>
							<p class="h5">{{ @$employee->highschool_grad_date->format("M d, Y") }}</p>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="elementary">Primary / Elementary</label>
							<p class="h5">{{ strtoupper(@$employee->elementary) }}</p>
						</div>
						<div class="form-group col-md-6">
							<label for="elementary_grad_date">Year Graduated</label>
							<p class="h5">{{ @$employee->elementary_grad_date->format("M d, Y") }}</p>
						</div>
					</div>
					<hr>
					<h5 class="text-muted"><i class="fas fa-briefcase"></i> Work Experience(s)</h5>
					<hr>

					@php
						$arr = unserialize(@$employee->experience);
						if (!empty(@$arr)) {
							$count = count(@$arr);
						}
							if (!empty(@$arr)){
								foreach (@$arr as $exp){
					@endphp
						@if ($exp[0] != null && $exp[1] != null && $exp[2] != null && $exp[3] != null)
							<div class="form-row">
								<div class="col-12">
									<div class="form-row">
										<div class="form-group col-md-4">
											<label for="experience" class="mr-2">Name of Company</label>
											<p class="h5">{{ ucwords($exp[0]) }}</p>
										</div>
										<div class="form-group col-md-4">
											<label for="experience" class="mr-2">Position</label>
											<p class="h5">{{ ucwords($exp[1]) }}</p>
										</div>
										<div class="form-group col-md-4">
											<label for="experience" class="mr-2">Period Covered</label>
											<p class="h5"> {{ Carbon\carbon::parse($exp[2])->format('M d, Y') . " " . " to " . " " . Carbon\carbon::parse($exp[3])->format('M d, Y') }}</p>
										</div>
									</div>
								</div>
							</div>
						@else
						<p>None</p>
						@endif
							
							@php
							}
						}
					@endphp

					<hr>
					<h5 class="text-muted"><i class="fas fa-user"></i> Personal Data</h5>
					<hr>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="birthday">Birthday</label>
							<p class="h5">{{ @$employee->birthday->format('M d, Y') }}</p>
						</div>
						<div class="form-group col-md-4">
							<label for="birthday">Age</label>
							<p class="h5">{{ @$employee->age }}</p>
						</div>
						<div class="form-group col-md-4">
							<label for="birth_place">Birth Place</label>
							<p class="h5">{{ ucwords(@$employee->birth_place) }}</p>
						</div>
						<div class="form-group col-md-4">
							<label for="birth_place">Gender</label>
							<p class="h5">{{ (@$employee->gender == 0) ? "Male" : "Female" }}</p>
						</div>
						<div class="form-group col-md-4">
							<label for="height">Height</label>
							<p class="h5">{{ @$employee->height }}</p>
						</div>
						<div class="form-group col-md-4">
							<label for="weight">Weight</label>
							<p class="h5">{{ @$employee->weight }} kg.</p>
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="civil_status">Civil Status</label>
							<p class="h5">{{ ucwords(@$employee->civil_status) }}</p>
						</div>
						<div class="form-group col-md-4">
							<label for="citizenship">Citizenship</label>
							<p class="h5">{{ ucwords(@$employee->citizenship) }}</p>
						</div>
						<div class="form-group col-md-4">
							<label for="religion">Religion</label>
							<p class="h5">{{ ucwords(@$employee->religion) }}</p>
						</div>
						{{-- <div class="col-4"><p>Hired date: {{ @$employee->created_at->format('M d, Y') . " " ."( ".@$employee->created_at->diffForHumans()." )" }}</p></div> --}}
					</div>

					<hr>
					<div class="form-row">
						<div class="form-group col-md-8">
							<label for="father_name">Father's Name</label>
							<p class="h5">{{ ucwords(@$employee->father_name) }}</p>
						</div>
						<div class="form-group col-md-4">
							<label for="father_birthday">Father's Birthday</label>
							<p class="h5">{{ ucwords(@$employee->father_birthday->format('M d, Y')) }}</p>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-8">
							<label for="mother_name">Mother's Name</label>
							<p class="h5">{{ ucwords(@$employee->mother_name) }}</p>
						</div>
						<div class="form-group col-md-4">
							<label for="mother_birthday">Mother's Birthday</label>
							<p class="h5">{{ ucwords(@$employee->mother_birthday->format('M d, Y')) }}</p>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-8">
							<label for="spouse_name">Spouse Name</label>
							<p class="h5">{{ ( !empty(@$employee->spouse_name) ) ? ucwords(@$employee->spouse_name) : "None" }}</p>
						</div>
						<div class="form-group col-md-4">
							<label for="spouse_birthday">Date of marriage</label>
							<p class="h5">{{ ( !empty(@$employee->spouse_name) ) ? Carbon\carbon::parse(@$employee->date_of_marriage)->format('M d, Y') : "None" }}</p>
						</div>
					</div>

					@php
						$arr = unserialize(@$employee->children);
						if (!empty(@$arr)) {
							$count = count(@$arr);
						}
							if (!empty(@$arr)){
							@endphp

						<hr>
						<h5 class="text-muted"><i class="fas fa-users"></i> Add Children if any</h5>
						<hr>
						@php
								foreach (@$arr as $children){
									if (!empty($children[0])) {
					@endphp
							<div class="row">
								<div class="col-12 form-row">
									<div class="form-group col-md-4">
										<label for="children" class="mr-2">Child's Name</label>
										<p class="h5">{{ ucfirst($children[0]) }}</p>
									</div>
									<div class="form-group col-md-4">
										<label for="children" class="mr-2">Birthday</label>
										<p class="h5">{{ Carbon\carbon::parse($children[1])->format('M d, Y') }}</p>
									</div>
									<div class="form-group col-md-4">
										<label for="children" class="mr-2">Gender</label>
										<p class="h5">{{ ucfirst($children[2]) }}</p>
									</div>
								</div>
							</div>
							
								@php
								}
							}
						}
					@endphp

					<hr>
					<h5 class="text-muted"><i class="fas fa-bars"></i> Others</h5>
					<hr>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="tin_no" class="{{ (@$employee->tin_no == NULL) ? 'text-danger' : ''  }}">{{ (@$employee->tin_no == NULL) ? '*' : ''  }} TIN Number</label>
							<p class="h5">{{ @$employee->tin_no }}</p>
						</div>
						<div class="form-group col-md-6">
							<label for="sss_no" class="{{ (@$employee->tin_no == NULL) ? 'text-danger' : ''  }}">{{ (@$employee->tin_no == NULL) ? '*' : ''  }} SSS Number</label>
							<p class="h5">{{ @$employee->sss_no }}</p>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="philhealth_no" class="{{ (@$employee->tin_no == NULL) ? 'text-danger' : ''  }}">{{ (@$employee->tin_no == NULL) ? '*' : ''  }} Philhealth Number</label>
							<p class="h5">{{ @$employee->philhealth_no }}</p>
						</div>
						<div class="form-group col-md-6">
							<label for="hdmf_no" class="{{ (@$employee->tin_no == NULL) ? 'text-danger' : ''  }}">{{ (@$employee->tin_no == NULL) ? '*' : ''  }} HDMF Number</label>
							<p class="h5">{{ @$employee->hdmf_no }}</p>
						</div>
					</div>
					<hr>
					<div class="form-group text-right">
						<a href="#" id="btnPrint" class="btn btn-success text-white">Print</a>
						<a href="{{ route('hr.emp.edit', ['employee' => @$employee->emp_id]) }}" class="btn btn-info text-white">Edit</a>
					</div>

				
					<script type="application/javascript">

						jQuery(document).ready(function($){

							jQuery(window).on('hashchange', function(e){
							    history.replaceState ("", document.title, e.originalEvent.oldURL);
							});

							$('#btnPrint').printPage({ 
								attr: "href",
								url: "{{ asset('storage/uploaded/print/employees/printinfo.html') }}",
								message:"Your document is being created",
							});

						});

					</script>


				@endsection
			</div>
		</div>
	</div>
</div>




