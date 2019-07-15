@extends('layouts.app')
@section('title', 'Position')
@section('reg_pos', 'active')
@section('dash-title', 'Position')
@section('dash-content')

<div class="form-group">
	<a class="btn btn-info text-white" href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Add Position</a>
</div>

<table class="table">
	<thead class="thead-dark">
		<th>Position</th>
		<th>No. of Employees</th>
	</thead>
	<tbody>
		@forelse ($positions as $position)
			<tr>
				<td>{{ $position->position }}</td>
				<td>{{ $position->employee->count() }}</td>
			</tr>
			@empty
				<tr>
					<td colspan="2" class="text-center">{{ "No position registered yet!" }}</td>
				</tr>
		@endforelse
	</tbody>
</table>
@include('layouts.errors')

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
							<option selected="true" disabled="disabled"> Select Department </option>
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