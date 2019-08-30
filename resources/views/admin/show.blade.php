@extends('layouts.app')
@section('title', '| '.ucwords($employee->last_name) . '\'s information')
@section('employeesMedical', 'active')
@section('dash-title', ucwords($employee->last_name) . '\'s information')
@section('dash-content')
@section('back')
<a href="{{ route('dashboard.main') }}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection
<div class="row">
	<div class="col-10">
		<div class="row">
			<div class="col-3">
				<p>Name: {{ ucwords($employee->last_name . " " . $employee->first_name . " " . $employee->middle_name) }}</p>
			</div>
			<div class="col-3">
				<p>Department: {{ strtoupper($employee->departments->department) }}</p>
			</div>
			<div class="col-3">
				<p>Position: {{ ucwords($employee->positions->position) }}</p>
			</div>
		</div>

		<div class="row">
			<div class="col-2">
				<p>Gender: {{ (@$employee->gender == 0) ? "Male" : "Female" }}</p>
			</div>
			<div class="col-1">
				<p>Age: {{ @$employee->age }}</p>
			</div>
			<div class="col-3">
				<p>Birthday: {{ @$employee->birthday->format('M d, Y') }}</p>
			</div>
			<div class="col-3">
				<p>Birth Place: {{ ucwords(@$employee->birth_place) }}</p>
			</div>
			<div class="col-3">
				<p>Contact number: {{ "+63" . @$employee->contact }}</p>
			</div>
		</div>
	</div>

	<div class="col-2">
		@if (@$employee->profile_img != null)
			<img src="{{ asset('storage/uploaded/'.@$employee->profile_img) }}" alt="{{ @$employee->profile_img }}" class="img-fluid">
		@endif
	</div>
</div>
<hr>
@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
<div class="form-group">
	@if ($employeesmedical->remarks == 'followUp')
			<button class="btn btn-success text-white" data-toggle="modal" data-target="#exampleModalCenter">Add Notes</button>
	@endif

	<button class="btn btn-info text-white" data-toggle="modal" data-target="#exampleModalCenter2">Edit Remarks</button>
</div>
@endif
<div class="row">
	<div id="diagnosis" class="container">
		<div class="mb-3">
			<h2>{{ ucwords($employeesmedical->diagnosis) }}</h2>
			<small>Date: {{ $employeesmedical->created_at->format('M d, Y - h:i a') }}</small>
		</div>
		<div>
			<h4>Doctor's Note:</h4>
			<p>{{ ucfirst($employeesmedical->note) }}</p>
			@if (count($employeesmedical->medNote) > 0)
				<h5>Follow up checkup:</h5>
				@foreach ($employeesmedical->medNote as $followups)
					<p>{{ ucfirst($followups->followup_note) }} <small>{{ $followups->created_at->format('M d, Y - h:i a') }}</small></p>
				@endforeach
			@endif
		</div>
		<div>
			<h5>Medicines:</h5>
			@foreach ($empMeds as $meds)
				{{ ucwords($meds->generic->gname) }}
				{{ ucwords($meds->medBrand->bname) }} {{ $meds->pivot->quantity }} <br>
					@foreach ($meds->users as $att)
						<small>{{ 'Given by: '. ucwords($att->employee->first_name) }} {{ ucwords($att->employee->middle_name) }} {{ ucwords($att->employee->last_name) }}<br>
					@endforeach
				{{ $meds->pivot->created_at->format('M d, Y - h:i a') }}</small><br>
			@endforeach
		</div>
		<br>
		<p>Attendant: {{ ucwords($employeesmedical->user->employee->first_name) }} {{ ucwords($employeesmedical->user->employee->middle_name) }} {{ ucwords($employeesmedical->user->employee->last_name) }}</p>
		<p>Remarks: {{ ($employeesmedical->remarks == 'followUp') ? 'Follow up' : 'Done' }}</p>
	</div>
</div>

@endsection