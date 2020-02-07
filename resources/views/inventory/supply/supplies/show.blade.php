@extends('layouts.app')
@section('title', '| Generics')
@section('supplyinv', 'active')
@section('heading-title')
	<i class="fas fa-tablets text-secondary"></i> Medical Supplies
@endsection
@section('dash-content')

<div class="mb-4">
	<h1 class="zp-text">Brand Name: <strong class="zp-color-6b">{{ ucwords($supbrand->name) }}</strong></h1>
	<h3 class="zp-text zp-text-16">Supply Name: {{ ucwords($supgen->name) }}</h3>
</div>
<form id="meds_log" method="get">
	<div class="row zp-filters mb-3">
		<div class="col-12 col-md-6">
			<div class="form-row">
				<div class="form-group col-md-8 mb-0 position-relative">
					<div class="input-group">
						<select name="search" id="search" class="form-control">
							@if (isset($_GET['search']))
								<option selected value="{{ $_GET['search'] }}">{{ Carbon\carbon::parse($_GET['search'])->format('M d, Y') }}</option>
							@else
								<option selected disabled='true'>Filter Date</option>
							@endif
							@forelse($dates->unique('fdate') as $date)
							@if (@$_GET['search'] != $date->fdate)
								<option value="{{ $date->fdate }}">{{ Carbon\carbon::parse($date->fdate)->format('M d, Y') }}</option>
							@endif
							@empty
							@endforelse
						</select>
						{{-- <span id="med_log_search_date" class="d-none font-weight-bold zp-filter-clear">x</span> --}}
						<div class="input-group-append">
							<button type="submit" class="btn btn-success mr-2">Search</button>
							<a href="{{ route('supply.show', ['supgen' => $supgen->slug, 'supbrand' => $supbrand->slug]) }}" class="btn btn-info text-white">Clear</a>
						</div>
					</div>
				</div>
				<div class="form-group col-12 col-md-4 mb-0 mt-2">
					<label class="form-check-label" for="exampleCheck1"> 
					<input type="checkbox" {{ (isset($_GET['expired'])) ? 'checked' : '' }} id="exampleCheck1" name="expired" onclick="this.form.submit()"> Filter Expired Medical Supplies</label>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-6">
			@php 
				$fileName = 'supplies_inventory';
			@endphp
			<div class="form-check">
				<div class="text-right">
					<!--- PRINT --->
					<button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">PRINT <span class="caret"></span>
					</button>
					<ul class="dropdown-menu print_dropdown">
						<a class="btnPrint dropdown-item" href="#"><i class="fas fa-print text-secondary"></i> PRINT All</a>
						@if(app('request')->input('expired') != 'on')
						<a class="btnPrintlog dropdown-item" href="#"><i class="fas fa-print text-secondary"></i> PRINT Available</a>
						<a class="btnPrintexpire dropdown-item" href="#"><i class="fas fa-print text-secondary"></i> PRINT Expired</a>
						@endif
						<a href="{{ asset('storage/uploaded/print/inventory/'.@$fileName.'.csv')}}" class="dropdown-item" download="{{ @$fileName.'.csv'}}" target="_blank"><i class="fas fa-file-csv text-secondary"></i> CSV All</a></li>
						@if(app('request')->input('expired') != 'on')
						<a href="{{ asset('storage/uploaded/print/inventory/'.@$fileName.'_log.csv')}}" class="dropdown-item" download="{{ @$fileName.'_log.csv'}}" target="_blank"><i class="fas fa-file-csv text-secondary"></i> CSV Available</a></li>
						<a href="{{ asset('storage/uploaded/print/inventory/'.@$fileName.'_expired.csv')}}" class="dropdown-item" download="{{ @$fileName.'_expired.csv'}}" target="_blank"><i class="fas fa-file-csv text-secondary"></i> CSV Expired</a></li>
						@endif
					</ul>
				</div>
			</div>
		</div>
	</div>
</form>

