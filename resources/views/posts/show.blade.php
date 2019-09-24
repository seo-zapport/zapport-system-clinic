@extends('layouts.app')
@section('title', '| '. $post->title)
@section('posts', 'active')
@section('heading-title')
	<i class="fas fa-book"></i> Posts
@endsection
@section('dash-content')

	<div class="row post-wrap">
		<div class="col-12 col-md-9">
			<div class="form-group posts-title">
				<span class="title mb-1 d-block"><strong>Title</strong></span>
				<p class="post-title">{{ $post->title }}</p>
			</div>
			<div class="form-group posts-description">
				<span class="description mb-1 d-block"><strong>Post description</strong></span>
				<div class="card p-3">
					{!! $post->description !!}
				</div>
			</div>
		</div>
		<div class="col-12 offset-md-1 col-md-2">
			<div class="card">
				<div class="card-body">
					<div class="header-title">
						<p><strong>Edit</strong></p>
						<hr>
					</div>
					<div class="form-group text-center">
						<div class="d-inline-flex float-right">
							<form action="{{ route('post.destroy', ['post' => $post->title]) }}" method="post">
								@method('DELETE')
								@csrf
								<button class="btn btn-danger mr-2" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
							</form>
							<a href="{{ route('post.edit', ['post' => $post->title]) }}" class="btn btn-info text-white">Edit</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection