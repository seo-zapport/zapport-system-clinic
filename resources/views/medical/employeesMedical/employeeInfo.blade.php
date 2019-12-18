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
							<button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Pre-employment Medical
							</button>
							<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
								@if (@$employee->preemployment == null)
									@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
										<a class="dropdown-item" href="#" data-toggle="modal" data-target="#pre-emp">Add</a>
									@else
										<a class="dropdown-item" href="#" onclick="return confirm('Access denied! Only Doctor or Nurse can add an Item')">Add</a>
									@endif
								@else
									@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
										<form method="POST" action="{{ route('pre_emp.delete', ['pre_emp.delete' => @$employee->preemployment->id]) }}">
											@csrf
											@method('DELETE')
											<button class="dropdown-item"  onclick="return confirm('Are you sure you want to delete {{ @$employee->preemployment->pre_employment_med }} File?')" data-id="{{ @$employee->preemployment->id }}">
												Remove
											</button>
										</form>
									@endif
										<a class="dropdown-item" href="{{ route('pre_emp.download', ['pre_emp' => @$employee->preemployment->pre_employment_med]) }}" download> View</a>
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
						<button class="btn btn-success text-white btnPrint">Print</button>
						<button class="btn btn-info text-white" data-toggle="modal" data-target="#exampleModalCenter">New</button>
						{{-- <a class="btn btn-success" href="{{ route('medical.form', ['employee'=>$employee->emp_id]) }}">Form</a> --}}
					</div>
				</div>
			@endif
		</div>

		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>No.</th>
					<th>Diagnosis</th>
					<th>Notes</th>
					<th>Date and Time</th>
					<th>Remarks</th>
				</thead>
				<tbody>
					@php
						$i = 1;
					@endphp
					@forelse ($search as $medsHistory)
						<tr>
							<td>{{ $i++ }}</td>
							<td>{{ ucwords($medsHistory->diagnoses->diagnosis) }}
								<div class="row-actions"><a href="{{ route('medical.show', ['employee' => $employee->emp_id, 'employeesmedical' => $medsHistory->id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i> View</a></div>
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
<!-- Modal Add -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add New Record</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form onsubmit="return test(this)" id="myform" method="post" action="{{ route('medical.store', ['employee' => $employee->emp_id]) }}" enctype="multipart/form-data" autocomplete="off">
					@csrf
					<input type="hidden" name="employee_id" value="{{ $employee->id }}">
{{-- 					<div class="form-group">
					<label for="status">Status of Patient</label>
					<select name="status" id="status" class="form-control" required>
							<option selected="true" disabled="disabled" value=""> Select Stats </option>
							<option value="walkin">Walk-in</option>
					</select>
					</div> --}}
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="bodypart_id">Body Part</label>
							<select name="bodypart_id" id="bodypart_id" class="form-control">
								<option value="" disabled selected>Select Body Part</option>
								@foreach ($bparts as $bpart)
									@if (count($bpart->diseases) > 0)
										<option value="{{ $bpart->bodypart_slug }}">{{ ucfirst($bpart->bodypart) }}</option>
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
						{{-- <label for="diagnosis" class="lbl_upload">Select a attachment</label> --}}
						<div class="input-group mb-3">
							<div class="custom-file">
								<input type="file" name="attachment" id="diagnosis" class="custom-file-input form-control-file file-upload">
								<label for="diagnosis" class="custom-file-label">Choose file</label>
							</div>
						</div>
						{{-- <div class="uploader_wrap">
							<input type="file" name="attachment" id="diagnosis" class="form-control-file file-upload">
						</div> --}}
					</div>
					<div class="form-group">
						<label for="note">Note:</label>
						<textarea name="note" id="note" cols="10" rows="5" class="form-control" placeholder="Doctor's note" required></textarea>
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
										<option value="{{ $gen->id }}">{{ $gen->gname }}</option>
										@empty
										empty
									@endforelse
							</select>
							<span id="select_generic" class="d-none text-muted font-weight-bold" style="cursor: pointer">Clear</span>
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

					<div class="form-group">
						<label for="remarks">Remarks</label>
						<select name="remarks" id="remarks" class="form-control" required>
							<option selected="true" disabled="disabled" value=""> Choose Remarks </option>
							<option value="followUp">Follow up</option>
							<option value="done">Done</option>
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

<div id="test"></div>

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
			<form id="preEmpForm" method="post" enctype="multipart/form-data">
				<div class="modal-body">
					<input type="file" name="pre_employment_med" class="form-control-file file-upload" required>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
					console.log(key + ' ' + value);
					dis.append('<option value="'+ key +'">'+ value +'</option>');
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

   $('#myform').on('submit', function(e){
		var btn = $('#sbmt');
		btn.prop('disabled', true);
		setTimeout(function(){btn.prop('disabled', false); }, 3000);
    });


    // Children
    var i = $('#addMedicine').length;
    var e = $(this).find('.editmedicine').length;
    var o = $('#editMedicine').length;
    // Children
    $("#addMedicine").click(function(event) {
    	$('<div id="medicineField" class="col-12 form-row"><div class="mb-2 col-md-4"><select name="generic_id['+i+']['+i+']" id="generic_id" class="form-control" required><option selected="true" disabled="disabled"> Select Generic Name </option>@foreach ($gens as $gen)<option value="{{ $gen->id }}">{{ $gen->gname }}</option>@endforeach</select></div><div class="mb-2 col-md-4"><select name="brand_id['+i+']['+i+']" id="brand_id" class="form-control" required><option selected="true" disabled="disabled"> Select Medicine </option></select></div><div class="mb-2 col-md-4"><input type="number" name="quantity['+i+']['+i+']" min="1" class="form-control" placeholder="Quantity"></div><a id="removeChildren" class="btn text-danger text-white position-absolute remove-actions" style="right: -16px;top: 0px;"><i class="fa fa-times"></i></a></div>').appendTo('#meds');
    

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

			 	// console.log(bid.find(':selected').attr('value'))

				bid.on('change',function(){
					var changed = true;
				    var gID = gid.find(':selected').attr('value');

				    	var bID = $(this).find(':selected').attr('value')
				    	console.log('brand_id '+bID);
				    	var myUrl3 = 'generic_id/'+gID+'/brand_id/'+bID+'';

				       if(bID)
				       {
				          // console.log(myUrl3);
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
			    	var myUrl3 = 'generic_id/'+gID+'/brand_id/'+bID+'';

			       if(bID)
			       {
			          // console.log(myUrl3);
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
		    	var myUrl2 = 'generic_id/'+gid+'/brand_id/'+bID+'';

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
	    	var myUrl2 = 'generic_id/'+gid+'/brand_id/'+bID+'';

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
			var fileName = document.getElementById("diagnosis").files[0].name;
			var nextSibling = e.target.nextElementSibling;
			nextSibling.innerText = fileName;
		});

</script>
@endsection