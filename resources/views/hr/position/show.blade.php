@extends('layouts.app')
@section('title', '| Position | ' .ucwords($position->position))
@section('reg_pos', 'active')
{{-- @section('dash-title', ucwords($position->position)) --}}
@section('heading-title')
	<i class="fas fa-tasks text-secondary"></i> {{ strtoupper($department->department) }} - {{ ucwords($position->position) }}
	@if (Gate::check('isAdmin') || Gate::check('isHr'))
		<a href="" data-toggle="modal" data-target="#exampleModalCenter"><i class="far fa-edit text-primary fa-xs"></i></a>
	@endif
@endsection
@section('dash-content')
@section('back')
<a href="{{ route('hr.pos.position') }}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection
<div class="card">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th width="5%">No.</th>
					<th>Employee Name</th>
					<th width="8%">Employee ID</th>
				</thead>
				<tbody>
					@php
						$i = 1;
					@endphp
					@forelse ($employees as $empPos)
						<tr>
							<td>{{ $i }}</td>
							<td>{{ ucwords($empPos->last_name) }} {{ ucwords($empPos->first_name) }} {{ ucwords($empPos->middle_name) }}
								<div class="row-actions">
									<a href="{{ route('hr.emp.show', ['employee' => $empPos->emp_id]) }}" class="btn btn-link text-secondary"><i class="far fa-eye"></i> View</a>
								</div>
							</td>
							<td>{{ $empPos->emp_id }}</td>
						</tr>
					@php
						$i++;
					@endphp
						@empty
							<tr>
								<td colspan="4" class="text-center">No Records Found!</td>
							</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header zp-bg-clan">
				<h5 class="modal-title text-white" id="exampleModalLongTitle">Edit Position Name</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{ route('hr.pos.update', ['position'	=>	$position->position_slug, 'department'	=>	$department->department_slug]) }}">
					@csrf
					@method('PUT')
					<div class="form-group">
						<label for="position">Position Name</label>
						<input type="text" name="position" class="form-control @error('position') border border-danger @enderror" placeholder="Add Generic" value="{{ $position->position }}" required autocomplete="off">
						@error('position') <small class="text-danger">{{ $message }}</small> @enderror
					</div>
					<div class="form-group text-right">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@error('position')
	@section('scripts')
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('#exampleModalCenter').modal('show')
			});
		</script>
	@endsection
@enderror