
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-md-6 mb-4 mt-4">
				<h1 class="text-secondary" style="font-size: 22px;">Employees List</h1>
				<p class="text-secondary">
					@if ($filter_gender != null && $filter_empType != null && $filter_age != null)
					Filter by Gender, Employee Type and Age: {{ (@$filter_gender == 0) ? 'Male' : 'Female' }} | {{ (@$filter_empType == 0) ? 'Probationary Employee' : 'Regular Employee' }} | {{ app('request')->input('filter_age') }}
					@elseif ($filter_gender != null && $filter_empType != null )
					Filter by Gender and Employee Type: {{ (@$filter_gender == 0) ? 'Male' : 'Female' }} | {{ (@$filter_empType == 0) ? 'Probationary Employee' : 'Regular Employee' }}
					@elseif ($filter_gender != null && $filter_age != null)
					Filter by Gender and Age: {{ (@$filter_gender == 0) ? 'Male' : 'Female' }} | {{ app('request')->input('filter_age') }}
					@elseif ($filter_empType != null && $filter_age != null)
					Filter by Employee Type and Age: {{ (@$filter_empType == 0) ? 'Probationary Employee' : 'Regular Employee' }} | {{ app('request')->input('filter_age') }}
					@elseif (@$filter_gender != null)
						Filter by Gender: {{ (@$filter_gender == 0) ? 'Male' : 'Female' }}
					@elseif (@$filter_empType != null)
						Filter by Employee Type: {{ (@$filter_empType == 0) ? 'Probationary Employee' : 'Regular Employee' }}
					@elseif (@$filter_age != null)
						Filter by Age: {{ app('request')->input('filter_age') }}
					@endif
				</p>
			</div>		
		</div>
		<div class="table-responsive">
			<table class="table">
				<thead>
					<th>Employee Number</th>
					<th>Name</th>
					<th>Department - Position</th>
				</thead>
				<tbody>
					@forelse ($employees as $employee)
							<tr>
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@empty
							<tr>
								<td colspan="4" class="text-center">{{ "No registered Employee yet!" }}</td>
							</tr>
					@endforelse
				</tbody>
			</table>	
		</div>
	</div>
