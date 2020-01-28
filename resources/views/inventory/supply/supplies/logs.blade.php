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
					@endforelse
				</tbody>
			</table>
		</div>
		{{ $raw->links() }}
	</div>
</div>
@endsection