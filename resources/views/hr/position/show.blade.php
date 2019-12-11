@extends('layouts.app')
@section('title', '| Position | ' .ucwords($position->position))
@section('reg_pos', 'active')
{{-- @section('dash-title', ucwords($position->position)) --}}
@section('heading-title')
	<i class="fas fa-tasks text-secondary"></i> {{ strtoupper($department->department) }} - {{ ucwords($position->position) }}
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

@endsection