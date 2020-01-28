@extends('layouts.app')
@section('title', "| " .ucwords($employee->last_name) . '\'s information')
@section('employeesMedical', 'active')
{{-- @section('dash-title', ucwords($employee->last_name) . '\'s information') --}}
@section('heading-title')
	<i class="fas fa-list text-secondary"></i> {{ ucwords($employee->last_name) . '\'s information' }}
@endsection
@section('dash-content')
@section('back')
<a href="{{ route('medical.listsofemployees') }}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection
<div class="card mb-3">
	<div class="card-body">
		<div class="row">
			<div class="col-12 col-md-4 col-lg-3">
				@if (@$employee->profile_img != null)
					<div class="employee_wrap mb-0">
						<div class="panel employee-photo rounded">
							<img src="{{ asset('storage/uploaded/'.@$employee->profile_img) }}" alt="{{ @$employee->profile_img }}" class="img-fluid rounded"  onerror="javascript:this.src='{{ asset('/images/default.png' )}}'">
						</div>
					</div>
				@endif
			</div>
			<div class="col-12 col-md-8 col-lg-9">
				<div class="row mb-3">
					<div class="col-12 col-md-6">
						<p class="med-name">{{ ucwords($employee->last_name . " " . $employee->first_name . " " . $employee->middle_name) }}</p>
					</div>
					<div class="col-12 col-md-6 print-col">
						<div class="btn-group print-group" role="group">
							<button id="btnGroupDrop1" type="button" class="btn  {{ (@$employee->preemployment == null ) ? 'btn-secondary ' : 'btn-success' }} dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Pre-employment Medical
							</button>
							<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
								@if (@$employee->preemployment == null)
									@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
										<a class="dropdown-item" href="#" data-toggle="modal" data-target="#pre-emp"><i class="fas fa-folder-plus"></i> Add</a>
									@else
										<a class="dropdown-item" href="#" onclick="return confirm('Access denied! Only Doctor or Nurse can add an Item')"><i class="fas fa-folder-plus"></i> Add</a>
									@endif
								@else
									@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
										<form method="POST" action="{{ route('pre_emp.delete', ['pre_emp.delete' => @$employee->preemployment->id]) }}">
											@csrf
											@method('DELETE')
											<button class="dropdown-item text-danger"  onclick="return confirm('Are you sure you want to delete {{ @$employee->preemployment->pre_employment_med }} File?')" data-id="{{ @$employee->preemployment->id }}">
												<i class="fas fa-trash-alt"></i> Remove
											</button>
										</form>
									@endif
										<div class="dropdown-divider"></div>
										<a class="dropdown-item text-info" href="{{ route('pre_emp.download', ['pre_emp' => @$employee->preemployment->pre_employment_med]) }}" download><i class="far fa-eye"></i> View</a>
								@endif
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-md-4 col-lg-3">
						<p class="mb-2"><span class="text-dark font-weight-bold">Department</span>: {{ strtoupper($employee->departments->department) }}</p>
						<p class="mb-2"><span class="text-dark font-weight-bold">Position</span>: {{ ucwords($employee->positions->position) }}</p>
					</div>
					<div class="col-12 col-md-4 col-lg-3">
						<p class="mb-2"><span class="text-dark font-weight-bold">Gender</span>: {{ (@$employee->gender == 0) ? "Male" : "Female" }}</p>
						<p class="mb-2"><span class="text-dark font-weight-bold">Age</span>: {{ @$employee->age }}</p>
					</div>
					<div class="col-12 col-md-4 col-lg-3">
						<p class="mb-2"><span class="text-dark font-weight-bold">Birthday</span>: {{ @$employee->birthday->format('M d, Y') }}</p>
						<p class="mb-2"><span class="text-dark font-weight-bold">Birth Place</span>: {{ ucwords(@$employee->birth_place) }}</p>
					</div>
					<div class="col-12 col-md-4 col-lg-3">
						<p class="mb-2"><span class="text-dark font-weight-bold">Contact</span>: {{ "+63" . @$employee->contact }}</p>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<br>
		<div class="row zp-filters">
			<div class="col-md-7">
				<form id="searchDiagnosis" method="get" autocomplete="off">
					<div class="form-row">
						<div class="form-group col-md-6 autocomplete">
							<div class="input-group">
								<input type="search" name="search" class="form-control" value="{{ (!empty($result)) ? $result : '' }}" placeholder="Search for Diagnosis">
								<div id="searchDiagnosis_list" class="autocomplete-items"></div>
								<div class="input-group-append">
									<button type="submit" class="btn btn-success mr-2">Search</button>
									<a href="{{ route('medical.employeeInfo', ['employee' => $employee->emp_id]) }}" class="btn btn-info text-white">Clear</a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))

				<div class="col-md-5">
					<div class="form-group text-right">
						<div class="btn-group">
							<button type="button" class="btn btn-info dropdown-toggle text-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								New
							</button>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModalCenter">Medical</a>
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#getSupply">Supply</a>
							</div>
						</div>
						@if ($search->count() > 0)
							<button class="btn btn-success text-white btnPrint">Print</button>
						@endif
						{{-- <button class="btn btn-info text-white" data-toggle="modal" data-target="#exampleModalCenter">New</button> --}}
						{{-- <a class="btn btn-success" href="{{ route('medical.form', ['employee'=>$employee->emp_id]) }}">Form</a> --}}
					</div>
				</div>
			@endif
		</div>

		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Medical Number</th>
					<th>Diagnosis</th>
					<th>Notes</th>
					<th>Date and Time</th>
					<th>Remarks</th>
				</thead>
				<tbody>
					@forelse ($search as $medsHistory)
						<tr>
							<td>{{ $medsHistory->med_num }}
								<div class="row-actions"><a href="{{ route('medical.show', ['employee' => $employee->emp_id, 'employeesmedical' => $medsHistory->med_num]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i> View</a></div>
							</td>
							<td>{{ ucwords($medsHistory->diagnoses->diagnosis) }}
							</td>
							<td>{{ Str::words($medsHistory->note, 15) }}</td>
							<td>{{ $medsHistory->created_at->format('M d, Y - h:i a') }}</td>
							<td>{{ ($medsHistory->remarks == 'followUp') ? 'Follow up' : 'Done' }}</td>
						</tr>
						@empty
							<tr>
								<td colspan="6" class="text-center">No Records Found!</td>
							</tr>
					@endforelse
				</tbody>
			</table>				
		</div> 
	
	</div>
