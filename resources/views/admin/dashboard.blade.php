@extends('layouts.app')
@section('title', '| Dashboard')
@section('overview', 'active')
{{-- @section('dash-title', 'Dashboard Overview') --}}
@section('heading-title')
	<i class="fas fa-tachometer-alt text-secondary"></i> Dashboard
@endsection

@section('dash-content')

	<div class="row">
		@if ( Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse') || Gate::check('isHr') )
			<div class="col-12 col-md-2 col-lg-2">
				<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
				  @if (Gate::check('isAdmin') || Gate::check('isDoctor'))
				  	<a class="nav-link active" id="v-new-consultation-tab" data-toggle="pill" href="#v-new-consultation" role="tab" aria-controls="v-new-consultation" aria-selected="true">New Consultations</a>
				  @endif
				  @if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
				  	<a class="nav-link" id="v-follow-up-tab" data-toggle="pill" href="#v-follow-up" role="tab" aria-controls="v-follow-up" aria-selected="false">For Follow up</a>
				  	<a class="nav-link" id="v-inc-preEmp-tab" data-toggle="pill" href="#v-inc-preEmp" role="tab" aria-controls="v-inc-preEmp" aria-selected="false">Pre-employement Medical</a>
				  @endif
				  @if (Gate::check('isAdmin') || Gate::check('isHr'))
				  	<a class="nav-link" id="v-inc-requirements-tab" data-toggle="pill" href="#v-inc-requirements" role="tab" aria-controls="v-inc-requirements" aria-selected="false">Employees with incomplete requirements</a>
				  	<a class="nav-link" id="v-inc-emp-6months-tab" data-toggle="pill" href="#v-emp-6months" role="tab" aria-controls="v-emp-6months" aria-selected="false">Candidates for Regularization</a>
				  @endif
				</div>	
			</div>
			<div class="col-12 col-md-10 col-lg-10">
				<div class="tab-content" id="v-pills-tabContent">
					@if (Gate::check('isAdmin') || Gate::check('isDoctor'))
					  	<div class="tab-pane fade show active" id="v-new-consultation" role="tabpanel" aria-labelledby="v-new-consultation-tab">
						  	<div class="card">
						  		<div class="card-header"><strong>New Consultations</strong></div>
						  		<div class="card-body">
						  			<div class="table-responsive">
										<table id="newConsTable" class="table table-hover">
											<thead class="thead-dark">
												<th>No.</th>
												<th>Employee Name</th>
												<th>Date and Time</th>
												<th>Diagnosis</th>
												<th>Notes</th>
												<th>Remarks</th>
											</thead>
											<tbody>
												@forelse (@$notSeen as $seen)
													<tr id="newCons">
														<td>{{ $seen->employee->emp_id }}</td>
														<td>{{ ucwords($seen->employee->last_name) }} {{ ucwords($seen->employee->first_name) }} {{ ucwords($seen->employee->middle_name) }}
															<div class="row-actions">
																<a href="{{ route('medical.show', ['employee' => $seen->employee->emp_id, 'employeesmedical' => $seen->id]) }}" class="btn btn-link text-secondary"><i class="far fa-eye"></i> View</a>	
															</div>
														</td>
														<td>{{ $seen->created_at->format('M d, Y - h:i a') }}</td>
														<td>{{ ucwords($seen->diagnoses->diagnosis) }}</td>
														<td>{{ Str::words($seen->note, 10) }}</td>
														<td>{{ ($seen->remarks == 'followUp') ? 'Follow up' : 'Done' }}</td>
													</tr>
													@empty
														<tr>
															<td colspan="7" class="text-center">No New Record Found!</td>
														</tr>
												@endforelse
											</tbody>
										</table>					  				
						  			</div>
						  		</div>
						  	</div>
					  </div>
					@endif
					@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
						<div class="tab-pane fade" id="v-follow-up" role="tabpanel" aria-labelledby="v-follow-up-tab">
						  	<div class="card">
						  		<div class="card-header"><strong>For Follow up</strong></div>
						  		<div class="card-body">
						  			<div class="table-responsive">
										<table id="forFollowUp" class="table table-hover">
											<thead class="thead-dark">
												<th>No.</th>
												<th>Employee Name</th>
												<th>Date and Time</th>
												<th>Diagnosis</th>
												<th>Notes</th>
												<th>Remarks</th>
											</thead>
											<tbody>
												@forelse (@$empMeds as $empMed)
													<tr id="FFup">
														<td>{{ $empMed->employee->emp_id }}</td>
														<td>
															{{ ucwords($empMed->employee->last_name) }} {{ ucwords($empMed->employee->first_name) }} {{ ucwords($empMed->employee->middle_name) }}
															<div class="row-actions">
																<a href="{{ route('medical.show', ['employee' => $empMed->employee->emp_id, 'employeesmedical' => $empMed->id]) }}" class="btn btn-link text-secondary"><i class="far fa-eye"></i> View</a>
															</div>
														</td>
														<td>{{ $empMed->created_at->format('M d, Y - h:i a') }}</td>
														<td>{{ ucwords($empMed->diagnoses->diagnosis) }}</td>
														<td>{{ Str::words($empMed->note, 10) }}</td>
														<td>{{ ($empMed->remarks == 'followUp') ? 'Follow up' : 'Done' }}</td>
													</tr>
													@empty
														<tr>
															<td colspan="7" class="text-center">No Medical Records To Follow Up</td>
														</tr>
												@endforelse
											</tbody>
										</table>
						  			</div>
						  		</div>
						  	</div>
						</div>

						<div class="tab-pane fade" id="v-inc-preEmp" role="tabpanel" aria-labelledby="v-inc-preEmp-tab">
							<div class="card">
								<div class="card-header"><strong>Employees without Pre-employment medical</strong></div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="IncPreEmp" class="table table-hover">
											<thead class="thead-dark">
												<th width="13%">Employee Number</th>
												<th>Employee Name</th>
												<th width="20%">Department - Positon</th>
											</thead>
											@forelse (@$noPreEmpMeds as $emp)
												<tr id="incPre">
													<td>{{ $emp->emp_id }}</td>
													<td>{{ $emp->last_name }} {{ $emp->first_name }} {{ $emp->middle_name }}
														<div class="row-actions"><a href="{{ route('medical.employeeInfo', ['employee' => $emp->emp_id]) }}" class="btn btn-link text-secondary"><i class="far fa-eye"></i> View</a></div></td>
													<td>{{ $emp->departments->department }} - {{ $emp->positions->position }}</td>
												</tr>
												@empty
													<tr>
														<td colspan="4" class="text-center">Employees with no requirements not found!</td>
													</tr>
											@endforelse
										</table>
									</div>

								</div>
							</div>
						</div>
					@endif
					@if (Gate::check('isAdmin') || Gate::check('isHr'))
						<div class="tab-pane fade" id="v-inc-requirements" role="tabpanel" aria-labelledby="v-inc-requirements-tab">
							<div class="card">
								<div class="card-header"><strong>Employees with incomplete requirements</strong></div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="IncReq" class="table table-hover">
											<thead class="thead-dark">
												<th width="13%">Employee Number</th>
												<th>Employee Name</th>
												<th width="20%">Department - Positon</th>
											</thead>
											@forelse (@$emps as $emp)
												<tr id="inc">
													<td>{{ $emp->emp_id }}</td>
													<td>{{ $emp->last_name }} {{ $emp->first_name }} {{ $emp->middle_name }}
														<div class="row-actions"><a href="{{ route('hr.emp.show', ['employee' => $emp->emp_id]) }}" class="btn btn-link text-secondary"><i class="far fa-eye"></i> View</a></div></td>
													<td>{{ $emp->departments->department }} - {{ $emp->positions->position }}</td>
												</tr>
												@empty
													<tr>
														<td colspan="4" class="text-center">Employees with no requirements not found!</td>
													</tr>
											@endforelse
										</table>									
									</div>

								</div>
							</div>
						</div>

						<div class="tab-pane fade" id="v-emp-6months" role="tabpanel" aria-labelledby="v-inc-requirements-tab">
							<div class="card">
								<div class="card-header"><strong>Candidates for Regularization</strong></div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="CandReg" class="table table-hover">
											<thead class="thead-dark">
												<th width="13%">Employee Number</th>
												<th>Employee Name</th>
												<th width="20%">Department - Positon</th>
											</thead>
											@forelse (@$emps2 as $emp)
											@php
												$hired_month = $emp->hired_date->diff(Carbon\carbon::now())->format('%m');
												$hired_year = $emp->hired_date->diff(Carbon\carbon::now())->format('%y');
												$month = (int)$hired_month;
												$year = (int)$hired_year;
											@endphp
											@if ($month > 5 || $year >= 1)
												<tr id="forReg">
													<td>{{ $emp->emp_id }}</td>
													<td>{{ $emp->last_name }} {{ $emp->first_name }} {{ $emp->middle_name }}
														<div class="row-actions"><a href="{{ route('hr.emp.show', ['employee' => $emp->emp_id]) }}" class="btn btn-link text-secondary"><i class="far fa-eye"></i> View</a></div></td>
													<td>{{ $emp->departments->department }} - {{ $emp->positions->position }}</td>
												</tr>
											@endif
												@empty
													<tr>
														<td colspan="4" class="text-center">Employees with no requirements not found!</td>
													</tr>
											@endforelse
										</table>									
									</div>

								</div>
							</div>
						</div>

					@endif
				</div>
			</div>
		@else
			<div class="col-12">
				<div class="card">
					<div class="card-header"><strong>Medical Records</strong></div>
					<div class="card-body">
						@if (empty(auth()->user()->employee))
						<h2>Welcome!</h2>
						<a href="{{ route('employees') }}">Click here to activate your account.</a>
						@else
						@if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor') || Gate::check('isNurse'))
							{{-- Leave this empty --}}
						@else
							<form id="searchDiagnosis" method="get" autocomplete="off">
								<div class="form-row">
									<div class="form-group col-md-4 autocomplete">
										<input type="search" name="search" class="form-control" value="{{ (!empty($result)) ? $result : '' }}" placeholder="Search for Diagnosis">
										<div id="searchDiagnosis_list" class="autocomplete-items"></div>
									</div>
									<div class="form-group col-md-1 d-inline-flex">
										<button type="submit" class="btn btn-success mr-2">Search</button>
										<a href="{{ route('dashboard.main') }}" class="btn btn-info text-white">Clear</a>
									</div>
								</div>
							</form>

							<table class="table table-hover">
								<thead class="thead-dark">
									<th width="7%">No.</th>
									<th>Diagnosis</th>
									<th>Notes</th>
									<th width="10%">Remarks</th>
									<th width="15%">Date and Time</th>
								</thead>
								<tbody>
									@php
										$i = 1;
									@endphp
									@forelse ($search as $medsHistory)
										<tr>
											<td>{{ $i++ }}</td>
											<td>{{ $medsHistory->diagnoses->diagnosis }}
												<div class="row-actions"><a href="{{ route('dashboard.show', ['employee' => $medsHistory->employee->emp_id, 'employeesmedical' => $medsHistory->id]) }}" class="btn text-secondary"><i class="far fa-eye"></i> View
												</a></div></td>
											<td>{{ Str::words($medsHistory->note, 15) }}</td>
											<td>{{ ($medsHistory->remarks == 'followUp') ? 'Follow up' : 'Done' }}</td>
											<td>{{ $medsHistory->created_at->format('M d, Y - h:i a') }}</td>
										</tr>
										@empty
											<tr>
												<td colspan="6" class="text-center">No Records Found!</td>
											</tr>
									@endforelse
								</tbody>
							</table>
							{{ $search->links() }}
						@endif
					@endif
					</div>
				</div>
			</div>
		@endif
	</div>

<script type="application/javascript">
	// Search Diagnosis

    $("#searchDiagnosis input[name='search']").on('keyup', function(){
    	var query = $(this).val();
    	$.ajax({
    		url: "/medical/employees/diagnosis/"+query+"",
    		type: "GET",
    		data:{'diagnosis':query},
    		success:function(response){
    			$('#searchDiagnosis_list').html(response);
    		}
    	});
    });

	$(document).on('click', 'li', function(){
	    var value = $(this).text();
	    $("#searchDiagnosis input[name='search']").val(value);
	    $('#searchDiagnosis_list').html("");
	});

</script>

@endsection