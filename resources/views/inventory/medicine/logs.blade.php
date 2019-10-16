@extends('layouts.app')
@section('title', '| Medicines | '.ucwords($generic->gname) . " | " . ucwords($medbrand->bname))
@section('medicine', 'active')
{{-- @section('dash-title', ucwords($generic->gname)) --}}
@section('heading-title')
	<i class="fas fa-pills text-secondary"></i> {{ ucwords($generic->gname) }}
@endsection
@section('dash-content')
@section('back')
<a href="{{ route('medicine') }}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection
<div class="mb-4">
	<h1 class="zp-text">Brand Name: <strong class="zp-color-6b">{{ ucwords($medbrand->bname) }}</strong></h1>
	<h3 class="zp-text zp-text-16">Generic Name: {{ ucwords($generic->gname) }}</h3>
</div>
<form method="get">
	<div class="form-row">
		<div class="form-group col-md-4 mb-0">
			<select name="search" id="search" class="form-control">
				<option selected disabled='true'>Filter Date</option>
				@if (isset($_GET['expired']) && @$search == null)
					@forelse ($logs as $log2)
						<option {{ (@$search == $log2->formatted_at) ? 'selected' : '' }} value="{{ $log2->formatted_at }}">{{ Carbon\carbon::parse($log2->formatted_at)->format('M d, Y') }}</option>
						@empty
							<option>No Records!</option>
					@endforelse
				@elseif (!empty(@$search) && isset($_GET['expired']))
					@forelse ($logsearch as $log2)
						<option {{ (@$search == $log2->formatted_at) ? 'selected' : '' }} value="{{ $log2->formatted_at }}">{{ Carbon\carbon::parse($log2->formatted_at)->format('M d, Y') }}</option>
						@empty
							<option>No Records!</option>
					@endforelse
				@else
					@forelse ($loglist->unique('formatted_at') as $log2)
						<option {{ (@$search == $log2->formatted_at) ? 'selected' : '' }} value="{{ $log2->formatted_at }}">{{ Carbon\carbon::parse($log2->formatted_at)->format('M d, Y') }}</option>
						@empty
							<option>No Records!</option>
					@endforelse
				@endif
			</select>
		</div>
		<div class="form-group col-md-2 d-inline-flex mb-0">
			<button type="submit" class="btn btn-success mr-2">Search</button>
			<a href="{{ route('medicine.log', ['medbrand' => $medbrand->bname, 'generic' => $generic->gname]) }}" class="btn btn-info text-white">Clear</a>
		</div>
		<div class="form-check col-12 col-md-4 mb-0">
			<input type="checkbox" class="form-check-input" {{ (isset($_GET['expired'])) ? 'checked' : '' }} id="exampleCheck1" name="expired" onclick="this.form.submit()">
			<label class="form-check-label" for="exampleCheck1">Filter Expired Medicines</label>
		</div>		
	</div>

</form>
<br>
<div class="card">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>No.</th>
					<th>Input Date</th>
					<th>Date Expire</th>
					<th>Remaining Quantity</th>
					<th>No. of deducted Meds</th>
					<th>No. of Medicines</th>
					<th>Input by</th>
					<th>Action</th>
				</thead>
				<tbody>
					@php
						$i = 1;
					@endphp
					@forelse ($logs as $log)
						<tr>
							<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
								{{ $i }}
							</td>
							<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
								{{ Carbon\carbon::parse($log->formatted_at)->format('M d, Y') }}
							</td>
							<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
								{{ Carbon\carbon::parse($log->expiration_date)->format('M d, Y') }}</td>
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
							<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
								<a href="{{ route('medicine.show', ['medbrand' => $log->bname, 'generic' => $log->gname, 'inputDate' => $log->orig, 'expDate' => 
								$log->expiration_date]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i>View</a>
							</td>
						</tr>
					@php
						$i++;
					@endphp
						@empty
							<tr>
								@if (isset($_GET['expired']) && @$search == null)
									<td colspan="8" class="text-center">{{ "No Expired Medicine!" }}</td>
									@else
										<td colspan="8" class="text-center">{{ "No registered Medicine yet!" }}</td>
								@endif
							</tr>
					@endforelse
				</tbody>
			</table>			
		</div>
	</div>
</div>

{{ $logs->links() }}
@endsection