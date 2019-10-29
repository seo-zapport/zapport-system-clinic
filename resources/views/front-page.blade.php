@extends('layouts.front-page.index')

{{-- @section('front-title',  ucfirst($site_identity->site_title).' | Home') --}}
@section('front-title', ' Zapport | Home')

@section('front-content')
	<section id="hero" class="text-center my-5 overlay">
		<div class="container z-index-1">
			<img src="{{ asset('images/zapport logo.png') }}" class="mx-auto mb-5">
			@guest()
			<div class="pt-5">
				<a href="{{ route('login') }}" class="btn btn-custom-trans">Login</a>		
			</div>
			@endguest
		</div>
	</section>
	<section id="clinic">
		<div class="container">
			<div class="title text-center text-secondary">
	            @php
	                $i = 1;
	                $outopen = "Closed";
	                $outopenClass = "danger";
	            @endphp
	            @foreach ($users as $user)
	                @if ($user->isOnline())
	            		@foreach ($user->roles as $role)
	                    @php 
	                    $attendant[] = $role->role;
	                    $outopen = "Open";
	                	$outopenClass = "success"; 
	                	@endphp
	                    @break
	            		@endforeach
	                @endif
	            @endforeach
	            <i class='fas fa-clinic-medical'></i> Clinic is <span class="text-{{ $outopenClass }}">{{ $outopen }}</span>
	            <hr>
			</div>
			<div class="text-center text-secondary">
	            @if (@$attendant)
		            @foreach (@$attendant as $in)
		            @if (count(@$attendant) == 1 && @$in == 'doctor')
		            	<p class="display-4 text-muted"><i class="fas fa-user-md"></i> {{ ucfirst(@$in) }} is In!</p>
		            @elseif (count(@$attendant) == 1 && @$in == 'nurse')
		            	<p class="display-4 text-muted"><i class="fas fa-user-nurse"></i> {{ ucfirst(@$in) }} is In!</p>
		            @elseif (count(@$attendant) == 2 && @$in == 'doctor')
		            	<p class="display-4 text-muted"><i class="fas fa-user-md"></i> {{ ucfirst(@$in) }} is In!</p>
		            @endif
		            @endforeach
	            @endif
			</div>
			
		</div>
	</section>
	<section id="post">
		<div class="container">
			<div class="slick-posts">
				@foreach ($posts as $post)
					<div>
						<div class="card p-2 mx-1">
							<img src="{{ ($post->medias != null) ? asset('storage/uploaded/media/'.$post->medias->file_name) : asset('storage/uploaded/media/No_image.png') }}" class="card-img-top">
							<div class="card-body">
								<a href="{{ route('frnt.show.post', ['post' => $post->slug]) }}">
									<h5 class="card-title">{{ $post->title }}</h5>
								</a>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</section>
@endsection