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

</head>
<body>
<div id="printable">
	<div class="text-center">	
		<img src="{{url( '/images/logo.png' )}}" alt="Zapport" style="display: block; margin:auto; width: 200px">
		<div style="margin-top: 20px; margin-bottom: 20px;">
		<p class="text-center" style="line-height:0px;">14/F UNIT 14-G BURGUNDY CORPORATE TOWER</p>
		<p class="text-center" style="line-height:0px;">Sen Gil Puyat Ave., San Lorenzo</p>
		<p class="text-center" style="line-height:0px;">Makati City Philippines</p>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div style="margin-bottom: 20px;">
				<h1>Employees List</h1>
				<p class="text-secondary">
					@if(@$filter_age != null && @$filter_gender != null && @$filter_empType != null && @$filter_status != null )
						Filter by Gender, Employee Type, Age and Civil Status: {{ (@$filter_gender == 0) ? 'Male' : 'Female' }} | {{ (@$filter_empType == 0) ? 'Probationary Employee' : 'Regular Employee' }} | {{ app('request')->input('filter_age') }} | {{ ucwords(app('request')->input('filter_status')) }}
					@elseif(@$filter_age != null && @$filter_gender != null && @$filter_empType != null )
						Filter by Gender, Employee Type and Age: {{ (@$filter_gender == 0) ? 'Male' : 'Female' }} | {{ (@$filter_empType == 0) ? 'Probationary Employee' : 'Regular Employee' }} | {{ app('request')->input('filter_age') }}
					@elseif(@$filter_age != null && @$filter_gender != null && @$filter_status != null )
						Filter by Gender, Age and Civil Status: {{ (@$filter_gender == 0) ? 'Male' : 'Female' }} | {{ app('request')->input('filter_age') }} | {{ ucwords(app('request')->input('filter_status')) }}	
					@elseif(@$filter_age != null && @$filter_empType != null && @$filter_status != null )
						Filter by Employee Type, Age and Civil Status: {{ (@$filter_empType == 0) ? 'Probationary Employee' : 'Regular Employee' }} | {{ app('request')->input('filter_age') }} | {{ ucwords(app('request')->input('filter_status')) }}
					@elseif(@$filter_gender != null && @$filter_empType != null && @$filter_status != null )
						Filter by Gender, Employee Type and Civil Status: {{ (@$filter_gender == 0) ? 'Male' : 'Female' }} | {{ (@$filter_empType == 0) ? 'Probationary Employee' : 'Regular Employee' }} | {{ ucwords(app('request')->input('filter_status')) }}
					@elseif(@$filter_gender != null && @$filter_empType != null)
						Filter by Gender and Employee Type: {{ (@$filter_gender == 0) ? 'Male' : 'Female' }} | {{ (@$filter_empType == 0) ? 'Probationary Employee' : 'Regular Employee' }}
					@elseif(@$filter_gender != null && @$filter_status != null)
						Filter by Gender and Civil Status: {{ (@$filter_gender == 0) ? 'Male' : 'Female' }} | {{ ucwords(app('request')->input('filter_status')) }}
					@elseif(@$filter_age != null && @$filter_gender != null)
						Filter by Gender and Age: {{ (@$filter_gender == 0) ? 'Male' : 'Female' }} | {{ app('request')->input('filter_age') }}
					@elseif(@$filter_age != null && @$filter_empType != null)
						Filter by Employee Type and Age: {{ (@$filter_empType == 0) ? 'Probationary Employee' : 'Regular Employee' }} | {{ app('request')->input('filter_age') }}
					@elseif(@$filter_age != null && @$filter_status != null)
						Filter by Age and Civil Status: {{ app('request')->input('filter_age') }} || {{ ucwords(app('request')->input('filter_status')) }}
					@elseif(@$filter_age != null)
						Filter by Age: {{ app('request')->input('filter_age') }}
					@elseif(@$filter_gender != null)
						Filter by Gender: {{ (@$filter_gender == 0) ? 'Male' : 'Female' }}
					@elseif(@$filter_empType != null)
						Filter by Employee Type: {{ (@$filter_empType == 0) ? 'Probationary Employee' : 'Regular Employee' }}
					@elseif(@$filter_status != null)
						Filter by Civil Status: {{ ucwords(ucwords(app('request')->input('filter_status'))) }}
					@elseif(@$filter_search != null)
						Search Keyword : {{ $filter_search }}
					@else
						
					@endif
				</p>
			</div>		
		</div>
		@php
			$countemp = 0;
		@endphp
		<div class="table-responsive">
			<table id="prntEmpCount" class="table">
				<thead  style="text-align: center;">
					<th>Employee Number</th>
					<th>Name</th>
					<th>Department - Position</th>
				</thead>
				<tbody>
					@if($emplist != null)
						@forelse ($emplist as $employee)
						@if(@$filter_gender != null && @$filter_empType != null && @$filter_age != null && @$filter_age == @$employee->age && @$filter_status != null )
							<tr id="prntEmpRow">
								<td width="20%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
							@php 
								$countemp++;
							@endphp
						@elseif(@$filter_gender != null && @$filter_empType != null && @$filter_age != null && @$filter_age == @$employee->age)
							<tr id="prntEmpRow">
								<td width="20%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
							@php 
								$countemp++;
							@endphp	
						@elseif(@$filter_gender != null && @$filter_age != null && @$filter_age == @$employee->age && @$filter_status != null )
							<tr id="prntEmpRow">
								<td width="20%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
							@php 
								$countemp++;
							@endphp	
						@elseif(@$filter_empType != null && @$filter_age != null && @$filter_age == @$employee->age && @$filter_status != null )
							<tr id="prntEmpRow">
								<td width="20%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
							@php 
								$countemp++;
							@endphp	
						@elseif(@$filter_gender != null && @$filter_empType != null && @$filter_status != null  && @$filter_age !=null && @$filter_age == @$employee->age)
							<tr id="prntEmpRow">
								<td width="20%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
							@php 
								$countemp++;
							@endphp	
						@elseif(@$filter_gender != null && @$filter_empType != null && @$filter_age == null)
							<tr id="prntEmpRow">
								<td width="20%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
							@php 
								$countemp++;
							@endphp	
						@elseif(@$filter_gender != null && @$filter_status != null && @$filter_age == null && @$filter_age != @$employee->age)
							<tr id="prntEmpRow">
								<td width="20%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
							@php 
								$countemp++;
							@endphp	
						@elseif(@$filter_gender != null && @$filter_age != null && @$filter_age == null)
							<tr id="prntEmpRow">
								<td width="20%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
							@php 
								$countemp++;
							@endphp
						@elseif(@$filter_empType != null && @$filter_age != null && @$filter_age == @$employee->age )
							<tr id="prntEmpRow">
								<td width="20%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
							@php 
								$countemp++;
							@endphp	
						@elseif(@$filter_age != null && @$filter_age == null && @$filter_age != @$employee->age && @$filter_status != null)
							<tr id="prntEmpRow">
								<td width="20%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
							@php 
								$countemp++;
							@endphp	
						@elseif( @$filter_gender != null && @$filter_age == null && @$filter_age != @$employee->age)
							<tr id="prntEmpRow">
								<td width="20%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
							@php 
								$countemp++;
							@endphp
						@elseif( @$filter_empType != null && @$filter_age == null && @$filter_age != @$employee->age)
							<tr id="prntEmpRow">
								<td width="20%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
							@php 
								$countemp++;
							@endphp
						@elseif(@$filter_age != null && @$filter_age == @$employee->age)
							<tr id="prntEmpRow">
								<td width="20%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
							@php 
								$countemp++;
							@endphp		
						@elseif(@$filter_status != null && @$filter_age == null)
							<tr id="prntEmpRow">
								<td width="20%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
							@php 
								$countemp++;
							@endphp
						@elseif(@$filter_search != null && @$filter_age == null)
							<tr id="prntEmpRow">
								<td width="20%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
							@php 
								$countemp++;
							@endphp	
						@elseif(@$filter_gender == null && @$filter_empType == null && @$filter_age == null && @$filter_status == null )
							<tr id="prntEmpRow">
								<td width="20%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
							@php 
								$countemp++;
							@endphp
						@else
							
						@endif
						@empty
							<tr>
								<td colspan="3" class="text-center" style="padding: 8px; border-bottom: 1px solid #dee2e6;">{{ "No registered Employee yet!" }}</td>
							</tr>
						@endforelse
					@else
						<tr>
							<td colspan="3" class="text-center" style="padding: 8px; border-bottom: 1px solid #dee2e6;">{{ "No registered Employee yet!" }}</td>
						</tr>
					@endif
				</tbody>
			</table>	
		</div>
	</div>
	<div style="margin-top: 20px">
		<p id="prntEmpRslt" style="font-family: arial; font-size: 10px; color: #212529;">Total number of employees: {{ @$countemp }}</p>
		@if (Auth::user()->employee != null)
		<p style="font-family: arial; font-size: 10px; color: #212529; float: right; margin-top: 30px;">Printed by: <span>{{ Auth::user()->employee->first_name }} {{ Auth::user()->employee->last_name }} {{ Auth::user()->employee->middle_name }}</span></p>
		@endif
	</div>
</div>

</body>
</html>