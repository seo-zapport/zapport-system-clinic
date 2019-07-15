@extends('layouts.app')
@section('title', 'Add Department')
@section('employee', 'active')
@section('dash-title', 'Your Personal Information')
@section('dash-content')

<img src="{{ asset('storage/uploaded/'.@$employee->profile_img) }}" alt="{{ @$employee->profile_img }}" class="img-fluid">
<p>Employee ID: {{ ucwords(@$employee->emp_id) }}</p>
<p>Department: {{ ucwords(@$employee->departments->department) }}</p>
<p>Position: {{ ucwords(@$employee->positions->position) }}</p>
<p>Name: {{ ucwords(@$employee->last_name) . " " . ucwords(@$employee->first_name) . " " .ucwords(@$employee->middle_name) }}</p>
<p>Address: {{ @$employee->address }}</p>
<p>Age: {{ @$employee->age }}</p>
<p>Birthday: {{ @$employee->birthday->format('M d, Y') }}</p>
<p>Birth Place: {{ ucwords(@$employee->birth_place) }}</p>
<p>Nationality: {{ ucwords(@$employee->nationality) }}</p>
<p>Civil Status: {{ ucwords(@$employee->civil_status) }}</p>
<p>Gender: {{ (@$employee->gender == 0) ? "Male" : "Female" }}</p>
<p>Contact: {{ "+63" . @$employee->contact }}</p>
<p>Hired date: {{ @$employee->created_at->format('M d, Y') . " " ."( ".@$employee->created_at->diffForHumans()." )" }}</p>

@endsection