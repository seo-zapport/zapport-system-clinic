@extends('layouts.app')
@section('title', "| " .ucwords($employee->last_name) . '\'s information')
@section('employeesMedical', 'active')
{{-- @section('dash-title', ucwords($employee->last_name) . '\'s information') --}}
@section('heading-title')
	<i class="fas fa-list text-secondary"></i> {{ 'Medical form for ' . ucwords($employee->last_name) }}
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

		<form onsubmit="return test(this)" id="myform" method="post" action="{{ route('medical.store', ['employee' => $employee->emp_id]) }}" enctype="multipart/form-data" autocomplete="off">
			@csrf
			<div class="row">
				<div class="col-md-8">
					<div class="card">
						<div class="card-header">Medical Form</div>
						<div class="card-body">
								<input type="hidden" name="employee_id" value="{{ $employee->id }}">
								<div class="form-group">
								<label for="status">Status of Patient</label>
								<select name="status" id="status" class="form-control" required>
										<option selected="true" disabled="disabled" value=""> Select Stats </option>
										<option value="walkin">Walk-in</option>
								</select>
								</div>
								<div class="form-group">
									<label for="diagnosis">Diagnosis</label>
									<input type="text" name="diagnosis" class="form-control" placeholder="Diagnosis" required>
									<div id="diagnosis_list" class="autocomplete-items"></div>
								</div>
								<div class="form-group">
									<p class="mb-1">Attachment</p>
									<label for="diagnosis" class="lbl_upload">Select a attachment</label>
									<div class="uploader_wrap">
										<input type="file" name="attachment" id="diagnosis" class="form-control-file file-upload">
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
									<div class="form-group col-5">
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
									<div class="form-group col-3">
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
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="card">
						<div class="card-header">Body Parts</div>
						<div class="card-body">
							<a class="btn btn-info btn-block" data-toggle="modal" data-target="#add-parts">Add Body Parts</a><hr>
							<div class="form-group">
								<select name="bodypart_id" id="bodypart_id" class="form-control">
									<option value="" disabled="" selected="">Select Body Parts</option>
									@foreach ($bparts as $bpart)
										<option value="{{ $bpart->id }}">{{ ucfirst($bpart->bodypart) }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group"></div>
						</div>
					</div>

					<br>

					<div class="card">
						<div class="card-header">Disease</div>
						<div class="card-body">
							<a class="btn btn-info btn-block">Add Disease</a><hr>
							<select name="" id="" class="form-control">
								<option value="" disabled="" selected="">Select Disease</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</form>

	</div>
</div>
@include('layouts.errors')

<!-- Modal For Body Parts -->
<div class="modal fade" id="add-parts" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add New Body Part</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="bParts-form" method="post">
					@csrf
					<div class="form-group">
						<label for="bodypart">Body Part</label>
						<input type="text" class="form-control" name="bodypart" placeholder="Add Body Part">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script type="application/javascript">
jQuery(document).ready(function($) {


    // Search input bodyparts_______________________________________________________________________________________________________________________
    $("input[name='bodypart']").on('keyup', function(){
    	var query = $(this).val();
    	$.ajax({
    		url: "/medical/employees/bodypart/"+query+"",
    		type: "GET",
    		data:{'bodypart':query},
    		success:function(response){
    			$('#bodyParts_list').html(response);
    		}
    	});
    });

	$(document).on('click', '#myform #bpart li', function(){
	    var value = $(this).text();
	    $("input[name='bodypart']").val(value);
	    $('#bodyParts_list').html("");
	});

	$("input[name='bodypart']").on('change', function(){
		var bodypart = $(this).val();
		console.log(bodypart);
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

	$("#bParts-form").on('submit', function(e){
		e.preventDefault();
		var bodypart = $('#bParts-form input[name="bodypart"]').val();
       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        });
        $.ajax({
        	type: 'POST',
        	url: '{{ route('bodyparts.store') }}',
        	data: {bodypart:bodypart},
        	dataType: 'json',
        	success: function(response){
        		console.log(response);
        		$('#bParts-form input[name="bodypart"]').val('');
        		$('#add-parts').modal('hide');
        		$('#bodypart_id').append('<option class="text-capitalize" value='+response.id+' selected>'+response.bodypart+'</option>')
        	},
        	error: function(response){
        		console.log(response);
        	}
        });
	});

	//__________________________________________________________________________________________________________________________________________________ 



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
    	$('<div id="medicineField" class="col-12 my-1 form-inline"><select name="generic_id['+i+']['+i+']" id="generic_id" class="form-control col-md-4" required><option selected="true" disabled="disabled"> Select Generic Name </option>@foreach ($gens as $gen)<option value="{{ $gen->id }}">{{ $gen->gname }}</option>@endforeach</select><select name="brand_id['+i+']['+i+']" id="brand_id" class="form-control col-md-4  ml-2 mr-2" required><option selected="true" disabled="disabled"> Select Medicine </option></select><input type="number" name="quantity['+i+']['+i+']" min="1" class="form-control col-md-3 mr-2" placeholder="Quantity">  <a id="removeChildren" class="btn btn-danger text-white"><i class="fa fa-times"></i></a></div>').appendTo('#meds');
    

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
				    	var myUrl3 = '/medical/employees/generic_id/'+gID+'/brand_id/'+bID+'';

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
			    	var myUrl3 = '/medical/employees/generic_id/'+gID+'/brand_id/'+bID+'';

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
		    	var myUrl2 = '/medical/employees/generic_id/'+gid+'/brand_id/'+bID+'/';

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
	    	var myUrl2 = '/medical/employees/generic_id/'+gid+'/brand_id/'+bID+'/';

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

</script>
@endsection