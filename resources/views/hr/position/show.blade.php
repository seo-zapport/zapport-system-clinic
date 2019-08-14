@extends('layouts.app')
@section('title', 'Position')
@section('reg_pos', 'active')
@section('dash-title', ucwords($position->position))
@section('dash-content')
@section('back')
<a href="{{ route('hr.pos.position') }}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection

<table class="table table-hover">
	<thead class="thead-dark">
		<th>No.</th>
		<th>Employee ID</th>
		<th>Employee Name</th>
	</thead>
	<tbody>
		@php
			$i = 1;
		@endphp
		@forelse ($position->employee as $empPos)
			<tr>
				<td>{{ $i }}</td>
				<td>{{ $empPos->emp_id }}</td>
				<td>
					{{ ucwords($empPos->last_name) }} {{ ucwords($empPos->first_name) }} {{ ucwords($empPos->middle_name) }}
					<span class="float-right"><a href="{{ route('hr.emp.show', ['employee' => $empPos->id]) }}" class="btn btn-info text-white">View</a></span>
				</td>
			</tr>
		@php
			$i++;
		@endphp
			@empty
				<tr>
					<td colspan="3" class="text-center">No Records Found!</td>
				</tr>
		@endforelse
	</tbody>
</table>

@endsection