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
<div class="card mb-5">
	<div class="card-body">
		<div class="row">
			<div class="col-12 col-md-2">
				@if (@$employee->profile_img != null)
					<div class="employee_wrap mb-0">
						<div class="panel employee-photo rounded">
							<img src="{{ asset('storage/uploaded/'.@$employee->profile_img) }}" alt="{{ @$employee->profile_img }}" class="img-fluid rounded">
						</div>
					</div>
				@endif
			</div>
			<div class="col-12 col-md-10">
				<p class="med-name">{{ ucwords($employee->last_name . " " . $employee->first_name . " " . $employee->middle_name) }}</p>
				<div class="row">
					<div class="col-12 col-md-3">
						<p class="mb-2"><span class="text-dark font-weight-bold">Department</span>: {{ strtoupper($employee->departments->department) }}</p>
						<p class="mb-2"><span class="text-dark font-weight-bold">Position</span>: {{ ucwords($employee->positions->position) }}</p>
					</div>
					<div class="col-12 col-md-3">
						<p class="mb-2"><span class="text-dark font-weight-bold">Gender</span>: {{ (@$employee->gender == 0) ? "Male" : "Female" }}</p>
						<p class="mb-2"><span class="text-dark font-weight-bold">Age</span>: {{ @$employee->age }}</p>
					</div>
					<div class="col-12 col-md-3">
						<p class="mb-2"><span class="text-dark font-weight-bold">Birthday</span>: {{ @$employee->birthday->format('M d, Y') }}</p>
						<p class="mb-2"><span class="text-dark font-weight-bold">Birth Place</span>: {{ ucwords(@$employee->birth_place) }}</p>
					</div>
					<div class="col-12 col-md-3">
						<p class="mb-2"><span class="text-dark font-weight-bold">Contact</span>: {{ "+63" . @$employee->contact }}</p>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div id="diagnosis">
			<div class="row my-3">
				<div class="col-12 col-md-8">
					<h2 class="text-secondary zp-text-22">Diagnosis: <span class="text-dark">{{ ucwords($employeesmedical->diagnoses->diagnosis) }}</span></h2>
					{{-- <p class="mb-2"><small class="text-muted">Date: {{ $employeesmedical->created_at->format('M d, Y - h:i a') }}</small></p>
					<p class="mb-1"><span class="text-dark font-weight-bold">Attendant</span>: {{ ucwords($employeesmedical->user->employee->first_name) }} {{ ucwords($employeesmedical->user->employee->middle_name) }} {{ ucwords($employeesmedical->user->employee->last_name) }}</p>
					<p class="mb-1"><span class="text-dark font-weight-bold">Remarks</span>: {{ ($employeesmedical->remarks == 'followUp') ? 'Follow up' : 'Done' }}</p> --}}
				</div>
				@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
				<div class="col-12 col-md-4 text-right">
					@if ($employeesmedical->remarks == 'followUp')
						<button class="btn btn-success text-white" data-toggle="modal" data-target="#exampleModalCenter">Add Notes</button>
					@endif

					<button class="btn btn-info text-white" data-toggle="modal" data-target="#exampleModalCenter2">Edit Remarks</button>
				</div>
				@endif
			</div>

			<ul class="nav nav-pills my-4 mx-0" id="pills-tab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Doctor's Note</a>
				</li>
				@if (count($employeesmedical->medicines) > 0)
					<li class="nav-item">
						<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Medicines</a>
					</li>
				@endif
				@if (count($employeesmedical->medNote) > 0)
					<li class="nav-item">
						<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Follow up checkup</a>
					</li>
				@endif
			</ul>
			<div class="tab-content" id="pills-tabContent">
				<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
					{{-- <div class="zp-notes light-yellow">
						<div class="zp-notes-header">
							<h4 class="zp-notes-title">Doctor's Note</h4>
						</div>
						<div class="zp-notes-body">
							<p>{{ ucfirst($employeesmedical->note) }}</p>
						</div>
					</div> --}}
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th>Doctor's Note</th>
									<th>Attachment</th>
									<th>Attendant</th>
									<th>Remarks</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{ ucfirst($employeesmedical->note) }}</td>
									<td>
										@if ($employeesmedical->attachment != null)
											<a class="btn-dl" href="{{ route('download', ['file_name' => $employeesmedical->attachment]) }}" download>{{ $employeesmedical->attachment }}</a>
										@endif
									</td>
									<td class="w-15">{{ ucwords($employeesmedical->user->employee->first_name) }} {{ ucwords($employeesmedical->user->employee->middle_name) }} {{ ucwords($employeesmedical->user->employee->last_name) }}</td>
									<td class="w-15">{{ ($employeesmedical->remarks == 'followUp') ? 'Follow up' : 'Done' }}</td>
									<td class="text-muted w-15">{{ $employeesmedical->created_at->format('M d, Y - h:i a') }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
					<div class="table-responsive">
						<table class="table">
							<thead class="thead-dark">
								<tr>
									<th>Generic Name</th>
									<th>Brand Name</th>
									<th class="text-center">Quantity</th>
									<th>Given by</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($empMeds as $meds)
									<tr>
										<td><span class="text-dark">{{ ucwords($meds->generic->gname) }}</span></td>
										<td><span class="text-dark">{{ ucwords($meds->medBrand->bname) }}</span></td>
										<td class="w-10 text-center"><span class="text-dark">{{ $meds->pivot->quantity }}</span></td>
										<td class="text-muted w-15">
											@foreach ($meds->users as $att)
											<span class="text-dark">{{  ucwords($att->employee->first_name) }} {{ ucwords($att->employee->middle_name) }} {{ ucwords($att->employee->last_name) }}</span>
											@endforeach
										</td>
										<td class="text-muted w-15"><span class="text-dark">{{ $meds->pivot->created_at->format('M d, Y - h:i a') }}</span></td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				@if (count($employeesmedical->medNote) > 0)
					<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-lsabelledby="pills-contact-tab">
						<div class="table-responsive">
							<table class="table">
								<thead class="thead-dark">
									<tr>
										<th>Findings</th>
										<th>Attachment</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($employeesmedical->medNote as $followups)
										<tr>
											<td>{{ ucfirst($followups->followup_note) }}</td>
											<td>
												@if ($followups->attachment != null)
													<a class="btn-dl" href="{{ route('download', ['file_name' => $followups->attachment]) }}" download>{{ $followups->attachment }}</a>
												@endif
											</td>
											<td  class="text-muted w-15">{{ $followups->created_at->format('M d, Y - h:i a') }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				@endif
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
				<form onsubmit="return test(this)" id="myform-show" method="post" action="{{ route('medical.storeFollowup', ['employee' => $employee->emp_id, 'employeesmedical' => $employeesmedical->id]) }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label for="diagnosis">Attachment</label>
						<input type="file" name="attachment" class="form-control-file file-upload">
					</div>
					<div class="form-group">
						<label for="followup_note">Note:</label>
						<textarea name="followup_note" id="followup_note" cols="10" rows="5" class="form-control" placeholder="Doctor's note" required></textarea>
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
						<span id="select_generic_show" class="d-none text-muted font-weight-bold" style="cursor: pointer">Clear</span>
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
				<form method="post" action="{{ route('medical.update', ['employee' => $employee->emp_id, 'employeesmedical' =>$employeesmedical->id]) }}">
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

<script type="application/javascript">
jQuery(document).ready(function($) {
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
       // console.log('generic_id '+generic_id);
       // var myUrl = 'medicine/gen/';
       var url   = window.location.href;

       if (url === "http://clinic/inventory/medicine") {
         var myUrl = 'medicine/gen/';
       }else {
          var myUrl = 'http://clinic/medical/employees/gen/';
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
    // $("#editMedicine").click(function(event) {
    //   $('<div id="medicineField" class="col-auto my-1 form-inline editmedicine"><label for="children" class="mr-2">Child\'s Name</label><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Child\'s Name" value=""><label for="children" class="mr-2">Birthday</label><input type="date" class="form-control mr-2" name="children['+e+'][]" " value=""><label for="children" class="mr-2">Gender</label><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Gender" value=""><a id="removeChildren" class="btn btn-danger text-white"><i class="fa fa-times"></i></a></div>').appendTo('#meds');
    // e++;

    // });


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
			$("#select_generic_show").removeClass('d-none');
		}else{
			$("#select_generic_show").addClass('d-none');
		}

       var url   = window.location.href;

       if (url === "http://clinic/inventory/medicine") {
         var myUrl = 'medicine/gen/';
       }else {
          var myUrl = 'http://clinic/medical/employees/gen/';
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