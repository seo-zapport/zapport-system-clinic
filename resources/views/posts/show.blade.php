@extends('layouts.app')
@section('title', '| '. $post->title)
@section('posts', 'active')
@section('dash-title', $post->title)
@section('heading-title')
	<i class="fas fa-book"></i> Posts
@endsection
@section('dash-content')
{!! $post->description !!}

<div class="d-inline-flex float-right">
	<form action="{{ route('post.destroy', ['post' => $post->title]) }}" method="post">
		@method('DELETE')
		@csrf
		<button class="btn btn-danger mr-2" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
	</form>
	<a href="{{ route('post.edit', ['post' => $post->title]) }}" class="btn btn-info">Edit</a>
</div>
@endsection