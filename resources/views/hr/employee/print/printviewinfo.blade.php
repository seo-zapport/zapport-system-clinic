<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backend.css') }}" rel="stylesheet">


<style type="text/css">
	.bor{
		border: #6c757d solid 1px;
	}	

</style>

</head>
<body>


	<div class="col-12 col-lg-12">
		<div class="text-center">	
			<img src="{{url( '/images/logo.png' )}}" alt="Zapport" style="display: block; margin:auto; width: 200px">
			<div style="margin-top: 20px; margin-bottom: 20px;">
			<p class="text-center" style="line-height:0px;">14/F UNIT 14-G BURGUNDY CORPORATE TOWER</p>
			<p class="text-center" style="line-height:0px;">Sen Gil Puyat Ave., San Lorenzo</p>
			<p class="text-center" style="line-height:0px;">Makati City Philippines</p>
			</div>
		</div>

	</div>
	<br/>
	<div class="col-12 col-lg-12">
		<div class="position row">
			<div class="col-3 col-lg-3 bor">Position :</div>
			<div class="col-9 col-lg-9 text-center bor">{{ ucwords(@$employee->positions->position) }} - {{ ucwords(@$employee->departments->department) }}</div>
		</div>
		<div class="name row">
			<div class="col-3 col-lg-3 bor">Name :</div>
			<div class="col-3 col-lg-3 bor"><span class="small">Last: </span> {{ ucwords(@$employee->last_name) }}</div>
			<div class="col-3 col-lg-3 bor"><span class="small">First: </span> {{ ucwords(@$employee->first_name) }}</div>
			<div class="col-3 col-lg-3 bor"><span class="small">Middle: </span> {{ ucwords(@$employee->middle_name) }}</div>
		</div>
		<div class="present row">
			<div class="col-3 col-lg-3 bor">Present Address :</div>
			<div class="col-9 col-lg-9 text-center bor">{{ ucwords(@$employee->present_address) }}</div>
		</div>	
		<div class="permanent row">
			<div class="col-3 col-lg-3 bor">Permanent Address :</div>
			<div class="col-9 col-lg-9 text-center bor">{{ ucwords(@$employee->permanent_address) }}</div>
		</div>		
		<div class="contact row">
			<div class="col-3 col-lg-3 bor">Contact No(s) :</div>
			<div class="col-9 col-lg-9 text-center bor">{{ "+63" . @$employee->contact }}</div>
		</div>		
    </div>
    <br/>
    <h4>EDUCATION:</h4>
	<div class="col-12 col-lg-12">
		<div class="h-title  row">
			<div class="col-4 col-lg-4 bor"></div>
			<div class="col-4 col-lg-4  text-center bor">Course / Name of School</div>
			<div class="col-4 col-lg-4  text-center bor">Year Graduated</div>
		</div>
		<div class="college  row">
			<div class="col-4 col-lg-4 bor">Tertiary/College</div>
			<div class="col-4 col-lg-4 bor text-center">{{ strtoupper(@$employee->course) }} / {{ strtoupper(@$employee->college) }}</div>
			<div class="col-4 col-lg-4 bor text-center">{{ ($employee->college_grad_date != null) ? Carbon\carbon::parse($employee->college_grad_date)->format("M d, Y") : @$employee->college_grad_date }}</div>
		</div>
		<div class="high  row">
			<div class="col-4 col-lg-4 bor">Secondary/High School</div>
			<div class="col-4 col-lg-4 bor text-center">{{ strtoupper(@$employee->highschool) }}</div>
			<div class="col-4 col-lg-4 bor text-center">{{ @$employee->highschool_grad_date->format("M d, Y") }}</div>
		</div>
		<div class="elem  row">
			<div class="col-4 col-lg-4 bor">Primary/Elementary</div>
			<div class="col-4 col-lg-4 bor text-center">{{ strtoupper(@$employee->elementary) }}</div>
			<div class="col-4 col-lg-4 bor text-center">{{ @$employee->elementary_grad_date->format("M d, Y") }}</div>
		</div>
    </div>
    <br/>    
    <h4>WORK EXPERIENCE(s):</h4>
	<div class="col-12 col-lg-12">
	  
	  	<div class="notif-head row">
	  		<div class="col-4 col-lg-4 text-center bor">Name of Company</div>
			<div class="col-4 col-lg-4 text-center bor">Position</div>
			<div class="col-4 col-lg-4 text-center bor">Period Covered</div>
	  	</div>
		@php
			$arr = unserialize(@$employee->experience);
			if (!empty(@$arr)) {
				$count = count(@$arr);
			}
				if (!empty(@$arr)){
					foreach (@$arr as $exp){
		@endphp
			@if ($exp[0] != null && $exp[1] != null && $exp[2] != null && $exp[3] != null)
	  	<div class="notif-body row">
	  		<div class="col-4 col-lg-4 text-center bor">{{ ucwords($exp[0]) }}</div>
			<div class="col-4 col-lg-4 text-center bor">{{ ucwords($exp[1]) }}</div>
			<div class="col-4 col-lg-4 text-center bor">{{ Carbon\carbon::parse($exp[2])->format('M d, Y') . " " . " to " . " " . Carbon\carbon::parse($exp[3])->format('M d, Y') }}</div>
	  	</div>
		@else
		<div class="notif-body row">
			<div class="col-4 col-lg-4 text-center bor">None</div>
			<div class="col-4 col-lg-4 text-center bor">None</div>
			<div class="col-4 col-lg-4 text-center bor">None</div>
		</div>
		@endif
			
			@php
			}
		}
	@endphp
	


	</div>
	<br/>    
    <h4>PERSONAL DATA:</h4>
    <div class="col-12 col-lg-12">
		<div class="b-info row">
			<div class="col-3 col-lg-3 bor">Birthday: </div>
			<div class="col-3 col-lg-3 bor">{{ @$employee->birthday->format('M d, Y') }}</div>
			<div class="col-3 col-lg-3 bor">Birthplace: </div>
			<div class="col-3 col-lg-3 bor">{{ ucwords(@$employee->birth_place) }}</div>
		</div>
		<div class="s-a row">
			<div class="col-3 col-lg-3 bor">Sex: </div>
			<div class="col-3 col-lg-3 bor">{{ (@$employee->gender == 0) ? "Male" : "Female" }}</div>
			<div class="col-3 col-lg-3 bor">Age: </div>
			<div class="col-3 col-lg-3 bor">{{ @$employee->age }}</div>
		</div>
		<div class="s-c row">
			<div class="col-3 col-lg-3 bor">Status: </div>
			<div class="col-3 col-lg-3 bor">{{ ucwords(@$employee->civil_status) }}</div>
			<div class="col-3 col-lg-3 bor">Citizenship: </div>
			<div class="col-3 col-lg-3 bor">{{ ucwords(@$employee->citizenship) }}</div>
		</div>
		<div class="h-w row">
			<div class="col-3 col-lg-3 bor">Height: </div>
			<div class="col-3 col-lg-3 bor">{{ @$employee->height }}</div>
			<div class="col-3 col-lg-3 bor">Weight: </div>
			<div class="col-3 col-lg-3 bor">{{ @$employee->weight }} kg.</div>
		</div>
		<div class="reg row">
			<div class="col-3 col-lg-3 bor">Religion: </div>
			<div class="col-3 col-lg-3 bor">{{ ucwords(@$employee->religion) }}</div>
			<div class="col-3 col-lg-3 bor"></div>
			<div class="col-3 col-lg-3 bor"></div>
		</div>
		<div class="f-info row">
			<div class="col-3 col-lg-3 bor">Father Name: </div>
			<div class="col-3 col-lg-3 bor">{{ ucwords(@$employee->father_name) }}</div>
			<div class="col-3 col-lg-3 bor">Birthday: </div>
			<div class="col-3 col-lg-3 bor">{{ ucwords(@$employee->father_birthday->format('M d, Y')) }}</div>
		</div>
		<div class="m-info row">
			<div class="col-3 col-lg-3 bor">Mother Name: </div>
			<div class="col-3 col-lg-3 bor">{{ ucwords(@$employee->mother_name) }}</div>
			<div class="col-3 col-lg-3 bor">Birthday: </div>
			<div class="col-3 col-lg-3 bor">{{ ucwords(@$employee->mother_birthday->format('M d, Y')) }}</div>
		</div>
		<div class="s-info row">
			<div class="col-3 col-lg-3 bor">Spouse Name: </div>
			<div class="col-3 col-lg-3 bor">{{ ( !empty(@$employee->spouse_name) ) ? ucwords(@$employee->spouse_name) : "None" }}</div>
			<div class="col-3 col-lg-3 bor">Date of Marriage: </div>
			<div class="col-3 col-lg-3 bor">{{ ( !empty(@$employee->spouse_name) ) ? Carbon\carbon::parse(@$employee->date_of_marriage)->format('M d, Y') : "None" }}</div>
		</div>
		<div class="c-info row">
		@php
			$arr = unserialize(@$employee->children);
			if (!empty($arr)) {
				$count = count(@$arr);
				 for($child = 0; $child < 3; $child++){	
				@endphp
					<div class="col-3 col-lg-3 bor">Children's Name: </div>
					<div class="col-3 col-lg-3 bor">None</div>
					<div class="col-3 col-lg-3 bor">Birthday/Gender: </div>
					<div class="col-3 col-lg-3 bor">None</div>
				@php
				}
			}else{ 
				echo 'meron';
				if (!empty(@$arr)){
				@endphp
				@php
						foreach (@$arr as $children){
							if (!empty($children[0])) {
				@endphp	
						<div class="col-3 col-lg-3 bor">Children's Name: </div>
						<div class="col-3 col-lg-3 bor">{{ ucfirst($children[0]) }}</div>
						<div class="col-3 col-lg-3 bor">Birthday/Gender: </div>
						<div class="col-3 col-lg-3 bor">{{ Carbon\carbon::parse($children[1])->format('M d, Y') }} / {{ ucfirst($children[2]) }}</div>
						@php
						}
					}
				}
				@endphp
			@php 
			}
			@endphp
		</div>
    </div>
    <br/>
    <h4>NOTIFY IN CASE OF EMERGENCY: </h4>
	<div class="col-12 col-lg-12">
	  	<div class="notif-head row">
	  		<div class="col-4 col-lg-4 text-center bor">Name</div>
			<div class="col-4 col-lg-4 text-center bor">Address</div>
			<div class="col-4 col-lg-4 text-center bor">Contact No: </div>
	  	</div>
  	  	<div class="notif-body row">
  	  		<div class="col-4 col-lg-4 text-center bor">{{ ucwords($employee->person_to_contact) }}</div>
  			<div class="col-4 col-lg-4 text-center bor">{{ ucwords($employee->person_to_contact_address) }}</div>
  			<div class="col-4 col-lg-4 text-center bor">{{ ucwords($employee->person_to_contact_number) }}</div>
  	  	</div>
	</div>
	<br/>
    <h4>Others: </h4>
	<div class="col-12 col-lg-12">
		<div class="number-id row">
			<div class="col-3 col-lg-3 bor">Tin No: </div>
			<div class="col-3 col-lg-3 bor">{{ @$employee->tin_no }}</div>
			<div class="col-3 col-lg-3 bor">SSS No: </div>
			<div class="col-3 col-lg-3 bor">{{ @$employee->sss_no }}</div>
		</div>
		<div class="number-id row">
			<div class="col-3 col-lg-3 bor">Philheath No: </div>
			<div class="col-3 col-lg-3 bor">{{ @$employee->philhealth_no }}</div>
			<div class="col-3 col-lg-3 bor">HDMF No: </div>
			<div class="col-3 col-lg-3 bor">{{ @$employee->hdmf_no }}</div>
		</div>
	</div>
	
<div class="cert" style="width: 35%;">
	<p style="margin-top: 50px;">Certified True and Correct By: </p>
	<br/>
	<p style="border-top: #6c757d solid 1px;" class="text-center">(Signature over Printed Name)</p>
	<br/>
	<p style="border-bottom: #6c757d solid 1px;">Date:</p>
</div>

</body>

</html>