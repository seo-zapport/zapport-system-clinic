@extends('layouts.app')
@section('title', '| Position')
@section('reg_pos', 'active')
{{-- @section('dash-title', 'Position') --}}
@section('heading-title')
	<i class="fas fa-tasks text-secondary"></i> Position
@endsection
@section('dash-content')
<div class="form-group text-right">
	<a class="btn btn-info text-white" href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Add Position</a>
</div>
<div class="card mb-3">
	<div class="card-body">
		<div class="row zp-countable">
			<div class="col-12 col-md-6">
				<p class="text-primary">Total number of Positions: <span>{{ count($arr) }}</span></p>
			</div>
			<div class="col-12 col-md-6 count_items">
				<p><span id="totitems" class="zp-ct"> Items</span></p>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Position</th>
					<th width="10%" class="text-center">Department</th>
					<th width="10%" class="text-center">No. of Employees</th>
				</thead>
				<tbody>
					@forelse ($positions as $position)
			        	@foreach ($position->departments as $department)
							<tr id="rowCount">
								<td>
									{{ strtoupper($position->position) }}
									<div class="row-actions">
										<a href="{{ route('hr.pos.show', ['position' => $position->position_slug, 'department' => $department->department_slug]) }}" class="btn btn-link text-secondary"><i class="far fa-eye"></i> View</a>
										<small class="text-muted">|</small>
							        	<form method="post" action="{{ route('hr.pos.deletePos', ['position' => $position->position_slug]) }}" class="d-inline-block">
							        		@csrf
							        		@method('DELETE')
												<button class="btn btn-link text-danger" onclick="return confirm('Are you sure you want to delete {{ ucfirst($position->position) }} Position?')" data-id="{{ $position->postion }}">
													<i class="fas fa-trash-alt"></i> Delete
												</button>
							        	</form>	
									</div>
								</td>
								<td class="text-center">
									{{ strtoupper($department->department) }}
								</td>
								<td class="text-center">
									{{ $employees->where('department_id', $department->id)->where('position_id', $position->id)->count() }}
								</td>
							</tr>
			        	@endforeach
						@empty
							<tr>
								<td colspan="4" class="text-center">{{ "No position registered yet!" }}</td>
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
<div class="pagination-wrap">{{ $positions->links() }}</div>

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
							<option value="{{ $department->id }}">{{ strtoupper($department->department) }}</option>
						@endforeach
					</select>
					</div>
					<div class="form-group">
						<label for="position">Position</label>
						<input type="text" name="position" class="form-control" placeholder="Add Position" value="{{ old('position') }}" required pattern="[a-zA-Z0-9\s]+" title="Special Characters are not allowed!">
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

@section('scripts')
<script type="application/javascript">
	jQuery(document).ready(function($) {
		var count = $("table #rowCount").length;
		$("#totitems").prepend(count);
	});
</script>
@endsection