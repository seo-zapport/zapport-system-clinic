@extends('layouts.app')
@section('title', '| Employees Profile')
@section('employees', 'active')
@section('dash-title', 'Employees Profile')
@section('dash-content')
@section('back')
<a href="{{ route('hr.employees') }}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection
@if (@$employee->profile_img != null)
	<img src="{{ asset('storage/uploaded/'.@$employee->profile_img) }}" alt="{{ @$employee->profile_img }}" class="img-fluid">
@endif
<hr>
<h3>Employees Info</h3>
<div class="row">
	<div class="col-3"><p>Employee ID: {{ ucwords(@$employee->emp_id) }}</p></div>
	<div class="col-3"><p>Department: {{ ucwords(@$employee->departments->department) }}</p></div>
	<div class="col-3"><p>Position: {{ ucwords(@$employee->positions->position) }}</p></div>
	<div class="col-3"><p>Hired Date: {{ @$employee->hired_date->format('M d, Y') }} ( {{ @$employee->hired_date->diffForHumans() }} )</p></div>
</div>
<hr>
<h3>Personal Info</h3>
<p>Name: {{ ucwords(@$employee->last_name) . " " . ucwords(@$employee->first_name) . " " .ucwords(@$employee->middle_name) }}</p>
<div class="row">
	<div class="col-4"><p>Birthday: {{ @$employee->birthday->format('M d, Y') }}</p></div>
	<div class="col-4"><p>Birth Place: {{ ucwords(@$employee->birth_place) }}</p></div>
	<div class="col-4"><p>Age: {{ @$employee->age }}</p></div>
	<div class="col-4"><p>Citizenship: {{ ucwords(@$employee->citizenship) }}</p></div>
	<div class="col-4"><p>Religion: {{ ucwords(@$employee->religion) }}</p></div>
	<div class="col-4"><p>Civil Status: {{ ucwords(@$employee->civil_status) }}</p></div>
	<div class="col-4"><p>Gender: {{ (@$employee->gender == 0) ? "Male" : "Female" }}</p></div>
	<div class="col-4"><p>Height: {{ @$employee->height }}</p></div>
	<div class="col-4"><p>Weight: {{ @$employee->weight }} kg.</p></div>
	<div class="col-4"><p>Contact: {{ "+63" . @$employee->contact }}</p></div>
	<div class="col-4"><p>Present Address: {{ ucwords(@$employee->present_address) }}</p></div>
	<div class="col-4"><p>Permanent Address: {{ ucwords(@$employee->permanent_address) }}</p></div>
	{{-- <div class="col-4"><p>Hired date: {{ @$employee->created_at->format('M d, Y') . " " ."( ".@$employee->created_at->diffForHumans()." )" }}</p></div> --}}
</div>
<hr>
<h4>Others</h4>
<div class="row">
	<div class="col-6"><p>Father's Name: {{ ucwords(@$employee->father_name) }}</p></div>
	<div class="col-6"><p>Birthday: {{ ucwords(@$employee->father_birthday->format('M d, Y')) }}</p></div>
	<div class="col-6"><p>Mother's Name: {{ ucwords(@$employee->mother_name) }}</p></div>
	<div class="col-6"><p>Birthday: {{ ucwords(@$employee->mother_birthday->format('M d, Y')) }}</p></div>
	<div class="col-6"><p>Spouse Name: {{ ( !empty(@$employee->spouse_name) ) ? ucwords(@$employee->spouse_name) : "None" }}</p></div>
	<div class="col-6"><p>Date of marriage: {{ ( !empty(@$employee->spouse_name) ) ? @$employee->date_of_merriage->format('M d, Y') : "None" }}</p></div>
</div>

@php
	$arr = unserialize(@$employee->children);
	if (!empty(@$arr)) {
		$count = count(@$arr);
	}
		if (!empty(@$arr)){
			foreach (@$arr as $children){
				if (!empty($children[0])) {
@endphp
		<div class="row">
			<div class="col-4"><p>Child's name: {{ $children[0] }}</p></div>
			<div class="col-4"><p>Birthday: {{ $children[1] }}</p></div>
			<div class="col-4"><p>Gender: {{ $children[2] }}</p></div>
		</div>
		
			@php
			}
		}
	}
@endphp

<hr>
<h3>Education</h3>
<div class="row">
	<div class="col-6"><p>Tertiary / College: {{ strtoupper(@$employee->college) }}</p></div>
	<div class="col-6"><p>Year Graduated: {{ ($employee->college_grad_date != null) ? Carbon\carbon::parse($employee->college_grad_date)->format("M d, Y") : @$employee->college_grad_date }}</p></div>
	<div class="col-6"><p>Secondary / Highschool: {{ strtoupper(@$employee->highschool) }}</p></div>
	<div class="col-6"><p>Year Graduated: {{ @$employee->highschool_grad_date->format("M d, Y") }}</p></div>
	<div class="col-6"><p>Primary / Elementary: {{ strtoupper(@$employee->elementary) }}</p></div>
	<div class="col-6"><p>Year Graduated: {{ @$employee->elementary_grad_date->format("M d, Y") }}</p></div>
</div>

<hr>
<h3>Work Experience</h3>
@php
	$arr = unserialize(@$employee->experience);
	if (!empty(@$arr)) {
		$count = count(@$arr);
	}
		if (!empty(@$arr)){
			foreach (@$arr as $exp){
@endphp
@if ($exp[0] != null && $exp[1] != null && $exp[2] != null && $exp[3] != null)
		<div class="row">
			<div class="col-4"><p>Company name: {{ ucwords($exp[0]) }}</p></div>
			<div class="col-4"><p>Position: {{ ucwords($exp[1]) }}</p></div>
			<div class="col-4"><p>Date covered: {{ Carbon\carbon::parse($exp[2])->format('M d, Y') . " " . " to " . " " . Carbon\carbon::parse($exp[3])->format('M d, Y') }}</p></div>
		</div>
@else
<p>None</p>
@endif
		
			@php
		}
	}
@endphp
<hr>
<h3>Other info</h3>
<p class="{{ (@$employee->tin_no == NULL) ? 'bg-warning' : ''  }}">TIN number: {{ @$employee->tin_no }}</p>
<p class="{{ (@$employee->sss_no == NULL) ? 'bg-warning' : ''  }}">SSS number: {{ @$employee->sss_no }}</p>
<p class="{{ (@$employee->philhealth_no == NULL) ? 'bg-warning' : ''  }}">Philhealth number: {{ @$employee->philhealth_no }}</p>
<p class="{{ (@$employee->hdmf_no == NULL) ? 'bg-warning' : ''  }}">HDMF number: {{ @$employee->hdmf_no }}</p>
<hr>
<a href="{{ route('hr.emp.edit', ['employee' => @$employee->emp_id]) }}" class="btn btn-info text-white">Edit</a>

@endsection