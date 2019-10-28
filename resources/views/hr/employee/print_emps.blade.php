@if (@$employees2 != NULL)
<div id="printable">
	<div class="text-center">	
		<img src="{{url( '/images/logo.png' )}}" alt="Zapport" style="display: block; margin:auto; width: 200px">
	</div>
	<div class="container-fluid">
		<div class="row">
			<div style="margin-bottom: 20px;">
				<h1 class="text-secondary" style="font-size: 16px; font-family: arial; color: #212529;">Employees List</h1>
				<p class="text-secondary" style="font-size: 10px; color: #212529; font-family: arial;">
					@if (@$filter_gender != null)
						Filtered by
						Gender:
						@if (@$filter_gender == 0)
							Male
						@else
							Female
						@endif
					@elseif (@$filter_empType != null)
						Filtered by
						Employee Type:
						@if (@$filter_empType == 0)
							Probationary Employee
						@else
							Regular Employee
						@endif
					@elseif (@$filter_status != null)
						Filtered by
						Civil Status:
						{{ ucfirst(@$filter_status) }}
					@elseif (@$filter_g_s != null)
						Filtered by
						Gender and Civil Status:
						@if (@$filter_g_s['gender'] == 0)
							Male
						@else
							Female
						@endif
						| {{ ucfirst(@$filter_g_s['status']) }}
					@elseif (@$filter_t_s != null)
						Filtered by
						Employee Type and Civil Status:
						@if (@$filter_t_s['type'] == 0)
							Probationary Employee
						@else
							Regular Employee
						@endif
						| {{ ucfirst(@$filter_t_s['status']) }}
					@elseif (@$filter_s_a != null)
						Filtered by
						Age and Civil Status:
						{{ @$filter_s_a['age'] }}
						| {{ ucfirst(@$filter_s_a['status']) }}
					@elseif (@$filter_g_t_s != null)
						Filtered by
						Gender, Employee Type and Civil Status:
						@if (@$filter_g_t_s['gender'] ==0)
							Male
						@else 
							Female
						@endif
						@if (@$filter_g_t_s['type'] == 0)
							| Probationary Employee
						@else
							| Regular Employee
						@endif
						| {{ ucfirst(@$filter_g_t_s['status']) }}
					@elseif (@$filter_t_a_s != null)
						Filtered by
						Employee Type, Age and Civil Status:
						@if (@$filter_t_a_s['type'] == 0)
							| Probationary Employee
						@else
							| Regular Employee
						@endif
						| {{ @$filter_t_a_s['age'] }}
						| {{ ucfirst(@$filter_t_a_s['status']) }}
					@elseif (@$filter_g_a_s != null)
						Filtered by
						Gender, Age and Civil Status:
						@if (@$filter_g_a_s['gender'] == 0)
							Male
						@else
							Female
						@endif
						| {{ @$filter_g_a_s['age'] }}
						| {{ @$filter_g_a_s['status'] }}
					@elseif (@$filter_age != null)
						Filtered by
						Age: {{ app('request')->input('filter_age') }}
					@elseif (@$filter_both != null)
						Filtered by
						Gender and Employee Type: {{ ($filter_both['gender'] == 0) ? 'Male' : 'Female' }} | {{ ($filter_both['type'] == 0) ? 'Probationary Employee' : 'Regular Employee' }}
					@elseif (@$filter_g_a != null)
						Filtered by
						Gender and Age: {{ ($filter_g_a['gender'] == 0) ? 'Male' : 'Female' }} | {{ $filter_g_a['age'] }}
					@elseif (@$filter_e_a != null)
						Filtered by
						Employee Type and Age: {{ ($filter_e_a['type'] == 0) ? 'Probationary Employee' : 'Regular Employee' }} | {{ $filter_e_a['age'] }}
					@elseif (@$filter_all != null)
						Filtered by
						Gender, Employee Type and Age: {{ ($filter_all['gender'] == 0) ? 'Male' : 'Female' }} | {{ ($filter_all['type'] == 0) ? 'Probationary Employee' : 'Regular Employee' }} | {{ $filter_all['age'] }}
					@elseif (@$filter_super != null)
						Filtered by
						Gender, Employee Type, Age and Civil Status:
						@if (@$filter_super['gender'] == 0)
							Male
						@else
							Female
						@endif
						@if (@$filter_super['type'] == 0)
							| Probationary Employee
						@else
							| Regular Employee
						@endif
						| {{ @$filter_super['age'] }}
						| {{ ucfirst(@$filter_super['status']) }}
					@endif
				</p>
			</div>		
		</div>
		<div class="table-responsive">
			<table id="prntEmpCount" class="table" style="border-collapse: collapse; border-spacing: 0; width: 100%; border-bottom: 1px solid #dee2e6; border-top: 1px solid #dee2e6;">
				<thead>
					<th  style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center; font-size: 13px; font-family: arial; color: #212529;">Employee Number</th>
					<th style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center; font-size: 13px; font-family: arial; color: #212529;">Name</th>
					<th style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; text-align: center; font-size: 13px; font-family: arial; color: #212529;">Department - Position</th>
				</thead>
				<tbody>
					@forelse ($employees2 as $employee)
						@if (@$filter_age != NULL && @$employee->age == @$filter_age)
							<tr id="prntEmpRow">
								<td width="20%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_all != NULL && @$employee->age == @$filter_all['age'])
							<tr id="prntEmpRow">
								<td width="20%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_g_a != NULL && @$employee->age == @$filter_g_a['age'])
							<tr id="prntEmpRow">
								<td width="20%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_e_a != NULL && @$employee->age == @$filter_e_a['age'])
							<tr id="prntEmpRow">
								<td width="20%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_s_a != NULL && @$employee->age == @$filter_s_a['age'] && @$employee->civil_status == @$filter_s_a['status'])
							<tr id="prntEmpRow">
								<td width="20%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_t_a_s != NULL && @$employee->age == @$filter_t_a_s['age'])
							<tr id="prntEmpRow">
								<td width="20%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_g_a_s != NULL && @$employee->age == @$filter_g_a_s['age'])
							<tr id="prntEmpRow">
								<td width="20%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_super != NULL && @$employee->age == @$filter_super['age'])
							<tr id="prntEmpRow">
								<td width="20%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@elseif (@$filter_age == NULL && @$filter_all == NULL && @$filter_g_a == NULL && @$filter_e_a == NULL && @$filter_s_a == NULL && @$filter_t_a_s == NULL && @$filter_g_a_s == NULL && @$filter_super == NULL)
							<tr id="prntEmpRow">
								<td width="20%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ $employee->emp_id }}</td>
								<td width="50%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
								<td width="30%" style="text-align: left; padding: 8px; border-bottom: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							</tr>
						@endif
						@empty
							<tr>
								<td colspan="4" style="text-align: left; padding: 8px; border: 1px solid #dee2e6; font-family: arial; font-size: 10px; color: #212529; text-align: center;">{{ "No registered Employee yet!" }}</td>
							</tr>
					@endforelse
				</tbody>
			</table>	
		</div>
	</div>
	<div style="margin-top: 20px">
		<p id="prntEmpRslt" style="font-family: arial; font-size: 10px; color: #212529;">Total number of employees: </p>
		@if (Auth::user()->employee != null)
			<p style="font-family: arial; font-size: 10px; color: #212529; float: right; margin-top: 30px;">Printed by: <span>{{ Auth::user()->employee->first_name }} {{ Auth::user()->employee->last_name }} {{ Auth::user()->employee->middle_name }}</span></p>
		@endif
	</div>
</div>

<script type="application/javascript">

	jQuery(document).ready(function($){
		var countTR2 = $("#prntEmpCount tbody #prntEmpRow").length;
		$("#prntEmpRslt").html('');
		$("#prntEmpRslt").append('<p class="font-weight-bold" style="font-family: arial; font-size: 10px; color: #212529;">Total number of employees: '+ countTR2 +'</p>');
	});

</script>

@endif