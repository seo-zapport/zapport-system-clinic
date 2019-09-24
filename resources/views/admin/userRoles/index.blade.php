@extends('layouts.app')
@section('title', '| User Roles')
@section('userRoles', 'active')
{{-- @section('dash-title', 'User Roles') --}}
@section('heading-title')
	<i class="fas fa-user-cog"></i> User Roles
@endsection
@section('dash-content')

<form method="get">
	<div class="form-row">
		<div class="form-group col-md-4">
			<input type="search" name="search" class="form-control" value="{{ (!empty($search)) ? $search : '' }}" placeholder="Search for User Name">
		</div>
		<div class="form-group col-md-1 d-inline-flex">
			<button type="submit" class="btn btn-success mr-2">Search</button>
			<a href="{{ route('dashboard.userRoles') }}" class="btn btn-info text-white">Clear</a>
		</div>
	</div>
</form>

<div class="card">
	<div class="card-body">

		<div class="form-group">
			<a class="btn btn-info text-white" href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Add Role Users</a>
		</div>

		<div class="table-responsive">
			<table class="table table-hover user-roles">
				<thead class="thead-dark">
					<tr>
						<th>ID</th>
						<th>User name</th>
						<th>Employee Email</th>
						<th>Role</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>

				@forelse($users as $user)
					<tr>
						<td>
							{{-- {{ $user->id }} --}}
				        	<form method="post" action="{{ route('dashboard.delete.user', ['user' => $user->id]) }}">
				        		@csrf
				        		@method('DELETE')
				        		<div class="form-row align-items-center">
				            		<div class="col-auto my-1 form-inline">
				        				{{ $user->id }}
									</div>
								</div>
				        	</form>
						</td>
						<td>{{ $user->name }}</td>
						<td>{{ $user->email }}</td>
						<td>
							@forelse ($user->roles as $role)
								<div class="role-user">
									{{ $role->role }}
								</div>
								@empty
								Set New Role
							@endforelse
						</td>
						<td class="w-15">
							@forelse ($user->roles as $role)
								<span id="{{ $user->id }}" class="show-edit"><i class="far fa-edit text-primary"></i> Quick Edit</span>
							@empty

							@endforelse
							|
							<button class="btn btn-link text-danger"  onclick="return confirm('Are you sure you want to remove {{ ucfirst($user->name) }} ?')" data-id="{{ $user->user }}">
								<i class="fas fa-times-circle"></i> Delete
							</button>
						</td>
					</tr>
					@forelse ($user->roles as $role)
						<tr class="inline-edit-row form-hide form-hidden-{{ $user->id }}">
							<td colspan="5" >
								<fieldset class="inline-edit-col w-100">
									<form method="post" action="{{ route('dashboard.editUserRoles', ['user_id' => $user->id, 'role_id' => $role->id]) }}">
										@csrf
										@method('PUT')
										<p class="text-muted">QUICK EDIT</p>
										<span>Role</span>
										<input type="hidden" name="user_id" value="{{ $user->id }}">
										<select name="role_id" id="role_id" class="form-control-sm" onchange="this.form.submit();">
											@foreach ($roles as $allRole)
												<option {{ ($role->id == $allRole->id) ? 'selected' : '' }} value="{{ $allRole->id }}">{{ $allRole->role }}</option>
											@endforeach
										</select>
									</form>
								</fieldset>
							</td>
						</tr>
					@empty
						<tr class="form-hide form-hidden-{{ $user->id }}">
							<td colspan="5" >
								<fieldset class="inline-edit-col w-100">
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
								</fieldset>
							</td>
						</tr>
					@endforelse
				@empty
					<td colspan="4" class="text-center">{{ "No User Roles Yet!" }}</td>
				@endforelse

				</tbody>

			</table>
		</div>
		@include('layouts.errors')
		@if (session('reg_success') || session('delete_error'))
			<div class="{{ (session('reg_success')) ? 'alert alert-success' : 'alert alert-danger' }}">
				{{ session('reg_success') }}
				{{ session('delete_error') }}
			</div>
		@endif
	</div>
</div>
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