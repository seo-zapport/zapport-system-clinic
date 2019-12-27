@extends('layouts.app')
@section('title', '| Dashboard')
@section('inventory_monitoring', 'active')
{{-- @section('dash-title', 'Dashboard Overview') --}}
@section('heading-title')
	<i class="fas fa-pills text-secondary"></i> Inventory Monitoring
@endsection

@section('dash-content')
<div class="col-12 col-md-6 p-0">
	<form id="diagnosis_suggetions" method="get" autocomplete="off">
		<div class="form-row">
	        <div class="form-group col-12 col-md-8">
		        <div class="input-group">
		            <input type="search" name="search" class="form-control" value="{{ (!empty($search)) ? $search : '' }}" placeholder="Search for Generic / Brand / Input by:">
		            <div class="input-group-append">
		                <button type="submit" class="btn btn-success mr-2">Search</button>
						<a href="{{ route('admin.inventory') }}" class="btn btn-info text-white">Clear</a>
		            </div>
		        </div>
	        </div>
		</div>
	</form>	
</div>
<div class="card mb-5">
	<div class="card-body">
		<div class="row zp-countable">
			<div class="col-12 col-md-6"><p class="zp-2a9">Total number of Medicines: <span>{{ $total_meds }}</span></p></div>
			<div id="InvMedTotal" class="col-12 col-md-6 zp-countable"></div>
		</div>
		<div class="table-responsive">
			<table id="InvMonTable" class="table table-hover">
				<thead class="thead-dark">
					{{-- <th>No.</th> --}}
					<th>Generic Name</th>
					<th>Brand Name</th>
					<th>Input by:</th>
					<th width="10%" class="text-center">Quantity</th>
				</thead>
				<tbody>
					@forelse ($meds as $med)
						<tr id="InvMonRow">
							<td>{{ strtoupper($med->generic->gname) }}</td>
							<td>{{ strtoupper($med->medbrand->bname) }}</td>
							<td>{{ ucfirst($med->user->name) }}</td>
							<td class="text-center">{{ $med->qty_stock }}</td>
						</tr>
						@empty
						<tr>
							<td colspan="4" class="text-center">0 Result Found!</td>
						</tr>
					@endforelse
				</tbody>
			</table>
			{{ $meds->links() }}
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="application/javascript">

	jQuery(document).ready(function($){
		
		$(window).on('hashchange', function(e){
		    history.replaceState ("", document.title, e.originalEvent.oldURL);
		});

		var countTR = $("#InvMonTable tbody #InvMonRow").length;
		$("#InvMedTotal").html('');
		$("#InvMedTotal").append('<p class="count_items"><span class="zp-tct">Total Items: </span>'+ countTR +' <span  class="zp-ct"> Items</span></p>');

		 
	});

</script>
@endsection