</div>
<div class="pagination-wrap">{{ $search->links() }}</div>
@include('layouts.errors')
<!-- Modal Add Medical -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header zp-bg-clan">
				<h5 class="modal-title text-white" id="exampleModalLongTitle">Add New Record</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form onsubmit="return test(this)" id="myform" method="post" action="{{ route('medical.store', ['employee' => $employee->emp_id]) }}" enctype="multipart/form-data" autocomplete="off">
					@csrf
					<input type="hidden" name="employee_id" value="{{ $employee->id }}">
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="bodypart_id">Body Part</label>
							<select name="bodypart_id" id="bodypart_id" class="form-control">
								<option value="" disabled selected>Select Body Part</option>
								@foreach ($bparts as $bpart)
									@if (count($bpart->diseases) > 0)
										<option value="{{ $bpart->bodypart_slug }}">{{ ucwords($bpart->bodypart) }}</option>
									@endif
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-8">
							<label for="disease_id">Disease</label>
							<select name="disease_id" id="disease_id" class="form-control">
								<option value="" selected disabled>Select Diseases</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="diagnosis">Diagnosis</label>
						<input type="text" name="diagnosis" class="form-control" placeholder="Diagnosis" required pattern="[a-zA-Z0-9\s]+" title="Special Characters are not allowed!">
						<div id="diagnosis_list" class="autocomplete-items"></div>
					</div>
					<div class="form-group">
						<p class="mb-1">Attachment</p>
						<div class="input-group mb-3">
							<div class="custom-file">
								<input type="file" name="attachment" id="diagnosis" class="custom-file-input form-control-file file-upload">
								<label for="attachment" class="custom-file-label">Choose file</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="note">Note:</label>
						<textarea name="note" id="note" cols="10" rows="5" class="form-control" placeholder="Doctor's note" required></textarea>
					</div>

					<div class="form-group">
						<a id="addMedicine" class="btn btn-success text-white mb-2"><i class="fa fa-plus"></i> Medicine</a>
					</div>

					<div id="meds" class="form-row">
						<div class="form-group col-4 position-relative">
							<label for="generic_id">Generic Name</label>
							<select name="generic_id[0][0]" id="generic_id" class="form-control">
									<option selected="true" disabled="disabled" value=""> Select Generic Name </option>
									@forelse ($gens as $gen)
										@if ($gen->medbrand->count() > 0)
											<option value="{{ $gen->id }}">{{ strtoupper($gen->gname) }}</option>
										@endif
										@empty
										empty
									@endforelse
							</select>
							<span id="select_generic" class="d-none font-weight-bold zp-filter-clear">x</span>
						</div>
						<div class="form-group col-4">
							<label for="brand_id">Brand Name</label>
							<select name="brand_id[0][0]" id="brand_id" class="form-control">
									<option selected="true" disabled="disabled"> Select Medicine </option>
							</select>
						</div>
						<div class="form-group col-4">
							<label for="quantity">Quantity</label>
							<input type="number" name="quantity[0][0]" class="form-control" min="1" placeholder="Quantity">
						</div>
					</div>

					<hr>

					<div class="form-group">
						<a id="addMedicalSupply" class="btn btn-success text-white mb-2"><i class="fa fa-plus"></i> Medical Supplies</a>
					</div>

					<div id="supmeds" class="form-row">
						<div class="form-group col-4 position-relative">
							<label for="supgen_id">Supply Name</label>
							<select name="supgen_id[0][0]" id="supgen_id" class="form-control">
								<option selected="true" disabled="disabled" value=""> Select Supply Name </option>
								@forelse ($supplies as $supply)
									@if (@$supply->supbrands->count() > 0)
										<option value="{{ $supply->id }}">{{ strtoupper($supply->name) }}</option>
									@endif
									@empty
									empty
								@endforelse
							</select>
							<span id="select_supgen" class="d-none font-weight-bold zp-filter-clear">x</span>
						</div>
						<div class="form-group col-4">
							<label for="supbrand_id">Supply Brand Name</label>
							<select name="supbrand_id[0][0]" id="supbrand_id" class="form-control">
									<option selected="true" disabled="disabled"> Select Supply Brand </option>
							</select>
						</div>
						<div class="form-group col-4">
							<label for="supqty">Quantity</label>
							<input type="number" name="supqty[0][0]" class="form-control" min="1" placeholder="Quantity">
						</div>
					</div>

					<div class="form-group">
						<label for="remarks">Remarks</label>
						<select name="remarks" id="remarks" class="form-control" required>
							<option selected="true" disabled="disabled" value=""> Choose Remarks </option>
							<option value="followUp">Follow up</option>
							<option value="done">Done</option>
						</select>
					</div>

					<div class="text-right">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button id="sbmt" type="submit" class="btn btn-primary" onclick="test()">Save changes</button>
						{{-- <button onclick="test()">test</button> --}}
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="test"></div>

