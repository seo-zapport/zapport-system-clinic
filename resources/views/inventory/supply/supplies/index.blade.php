@extends('layouts.app')
@section('title', '| Generics')
@section('supplyinv', 'active')
@section('heading-title')
	<i class="fas fa-tablets text-secondary"></i> Medical Supplies
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
				<p class="zp-2a9">Total: <span>{{ $supplies->count() }}</span></p>
			</div>
			<div class="col-12 col-md-6 count_items">
				{{-- <p><span class="zp-tct">Total Items: </span> {{ $gens->count() }} <span  class="zp-ct"> Items</span></p> --}}
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Supply Name</th>
					<th>Supply Brand Name</th>
					<th width="10%" class="text-center">Quantity</th>
				</thead>
				<tbody>
					@foreach ($supplies as $supply)
						<tr>
							<td>{{ strtoupper($supply->supgen->name) }}</td>
							<td>{{ strtoupper($supply->supbrand->name) }}</td>
							<td>
								{{ 
									$supply->where('availability', 0)
										   ->where('supbrand_id', $supply->supbrand_id)
										   ->where('supgen_id', $supply->supgen_id)
										   ->where(function($expdate){
										   		$expdate->where('expiration_date', '>', NOW())
										   			    ->orWhereNull('expiration_date');
										   })
										   ->count()
								}}
							</td>
						</tr>
					@endforeach
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
			<div class="modal-header zp-bg-clan">
				<h5 class="modal-title text-white" id="exampleModalLongTitle">Add New Medical Supply</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="addSupplies" method="post" action="{{ route('supply.store') }}">
					@csrf
					<div class="form-group">
						<label for="supgen_id">Supply Name*</label>
						<select name="supgen_id" id="supgen_id" class="form-control" required>
							<option selected="true" disabled="disabled" value=""> Select Supply name </option>
							@foreach ($supgens as $gen)
								<option value="{{ $gen->id }}">{{ strtoupper($gen->name) }}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label for="supbrand_id">Supply Brand Name*</label>
						<select name="supbrand_id" id="supbrand_id" class="form-control" required>
							<option selected="true" disabled="disabled" value=""> Select Supply Brand </option>
						</select>
					</div>

					<div class="form-group">
						<label for="expiration_date">Expiration Date</label> <small class="text-muted">( Fill this up if supply has expiration date )</small>
						<input type="date" name="expiration_date" class="form-control" placeholder="Expiration Date" value="{{ old('expiration_date') }}">
					</div>
					<div class="form-group">
						<label for="quantity">Quantity*</label>
						<input type="number" name="quantity" class="form-control" placeholder="Quantity" value="{{ old('quantity') }}" required>
					</div>
					<div class="text-right">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button id="supBtn" type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
	<script text='text/javascript'>
		jQuery(document).ready(function(){
			$("select[name='supgen_id']").on('change', function(e){
				var gen = $(this).val();
				var hostname = window.location.hostname;
				var url   = window.location.pathname;

				if ("http://"+hostname+""+url ===  "http://"+hostname+"/inventory/supply") {
					var myUrl = 'supply/fetch';
				}
				$.ajax({
					type: 'GET',
					url: myUrl,
					data: {'supgen_id':gen},
					dataType: 'json',
					success: function(response){
						$("select[name='supbrand_id']").empty();
						$.each(response, function(key, value){
							$("select[name='supbrand_id']").append('<option value="'+ key +'">'+ value.toUpperCase() +'</option>');
						});
					}
				});
			});
			$("#addSupplies").on('click', '#supBtn', function(e){
				var supgen = $("select[name='supgen_id']").val();
				var supbrn = $("select[name='supbrand_id']").val();
				var supqty = $("input[name='quantity']").val();
				if (supgen != null && supbrn != null && supqty != null) {
					$("#supBtn").prop('disabled', true);
					$("#addSupplies").submit();
				}
			});
		});
	</script>
@endsection