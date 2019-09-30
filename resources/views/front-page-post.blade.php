@extends('layouts.front-page.index')

{{-- @section('front-title',  ucfirst($site_identity->site_title).' | Home') --}}
@section('front-title', ' Zapport | Home')

@section('front-content')
	<section class="zp-article-wrapper">
		<div class="container">
			<div class="card px-0 col-12 col-md-10">
				<div class="card-body">
					{{-- thumbnail --}}
					<figure class="zp-wrap-img">
							<img src="{{ !empty(@$post->medias->file_name) ? asset('storage/uploaded/media/'.$post->medias->file_name) : asset('storage/uploaded/media/No_image.png') }}" class="mx-auto mb-5">
					</figure>

					<div class="zp-article-title-wrap m-b-md text-secondary">
			            <h3 class="zp-article-title">{{ $post->title }}</h3>
					</div>
					<span class="zp-article-meta">
						<span class="text-muted meta-date"><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</span>
					</span>
					<div class="text-secondary zp-article-content">
						{!! $post->description !!}
					</div>					
				</div>
			</div>

		</div>
	</section>
@endsection