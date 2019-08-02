@extends('layouts.app')
@section('title', 'Brand Name')
@section('medicine', 'active')
@section('dash-title', ucwords($generic->gname))
@section('dash-content')
@section('back')
<a href="{{ route('medicine') }}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection
<h4>Brand Name: {{ ucwords($medbrand->bname) }}</h4>
<h5>Generic Name: {{ ucwords($generic->gname) }}</h5>

<table class="table">
	<thead class="thead-dark">
		<th>No.</th>
		<th>Input Date</th>
		<th>Date Expire</th>
		<th>Remaining Quantity</th>
		<th>No. deducted Meds</th>
		<th>Input by</th>
	</thead>
	<tbody>
		@forelse ($logs->unique('expiration_date') as $log)
			<tr>
				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $log->id }}</td>
				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $log->created_at->format('M d, Y') }}</td>
				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $log->expiration_date->format('M d, Y') }}</td>
				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $logs->where('expiration_date', $log->expiration_date)->where('availability', 0)->count() }}</td>
				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $logs->where('expiration_date', $log->expiration_date)->where('availability', 1)->count() }}</td>
				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ ucwords($log->user->employee->first_name) }} {{ ucwords($log->user->employee->last_name) }}</td>
			</tr>
			@empty
				<tr>
					<td colspan="4" class="text-center">{{ "No registered Medicine yet!" }}</td> 
				</tr>
		@endforelse
	</tbody>
</table>

@endsection