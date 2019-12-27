@extends('layouts.app')
@section('title', '| '.ucwords($employee->last_name) . '\'s information')
@section('employeesMedical', 'active')
@section('dash-title', ucwords($employee->last_name) . '\'s information')
@section('dash-content')
	@section('back')
		<a href="{{ route('dashboard.main') }}">
			<i class="fas fa-arrow-left"></i>
		</a>
	@endsection
	<div class="card mb-3">
		<div class="card-body">
			<div class="row">
				<div class="col-12 col-md-4 col-lg-2">
					@if (@$employee->profile_img != null)
						<div class="employee_wrap mb-0">
							<div class="panel employee-photo rounded">
								<img src="{{ asset('storage/uploaded/'.@$employee->profile_img) }}" alt="{{ @$employee->profile_img }}" class="img-fluid rounded" onerror="javascript:this.src='{{url( '/images/default.png' )}}'">
							</div>
						</div>
					@endif
				</div>
				<div class="col-12 col-md-8 col-lg-10">
					<div class="row mb-3">
						<div class="col-12 col-md-6">
							<p class="med-name">{{ ucwords($employee->last_name . " " . $employee->first_name . " " . $employee->middle_name) }}</p>
						</div>
						<div class="col-12 col-md-6">
							@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
								<div class="form-group">
									@if ($employeesmedical->remarks == 'followUp')
										<button class="btn btn-success text-white" data-toggle="modal" data-target="#exampleModalCenter">Add Notes</button>
									@endif
									<button class="btn btn-info text-white" data-toggle="modal" data-target="#exampleModalCenter2">Edit Remarks</button>
								</div>
							@endif
						</div>
					</div>
					<div class="row">
						<div class="col-12 col-md-4 col-lg-3">
							<p class="mb-2"><span class="text-dark font-weight-bold">Department</span>: {{ strtoupper($employee->departments->department) }}</p>
							<p class="mb-2"><span class="text-dark font-weight-bold">Position</span>: {{ ucwords($employee->positions->position) }}</p>
						</div>
						<div class="col-12 col-md-4 col-lg-3">
							<p class="mb-2"><span class="text-dark font-weight-bold">Gender</span>: {{ (@$employee->gender == 0) ? "Male" : "Female" }}</p>
							<p class="mb-2"><span class="text-dark font-weight-bold">Age</span>: {{ @$employee->age }}</p>
						</div>
						<div class="col-12 col-md-4 col-lg-3">
							<p class="mb-2"><span class="text-dark font-weight-bold">Birthday</span>: {{ @$employee->birthday->format('M d, Y') }}</p>
							<p class="mb-2"><span class="text-dark font-weight-bold">Birth Place</span>: {{ ucwords(@$employee->birth_place) }}</p>
						</div>
						<div class="col-12 col-md-4 col-lg-3">
							<p class="mb-2"><span class="text-dark font-weight-bold">Contact</span>: {{ "+63" . @$employee->contact }}</p>
						</div>
					</div>
				</div>
			</div>
			<hr>
			<div id="diagnosis" class="zpr-row">
				<div class="container-fluid m-auto px-0 py-3">
					<div class="row">
						<div id="sideInfo" class="col-12 col-md-4 col-lg-2 mb-3">
							<div id="sideList" class="list-group m-auto">
								<h2 class="text-secondary zp-text-14 list-group-item">Medical Number: <span class="text-dark">{{ $employeesmedical->med_num }}</span></h2>
								<h2 class="text-secondary zp-text-14 list-group-item">Body Part: <span class="text-dark">{{ ucwords($employeesmedical->diagnoses->diseases->bodypart->bodypart) }}</span></h2>
								<h2 class="text-secondary zp-text-14 list-group-item">Disease: <span class="text-dark">{{ ucwords($employeesmedical->diagnoses->diseases->disease) }}</span></h2>
								<h2 class="text-secondary zp-text-14 list-group-item">Diagnosis: <span class="text-dark">{{ ucwords($employeesmedical->diagnoses->diagnosis) }}</span></h2>
							</div>
						</div>
						<div id="DiagInfo" class="col-12 col-md-8 col-lg-10">
							<div class="form-group form-row">
								<div class="col-12 col-md-6">
									<p class="mb-0"><strong>Remarks:</strong> {{ ($employeesmedical->remarks == 'followUp') ? 'Follow up' : 'Done' }}</p>
								</div>
								<div class="col-12 col-md-6">
									<p class="mb-0 text-right zpwm-text-left"><strong>Date:</strong> {{ $employeesmedical->created_at->format('M d, Y - h:i a') }}</p>
								</div>
							</div>
							<div class="form-group">
								<p><strong>Attachment:</strong>
									@if ($employeesmedical->attachment != null)
										<a class="btn-dl" href="{{ route('download', ['file_name' => $employeesmedical->attachment]) }}" download>
											{{ $employeesmedical->attachment }}
										</a>
									@else
										<span class="text-muted">None</span>
									@endif
								</p>
							</div>
							<div class="form-group">
								<p><strong>Notes:</strong></p>
								<div class="doctors-note form-control">
									{{ ucfirst($employeesmedical->note) }}
								</div>
							</div>
							@if (count($employeesmedical->medNote) > 0)
								<div class="form-group">
									<p><strong>List of Followup Checkups</strong></p>
								</div>
								<div class="accordion med-list-findings mb-3" id="findings">
									@php
											$i = 1;
									@endphp
									@foreach ($employeesmedical->medNote as $followups)
										<div class="card">
											<div class="card-header" id="heading_{{ $followups->id }}">
												<h2 class="mb-0">
													<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse_{{ $followups->id }}" aria-expanded="true" aria-controls="collapse_{{ $followups->id }}">
														Followup Checkup {{ $i++ }}
													</button>
												</h2>
											</div>

											<div id="collapse_{{ $followups->id }}" class="collapse" aria-labelledby="heading_{{ $followups->id }}" data-parent="#findings">
												<div class="card-body">
													<small>{{ $followups->created_at->format('M d, Y - h:i a') }}</small>
													<p class="form-group"><strong>Attachments : </strong> 
													@if ($followups->attachment != null)
														<a class="btn-dl" href="{{ route('download', ['file_name' => $followups->attachment]) }}" download>{{ $followups->attachment }}</a>
													@else
														<span class="text-muted">None</span>
													@endif</p>
													<div class="form-group">
														<p><strong>Notes : </strong></p>
														<div class="doctors-note form-control">
																{{ ucfirst($followups->followup_note) }}
														</div>
													</div>
												</div>
											</div>
										</div>
									@endforeach
								</div>
							@endif
							@if (count($employeesmedical->medicines))
								<div class="form-group">
									<p><strong>Medicine</strong></p>
								</div>
							@endif
							<div class="form-group form-row">
								@foreach ($empMeds as $meds)
									<div class="col-12 col-md-6 col-lg-3">
										<div class="med-wrap ">
											<div class="med-head med-info">
												<i class="fas fa-tablets"></i>
												<div class="med-info">
													<h2 class="brand">{{ ucwords($meds->medBrand->bname) }}</h2>
													<h3 class="generic">{{ ucwords($meds->generic->gname) }}</h3>
													<div class="quantity">
														<span id="quantity-text">QTY</span>
														<span id="quantity-num">{{ $meds->pivot->quantity }}</span>
													</div>
												</div>
											</div>
											<div class="med-body">
												<p class="mb-0"><strong>Given by : </strong>
													@foreach ($meds->users as $att)
													{{  ucwords($att->employee->first_name) }} {{ ucwords($att->employee->middle_name) }} {{ ucwords($att->employee->last_name) }}
													@endforeach
											</p>
												<p class="mb-0"><strong>Date : </strong>{{ $meds->pivot->created_at->format('M d, Y - h:i a') }}</p>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div> 
			</div>
		</div>
	</div>
@endsection