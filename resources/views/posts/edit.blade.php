@extends('posts.create')
@section('title', '| Edit Post')
{{-- @section('posts', 'active') --}}
@section('dash-title', 'Edit '. $post->title)
@section('dash-content')

@section('postAction', route('post.edit', ['post' => $post->id]))
@section('postMethod')
	@method('PUT')
@endsection
@section('postEdit', $post->title)
@section('postEditDes', $post->description)