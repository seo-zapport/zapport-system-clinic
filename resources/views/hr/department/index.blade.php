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
		<div class="row zp-countable">
			<div class="col-12 col-md-6">
				<p class="text-primary"><span>Total number of Departments:</span> {{ $depsCount->count() }}</p>
			</div>
			<div class="col-12 col-md-6 count_items">
				<p><span class="zp-tct">Total Items: </span> {{ $deps->count() }} <span  class="zp-ct"> Items</span></p>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Department</th>
					<th width="20%">No. of Positions</th>
					<th width="10%" class="text-center">No. of Employees</th>
				</thead>
				<tbody>
					@forelse ($deps as $dep)
						<tr>
							<td>{{ strtoupper($dep->department) }}
								<div class="row-actions">
									<a href="{{ route('hr.dep.showDep', ['department' => $dep->department_slug]) }}" class="btn btn-link text-secondary"><i class="far fa-eye"></i> View</a>
									<form method="post" action="{{ route('hr.dep.deleteDep', ['department' => $dep->department_slug]) }}" class="d-inline-block">
						        		@csrf
						        		@method('DELETE')
										<button class="btn btn-link text-danger"  onclick="return confirm('Are you sure you want to delete {{ ucfirst($dep->department) }} Department?')" data-id="{{ $dep->department }}">
											<i class="fas fa-trash-alt"></i> Delete
										</button>
						        	</form>
						        </div>
						    </td>
							<td>{{ $dep->positions->count() }}</td>
							<td class="text-center">{{ $dep->employee->count() }}</td>
						</tr>
						@empty
							<tr>
								<td colspan="3" class="text-center">{{ "No registered Department yet!" }}</td>
							</tr>
					@endforelse
				</tbody>
			</table>
			{{ $deps->links() }}
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