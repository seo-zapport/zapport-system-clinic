@extends('layouts.front-page.index')

{{-- @section('front-title',  ucfirst($site_identity->site_title).' | Home') --}}
@section('front-title', ' Zapport | Home')

@section('front-content')
	<section id="hero" class="text-center my-5 overlay">
		<div class="container z-index-1">
			<img src="{{ asset('images/zapport logo.png') }}" class="mx-auto mb-5">
			<div class="pt-5">
				<button class="btn btn-custom-trans"><a href="{{ route('login') }}">Login</a></button>		
			</div>
		</div>
	</section>
	<section id="clinic">
		<div class="container">
			<div class="title m-b-md text-center h3 text-secondary">
	            @php
	                $i = 1;
	                $outopen = "Closed";
	                $outopenClass = "danger";
	            @endphp
	            @foreach ($users as $user)
	                @if ($user->isOnline())
	                    @php $outopen = "Open";
	                	$outopenClass = "success"; @endphp
	                    @break
	                @endif
	            @endforeach
	            <i class='fas fa-clinic-medical'></i> Clinic is <span class="text-{{ $outopenClass }}">{{ $outopen }}</span>
			</div>
			
		</div>
	</section>
	<section id="post">
		<div class="container">
			<div class="slick-posts">
				@foreach ($posts as $post)
					<div>
						<div class="card p-2 mx-1">
							{!! $post->description !!}
							{{-- <img src="{{ asset('storage/uploaded/media/'.$post->medias->file_name) }}" class="card-img-top"> --}}
							<div class="card-body">
								<h5 class="card-title">{{ $post->title }}</h5>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</section>
@endsection