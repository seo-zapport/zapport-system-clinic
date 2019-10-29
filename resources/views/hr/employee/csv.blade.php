@php
	$headtitle = "Employee List";
	$headrow = "Employee No.,Name,Department - Position"; 
@endphp
{{ $headtitle }}
@if (@$filter_gender != null && @$filter_empType != null && @$filter_age != null)
Filter by Gender, Employee Type and Age: {{ (@$filter_gender == 0) ? 'Male' : 'Female' }} | {{ (@$filter_empType == 0) ? 'Probationary Employee' : 'Regular Employee' }} | {{ app('request')->input('filter_age') }}
@elseif (@$filter_gender != null && @$filter_empType != null )
Filter by Gender and Employee Type: {{ (@$filter_gender == 0) ? 'Male' : 'Female' }} | {{ (@$filter_empType == 0) ? 'Probationary Employee' : 'Regular Employee' }}
@elseif (@$filter_gender != null && @$filter_age != null)
Filter by Gender and Age: {{ (@$filter_gender == 0) ? 'Male' : 'Female' }} | {{ app('request')->input('filter_age') }}
@elseif (@$filter_empType != null && @$filter_age != null)
Filter by Employee Type and Age: {{ (@$filter_empType == 0) ? 'Probationary Employee' : 'Regular Employee' }} | {{ app('request')->input('filter_age') }}
@elseif (@$filter_gender != null)
	Filter by Gender: {{ (@$filter_gender == 0) ? 'Male' : 'Female' }}
@elseif (@$filter_empType != null)
	Filter by Employee Type: {{ (@$filter_empType == 0) ? 'Probationary Employee' : 'Regular Employee' }}
@elseif (@$filter_age != null)
	Filter by Age: {{ app('request')->input('filter_age') }}
@endif
{{ $headrow }}
@if($employees != null)
@forelse ($employees as $employee)
{{ $employee->emp_id }},{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }},{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}
@empty
{{ "No registered Employee yet!" }}
@endforelse
@else
{{ "No registered Employee yet!" }}
@endif

