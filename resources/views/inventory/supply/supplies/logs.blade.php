@extends('layouts.app')
@section('title', '| Medicines | '.ucwords($supgen->name) . " | " . ucwords($supbrand->name))
@section('supplyinv', 'active')
{{-- @section('dash-title', ucwords($generic->gname)) --}}
@section('heading-title')
	<i class="fas fa-pills text-secondary"></i> {{ ucwords($supgen->name) }}
@endsection
@section('dash-content')
<div class="mb-4">
	<h1 class="zp-text">Brand Name: <strong class="zp-color-6b">{{ ucwords($supbrand->name) }}</strong></h1>
	<h3 class="zp-text zp-text-16">Supply Name: {{ ucwords($supgen->name) }}</h3>
</div>
<form id="filter_med_history" method="get" class="zp-filters" autocomplete="off">
	<div class="form-row">
		<div class="form-group col-md-3">
			<input type="search" name="search_name" class="form-control" value="{{ @$_GET['search_name'] }}" placeholder="Search for Names">
		</div>
		<div class="form-group col-md-3">
			<div class="input-group">
				<select name="search_date" id="search_date" class="form-control">
					@if (isset($_GET['search_date']))
						<option selected="true" value="{{ $_GET['search_date'] }}">{{ Carbon\carbon::parse($_GET['search_date'])->format('M d, Y') }}</option>
					@else
						<option selected disabled="true">Search for Date</option>
					@endif
					@foreach ($dates->unique('fdate') as $date)
						<option value="{{ $date->fdate }}">{{ Carbon\carbon::parse($date->fdate)->format('M d, Y') }}</option>
					@endforeach
				</select>
				{{-- <span id="med_history_search_date" class="d-none text-muted font-weight-bold  zp-filter-clear">x</span> --}}
				<div class="input-group-append">
					<button class="btn btn-success mr-2">Search</button>
					<a href="{{ route('supply.showLogs', ['supgen' => $supgen->slug, 'supbrand' => $supbrand->slug, 'created' => $created]) }}" class="btn btn-info text-white">Clear</a>
				</div>
			</div>
		</div>
		<div class="form-group col-md-6 text-right">
			<!--- PRINT --->
			<button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">PRINT <span class="caret"></span>
			</button>
			@php 
				$fileName = 'supplies_inventory';
			@endphp
			<div class="dropdown-menu print_dropdown">
				 <a href="#" class="btnPrint dropdown-item"><i class="fas fa-print text-secondary"></i> PRINT</a>
				 <a href="{{ asset('storage/uploaded/print/inventory/supplies_inventory.csv')}}" class="dropdown-item" download="{{ @$fileName.'.csv'}}" target="_blank"><i class="fas fa-file-csv text-secondary"></i> CSV</a>
			</div>
		</div>

	</div>
</form>
<div class="card mb-3">
	<div class="card-body">
		<div id="medTotal" class="mb-3"></div>
		<div class="table-responsive">
			<table id="MedTable" class="table table-hover">
				<thead class="thead-dark">
					{{-- <th>No.</th> --}}
					<th>Date Taken</th>
					<th>Name</th>
					<th>No. of Supply</th>
					<th>Given by</th>
				</thead>
				<tbody>
					@forelse($raw as $row)
						<tr>
							<td>{{ Carbon\carbon::parse($row->date_given)->format('M d, Y - h:i:sa') }}</td>
							<td>{{ ucwords($row->requested_Fname) }} {{ ucwords($row->requested_Lname) }}</td>
							<td>{{ $row->sup_avail }}</td>
							<td>{{ ucwords($row->givenBy_Fname) }} {{ ucwords($row->givenBy_Lname) }}</td>
						</tr>
					@empty
						<tr>
							<td colspan="4" class="text-center">0 Result Found!</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		{{ $raw->links() }}
	</div>
</div>
@endsection



@section('scripts')
	<script text='text/javascript'>
		jQuery(document).ready(function(){
				$(window).on('hashchange', function(e){
			    history.replaceState ("", document.title, e.originalEvent.oldURL);
			});

			//var countTR = $("#MedTable tbody #MedRow").length;
			//$("#medTotal").html('');
			//$("#medTotal").append('<p class="count_items"><span class="zp-tct">Total Items: </span>'+ countTR +' <span  class="zp-ct"> Items</span></p>');

			 $('.btnPrint').printPage({
			  url: "{{ asset('storage/uploaded/print/inventory/supplies_inventory.html') }}",
			  attr: "href",
			  message:"Your document is being created"
			});

		});
	</script>
@endsection


