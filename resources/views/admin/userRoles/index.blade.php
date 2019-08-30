@extends('layouts.app')
@section('title', '| User Roles')
@section('userRoles', 'active')
@section('dash-title', 'User Roles')
@section('dash-content')

<div class="form-group">
	<a class="btn btn-info text-white" href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Add Role Users</a>
</div>

<table class="table table-hover user-roles">
	<thead class="thead-dark">
		<tr>
			<th>ID</th>
			<th>Employee Name</th>
			<th>Employee Email</th>
			<th>Role</th>
		</tr>
	</thead>
	<tbody>

	@forelse($users as $user)
		<tr>
			<td>{{ $user->id }}</td>
			<td>{{ $user->name }}</td>
			<td>{{ $user->email }}</td>
			<td>
				@forelse ($user->roles as $role)

					<div class="role-user">
						{{ $role->role }}
						<span id="{{ $user->id }}" class="show-edit"><i class="far fa-edit text-primary"></i></span>

						<form method="post" action="{{ route('dashboard.editUserRoles', ['user_id' => $user->id, 'role_id' => $role->id]) }}" class="form-hide form-hidden-{{ $user->id }}">
							@csrf
							@method('PUT')
							<input type="hidden" name="user_id" value="{{ $user->id }}">
							<select name="role_id" id="role_id" class="form-control-sm" onchange="this.form.submit();">
								@foreach ($roles as $allRole)
									<option {{ ($role->id == $allRole->id) ? 'selected' : '' }} value="{{ $allRole->id }}">{{ $allRole->role }}</option>
								@endforeach
							</select>
						</form>
					</div>

					@empty

					<form method="post" action="{{ route('dashboard.addUserRoles') }}">
						@csrf
						<input type="hidden" name="user_id" value="{{ $user->id }}">
						<select name="role_id" id="role_id" class="form-control-sm" onchange="this.form.submit();">
							@foreach ($roles as $role)
								<option hidden>Select Role</option>
								<option value="{{ $role->id }}">{{ $role->role }}</option>
							@endforeach
						</select>
					</form>

				@endforelse
			</td>
		</tr>
	@empty
		<td colspan="4" class="text-center">{{ "No User Roles Yet!" }}</td>

	@endforelse

	</tbody>

</table>
@include('layouts.errors')
@if (session('reg_success'))
	<div class="alert alert-success">{{ session('reg_success') }}</div>
@endif

	<!-- Modal Add -->
	<div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Add Role For Users</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					@if ($noRoles->count() < 1)
							{{ "All users has role" }}
						@else
					<form method="post" action="{{ route('dashboard.addUserRoles') }}">
						@csrf
						<div class="form-group">
							<select name="user_id" class="form-control">
								@foreach ($noRoles as $noRole)
									<option value="{{ $noRole->id }}">{{ $noRole->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="role">Role</label>
							<select name="role_id" class="form-control">
								<option selected="true" disabled>Select Roles for Users</option>
								@foreach ($roles as $role)
									<option value="{{ $role->id }}">{{ $role->role }}</option>
								@endforeach
							</select>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Save changes</button>
						</div>
					</form>
					@endif
				</div>
			</div>
		</div>
	</div>

@endsection