<div class="card mb-3">
	<div class="card-body">
		<div class="row zp-countable">
			<div class="col-12 col-md-6">
				{{-- <p class="zp-2a9">Total: <span>{{ $supplies->count() }}</span></p> --}}
			</div>
			<div class="col-12 col-md-6 count_items">
				{{-- <p><span class="zp-tct">Total Items: </span> {{ $gens->count() }} <span  class="zp-ct"> Items</span></p> --}}
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Input by</th>
					<th>Input Date</th>
					<th>Date Expire</th>
					<th>Remaining Quantity</th>
					<th>No. of deducted Supply</th>
					<th>No. of Supply</th>
				</thead>
				<tbody>
					@forelse($rawSup as $supply)
						<tr class="{{ ($supply->expiration_date != NULL && $supply->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
							<td>
								{{ ucwords($supply->user->employee->first_name) }}
								<div class="row-actions">
									<a href="{{ route('supply.showLogs', ['supgen' => $supply->supgen->slug, 'supbrand' => $supply->supbrand->slug, 'created' => $supply->created_at]) }}" class="show-edit btn btn-link {{ ($supply->expiration_date != NULL && $supply->expiration_date <= NOW()) ? 'bg-danger text-white' : 'text-secondary' }}">
										<i class="far fa-eye"></i>View
									</a>
								</div>
							</td>
							<td>{{ Carbon\carbon::parse($supply->created_at)->format('M d, Y - h:i:sa') }}</td>
							<td class="{{ ($supply->expiration_date == NULL) ? 'text-muted' : '' }}">
								{{ ($supply->expiration_date != NULL) ? Carbon\carbon::parse($supply->expiration_date)->format('M d, Y - h:i:sa') : 'NULL' }}
							</td>
							<td>
								{{ 
									$supply->where('user_id', $supply->user_id)
										   ->where('supbrand_id', $supply->supbrand_id)
										   ->where('supgen_id', $supply->supgen_id)
										   ->where('availability', 0)
										   ->where('created_at', $supply->created_at)
										   ->where('expiration_date', ($supply->expiration_date != NULL) ? $supply->expiration_date : NULL)
										   ->count()
								}}
							</td>
							<td>
								{{ 
									$supply->where('user_id', $supply->user_id)
										   ->where('supbrand_id', $supply->supbrand_id)
										   ->where('supgen_id', $supply->supgen_id)
										   ->where('availability', 1)
										   ->where('created_at', $supply->created_at)
										   ->where('expiration_date', ($supply->expiration_date != NULL) ? $supply->expiration_date : NULL)
										   ->count()
								}}
							</td>
							<td>
								{{ 
									$supply->where('user_id', $supply->user_id)
										   ->where('supbrand_id', $supply->supbrand_id)
										   ->where('supgen_id', $supply->supgen_id)
										   ->where('created_at', $supply->created_at)
										   ->where('expiration_date', ($supply->expiration_date != NULL) ? $supply->expiration_date : NULL)
										   ->count()
								}}
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="6" class="text-center">0 Result Found!</td>
						</tr>
					@endforelse
				</tbody>
			</table>
			{{ $rawSup->links() }}
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="application/javascript">

	jQuery(document).ready(function($){
		jQuery(window).on('hashchange', function(e){
		    history.replaceState ("", document.title, e.originalEvent.oldURL);
		});

		/*var countTR = $("#MedTable tbody #MedRow").length;
		$("#medTotal").html('');
		$("#medTotal").append('<span>'+ countTR +' items</span>');*/
		 
		 $('.btnPrint').printPage({
    	  	url: "{{ asset('storage/uploaded/print/inventory/supplies_inventory.html') }}",
    	  	attr: "href",
    	  	message:"Your document is being created"
    	});

		$('.btnPrintexpire').printPage({
			url: "{{ asset('storage/uploaded/print/inventory/supplies_inventory_printexp.html') }}",
			attr: "href",
			message:"Your document is being created"
		}); 

		$('.btnPrintlog').printPage({
			url: "{{ asset('storage/uploaded/print/inventory/supplies_inventory_printlog.html') }}",
			attr: "href",
			message:"Your document is being created"
		});
		 
	});

</script>
@endsection