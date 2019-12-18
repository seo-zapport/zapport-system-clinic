@extends('layouts.app')
@section('title', '| Posts')
@section('category', 'active')
@section('heading-title')
	<i class="fas fa-book"></i> Category
@endsection
@section('dash-content')
<div class="form-group text-right">
	<a class="btn btn-info text-white" href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i>Add Category</a>
</div>
<div class="card mb-3">
	<div class="card-body">

		<div class="row zp-countable">
			<div class="col-12 count_items">
				<p><span class="zp-tct">Total Items: </span> {{ $count->count() }} <span  class="zp-ct"> Items</span></p>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Category</th>
					<th width="10%" class="text-center">Number of Posts</th>
				</thead>
				<tbody>
					@forelse ($tags as $tag)
						<tr>
							<td>
								{{ $tag->tag_name }}
								<div class="row-actions">
									<span id="{{ $tag->tag_slug }}" class="show-edit btn btn-link text-secondary"><i class="far fa-edit"></i> Quick Edit</span> <span class="text-muted">|</span>
									<form method="post" action="{{ route('destroy.tag', ['tag' => $tag->tag_slug]) }}"  class="d-inline-block">
										@csrf
										@method('DELETE')
										<button class="btn btn-link text-danger" onclick="return confirm('Are you sure you want to delete {{ ucfirst($tag->tag_name) }} Tag?')" data-id="{{ $tag->tag_name }}">
											<i class="fas fa-trash-alt"></i> Delete
										</button>
									</form>
								</div>
							</td>
							<td class="text-center">
								{{ $tag->posts->count() }}
							</td>
						</tr>
						<tr class="inline-edit-row form-hide form-hidden-{{ $tag->tag_slug }}">
							<td colspan="3" >
								<fieldset class="inline-edit-col w-100">
									<form method="post" action="{{ route('update.tag', ['tag' => $tag->tag_slug]) }}">
										@csrf
										@method('PUT')
										<p class="text-muted">QUICK EDIT</p>
										<span>Category</span>
										<input type="text" name="tag_name" value="{{ $tag->tag_name }}" class="form-control" required autocomplete="off" pattern="[a-zA-Z0-9\s]+" title="Special Characters are not allowed!">
									</form>
								</fieldset>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="3" class="text-center">
								<span class="mb-1 text-secondary">No Category Yet !</span>
								{{-- <a href="{{ route('post.create') }}">Create New Post here!</a> --}}
							</td>
						</tr>
					@endforelse
				</tbody>
			</table>
			
		</div>
	</div>
</div>
<div class="pagination-wrap">{{ $tags->links() }}</div>
@include('layouts.errors')
@if (session('tag_error'))
	<div class="alert alert-danger alert-posts">
		{{ session('tag_error') }}
	</div>
@endif

<!-- Modal Add -->
<div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add New Category</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{ route('store.tag') }}">
					@csrf
					<div class="form-group">
						<input type="text" name="tag_name" class="form-control" placeholder="Category Name" required autocomplete="off" pattern="[a-zA-Z0-9\s]+" title="Special Characters are not allowed!">
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


{{-- {{ $posts->links() }} --}}
@endsection