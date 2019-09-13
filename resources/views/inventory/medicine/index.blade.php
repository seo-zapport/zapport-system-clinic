@extends('layouts.app')
@section('title', '| Medicines')
@section('medicine', 'active')
@section('dash-title', 'List of Medicines')
@section('dash-content')

@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
	<div class="form-group">
		<a class="btn btn-info text-white" href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Add New</a>
	</div>
@endif

<form method="get">
	<div class="form-row">
		<div class="form-group col-md-4">
			<input type="search" name="search" class="form-control" value="{{ (!empty($search)) ? $search : '' }}" placeholder="Search for Generic Name">
		</div>
		<div class="form-group col-md-1 d-inline-flex">
			<button type="submit" class="btn btn-success mr-2">Search</button>
			<a href="{{ route('medicine') }}" class="btn btn-info text-white">Clear</a>
		</div>
	</div>
</form>

<table class="table table-hover">
	<thead class="thead-dark">
		<th>Generic Name</th>
		<th>Brand Name</th>
		<th>Remaining Quantity</th>
		<th>Stock Logs</th>
	</thead>
	<tbody>
		@if ($meds != null)		
		@forelse ($meds as $med)
			<tr>
				<td>{{ ucfirst($med->generic->gname) }}</td>
				<td>{{ ucwords($med->medBrand->bname) }}</td>
				<td>{{ $med->where('generic_id', $med->generic_id)->where('brand_id', $med->brand_id)->where('availability', 0)->where('expiration_date', '>', NOW())->count() }}</td>
				<td>
					{{-- {{ $med->qty_stock }} --}}
					<a href="{{ route('medicine.log', ['medbrand' => $med->medBrand->bname, 'generic' => $med->generic->gname]) }}" class="btn btn-info text-white">View</a>
				</td>
			</tr>
			@empty
				<tr>
					<td colspan="4" class="text-center">{{ "No registered Medicine yet!" }}</td>
				</tr>
		@endforelse
		@else
			<tr>
				<td colspan="4" class="text-center">{{ "No Record Found!" }}</td>
			</tr>
		@endif
	</tbody>
</table>
@if ($meds != null)
	{{ $meds->links() }}
@endif
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
						<select name="generic_id" id="generic_id" class="form-control" required>
							<option selected="true" disabled="disabled" value=""> Select Generic name </option>
							@foreach ($gens as $gen)
								<option value="{{ $gen->id }}">{{ $gen->gname }}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label for="brand_id">Brand Name</label>
						<select name="brand_id" id="brand_id" class="form-control" required>
							<option selected="true" disabled="disabled" value=""> Select Brand </option>
						</select>
					</div>

					<div class="form-group">
						<label for="expiration_date">Expiration Date</label>
						<input type="date" name="expiration_date" class="form-control" placeholder="Expiration Date" value="{{ old('expiration_date') }}" required>
					</div>
					<div class="form-group">
						<label for="qty_input">Quantity</label>
						<input type="number" name="qty_input" class="form-control" placeholder="Quantity" value="{{ old('qty_input') }}" required>
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