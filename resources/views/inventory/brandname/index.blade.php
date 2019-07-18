@extends('layouts.app')
@section('title', 'Brand Name')
@section('brandname', 'active')
@section('dash-title', 'Brand Names')
@section('dash-content')

<div class="form-group">
	<a class="btn btn-info text-white" href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> Add Brand</a>
</div>

<table class="table">
	<thead class="thead-dark">
		<th>Brand Name</th>
		<th>No. of Generics</th>
		<th></th>
	</thead>
	<tbody>
		@forelse ($brands as $brand)
			<tr>
				<td>
	        	<form method="post" action="{{ route('brandname.delete', ['medbrand' => $brand->id]) }}">
	        		@csrf
	        		@method('DELETE')
	        		<div class="form-row align-items-center">
	            		<div class="col-auto my-1 form-inline">
	        				{{ $brand->bname }}
							<button class="btn btn-link"  onclick="return confirm('Are you sure you want to delete {{ ucfirst($brand->bname) }} Brand?')" data-id="{{ $brand->id }}">
								<i class="fas fa-times-circle"></i>
							</button>
						</div>
					</div>
	        	</form>
				</td>
				<td>{{ $brand->generic->count() }}</td>
				<td><a href="{{ route('brandname.show', ['medbrand' => $brand->id]) }}" class="btn btn-info text-white">View</a></td>
			</tr>
			@empty
				<tr>
					<td colspan="2" class="text-center">{{ "No registered Brand Name yet!" }}</td>
				</tr>
		@endforelse
	</tbody>
</table>
@include('layouts.errors')
@if (session('brand_message'))
	<div class="alert alert-danger alert-posts">
		{{ session('brand_message') }}
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