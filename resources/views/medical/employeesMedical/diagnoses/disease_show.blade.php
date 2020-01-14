@extends('layouts.app')
@section('title', "| " . 'Medical')
@section('bodypartindex', 'active')
{{-- @section('dash-title', ucwords($employee->last_name) . '\'s information') --}}
@section('heading-title')
	<i class="fas fa-list text-secondary"></i> {{ ucwords($disease->disease) }}
@endsection
@section('dash-content')

<div class="card mb-3">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Diagnoses</th>
					<th width="10%" class="text-center">No. of Cases</th>
				</thead>
				<tbody>
					@forelse ($disease->diagnoses as $diagnosis)
						<tr>
							<td>
								{{ ucwords($diagnosis->diagnosis) }}
								@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
									<div class="row-actions">
										<span id="diagnosisID-{{ $diagnosis->id }}" class="show-edit btn btn-link text-secondary"><i class="far fa-edit"></i> Quick Edit</span>
									</div>
								@endif
							</td>
							<td class="text-center">{{ $diagnosis->employeesMedicals->count() }}</td>
						</tr>
						<tr class="inline-edit-row form-hide form-hidden-diagnosisID-{{ $diagnosis->id }}">
							<td colspan="3" >
								<fieldset class="inline-edit-col w-100">
									<form method="post" action="{{ route('diagnosis.update', ['diagnosis'=>$diagnosis->id]) }}">
										@csrf
										@method('PUT')
										<p class="text-muted">QUICK EDIT</p>
										<span>Category</span> <span class="font-italic text-muted">Enter to save</span>
										<input type="hidden" name="disease_id" value="{{ $disease->id }}">
										<input type="text" name="diagnosis" value="{{ $diagnosis->diagnosis }}" autocomplete="off" class="form-control" required>
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
	</div>
</div>

@error('diagnosis')
	<div id="err-msg" class="alert alert-danger">
		{{ $message }}
	</div>
@enderror

@endsection

@section('scripts')
	<script text=text/javascript>
		jQuery(document).ready(function(){
			$("#err-msg").on('click', function(e){
				$(this).fadeOut('slow');
			});
		});
	</script>
@endsection