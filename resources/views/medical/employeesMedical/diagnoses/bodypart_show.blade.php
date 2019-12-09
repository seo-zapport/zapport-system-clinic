@extends('layouts.app')
@section('title', "| " . 'Medical')
@section('bodypartindex', 'active')
{{-- @section('dash-title', ucwords($employee->last_name) . '\'s information') --}}
@section('heading-title')
	<i class="fas fa-list text-secondary"></i> {{ ucfirst($bodypart->bodypart) }}
@endsection
@section('dash-content')

<div class="card mb-3">
	<div class="card-body">
		<a class="btn btn-info" data-toggle="modal" data-target="#add-parts">Add Disease</a><hr>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Disease</th>
					<th>No. of Diagnoses</th>
					<th>Action</th>
				</thead>
				<tbody>
					@php
						$collection = $bodypart->diseases()->paginate(10);
					@endphp
					@foreach ($collection as $disease)
						<tr>
							<td>{{ ucfirst($disease->disease) }}</td>
							<td>{{ count($disease->diagnoses) }}</td>
							<td>
								<form method="post" action="{{ route('diseases.destroy', ['disease'=>$disease->disease_slug]) }}" class="d-inline-block">
					        		@csrf
					        		@method('DELETE')
									<button class="btn btn-link text-danger"  onclick="return confirm('Are you sure you want to delete {{ ucfirst($disease->disease) }} ?')" data-id="{{ $disease->disease }}">
										<i class="fas fa-trash-alt"></i> Delete
									</button>
					        	</form>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		{{ $collection->links() }}
	</div>
</div>
@include('layouts.errors')
@if (session('disease_error'))
	<div class="alert alert-danger alert-posts">
		{{ session('disease_error') }}
	</div>
@endif

<!-- Modal For Body Parts -->
<div class="modal fade" id="add-parts" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add Disease for {{ ucfirst($bodypart->bodypart) }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="bParts-form" method="post" action="{{ route('diseases.store') }}">
					@csrf
					<div class="form-group">
						<label for="disease">Disease</label>
						<input type="hidden" name="bodypart_id" value="{{ $bodypart->id }}">
						<input type="text" class="form-control" name="disease" placeholder="Add Disease" required>
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