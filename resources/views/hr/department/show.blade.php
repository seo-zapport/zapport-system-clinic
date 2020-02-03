@extends('layouts.app')
@section('title', '| Department')
@section('reg_dep', 'active')
{{-- @section('dash-title', 'Department') --}}
@section('heading-title')
	<i class="fas fa-building text-secondary"></i> {{ strtoupper($department->department) }}
	@if (Gate::check('isAdmin') || Gate::check('isHr'))
		<a href="" data-toggle="modal" data-target="#exampleModalCenter"><i class="far fa-edit text-primary fa-xs"></i></a>
	@endif
@endsection
@section('dash-content')
<div class="card mb-5">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Position</th>
					<th width="10%" class="text-center">No. of Employees</th>
				</thead>
				<tbody>
					@foreach ($department->positions as $position)
					<tr>
						<td>
							{{ strtoupper($position->position) }}
							<div class="row-actions"><a href="{{ route('hr.pos.show', ['position' => $position->position_slug, 'department' => $department->department_slug]) }}" class="btn btn-link text-secondary"><i class="far fa-eye"></i> View</a></div>
						</td>
						<td class="text-center">{{ $department->employee->where('position_id', $position->id)->count() }}</td>
					</tr>
					@endforeach
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
				<h5 class="modal-title text-white" id="exampleModalLongTitle">Edit Department Name</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{ route('hr.dep.update', ['department'	=>	$department->department_slug]) }}">
					@csrf
					@method('PUT')
					<div class="form-group">
						<label for="department">Department Name</label>
						<input type="text" name="department" class="form-control @error('department') border border-danger @enderror" placeholder="Add Generic" value="{{ $department->department }}" required autocomplete="off">
						@error('department') <small class="text-danger">{{ $message }}</small> @enderror
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

@error('department')
	@section('scripts')
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('#exampleModalCenter').modal('show')
			});
		</script>
	@endsection
@enderror