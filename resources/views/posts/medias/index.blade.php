@extends('layouts.app')
@section('title', '| Media')
@section('medias', 'active')
@section('dash-title', 'Media')
@section('dash-content')
	<div class="row">
		@foreach ($medias as $media)
			<div class="col-md-2">
					@php
						$arr = array(" ", ".", "(", ")", "_", '-');
						$arr2 = array("");
					@endphp
					<img src="{{ asset('storage/uploaded/media/'.$media->file_name) }}" class="img-fluid" data-toggle="modal" data-target="{{ str_replace($arr, $arr2, '#modal'.$media->file_name) }}">
			</div>
		@endforeach

		@forelse ($medias as $m)
			<!-- Large modal -->
			<div id="modal{{ str_replace($arr, $arr2, $m->file_name) }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg post-modal">
					<div class="modal-content">
						<div class="modal-header text-center bg-dark">
							<h4 class="modal-title text-white" id="myLargeModalLabel">{{ $m->file_name }}</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true" class="text-white">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-12">
									<img src="{{ !empty(@$m->file_name) ? asset('storage/uploaded/media/'.$m->file_name) : asset('storage/uploaded/media/No_image.png') }}" alt="{{ @$m->file_name }}" class="img-fluid" itemprop="image">
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<form action="{{ route('media.delete', ['media' => $m->id]) }}" method="post">
								@method('DELETE')
								@csrf
								<button id="InsertPhoto" type="submit" class="btn btn-danger">Delete</button>
							</form>
						</div>
					</div>
				</div>
			</div>
			@empty
				<div class="col-12 text-center">
					EMPTY
				</div>
		@endforelse
	</div>
@endsection