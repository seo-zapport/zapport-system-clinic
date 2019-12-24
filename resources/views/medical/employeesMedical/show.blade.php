@extends('layouts.app')
@section('title', "| ".ucwords($employee->last_name) . '\'s information')
@section('employeesMedical', 'active')
@section('dash-title', ucwords($employee->last_name) . '\'s information')
@section('heading-title')
	<i class="fas fa-list text-secondary"></i> {{ ucwords($employee->last_name) . '\'s information' }}
@endsection
@section('dash-content')
@section('back')
<a href="{{ route('medical.employeeInfo', ['employee' => $employee->emp_id]) }}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection
<div class="card mb-3">
	<div class="card-body">
		<div class="row">
			<div class="col-12 col-md-4 col-lg-2">
				@if (@$employee->profile_img != null)
					<div class="employee_wrap mb-0">
						<div class="panel employee-photo rounded">
							<img src="{{ asset('storage/uploaded/'.@$employee->profile_img) }}" alt="{{ @$employee->profile_img }}" class="img-fluid rounded" onerror="javascript:this.src='{{url( '/images/default.png' )}}'" >
						</div>
					</div>
						
				@endif
			</div>
			<div class="col-12 col-md-8 col-lg-10">
				<div class="row mb-3">
					<div class="col-12 col-md-6">
						<p class="med-name">{{ ucwords($employee->last_name . ", " . $employee->first_name . " " . $employee->middle_name) }}</p>
					</div>
					<div class="col-12 col-md-6 print-col">
						<div class="btn-group print-group" role="group">
							<button id="btnGroupDrop1" type="button" class="btn {{ (@$employee->preemployment == null ) ? 'btn-secondary ' : 'btn-success' }} dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Pre-employment Medical
							</button>
							<div class="dropdown-menu " aria-labelledby="btnGroupDrop1">
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
		<div id="diagnosis" class="zpr-row">
			<div class="container-fluid m-auto px-0 py-3">
				<div class="row">
					<div id="sideInfo" class="col-12 col-md-4 col-lg-2 mb-3">
						<div id="sideList" class="list-group m-auto">
							<h2 class="text-secondary zp-text-14 list-group-item">Medical Number: <span class="text-dark">{{ $employeesmedical->med_num }}</span></h2>
							<h2 class="text-secondary zp-text-14 list-group-item">Body Part: <span class="text-dark">{{ ucwords($employeesmedical->diagnoses->diseases->bodypart->bodypart) }}</span></h2>
							<h2 class="text-secondary zp-text-14 list-group-item">Disease: <span class="text-dark">{{ ucwords($employeesmedical->diagnoses->diseases->disease) }}</span></h2>
							<h2 class="text-secondary zp-text-14 list-group-item">Diagnosis: <span class="text-dark">{{ ucwords($employeesmedical->diagnoses->diagnosis) }}</span></h2>
							@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
								<div class="list-group-item">
									@if ($employeesmedical->remarks == 'followUp')
										<button class="btn btn-success text-white btn-block" data-toggle="modal" data-target="#exampleModalCenter">Add Notes</button>
									@endif

									<button class="btn btn-info text-white btn-block" data-toggle="modal" data-target="#exampleModalCenter2">Edit Remarks</button>
									@if ($employeesmedical->remarks != 'followUp')
									<button class="btn btn-success btn-block text-white btnPrint">Print</button>
									@endif
								</div>
							@endif
						</div>
					</div>
					<div id="DiagInfo" class="col-12 col-md-8 col-lg-10">
						<div class="form-group form-row">
							<div class="col-12 col-md-6">
								<p class="mb-0"><strong>Remarks:</strong> {{ ($employeesmedical->remarks == 'followUp') ? 'Follow up' : 'Done' }}</p>
							</div>
							<div class="col-12 col-md-6">
								<p class="mb-0 text-right zpwm-text-left"><strong>Date:</strong> {{ $employeesmedical->created_at->format('M d, Y - h:i a') }}</p>
							</div>
						</div>
						<div class="form-group">
							<p><strong>Attachment:</strong>
								@if ($employeesmedical->attachment != null)
									<a class="btn-dl" href="{{ route('download', ['file_name' => $employeesmedical->attachment]) }}" download>
										{{ $employeesmedical->attachment }}
									</a>
								@else
									<span class="text-muted">None</span>
								@endif
							</p>
						</div>
						<div class="form-group">
							<p><strong>Notes:</strong></p>
							<div class="doctors-note form-control">
								{{ ucfirst($employeesmedical->note) }}
							</div>
						</div>

						@if (count($employeesmedical->medNote) > 0)
							<div class="form-group">
								<p><strong>List of Followup Checkups</strong></p>
							</div>
							<div class="accordion med-list-findings mb-3" id="findings">
								@php
									$i = 1;
								@endphp
								@foreach ($employeesmedical->medNote as $followups)
									<div class="card">
										<div class="card-header" id="heading_{{ $followups->id }}">
											<h2 class="mb-0">
												<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse_{{ $followups->id }}" aria-expanded="true" aria-controls="collapse_{{ $followups->id }}">
													Followup Checkup {{ $i++ }}
												</button>
											</h2>
										</div>

										<div id="collapse_{{ $followups->id }}" class="collapse" aria-labelledby="heading_{{ $followups->id }}" data-parent="#findings">
											<div class="card-body">
												<small>{{ $followups->created_at->format('M d, Y - h:i a') }}</small>
												<p class="form-group"><strong>Attachments : </strong> 
												@if ($followups->attachment != null)
													<a class="btn-dl" href="{{ route('download', ['file_name' => $followups->attachment]) }}" download>{{ $followups->attachment }}</a>
												@else
													<span class="text-muted">None</span>
												@endif</p>
												<div class="form-group">
													<p><strong>Notes : </strong></p>
													<div class="doctors-note form-control">
															{{ ucfirst($followups->followup_note) }}
													</div>
												</div>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						@endif

						@if (count($employeesmedical->medicines))
						<div class="form-group">
							<p><strong>Medicine</strong></p>
						</div>
						@endif
						<div class="form-group form-row">
							@foreach ($empMeds as $meds)
								<div class="col-12 col-md-6 col-lg-3">
									<div class="med-wrap ">
										<div class="med-head med-info">
											<i class="fas fa-tablets"></i>
											<div class="med-info">
												<h2 class="brand">{{ ucwords($meds->medBrand->bname) }}</h2>
												<h3 class="generic">{{ ucwords($meds->generic->gname) }}</h3>
												<div class="quantity">
													<span id="quantity-text">QTY</span>
													<span id="quantity-num">{{ $meds->pivot->quantity }}</span>
												</div>
											</div>
										</div>
										<div class="med-body">
											<p class="mb-0"><strong>Given by : </strong>
												@foreach ($meds->users as $att)
												{{  ucwords($att->employee->first_name) }} {{ ucwords($att->employee->middle_name) }} {{ ucwords($att->employee->last_name) }}
												@endforeach
										</p>
											<p class="mb-0"><strong>Date : </strong>{{ $meds->pivot->created_at->format('M d, Y - h:i a') }}</p>
										</div>
									</div>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>

