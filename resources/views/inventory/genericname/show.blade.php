@extends('layouts.app')
@section('title', 'Position')
@section('genericname', 'active')
@section('dash-title', $generic->gname)
@section('dash-content')
<table class="table">
	<thead class="thead-dark">
		<th>Generic Name</th>
		<th>Input Date</th>
		<th>Date Expire</th>
		<th>Quantity</th>
	</thead>
	<tbody>
		@forelse ($generic->medicines->unique('expiration_date') as $gen)
			<tr>
				<td class="{{ ($gen->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ ucwords($gen->medbrand->bname) }}</td>
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