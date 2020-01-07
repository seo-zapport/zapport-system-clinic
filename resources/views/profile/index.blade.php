@extends('layouts.app')
@section('title', '| Sync Profile')
@section('employee', 'active')
{{-- @section('dash-title', 'Enter Your Employee Number') --}}
@section('heading-title')
	<i class="far fa-address-card text-secondary"></i> Enter Your Employee Number
@endsection
@section('dash-content')

<div class="container">
	<div class="row justify-content-center">
		<div class="signin-container">
			<div class="signin-form">
				{{-- <div class="zp-bg-clan p-1"></div> --}}
				<form method="get" action="{{ route('employee.search') }}">
					<div class="form-row">
						<div class="form-group col-12">
							<label for="emp_id"></label>
							<input id="emp_id_field" type="number" name="emp_id" class="form-control" placeholder="Enter Your Employee ID">
						</div>
						<div class="form-group col-12 text-center">
							<button type="submit" class="btn btn-info text-white" onclick="return confirm('Are you sure '+ $('#emp_id_field').val() +' is your Employee ID?')">Submit</button>
						</div>
					</div>
				</form>
				@include('layouts.errors')
				@if (session('noResult'))
					<div class="alert alert-danger alert-posts">
						{{ session('noResult') }}
					</div>
				@endif
			</div>
		</div>
	</div>
</div>

@endsection