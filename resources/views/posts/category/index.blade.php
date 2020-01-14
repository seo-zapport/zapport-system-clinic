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
@if (session('tag_error'))
	<div id="err-msg" class="alert alert-danger alert-posts">
		{{ session('tag_error') }}
	</div>
@endif
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
								{{ ucwords($tag->tag_name) }}
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
										<span>Category</span> <small class="text-muted font-italic">Enter to save</small>
										<input type="text" name="tag_name" value="{{ $tag->tag_name }}" class="form-control" required autocomplete="off">
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

<!-- Modal Add -->
<div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header zp-bg-clan">
				<h5 class="modal-title text-white" id="exampleModalLongTitle">Add New Category</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="cat-cat-form" method="post" action="{{ route('store.tag') }}">
					@csrf
					<div class="form-group">
						<input type="text" name="tag_name" class="form-control @error('tag_name') border border-danger @enderror" placeholder="Category Name" required autocomplete="off">
						@error('tag_name') <small class="text-danger">{{ $message }}</small> @enderror
					</div>
					<div class="text-right">
						<button id="cat-add" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script type="application/javascript">
	jQuery(document).ready(function($) {
		$("#cat-cat-form #cat-add").on("click", function(e){
			e.preventDefault();
			console.log('clicked');
			$("input[name='tag_name']").val('');
		});
	});
</script>
@error('tag_name')
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('#exampleModalCenter').modal('show')
		});
	</script>
@enderror
@if (session('tag_error'))
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$("#err-msg").on('click', function(e){
				$(this).fadeOut('slow');
			});
		});
	</script>
@endif
@endsection