@extends('layouts.app')
@section('title', '| Department')
@section('reg_dep', 'active')
{{-- @section('dash-title', 'Department') --}}
@section('heading-title')
	<i class="fas fa-building text-secondary"></i> {{ $department->department }}
@endsection
@section('dash-content')
<div class="card mb-5">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Position</th>
					<th width="10%">No. of Employees</th>
				</thead>
				<tbody>
					@foreach ($department->positions as $position)
					<tr>
						<td>
							{{ strtoupper($position->position) }}
							<div class="row-actions"><a href="{{ route('hr.pos.show', ['position' => $position->position, 'department' => $department->department]) }}" class="btn btn-link text-secondary"><i class="far fa-eye"></i> View</a></div>
						</td>
						<td >{{ $position->employee->count() }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>	
	</div>
</div>

@endsection