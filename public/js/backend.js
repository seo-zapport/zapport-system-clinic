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
      // $('<div id="childrenField" class="col-12 form-row"><div class="form-group col-md-4"><input type="text" class="form-control mr-2" name="children['+i+'][]" placeholder="Child\'s Name" value="" required></div><div class="form-group col-md-3"><input type="date" class="form-control mr-2" name="children['+i+'][]" " value="" required></div><div class="form-group col-md-3"><input type="text" class="form-control mr-2" name="children['+i+'][]" placeholder="Gender" value="" required></div><div class="form-group col-md-2"><a id="removeChildren" class="btn btn-danger text-white  btn-block"><i class="fa fa-times"></i> Remove Child</a></div></div>').appendTo('#children');
      $('<div id="childrenField" class="col-12 form-row"><div class="form-group col-md-4"><input type="text" class="form-control mr-2" name="children['+i+'][]" placeholder="Child\'s Name" value="" required></div><div class="form-group col-md-3"><input type="date" class="form-control mr-2" name="children['+i+'][]" " value="" required></div><div class="form-group col-md-3"> <select class="form-control mr-2" name="children['+i+'][]" required><option selected="true" disabled="true">Select Gender</option><option value="male">Male</option><option value="female">Female</option></select></div><div class="form-group col-md-2"><a id="removeChildren" class="btn btn-danger text-white  btn-block"><i class="fa fa-times"></i> Remove Child</a></div></div>').appendTo('#children');
    i++;

    });
    // Children
    $("#editChildren").click(function(event) {
      /* $('<div id="childrenField" class="col-auto my-1 form-inline editchildren"><label for="children" class="mr-2">Child\'s Name</label><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Child\'s Name" value="" required><label for="children" class="mr-2">Birthday</label><input type="date" class="form-control mr-2" name="children['+e+'][]" " value="" required><label for="children" class="mr-2">Gender</label><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Gender" value="" required><a id="removeChildren" class="btn btn-danger text-white"><i class="fa fa-times"></i></a></div>').appendTo('#children');*/
      // $('<div id="childrenField" class="col-12 form-row editchildren"><div class="form-group col-md-4"><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Child\'s Name" value="" required></div><div class="form-group col-md-3"><input type="date" class="form-control mr-2" name="children['+e+'][]" " value="" required></div><div class="form-group col-md-3"><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Gender" value="" required></div><div class="form-group col-md-2"><a id="removeChildren" class="btn btn-danger text-white  btn-block"><i class="fa fa-times"></i> Remove Child</a></div></div>').appendTo('#children');
      $('<div id="childrenField" class="col-12 form-row editchildren"><div class="form-group col-md-4"><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Child\'s Name" value="" required></div><div class="form-group col-md-3"><input type="date" class="form-control mr-2" name="children['+e+'][]" " value="" required></div><div class="form-group col-md-3"><select class="form-control mr-2" name="children['+e+'][]" placeholder="Gender" value="" required><option selected="true" disabled="true" value="">Select Gender</option><option value="male">Male</option><option value="female">Female</option></select></div><div class="form-group col-md-2"><a id="removeChildren" class="btn btn-danger text-white  btn-block"><i class="fa fa-times"></i> Remove Child</a></div></div>').appendTo('#children');
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
      $('<div id="workField" class="form-row"><div class="form-group col-md-3"><input type="text" class="form-control mr-2" name="experience['+a+'][]" placeholder="Name of Company" value="" required></div><div class="form-group col-md-3"><input type="text" class="form-control mr-2" name="experience['+a+'][]" " value="" placeholder="Position" required></div><div class="form-group col-md-5"><div class="form-inline"><div class="form-group"><input type="date" class="form-control" name="experience['+a+'][]" value=""><span class="mx-1"> To</span><input type="date" class="form-control mr-2" name="experience['+a+'][]" value="" required></div></div></div><div class="form-group col-md-1"><a id="removeWork" class="btn btn-danger text-white"><i class="fa fa-times mr-1"></i><i class="fas fa-briefcase"></i></a></div></div>').appendTo('#work');
    a++;

    });
    // Work
    $("#editWork").click(function(event) {
      // $('<div id="workField" class="col-auto my-1 form-inline editwork"><label for="work" class="mr-2">Name of Company</label><input type="text" class="form-control mr-2" name="experience['+b+'][]" placeholder="Name of Company" value="" required><label for="work" class="mr-2">Position</label><input type="text" class="form-control mr-2" name="experience['+b+'][]" " value="" placeholder="Position" required><label for="work" class="mr-2">Period Covered</label><input type="date" class="form-control mr-2" name="experience['+b+'][]" value=""><label for="work" class="ml-2 mr-2">To</label><input type="date" class="form-control ml-2 mr-2" name="experience['+b+'][]" value="" required><a id="removeWork" class="btn btn-danger text-white"><i class="fa fa-times"></i></a></div>').appendTo('#work');
      $('<div id="workField" class="form-row editwork"><div class="form-group col-md-3"><input type="text" class="form-control mr-2" name="experience['+b+'][]" placeholder="Name of Company" value="" required></div><div class="form-group col-md-3"><input type="text" class="form-control mr-2" name="experience['+b+'][]" " value="" placeholder="Position" required></div><div class="form-group col-md-5"><div class="form-inline"><div class="form-group"><input type="date" class="form-control" name="experience['+b+'][]" value=""><span class="mx-1"> To</span><input type="date" class="form-control mr-2" name="experience['+b+'][]" value="" required></div></div></div><div class="form-group col-md-1"><a id="removeWork" class="btn btn-danger text-white"><i class="fa fa-times mr-1"></i><i class="fas fa-briefcase"></i></a></div></div>').appendTo('#work');
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


    // Form Validation Add Required IF first OR second input is not EMPTY

    // Spouse_________________________________________________________________________________
    var spouse = $("#empForm input[name='spouse_name']");
    var date_of_merriage = $("#empForm input[name='date_of_merriage']");
    spouse.blur(function() {
      if ($(this).val()) {
        date_of_merriage.prop('required', true);
      }else{
        date_of_merriage.prop('required', false);
      }
    });

    date_of_merriage.blur(function() {
      if ($(this).val()) {
        spouse.prop('required', true);
      }else{
        spouse.prop('required', false);
      }
    });
    // College variables_________________________________________________________________________________
    var college =  $("#empForm input[name='college']");
    var grad_date = $("#empForm input[name='college_grad_date']");
    if (window.location.href == 'http://clinic/hr/employees/7/edit') {
      // College_________________________________________________________________________________
      $("#empForm input[name='college'], input[name='college_grad_date']").on('change', function(){
        var collegeVal = $('input[name="college"]').val();
        var gradDateVal = $('input[name="college_grad_date"]').val();
        if (collegeVal == '' && gradDateVal == '') {
          college.prop('required', false);
          grad_date.prop('required', false);
        }else{
          college.prop('required', true);
          grad_date.prop('required', true);
        }
      });

    }
    // College if location == create_________________________________________________________________________________
      college.blur(function() {
        if ($(this).val()) {
          grad_date.prop('required', true);
        }else{
          grad_date.prop('required', false);
        }
      });

      grad_date.blur(function() {
        if ($(this).val()) {
          college.prop('required', true);
        }else{
          college.prop('required', false);
        }
      });
    // Experience_________________________________________________________________________________
    var experience = $("#empForm input[name='experience[0][]']");
    experience.blur(function() {
      if ($(this).val()) {
        experience.prop('required', true);
      }else{
        experience.prop('required', false);
      }
    });
    // Children_________________________________________________________________________________
    var children = $("#empForm input[name='children[0][]'], #empForm select[name='children[0][]']");
    children.blur(function() {
      if ($(this).val()) {
        children.prop('required', true);
      }else{
        children.prop('required', false);
      }
    });

// Post_________________________________________________________________________________

  // $("#InsertPhoto").click(function () {
  // $("#Media").modal("hide"); // Close the modal
  // $image_id = $('#edit_id').val();
  // $("#preview_images").attr('src',$('#attach_url_'+$image_id).val());
  // / If variable value is not empty we pass it to tinymce function and it inserts the image to post /
  // if ($image_id != "") { 
  // tinymce.activeEditor.execCommand('mceInsertContent', false, '<img class="img-responsive" style="max-width:100%; height:auto; display:block;" src="' + $('#attach_url_'+$image_id).val() + '">'); 
  // }
  // });
  

   /**
    * TinyMCE Text Editor
    */
   tinymce.init({
       selector: 'textarea[name=description]',
       max_height: 500,
       min_height: 500,
       menubar: false,
       branding: false,
       resize: false,
       relative_urls: false,
       plugins: [
           'advlist autolink lists link charmap print preview anchor',
           'searchreplace visualblocks code fullscreen',
           'insertdatetime table contextmenu paste code',
           'link image'
       ],
       setup: function (editor) {
       editor.addButton('newmedia', {
        text: 'Add media',
        title: 'Add image to article',
        icon: 'image',
        onclick: function() {
          $("#newMedia").modal("show");
        } });
        },
       toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | code | newmedia'

       //content_css: ‘https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css’,

   });

   $("#addMds").on('click', '#medBtn', function(event) {
     var gen = $('select[name="generic_id"]').val();
     var brn = $('select[name="brand_id"]').val();
     var dte = $('input[name="expiration_date"]').val();
     var qty = $('input[name="qty_input"]').val();
     if (gen != null && brn != null && dte != qty) {
      $("#medBtn").prop('disabled', true);
      $("#addMds").submit();
     }
   });

  // $(function () {
  //     $("#media #img_cont").click(function (event) {
  //       $("#newMedia").modal("hide");
  //         var sr = $('img', this).attr('src');
  //       tinymce.activeEditor.insertContent('<img class="img-fluid" src="' + sr + '"/>');
  //     });
  // });

// $("#media #img_cont").on('click', function(){
//   var hrf = $(this).attr('data-id');
//   console.log(hrf);
//  $.ajaxSetup({
//       headers: {
//           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//       },
//   });
//   $.ajax({
//     url: 'create/media/'+hrf,
//     type: 'delete',
//     data: hrf,
//     dataType: 'json',
//     success:function(data){
//       console.log(data);
//     }
//   });

// });

// $("#featImgModal").on('click', '#ftdimg', function(event) {
//   event.preventDefault();
//   var i = $(this).attr('data-target');
//   console.log(i.replace('#modal-', ''));
//   $.ajax({
//     type: 'GET',
//     url: 'create/'+i,
//     dataType : "json",
//     success: function(response)
//     {
//       console.log(response);
//     }
//   });
// });

  var count = $("#newConsTable #newCons").length
  var FFcount = $("#forFollowUp #FFup").length
  var incCount = $("#IncReq #inc").length
  var forRegCount = $("#CandReg #forReg").length
  if (count > 0) {
   $("#v-new-consultation-tab").append('<span class="text-center text-white bg-danger float-right">'+count+'</span>');
  }
  if(FFcount > 0){
    $("#v-follow-up-tab").append('<span class="text-center text-white bg-danger float-right">'+FFcount+'</span>');
  }
  if (incCount) {
    $("#v-inc-requirements-tab").append('<span class="text-center text-white bg-danger float-right">'+incCount+'</span>');
  }  
  if (forRegCount) {
    $("#v-inc-emp-6months-tab").append('<span class="text-center text-white bg-danger float-right">'+forRegCount+'</span>');
  }

});