@php
	$headtitle = "Employee List";
	$headrow = "Employee No.,Name,Department - Position"; 
	$countemp = 0;
@endphp
{{ $headtitle }}
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
@elseif(@$request->search != null)
Search Keyword : {{ $request->search }}
@else
@endif
{{ $headrow }}
@if($employees != null)
@forelse ($employees as $employee)
@if(@$filter_gender != null && @$filter_empType != null && @$filter_age != null && @$filter_age == @$employee->age && @$filter_status != null ){!! $employee->emp_id !!},{!! ucwords($employee->last_name) !!} {!! ucwords($employee->first_name) !!} {!! ucwords($employee->middle_name) !!},{!! ucwords($employee->departments->department) !!} - {!! ucwords($employee->positions->position) !!}
@php $countemp++; @endphp
@elseif(@$filter_gender != null && @$filter_empType != null && @$filter_age != null && @$filter_age == @$employee->age){!! $employee->emp_id !!},{!! ucwords($employee->last_name) !!} {!! ucwords($employee->first_name) !!} {!! ucwords($employee->middle_name) !!},{!! ucwords($employee->departments->department) !!} - {!! ucwords($employee->positions->position) !!}
@php $countemp++; @endphp
@elseif(@$filter_gender != null && @$filter_age != null && @$filter_age == @$employee->age && @$filter_status != null ){!! $employee->emp_id !!},{!! ucwords($employee->last_name) !!} {!! ucwords($employee->first_name) !!} {!! ucwords($employee->middle_name) !!},{!! ucwords($employee->departments->department) !!} - {!! ucwords($employee->positions->position) !!}
@php $countemp++; @endphp
@elseif(@$filter_empType != null && @$filter_age != null && @$filter_age == @$employee->age && @$filter_status != null ){!! $employee->emp_id !!},{!! ucwords($employee->last_name) !!} {!! ucwords($employee->first_name) !!} {!! ucwords($employee->middle_name) !!},{!! ucwords($employee->departments->department) !!} - {!! ucwords($employee->positions->position) !!}
@php $countemp++; @endphp
@elseif(@$filter_gender != null && @$filter_empType != null && @$filter_status != null  && @$filter_age !=null && @$filter_age == @$employee->age){!! $employee->emp_id !!},{!! ucwords($employee->last_name) !!} {!! ucwords($employee->first_name) !!} {!! ucwords($employee->middle_name) !!},{!! ucwords($employee->departments->department) !!} - {!! ucwords($employee->positions->position) !!}
@php $countemp++; @endphp
@elseif(@$filter_gender != null && @$filter_empType != null && @$filter_age == null){!! $employee->emp_id !!},{!! ucwords($employee->last_name) !!} {!! ucwords($employee->first_name) !!} {!! ucwords($employee->middle_name) !!},{!! ucwords($employee->departments->department) !!} - {!! ucwords($employee->positions->position) !!}
@php $countemp++; @endphp	
@elseif(@$filter_gender != null && @$filter_status != null && @$filter_age == null && @$filter_age != @$employee->age){!! $employee->emp_id !!},{!! ucwords($employee->last_name) !!} {!! ucwords($employee->first_name) !!} {!! ucwords($employee->middle_name) !!},{!! ucwords($employee->departments->department) !!} - {!! ucwords($employee->positions->position) !!}
@php $countemp++; @endphp
@elseif(@$filter_gender != null && @$filter_age != null && @$filter_age == null){!! $employee->emp_id !!},{!! ucwords($employee->last_name) !!} {!! ucwords($employee->first_name) !!} {!! ucwords($employee->middle_name) !!},{!! ucwords($employee->departments->department) !!} - {!! ucwords($employee->positions->position) !!}
@php $countemp++; @endphp
@elseif(@$filter_empType != null && @$filter_age != null && @$filter_age == @$employee->age ){!! $employee->emp_id !!},{!! ucwords($employee->last_name) !!} {!! ucwords($employee->first_name) !!} {!! ucwords($employee->middle_name) !!},{!! ucwords($employee->departments->department) !!} - {!! ucwords($employee->positions->position) !!}
@php $countemp++; @endphp
@elseif(@$filter_age != null && @$filter_age == null && @$filter_age != @$employee->age && @$filter_status != null){!! $employee->emp_id !!},{!! ucwords($employee->last_name) !!} {!! ucwords($employee->first_name) !!} {!! ucwords($employee->middle_name) !!},{!! ucwords($employee->departments->department) !!} - {!! ucwords($employee->positions->position) !!}
@php $countemp++; @endphp
@elseif( @$filter_gender != null && @$filter_age == null && @$filter_age != @$employee->age){!! $employee->emp_id !!},{!! ucwords($employee->last_name) !!} {!! ucwords($employee->first_name) !!} {!! ucwords($employee->middle_name) !!},{!! ucwords($employee->departments->department) !!} - {!! ucwords($employee->positions->position) !!}
@php $countemp++; @endphp
@elseif( @$filter_empType != null && @$filter_age == null && @$filter_age != @$employee->age){!! $employee->emp_id !!},{!! ucwords($employee->last_name) !!} {!! ucwords($employee->first_name) !!} {!! ucwords($employee->middle_name) !!},{!! ucwords($employee->departments->department) !!} - {!! ucwords($employee->positions->position) !!}
@php $countemp++; @endphp
@elseif(@$filter_age != null && @$filter_age == @$employee->age){!! $employee->emp_id !!},{!! ucwords($employee->last_name) !!} {!! ucwords($employee->first_name) !!} {!! ucwords($employee->middle_name) !!},{!! ucwords($employee->departments->department) !!} - {!! ucwords($employee->positions->position) !!}
@php $countemp++; @endphp	
@elseif(@$filter_status != null && @$filter_age == null){!! $employee->emp_id !!},{!! ucwords($employee->last_name) !!} {!! ucwords($employee->first_name) !!} {!! ucwords($employee->middle_name) !!},{!! ucwords($employee->departments->department) !!} - {!! ucwords($employee->positions->position) !!}
@php $countemp++; @endphp
@elseif(@$filter_search != null && @$filter_age == null){!! $employee->emp_id !!},{!! ucwords($employee->last_name) !!} {!! ucwords($employee->first_name) !!} {!! ucwords($employee->middle_name) !!},{!! ucwords($employee->departments->department) !!} - {!! ucwords($employee->positions->position) !!}
@php $countemp++; @endphp
@elseif(@$filter_gender == null && @$filter_empType == null && @$filter_age == null && @$filter_status == null ){!! $employee->emp_id !!},{!! ucwords($employee->last_name) !!} {!! ucwords($employee->first_name) !!} {!! ucwords($employee->middle_name) !!},{!! ucwords($employee->departments->department) !!} - {!! ucwords($employee->positions->position) !!}
@php $countemp++; @endphp
@endif
@empty
{{ "No registered Employee yet!" }}
@endforelse
@else
{{ "No registered Employee yet!" }}
@endif