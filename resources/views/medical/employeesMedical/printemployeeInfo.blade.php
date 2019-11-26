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
<div class="card mb-3">
	<div class="card-body">
		<div class="row">
			<div class="col-3">
				@if (@$employee->profile_img != null)
					<div class="employee_wrap mb-0">
						<div class="panel employee-photo rounded">
							<img src="{{ asset('storage/uploaded/'.@$employee->profile_img) }}" alt="{{ @$employee->profile_img }}" class="img-fluid rounded" onerror="javascript:this.src='{{ asset('/images/default.png' )}}'" >
						</div>
					</div>
				@endif
			</div>
			<div class="col-9">
				<div class="row mb-3">
					<div class="col-6">
						<p class="med-name">{{ ucwords($employee->last_name . " " . $employee->first_name . " " . $employee->middle_name) }}</p>
					</div>
					<div class="col-6">

					</div>
				</div>
				<div class="row">
					<div class="col-3">
						<p class="mb-2"><span class="text-dark font-weight-bold">Department</span>: {{ strtoupper($employee->departments->department) }}</p>
						<p class="mb-2"><span class="text-dark font-weight-bold">Position</span>: {{ ucwords($employee->positions->position) }}</p>
					</div>
					<div class="col-3">
						<p class="mb-2"><span class="text-dark font-weight-bold">Gender</span>: {{ (@$employee->gender == 0) ? "Male" : "Female" }}</p>
						<p class="mb-2"><span class="text-dark font-weight-bold">Age</span>: {{ @$employee->age }}</p>
					</div>
					<div class="col-3">
						<p class="mb-2"><span class="text-dark font-weight-bold">Birthday</span>: {{ @$employee->birthday->format('M d, Y') }}</p>
						<p class="mb-2"><span class="text-dark font-weight-bold">Birth Place</span>: {{ ucwords(@$employee->birth_place) }}</p>
					</div>
					<div class="col-3">
						<p class="mb-2"><span class="text-dark font-weight-bold">Contact</span>: {{ "+63" . @$employee->contact }}</p>
					</div>
				</div>
			</div>
		</div>
		<br>
		<table class="table table-hover">
			<thead class="thead-dark">
				<th>No.</th>
				<th>Diagnosis</th>
				<th>Notes</th>
				<th>Date and Time</th>
				<th>Remarks</th>
			</thead>
			<tbody>
				@php
					$i = 1;
				@endphp
				@forelse ($printsearch as $medsHistory)
					<tr>
						<td>{{ $i++ }}</td>
						<td>{{ ucwords($medsHistory->diagnoses->diagnosis) }}
							<div class="row-actions"><a href="{{ route('medical.show', ['employee' => $employee->emp_id, 'employeesmedical' => $medsHistory->id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i> View</a></div>
						</td>
						<td>{{ Str::words($medsHistory->note, 15) }}</td>
						<td>{{ $medsHistory->created_at->format('M d, Y - h:i a') }}</td>
						<td>{{ ($medsHistory->remarks == 'followUp') ? 'Follow up' : 'Done' }}</td>
					</tr>
					@empty
						<tr>
							<td colspan="6" class="text-center">No Records Found!</td>
						</tr>
				@endforelse
			</tbody>
		</table>		
	</div>
</div>

</body>
</html>