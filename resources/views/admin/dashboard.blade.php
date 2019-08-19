@extends('layouts.app')
@section('title', 'Dashboard')
@section('overview', 'active')
@section('dash-title', 'Dashboard Overview')
@section('dash-content')

@if (Gate::check('isAdmin') || Gate::check('isDoctor'))

	<h3>New Consultations</h3>
	<table class="table table-hover">
		<thead class="thead-dark">
			<th>No.</th>
			<th>Employee Name</th>
			<th>Date and Time</th>
			<th>Diagnosis</th>
			<th>Notes</th>
			<th>Remarks</th>
			<th>Action</th>
		</thead>
		<tbody>
			@forelse (@$notSeen as $seen)
				<tr>
					<td>{{ $seen->employee->emp_id }}</td>
					<td>{{ ucwords($seen->employee->last_name) }} {{ ucwords($seen->employee->first_name) }} {{ ucwords($seen->employee->middle_name) }}</td>
					<td>{{ $seen->created_at->format('M d, Y - h:i a') }}</td>
					<td>{{ $seen->diagnosis }}</td>
					<td>{{ $seen->note }}</td>
					<td>{{ ($seen->remarks == 'followUp') ? 'Follow up' : 'Done' }}</td>
					<td><a href="{{ route('medical.show', ['employee' => $seen->employee->id, 'employeesmedical' => $seen->id]) }}" class="btn btn-info text-white">View</a></td>
				</tr>
				@empty
					<tr>
						<td colspan="7" class="text-center">No New Record Found!</td>
					</tr>
			@endforelse
		</tbody>
	</table>

@endif

@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))

	<h3>For Follow up</h3>
	<table class="table table-hover">
		<thead class="thead-dark">
			<th>No.</th>
			<th>Employee Name</th>
			<th>Date and Time</th>
			<th>Diagnosis</th>
			<th>Notes</th>
			<th>Remarks</th>
			<th>Action</th>
		</thead>
		<tbody>
			@forelse (@$empMeds as $empMed)
				<tr>
					<td>{{ $empMed->employee->emp_id }}</td>
					<td>{{ ucwords($empMed->employee->last_name) }} {{ ucwords($empMed->employee->first_name) }} {{ ucwords($empMed->employee->middle_name) }}</td>
					<td>{{ $empMed->created_at->format('M d, Y - h:i a') }}</td>
					<td>{{ $empMed->diagnosis }}</td>
					<td>{{ $empMed->note }}</td>
					<td>{{ ($empMed->remarks == 'followUp') ? 'Follow up' : 'Done' }}</td>
					<td><a href="{{ route('medical.show', ['employee' => $empMed->employee->id, 'employeesmedical' => $empMed->id]) }}" class="btn btn-info text-white">View</a></td>
				</tr>
				@empty
					<tr>
						<td colspan="7" class="text-center">No Medical Records To Follow Up</td>
					</tr>
			@endforelse
		</tbody>
	</table>
	{{ $empMeds->links() }}

@endif

@if (Gate::check('isAdmin') || Gate::check('isHr'))
	<h3>Employees with incomplete requirements</h3>
	<table class="table table-hover">
		<thead class="thead-dark">
			<th>Employee Number</th>
			<th>Employee Name</th>
			<th>Department - Positon</th>
			<th>Action</th>
		</thead>
		@forelse (@$emps as $emp)
			<tr>
				<td>{{ $emp->emp_id }}</td>
				<td>{{ $emp->last_name }} {{ $emp->first_name }} {{ $emp->middle_name }}</td>
				<td>{{ $emp->departments->department }} - {{ $emp->positions->position }}</td>
				<td><a href="{{ route('hr.emp.show', ['employee' => $emp->id]) }}" class="btn btn-info text-white">View</a></td>
			</tr>
			@empty
				<tr>
					<td colspan="4" class="text-center">Employees with no requirements not found!</td>
				</tr>
		@endforelse
	</table>
@endif

@endsection