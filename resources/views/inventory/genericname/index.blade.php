@extends('layouts.app')
@section('title', '| Generics')
@section('genericname', 'active')
{{-- @section('dash-title', 'Generic Names') --}}
@section('heading-title')
	<i class="fas fa-tablets text-secondary"></i> Generic Name
@endsection
@section('dash-content')

@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
	<div class="form-group text-right">
		<a class="btn btn-info text-white" href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Add New</a>
	</div>
@endif

<div class="card mb-3">
	<div class="card-body">
		<div class="row zp-countable">
			<div class="col-12 col-md-6">
				<p class="text-primary">Total number of Generics: <span>{{ $gensCount->count() }}</span></p>
			</div>
			<div class="col-12 col-md-6 count_items">
				<p><span class="zp-tct">Total Items: </span> {{ $gens->count() }} <span  class="zp-ct"> Items</span></p>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Generic Name</th>
					<th width="10%" class="text-center">Quantity</th>
				</thead>
				<tbody>
					@forelse ($gens as $gen)
						<tr>
							<td>
				        		{{ ucwords($gen->gname) }}
								<div class="row-actions">
									<a href="{{ route('genericname.show', ['generic' => $gen->gname_slug]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i> View</a>
									@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
									<small class="text-muted">|</small>
						        	<form method="post" action="{{ route('genericname.delete', ['generic' => $gen->gname_slug]) }}" class="d-inline">
						        		@csrf
						        		@method('DELETE')
										<button class="btn btn-link text-danger"  onclick="return confirm('Are you sure you want to delete {{ ucfirst($gen->gname) }} Generic Name?')" data-id="{{ $gen->gname }}">
											<i class="fas fa-trash-alt"></i> Delete
										</button>
						        	</form>
									@endif
								</div>
							</td>
							<td class="text-center">{{ $gen->medicines->where('availability', 0)->where('expiration_date', '>=', NOW())->count() }}</td>
						</tr>
						@empty
							<tr>
								<td colspan="3" class="text-center">{{ "No generic names registered yet!" }}</td>
							</tr>
					@endforelse
				</tbody>
			</table>			
		</div>
	</div>
</div>
<div class="pagination-wrap">{{ $gens->links() }}</div>
@include('layouts.errors')
@if (session('generic_message'))
	<div class="alert alert-danger alert-posts">
		{{ session('generic_message') }}
	</div>
@endif
<!-- Modal Add -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add New Generic</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{ route('genericname.add') }}">
					@csrf
					<div class="form-group">
						<label for="gname">Generic Name</label>
						<input type="text" name="gname" class="form-control" placeholder="Generic Name" value="{{ old('gname') }}" required>
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