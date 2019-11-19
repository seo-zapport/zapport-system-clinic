@extends('layouts.app')
@section('title', '| Roles')
@section('roles', 'active')
{{-- @section('dash-title', 'Roles') --}}
@section('heading-title')
	<i class="fas fa-cogs text-secondary"></i> Roles
@endsection
@section('dash-content')
<div class="card">
	<div class="card-body">
		<div class="form-group">
			<a class="btn btn-info text-white" href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Add Roles</a>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<tr>
						<th>Role Type</th>
						<th width="8%">Count</th>
					</tr>
				</thead>
				<tbody>

				@forelse($roles as $role)
					<tr>
						<td>
				        	{{ $role->role }}
							<div class="row-actions">
								<a href="{{ route('dashboard.showRoles', ['role' => $role->role]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i> View</a>
								<small class="text-muted">|</small>
					        	<form method="post" action="{{ route('dashboard.deleteRole', ['role' => $role->role]) }}" class="d-inline">
					        		@csrf
					        		@method('DELETE')
					        		
									<button class="btn btn-link text-danger"  onclick="return confirm('Are you sure you want to delete {{ ucfirst($role->role) }} Role?')" data-id="{{ $role->role }}">
										<i class="fas fa-trash-alt"></i> Delete
									</button>
									
					        	</form>
							</div>
						</td>
						<td>{{ $role->users->count() }}</td>
					</tr>
				@empty
					<td colspan="3" class="text-center">{{ "No Roles Yet!" }}</td>
				@endforelse

				</tbody>
			</table>
		</div>

		@include('layouts.errors')
		@if (session('role_msg'))
			<div class="alert alert-danger alert-posts">
				{{ session('role_msg') }}
			</div>
		@endif
			<!-- Modal Add -->
			<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLongTitle">Add New Role</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form method="post" action="{{ route('dashboard.addRoles') }}">
								@csrf
								<div class="form-group">
									<label for="role">Role</label>
									<input type="text" name="role" class="form-control" placeholder="Add Role" value="{{ old('role') }}" required>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary">Save changes</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>
@endsection