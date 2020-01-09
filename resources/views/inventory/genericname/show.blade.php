@extends('layouts.app')
@section('title', '| Generics | '. $generic->gname)
@section('genericname', 'active')
@section('heading-title')
	<i class="fas fa-tablets text-secondary"></i> {{ strtoupper($generic->gname) }}
@endsection
@section('dash-content')

<div class="d-flex align-content-center p-2">
	<p><span class="text-muted">Generic Name</span>: <strong>{{ strtoupper($generic->gname) }}</strong></p>
	@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
		<a href="" data-toggle="modal" data-target="#exampleModalCenter"><i class="far fa-edit text-primary p-1"></i></a>
	@endif
</div>

<div class="card">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table">
				<thead class="thead-dark">
					<th>Brand Name</th>
					<th width="10%" class="text-center">Remaining Quantity</th>
				</thead>
				<tbody>
					@forelse ($allBrands as $gen)
						<tr>
							<td>
								{{ strtoupper($gen->medbrand->bname) }}
							</td>
							<td class="text-center">
								{{ $gen->where('brand_id', $gen->medbrand->id)->where('availability', 0)->where('expiration_date', '>', NOW())->count() }}
							</td>
						</tr>
						@empty
							<tr>
								<td colspan="4" class="text-center">{{ "No Records yet!" }}</td>
							</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- Modal Add -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Edit Generic Name</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{ route('genericname.update', ['generic' => $generic->gname_slug]) }}">
					@csrf
					@method('PUT')
					<div class="form-group">
						<label for="bname">Generic Name</label>
						<input type="text" name="gname" class="form-control @error('gname') border border-danger @enderror" placeholder="Add Generic" value="{{ $generic->gname }}" required autocomplete="off" pattern="[a-zA-Z0-9\s()/]+" title="Special Characters are not allowed!">
						@error('gname') <small class="text-danger">{{ $message }}</small> @enderror
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

@error('gname')
	@section('scripts')
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('#exampleModalCenter').modal('show')
			});
		</script>
	@endsection
@enderror