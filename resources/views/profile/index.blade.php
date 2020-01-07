@extends('layouts.app')
@section('title', 'Add Department')
@section('employee', 'active')
@section('dash-title', 'Enter Your Employee Number')
@section('dash-content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-6">
			<form method="get" action="{{ route('employee.search') }}">
				<div class="form-row">
					<div class="form-group col-12">
						<label for="emp_id"></label>
						<input type="number" name="emp_id" class="form-control" placeholder="Enter Your Employee ID">
					</div>
					<div class="form-group col-12">
						<button type="submit" class="btn btn-info">Submit</button>
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

@endsection