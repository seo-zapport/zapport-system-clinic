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