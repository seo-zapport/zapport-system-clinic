@extends('layouts.app')
@section('title', 'Brand Name')
@section('medicine', 'active')
@section('dash-title', 'test')
@section('dash-content')
@section('back')
<a href="{{ route('medicine.log', ['medbrand' => $medbrand->id, 'generic' => $generic->id]) }}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection

<table class="table table-hover">
	<thead class="thead-dark">
		{{-- <th>No.</th> --}}
		<th>Date Taken</th>
		<th>Name</th>
		<th>No. of medicine</th>
		<th>Given by</th>
	</thead>
	<tbody>
		@if ($empsMeds != null)
			@php
				$temp_id = 0;
				$temp_date = '';
			@endphp
			@foreach ($arr  as $item)
				@foreach ($item->employeesMedical as $ids)
				@if ($temp_id != $ids->id || $temp_date != $ids->pivot->created_at)
						{{-- {{ $ids->pivot->created_at}} --}}
					<tr>
							<td>{{ $ids->pivot->created_at->format('M d, Y - h:i a') }}</td>
							<td>{{ ucwords($ids->employee->first_name) }} {{ ucwords($ids->employee->last_name) }}</td>
							<td>{{ $ids->pivot->quantity }}</td>
						

{{-- 						@php
							$temp_id = 0;
						@endphp
 --}}
						{{-- @foreach ($item->users as $ids) --}}
							{{-- @if ($temp_id != $ids->id) --}}
								{{-- {{ $ids->id }} --}}
								@foreach ($item->users as $ems)
									<td>{{ ucwords($ems->employee->first_name) }} {{ ucwords($ems->employee->last_name) }}</td>
								@endforeach
							{{-- @endif --}}
{{-- 							@php
								$temp_id = $ids->id;
							@endphp --}}
						{{-- @endforeach --}}

					</tr>
			@endif
			@php
				$temp_id = $ids->id;
				$temp_date = $ids->pivot->created_at;
			@endphp
			@endforeach
			@endforeach
			@else
				<tr>
					<td colspan="4" class="text-center">{{ "No registered Medicine yet!" }}</td> 
				</tr>
		@endif
	</tbody>
</table>

@endsection