@include('layouts.errors')
<!-- Modal Add -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Update Record</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form onsubmit="return test(this)" id="myform-show" method="post" action="{{ route('medical.storeFollowup', ['employee' => $employee->emp_id, 'employeesmedical' => $employeesmedical->med_num]) }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<p class="mb-1">Attachments</p>
						<div class="input-group mb-3">
							<div class="custom-file">
								<input type="file" name="attachment" id="diagnosis_show" class="custom-file-input form-control-file file-upload">
								<label for="diagnosis" class="custom-file-label">Choose file</label>
							</div>
						</div>
						{{-- <label for="diagnosis_show" class="lbl_upload">Attachments</label>
						<div class="uploader_wrap">
							<input type="file" name="attachment" id="diagnosis_show" class="form-control-file file-upload">
						</div> --}}
					</div>
					<div class="form-group">
						<label for="followup_note">Note:</label>
						<textarea name="followup_note" id="followup_note" cols="10" rows="5" class="form-control" placeholder="Doctor's note" required></textarea>
					</div>

					<div class="form-group">
						<a id="addMedicine" class="btn btn-success text-white mb-2"><i class="fa fa-plus"></i> Medicine</a>
					</div>

					<div id="meds" class="form-row">
						<div class="form-group col-4">
						<label for="generic_id">Generic Name</label>
						<select name="generic_id[0][0]" id="generic_id" class="form-control">
								<option selected="true" disabled="disabled" value=""> Select Generic Name </option>
								@forelse ($gens as $gen)
									@if ($gen->medbrand->count() > 0)
										<option value="{{ $gen->id }}">{{ $gen->gname }}</option>
									@endif
									@empty
									empty
								@endforelse
						</select>
						<span id="select_generic_show" class="d-none text-muted zp-filter-clear" ><i class="fas fa-times"></i></span>
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

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button id="sbmt" type="submit" class="btn btn-primary" onclick="test()">Save changes</button>
						{{-- <button onclick="test()">test</button> --}}
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Update Remarks</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{ route('medical.update', ['employee' => $employee->emp_id, 'employeesmedical' =>$employeesmedical->med_num]) }}">
					@csrf
					@method('PUT')
					<input type="hidden" name="employee_id" value="{{ $employee->id }}">

					<div class="form-group">
						<label for="remarks">Remarks</label>
						<select name="remarks" id="remarks" class="form-control">
							<option value="followUp" {{ ($employeesmedical->remarks == 'followUp') ? 'selected="true"' : '' }}>Follow up</option>
							<option value="done" {{ ($employeesmedical->remarks == 'done') ? 'selected="true"' : '' }}>Done</option>
						</select>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button id="sbmt" type="submit" class="btn btn-primary" onclick="test()">Save changes</button>
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
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Pre Employement Medical</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="preEmpForm2" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="input-group">
						<div class="custom-file">
							<input type="file" id="pre_employment_med" name="pre_employment_med" class="form-control-file file-upload" required>
							<label id="preemplabel" for="pre_employment_med" class="custom-file-label">Choose file</label>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button id="preEmpShow" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

	$("#myform-show").on("submit", function(e){
		console.log("submited");
		var btn = $("#sbmt");
		btn.prop('disabled', true);
		setTimeout(function(){btn.prop('disabled', false); }, 3000);
	});

	$('.btnPrint').printPage({ 
		attr: "href",
		url: "{{ asset('storage/uploaded/print/medrecord/emp-med-record.html') }}",
		message:"Your document is being created",
	});

	$("#preEmpForm2").on('submit', function(e) {
		e.preventDefault();
       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });

        $.ajax({
        	type: 'POST',
        	url: '{{ route('medical.pre_emp', ['employee' => $employee->id]) }}',
        	data: new FormData($('#preEmpForm2')[0]),
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

	$("#preEmpForm2").on('change', function(e){
		e.preventDefault();
		var file = e.target.files[0].name;
		document.getElementById("preemplabel").innerHTML = file;
	});

	$("#preEmpForm2 #preEmpShow").on("click", function(e){
		e.preventDefault();
		document.getElementById("preemplabel").innerHTML = 'Choose file';
		$("input[name='pre_employment_med']").val("");
	});

    // Children
    var i = $('#addMedicine').length;
    var e = $(this).find('.editmedicine').length;
    var o = $('#editMedicine').length;
    // Children
    $("#addMedicine").click(function(event) {
      $('<div id="medicineField" class="col-12 form-row medicine-field"><div class="mb-2 col-md-4"><select name="generic_id['+i+']['+i+']" id="generic_id" class="form-control" required><option selected="true" disabled="disabled"> Select Generic Name </option>@foreach ($gens as $gen)<option value="{{ $gen->id }}">{{ $gen->gname }}</option>@endforeach</select></div><div class="mb-2 col-md-4"><select name="brand_id['+i+']['+i+']" id="brand_id" class="form-control" required><option selected="true" disabled="disabled"> Select Medicine </option></select></div><div class="mb-2 col-md-4"><input type="number" name="quantity['+i+']['+i+']" min="1" class="form-control" placeholder="Quantity"></div><a id="removeChildren" class="btn text-danger text-white position-absolute remove-actions" style="right: -16px;top: 0px;"><i class="fa fa-times"></i></a></div>').appendTo('#meds');

    var gid = $('select[name="generic_id['+i+']['+i+']"]');
    var brand = $('select[name="brand_id['+i+']['+i+']"]');
    var qty = $('input[name="quantity['+i+']['+i+']"]');
    $('select[name="generic_id['+i+']['+i+']"]').on('change',function(){
 
       var generic_id = jQuery(this).val();
       // console.log('generic_id '+generic_id);
       // var myUrl = 'medicine/gen/';
       var url   = window.location.href;
       var hostname = window.location.hostname;

       if (url === "http://"+hostname+"/inventory/medicine") {
         var myUrl = 'medicine/gen/';
       }else {
          var myUrl = "http://"+hostname+"/medical/employees/gen/";
       }

       if(generic_id)
       {
          // console.log(myUrl + generic_id);
          jQuery.ajax({
             url : myUrl + generic_id,
             type : "GET",
             dataType : "json",
             success:function(data)
             {
             	// console.log(data);
                brand.empty();
                qty.val('');
                jQuery.each(data.brand_id, function(key,value){
                   brand.append('<option value="'+ key +'">'+ value +'</option>');
                });
                qty.attr('max', data.id);
                qty.prop('required',true);
                // qty.prop('placeholder','Remaining stocks '+data);
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

	 	// console.log(gid.find(':selected').attr('value'))

		bid.on('change',function(){
			var changed = true;
		    var gID = gid.find(':selected').attr('value');

		    	var bID = $(this).find(':selected').attr('value')
		    	console.log('brand_id '+bID);
		    	var myUrl3 = {{ $employee->id }}+'/generic_id/'+gID+'/brand_id/'+bID+'';

		       if(bID)
		       {
		          console.log(myUrl3);
		          jQuery.ajax({
		             url : myUrl3,
		             type : "GET",
		             dataType : "json",
		             success:function(data)
		             {
		             	// gID.empty();
		             	// console.log(data);
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
	    	// console.log('brand_id '+bID);
	    	var myUrl3 = {{ $employee->id }}+'/generic_id/'+gID+'/brand_id/'+bID+'';

	       if(bID)
	       {
	          console.log(myUrl3);
	          jQuery.ajax({
	             url : myUrl3,
	             type : "GET",
	             dataType : "json",
	             success:function(data)
	             {
	             	// gid.empty();
	             	// console.log(data);
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

		{{--  $(window).on('load resize',function(){
			let viewWidth = $(window).width();
			if(viewWidth >= 1024 ){
				$(document).on('scroll', function(){
					$('#sideList').stop(true,true).animate({top:$(this).scrollTop()},100,"linear");
				});
			}
		});  --}}
});

    var brand = $('select[name="brand_id[0][0]"]');
    var qty = $('input[name="quantity[0][0]"]');
    $('select[name="generic_id[0][0]"]').on('change',function(){
       var generic_id = jQuery(this).val();
		if (generic_id) {
			$("#select_generic_show").removeClass('d-none');
		}else{
			$("#select_generic_show").addClass('d-none');
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
          // console.log(myUrl + generic_id);
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
						brand.append('<option value="'+ key +'">'+ value +'</option>');
        	   
                });

                qty.attr('max', data.id);
                qty.prop('required',true);
                // qty.prop('placeholder','Remaining stocks '+data);

                // console.log(data.id);
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
		    // console.log('brand_id '+bid);

		    	var bID = jQuery(this).val();
		    	var myUrl2 = {{ $employeesmedical->id }}+'/generic_id/'+gid+'/brand_id/'+bID+'';

		       if(bID)
		       {
		          // console.log(myUrl2);
		          jQuery.ajax({
		             url : myUrl2,
		             type : "GET",
		             dataType : "json",
		             success:function(data)
		             {
		             	// gid.empty();
		             	// console.log(data);
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
	    // console.log('brand_id '+bid);

	    	var bID = jQuery(this).val();
	    	var myUrl2 = {{ $employeesmedical->id }}+'/generic_id/'+gid+'/brand_id/'+bID+'';

	       if(bID)
	       {
	          // console.log(myUrl2);
	          jQuery.ajax({
	             url : myUrl2,
	             type : "GET",
	             dataType : "json",
	             success:function(data)
	             {
	             	// gid.empty();
	             	// console.log(data);
	             	qty.val('');
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
		// console.log('Generic '+genArr+' '+'Brand '+brdArr);

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
			var fileName = document.getElementById("diagnosis_show").files[0].name;
			var nextSibling = e.target.nextElementSibling;
			nextSibling.innerText = fileName;
		});

</script>
@endsection