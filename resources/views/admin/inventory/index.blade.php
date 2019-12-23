@extends('layouts.app')
@section('title', '| Dashboard')
@section('inventory_monitoring', 'active')
{{-- @section('dash-title', 'Dashboard Overview') --}}
@section('heading-title')
	<i class="fas fa-pills text-secondary"></i> Inventory Monitoring
@endsection

@section('dash-content')
	<div class="table-responsive">
		<table class="table table-hover">
			<thead class="thead-dark">
				{{-- <th>No.</th> --}}
				<th>Generic Name</th>
				<th>Brand Name</th>
				<th>Input by:</th>
				<th>Quantity</th>
			</thead>
			<tbody>
				@forelse ($meds as $med)
					<tr>
						<td>{{ strtoupper($med->generic->gname) }}</td>
						<td>{{ strtoupper($med->medbrand->bname) }}</td>
						<td>{{ ucfirst($med->user->name) }}</td>
						<td>{{ $med->qty_stock }}</td>
					</tr>
					@empty
					<tr>
						<td colspan="4" class="text-center">0 Result Found!</td>
					</tr>
				@endforelse
			</tbody>
		</table>
		{{ $meds->links() }}
	</div>
@endsection