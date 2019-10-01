@extends('posts.create')
@section('title', '| Edit Post')
@section('heading-title')
	<i class="fas fa-book text-secondary"></i> Edit Posts
@endsection
@section('dash-content')

@section('postAction', route('post.edit', ['post' => $post->title]))
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
		</div>
		<div>
			<input type="hidden" name="tag_old" value="{{ $postTags->id }}">
			<select name="tag_id" id="tag_id" class="form-control">
				{{-- <option selected="true" disabled="disabled" value=""> Select Generic Name </option> --}}
				@foreach ($tags as $tag)
					<option {{ ($postTags->tag_name == $tag->tag_name) ? 'selected="true"' : '' }} value="{{ $tag->id }}">{{ $tag->tag_name }}</option>
				@endforeach
			</select>
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