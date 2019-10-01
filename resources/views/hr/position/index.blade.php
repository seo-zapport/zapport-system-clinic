@extends('layouts.app')
@section('title', '| Position')
@section('reg_pos', 'active')
{{-- @section('dash-title', 'Position') --}}
@section('heading-title')
	<i class="fas fa-tasks text-secondary"></i> Position
@endsection
@section('dash-content')

<div class="card mb-5">
	<div class="card-body">
		<div class="form-group">
			<a class="btn btn-info text-white" href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Add Position</a>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Position</th>
					<th>Department</th>
					<th>No. of Employees</th>
					<th>Action</th>
				</thead>
				<tbody>
					@forelse ($positions as $position)
			        	@foreach ($position->departments as $department)
							<tr>
								<td>
									{{ ucwords($position->position) }}
								</td>
				        		<td>
				        			{{ ucwords($department->department) }}
				        		</td>
								<td>
									{{ $employees->where('department_id', $department->id)->where('position_id', $position->id)->count() }}
								</td>
								<td class="w-15 px-0">
									<a href="{{ route('hr.pos.show', ['position' => $position->position, 'department' => $department->department]) }}" class="btn btn-link text-secondary"><i class="far fa-eye"></i> View</a>
									<small class="text-muted">|</small>
						        	<form method="post" action="{{ route('hr.pos.deletePos', ['position' => $position->position]) }}" class="d-inline-block">
						        		@csrf
						        		@method('DELETE')
											<button class="btn btn-link text-danger" onclick="return confirm('Are you sure you want to delete {{ ucfirst($position->position) }} Position?')" data-id="{{ $position->postion }}">
												<i class="fas fa-trash-alt"></i> Delete
											</button>
						        	</form>	
								</td>
							</tr>
			        	@endforeach
						@empty
							<tr>
								<td colspan="3" class="text-center">{{ "No position registered yet!" }}</td>
							</tr>
					@endforelse
				</tbody>
			</table>			
		</div>

		@include('layouts.errors')
		@if (session('pos_message') || session('pivot_validation'))
			<div class="alert alert-danger alert-posts">
				{{ session('pos_message') }}
				{{ session('pivot_validation') }}
			</div>
		@endif
		
	</div>
</div>


<!-- Modal Add -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add New Position</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{ route('hr.pos.addPos') }}">
					@csrf
					<div class="form-group">
						<label for="department_id">Department</label>
					<select name="department_id" id="department_id" class="form-control" required>
							<option selected="true" disabled="disabled" value=""> Select Department </option>
						@foreach ($departments as $department)
							<option value="{{ $department->id }}">{{ $department->department }}</option>
						@endforeach
					</select>
					</div>
					<div class="form-group">
						<label for="position">Position</label>
						<input type="text" name="position" class="form-control" placeholder="Add Position" value="{{ old('position') }}" required>
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

@endsection