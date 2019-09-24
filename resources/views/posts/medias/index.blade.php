@extends('layouts.app')
@section('title', '| Media')
@section('medias', 'active')

@section('heading-title')
	<i class="fas fa-photo-video"></i> Media
@endsection
@section('dash-content')
<div class="media-frame zp-core-ui mode-grid hide-menu">
	<div class="media-frame-content" data-columns="11">
		<div class="attachment-browser hide-sidebar">
			<h2 class="media-views-heading sr-only">Attachment List</h2>
			@if ( $medias )
				<ul tabindex="-1" class="attachment ui-media">
					@foreach ($medias as $media)
						@php
							$arr = array(" ", ".", "(", ")", "_", '-');
							$arr2 = array("");
						@endphp
						<li class="attachment-list">
							<div class="attachment-preview type-image landscape">
								<div class="thumbnail" data-toggle="modal" data-target="{{ str_replace($arr, $arr2, '#modal'.$media->file_name) }}">
									<div class="centered">
										<img src="{{ asset('storage/uploaded/media/'.$media->file_name) }}">
									</div>
								</div>
							</div>
						</li>
					@endforeach
				</ul>
			@else
				<p class="no-media">No media files found.</p>
			@endif
		</div>
	</div>
</div>

@forelse ($medias as $m)
	<!-- Large modal -->
	<div id="modal{{ str_replace($arr, $arr2, $m->file_name) }}" class="modal fade media-model zp-core-ui" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog media-dialog">
			<div class="media-modal-content modal-content" role="document">
				<div class="edit-attachment-frame mode-select hide-menu hide-router">
					<div class="edit-media-header">
						<button type="button" class="close media-modal-close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true" class="media-modal-icon">×</span>
						</button>
					</div>
					<div class="media-frame-title">
						<h1 id="myLargeModalLabel">Attachment Details</h1>
					</div>
					<div class="media-frame-content">
						<div class="attachment-details save-ready">
							<div class="attachment-media-view landscape">
								<div class="thumbnail thumbnail-image">
									<img src="{{ !empty(@$m->file_name) ? asset('storage/uploaded/media/'.$m->file_name) : asset('storage/uploaded/media/No_image.png') }}" alt="{{ @$m->file_name }}" class="details-image" itemprop="image">
								</div>
							</div>
							<div class="attachment-info">
								<div class="details">
									<div class="filename"><strong>File name:</strong> {{ $m->file_name }}</div>
									<div class="filename"><strong>File type:</strong> image/jpeg</div>
									<div class="uploaded"><strong>Uploaded on:</strong> September 20, 2019</div>
									<div class="file-size"><strong>File size:</strong> 88 KB</div>
									<div class="dimensions"><strong>Dimensions:</strong> 1000 by 551 pixels</div>
								</div>
								<div class="settings">
									<label class="setting" data-setting="alt">
										<span class="name">Alternative Text</span>
										<input type="text" value="Wind Farm" aria-describedby="alt-text-description">
									</label>
									<div class="setting">
										<span class="name">Uploaded By</span>
										<span class="value">admin</span>
									</div>
									<label class="setting" data-setting="url">
										<span class="name">Copy Link</span>
										<input type="text" value="{{ asset('storage/uploaded/media/'.$m->file_name) }}" readonly="">
									</label>
								</div>
								<div class="actions">
									<form action="{{ route('media.delete', ['media' => $m->id]) }}" method="post">
										@method('DELETE')
										@csrf
										<button id="InsertPhoto" type="submit" class="btn btn-link text-danger">Delete</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@empty
		<div class="col-12 text-center">
			EMPTY
		</div>
@endforelse
@endsection