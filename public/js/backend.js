jQuery(document).ready(function($){

	$('.show-edit').on('click', function(e){
	    $('.form-hidden-'+this.id).toggleClass('form-hide');
	});

	// AJAX
    jQuery('select[name="department_id"]').on('change',function(){
       var department_id = jQuery(this).val();
       // var myUrl = 'create/deptID/';
       var url   = window.location.href;

       if (url === "http://clinic/hr/employees/create") {
         var myUrl = 'create/deptID/';
       }else {
          var myUrl = 'http://clinic/hr/employees/edit/deptID/';
       }

       if(department_id)
       {
          console.log(myUrl + department_id);
          jQuery.ajax({
             url : myUrl + department_id,
             type : "GET",
             dataType : "json",
             success:function(data)
             {
                jQuery('select[name="position_id"]').empty();
                jQuery.each(data, function(key,value){
                   $('select[name="position_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
             }
          });
       }
       else
       {
          $('select[name="position_id"]').empty();
       }
    });

    // Children
    var i = $('#addChildren').length;
    var e = $(this).find('.editchildren').length;
    var o = $('#editChildren').length;
    // Children
    $("#addChildren").click(function(event) {
      $('<div id="childrenField" class="col-12 my-1 form-inline"><label for="children" class="mr-2">Childrens Name</label><input type="text" class="form-control mr-2" name="children['+i+'][]" placeholder="Add children" value=""><label for="children" class="mr-2">Childrens Birthday</label><input type="date" class="form-control mr-2" name="children['+i+'][]" " value=""><label for="children" class="mr-2">Childrens Gender</label><input type="text" class="form-control mr-2" name="children['+i+'][]" placeholder="Add icon class" value=""><a id="removeChildren" class="btn btn-danger text-white"><i class="fa fa-times"></i></a></div>').appendTo('#children');
    i++;

    });
    // Children
    $("#editChildren").click(function(event) {
      $('<div id="childrenField" class="col-auto my-1 form-inline editchildren"><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Add children" value=""><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Add children description" value=""><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Add icon class" value=""><a id="removeSkill" class="btn btn-danger text-white"><i class="fa fa-times"></i></a></div>').appendTo('#children');
    e++;

    });
    // Children
    $("body").on("click", "#removeChildren", function(event){
      if (i > 1 || e > 1) {
        $(this).parents("#childrenField").remove();
        i--;
        e--;
      }
    });


    // Work
    var i = $('#addWork').length;
    var e = $(this).find('.editwork').length;
    var o = $('#editWork').length;
    // Work
    $("#addWork").click(function(event) {
      $('<div id="workField" class="col-12 my-1 form-inline"><label for="work" class="mr-2">Name of Company</label><input type="text" class="form-control mr-2" name="work['+i+'][]" placeholder="Name of Company" value=""><label for="work" class="mr-2">Position</label><input type="text" class="form-control mr-2" name="work['+i+'][]" " value="" placeholder="Position"><label for="work" class="mr-2">Period Covered</label><input type="date" class="form-control mr-2" name="work['+i+'][]" value=""><label for="work" class="ml-2 mr-2">To</label><input type="date" class="form-control mr-2" name="work['+i+'][]" value=""><a id="removeWork" class="btn btn-danger text-white"><i class="fa fa-times"></i></a></div>').appendTo('#work');
    i++;

    });
    // Work
    $("#editWork").click(function(event) {
      $('<div id="workField" class="col-auto my-1 form-inline editchildren"><input type="text" class="form-control mr-2" name="work['+e+'][]" placeholder="Add work" value=""><input type="text" class="form-control mr-2" name="work['+e+'][]" placeholder="Add work description" value=""><input type="text" class="form-control mr-2" name="work['+e+'][]" placeholder="Add icon class" value=""><a id="removeSkill" class="btn btn-danger text-white"><i class="fa fa-times"></i></a></div>').appendTo('#work');
    e++;

    });
    // Work
    $("body").on("click", "#removeWork", function(event){
      if (i > 1 || e > 1) {
        $(this).parents("#workField").remove();
        i--;
        e--;
      }
    });
    
});