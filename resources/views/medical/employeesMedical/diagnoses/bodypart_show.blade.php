@extends('layouts.app')
@section('title', "| " . 'Medical')
@section('bodypartindex', 'active')
{{-- @section('dash-title', ucwords($employee->last_name) . '\'s information') --}}
@section('heading-title')
	<i class="fas fa-list text-secondary"></i> {{ ucfirst($bodypart->bodypart) }}
@endsection
@section('dash-content')

@if (Gate::check('isAdmin') || Gate::check('isNurse') || Gate::check('isDoctor'))
	<div class="row zp-filters">
		<div class="col-12 text-right form-group"><a class="btn btn-info text-white" data-toggle="modal" data-target="#add-parts"><i class="fa fa-plus"></i> Add Disease</a></div>
	</div>
@endif

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
					@forelse ($collection as $disease)
						<tr>
							<td>
								{{ ucfirst($disease->disease) }}
								<div class="row-actions">
									@if (Gate::check('isAdmin') || Gate::check('isNurse') || Gate::check('isDoctor'))
										<span id="{{ $disease->disease_slug }}" class="show-edit btn btn-link text-secondary"><i class="far fa-edit"></i> Quick Edit</span> <span class="text-muted">|</span>
									@endif
									<a href="{{ route('diseases.show', ['disease'=>$disease->disease_slug]) }}" class="btn-link text-secondary"><i class="far fa-eye"></i> View |</a>
									@if (Gate::check('isAdmin') || Gate::check('isNurse') || Gate::check('isDoctor'))
										<form method="post" action="{{ route('diseases.destroy', ['disease'=>$disease->disease_slug]) }}" class="d-inline-block">
											@csrf
											@method('DELETE')
											<button class="btn btn-link text-danger"  onclick="return confirm('Are you sure you want to delete {{ ucfirst($disease->disease) }} ?')" data-id="{{ $disease->disease }}">
												<i class="fas fa-trash-alt"></i> Delete
											</button>
										</form>									
									@endif
								</div>
							</td>
							<td class="text-center">{{ $disease->diagnoses->count() }}</td>
						</tr>
						<tr class="inline-edit-row form-hide form-hidden-{{ $disease->disease_slug }}">
							<td colspan="3" >
								<fieldset class="inline-edit-col w-100">
									<form method="post" action="{{ route('diseases.update', ['disease'=>$disease->disease_slug]) }}">
										@csrf
										@method('PUT')
										<p class="text-muted">QUICK EDIT</p>
										<span>Category</span>
										<input type="hidden" name="bodypart_id" value="{{ $bodypart->id }}">
										<input type="text" name="disease" value="{{ $disease->disease }}" class="form-control" required autocomplete="off" pattern="[a-zA-Z0-9\s()-/]+" title="Special Characters are not allowed!">
									</form>
								</fieldset>
							</td>
						</tr>
						@empty
							<tr>
								<td colspan="2" class="text-center">
									0 Result Found!
								</td>
							</tr>
					@endforelse
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
						<input type="text" class="form-control" name="disease" placeholder="Add Disease" required autocomplete="off" pattern="[a-zA-Z0-9\s()-/']+" title="Special Characters are not allowed!">
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