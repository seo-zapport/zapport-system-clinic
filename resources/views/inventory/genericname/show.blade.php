@extends('layouts.app')
@section('title', '| Generics | '. $generic->gname)
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
				<td>
					{{ ucwords($gen->medbrand->bname) }}
				</td>
				<td>
					{{ $gen->where('brand_id', $gen->medbrand->id)->where('availability', 0)->where('expiration_date', '>', NOW())->count() }}
				</td>
			</tr>
			@empty
				<tr>
					<td colspan="4" class="text-center">{{ "No Records yet!" }}</td>
				</tr>
		@endforelse
	</tbody>
</table>
@endsection