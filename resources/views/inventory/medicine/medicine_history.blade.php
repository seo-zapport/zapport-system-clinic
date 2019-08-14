@extends('layouts.app')
@section('title', 'Brand Name')
@section('medicine', 'active')
@section('dash-title', ucwords($generic->gname))
@section('dash-content')
@section('back')
<a href="{{ route('medicine.log', ['medbrand' => $medbrand->id, 'generic' => $generic->id]) }}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection
<h4>Brand Name: {{ ucwords($medbrand->bname) }}</h4>
<h5>Generic Name: {{ ucwords($generic->gname) }}</h5>
<br>
<form method="get">
	<div class="form-row">
		<div class="form-group col-md-2">
			<input type="search" name="search_name" class="form-control" value="{{ (@$search_name != null) ? $search_name : '' }}" placeholder="Search for Names">
		</div>
		<div class="form-group col-md-2">
			<select name="search_date" id="search_date" class="form-control">
				<option selected disabled="true">Search for Date</option>
				@foreach ($meds as $med)
					<option {{ (@$search_date == $med->Distinct_date) ? 'selected' : '' }} value="{{ $med->Distinct_date }}">{{ $med->Distinct_date->format('M d, Y - h:i a') }}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-md-2">
			<button class="btn btn-success">Search</button>
			<a href="{{ route('medicine.show', ['medbrand' => $medbrand->id, 'generic' => $generic->id, 'inputDate' => $inputDate, 'expDate' => 
					$expDate]) }}" class="btn btn-info text-white">Clear</a>
		</div>
	</div>
</form>

<table class="table table-hover">
	<thead class="thead-dark">
		{{-- <th>No.</th> --}}
		<th>Date Taken</th>
		<th>Name</th>
		<th>No. of medicine</th>
		<th>Given by</th>
	</thead>
	<tbody>
	@forelse ($meds as $med)
	<tr>
		<td>{{ $med->Distinct_date->format('M d, Y - h:i a') }}</td>
		<td>{{ $med->last_name }} {{ $med->first_name }}</td>
		<td>{{ $med->quantity }}</td>
		<td>{{ $med->givenLname }} {{ $med->givenFname }}</td>
	</tr>
	@empty
	<tr>
		<td colspan="4" class="text-center">No Records Yet!</td>
	</tr>
	@endforelse

	</tbody>
</table>

{{ $meds->links() }}

@endsection