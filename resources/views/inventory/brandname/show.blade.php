@extends('layouts.app')
@section('title', '| Brand Name | '.ucwords($medbrand->bname))
@section('brandname', 'active')
{{-- @section('dash-title', ucwords($medbrand->bname)) --}}
@section('heading-title')
	<i class="fas fa-file-prescription text-secondary"></i> {{ ucwords($medbrand->bname) }}
@endsection
@section('dash-content')
@section('back')
<a href="{{ route('brandname') }}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection
<div class="d-flex align-content-center p-2">
	<p><span class="text-muted">Brand Name</span>: <strong>{{ ucwords($medbrand->bname) }}</strong></p>
	@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
		<a href="" data-toggle="modal" data-target="#exampleModalCenter"><i class="far fa-edit text-primary p-1"></i></a>
	@endif
</div>

<div class="card">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table">
				<thead class="thead-dark">
					<th>Generic Name</th>
					<th width="10%" class="text-center">Quantity</th>
				</thead>
				<tbody>
					@forelse ($medbrand->medicines->unique('brand_id') as $gen)
						<tr>
							<td>{{ strtoupper($gen->generic->gname) }}</td>
							<td class="text-center">{{ $gen->where('brand_id', $medbrand->id)->where('generic_id', $gen->generic->id)->where('expiration_date', '>', NOW())->where('availability', 0)->count() }}</td>
						</tr>
						@empty
							<tr>
								<td colspan="4" class="text-center">{{ "No Records yet!" }}</td>
							</tr>
					@endforelse
				</tbody>
			</table>			
		</div>
	</div>
</div>

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
				<form method="post" action="{{ route('brandname.update', ['medbrand' => $medbrand->bname_slug]) }}">
					@csrf
					@method('PUT')
					<div class="form-group">
						<label for="bname">Brand Name</label>
						<input type="text" name="bname" class="form-control" placeholder="Add Brand" value="{{ $medbrand->bname }}" required autocomplete="off" pattern="[a-zA-Z0-9\s()/]+" title="Special Characters are not allowed!">
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