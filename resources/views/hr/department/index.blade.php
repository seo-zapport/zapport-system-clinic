@extends('layouts.app')
@section('title', 'Department')
@section('reg_dep', 'active')
@section('dash-title', 'Department')
@section('dash-content')

<div class="form-group">
	<a class="btn btn-info text-white" href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Add Department</a>
</div>

<table class="table">
	<thead class="thead-dark">
		<th>Department</th>
		<th>No. of Employees</th>
	</thead>
	<tbody>
		@forelse ($deps as $dep)
			<tr>
				<td>
	        	<form method="post" action="{{ route('hr.dep.deleteDep', ['department' => $dep->id]) }}">
	        		@csrf
	        		@method('DELETE')
	        		<div class="form-row align-items-center">
	            		<div class="col-auto my-1 form-inline">
	        				{{ $dep->department }}
							<button class="btn btn-link"  onclick="return confirm('Are you sure you want to delete {{ ucfirst($dep->department) }} Department?')" data-id="{{ $dep->id }}">
								<i class="fas fa-times-circle"></i>
							</button>
						</div>
					</div>
	        	</form>
				</td>
				<td>{{ $dep->employee->count() }}</td>
			</tr>
			@empty
				<tr>
					<td colspan="2" class="text-center">{{ "No registered Department yet!" }}</td>
				</tr>
		@endforelse
	</tbody>
</table>
@include('layouts.errors')
@if (session('dep_message'))
	<div class="alert alert-danger alert-posts">
		{{ session('dep_message') }}
	</div>
@endif

<!-- Modal Add -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add New Department</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{ route('hr.dep.addDep') }}">
					@csrf
					<div class="form-group">
						<label for="department">Department</label>
						<input type="text" name="department" class="form-control" placeholder="Add Department" value="{{ old('department') }}" required>
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