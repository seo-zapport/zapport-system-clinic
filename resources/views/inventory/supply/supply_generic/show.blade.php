@extends('layouts.app')
@section('title', '| Generics')
@section('supplygen', 'active')
{{-- @section('dash-title', 'Generic Names') --}}
@section('heading-title')
	<i class="fas fa-tablets text-secondary"></i> {{ ucwords($supgen->name) }}
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
				<p class="zp-2a9">Total: <span>{{ $supgen->supbrands->count() }}</span></p>
			</div>
			<div class="col-12 col-md-6 count_items">
				{{-- <p><span class="zp-tct">Total Items: </span> {{ $gens->count() }} <span  class="zp-ct"> Items</span></p> --}}
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Brand Name</th>
					<th width="15%" class="text-center">Quantity</th>
				</thead>
				<tbody>
					@php
						$coll = $supgen->supbrands()->paginate(10);
					@endphp
					@forelse ($coll as $brand)
						<tr>
							<td>
								{{ strtoupper($brand->name) }}
								<div class="row-actions">
									@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))

										<span id="{{ $brand->slug }}" class="show-edit btn btn-link text-secondary"><i class="far fa-edit"></i> Quick Edit</span> <span class="text-muted">|</span>

							        	<form method="post" action="{{ route('supply.brand.destroy', ['supgen' => $supgen->slug, 'supbrand' => $brand->slug]) }}" class="d-inline">
							        		@csrf
							        		@method('DELETE')
											<button class="btn btn-link text-danger"  onclick="return confirm('Are you sure you want to delete {{ ucfirst($brand->name) }} Generic Name?')" data-id="{{ $brand->name }}">
												<i class="fas fa-trash-alt"></i> Delete
											</button>
							        	</form>
									@endif
								</div>
							</td>
							<td class="text-center">
								{{ 
									$brand->supplies->where('availability', 0)
												    ->where('supgen_id', $supgen->id)
												    ->count()
								}}
							</td>
						</tr>
						<tr class="inline-edit-row form-hide form-hidden-{{ $brand->slug }}">
							<td colspan="3" >
								<fieldset class="inline-edit-col w-100">
									<form method="post" action="{{ route('supply.brand.update', ['supgen' => $supgen->slug, 'supbrand' => $brand->slug]) }}">
										@csrf
										@method('PUT')
										<p class="text-muted">QUICK EDIT</p>
										<span>Brand Name</span> <small class="font-italic text-muted">( Enter to save )</small>
										<input type="text" name="name" value="{{ $brand->name }}" class="form-control" required autocomplete="off">
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
			{{ $coll->links() }}
		</div>
	</div>
</div>

@if (session('duplicate') || session('delete_error'))
	<div id="err-msg" class="alert alert-danger">
		{{ session('duplicate') }}
		{{ session('delete_error') }}
	</div>
@endif

@error('name')
	<div id="err-msg" class="alert alert-danger">
		{{ $message }}
	</div>
@enderror

<!-- Modal Add -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header zp-bg-clan">
				<h5 class="modal-title text-white" id="exampleModalLongTitle">Add New Brand</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="fetch-form" method="post" action="{{ route('supply.brand.store', ['supgen'=>$supgen->slug]) }}">
					@csrf
					<div class="form-group">
						<input type="hidden" name="supgen_id" value="{{ $supgen->id }}">
						<label for="name">Brand Name</label>
						<input type="text" name="name" class="form-control" placeholder="Add Brand" value="{{ old('name') }}" required autocomplete="off">
						<div id="fetch_result"></div>
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
	<script text="text/javascript">
		jQuery(document).ready(function(){
			$("#fetch-form input[name='name']").on('keyup', function(e){
				e.preventDefault();
				var typed = $(this).val();
				var loc = location.href;
				var hostname = window.location.hostname;
				if (loc === "http://"+hostname+"/inventory/supply/register/{{ $supgen->slug }}") {
					var url = '/inventory/supply/fetch';
				}
				if (typed){
					$.ajax({
						type: 'GET',
						url: url,
						data: {'name':typed},
						success: function(response){
							document.getElementById("fetch_result").innerHTML = response;
						}
					});
				}else{
					document.getElementById("fetch_result").innerHTML = '';
				}
			});
			$(document).on('click', '#fetch-form #fetch_result ul li', function(){
			    var value = $(this).text();
			    $("input[name='name']").val(value);
			    $('#fetch_result').html("");
			});
		});
	</script>
	@if (session('duplicate') || session('delete_error'))
		<script text="text/javascript">
			jQuery(document).ready(function(){
				$("#err-msg").on('click', function(e){
					e.preventDefault();
					$(this).fadeOut('slow');
				});
			});
		</script>
	@endif
	@error('name')
		<script text="text/javascript">
			jQuery(document).ready(function(){
				$("#err-msg").on('click', function(e){
					e.preventDefault();
					$(this).fadeOut('slow');
				});
			});
		</script>
	@enderror
@endsection