@extends('layouts.app')
@section('title', 'Brand Name')
@section('medicine', 'active')
@section('dash-title', ucwords($generic->gname))
@section('dash-content')

<h4>Brand Name: {{ ucwords($medbrand->bname) }}</h4>
<h5>Generic Name: {{ ucwords($generic->gname) }}</h5>

<table class="table">
	<thead class="thead-dark">
		<th>Input Date</th>
		<th>Date Expire</th>
		<th>Quantity</th>
	</thead>
	<tbody>
		@forelse ($logs->unique('expiration_date') as $log)
			<tr>
				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $log->created_at->format('M d, Y') }}</td>
				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $log->expiration_date->format('M d, Y') }}</td>
				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $logs->where('expiration_date', $log->expiration_date)->count() }}</td>
			</tr>
			@empty
				<tr>
					<td colspan="4" class="text-center">{{ "No registered Medicine yet!" }}</td> 
				</tr>
		@endforelse
	</tbody>
</table>

@endsection