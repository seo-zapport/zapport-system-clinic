@extends('posts.create')
@section('title', '| Edit Post')
@section('heading-title')
	<i class="fas fa-book"></i> Edit Posts
@endsection
@section('dash-content')

@section('postAction', route('post.edit', ['post' => $post->slug]))
@section('postMethod')
	@method('PUT')
@endsection
@section('postEdit', $post->title)
@section('postEditDes', $post->description)
@section('tagsEdit')
<div class="card">
	<div class="card-body">
		<div class="header-title">
			<p><strong>Categories</strong></p>
			<hr>
			<a href="#" class="btn btn-info text-white btn-block mb-2" href="#" data-toggle="modal" data-target="#tagModal">Add Category</a>
		</div>
		<div>
			<input type="hidden" name="tag_old" value="{{ $postTags->id }}">
			<select multiple name="tag_id[]" id="tag_id" class="form-control">
				{{-- <option selected="true" disabled="disabled" value=""> Select Generic Name </option> --}}
				@foreach ($uniqueTag as $tag)
					<option value="{{ $tag->id }}">{{ $tag->tag_name }}</option>
				@endforeach
			</select>
		</div>
		<hr>

		<div id="rmvTags" class="form-row align-items-center">
			<div class="col-auto my-1 form-inline">
				<label for="tags"><p>Tags:</p></label>
			</div>
			@foreach ($post->tags as $tag)
				<div id="cont-{{ $tag->id }}" class="col-auto my-1 form-inline">
					<p>
						{{ $tag->tag_name }} <a href="#" data-toggle="modal" id="delTag" data-target="{{ $tag->id }}">
							<input id="postID" type="hidden" value="{{ $post->slug }}">
							<i class="fas fa-times-circle"></i>
						</a>
					</p>
				</div>

			@endforeach
		</div>
		<span id="errorTag"></span>
	</div>
</div>
@endsection
@section('ftEdit')
<div class="card">
	<div class="card-body">
		<div class="header-title">
			<p><strong>Featured Image</strong></p>
			<hr>
			<a href="#" class="btn btn-info text-white btn-block mb-2" href="#" data-toggle="modal" data-target="#featImgModal">Add Featured Image</a>
		</div>
		<div>
			<span id="ftID"></span>
			<figure id="ftimg">
				<img id="edit_id" src="{{ ($post->medias != null) ? asset('storage/uploaded/media/'.$post->medias->file_name) : asset('storage/uploaded/media/No_image.png') }}" class="img-fluid d-inline-flex">
			</figure>
{{-- 			<figure id="stored_ftimg">
				<img id="edit_id" src="{{ asset('storage/uploaded/media/'.$post->medias->file_name) }}" class="img-fluid d-inline-flex">
			</figure> --}}
			<span id="rmvImg" class="btn btn-secondary btn-sm d-none">x</span>
		</div>					
	</div>
</div>

@endsection

{{-- @section('rmvTag')
@foreach ($post->tags as $tag)
<!-- Modal Tag -->
<div class="modal fade" id="delTag-{{ $tag->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Delete Category</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="card">
					<div class="card-body">
						<div>
							<form id="tagForm" method="post" action="{{ route('removeTags', ['post' => $post->id, 'tag' => $tag->id]) }}">
								@csrf
								@method('DELETE')
								<p>{{ $tag->tag_name }}</p>
								<small id="errorlogTag" class="text-muted mt-2"></small>
							<hr>
							<div class="form-group text-center">
								<button class="btn btn-info text-white btn-block" type="submit">Delete Category</button>
							</div>	
							</form>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endforeach
@endsection --}}