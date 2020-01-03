@extends('layouts.app')
@section('title', '| Inventory Monitoring')
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
<span id="showFilterDate" class="text-secondary font-weight-bold mb-3 d-inline-block" style="cursor: pointer;">Date Filter <i class="fas fa-user-cog"></i></span>
<div id="dateFilter" class="col-12 p-0 {{ (isset($_GET['filter_date']) ? '' : 'd-none') }}">
	<form id="admin_inv" method="get">
		<div class="row zp-filters mb-3">
			<div class="col-12 col-md-6">
				<div class="form-row">
					<div class="form-group col-md-8 mb-0 position-relative">
						<div class="input-group">
							<select name="filter_date" id="filter_date" class="form-control">
								@if (isset($_GET['filter_date']))
									<option value="{{ $filter }}">{{ Carbon\carbon::parse($filter)->format('M d, Y') }}</option>
								@else
									<option selected disabled='true'>Filter Date</option>
								@endif
								@forelse ($dates->unique('fdate') as $date)
									@if (isset($_GET['filter_date']))
										@if ($date->fdate != $filter)
											<option value="{{ $date->fdate }}" {{ ($filter == $date) ? 'selected' : '' }} >{{ Carbon\carbon::parse($date->fdate)->format('M d, Y') }}</option>
										@endif
									@else
										<option value="{{ $date->fdate }}">{{ Carbon\carbon::parse($date->fdate)->format('M d, Y') }}</option>
									@endif
								@empty
									<option selected disabled='true'>Empty</option>
								@endforelse
							</select>
							<span id="med_log_search_date" class="d-none font-weight-bold zp-filter-clear">x</span>
							<div class="input-group-append">
								<button type="submit" class="btn btn-success mr-2">Search</button>
								<a href="{{ route('admin.inventory') }}" class="btn btn-info text-white">Clear</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="card mb-5">
	<div class="card-body">
		<div class="row zp-countable">
			@if (isset($_GET['filter_date']))
				<div class="col-12">
					<h4>
						{{ strtoupper(Carbon\carbon::parse($_GET['filter_date'])->isoFormat('MMMM Do, YYYY')) }}
					</h4>
				</div>
			@endif
			<div class="col-12 col-md-6"><p class="zp-2a9">Total number of Medicines: <span>{{ $total_meds }}</span></p></div>
			<div id="InvMedTotal" class="col-12 col-md-6 zp-countable"></div>
		</div>
		<div class="table-responsive">
			<table id="InvMonTable" class="table table-hover">
				<thead class="thead-dark">
					{{-- <th>No.</th> --}}
					<th>{{ (isset($_GET['filter_date']) ? 'Time' : 'Date') }}</th>
					<th>Generic Name</th>
					<th>Brand Name</th>
					<th>Input by:</th>
					<th width="10%" class="text-center">Quantity</th>
				</thead>
				<tbody>
					@forelse ($meds as $med)
						<tr id="InvMonRow">
							<td>
								@if (isset($_GET['filter_date']))
									{{ Carbon\carbon::parse($med->created_at)->format('h:i:sa') }}
								@else
									{{ Carbon\carbon::parse($med->created_at)->format('M d, Y') }}
								@endif
							</td>
							<td>{{ strtoupper($med->generic->gname) }}</td>
							<td>{{ strtoupper($med->medbrand->bname) }}</td>
							<td>{{ ucfirst($med->user->name) }}</td>
							<td class="text-center">{{ $med->remaining }}</td>
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
		
		$("#showFilterDate").on('click', function(e){
			e.preventDefault();
			$("#dateFilter").toggleClass('d-none');
		});

		$(window).on('hashchange', function(e){
		    history.replaceState ("", document.title, e.originalEvent.oldURL);
		});

		var countTR = $("#InvMonTable tbody #InvMonRow").length;
		$("#InvMedTotal").html('');
		$("#InvMedTotal").append('<p class="count_items"><span class="zp-tct">Total Items: </span>'+ countTR +' <span  class="zp-ct"> Items</span></p>');

		 
	});

</script>
@endsection


