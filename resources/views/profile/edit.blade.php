@extends('layouts.app')
@section('title', '| Sync Profile')
@section('employee', 'active')
@section('dash-title', 'Confirm Your Information')
@section('dash-content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 text-center">
			@foreach ($emp as $info)
				<p>Employee ID: {{ $info->emp_id }}</p>
				<p>Name: {{ ucwords($info->last_name) }} {{ ucwords($info->first_name) }} {{ ucwords($info->middle_name) }}</p>
				<p>Present Address: {{ ucwords(@$info->present_address) }}</p>
				<p>Permanent Address: {{ ucwords(@$info->permanent_address) }}</p>
				<p>Contact number: {{ ucwords($info->contact) }}</p>
			<form method="post" action="{{ route('employee.update', ['emp_id' => $info->emp_id]) }}">
				@csrf
				@method('PUT')
				<div class="form-group">
					<input type="hidden" name="id" value="{{ $info->id }}">
					<button type="submit" class="btn btn-info" onclick="return confirm('Are you sure this is your Acount?')">Save</button>
				</div>
			</form>
			@endforeach
		</div>
	</div>
</div>

@endsection