<table class="table table-hover">
				<thead class="thead-dark">
					<th>Employee Number</th>
					<th>Name</th>
					<th>Department - Position</th>
					<th>Action</th>
				</thead>
				<tbody>
					@forelse ($employees as $employee)
						<tr>
							<td>{{ $employee->emp_id }}</td>
							<td>{{ ucwords($employee->last_name) }} {{ ucwords($employee->first_name) }} {{ ucwords($employee->middle_name) }}</td>
							<td>{{ ucwords($employee->departments->department) }} - {{ ucwords($employee->positions->position) }}</td>
							<td> <a href="{{ route('hr.emp.show', ['employee' => $employee->emp_id]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i>View</a></td>

						</tr>
						@empty
							<tr>
								<td colspan="4" class="text-center">{{ "No registered Employee yet!" }}</td>
							</tr>
					@endforelse
				</tbody>
			</table>