<!-- Modal Get Supply -->
<div class="modal fade" id="getSupply" tabindex="-1" role="dialog" aria-labelledby="getSupplyTitle" aria-hidden="true">
	<div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header zp-bg-clan">
				<h5 class="modal-title text-white" id="exampleModalLongTitle">Medical Supply Form</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="getSupplyForm" action="{{ route('medical.getSupply', ['employee' => $employee->emp_id]) }}" method="POST">
					@csrf
					<div class="form-group">
						<a id="addMedicalSupply2" class="btn btn-success text-white mb-2"><i class="fa fa-plus"></i> Medical Supplies</a>
					</div>

					<div id="supmeds2" class="form-row">
						<input type="hidden" name="employee_id" value="{{ $employee->id }}">
						<div class="form-group col-4 position-relative">
							<label for="supgen_id">Supply Name</label>
							<select name="supgen_id[0][0]" id="supgen_id" class="form-control" required>
								<option selected="true" disabled="disabled" value=""> Select Supply Name </option>
								@forelse (@$supplies as $supply)
									@if (@$supply->supbrands->count() > 0)
										<option value="{{ $supply->id }}">{{ strtoupper($supply->name) }}</option>
									@endif
									@empty
									empty
								@endforelse
							</select>
							<span id="select_supgen" class="d-none font-weight-bold zp-filter-clear">x</span>
						</div>
						<div class="form-group col-4">
							<label for="supbrand_id">Supply Brand Name</label>
							<select name="supbrand_id[0][0]" id="supbrand_id" class="form-control" required>
									<option selected="true" disabled="disabled"> Select Supply Brand </option>
							</select>
						</div>
						<div class="form-group col-4">
							<label for="supqty">Quantity</label>
							<input type="number" name="supqty[0][0]" class="form-control" min="1" placeholder="Quantity" required>
						</div>
					</div>

					<div class="text-right">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button id="sbmt" type="submit" class="btn btn-primary">Save changes</button>
						{{-- <button onclick="test()">test</button> --}}
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="pre-emp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header zp-bg-clan">
				<h5 class="modal-title text-white" id="exampleModalLabel">Pre Employement Medical</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="preEmpForm" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="input-group">
						<div class="custom-file">
							<input type="file" id="pre_employment_med" name="pre_employment_med" class="form-control-file file-upload" required>
							<label id="preemplabel" for="pre_employment_med" class="custom-file-label">Choose file</label>
						</div>
					</div>
				</div>
				<div class="form-group text-right">
					<button id="preEmpClosed" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script type="application/javascript">
