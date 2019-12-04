@extends('layouts.app')
@section('title', "| " . 'Medical')
@section('bodypartindex', 'active')
{{-- @section('dash-title', ucwords($employee->last_name) . '\'s information') --}}
@section('heading-title')
	<i class="fas fa-list text-secondary"></i> {{ 'Medical form for' }}
@endsection
@section('dash-content')

<div class="card mb-3">
	<div class="card-body">
		<a class="btn btn-info" data-toggle="modal" data-target="#add-parts">Add Body Parts</a><hr>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Body Part</th>
					<th>No. of Diseases</th>
				</thead>
				<tbody>
					@foreach ($bparts as $bpart)
						<tr>
							<td>{{ $bpart->bodypart }}</td>
							<td>{{ count($bpart->diseases) }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@include('layouts.errors')

<!-- Modal For Body Parts -->
<div class="modal fade" id="add-parts" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add New Body Part</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="bParts-form" method="post" action="{{ route('bodyparts.store') }}">
					@csrf
					<div class="form-group">
						<label for="bodypart">Body Part</label>
						<input type="text" class="form-control" name="bodypart" placeholder="Add Body Part">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection