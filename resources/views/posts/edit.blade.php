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
		<div id="category_lists_edit">
			<div class="mb-1">
				<input type="hidden" name="tag_old" value="{{ $postTags->id }}">
				@foreach ($uniqueTag as $tag)
					<input type="checkbox"  name="tag_id[]" class="zp-chkbox" id="tag_id_{{ $tag->id }}" value="{{ $tag->id }}">
					<label class="form-check-label" for="tag_id_{{ $tag->id }}">{{ $tag->tag_name }}</label>
				@endforeach
			</div>
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

@section('importantEdit')
<div class="card">
	<div class="card-body">
		<div class="header-title">
			<p><strong>Important</strong></p>
			<hr>
		</div>
		<div class="mb-1">
			<input type="checkbox" id="zpImportant" {{ ($post->important != null) ? 'checked' : '' }} name="important" value="{{ $post->important }}" class="zp-chkbox">
			<label for="zpImportant">Check for Important posts</label>
		</div>				
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