@extends('layouts.app')
@section('title', '| Brand Name')
@section('brandname', 'active')
{{-- @section('dash-title', 'Brand Names') --}}
@section('heading-title')
	<i class="fas fa-file-prescription text-secondary"></i> Brand Names
@endsection
@section('dash-content')

@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
	<div class="form-group">
		<a class="btn btn-info text-white" href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Add Brand</a>
	</div>
@endif

<div class="card mb-5">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Brand Name</th>
					<th>No. of Generics</th>
					<th>Action</th>
				</thead>
				<span class="font-weight-bold">Result: {{ $brands->count() }}</span><br>
				<span class="font-weight-bold">Total number of Brands: {{ $brandCount->count() }}</span>
				<tbody>
					@forelse ($brands as $brand)
						<tr>
							<td>
				        		{{ ucwords($brand->bname) }}
							</td>
							<td>{{ $brand->generic->count() }} </td>
							<td class="w-15 px-0">
								<a href="{{ route('brandname.show', ['medbrand' => $brand->bname]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i>View</a>
								@if (Gate::check('isAdmin') || Gate::check('isDoctor') || Gate::check('isNurse'))
								<small class="text-muted">|</small>
					        	<form method="post" action="{{ route('brandname.delete', ['medbrand' => $brand->bname]) }}" class="d-inline">
					        		@csrf
					        		@method('DELETE')
									<button class="btn btn-link text-danger"   onclick="return confirm('Are you sure you want to delete {{ ucfirst($brand->bname) }} Brand?')" data-id="{{ $brand->bname }}">
										<i class="fas fa-trash-alt"></i> Delete
									</button>
					        	</form>	
								@endif
							</td>
						</tr>
						@empty
							<tr>
								<td colspan="3" class="text-center">{{ "No registered Brand Name yet!" }}</td>
							</tr>
					@endforelse
				</tbody>
			</table>			
		</div>
	</div>
</div>

{{ $brands->links() }}
@include('layouts.errors')
@if (session('brand_message') || session('pivot_validation'))
	<div class="alert alert-danger alert-posts">
		{{ session('brand_message') }}
		{{ session('pivot_validation') }}
	</div>
@endif
<!-- Modal Add -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add New Brand</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{ route('brandname.add') }}">
					@csrf
					<div class="form-group">
						<label for="generic_id">Generic Name</label>
					<select name="generic_id" id="generic_id" class="form-control" required>
							<option selected="true" disabled="disabled" value=""> Select Generic Name </option>
						@foreach ($gens as $gen)
							<option value="{{ $gen->id }}">{{ $gen->gname }}</option>
						@endforeach
					</select>
					</div>
					<div class="form-group">
						<label for="bname">Brand Name</label>
						<input type="text" name="bname" class="form-control" placeholder="Add Brand" value="{{ old('bname') }}" required>
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