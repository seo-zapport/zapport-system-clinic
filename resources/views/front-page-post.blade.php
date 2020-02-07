@extends('layouts.front-page.index')

{{-- @section('front-title',  ucfirst($site_identity->site_title).' | Home') --}}
@section('front-title', ' Zapport | Home')

@section('front-content')
	<section class="zp-article-wrapper">
		<div class="container">
			<div class="card px-0 col-12 col-md-10">
				<div class="card-body">
					{{-- thumbnail --}}
					@if ( $post->important === 0 )
						<figure class="zp-wrap-img">
							<img src="{{ !empty(@$post->medias->file_name) ? asset('storage/uploaded/media/'.$post->medias->file_name) : asset('storage/uploaded/media/No_image.png') }}">
					</figure>	
					@endif

					<div class="zp-article-title-wrap m-b-md text-secondary">
						<h3 class="zp-article-title">{{ ucwords($post->title) }}</h3>
					</div>
					<span class="zp-article-meta">
						<span class="text-muted meta-date"><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</span>
					</span>
					<div class="text-secondary zp-article-content">
						{!! $post->description !!}
					</div>
					@if ( $post->important === 0 )
						<div class="zp-article-footer">
							<span><i class="fas fa-tags"></i></span>
							<span class="zp-categories">@foreach ($post->tags as $tag) {{$tag->tag_name}}, @endforeach</span>
						</div>
					@endif
				</div>
				@if ($post->user_id == Auth::id())
					<div class="card-footer">
						<a href="{{ route('post.edit', ['post' => $post->slug]) }}" class=""><i class="far fa-edit text-primary p-1"></i>Edit</a>
					</div>
				@endif
			</div>
		</div>
	</section>
	<!-- Modal -->
	@include('front-modal')	
@endsection
