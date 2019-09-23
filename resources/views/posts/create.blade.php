@extends('layouts.app')
@section('title', '| New Post')
@section('new_post', 'active')
{{-- @section('dash-title', 'New Post') --}}
@section('heading-title')
	<i class="fas fa-book"></i> New Posts
@endsection
@section('dash-content')
{{-- {{ phpinfo() }} --}}
	<form method="post" action="@yield('postAction', route('post.store'))">
		@csrf
		@yield('postMethod')
		<div class="row post-wrap">
			<div class="col-12 col-md-9">
				<div class="form-group posts-title">
					<label for="title"><strong>Title</strong></label>
					<input type="text" name="title" class="form-control" value="@yield('postEdit')" placeholder="Enter Post Title Here!" required>
				</div>
				<div class="form-group posts-description">
					<label for="description"><strong>Post description</strong></label>
					<textarea name="description" id="description" rows="20" class="form-control" placeholder="Enter Your Content Here!">@yield('postEditDes')</textarea>
				</div>
			</div>
			<div class="col-12 offset-md-1 col-md-2">
				<div class="card">
					<div class="card-body">
						<div class="header-title">
							<p><strong>Publish</strong></p>
							<hr>
						</div>
						<div class="form-group text-center">
							<button class="btn btn-info text-white btn-block" type="submit">Submit</button>
						</div>							
					</div>
				</div>

			</div>
		</div>
	</form>

@include('layouts.errors')

	<!-- Modal Add -->
	<div class="modal fade media-model zp-core-ui" id="newMedia" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog media-dialog" role="document">
			<div class="media-modal-content modal-content" role="document">
				<button type="button" class="close media-modal-close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="media-modal-icon">×</span>
				</button>
				<div class="media-frame zp-core-ui hide-menu">
					<div class="media-frame-title">
						<h1>Attachment Details</h1>
					</div>
					<div class="media-frame-router">
						<ul class="nav nav-tabs media-router" id="myTab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="upload-tab" data-toggle="tab" href="#upload" role="tab" aria-controls="upload" aria-selected="true">Upload</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="media-tab" data-toggle="tab" href="#media" role="tab" aria-controls="media" aria-selected="false">Media</a>
							</li>
						</ul>						
					</div>
					<div class="media-frame-content tab-content" data-columns="10">
						<div class="tab-pane fade show active" id="upload" role="tabpanel" aria-labelledby="upload-tab">
							<div class="uploader-inline">
								<div class="uploader-inline-content">
									<div class="upload-ui">
										<h2 class="upload-instructions drop-instructions">Drop Files to upload</h2>
										<p class="upload-instructions drop-instructions">or</p>
										{{-- <button type="button" class="btn btn-light btn-custom">Select Files</button> --}}
										<input type="file" name="file_name" class="form-control-file" required>
									</div>
								</div>
							</div>
							{{-- <form id="addFileForm" enctype="multipart/form-data">
								@csrf
								<div class="mt-5 mb-5">
									<input type="file" name="file_name" class="form-control-file" required>
								</div>
									<small id="errorlog" class="text-muted"></small>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button id="InsertPhoto" type="submit" class="btn btn-primary">Save changes</button>
								</div>
							</form> --}}
						</div>
						<div class="attachment-browser tab-pane fade" id="media" role="tabpanel" aria-labelledby="media-tab">
							<h2 class="media-views-heading sr-only">Attachment List</h2>
							<ul tabindex="-1" class="attachment ui-media">
								<form id="addFileForm" enctype="multipart/form-data" method="post">
									@method('DELETE')
									@csrf
									@forelse ($employees as $pics)
										<li class="attachment-list">
											<div class="attachment-preview type-image landscape">
												<div class="thumbnail">
													<div id="edit_id" class="centered" data-id="{{ $pics->id }}" data-toggle="modal" data-target="#Media">
														<img id="edit_id" src="{{ asset('storage/uploaded/media/'.$pics->file_name) }}" class="img-fluid d-inline-flex">
													</div>
												</div>
											</div>
										</li>
									@empty
										<p class="no-media">No media files found.</p>
									@endforelse
								</form>
							</ul>
							<div class="media-sidebar">
								<div class="media-uploader-status">
									details here.....
								</div>
							</div>
						</div>
					</div>
					<div class="media-frame-toolbar">
						<div class="media-toolbar">
							<div class="media-toolbar-primary search-form">
								<button class="btn btn-primary">Select</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="application/javascript">
		$(document).ready(function(){
			$('#addFileForm').on('submit', function(e){
				e.preventDefault();
				var btn = $('#InsertPhoto');
				var loc = location.href;
				if (loc === 'http://clinic/posts/create') {
					var url = 'create/media';
				}else{
					var url = 'edit/media';
				}
				btn.prop('disabled', true);
           		setTimeout(function(){btn.prop('disabled', false); }, 3000);
		       $.ajaxSetup({
		            headers: {
		                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		            },
		        });
				$.ajax({
					type: 'POST',
					url: url,
					data: new FormData($("#addFileForm")[0]),
					dataType: 'json',
					cache: false,
					processData: false,
					contentType: false,
					mimeType:"multipart/form-data",
					success: function(response){
						var path = '{{ asset('storage/uploaded/media/') }}';
						tinymce.activeEditor.insertContent('<img alt="'+ response.file_name +'" class="img-fluid" src="' + path + "/" + response.file_name + '"/>');
						$('#addFileForm')[0].reset();
						$("#newMedia").modal('hide');
					},
					error: function(response){
						console.log(response) 
						$('#addFileForm')[0].reset();
						document.getElementById("errorlog").innerHTML = '';

						var customError = response.responseJSON.errors2;
						if (jQuery.isEmptyObject(customError) === false) {
							// console.log(customError);
							document.getElementById("errorlog").innerHTML += customError + "<br>";
						}
						if (jQuery.isEmptyObject(response.responseJSON.errors) === false) {
							var errors = response.responseJSON.errors.file_name;
							errors.forEach(function(i){
							document.getElementById("errorlog").innerHTML += i + "<br>";
						});
						}
					}
				});

			});

		});
	</script>

@endsection