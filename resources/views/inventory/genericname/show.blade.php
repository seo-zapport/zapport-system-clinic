@extends('layouts.app')
@section('title', 'Position')
@section('genericname', 'active')
@section('dash-title', $generic->gname)
@section('dash-content')
@section('back')
<a href="{{ route('genericname') }}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection
<table class="table">
	<thead class="thead-dark">
		<th>Brand Name</th>
		{{-- <th>Input Date</th> --}}
		{{-- <th>Date Expire</th> --}}
		<th>Remaining Quantity</th>
	</thead>
	<tbody>
		@forelse ($allBrands as $gen)
			<tr>
				<td class="{{ ($gen->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ ucwords($gen->medbrand->bname) }}</td>
				{{-- <td class="{{ ($gen->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $gen->created_at->format('M d, Y') }}</td> --}}
				{{-- <td class="{{ ($gen->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $gen->expiration_date->format('M d, Y') }}</td> --}}
				<td class="{{ ($gen->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $gen->where('brand_id', $gen->medbrand->id)->where('availability', 0)->count() }}</td>
				{{-- <td class="{{ ($gen->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $gen->where('brand_id', $gen->medbrand->id)->where('expiration_date', $gen->expiration_date)->where('availability', 0)->count() }}</td> --}}
			</tr>
			@empty
				<tr>
					<td colspan="4" class="text-center">{{ "No Records yet!" }}</td>
				</tr>
		@endforelse
	</tbody>
</table>
@endsection