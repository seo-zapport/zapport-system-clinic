@extends('layouts.app')
@section('title', '| Medicines | '.ucwords($generic->gname) . " | " . ucwords($medbrand->bname))
@section('medicine', 'active')
{{-- @section('dash-title', ucwords($generic->gname)) --}}
@section('heading-title')
	<i class="fas fa-pills text-secondary"></i> {{ ucwords($generic->gname) }}
@endsection
@section('dash-content')
@section('back')
<a href="{{ route('medicine.log', ['medbrand' => $medbrand->bname, 'generic' => $generic->gname]) }}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection
<div class="mb-4">
	<h1 class="zp-text">Brand Name: <strong class="zp-color-6b">{{ ucwords($medbrand->bname) }}</strong></h1>
	<h3 class="zp-text zp-text-16">Generic Name: {{ ucwords($generic->gname) }}</h3>
</div>
<form id="filter_med_history" method="get">
	<div class="form-row">
		<div class="form-group col-md-2">
			<input type="search" name="search_name" class="form-control" value="{{ (@$search_name != null) ? $search_name : '' }}" placeholder="Search for Names">
		</div>
		<div class="form-group col-md-2">
			<select name="search_date" id="search_date" class="form-control">
				<option selected disabled="true">Search for Date</option>
				@foreach ($dates as $date)
					<option {{ (@$search_date == $date->medical_date) ? 'selected' : '' }} value="{{ $date->medical_date }}">{{ Carbon\carbon::parse($date->medical_date)->format('M d, Y') }}</option>
				@endforeach
			</select>
			<span id="med_history_search_date" class="d-none text-muted font-weight-bold" style="cursor: pointer">Clear</span>
		</div>
		<div class="form-group col-md-2">
			<button class="btn btn-success">Search</button>
			<a href="{{ route('medicine.show', ['medbrand' => $medbrand->bname, 'generic' => $generic->gname, 'inputDate' => $inputDate, 'expDate' => 
					$expDate]) }}" class="btn btn-info text-white">Clear</a>
		</div>
		<div class="form-group col-md-6 text-right">
			<button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">PRINT <span class="caret"></span>
			</button>
			@php 
				$fileName = 'inventory_medicine';
			@endphp
			<ul class="dropdown-menu">
				<li class="nav-item-btn"><a class="btnPrint" href="#"><i class="fas fa-print text-secondary"></i>PRINT</a></li>
				<li class="nav-item-btn"><a href="{{ asset('storage/uploaded/print/inventory/'.@$fileName.'.csv')}}" download="{{ @$fileName.'.csv'}}" target="_blank"><i class="fas fa-file-csv text-secondary"></i>CSV</a></li>
			</ul>
		</div>
	</div>
</form>

<div class="card">
	<div class="card-body">
		<div class="table-responsive">
			<div id="medTotal"></div>
			<table id="MedTable" class="table table-hover">
				<thead class="thead-dark">
					{{-- <th>No.</th> --}}
					<th>Date Taken</th>
					<th>Name</th>
					<th>No. of medicine</th>
					<th>Given by</th>
				</thead>
				<tbody>
				@forelse ($meds as $med)
				<tr id="MedRow">
					<td>{{ $med->Distinct_date->format('M d, Y - h:i a') }}</td>
					<td>{{ $med->last_name }} {{ $med->first_name }}</td>
					<td>{{ $countMeds->where('empMeds_id', $med->empMeds_id)->where('patient', $med->patient)->where('distinct_user_id', $med->distinct_user_id)->where('Distinct_date', $med->Distinct_date)->count() }}</td>
					<td>{{ $med->givenLname }} {{ $med->givenFname }}</td>
				</tr>
				@empty
				<tr>
					<td colspan="4" class="text-center">No Records Yet!</td>
				</tr>
				@endforelse

				</tbody>
			</table>			
		</div>
	</div>
</div>

{{ $meds->links() }}

<script type="application/javascript">
	        
	jQuery(document).ready(function($){
		jQuery(window).on('hashchange', function(e){
		    history.replaceState ("", document.title, e.originalEvent.oldURL);
		});

		var countTR = $("#MedTable tbody #MedRow").length;
		$("#medTotal").html('');
		$("#medTotal").append('<span class="font-weight-bold">Result: '+ countTR +'</span>');

		 $('.btnPrint').printPage({
		  url: "{{ asset('storage/uploaded/print/inventory/inventory_medicine.html') }}",
		  attr: "href",
		  message:"Your document is being created"
		});
	});

</script>
@endsection
