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
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-12">
				<p class="mb-2"><span class="text-dark font-weight-bold">Name</span>: {{ ucwords($employee->last_name . ", " . $employee->first_name . " " . $employee->middle_name) }} </p> 
			</div>
			<div class="col-12 col-md-12">
				<p class="mb-2"><span class="text-dark font-weight-bold">Department - Position</span>: {{ strtoupper($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</p>
			</div>
		</div>
		<div class="row">
			<div style="border-bottom: 1px solid black; margin-bottom: 5px;"></div>
			<div class="col-12 col-md-12">
					<p class="mb-2"><span class="text-dark font-weight-bold">Diagnosis</span>: {{ ucwords($employeesmedical->diagnoses->diagnosis) }}</p>
			</div>
		</div>
		<div class="row">
			<div class="col-8 col-md-8">
				<p><span class="text-dark font-weight-bold">Note's</span></p>
				<p>{{ ucfirst($employeesmedical->note) }}</p>
			</div>
			<div class="col-4 col-md-4">
				<p><span class="text-dark font-weight-bold">Date:</span> {{ $employeesmedical->created_at->format('M d, Y - h:i a') }}</p>
			</div>
			<div class="col-12 col-md-12">
				<div class="table-responsive" style="width: 50% !important; margin: 0px 35px; float: left;">
					<table class="table">
						<thead >
							<tr>
								<th>Medicine</th>
								<th class="text-center">Quantity</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($empMeds as $meds)

							  @if($meds->pivot->created_at->format('M d, Y - h:i a') == $employeesmedical->created_at->format('M d, Y - h:i a'))
								<tr>
									<td><span class="text-dark">{{ ucwords($meds->generic->gname) }} - {{ ucwords($meds->medBrand->bname) }}</span></td>
									<td class="w-10 text-center"><span class="text-dark">{{ $meds->pivot->quantity }}</span></td>
								</tr>
							  @endif
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			@if (count($employeesmedical->medNote) > 0)
					<div class="col-12 col-md-12">
						<span class="text-dark font-weight-bold">Follow Up Checkup</span> :
					</div> 	
					@foreach ($employeesmedical->medNote as $followups)
						<div class="col-1 col-md-1"></div>
						<div class="col-7 col-md-7">
							<p>@php if($loop->first){ @endphp <span class="text-dark font-weight-bold">Note's: </span> @php } @endphp</p> 
							<p> {{ ucfirst($followups->followup_note) }}</p>
							<div class="table-responsive" style="margin: 0px 35px; float: left;">
								<table class="table">
									<thead >
										<tr>
											<th>Medicine</th>
											<th class="text-center">Quantity</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($empMeds as $meds)
										 @if($followups->created_at->format('M d, Y - h:i a') == $meds->pivot->created_at->format('M d, Y - h:i a'))
											<tr>
												<td><span class="text-dark">{{ ucwords($meds->generic->gname) }} - {{ ucwords($meds->medBrand->bname) }}</span></td>
												<td class="w-10 text-center"><span class="text-dark">{{ $meds->pivot->quantity }}</span></td>
											</tr>
										 @endif	
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-4 col-md-4">
							<p><span class="text-dark font-weight-bold">Date: </span>{{ $followups->created_at->format('M d, Y - h:i a') }}</p>
						</div>
					@endforeach
			@endif
		</div>
	</div>
	
</div>

</body>
</html>