@if (@$employees2 != NULL)
<div id="printable">
	<div class="text-center">	
		<img src="{{url( '/images/logo.png' )}}" alt="Zapport">
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-md-6 mb-4 mt-4">
				<h1 class="text-secondary" style="font-size: 22px;">Employees List</h1>
				<p class="text-secondary">
					@if (@$filter_gender != null)
						Filter by
						Gender:
						@if (@$filter_gender == 0)
							Male
						@else
							Female
						@endif
					@elseif (@$filter_empType != null)
						Filter by
						Employee Type:
						@if (@$filter_empType == 0)
							Probationary Employee
						@else
							Regular Employee
						@endif
					@elseif (@$filter_age != null)
						Filter by
						Age: {{ app('request')->input('filter_age') }}
					@elseif (@$filter_both != null)
						Filter by
						Gender and Employee Type: {{ ($filter_both['gender'] == 0) ? 'Male' : 'Female' }} | {{ ($filter_both['type'] == 0) ? 'Probationary Employee' : 'Regular Employee' }}
					@elseif (@$filter_g_a != null)
						Filter by
						Gender and Age: {{ ($filter_g_a['gender'] == 0) ? 'Male' : 'Female' }} | {{ $filter_g_a['age'] }}
					@elseif (@$filter_e_a != null)
						Filter by
						Employee Type and Age: {{ ($filter_e_a['type'] == 0) ? 'Probationary Employee' : 'Regular Employee' }} | {{ $filter_e_a['age'] }}
					@elseif (@$filter_all != null)
						Filter by
						Gender, Employee Type and Age: {{ ($filter_all['gender'] == 0) ? 'Male' : 'Female' }} | {{ ($filter_all['type'] == 0) ? 'Probationary Employee' : 'Regular Employee' }} | {{ $filter_all['age'] }}
					@endif
				</p>
			</div>		
		</div>
		<div class="table-responsive">
			<table id="prntEmpCount" class="table">
				<thead>
					<th>Employee Number</th>
					<th>Name</th>
					<th>Department - Position</th>
				</thead>
				<tbody>
					@forelse ($employees2 as $employee)
						@if (@$filter_age != NULL && @$employee->age == @$filter_age)
							<tr id="prntEmpRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_all != NULL && @$employee->age == @$filter_all['age'])
							<tr id="prntEmpRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_g_a != NULL && @$employee->age == @$filter_g_a['age'])
							<tr id="prntEmpRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_e_a != NULL && @$employee->age == @$filter_e_a['age'])
							<tr id="prntEmpRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_age == NULL && @$filter_all == NULL && @$filter_g_a == NULL && @$filter_e_a == NULL)
							<tr id="prntEmpRow">
								<td>{{ $employee->emp_id }}</td>
								<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@endif
						@empty
							<tr>
								<td colspan="4" class="text-center">{{ "No registered Employee yet!" }}</td>
							</tr>
					@endforelse
				</tbody>
			</table>	
		</div>
	</div>
	<div class="wrap text-right">
		<p id="prntEmpRslt">Total number of employees: </p>
		@if (Auth::user()->employee != null)
			<p>Printed by: <span>{{ Auth::user()->employee->first_name }} {{ Auth::user()->employee->last_name }} {{ Auth::user()->employee->middle_name }}</span></p>
		@endif
	</div>
</div>

<script type="application/javascript">

	jQuery(document).ready(function($){
		var countTR = $("#prntEmpCount tbody tr").length;
		$("#prntEmpRslt").append('<span class="font-weight-bold">'+ countTR +'</span>');
	});

</script>

@endif