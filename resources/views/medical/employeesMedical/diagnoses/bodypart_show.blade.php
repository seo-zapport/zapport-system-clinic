@extends('layouts.app')
@section('title', "| " . 'Medical')
@section('bodypartindex', 'active')
{{-- @section('dash-title', ucwords($employee->last_name) . '\'s information') --}}
@section('heading-title')
	<i class="fas fa-list text-secondary"></i> {{ ucfirst($bodypart->bodypart) }}
@endsection
@section('dash-content')
<div class="row zp-filters">
	<div class="col-12 text-right form-group"><a class="btn btn-info text-white" data-toggle="modal" data-target="#add-parts"><i class="fa fa-plus"></i> Add Disease</a></div>
</div>

<div class="card mb-3">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Disease</th>
					<th width="10%" class="text-center">No. of Diagnoses</th>
				</thead>
				<tbody>
					@php
						$collection = $bodypart->diseases()->paginate(10);
					@endphp
					@foreach ($collection as $disease)
						<tr>
							<td>
								{{ ucfirst($disease->disease) }}
								<div class="row-actions">
									<form method="post" action="{{ route('diseases.destroy', ['disease'=>$disease->disease_slug]) }}" class="d-inline-block">
												@csrf
												@method('DELETE')
										<button class="btn btn-link text-danger"  onclick="return confirm('Are you sure you want to delete {{ ucfirst($disease->disease) }} ?')" data-id="{{ $disease->disease }}">
											<i class="fas fa-trash-alt"></i> Delete
										</button>
											</form>									
								</div>
							</td>
							<td class="text-center">{{ count($disease->diagnoses) }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="pagination-wrap">{{ $collection->links() }}</div>
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