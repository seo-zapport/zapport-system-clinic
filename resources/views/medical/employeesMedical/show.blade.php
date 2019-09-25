@extends('layouts.app')
@section('title', "| ".ucwords($employee->last_name) . '\'s information')
@section('employeesMedical', 'active')
@section('dash-title', ucwords($employee->last_name) . '\'s information')
@section('dash-content')
@section('back')
<a href="{{ route('medical.employeeInfo', ['employee' => $employee->emp_id]) }}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-10">
				<div class="row">
					<div class="col-3">
						<p>Name: {{ ucwords($employee->last_name . " " . $employee->first_name . " " . $employee->middle_name) }}</p>
					</div>
					<div class="col-3">
						<p>Department: {{ strtoupper($employee->departments->department) }}</p>
					</div>
					<div class="col-3">
						<p>Position: {{ ucwords($employee->positions->position) }}</p>
					</div>
				</div>

				<div class="row">
					<div class="col-2">
						<p>Gender: {{ (@$employee->gender == 0) ? "Male" : "Female" }}</p>
					</div>
					<div class="col-1">
						<p>Age: {{ @$employee->age }}</p>
					</div>
					<div class="col-3">
						<p>Birthday: {{ @$employee->birthday->format('M d, Y') }}</p>
					</div>
					<div class="col-3">
						<p>Birth Place: {{ ucwords(@$employee->birth_place) }}</p>
					</div>
					<div class="col-3">
						<p>Contact number: {{ "+63" . @$employee->contact }}</p>
					</div>
				</div>
			</div>

			<div class="col-2">
				@if (@$employee->profile_img != null)
					<img src="{{ asset('storage/uploaded/'.@$employee->profile_img) }}" alt="{{ @$employee->profile_img }}" class="img-fluid">
				@endif
			</div>
		</div>

		<hr>
		@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
		<div class="form-group">
			@if ($employeesmedical->remarks == 'followUp')
					<button class="btn btn-success text-white" data-toggle="modal" data-target="#exampleModalCenter">Add Notes</button>
			@endif

			<button class="btn btn-info text-white" data-toggle="modal" data-target="#exampleModalCenter2">Edit Remarks</button>
		</div>
		@endif
		<div class="row">
			<div id="diagnosis" class="container">
				<div class="mb-3">
					<h2>{{ ucwords($employeesmedical->diagnosis) }}</h2>
					<small>Date: {{ $employeesmedical->created_at->format('M d, Y - h:i a') }}</small>
				</div>
				<div>
					<h4>Doctor's Note:</h4>
					<p>{{ ucfirst($employeesmedical->note) }}</p>
					@if (count($employeesmedical->medNote) > 0)
						<h5>Follow up checkup:</h5>
						@foreach ($employeesmedical->medNote as $followups)
							<p>{{ ucfirst($followups->followup_note) }} <small>{{ $followups->created_at->format('M d, Y - h:i a') }}</small></p>
						@endforeach
					@endif
				</div>
				<div>
					<h5>Medicines:</h5>
					@foreach ($empMeds as $meds)
						{{ ucwords($meds->generic->gname) }}
						{{ ucwords($meds->medBrand->bname) }} {{ $meds->pivot->quantity }} <br>
							@foreach ($meds->users as $att)
								<small>{{ 'Given by: '. ucwords($att->employee->first_name) }} {{ ucwords($att->employee->middle_name) }} {{ ucwords($att->employee->last_name) }}<br>
							@endforeach
						{{ $meds->pivot->created_at->format('M d, Y - h:i a') }}</small><br>
					@endforeach
				</div>
				<br>
				<p>Attendant: {{ ucwords($employeesmedical->user->employee->first_name) }} {{ ucwords($employeesmedical->user->employee->middle_name) }} {{ ucwords($employeesmedical->user->employee->last_name) }}</p>
				<p>Remarks: {{ ($employeesmedical->remarks == 'followUp') ? 'Follow up' : 'Done' }}</p>
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
				<form onsubmit="return test(this)" id="myform" method="post" action="{{ route('medical.storeFollowup', ['employee' => $employee->emp_id, 'employeesmedical' =>$employeesmedical->diagnosis]) }}">
					@csrf
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
						<select name="generic_id[0][0]" id="generic_id" class="form-control" required>
								<option selected="true" disabled="disabled"> Select Generic Name </option>
								@forelse ($gens as $gen)
									<option value="{{ $gen->id }}">{{ $gen->gname }}</option>
									@empty
									empty
								@endforelse
						</select>
						</div>
						<div class="form-group col-4">
						<label for="brand_id">Brand Name</label>
						<select name="brand_id[0][0]" id="brand_id" class="form-control" required>
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
				<form method="post" action="{{ route('medical.update', ['employee' => $employee->emp_id, 'employeesmedical' =>$employeesmedical->diagnosis]) }}">
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