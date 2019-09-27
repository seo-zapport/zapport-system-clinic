@extends('layouts.front-page.index')

{{-- @section('front-title',  ucfirst($site_identity->site_title).' | Home') --}}
@section('front-title', ' Zapport | Home')

@section('front-content')
	<section class="text-center">
		{{-- thumbnail --}}
		<figure>
				<img src="{{ !empty(@$post->medias->file_name) ? asset('storage/uploaded/media/'.$post->medias->file_name) : asset('storage/uploaded/media/No_image.png') }}" class="mx-auto mb-5">
            	<span class="text-muted">{{ $post->created_at->format('M d, Y') }}</span>
		</figure>
	</section>
	<div class="container">
		<div class="title m-b-md text-center h3 text-secondary">
            <span>{{ $post->title }}</span>
		</div>
		<div class="text-center text-secondary lead">
			{!! $post->description !!}
		</div>
	</div>
@endsection