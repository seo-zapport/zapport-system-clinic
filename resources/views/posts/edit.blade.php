@extends('posts.create')
@section('title', '| Edit Post')
@section('heading-title')
	<i class="fas fa-book"></i> Edit Posts
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
			<p><strong>Tags</strong></p>
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