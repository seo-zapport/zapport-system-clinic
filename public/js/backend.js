jQuery(document).ready(function($){

	$('.show-edit').on('click', function(e){
	    $('.form-hidden-'+this.id).toggleClass('form-hide');
	});

	// AJAX
    jQuery('select[name="department_id"]').on('change',function(){
       var department_id = jQuery(this).val();
       // var myUrl = 'create/deptID/';
       var url   = window.location.href;
       var hostname = window.location.hostname;

       if (url === "http://"+hostname+"/hr/employees/create") {
         var myUrl = 'create/deptID/';
       }else {
          var myUrl = 'http://'+hostname+'/hr/employees/edit/deptID/';
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
       var hostname = window.location.hostname;
       var url   = window.location.pathname;

       if ("http://"+hostname+""+url ===  "http://"+hostname+"/inventory/medicine") {
         var myUrl = 'medicine/gen/';
       }else {
          var myUrl = "http://"+hostname+"/medical/employees/gen/";
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
      $('<div id="childrenField" class="col-12 form-row"><div class="form-group col-md-4"><input type="text" class="form-control mr-2" name="children['+i+'][]" placeholder="Child\'s Name" value="" required></div><div class="form-group col-md-3"><input type="date" class="form-control mr-2" name="children['+i+'][]" " value="" required></div><div class="form-group col-md-3"> <select class="form-control mr-2" name="children['+i+'][]" required><option selected="true" disabled="true" value="">Select Gender</option><option value="male">Male</option><option value="female">Female</option></select></div><div class="form-group col-md-2"><a id="removeChildren" class="btn btn-danger text-white  btn-block"><i class="fa fa-times"></i> Remove </a></div></div>').appendTo('#children');
    i++;

    });
    // Children
    $("#editChildren").click(function(event) {
      /* $('<div id="childrenField" class="col-auto my-1 form-inline editchildren"><label for="children" class="mr-2">Child\'s Name</label><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Child\'s Name" value="" required><label for="children" class="mr-2">Birthday</label><input type="date" class="form-control mr-2" name="children['+e+'][]" " value="" required><label for="children" class="mr-2">Gender</label><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Gender" value="" required><a id="removeChildren" class="btn btn-danger text-white"><i class="fa fa-times"></i></a></div>').appendTo('#children');*/
      // $('<div id="childrenField" class="col-12 form-row editchildren"><div class="form-group col-md-4"><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Child\'s Name" value="" required></div><div class="form-group col-md-3"><input type="date" class="form-control mr-2" name="children['+e+'][]" " value="" required></div><div class="form-group col-md-3"><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Gender" value="" required></div><div class="form-group col-md-2"><a id="removeChildren" class="btn btn-danger text-white  btn-block"><i class="fa fa-times"></i> Remove Child</a></div></div>').appendTo('#children');
      $('<div id="childrenField" class="col-12 form-row editchildren"><div class="form-group col-md-4"><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Child\'s Name" value="" required></div><div class="form-group col-md-3"><input type="date" class="form-control mr-2" name="children['+e+'][]" " value="" required></div><div class="form-group col-md-3"><select class="form-control mr-2" name="children['+e+'][]" placeholder="Gender" required><option selected="true" disabled="true" value="">Select Gender</option><option value="male">Male</option><option value="female">Female</option></select></div><div class="form-group col-md-2"><a id="removeChildren" class="btn btn-danger text-white  btn-block"><i class="fa fa-times"></i> Remove </a></div></div>').appendTo('#children');
    e++;

    });
    // Children
    $("body").on("click", "#removeChildren", function(event){
      if (i > 1 || e >= 0) {
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

    // College variables_________________________________________________________________________________
    var college =  $("#empForm input[name='college']");
    var grad_date = $("#empForm input[name='college_grad_date']");
    var hostname = window.location.hostname;

    if (window.location.href == "http://"+hostname+"/hr/employees/create") {

      // College if location == create_________________________________________________________________________________
      $("#empForm input[name='college'], input[name='college_grad_date'], input[name='course']").on('change', function(){
        var college_input = $('input[name="college"]').val();
        var college_grad = $('input[name="college_grad_date"]').val();
        var college_course = $('input[name="course"]').val();
        if (college_input == '' && college_grad == '' && college_course =='') {
         $('input[name="college"]').prop('required', false);
         $('input[name="college_grad_date"]').prop('required', false);
         $('input[name="course"]').prop('required', false);
        }else{
          $('input[name="college"]').prop('required', true);
          $('input[name="college_grad_date"]').prop('required', true);
          $('input[name="course"]').prop('required', true);
        }
      });

      // Experience if location == create_________________________________________________________________________________

      $("#empForm #company_name, #work_position, #work_exp_1, #work_exp_2").on('change', function(){
        var company_name = $("#company_name").val();
        var work_position = $("#work_position").val();
        var work_exp_1 = $("#work_exp_1").val();
        var work_exp_2 = $("#work_exp_2").val();
        if (company_name == '' && work_position == '' && work_exp_1 == '' && work_exp_2 == '') {
          $("#company_name").prop('required', false);
          $("#work_position").prop('required', false);
          $("#work_exp_1").prop('required', false);
          $("#work_exp_2").prop('required', false);
        }else{
          $("#company_name").prop('required', true);
          $("#work_position").prop('required', true);
          $("#work_exp_1").prop('required', true);
          $("#work_exp_2").prop('required', true);
        }
      });

      // Spouse if location == create_________________________________________________________________________________

      // $("#empForm input[name='spouse_name'], input[name='date_of_marriage']").on('change', function(){
      //   var spouse = $("#empForm input[name='spouse_name']").val();
      //   var date_of_marriage = $("#empForm input[name='date_of_marriage']").val();
      //   if (spouse == '' && date_of_marriage == '') {
      //     $("#empForm input[name='spouse_name']").prop('required', false);
      //     $("#empForm input[name='date_of_marriage']").prop('required', false);
      //   }else{
      //     $("#empForm input[name='spouse_name']").prop('required', true);
      //     $("#empForm input[name='date_of_marriage']").prop('required', true);
      //   }
      // });

    }else{

      // College if location == edit_________________________________________________________________________________
      $("#empForm input[name='college'], input[name='college_grad_date'], input[name='course']").on('change', function(){
        var college_input = $('input[name="college"]').val();
        var college_grad = $('input[name="college_grad_date"]').val();
        var college_course = $('input[name="course"]').val();
        if (college_input == '' && college_grad == '' && college_course =='') {
         $('input[name="college"]').prop('required', false);
         $('input[name="college_grad_date"]').prop('required', false);
         $('input[name="course"]').prop('required', false);
        }else{
          $('input[name="college"]').prop('required', true);
          $('input[name="college_grad_date"]').prop('required', true);
          $('input[name="course"]').prop('required', true);
        }
      });

      // Experience if location == edit_________________________________________________________________________________

      $("#empForm #company_name, #work_position, #work_exp_1, #work_exp_2").on('change', function(){
        var company_name = $("#company_name").val();
        var work_position = $("#work_position").val();
        var work_exp_1 = $("#work_exp_1").val();
        var work_exp_2 = $("#work_exp_2").val();
        if (company_name == '' && work_position == '' && work_exp_1 == '' && work_exp_2 == '') {
          $("#company_name").prop('required', false);
          $("#work_position").prop('required', false);
          $("#work_exp_1").prop('required', false);
          $("#work_exp_2").prop('required', false);
        }else{
          $("#company_name").prop('required', true);
          $("#work_position").prop('required', true);
          $("#work_exp_1").prop('required', true);
          $("#work_exp_2").prop('required', true);
        }
      });

      // Spouse if location == edit_________________________________________________________________________________

      $("#empForm input[name='spouse_name'], input[name='date_of_marriage']").on('change', function(){
        var spouse = $("#empForm input[name='spouse_name']").val();
        var date_of_marriage = $("#empForm input[name='date_of_marriage']").val();
        if (spouse == '' && date_of_marriage == '') {
          $("#empForm input[name='spouse_name']").prop('required', true);
          $("#empForm input[name='date_of_marriage']").prop('required', true);
        }else{
          $("#empForm input[name='spouse_name']").prop('required', true);
          $("#empForm input[name='date_of_marriage']").prop('required', true);
        }
      });

    }

    // Children (CREATE)_________________________________________________________________________________

    $("#empForm #ChildName, #ChildBday, select[name='children[0][]']").on('change', function(e){
      var child_name = $("#empForm #ChildName").val();
      var child_bday = $("#empForm #ChildBday").val();
      var child_gender = $("#empForm select[name='children[0][]']").val();

      if (child_name != '' || child_bday != '' || child_gender != null) {
        $("#empForm #ChildName").prop('required', true);
        $("#empForm #ChildBday").prop('required', true);
        $("#empForm select[name='children[0][]']").prop('required', true);
      }else if (child_name == '' && child_bday == '' && child_gender == null){
        $("#empForm #ChildName").prop('required', false);
        $("#empForm #ChildBday").prop('required', false);
        $("#empForm select[name='children[0][]']").prop('required', false);
      }

    });

    // Children (EDIT)_________________________________________________________________________________

    $("#empForm #ChildNameEdit, #ChildBdayEdit, select[name='children[0][]']").on('change', function(e){
      var child_name = $("#empForm #ChildNameEdit").val();
      var child_bday = $("#empForm #ChildBdayEdit").val();
      var child_gender = $("#empForm select[name='children[0][]']").val();

      if (child_name != '' || child_bday != '' || child_gender != null) {
        $("#empForm #ChildNameEdit").prop('required', true);
        $("#empForm #ChildBdayEdit").prop('required', true);
        $("#empForm select[name='children[0][]']").prop('required', true);
      }else if (child_name == '' && child_bday == '' && child_gender == null){
        $("#empForm #ChildNameEdit").prop('required', false);
        $("#empForm #ChildBdayEdit").prop('required', false);
        $("#empForm select[name='children[0][]']").prop('required', false);
      }

    });
  

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


  var count = $("#newConsTable #newCons").length;
  var FFcount = $("#forFollowUp #FFup").length;
  var incCount = $("#IncReq #inc").length;
  var forRegCount = $("#CandReg #forReg").length;
  var PreEmpCount = $("#IncPreEmp #incPre").length;
  
  if (count > 0) {
   $("#v-new-consultation-tab").append('<span class="dash-badge">'+count+'</span>');
  }
  if(FFcount > 0){
    $("#v-follow-up-tab").append('<span class="dash-badge">'+FFcount+'</span>');
  }
  if (incCount) {
    $("#v-inc-requirements-tab").append('<span class="dash-badge">'+incCount+'</span>');
  }  
  if (forRegCount) {
    $("#v-inc-emp-6months-tab").append('<span class="dash-badge">'+forRegCount+'</span>');
  }
    if(PreEmpCount > 0){
    $("#v-inc-preEmp-tab").append('<span class="dash-badge">'+PreEmpCount+'</span>');
  }

  $.ajax({
    type: 'GET',
    url: '/dashboard/notification/',
    dataType : "json",
    success:function(response)
    {
      var doctor = response.admin_doctor + response.admin_nurse_doctor;
      var nurse = response.admin_nurse_doctor;
      var hr = response.admin_hr + response.admin_hr2;
      var admin = doctor + hr;
      $("#adminNotif").append('<span id="Notifs" class="text-center text-white bg-danger float-right">'+admin+'</span>');
      $("#doctorNotif").append('<span id="Notifs" class="text-center text-white bg-danger float-right">'+doctor+'</span>');
      $("#nurseNotif").append('<span id="Notifs" class="text-center text-white bg-danger float-right">'+nurse+'</span>');
      $("#hrNotif").append('<span id="Notifs" class="text-center text-white bg-danger float-right">'+hr+'</span>');

      $("#adminNotifTitle").append('( '+admin+' )');
      $("#doctorNotifTitle").append('( '+doctor+' )');
      $("#nurseNotifTitle").append('( '+nurse+' )');
      $("#hrNotifTitle").append('( '+hr+' )');
    }
  });

  $("#showFilter").on('click', function(e){
    $("#advncfilter").toggleClass('d-none');
  });


  // Employee Gender_____________________________________________________________________________________________________

  $("#advncfilter select[name='filter_gender']").on('change', function(e){
    var selected = $(this).children('option:selected').val();
    console.log(selected);
    if (selected) {
      $("#clear_gender").removeClass('d-none');
    }else{
      $("#clear_gender").addClass('d-none');
    }
  });

  $("#clear_gender").on('click', function(e){
    $("select[name='filter_gender']").prop('selectedIndex',0);
    $(this).addClass('d-none');
  });

  var gender_selected = $("#advncfilter select[name='filter_gender']").children('option:selected').val();
  if (gender_selected) {
    $("#clear_gender").removeClass('d-none');
  }else{
    $("#clear_gender").addClass('d-none');
  }

  // Employee Type_____________________________________________________________________________________________________

  $("#advncfilter select[name='filter_empType']").on('change', function(e){
    var selected = $(this).children('option:selected').val();
    if (selected) {
      $("#clear_type").removeClass('d-none');
    }else{
      $("#clear_type").addClass('d-none');
    }
  });

  $("#clear_type").on('click', function(e){
    $("select[name='filter_empType']").prop('selectedIndex',0);
    $(this).addClass('d-none');
  });

  var type_selected = $("#advncfilter select[name='filter_empType']").children('option:selected').val();
  if (type_selected) {
    $("#clear_type").removeClass('d-none');
  }else{
    $("#clear_type").addClass('d-none');
  }

  // Employee Age_____________________________________________________________________________________________________

  $("#advncfilter select[name='filter_age']").on('change', function(e){
    var selected = $(this).children('option:selected').val();
    if (selected) {
      $("#clear_age").removeClass('d-none');
    }else{
      $("#clear_age").addClass('d-none');
    }
  });

  $("#clear_age").on('click', function(e){
    $("select[name='filter_age']").prop('selectedIndex',0);
    $(this).addClass('d-none');
  });

  var age_selected = $("#advncfilter select[name='filter_age']").children('option:selected').val();
  if (age_selected) {
    $("#clear_age").removeClass('d-none');
  }else{
    $("#clear_age").addClass('d-none');
  }

  // Employee Status_____________________________________________________________________________________________________

  $("#advncfilter select[name='filter_status']").on('change', function(e){
    var selected = $(this).children('option:selected').val();
    if (selected) {
      $("#clear_status").removeClass('d-none');
    }else{
      $("#clear_status").addClass('d-none');
    }
  });

  $("#clear_status").on('click', function(e){
    $("select[name='filter_status']").prop('selectedIndex',0);
    $(this).addClass('d-none');
  });

  var status_selected = $("#advncfilter select[name='filter_status']").children('option:selected').val();
  if (status_selected) {
    $("#clear_status").removeClass('d-none');
  }else{
    $("#clear_status").addClass('d-none');
  }

  // Employees Medical Medicine_____________________________________________________________________________________________________

  $("#myform #select_generic").on('click', function(e){
    $('#myform select[name="generic_id[0][0]"]').prop('selectedIndex',0);
    $('#myform select[name="generic_id[0][0]"]').prop('required',false);
    $('#myform select[name="brand_id[0][0]"] option').remove();
    $('#myform select[name="brand_id[0][0]"]').prop('required',false);
    $('#myform select[name="brand_id[0][0]"]').append('<option selected="true" disabled="disabled"> Select Medicine </option>')
    $('#myform input[name="quantity[0][0]"]').prop('required',false);
    $('#myform input[name="quantity[0][0]"]').removeAttr('max');
    $('#myform input[name="quantity[0][0]"]').prop('placeholder','Quantity');
    $('#myform input[name="quantity[0][0]"]').val('');
    $(this).addClass('d-none');
  });

  var status_selected = $("#myform select[name='generic_id[0][0]']").children('option:selected').val();
  if (status_selected) {
    $("#select_generic").removeClass('d-none');
  }else{
    $("#select_generic").addClass('d-none');
  }

  $('#myform input[name="quantity[0][0]"]').on('keyup', function(){
    var empMedQtty =  $('#myform input[name="quantity[0][0]"]').val();
   if (empMedQtty != '') {
    $('#myform select[name="brand_id[0][0]"]').prop('required',true);
    $('#myform select[name="generic_id[0][0]"]').prop('required',true);
   }else{
    $('#myform select[name="brand_id[0][0]"]').prop('required',false);
    $('#myform select[name="generic_id[0][0]"]').prop('required',false);
   }
  });

  // Employees Medical Medicine In Show Blade_____________________________________________________________________________________________________

  $("#myform-show #select_generic_show").on('click', function(e){
    $('#myform-show select[name="generic_id[0][0]"]').prop('selectedIndex',0);
    $('#myform-show select[name="generic_id[0][0]"]').prop('required',false);
    $('#myform-show select[name="brand_id[0][0]"] option').remove();
    $('#myform-show select[name="brand_id[0][0]"]').prop('required',false);
    $('#myform-show select[name="brand_id[0][0]"]').append('<option selected="true" disabled="disabled"> Select Medicine </option>')
    $('#myform-show input[name="quantity[0][0]"]').prop('required',false);
    $('#myform-show input[name="quantity[0][0]"]').removeAttr('max');
    $('#myform-show input[name="quantity[0][0]"]').prop('placeholder','Quantity');
    $('#myform-show input[name="quantity[0][0]"]').val('');
    $(this).addClass('d-none');
  });

  var status_selected = $("#myform-show select[name='generic_id[0][0]']").children('option:selected').val();
  if (status_selected) {
    $("#select_generic_show").removeClass('d-none');
  }else{
    $("#select_generic_show").addClass('d-none');
  }

  $('#myform-show input[name="quantity[0][0]"]').on('keyup', function(){
    var empMedQtty =  $('#myform-show input[name="quantity[0][0]"]').val();
   if (empMedQtty != '') {
    $('#myform-show select[name="brand_id[0][0]"]').prop('required',true);
    $('#myform-show select[name="generic_id[0][0]"]').prop('required',true);
   }else{
    $('#myform-show select[name="brand_id[0][0]"]').prop('required',false);
    $('#myform-show select[name="generic_id[0][0]"]').prop('required',false);
   }
  });

  // Employees Children if any (CREATE)_____________________________________________________________________________________________________

  $("#children select[name='children[0][]']").on('change', function(e){
    var selected = $(this).children('option:selected').val();
    if (selected) {
      $("#clear_children_create").removeClass('d-none');
    }else{
      $("#clear_children_create").addClass('d-none');
    }
  });

  $("#empForm #clear_children_create").on('click', function(e){
    var check_name = $("#empForm #ChildName").val();
    var check_bday = $("#empForm #ChildBday").val();
    $("#empForm select[name='children[0][]']").prop('selectedIndex', 0);
    $(this).addClass('d-none');

    if (check_name == '' && check_bday == '') {
      $("#empForm #ChildName").prop('required', false);
      $("#empForm #ChildBday").prop('required', false);
      $("#empForm select[name='children[0][]']").prop('required', false);
    }

  });

  // Employees Children if any (EDIT)_____________________________________________________________________________________________________

  $("#children select[name='children[0][]']").on('change', function(e){
    var selected = $(this).children('option:selected').val();
    if (selected) {
      $("#clear_children_edit").removeClass('d-none');
    }else{
      $("#clear_children_edit").addClass('d-none');
    }
  });

  $("#empForm #clear_children_edit").on('click', function(e){
    var check_name = $("#empForm #ChildNameEdit").val();
    var check_bday = $("#empForm #ChildBdayEdit").val();
    $("#empForm select[name='children[0][]']").prop('selectedIndex', 0);
    $(this).addClass('d-none');

    if (check_name == '' && check_bday == '') {
      $("#empForm #ChildNameEdit").prop('required', false);
      $("#empForm #ChildBdayEdit").prop('required', false);
      $("#empForm select[name='children[0][]']").prop('required', false);
    }

  });

  // Medicines History_____________________________________________________________________________________________________

  $("#filter_med_history select[name='search_date']").on('change', function(e){
    var selected = $(this).children('option:selected').val();
    if (selected) {
      $("#med_history_search_date").removeClass('d-none');
    }else{
      $("#med_history_search_date").addClass('d-none');
    }
  });

  $("#filter_med_history #med_history_search_date").on('click', function(e){
    $("#filter_med_history select[name='search_date']").prop('selectedIndex', 0);
    $(this).addClass('d-none');
  });

  var selected_date = $("#filter_med_history select[name='search_date']").val();
  if (selected_date != null) {
    $("#med_history_search_date").removeClass('d-none');
  }

  // Medicines Logs_____________________________________________________________________________________________________

  $("#meds_log select[name='search']").on('change', function(e){
    var selected = $(this).children('option:selected').val();
    if (selected) {
      $("#med_log_search_date").removeClass('d-none');
    }else{
      $("#med_log_search_date").addClass('d-none');
    }
  });

  $("#meds_log #med_log_search_date").on('click', function(e){
    $("#meds_log select[name='search']").prop('selectedIndex', 0);
    $(this).addClass('d-none');
  });

  var selected_log_date =  $("#meds_log select[name='search']").val();
  if (selected_log_date != null) {
    $("#med_log_search_date").removeClass('d-none');
  }

  // Generic Suggestions_____________________________________________________________________________________________________
  $("#diagnosis_suggetions input[name='search']").on('keyup', function(){
    var query = $(this).val();
    $.ajax({
      type: 'GET',
      url: '/inventory/medicine/generic/suggestions/'+query,
      data: { 'generic': query },
      success: function(response)
      {
        console.log(response);
        $('#suggestions_list').html(response);
      },
      error: function(response)
      {
        console.log(response);
      }
    });
  })

  $(document).on('click', '#diagnosis_suggetions li', function(){
      var value = $(this).text();
      $("input[name='search']").val(value);
      $('#suggestions_list').html("");
  });

  // Media Upload_____________________________________________________________________________________________________

  $("#media_up").on('change', function(e){
    e.preventDefault();
    $(this).submit();
  });

  // Snippet Actions Hover_____________________________________________________________________________________________________
  $("table.table-hover tr").hover(function(e) {
    $(this).find('td').find('.row-actions').addClass('visible');
  },function(e){
    $(this).find('td').find('.row-actions').removeClass('visible');
  });

 // Sidebar hide&show_____________________________________________________________________________________________________

  $('.zp-navbar-show').on('click', function(e){

    if ($('#adminMainMenu').css("margin-left") == '-999px' ){
      $('#adminMainMenu').stop(true, true).animate({
        opacity: 1,
        marginLeft: '0'
      }, 'slow', 'linear');
      if ($('.zp-navbar-show span').hasClass('navbar-toggler-icon') ) {
        $('.zp-navbar-show span.navbar-toggler-icon').addClass('fas fa-times');
        $('.zp-navbar-show span').removeClass('navbar-toggler-icon');
      }
    }else{
      $('#adminMainMenu').stop(true, true).animate({
        opacity: 0,
        marginLeft: '-999px'
      }, 'slow', 'linear');
      if ($('.zp-navbar-show span').hasClass('fas')) {
        $('.zp-navbar-show span.fas').addClass('navbar-toggler-icon');
        $('.zp-navbar-show span').removeClass('fas fa-times');
      }
    }
  });


 // Remove inline style_____________________________________________________________________________________________________
  $(window).on('load resize', function(){
    var viewWidth = $(window).width();
    if ( viewWidth >= 750) {
      if ( $('#adminMainMenu').attr('style') ) {
        $('#adminMainMenu').removeAttr('style');
      }
    }
  });

  // Disable button

});