jQuery(document).ready(function($) {

	// GET SUPPLY FORM
	$("#getSupplyForm select[name='supgen_id[0][0]']").on('change', function(e){
		e.preventDefault();
		var supgen = $(this).val();
		var supbrnd = $("#getSupplyForm select[name='supbrand_id[0][0]']");
		var supgn = $("#getSupplyForm select[name='supgen_id[0][0]");
		var supqty = $("#getSupplyForm input[name='supqty[0][0]']");
		if (supgen) {
			$("#select_supgen").removeClass('d-none');
		}else{
			$("#select_supgen").addClass('d-none');
		}
		var url   = window.location.href;
		var hostname = window.location.hostname;
		if (url === "http://"+hostname+"/medical/employees/"+'{{ $employee->emp_id }}') {
			var supUrl = '/medical/fetch/supply/';
		}
		$.ajax({
			type: 'get',
			url: supUrl+supgen,
			data: {'supgen_id':supgen},
			dataType: 'json',
			success: function(response){
				supbrnd.empty();
				$.each(response.brand, function(key, value){
					supbrnd.append('<option value="'+ key +'" class="text-capitalize">'+ value +'</option>');
				});
				fetchResult2(supbrnd, supgn, supqty);
			}
		});

		function fetchResult2(supbrnd, supgn, supqty) {
			$("#getSupplyForm select[name='supbrand_id[0][0]']").on('change', function(){
				var sbrnd = supbrnd.find(':selected').attr('value');
				var sgen = supgn.find(':selected').attr('value');
				console.log(sgen+'-'+sbrnd);
				$.ajax({
					type: 'get',
					url: '/medical/fetch/supply/'+sgen+'/'+sbrnd,
					dataType: 'json',
					success: function(response){
						supqty.attr('max', response);
						supqty.prop('required', true);
						supqty.prop('placeholder', 'Remaining stocks: '+response);
					}
				});
			});
			$("#getSupplyForm select[name='supbrand_id[0][0]']").each(function(){
				var sbrnd = supbrnd.find(':selected').attr('value');
				var sgen = supgn.find(':selected').attr('value');
				console.log(sgen+'-'+sbrnd);
				$.ajax({
					type: 'get',
					url: '/medical/fetch/supply/'+sgen+'/'+sbrnd,
					dataType: 'json',
					success: function(response){
						supqty.attr('max', response);
						supqty.prop('required', true);
						supqty.prop('placeholder', 'Remaining stocks: '+response);
					}
				});
			});
		}
	});

    var s = $('#addMedicalSupply2').length;
    var e = $('#MedSupply').length;
	$("#addMedicalSupply2").on('click', function(event){
	    $('<div id="supplyField2" class="col-12 form-row"><div class="mb-2 col-md-4"><select name="supgen_id['+s+']['+s+']" class="form-control" required><option selected="true" disabled="disabled" value=""> Select Supply Name </option>@foreach ($supplies as $supply)<option value="{{ $supply->id }}">{{ strtoupper($supply->name) }}</option>@endforeach</select></div><div class="mb-2 col-md-4"><select name="supbrand_id['+s+']['+s+']" class="form-control" required><option selected="true" disabled="disabled" value=""> Select Supply Brand </option></select></div><div class="mb-2 col-md-4"><input type="number" name="supqty['+s+']['+s+']" min="1" class="form-control" placeholder="Quantity" required></div><a id="removeChildren2" class="btn text-danger text-white position-absolute" style="right: -16px;top: 0px;"><i class="fa fa-times"></i></a></div>').appendTo('#supmeds2');

	    // ____________________________________________________________________________________________________

		var supbrnd = $("#getSupplyForm select[name='supbrand_id["+s+"]["+s+"]']");
		var supgn = $("#getSupplyForm select[name='supgen_id["+s+"]["+s+"]");
		var supqty = $("#getSupplyForm input[name='supqty["+s+"]["+s+"]']");
		$("#getSupplyForm select[name='supgen_id["+s+"]["+s+"]']").on('change', function(e){
			e.preventDefault();
			var supgen = $(this).val();
			var url   = window.location.href;
			var hostname = window.location.hostname;
			if (url === "http://"+hostname+"/medical/employees/"+'{{ $employee->emp_id }}') {
				var supUrl = '/medical/fetch/supply/';
			}
			$.ajax({
				type: 'get',
				url: supUrl+supgen,
				data: {'supgen_id':supgen},
				dataType: 'json',
				success: function(response){
					supbrnd.empty();
					$.each(response.brand, function(key, value){
						supbrnd.append('<option value="'+ key +'" class="text-capitalize">'+ value +'</option>');
					});
					fetchResult(supbrnd, supgn, supqty);
				}
			});

			function fetchResult(supbrnd, supgn, supqty) {
				supbrnd.on('change', function(){
					var sbrnd = $(this).find(':selected').attr('value');
					var sgen = supgn.find(':selected').attr('value');
					console.log(sgen+'-'+sbrnd);
					$.ajax({
						type: 'get',
						url: '/medical/fetch/supply/'+sgen+'/'+sbrnd,
						dataType: 'json',
						success: function(response){
							supqty.attr('max', response);
							supqty.prop('required', true);
							supqty.prop('placeholder', 'Remaining stocks: '+response);
						}
					});
				});
				supbrnd.each(function(){
					var sbrnd = $(this).find(':selected').attr('value');
					var sgen = supgn.find(':selected').attr('value');
					console.log(sgen+'-'+sbrnd);
					$.ajax({
						type: 'get',
						url: '/medical/fetch/supply/'+sgen+'/'+sbrnd,
						dataType: 'json',
						success: function(response){
							supqty.attr('max', response);
							supqty.prop('required', true);
							supqty.prop('placeholder', 'Remaining stocks: '+response);
						}
					});
				});
			}
		});
	    // ____________________________________________________________________________________________________

	    s++;
	})
    $("body").on("click", "#removeChildren2", function(event){
      if (s > 1) {
        $(this).parents("#supplyField2").remove();
        s--;
      }
    });

	// Fetch Medical Supply
	$("#myform select[name='supgen_id[0][0]']").on('change', function(e){
		e.preventDefault();
		var supgen = $(this).val();
		var supbrnd = $("select[name='supbrand_id[0][0]']");
		var supgn = $("select[name='supgen_id[0][0]");
		var supqty = $("input[name='supqty[0][0]']");
		if (supgen) {
			$("#select_supgen").removeClass('d-none');
		}else{
			$("#select_supgen").addClass('d-none');
		}
		var url   = window.location.href;
		var hostname = window.location.hostname;
		if (url === "http://"+hostname+"/medical/employees/"+'{{ $employee->emp_id }}') {
			var supUrl = '/medical/fetch/supply/';
		}
		$.ajax({
			type: 'get',
			url: supUrl+supgen,
			data: {'supgen_id':supgen},
			dataType: 'json',
			success: function(response){
				supbrnd.empty();
				$.each(response.brand, function(key, value){
					supbrnd.append('<option value="'+ key +'" class="text-capitalize">'+ value +'</option>');
				});
				fetchResult(supbrnd, supgn, supqty);
			}
		});

		function fetchResult(supbrnd, supgn, supqty) {
			$("#myform select[name='supbrand_id[0][0]']").on('change', function(){
				var sbrnd = supbrnd.find(':selected').attr('value');
				var sgen = supgn.find(':selected').attr('value');
				console.log(sgen+'-'+sbrnd);
				$.ajax({
					type: 'get',
					url: '/medical/fetch/supply/'+sgen+'/'+sbrnd,
					dataType: 'json',
					success: function(response){
						supqty.attr('max', response);
						supqty.prop('required', true);
						supqty.prop('placeholder', 'Remaining stocks: '+response);
					}
				});
			});
			$("#myform select[name='supbrand_id[0][0]']").each(function(){
				var sbrnd = supbrnd.find(':selected').attr('value');
				var sgen = supgn.find(':selected').attr('value');
				console.log(sgen+'-'+sbrnd);
				$.ajax({
					type: 'get',
					url: '/medical/fetch/supply/'+sgen+'/'+sbrnd,
					dataType: 'json',
					success: function(response){
						supqty.attr('max', response);
						supqty.prop('required', true);
						supqty.prop('placeholder', 'Remaining stocks: '+response);
					}
				});
			});
		}
	});

    var l = $('#addMedicalSupply').length;
    var j = $('#MedSupply').length;
	$("#addMedicalSupply").on('click', function(event){
	    $('<div id="supplyField" class="col-12 form-row"><div class="mb-2 col-md-4"><select name="supgen_id['+l+']['+l+']" class="form-control" required><option selected="true" disabled="disabled" value=""> Select Supply Name </option>@foreach ($supplies as $supply)<option value="{{ $supply->id }}">{{ strtoupper($supply->name) }}</option>@endforeach</select></div><div class="mb-2 col-md-4"><select name="supbrand_id['+l+']['+l+']" class="form-control" required><option selected="true" disabled="disabled" value=""> Select Supply Brand </option></select></div><div class="mb-2 col-md-4"><input type="number" name="supqty['+l+']['+l+']" min="1" class="form-control" placeholder="Quantity" value=""></div><a id="removeChildren" class="btn text-danger text-white position-absolute" style="right: -16px;top: 0px;"><i class="fa fa-times"></i></a></div>').appendTo('#supmeds');

	    // ____________________________________________________________________________________________________

		var supbrnd = $("select[name='supbrand_id["+l+"]["+l+"]']");
		var supgn = $("select[name='supgen_id["+l+"]["+l+"]");
		var supqty = $("input[name='supqty["+l+"]["+l+"]']");
		$("#myform select[name='supgen_id["+l+"]["+l+"]']").on('change', function(e){
			e.preventDefault();
			var supgen = $(this).val();
			var url   = window.location.href;
			var hostname = window.location.hostname;
			if (url === "http://"+hostname+"/medical/employees/"+'{{ $employee->emp_id }}') {
				var supUrl = '/medical/fetch/supply/';
			}
			$.ajax({
				type: 'get',
				url: supUrl+supgen,
				data: {'supgen_id':supgen},
				dataType: 'json',
				success: function(response){
					supbrnd.empty();
					$.each(response.brand, function(key, value){
						supbrnd.append('<option value="'+ key +'" class="text-capitalize">'+ value +'</option>');
					});
					fetchResult(supbrnd, supgn, supqty);
				}
			});

			function fetchResult(supbrnd, supgn, supqty) {
				supbrnd.on('change', function(){
					var sbrnd = $(this).find(':selected').attr('value');
					var sgen = supgn.find(':selected').attr('value');
					console.log(sgen+'-'+sbrnd);
					$.ajax({
						type: 'get',
						url: '/medical/fetch/supply/'+sgen+'/'+sbrnd,
						dataType: 'json',
						success: function(response){
							supqty.attr('max', response);
							supqty.prop('required', true);
							supqty.prop('placeholder', 'Remaining stocks: '+response);
						}
					});
				});
				supbrnd.each(function(){
					var sbrnd = $(this).find(':selected').attr('value');
					var sgen = supgn.find(':selected').attr('value');
					console.log(sgen+'-'+sbrnd);
					$.ajax({
						type: 'get',
						url: '/medical/fetch/supply/'+sgen+'/'+sbrnd,
						dataType: 'json',
						success: function(response){
							supqty.attr('max', response);
							supqty.prop('required', true);
							supqty.prop('placeholder', 'Remaining stocks: '+response);
						}
					});
				});
			}
		});

	    // ____________________________________________________________________________________________________

	    l++;
	})
    $("body").on("click", "#removeChildren", function(event){
      if (l > 1) {
        $(this).parents("#supplyField").remove();
        l--;
      }
    });

	// Fetch Disease_____________________________________________________________________________________________________________________________
	$("#myform select[name='bodypart_id']").on('change', function(e){
		e.preventDefault();
		var bodypart = $(this).val();
		var dis = $("#myform select[name='disease_id']");
		$.ajax({
			type: 'GET',
			url: '/medical/fetch/' + bodypart,
			data: {bodypart:bodypart},
			dataType: 'json',
			success: function(response){
				dis.empty();
				$.each(response.disease, function(key, value){
					dis.append('<option value="'+ key +'" class="text-capitalize">'+ value +'</option>');
				});
			}
		});
	});

    // Search input diagnosis_______________________________________________________________________________________________________________________

    $("input[name='diagnosis']").on('keyup', function(){
    	var query = $(this).val();
    	$.ajax({
    		url: "/medical/employees/diagnosis/"+query+"",
    		type: "GET",
    		data:{'diagnosis':query},
    		success:function(response){
    			$('#diagnosis_list').html(response);
    		}
    	});
    });

	$(document).on('click', '#myform #diag li', function(){
	    var value = $(this).text();
	    $("input[name='diagnosis']").val(value);
	    $('#diagnosis_list').html("");
	});

	// Search Diagnosis

    $("#searchDiagnosis input[name='search']").on('keyup', function(){
    	var query = $(this).val();
    	$.ajax({
    		url: "/medical/employees/diagnosis/"+query+"",
    		type: "GET",
    		data:{'diagnosis':query},
    		success:function(response){
    			console.log(response);
    			$('#searchDiagnosis_list').html(response);
    		}
    	});
    });

	$(document).on('click', '#searchDiagnosis #diag li', function(){
	    var value = $(this).text();
	    $("#searchDiagnosis input[name='search']").val(value);
	    $('#searchDiagnosis_list').html("");
	});

	//__________________________________________________________________________________________________________________________________________________ 



	$('.btnPrint').printPage({ 
		attr: "href",
		url: "{{ asset('storage/uploaded/print/medrecord/emp-med-info.html') }}",
		message:"Your document is being created",
	});

	$("#preEmpForm").on('change', function(e){
		e.preventDefault();
		var file = e.target.files[0].name;
		document.getElementById("preemplabel").innerHTML = file;
	});

	$("#preEmpForm").on('submit', function(e) {
		e.preventDefault();
       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });

        $.ajax({
        	type: 'POST',
        	url: '{{ route('medical.pre_emp', ['employee' => $employee->id]) }}',
        	data: new FormData($('#preEmpForm')[0]),
        	dataType: 'json',
			cache: false,
			processData: false,
			contentType: false,
			mimeType:"multipart/form-data",
			success:function(response){
				console.log(response);
				$("#pre-emp").modal('hide');
				location.reload();
			}
        });
	});

	$("#preEmpForm #preEmpClosed").on("click", function(e){
		e.preventDefault();
		document.getElementById("preemplabel").innerHTML = 'Choose file'
		$("input[name='pre_employment_med']").val('');
	});

   $('#myform').on('submit', function(e){
		var btn = $('#sbmt');
		btn.prop('disabled', true);
		setTimeout(function(){btn.prop('disabled', false); }, 3000);
    });


    var i = $('#addMedicine').length;
    var e = $(this).find('.editmedicine').length;
    var o = $('#editMedicine').length;
    $("#addMedicine").click(function(event) {
    	$('<div id="medicineField" class="col-12 form-row"><div class="mb-2 col-md-4"><select name="generic_id['+i+']['+i+']" id="generic_id" class="form-control" required><option selected="true" disabled="disabled" value=""> Select Generic Name </option>@foreach ($gens as $gen)<option value="{{ $gen->id }}">{{ strtoupper($gen->gname) }}</option>@endforeach</select></div><div class="mb-2 col-md-4"><select name="brand_id['+i+']['+i+']" id="brand_id" class="form-control" required><option selected="true" disabled="disabled" value=""> Select Medicine </option></select></div><div class="mb-2 col-md-4"><input type="number" name="quantity['+i+']['+i+']" min="1" class="form-control" placeholder="Quantity" value=""></div><a id="removeChildren" class="btn text-danger text-white position-absolute remove-actions" style="right: -16px;top: 0px;"><i class="fa fa-times"></i></a></div>').appendTo('#meds');
    

	    var gid = $('select[name="generic_id['+i+']['+i+']"]');
	    var brand = $('select[name="brand_id['+i+']['+i+']"]');
	    var qty = $('input[name="quantity['+i+']['+i+']"]');
	    $('select[name="generic_id['+i+']['+i+']"]').on('change',function(){
	 
	       var generic_id = jQuery(this).val();
	       var url   = window.location.href;
		   var hostname = window.location.hostname;
	       if (url === "http://"+hostname+"/inventory/medicine") {
	         var myUrl = 'medicine/gen/';
	       }else {
	          var myUrl = "http://"+hostname+"/medical/employees/gen/";
	       }

	       if(generic_id)
	       {
	          jQuery.ajax({
	             url : myUrl + generic_id,
	             type : "GET",
	             dataType : "json",
	             success:function(data)
	             {
	                brand.empty();
	                qty.val('');
	                jQuery.each(data.brand_id, function(key,value){
	                   brand.append('<option value="'+ key +'" class="text-uppercase">'+ value.toUpperCase() +'</option>');
	                });
	                qty.attr('max', data.id);
	                qty.prop('required',true);
	                var brand_id = brand.find(':selected').attr('value');
	                getData2(gid, brand, qty);
	             }
	          });
	       }
	       else
	       {
	          brand.empty();
	          qty.val('');
	       }

			function getData2(gid, bid, qty){

				bid.on('change',function(){
					var changed = true;
				    var gID = gid.find(':selected').attr('value');

				    	var bID = $(this).find(':selected').attr('value')
				    	console.log('brand_id '+bID);
				    	var myUrl3 = 'generic_id/'+gID+'/brand_id/'+bID+'';

				       if(bID)
				       {
				          jQuery.ajax({
				             url : myUrl3,
				             type : "GET",
				             dataType : "json",
				             success:function(data)
				             {
				             	qty.val('');
				                qty.attr('max', data);
				                qty.prop('required',true);
				                qty.prop('placeholder','Remaining stocks '+data);
				                qty.on({
				                	invalid: function(e){
				                		e.target.setCustomValidity("");
				                		if (!e.target.validity.valid){
				                			e.target.setCustomValidity("No remaining stocks");
				                		}
				                	},
			                		input: function(e){
			                			e.target.setCustomValidity("");
			                		}
				                });
				             }
				          });
				       }
				       else
				       {
				          bid.empty();
				       }
				});


			   bid.each(function(){
			    
			    var gID = gid.find(':selected').attr('value');

			    	var bID = $(this).find(':selected').attr('value')
			    	var myUrl3 = 'generic_id/'+gID+'/brand_id/'+bID+'';

			       if(bID)
			       {
			          jQuery.ajax({
			             url : myUrl3,
			             type : "GET",
			             dataType : "json",
			             success:function(data)
			             {
			                qty.attr('max', data);
			                qty.prop('required',true);
			                qty.prop('placeholder','Remaining stocks '+data);
			                qty.on({
			                	invalid: function(e){
			                		e.target.setCustomValidity("");
			                		if (!e.target.validity.valid){
			                			e.target.setCustomValidity("No remaining stocks");
			                		}
			                	},
		                		input: function(e){
		                			e.target.setCustomValidity("");
		                		}
			                });
			             }
			          });
			       }
			       else
			       {
			          bid.empty();
			          qty.val('');
			       }

			    });

			}

	    });

    	i++;

	});

    // Children
    $("body").on("click", "#removeChildren", function(event){
      if (i > 1 || e > 1) {
        $(this).parents("#medicineField").remove();
        i--;
        e--;
      }
    });
});

    var brand = $('select[name="brand_id[0][0]"]');
    var qty = $('input[name="quantity[0][0]"]');
    $('select[name="generic_id[0][0]"]').on('change',function(){
       var generic_id = jQuery(this).val();
		if (generic_id) {
			$("#select_generic").removeClass('d-none');
		}else{
			$("#select_generic").addClass('d-none');
		}

       var url   = window.location.href;
       var hostname = window.location.hostname;

       if (url === "http://"+hostname+"/inventory/medicine") {
         var myUrl = 'medicine/gen/';
       }else {
          var myUrl = "http://"+hostname+"/medical/employees/gen/";
       }

       if(generic_id)
       {
          jQuery.ajax({
             url : myUrl + generic_id,
             type : "GET",
             dataType : "json",
             success:function(data)
             {
             	console.log(data);
                brand.empty();
                qty.val('');
                jQuery.each(data.brand_id, function(key,value){
						brand.append('<option value="'+ key +'" class="text-uppercase">'+ value.toUpperCase() +'</option>');
        	   
                });
                qty.attr('max', data.id);
                qty.prop('required',true);
                var brand_id = brand.find(':selected').attr('value');
                getData(brand_id);

             }
          });


       }
       else
       {
          brand.empty();
          qty.val('');
       }


	function getData(brand_id){

		$('select[name="brand_id[0][0]"]').on('change',function(){
			var changed = true;
		    var gid = $('select[name="generic_id[0][0]"] option:selected').attr('value');
		    var bid = $('select[name="brand_id[0][0]"] option:selected').attr('value');

		    	var bID = jQuery(this).val();
		    	var myUrl2 = 'generic_id/'+gid+'/brand_id/'+bID+'';

		       if(bID)
		       {
		          jQuery.ajax({
		             url : myUrl2,
		             type : "GET",
		             dataType : "json",
		             success:function(data)
		             {
		             	qty.val('');
		                qty.attr('max', data);
		                qty.prop('required',true);
		                qty.prop('placeholder','Remaining stocks '+data);
		                qty.on({
		                	invalid: function(e){
		                		e.target.setCustomValidity("");
		                		if (!e.target.validity.valid){
		                			e.target.setCustomValidity("No remaining stocks");
		                		}
		                	},
	                		input: function(e){
	                			e.target.setCustomValidity("");
	                		}
		                });
		             }
		          });
		       }
		       else
		       {
		          bID.empty();
		          qty.val('');
		       }
		});


	    $('select[name="brand_id[0][0]"]').each(function(){
	    
	    var gid = $('select[name="generic_id[0][0]"] option:selected').attr('value');
	    var bid = $('select[name="brand_id[0][0]"] option:selected').attr('value');
	    	var bID = jQuery(this).val();
	    	var myUrl2 = 'generic_id/'+gid+'/brand_id/'+bID+'';

	       if(bID)
	       {
	          jQuery.ajax({
	             url : myUrl2,
	             type : "GET",
	             dataType : "json",
	             success:function(data)
	             {
	             	qty.val('');
	             	console.log(data);
	                qty.attr('max', data);
	                qty.prop('required',true);
	                qty.prop('placeholder', 'Remaining stocks '+data);
	                qty.on({
	                	invalid: function(e){
	                		e.target.setCustomValidity("");
	                		if (!e.target.validity.valid){
	                			e.target.setCustomValidity("No remaining stocks");
	                		}
	                	},
                		input: function(e){
                			e.target.setCustomValidity("");
                		}
	                });
	             }
	          });
	       }
	       else
	       {
	          bID.empty();
	          qty.val('');
	       }

	    });

	}


    });

    function test(form){
		var genArr = $('select#generic_id').map(function(){
		              return this.value
		    }).get()
		var brdArr = $('select#brand_id').map(function(){
		              return this.value
		    }).get()
		var newArray = genArr.map((e, i) => e + brdArr[i]);

		var arr = newArray.sort(); 
		var reportDuplicates = [];
		for (var i = 0; i < arr.length - 1; i++) {
		    if (arr[i + 1] == arr[i]) {
		        reportDuplicates.push(arr[i]);
				alert('Duplacate items detected! Please check for duplicate items before submitting');
				return false;
		    }
		}
		};
		
		//Upload update
		document.querySelector('.form-control-file').addEventListener('change',function(e){
			var fileName = document.getElementById("diagnosis").files[0].name;
			var nextSibling = e.target.nextElementSibling;
			nextSibling.innerText = fileName;
		});

</script>
@endsection