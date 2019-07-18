@extends('layouts.app')
@section('title', 'Position')
@section('genericname', 'active')
@section('dash-title', 'Generic Names')
@section('dash-content')

<div class="form-group">
	<a class="btn btn-info text-white" href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Add Position</a>
</div>

<table class="table">
	<thead class="thead-dark">
		<th>Generic Name</th>
		<th>No. of Medecines</th>
	</thead>
	<tbody>
		@forelse ($gens as $gen)
			<tr>
				<td>
	        	<form method="post" action="{{ route('genericname.delete', ['generic' => $gen->id]) }}">
	        		@csrf
	        		@method('DELETE')
	        		<div class="form-row align-items-center">
	            		<div class="col-auto my-1 form-inline">
	        				{{ $gen->gname }}
							<button class="btn btn-link"  onclick="return confirm('Are you sure you want to delete {{ ucfirst($gen->gname) }} Position?')" data-id="{{ $gen->id }}">
								<i class="fas fa-times-circle"></i>
							</button>
						</div>
					</div>
	        	</form>
				</td>
				<td>{{ $gen->medbrand->count() }}</td>
			</tr>
			@empty
				<tr>
					<td colspan="2" class="text-center">{{ "No generic names registered yet!" }}</td>
				</tr>
		@endforelse
	</tbody>
</table>
@include('layouts.errors')

<!-- Modal Add -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add New Position</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{ route('genericname.add') }}">
					@csrf
					<div class="form-group">
						<label for="department_id">Brand Name</label>
					<select name="medbrand_id" id="medbrand_id" class="form-control" {{-- required --}}>
							<option selected="true" disabled="disabled"> Select Brand Name </option>
						@foreach ($brands as $brand)
							<option value="{{ $brand->id }}">{{ $brand->bname }}</option>
						@endforeach
					</select>
					</div>
					<div class="form-group">
						<label for="gname">Generic Name</label>
						<input type="text" name="gname" class="form-control" placeholder="Add Position" value="{{ old('gname') }}" {{-- required --}}>
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