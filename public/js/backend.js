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
       var url   = window.location.href;
       var hostname = window.location.hostname;
       if (url ===  "http://"+hostname+"/inventory/medicine") {
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
      $('<div id="childrenField" class="col-12 form-row"><div class="form-group col-md-4"><input type="text" class="form-control mr-2" name="children['+i+'][]" placeholder="Child\'s Name" value="" required></div><div class="form-group col-md-3"><input type="date" class="form-control mr-2" name="children['+i+'][]" " value="" required></div><div class="form-group col-md-3"> <select class="form-control mr-2" name="children['+i+'][]" required><option selected="true" disabled="true" value="">Select Gender</option><option value="male">Male</option><option value="female">Female</option></select></div><div class="form-group col-md-2"><a id="removeChildren" class="btn btn-danger text-white  btn-block"><i class="fa fa-times"></i> Remove Child</a></div></div>').appendTo('#children');
    i++;

    });
    // Children
    $("#editChildren").click(function(event) {
      /* $('<div id="childrenField" class="col-auto my-1 form-inline editchildren"><label for="children" class="mr-2">Child\'s Name</label><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Child\'s Name" value="" required><label for="children" class="mr-2">Birthday</label><input type="date" class="form-control mr-2" name="children['+e+'][]" " value="" required><label for="children" class="mr-2">Gender</label><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Gender" value="" required><a id="removeChildren" class="btn btn-danger text-white"><i class="fa fa-times"></i></a></div>').appendTo('#children');*/
      // $('<div id="childrenField" class="col-12 form-row editchildren"><div class="form-group col-md-4"><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Child\'s Name" value="" required></div><div class="form-group col-md-3"><input type="date" class="form-control mr-2" name="children['+e+'][]" " value="" required></div><div class="form-group col-md-3"><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Gender" value="" required></div><div class="form-group col-md-2"><a id="removeChildren" class="btn btn-danger text-white  btn-block"><i class="fa fa-times"></i> Remove Child</a></div></div>').appendTo('#children');
      $('<div id="childrenField" class="col-12 form-row editchildren"><div class="form-group col-md-4"><input type="text" class="form-control mr-2" name="children['+e+'][]" placeholder="Child\'s Name" value="" required></div><div class="form-group col-md-3"><input type="date" class="form-control mr-2" name="children['+e+'][]" " value="" required></div><div class="form-group col-md-3"><select class="form-control mr-2" name="children['+e+'][]" placeholder="Gender" required><option selected="true" disabled="true" value="">Select Gender</option><option value="male">Male</option><option value="female">Female</option></select></div><div class="form-group col-md-2"><a id="removeChildren" class="btn btn-danger text-white  btn-block"><i class="fa fa-times"></i> Remove Child</a></div></div>').appendTo('#children');
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
    var hostname = window.location.hostname;
    if (window.location.href == "http://"+hostname+"/hr/employees/7/edit") {
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
    $('#myform select[name="brand_id[0][0]"] option').remove();
    $('#myform select[name="brand_id[0][0]"] option').prop('required',false);
    $('#myform select[name="brand_id[0][0]"]').append('<option selected="true" disabled="disabled"> Select Medicine </option>')
    $('#myform input[name="quantity[0][0]"]').prop('required',false);
    $('#myform input[name="quantity[0][0]"]').removeAttr('max');
    $('#myform input[name="quantity[0][0]"]').prop('placeholder','Quantity');
    $(this).addClass('d-none');
  });

  var status_selected = $("#myform select[name='generic_id[0][0]']").children('option:selected').val();
  if (status_selected) {
    $("#select_generic").removeClass('d-none');
  }else{
    $("#select_generic").addClass('d-none');
  }

// Employees Medical Medicine In Show Blade_____________________________________________________________________________________________________

  $("#myform-show #select_generic_show").on('click', function(e){
    $('#myform-show select[name="generic_id[0][0]"]').prop('selectedIndex',0);
    $('#myform-show select[name="brand_id[0][0]"] option').remove();
    $('#myform-show select[name="brand_id[0][0]"] option').prop('required',false);
    $('#myform-show select[name="brand_id[0][0]"]').append('<option selected="true" disabled="disabled"> Select Medicine </option>')
    $('#myform-show input[name="quantity[0][0]"]').prop('required',false);
    $('#myform-show input[name="quantity[0][0]"]').removeAttr('max');
    $('#myform-show input[name="quantity[0][0]"]').prop('placeholder','Quantity');
    $(this).addClass('d-none');
  });

  var status_selected = $("#myform-show select[name='generic_id[0][0]']").children('option:selected').val();
  if (status_selected) {
    $("#select_generic_show").removeClass('d-none');
  }else{
    $("#select_generic_show").addClass('d-none');
  }

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

});