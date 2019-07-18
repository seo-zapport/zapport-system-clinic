@extends('layouts.app')
@section('title', 'Brand Name')
@section('brandname', 'active')
@section('dash-title', ucwords($medbrand->bname))
@section('dash-content')

<h4>Brand Name: {{ ucwords($medbrand->bname) }}</h4>

<table class="table">
	<thead class="thead-dark">
		<th>Generic Name</th>
		<th>Input Date</th>
		<th>Date Expire</th>
		<th>Quantity</th>
	</thead>
	<tbody>
		@forelse ($medbrand->medicines->unique('expiration_date') as $gen)
			<tr>
				<td class="{{ ($gen->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $gen->generic->gname }}</td>
				<td class="{{ ($gen->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $gen->created_at->format('M d, Y') }}</td>
				<td class="{{ ($gen->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $gen->expiration_date->format('M d, Y') }}</td>
				<td class="{{ ($gen->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $gen->where('expiration_date', $gen->expiration_date)->where('availability', 0)->count() }}</td>
			</tr>
			@empty
				<tr>
					<td colspan="4" class="text-center">{{ "No Records yet!" }}</td>
				</tr>
		@endforelse
	</tbody>
</table>

@endsection