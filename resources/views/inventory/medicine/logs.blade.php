@extends('layouts.app')
@section('title', '| Medicines | '.ucwords($generic->gname) . " | " . ucwords($medbrand->bname))
@section('medicine', 'active')
@section('dash-title', ucwords($generic->gname))
@section('dash-content')
@section('back')
<a href="{{ route('medicine') }}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection
<h4>Brand Name: {{ ucwords($medbrand->bname) }}</h4>
<h5>Generic Name: {{ ucwords($generic->gname) }}</h5>
<form method="get">
	<div class="form-row">
		<div class="form-group col-md-4">
			<select name="search" id="search" class="form-control">
				<option selected disabled='true'>Filter Date</option>
				@if (isset($_GET['expired']) && @$search == null)
					@forelse ($logs as $log2)
						<option {{ (@$search == $log2->created_at) ? 'selected' : '' }} value="{{ $log2->created_at }}">{{ Carbon\carbon::parse($log2->created_at)->format('M d, Y') }}</option>
						@empty
							<option>No Records!</option>
					@endforelse
				@elseif (!empty(@$search) && isset($_GET['expired']))
					@forelse ($logsearch as $log2)
						<option {{ (@$search == $log2->created_at) ? 'selected' : '' }} value="{{ $log2->created_at }}">{{ Carbon\carbon::parse($log2->created_at)->format('M d, Y') }}</option>
						@empty
							<option>No Records!</option>
					@endforelse
				@else
					@forelse ($loglist as $log2)
						<option {{ (@$search == $log2->created_at) ? 'selected' : '' }} value="{{ $log2->created_at }}">{{ Carbon\carbon::parse($log2->created_at)->format('M d, Y') }}</option>
						@empty
							<option>No Records!</option>
					@endforelse
				@endif
			</select>
		</div>
		<div class="form-group col-md-1 d-inline-flex">
			<button type="submit" class="btn btn-success mr-2">Search</button>
			<a href="{{ route('medicine.log', ['medbrand' => $medbrand->id, 'generic' => $generic->id]) }}" class="btn btn-info text-white">Clear</a>
		</div>
	</div>
	  <div class="form-check">
	    <input type="checkbox" class="form-check-input" {{ (isset($_GET['expired'])) ? 'checked' : '' }} id="exampleCheck1" name="expired" onclick="this.form.submit()">
	    <label class="form-check-label" for="exampleCheck1">Filter Expired Medicines</label>
	  </div>
</form>
<br>
<table class="table table-hover">
	<thead class="thead-dark">
		<th>No.</th>
		<th>Input Date</th>
		<th>Date Expire</th>
		<th>Remaining Quantity</th>
		<th>No. of deducted Meds</th>
		<th>No. of Medicines</th>
		<th>Input by</th>
		<th>View</th>
	</thead>
	<tbody>
		@php
			$i = 1;
		@endphp
		@forelse ($logs as $log)
			<tr>
				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $i }}</td>
				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ Carbon\carbon::parse($log->created_at)->format('M d, Y') }}</td>
				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ Carbon\carbon::parse($log->expiration_date)->format('M d, Y') }}</td>
				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $log1->where('expiration_date', $log->expiration_date)->where('availability', 0)->count() }}</td>
				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $log1->where('expiration_date', $log->expiration_date)->where('availability', 1)->count() }}</td>
				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ $log1->where('expiration_date', $log->expiration_date)->where('created_at', $log->created_at)->count() }}</td>
				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">{{ ucwords($log->user->employee->last_name) }} {{ ucwords($log->user->employee->first_name) }}</td>
				<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
					<a href="{{ route('medicine.show', ['medbrand' => $log->brand_id, 'generic' => $log->generic_id, 'inputDate' => $log->created_at, 'expDate' => 
					$log->expiration_date]) }}" class="btn btn-info text-white">View</a>
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
{{ $logs->links() }}
@endsection