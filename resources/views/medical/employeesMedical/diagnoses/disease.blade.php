@extends('layouts.app')
@section('title', "| " . 'Medical')
@section('diseaseindex', 'active')
{{-- @section('dash-title', ucwords($employee->last_name) . '\'s information') --}}
@section('heading-title')
	<i class="fas fa-list text-secondary"></i> {{ 'Medical form for' }}
@endsection
@section('dash-content')

<div class="card mb-3">
	<div class="card-body">
		<a class="btn btn-info" data-toggle="modal" data-target="#add-parts">Add Diseases</a><hr>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Diseases</th>
					<th>No. of Diagnoses</th>
					<th>Action</th>
				</thead>
				<tbody>
					@foreach ($diseases as $disease)
						<tr>
							<td>{{ $disease->disease }}</td>
							<td>{{ count($disease->diagnoses) }}</td>
							<td>
								<form method="post" action="{{ route('diseases.destroy', ['disease'=>$disease->id]) }}" class="d-inline-block">
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
				<h5 class="modal-title" id="exampleModalLongTitle">Add New Body Part</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="bParts-form" method="post" action="">
					@csrf
					<div class="form-group">
						<label for="bodypart_id">Select Body Parts</label>
						<select name="bodypart_id" id="bodypart_id" class="form-control">
							<option value="" selected disabled>Select Body Parts</option>
							@foreach ($bparts as $bpart)
								<option value="{{ $bpart->id }}">{{ ucfirst($bpart->bodypart) }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="disease">Disease</label>
						<input type="text" class="form-control" name="disease" placeholder="Add Body Part">
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