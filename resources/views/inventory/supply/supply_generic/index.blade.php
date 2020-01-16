@extends('layouts.app')
@section('title', '| Generics')
@section('supplygen', 'active')
{{-- @section('dash-title', 'Generic Names') --}}
@section('heading-title')
	<i class="fas fa-tablets text-secondary"></i> Register New Supply
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
				<p class="zp-2a9">Total: <span>{{ $supgens->count() }}</span></p>
			</div>
			<div class="col-12 col-md-6 count_items">
				{{-- <p><span class="zp-tct">Total Items: </span> {{ $gens->count() }} <span  class="zp-ct"> Items</span></p> --}}
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Supply Name</th>
					<th width="20%">Number of Brands</th>
					<th width="10%" class="text-center">Quantity</th>
				</thead>
				<tbody>
					@forelse ($supgens as $supgen)
						<tr>
							<td>
								{{ strtoupper($supgen->name) }}
								<div class="row-actions">
									<a href="{{ route('supply.generic.show', ['supgen' => $supgen->slug]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i> View</a>
									@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))

										<span id="{{ $supgen->slug }}" class="show-edit btn btn-link text-secondary"><i class="far fa-edit"></i> Quick Edit</span> <span class="text-muted">|</span>

										<small class="text-muted">|</small>
							        	<form method="post" action="{{ route('supply.generic.destroy', ['supgen' => $supgen->slug]) }}" class="d-inline">
							        		@csrf
							        		@method('DELETE')
											<button class="btn btn-link text-danger"  onclick="return confirm('Are you sure you want to delete {{ ucfirst($supgen->name) }} Generic Name?')" data-id="{{ $supgen->name }}">
												<i class="fas fa-trash-alt"></i> Delete
											</button>
							        	</form>
									@endif
								</div>
							</td>
							<td>{{ $supgen->supbrands->count() }}</td>
							<td>{{ $supgen->supplies->where('availability', 0)->count() }}</td>
						</tr>
						<tr class="inline-edit-row form-hide form-hidden-{{ $supgen->slug }}">
							<td colspan="3" >
								<fieldset class="inline-edit-col w-100">
									<form method="post" action="{{ route('supply.generic.update', ['supgen' => $supgen->slug]) }}">
										@csrf
										@method('PUT')
										<p class="text-muted">QUICK EDIT</p>
										<span>Supply Name</span> <small class="font-italic text-muted">Enter to save</small>
										<input type="text" name="name" value="{{ $supgen->name }}" class="form-control" required autocomplete="off">
									</form>
								</fieldset>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="2" class="text-center">No Registered Supplies yet!</td>
						</tr>
					@endforelse
				</tbody>
			</table>
			{{ $supgens->links() }}
		</div>
	</div>
</div>
@include('layouts.errors')
@if (session('supgen_error'))
	<div id="err-msg" class="alert alert-danger">
		{{ session('supgen_error') }}
	</div>
@endif

<!-- Modal Add -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header zp-bg-clan">
				<h5 class="modal-title text-white" id="exampleModalLongTitle">Register New Supply </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{ route('supply.generic.store') }}">
					@csrf
					<div class="form-group">
						<label for="name">Supply Name</label>
						<input type="text" name="name" class="form-control" placeholder="Supply Name" value="{{ old('name') }}" required autocomplete="off">
					</div>
					<div class="text-right">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')
	@if (session('supgen_error'))
		<script text=text/scripts>
			jQuery(document).ready(function(){
				$("#err-msg").on('click', function(e){
					e.preventDefault();
					$(this).fadeOut('slow');
				});
			});
		</script>
	@endif
@endsection