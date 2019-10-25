<div class="printhead">	
	<img src="{{url( '/images/logo.png' )}}" alt="Zapport" style="display:block;margin:auto;">
</div>
<h2>Medicines Inventory</h2>
<h3>@if(app('request')->input('search') != "")  {{ "Filter by: ".app('request')->input('search') }} @endif</h3>
<div class="table-responsive">
	<table id="medTable" class="table table-hover">
	 @php 
	 	if(@$typeprint == "viewlogs"){ 
	 @endphp
	   	<thead class="thead-dark">
	   		<th>Input Date</th>
	   		<th>Date Expire</th>
	   		<th>Remaining Quantity</th>
	   		<th>No. of deducted Meds</th>
	   		<th>No. of Medicines</th>
	   		<th>Input by</th>
	   	</thead>
	   	<tbody>
	   		@forelse (@$meds as $log)
	   			<tr class="medTR">
	   				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
	   				{{ Carbon\carbon::parse($log->formatted_at)->format('m/d/Y') }}
	   				</td>
	   				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
	   				{{ Carbon\carbon::parse($log->expiration_date)->format('m/d/Y') }}</td>
	   				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
	   				{{ $log->where('brand_id', $log->brand_id)->where('generic_id', $log->generic_id)->where('expiration_date', $log->expiration_date)->where('availability', 0)->where('created_at', $log->orig)->count() }}
	   				</td>
	   				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
	   					{{ $log->where('brand_id', $log->brand_id)->where('generic_id', $log->generic_id)->where('expiration_date', $log->expiration_date)->where('availability', 1)->count() }}
	   				</td>
	   				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
	   					{{ $log->where('brand_id', $log->brand_id)->where('generic_id', $log->generic_id)->where('expiration_date', $log->expiration_date)->where('created_at', $log->orig)->count() }}
	   				</td>
	   				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
	   				{{ ucwords($log->user->employee->last_name) }} {{ ucwords($log->user->employee->first_name) }}
	   				</td>
	   			</tr>
	   			@empty
	   				<tr>
	   					@if (isset($_GET['expired']) && @$search == null)
	   							<td colspan="6" class="text-center">{{ "No Expired Medicine!" }}</td>
	   						@else
	   							<td colspan="6" class="text-center">{{ "No registered Medicine yet!" }}</td>
	   					@endif
	   				</tr>
	   		@endforelse
	   	</tbody>	

	@php 
		}elseif(@$typeprint == "logsinput"){ 
	@endphp
		<thead class="thead-dark">
			<th>Date Taken</th>
			<th>Name</th>
			<th>No. of medicine</th>
			<th>Given by</th>
		</thead>
		<tbody>
		@forelse (@$meds['meds'] as $med)
		<tr>
			<td>{{ $med->Distinct_date->format('m/d/Y - h:i a') }}</td>
			<td>{{ $med->last_name }} {{ $med->first_name }}</td>
			<td>{{ $meds['countMeds']->where('empMeds_id', $med->empMeds_id)->where('patient', $med->patient)->where('distinct_user_id', $med->distinct_user_id)->where('Distinct_date', $med->Distinct_date)->count() }}</td>
			<td>{{ $med->givenLname }} {{ $med->givenFname }}</td>
		</tr>
		@empty
		<tr>
			<td colspan="4" class="text-center">No Records Yet!</td>
		</tr>
		@endforelse
		</tbody>

	@php }else{ @endphp
		<thead class="thead-dark">
			<th>Generic Name</th>
			<th>Brand Name</th>
			<th>Remaining Quantity</th>
		</thead>
		<tbody>
			@if (@$meds != null)		
			@forelse (@$meds as $med)
				<tr class="medTR">
					<td>{{ ucfirst($med->generic->gname) }}</td>
					<td>{{ ucwords($med->medBrand->bname) }}</td>
					<td>{{ $med->where('generic_id', $med->generic_id)->where('brand_id', $med->brand_id)->where('availability', 0)->where('expiration_date', '>', NOW())->count() }}</td>
				</tr>
				@empty
					<tr>
						<td colspan="3" class="text-center">{{ "No registered Medicine yet!" }}</td>
					</tr>
			@endforelse
			@else
				<tr>
					<td colspan="3" class="text-center">{{ "No Record Found!" }}</td>
				</tr>
			@endif
		</tbody>
	@php } @endphp
	</table>			
</div>

