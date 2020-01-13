@extends('layouts.app')
@section('title', '| Medicines')
@section('medicine', 'active')
@section('heading-title')
	<i class="fas fa-pills text-secondary"></i> List of Medicines
@endsection
@section('dash-content')

<div class="row zp-filters">
	<div class="col-12 col-md-6">
		<form id="diagnosis_suggetions" method="get" autocomplete="off">
			<div class="form-row">
		        <div class="form-group col-12 col-md-8 mb-0">
			        <div class="input-group">
			            <input type="search" name="search" class="form-control" value="{{ (!empty($search)) ? $search : '' }}" placeholder="Search for Generic Name">
			            <div id="suggestions_list" class="autocomplete-items" style="position: absolute; width: 75%; padding-right: 10px; margin-top: 37px;"></div>
			            <div class="input-group-append">
			                <button type="submit" class="btn btn-success mr-2">Search</button>
							<a href="{{ route('medicine') }}" class="btn btn-info text-white">Clear</a>
			            </div>
			        </div>
		        </div>
			</div>
		</form>
	</div>
	@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
		<div class="col-12 col-md-6">
			<div class="form-group text-right">
				<a class="btn btn-info text-white" href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Add New</a>
				<!--- PRINT --->
				<button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">PRINT <span class="caret"></span>
				</button>
				@php 
					$fileName = 'inventory_medicine';
				@endphp
				<div class="dropdown-menu print_dropdown">
					 <a href="#" class="btnPrint dropdown-item"><i class="fas fa-print text-secondary"></i> PRINT</a>
					 <a href="{{ asset('storage/uploaded/print/inventory/inventory_medicine.csv')}}" class="dropdown-item" download="{{ @$fileName.'.csv'}}" target="_blank"><i class="fas fa-file-csv text-secondary"></i> CSV</a>
				</div>
			</div>
		</div>
	@endif
</div>

<div class="card mb-3">
	<div class="card-body">
		<div class="row zp-countable">
			<div class="col-12 col-md-6"><p class="zp-2a9">Total number of Medicines: <span>{{ $total_meds }}</span></p></div>
			<div id="medTotal" class="col-12 col-md-6 zp-countable"></div>
		</div>
		<div class="table-responsive">
			<table id="MedTable" class="table table-hover">
				<thead class="thead-dark">
					<th>Generic Name</th>
					<th width="25%">Brand Name</th>
					<th width="25%" class="text-center">
						<form method="get">
							<div class="col-12">
								Remaining Quantity &nbsp;
								<input type="checkbox" {{ (isset($_GET['filter_meds'])) ? 'checked' : '' }} id="exampleCheck1" name="filter_meds" onclick="this.form.submit()">
								<small class="text-muted font-weight-bold">(Sort)</small>
							</div>
						</form>
					</th>
				</thead>
				<tbody>
					
					@if ($meds != null)		
					@forelse ($meds as $med)
						<tr id="MedRow">
							<td>{{ strtoupper($med->generic->gname) }}
								<div class="row-actions">
									<a href="{{ route('medicine.log', ['medbrand' => $med->medBrand->bname_slug, 'generic' => $med->generic->gname_slug]) }}" class="show-edit btn btn-link text-secondary">
										<i class="far fa-eye"></i>View
									</a>
								</div>
							</td>
							<td>{{ strtoupper($med->medBrand->bname) }}</td>
							<td class="text-center">{{ $med->where('generic_id', $med->generic_id)->where('brand_id', $med->brand_id)->where('availability', 0)->where('expiration_date', '>', NOW())->count() }}</td>
						</tr>
						@empty
							<tr>
								<td colspan="4" class="text-center">{{ "No registered Medicine yet!" }}</td>
							</tr>
					@endforelse
					@else
						<tr>
							<td colspan="4" class="text-center">{{ "No Record Found!" }}</td>
						</tr>
					@endif
				</tbody>
			</table>			
		</div>
	</div>
</div>

@if ($meds != null)
	<div class="pagination-wrap">{{ $meds->links() }}</div>
@endif
<br>
@include('layouts.errors')

<!-- Modal Add -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add New Medicine</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="addMds" method="post" action="{{ route('medicine.add') }}">
					@csrf
					<div class="form-group">
						<label for="generic_id">Generic Name</label>
						<select name="generic_id" id="generic_id" class="form-control" required>
							<option selected="true" disabled="disabled" value=""> Select Generic name </option>
							@foreach ($gens as $gen)
								@if ($gen->medbrand->count() > 0)
									<option value="{{ $gen->id }}">{{ strtoupper($gen->gname) }}</option>
								@endif
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label for="brand_id">Brand Name</label>
						<select name="brand_id" id="brand_id" class="form-control" required>
							<option selected="true" disabled="disabled" value=""> Select Brand </option>
						</select>
					</div>

					<div class="form-group">
						<label for="expiration_date">Expiration Date</label>
						<input type="date" name="expiration_date" class="form-control" placeholder="Expiration Date" value="{{ old('expiration_date') }}" required>
					</div>
					<div class="form-group">
						<label for="qty_input">Quantity</label>
						<input type="number" name="qty_input" class="form-control" placeholder="Quantity" value="{{ old('qty_input') }}" required>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button id="medBtn" type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
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

		var countTR = $("#MedTable tbody #MedRow").length;
		$("#medTotal").html('');
		$("#medTotal").append('<p class="count_items"><span class="zp-tct">Total Items: </span>'+ countTR +' <span  class="zp-ct"> Items</span></p>');

		 $('.btnPrint').printPage({
		  url: "{{ asset('storage/uploaded/print/inventory/inventory_medicine.html') }}",
		  attr: "href",
		  message:"Your document is being created"
		});
	});

</script>
@endsection
