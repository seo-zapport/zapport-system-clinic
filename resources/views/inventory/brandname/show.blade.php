@extends('layouts.app')
@section('title', 'Brand Name')
@section('brandname', 'active')
@section('dash-title', ucwords($medbrand->bname))
@section('dash-content')
@section('back')
<a href="{{ route('brandname') }}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection
<div class="d-flex align-content-center p-2">
	<h4>Brand Name: {{ ucwords($medbrand->bname) }}</h4>
	@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
		<a href="" data-toggle="modal" data-target="#exampleModalCenter"><i class="far fa-edit text-primary p-1"></i></a>
	@endif
</div>

<table class="table">
	<thead class="thead-dark">
		<th>Generic Name</th>
		<th>Quantity</th>
	</thead>
	<tbody>
		@forelse ($medbrand->medicines->unique('brand_id') as $gen)
			<tr>
				<td class="{{ ($gen->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ ucfirst($gen->generic->gname) }}</td>
				<td class="{{ ($gen->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $gen->where('brand_id', $medbrand->id)->where('generic_id', $gen->generic->id)->where('expiration_date', '>=', NOW())->where('availability', 0)->count() }}</td>
			</tr>
			@empty
				<tr>
					<td colspan="4" class="text-center">{{ "No Records yet!" }}</td>
				</tr>
		@endforelse
	</tbody>
</table>
@include('layouts.errors')
<!-- Modal Add -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Edit Brand Name</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{ route('brandname.update', ['medbrand' => $medbrand->id]) }}">
					@csrf
					@method('PUT')
					<div class="form-group">
						<label for="bname">Brand Name</label>
						<input type="text" name="bname" class="form-control" placeholder="Add Brand" value="{{ $medbrand->bname }}" required>
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