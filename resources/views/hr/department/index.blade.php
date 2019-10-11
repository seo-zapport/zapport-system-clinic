@extends('layouts.app')
@section('title', '| Department')
@section('reg_dep', 'active')
{{-- @section('dash-title', 'Department') --}}
@section('heading-title')
	<i class="fas fa-building text-secondary"></i> Department
@endsection
@section('dash-content')
<div class="card mb-5">
	<div class="card-body">
		<div class="form-group">
			<a class="btn btn-info text-white" href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Add Department</a>
		</div>
		<div class="table-responsive">
			<table class="table">
				<thead class="thead-dark">
					<th>Department</th>
					<th>No. of Employees</th>
					<th>Action</th>
				</thead>
				<tbody>
					@forelse ($deps as $dep)
						<tr>
							<td>{{ $dep->department }}</td>
							<td>{{ $dep->employee->count() }}</td>
							<td class="w-15 px-0">
								<form method="post" action="{{ route('hr.dep.deleteDep', ['department' => $dep->department]) }}">
					        		@csrf
					        		@method('DELETE')
									<button class="btn btn-link text-danger"  onclick="return confirm('Are you sure you want to delete {{ ucfirst($dep->department) }} Department?')" data-id="{{ $dep->department }}">
										<i class="fas fa-trash-alt"></i> Delete
									</button>
					        	</form>
					        </td>
						</tr>
						@empty
							<tr>
								<td colspan="2" class="text-center">{{ "No registered Department yet!" }}</td>
							</tr>
					@endforelse
				</tbody>
			</table>			
		</div>

		@include('layouts.errors')
		@if (session('dep_message'))
			<div class="alert alert-danger alert-posts">
				{{ session('dep_message') }}
			</div>
		@endif		
	</div>
</div>



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
						<input type="text" name="department" class="form-control" placeholder="Department Name" value="{{ old('department') }}" required>
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