@extends('layouts.app')
@section('title', '| Sync Profile')
@section('employee', 'active')
{{-- @section('dash-title', 'Confirm Your Information') --}}
@section('heading-title')
	<i class="far fa-address-card text-secondary"></i> Confirm Your Information
@endsection
@section('dash-content')

<div class="container">
	<div class="row justify-content-center">
		<div class="signin-container">
			<div class="signin-form">
				{{-- <div class="zp-bg-clan p-1"></div> --}}
				@foreach ($emp as $info)
					<div class="employee_wrap">
						<div class="panel employee-photo d-flex justify-content-center align-items-center">
							@if (@$info->profile_img != null)
								<img src="{{ asset('storage/uploaded/'.@$info->profile_img) }}" alt="{{ @$info->profile_img }}" class="img-fluid" onerror="javascript:this.src='{{url( '/images/default.png' )}}'" >
							@endif
							<div class="d-flex justify-content-center align-items-center upload-button">
							</div>
						</div>
					</div>
					<p class="signin-text text-center">Employee ID: <span class="signin-v">{{ $info->emp_id }}</span></p>
					<hr>
					<p class="signin-text">Name: <span class="signin-v">{{ ucwords($info->last_name) }} {{ ucwords($info->first_name) }} {{ ucwords($info->middle_name) }}</span></p>
					<p class="signin-text">Present Address: <span class="signin-v">{{ ucwords(@$info->present_address) }}</span></p>
					<p class="signin-text">Permanent Address: <span class="signin-v">{{ ucwords(@$info->permanent_address) }}</span></p>
					<p class="signin-text">Contact number: <span class="signin-v">{{ ucwords($info->contact) }}</span></p>
					<hr>
				<form method="post" action="{{ route('employee.update', ['emp_id' => $info->emp_id]) }}" class="text-center mt-3">
					@csrf
					@method('PUT')
					<div class="form-group">
						<input type="hidden" name="id" value="{{ $info->id }}">
						<button type="submit" class="btn btn-info text-white" onclick="return confirm('Are you sure this is your Acount?')">Save</button>
					</div>
				</form>
				@endforeach
			</div>
		</div>
	</div>
</div>

@endsection