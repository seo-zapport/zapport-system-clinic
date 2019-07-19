@extends('layouts.app')
@section('title', 'Brand Name')
@section('medicine', 'active')
@section('dash-title', 'Brand Names')
@section('dash-content')

<div class="form-group">
	<a class="btn btn-info text-white" href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Add New</a>
</div>

<table class="table table-hover">
	<thead class="thead-dark">
		<th>Generic Name</th>
		<th>Brand Name</th>
		<th>Quantity</th>
		<th>Stock Logs</th>
	</thead>
	<tbody>
		@forelse ($meds as $med)
			<tr>
				<td>{{ ucfirst($med->generic->gname) }}</td>
				<td>{{ ucwords($med->medBrand->bname) }}</td>
				<td>{{ $med->where('generic_id', $med->generic_id)->where('brand_id', $med->brand_id)->where('availability', 0)->count() }}</td>
				<td>
					{{ $med->qty_stock }}
					<a href="{{ route('medicine.log', ['medbrand' => $med->medBrand->id, 'generic' => $med->generic->id]) }}" class="btn btn-info text-white float-right">View</a>
				</td>
			</tr>
			@empty
				<tr>
					<td colspan="4" class="text-center">{{ "No registered Medicine yet!" }}</td>
				</tr>
		@endforelse
	</tbody>
</table>
{{ $meds->links() }}
<br>
@include('layouts.errors')

<!-- Modal Add -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add New Medicine</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{ route('medicine.add') }}">
					@csrf

					<div class="form-group">
						<label for="generic_id">Generic Name</label>
						<select name="generic_id" id="generic_id" class="form-control">
							<option selected="true" disabled="disabled"> Select Generic name </option>
							@foreach ($gens as $gen)
								<option value="{{ $gen->id }}">{{ $gen->gname }}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label for="brand_id">Brand Name</label>
						<select name="brand_id" id="brand_id" class="form-control" required>
							<option selected="true" disabled="disabled"> Select Brand </option>
						</select>
					</div>

					<div class="form-group">
						<label for="expiration_date">Expiration Date</label>
						<input type="date" name="expiration_date" class="form-control" placeholder="Expiration Date" value="{{ old('expiration_date') }}" {{-- required --}}>
					</div>
					<div class="form-group">
						<label for="qty_input">Quantity</label>
						<input type="number" name="qty_input" class="form-control" placeholder="Quantity" value="{{ old('qty_input') }}" {{-- required --}}>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection