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



  // AJAX
    jQuery('select[name="generic_id"]').on('change',function(){
       var generic_id = jQuery(this).val();
       // var myUrl = 'medicine/gen/';
       var url   = window.location.href;

       if (url === "http://clinic/inventory/medicine") {
         var myUrl = 'medicine/gen/';
       }else {
          var myUrl = 'http://clinic/medical/employees/gen/';
       }

       if(generic_id)
       {
          console.log(myUrl + generic_id);
          jQuery.ajax({
             url : myUrl + generic_id,
             type : "GET",
             dataType : "json",
             success:function(data)
             {
                jQuery('select[name="brand_id"]').empty();
                jQuery.each(data, function(key,value){
                   $('select[name="brand_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
             }
          });
       }
       else
       {
          $('select[name="brand_id"]').empty();
       }
    });


    // Children
    var i = $('#addChildren').length;
    var e = $(this).find('.editchildren').length;
    var o = $('#editChildren').length;
    // Children
    $("#addChildren").click(function(event) {
      $('<div id="childrenField" class="col-12 my-1 form-inline"><label for="children" class="mr-2">Child\'s Name</label><input type="text" class="form-control mr-2" name="children['+i+'][]" placeholder="Child\'s Name" value=""><label for="children" class="mr-2">Birthday</label><input type="date" class="form-control mr-2" name="children['+i+'][]" " value=""><label for="children" class="mr-2">Gender</label><input type="text" class="form-control mr-2" name="children['+i+'][]" placeholder="Gender" value=""><a id="removeChildren" class="btn btn-danger text-white"><i class="fa fa-times"></i></a></div>').appendTo('#children');
    i++;

    });
    // Children
    $("#editChildren").click(function(event) {
      $('<div id="childrenField" class="col-auto my-1 form-inline editchildren"><label for="children" class="mr-2">Child\'s Name</label><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Child\'s Name" value=""><label for="children" class="mr-2">Birthday</label><input type="date" class="form-control mr-2" name="children['+e+'][]" " value=""><label for="children" class="mr-2">Gender</label><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Gender" value=""><a id="removeChildren" class="btn btn-danger text-white"><i class="fa fa-times"></i></a></div>').appendTo('#children');
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
    var a = $('#addWork').length;
    var b = $(this).find('.editwork').length;
    var o = $('#editWork').length;
    // Work
    $("#addWork").click(function(event) {
      $('<div id="workField" class="col-12 my-1 form-inline"><label for="work" class="mr-2">Name of Company</label><input type="text" class="form-control mr-2" name="experience['+a+'][]" placeholder="Name of Company" value=""><label for="work" class="mr-2">Position</label><input type="text" class="form-control mr-2" name="experience['+a+'][]" " value="" placeholder="Position"><label for="work" class="mr-2">Period Covered</label><input type="date" class="form-control" name="experience['+a+'][]" value=""><label for="work" class="ml-2 mr-2">To</label><input type="date" class="form-control mr-2" name="experience['+a+'][]" value=""><a id="removeWork" class="btn btn-danger text-white"><i class="fa fa-times"></i></a></div>').appendTo('#work');
    a++;

    });
    // Work
    $("#editWork").click(function(event) {
      $('<div id="workField" class="col-auto my-1 form-inline editwork"><label for="work" class="mr-2">Name of Company</label><input type="text" class="form-control mr-2" name="experience['+b+'][]" placeholder="Name of Company" value=""><label for="work" class="mr-2">Position</label><input type="text" class="form-control mr-2" name="experience['+b+'][]" " value="" placeholder="Position"><label for="work" class="mr-2">Period Covered</label><input type="date" class="form-control mr-2" name="experience['+b+'][]" value=""><label for="work" class="ml-2 mr-2">To</label><input type="date" class="form-control ml-2 mr-2" name="experience['+b+'][]" value=""><a id="removeWork" class="btn btn-danger text-white"><i class="fa fa-times"></i></a></div>').appendTo('#work');
    b++;

    });
    // Work
    $("body").on("click", "#removeWork", function(event){
      if (a > 1 || b > 1) {
        $(this).parents("#workField").remove();
        a--;
        b--;
      }
    });

    /**
     * Folded Menu
     -------------------------*/
    $('#collapse-button').on('click', function(e){
      e.preventDefault();
      $('#zapWrap').toggleClass('folded');
      localStorage.setItem( 'state', (($("#zapWrap").hasClass("folded")) ? "folded" : "") );
      
      $('.collapse-button-icon > i', this).toggleClass("fa-chevron-left fa-chevron-right");
      localStorage.setItem( 'icon', (($(".collapse-button-icon > i").hasClass("fa-chevron-left")) ? "fa-chevron-left" : "fa-chevron-right") );
      // console.log("Local Storage Set to: " + (($(".collapse-button-icon > i").hasClass("fa-chevron-left")) ? "fa-chevron-left" : "fa-chevron-right") );
    });

    if (!!localStorage.getItem("state") && localStorage.getItem("state") == "folded"){
      $("#zapWrap").addClass("folded"); 
    }

    if (!!localStorage.getItem("icon") && localStorage.getItem("icon") == "fa-chevron-left"){
      $(".collapse-button-icon > i").addClass("fa-chevron-left");
      // $(".collapse-button-icon > i").removeClass("fa-chevron-left");
    }else{
      $(".collapse-button-icon > i").removeClass("fa-chevron-right");
      // $(".collapse-button-icon > i").AddClass("fa-chevron-left");
    }
    
});