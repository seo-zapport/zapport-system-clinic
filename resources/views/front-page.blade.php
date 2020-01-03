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
	<section id="importantPost">
		<div class="container">
			<div class="text-center mb-4">
				<h2 class="text-secondary">List of Announcement</h2>
			</div>
			{{ csrf_field() }}
			<div id="listData" class="list-group mb-4"></div>
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
				@foreach ($posts->where('important', 0) as $post)
					<div class="test">
						<div class="card p-2 mx-1">
							<div class="img-wrap">
								<img src="{{ ($post->medias != null) ? asset('storage/uploaded/media/'.$post->medias->file_name) : asset('storage/uploaded/media/No_image.png') }}" class="card-img-top">
							</div>
							<div class="card-body"><!--//344x193-->
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

	<!-- Modal -->
	<div class="modal fade" id="frontModal" tabindex="-1" role="dialog" aria-labelledby="frontModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="frontModalLabel">Important Announcement</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					@foreach ($posts->where('important', 1) as $post)
						@if ($loop->first)
							<div class="post-header">
								<h2 class="post-title">{{ strtoupper($post->title) }}</h2>
								<span class="zp-article-meta"><span class="text-muted meta-date"><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</span>
							</div>
							<div class="post-content">
								{!! $post->description !!}
							</div> 
						@endif
					@endforeach
				</div>
			</div>
		</div>
	</div>
@endsection
