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
	<div class="card mb-5">
		<div class="card-body">
			<div class="row">
				<div class="col-2">
					@if (@$employee->profile_img != null)
						<div class="employee_wrap mb-0">
							<div class="panel employee-photo rounded">
								<img src="{{ asset('storage/uploaded/'.@$employee->profile_img) }}" alt="{{ @$employee->profile_img }}" class="img-fluid rounded">
							</div>
						</div>
					@endif
				</div>
				<div class="col-10">
					<div class="row mb-3">
						<div class="col-6">
							<p class="med-name">{{ ucwords($employee->last_name . " " . $employee->first_name . " " . $employee->middle_name) }}</p>
						</div>
						<div class="col-6">
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
			<hr>
			<div id="diagnosis">
				<div class="row my-3">
					<div class="col-12 col-md-8">
						<h2 class="text-secondary zp-text-22">Diagnosis: <span class="text-dark">{{ ucwords($employeesmedical->diagnoses->diagnosis) }}</span></h2>
					</div>
				</div>
				<ul class="nav nav-pills my-4 mx-0" id="pills-tab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Doctor's Note</a>
					</li>
					@if (count($employeesmedical->medicines) > 0)
						<li class="nav-item">
							<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Medicines</a>
						</li>
					@endif
					@if (count($employeesmedical->medNote) > 0)
						<li class="nav-item">
							<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Follow up checkup</a>
						</li>
					@endif
				</ul>
				<div class="tab-content" id="pills-tabContent">
					<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
						<div class="table-responsive">
							<table class="table">
								<thead class="thead-dark">
									<tr>
										<th width="38%">Doctor's Note</th>
										<th>Attachment</th>
										<th>Attendant</th>
										<th width="5%">Remarks</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td width="38%">{{ ucfirst($employeesmedical->note) }}</td>
										<td>
											@if ($employeesmedical->attachment != null)
												<a class="btn-dl" href="{{ route('download', ['file_name' => $employeesmedical->attachment]) }}" download>
													{{ $employeesmedical->attachment }}
												</a>
											@else
												<span class="text-muted">None</span>
											@endif
										</td>
										<td class="w-15">{{ ucwords($employeesmedical->user->employee->first_name) }} {{ ucwords($employeesmedical->user->employee->middle_name) }} {{ ucwords($employeesmedical->user->employee->last_name) }}</td>
										<td width="5%" class="w-15">{{ ($employeesmedical->remarks == 'followUp') ? 'Follow up' : 'Done' }}</td>
										<td class="text-muted w-15">{{ $employeesmedical->created_at->format('M d, Y - h:i a') }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
						<div class="table-responsive">
							<table class="table">
								<thead class="thead-dark">
									<tr>
										<th>Generic Name</th>
										<th>Brand Name</th>
										<th class="text-center">Quantity</th>
										<th>Given by</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($empMeds as $meds)
										<tr>
											<td><span class="text-dark">{{ ucwords($meds->generic->gname) }}</span></td>
											<td><span class="text-dark">{{ ucwords($meds->medBrand->bname) }}</span></td>
											<td class="w-10 text-center"><span class="text-dark">{{ $meds->pivot->quantity }}</span></td>
											<td class="text-muted w-15">
												@foreach ($meds->users as $att)
												<span class="text-dark">{{  ucwords($att->employee->first_name) }} {{ ucwords($att->employee->middle_name) }} {{ ucwords($att->employee->last_name) }}</span>
												@endforeach
											</td>
											<td class="text-muted w-15"><span class="text-dark">{{ $meds->pivot->created_at->format('M d, Y - h:i a') }}</span></td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					@if (count($employeesmedical->medNote) > 0)
						<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-lsabelledby="pills-contact-tab">
							<div class="table-responsive">
								<table class="table">
									<thead class="thead-dark">
										<tr>
											<th>Findings</th>
											<th>Attachment</th>
											<th>Date</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($employeesmedical->medNote as $followups)
											<tr>
												<td>{{ ucfirst($followups->followup_note) }}</td>
												<td>
													@if ($followups->attachment != null)
														<a class="btn-dl" href="{{ route('download', ['file_name' => $followups->attachment]) }}" download>{{ $followups->attachment }}</a>
													@else
														<span class="text-muted">None</span>
													@endif
												</td>
												<td  class="text-muted w-15">{{ $followups->created_at->format('M d, Y - h:i a') }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection