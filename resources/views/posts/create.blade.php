@extends('layouts.app')
@section('title', '| New Post')
@section('new_post', 'active')
@section('heading-title')
	<i class="fas fa-book text-secondary"></i> Add New Post
@endsection
@section('dash-content')
	<form method="post" action="@yield('postAction', route('post.store'))" enctype="multipart/form-data">
		@csrf
		@yield('postMethod')
		<div class="row post-wrap">
			<div class="col-12 col-md-8 col-lg-10">
				<div class="form-group posts-title">
					<label for="title"><strong>Title @error('title') <span class="text-danger">You need to fill this field!</span> @enderror</strong></label>
					<input type="text" name="title" class="form-control @error('title') border border-danger @enderror" value="@yield('postEdit', old('title'))" placeholder="Enter Post Title Here!" required autocomplete="off">
				</div>
				<div class="form-group posts-description">
					<label for="description"><strong>Post Content @error('description') <span class="text-danger">This field is required!</span> @enderror</strong></label>
					<textarea name="description" id="description" rows="20" class="form-control" placeholder="Enter Your Content Here!">@yield('postEditDes', old('description'))</textarea>
				</div>
			</div>
			<div class="col-12 col-md-4 col-lg-2">
				<div class="card mb-3">
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
				<br>

				@if (strstr(url()->current(), 'create'))
				<div class="card mb-3 border @error('tag_id') border-danger @enderror">
					<div class="card-body">
						<div class="header-title">
							<p><strong>Categories @error('tag_id')<span class="text-danger"> Select Category</span>@enderror</strong></p>
							<hr>
							<a href="#" class="btn btn-info text-white btn-block mb-2" href="#" data-toggle="modal" data-target="#tagModal">Add Category</a>
						</div>
						<div id="search-cats-con" class="tag_search_con mb-2 {{ (count($tags) <= 3) ? 'd-none' : '' }}">
							<input type="text" name="search_tag" class="form-control form-control-sm" placeholder="Search for category">
						</div>
						<div id="category_lists" style="height: 12vh; overflow-y: scroll; width: auto;">
							@foreach ($tags as $tag)
								<div class="mb-1">
									<input type="checkbox"  name="tag_id[]" value="{{ $tag->id }}" class="zp-chkbox" id="tag_id_{{ $tag->id }}">
									<label class="form-check-label" for="tag_id_{{ $tag->id }}">{{ $tag->tag_name }}</label>
								</div>
							@endforeach
						</div>						
					</div>
				</div>
				@else
					@yield('tagsEdit')
				@endif
				<br>

				{{-- Important --}}
				@if (Gate::check('isHr') || Gate::check('isAdmin'))
					@if (strstr(url()->current(), 'create'))
						<div class="card mb-3">
							<div class="card-body">
								<div class="header-title">
									<p><strong>Important</strong></p>
									<hr>
								</div>
								<div class="mb-1">
									<input type="checkbox" id="zpImportant" name="important" value="1" class="zp-chkbox">
									<label for="zpImportant"><small class="font-weight-bold">Check for Important posts</small></label>
								</div>						
							</div>
						</div>
					@else
						@yield('importantEdit')
					@endif
					<br>
				@endif

				{{-- Featured Image --}}
				@if (strstr(url()->current(), 'create'))
				<div class="card mb-3">
					<div class="card-body">
						<div class="header-title">
							<p><strong>Featured Image</strong></p>
							<hr>
							<a href="#" class="btn btn-info text-white btn-block mb-2" href="#" data-toggle="modal" data-target="#featImgModal">Add Featured Image</a>
						</div>
						<div class="position-relative">
							<span id="ftID"></span>
							<figure id="ftimg"></figure>
							<span id="rmvImg" class="d-none">x</span>
						</div>						
					</div>
				</div>
				@else
					@yield('ftEdit')
				@endif
			</div>
		</div>
	</form>

<!-- Modal Add -->
<div class="modal fade media-model zp-core-ui" id="newMedia" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog media-dialog" role="document">
		<div class="media-modal-content modal-content" role="document">
			<button id="closeModal" type="button" class="close media-modal-close" data-dismiss="modal" aria-label="Close">
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
									<h2 class="upload-instructions drop-instructions">Drop files to upload</h2>
									<p class="upload-instructions drop-instructions">or</p>
									<form id="addFileForm" enctype="multipart/form-data">
										@csrf
										<div class="col-12 col-md-3 col-lg-3 m-auto">
											{{--  <div class="input-group mb-3">
												<div class="custom-file">
													<input type="file" name="file_name" id="file_name" class="custom-file-input form-control-file" required>
													<label id="file-label" for="file_name" class="custom-file-label">Choose file</label>
												</div>
											</div>  --}}
											<div class="col-12 col-md-3 col-lg-3 m-auto mb-3">
												<div class="custom-file">
													<label id="file-label" for="file_name" class="lbl_upload">Choose file</label>
													<div class="uploader_wrap"><input type="file" name="file_name" id="file_name" class="form-control-file" required></div>
												</div>
												<small id="errorlog" class="text-muted mb-2 mt-2"></small>
											</div>											
										</div>
									</form>
									<span id="slctdFile" class="d-block"></span>
									<p class="upload-instructions drop-instructions text-muted">Maximum upload file size: 20 MB.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="attachment-browser tab-pane fade" id="media" role="tabpanel" aria-labelledby="media-tab">
						<h2 class="media-views-heading sr-only">Attachment List</h2>
						<ul id="allFT" tabindex="-1" class="attachment ui-media">
						@foreach ($employees as $media)
							<li class="attachment-list">
								<div class="attachment-preview type-image landscape">
									<div class="thumbnail" id="ftdimg" data-target="{{ '#modal-'.$media->id }}">
										<div class="centered">
											<img id="slctft" src="{{ asset('storage/uploaded/media/'.$media->file_name) }}">
										</div>
									</div>
								</div>
							</li>
						@endforeach

						</ul>
						<div class="media-sidebar">
							<div class="media-uploader-status">
							<div class="details">
								<div class="filename"><strong>File name:</strong><span id="filename_media"></span></div>
								<div class="filetype"><strong>File type:</strong><span id="filetype_media"></span></div>
								<div class="uploaded"><strong>Uploaded on:</strong><span id="uploaded_date_media"></span></div>
								<div class="file-size"><strong>File size:</strong><span id="filesize_media"></span></div>
								<div class="dimensions"><strong>Dimensions:</strong><span id="dimensions_media"></span></div>
								<div id="ftslctd"></div>
							</div>
							</div>
						</div>
					</div>
				</div>
				<div class="media-frame-toolbar">
					<div class="media-toolbar">
						<div class="media-toolbar-primary search-form">
							<button data-target="#upload" id="InsertPhoto" type="submit" class="btn btn-primary tinymcE">Choose</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Tag -->
<div class="modal fade" id="tagModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header zp-bg-clan">
				<h5 class="modal-title text-white" id="exampleModalLongTitle">Add New Category</h5>
				<button id="tagmodalclose" type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
					<form id="tagForm" method="post">
						@csrf
						<input type="text" name="tag" class="form-control" placeholder="Add New Category" required autocomplete="off">
						<small id="errorlogTag" class="text-danger font-weight-bold mt-2"></small>
					<div class="text-center mt-3">
						<button class="btn btn-info text-white btn-block" type="submit">Add Category</button>
					</div>	
					</form>
			</div>
		</div>
	</div>
</div>

<!-- Modal Add -->
<div id="featImgModal" class="modal fade media-model zp-core-ui" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog media-dialog" role="document">
		<div id="dropArea" class="media-modal-content modal-content" role="document">
			<button id="closeModal2" type="button" class="close media-modal-close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true" class="media-modal-icon">×</span>
			</button>
			<div class="media-frame zp-core-ui hide-menu">
				<div class="media-frame-title">
					<h1>Add Featured Image</h1>
				</div>
				<div class="media-frame-router">
					<ul class="nav nav-tabs media-router" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="upload2-tab" data-toggle="tab" href="#upload2" role="tab" aria-controls="upload2" aria-selected="true">Upload</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="media2-tab" data-toggle="tab" href="#media2" role="tab" aria-controls="media2" aria-selected="false">Media</a>
						</li>
					</ul>						
				</div>
				<div class="media-frame-content tab-content" data-columns="10">
					<div class="tab-pane fade show active" id="upload2" role="tabpanel" aria-labelledby="upload-tab">
						<div class="uploader-inline">
							<div class="uploader-inline-content">
								<div class="upload-ui">
									<h2 class="upload-instructions drop-instructions">Drop files to upload</h2>
									<p class="upload-instructions drop-instructions">or</p>
									<form id="addFileForm2" enctype="multipart/form-data">
										@csrf
										<div class="col-12 col-md-3 col-lg-3 m-auto mb-3">
											<div class="custom-file">
												<label id="file-label2" for="file_name2" class="lbl_upload">Choose file</label>
												<div class="uploader_wrap"><input type="file" name="file_name" id="file_name2" class="form-control-file" required></div>
											</div>
											<small id="errorlog2" class="text-danger mb-2 mt-2"></small>
										</div>
									</form>
									<span id="slctdFile2" class="d-block"></span>
									<p class="upload-instructions drop-instructions text-muted">Maximum upload file size: 20 MB.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="attachment-browser tab-pane fade" id="media2" role="tabpanel" aria-labelledby="media-tab">
						<h2 class="media-views-heading sr-only">Attachment List</h2>
						<ul id="allFT" tabindex="-1" class="attachment ui-media">
						@foreach ($employees as $media)
							<li class="attachment-list">
								<div class="attachment-preview type-image landscape">
									<div class="thumbnail" id="ftdimg" data-target="{{ '#modal-'.$media->id }}">
										<div class="centered">
											<img src="{{ asset('storage/uploaded/media/'.$media->file_name) }}">
										</div>
									</div>
								</div>
							</li>
						@endforeach

						</ul>
						<div class="media-sidebar">
							<div class="media-uploader-status">
							<div class="details">
								<div class="filename"><strong>File name:</strong><span id="filename"></span></div>
								<div class="filetype"><strong>File type:</strong><span id="filetype"></span></div>
								<div class="uploaded"><strong>Uploaded on:</strong><span id="uploaded_date"></span></div>
								<div class="file-size"><strong>File size:</strong><span id="filesize"></span></div>
								<div class="dimensions"><strong>Dimensions:</strong><span id="dimensions"></span></div>
							</div>
							</div>
						</div>
					</div>
				</div>
				<div class="media-frame-toolbar">
					<div class="media-toolbar">
						<div class="media-toolbar-primary search-form">
							<button data-target="#upload2" id="InsertPhoto-upload" type="submit" class="btn btn-primary tinymcE h-35">Select</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script type="application/javascript">
	$(document).ready(function(){

		$("input[name='search_tag']").on('keyup', function(){
			var query = $(this).val();
			var loc = location.href;
			var hostname = window.location.hostname;
			if (loc === "http://"+hostname+"/posts/create") {
				var url = '/category/search/';
				// CREATE BLADE
				if (query != ''){
					$.ajax({
						type: 'GET',
						url: url+query,
						data: {'tag':query},
						success: function(response){
							document.getElementById("category_lists").innerHTML = response;
						},
					});
				}else{
					$.ajax({
						type: 'GET',
						url : url,
						success: function(response){
							document.getElementById("category_lists").innerHTML = response;
						}
					});
				}
			}else{
				// Edit Blade
				var url = '/category/search/edit/';
				var tag_old = [];
				$("input[name='tag_old']").each(function(){
					tag_old.push($(this).val());
				});
				if (query != ''){
					$.ajax({
						type: 'GET',
						url: url+query,
						data: {
							'tag':query,
							'tag_old':tag_old,
						},
						success: function(response){
							document.getElementById("category_lists_edit").innerHTML = response;
						},
					});
				}else{
					$.ajax({
						type: 'GET',
						url : url+'tag_old/'+tag_old,
						data: {
							'tag_old':tag_old,
						},
						success: function(response){
							document.getElementById("category_lists_edit").innerHTML = response;
						}
					});
				}
			}
		});

		$("#closeModal").on('click', function(e){
			e.preventDefault();
			_("file-label").innerHTML = 'Choose file';
			_('slctdFile').innerHTML = '';
			_("errorlog").innerHTML = '';
		});

		$("#addFileForm input[name='file_name']").on('change', function(e){
			e.preventDefault();
			var file = e.target.files[0].name;
			_('slctdFile').innerHTML = file;
		});

	// ______________________________________

		$("#closeModal2").on('click', function(e){
			e.preventDefault();
			_("file-label2").innerHTML = 'Choose file';
			_("slctdFile2").innerHTML = '';
			_("errorlog2").innerHTML = '';
		});

		$("#addFileForm2 input[name='file_name']").on('change', function(e){
			e.preventDefault();
			var file = e.target.files[0].name;
			_("slctdFile2").innerHTML = file;
		});

		$('#addFileForm').on('submit', function(e){
			e.preventDefault();
			var btn = $('#InsertPhoto');
			var loc = location.href;
			var hostname = window.location.hostname;
			if (loc === "http://"+hostname+"/posts/create") {
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
					console.log(response);
					var path = '{{ asset('storage/uploaded/media/') }}';
					tinymce.activeEditor.insertContent('<img alt="'+ response.file_name +'" class="img-fluid" src="' + path + "/" + response.file_name + '"/>');
					$('#addFileForm')[0].reset();
					$("#newMedia").modal('hide');
					$('#allFT').append('<li class="attachment-list"><div class="attachment-preview type-image landscape"><div class="thumbnail" id="ftdimg" data-target="'+'#modal-'+response.id+'><div class="centered"><img alt="'+ response.file_name +'" class="img-fluid" src="' + path + "/" + response.file_name + '"/></div></div></div></li>');
					$('#featImgModal #allFT').append('<li class="attachment-list"><div class="attachment-preview type-image landscape"><div class="thumbnail" id="ftdimg" data-target="'+'#modal-'+response.id+'><div class="centered"><img alt="'+ response.file_name +'" class="img-fluid" src="' + path + "/" + response.file_name + '"/></div></div></div></li>');
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

		$('#tagForm').on('submit', function(e){
			e.preventDefault();
			loc2 = location.href;
			var hostname = window.location.hostname;
			if (loc2 === "http://"+hostname+"/posts/create") {
				var url = 'create/tag';
				var list = $("#category_lists");
			}else{
				var url = '/posts/edit/tag';
				var list = $("#category_lists_edit");
			}
			var tag = $('input[name="tag"]').val();
					$.ajaxSetup({
							headers: {
									'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
					});
					$.ajax({
						type: 'POST',
						url: url,
						data: {tag_name:tag},
						dataType: 'json',
						success: function(response){
							$('#tagForm')[0].reset();
							$("#tagModal").modal('hide');
							list.prepend('<div class="mb-1"><input type="checkbox" checked name="tag_id[]" value="'+response.id+'" class="zp-chkbox" id="tag_id_'+response.id+'"><label class="form-check-label" for="tag_id_'+response.id+'">'+response.tag_name+'</label></div>')
					if ($('input[name="tag"]').hasClass('border border-danger'))
					{
						$('input[name="tag"]').removeClass('border border-danger')
						document.getElementById("errorlogTag").innerHTML = ''
					}
					var chkbx = list.find('input[type="checkbox"]').length;
					console.log(chkbx);
					if (chkbx > 3){
						$("#search-cats-con").removeClass('d-none');
					}else{
						$("#search-cats-con").addClass('d-none');
					}
						},
						error: function(response){
							document.getElementById("errorlogTag").innerHTML = '';
					if (jQuery.isEmptyObject(response.responseJSON) == false) {
						var errors = response.responseJSON.errors.tag_name;
						errors.forEach(function(i){
						document.getElementById("errorlogTag").innerHTML += i + "<br>";
						$('input[name="tag"]').addClass('border border-danger');
					});
					}
						}
					});
		});

		$("#tagmodalclose").on('click', function(e){
			e.preventDefault();
			$('#tagForm')[0].reset();
			if ($('input[name="tag"]').hasClass('border border-danger'))
			{
				$('input[name="tag"]').removeClass('border border-danger')
				document.getElementById("errorlogTag").innerHTML = ''
			}
		});

	// _____________________________________________________________________________________________________

			$("#featImgModal").on('click', '#ftdimg', function(event) {
				event.preventDefault();
				var ft_id = $(this).attr('data-target');
				var strs = '';
				selectMedia(ft_id, strs);
			});

			// Upload Feat Img
			$("#featImgModal").on('click', '#upload2-tab', function(event) {
				$('.tinymcE').attr('data-target', '#upload2');
				$('.tinymcE').attr('id', 'InsertPhoto-upload');
			});

			// Media Feat Img
			$("#featImgModal").on('click', '#media2-tab', function(event) {
				$('.tinymcE').attr('data-target', '#media2');
				$('.tinymcE').attr('id', 'InsertPhoto-media');
			});

			$("#featImgModal").on('click', '#InsertPhoto-media', function(event) {
				$('#featImgModal').modal('hide');
			});

			$("#featImgModal").on('click', '#InsertPhoto-upload', function(event) {
				var uploadsel = $(this).attr('data-target');
				if(uploadsel == "#upload2"){
					$('#addFileForm2').submit();
					console.log('triggered')
				}
				_('slctdFile2').innerHTML = '';
			});

			// Upload on Media Feat Img
			$('#addFileForm2').on('submit', function(e){
				e.preventDefault();
				var btn = $('#InsertPhoto-upload');
				var loc = location.href;
				var hostname = window.location.hostname;
				if (loc === "http://"+hostname+"/posts/create") {
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
				document.getElementById("ftimg").innerHTML = '';
				document.getElementById("ftID").innerHTML = '';
				$.ajax({
					type: 'POST',
					url: url,
					data: new FormData($("#addFileForm2")[0]),
					dataType: 'json',
					cache: false,
					processData: false,
					contentType: false,
					mimeType:"multipart/form-data",
					success: function(response){
						console.log(response);
						var path = '{{ asset('storage/uploaded/media/') }}';
						$('#addFileForm2')[0].reset();
						$("#featImgModal").modal('hide');
						$('#allFT').append('<li class="attachment-list"><div class="attachment-preview type-image landscape"><div class="thumbnail" id="ftdimg" data-target="'+'#modal-'+response.id+'><div class="centered"><img alt="'+ response.file_name +'" class="img-fluid" src="' + path + "/" + response.file_name + '"/></div></div></div></li>');
						$('#featImgModal #allFT').append('<li class="attachment-list"><div class="attachment-preview type-image landscape"><div class="thumbnail" id="ftdimg" data-target="'+'#modal-'+response.id+'><div class="centered"><img alt="'+ response.file_name +'" class="img-fluid" src="' + path + "/" + response.file_name + '"/></div></div></div></li>');
							$('#ftimg').append('<img alt="'+ response["file_name"] +'" class="img-fluid" src="' + path + "/" + response["file_name"] + '"/>');
							$('#ftID').append('<input name="media_id" type="hidden" value="'+ response["id"] +'">');
							$("#rmvImg").removeClass('d-none');
					},
					error: function(response){
						console.log(response) 
						$('#addFileForm2')[0].reset();
						document.getElementById("errorlog2").innerHTML = '';

						var customError = response.responseJSON.errors2;
						if (jQuery.isEmptyObject(customError) === false) {
							// console.log(customError);
							document.getElementById("errorlog2").innerHTML += customError + "<br>";
							$("#rmvImg").addClass('d-none');
						}
						if (jQuery.isEmptyObject(response.responseJSON.errors) === false) {
							var errors = response.responseJSON.errors.file_name;
							errors.forEach(function(i){
							document.getElementById("errorlog2").innerHTML += i + "<br>";
							$("#rmvImg").addClass('d-none');
						});
						}
					}
				});

			});

	// _____________________________________________________________________________________________________

		$("#rmvImg").click(function(event) {
			document.getElementById("ftimg").innerHTML = '';
			document.getElementById("ftID").innerHTML = '';
			$("#rmvImg").addClass('d-none');
		});

		// Upload
		$("#newMedia").on('click', '#upload-tab', function(event) {
			$('.tinymcE').attr('data-target', '#upload');
		});

		$("#newMedia").on('click', '#InsertPhoto', function(event) {
			var uploadsel = $(this).attr('data-target');
			if(uploadsel == "#upload"){
				$('#addFileForm').submit();
				console.log('triggered')
			}
			_('slctdFile').innerHTML = '';

		});


		$("#newMedia").on('click', '#ftdimg', function(event) {
			event.preventDefault();
			var ft_id = $(this).attr('data-target');
			var strs = '_media';
			selectMedia(ft_id, strs);
		});

		$(function () {
				$("#newMedia").on('click', '#InsertPhoto', function(event) {
					var uploadsel = $(this).attr('data-target');
					if(uploadsel === "#media"){
						var sr = $('input[name="str_slct"]').val();
						console.log(sr);
						tinymce.activeEditor.insertContent('<img class="img-fluid" src="' + sr + '"/>');
						$("#newMedia").modal("hide");
					}
				});
		});

		// Media
		$("#newMedia").on('click', '#media-tab', function(event) {
			$('.tinymcE').attr('data-target', '#media');
		});

		function selectMedia(ft_id, strs)
		{
			console.log(ft_id);
			var loc3 = location.href;
			// var ft_id = $('#ftdimg').attr('data-target');
			var hostname = window.location.hostname;

			if (loc3 === "http://"+hostname+"/posts/create") {
				var url = 'create/featured/'+ft_id.replace('#modal-', '');
			}else{
				var url = '/posts/edit/featured/'+ft_id.replace('#modal-', '');
			}
			// console.log(ft_id.replace('#modal-', ''));
			if (strs == '') {
				document.getElementById("filename").innerHTML = '';
				document.getElementById("filetype").innerHTML = '';
				document.getElementById("uploaded_date").innerHTML = '';
				document.getElementById("filesize").innerHTML = '';
				document.getElementById("dimensions").innerHTML = '';
				document.getElementById("ftimg").innerHTML = '';
				document.getElementById("ftID").innerHTML = '';
			}else{
				document.getElementById("filename_media").innerHTML = '';
				document.getElementById("filetype_media").innerHTML = '';
				document.getElementById("uploaded_date_media").innerHTML = '';
				document.getElementById("filesize_media").innerHTML = '';
				document.getElementById("dimensions_media").innerHTML = '';
				document.getElementById("ftslctd").innerHTML = '';
				// document.getElementById("ftimg_media").innerHTML = '';
				// document.getElementById("ftID_media").innerHTML = '';
			}
			$.ajax({
				type: 'GET',
				url: url,
				dataType : "json",
				success: function(response)
				{
					console.log(response);
					$('#filename'+strs).append(' '+response["file_name"]);
					$('#filetype'+strs).append(' '+response["fileType"]);
					$('#uploaded_date'+strs).append(' '+response["created_at"]);
					$('#filesize'+strs).append(' '+response["filesize"]);
					$('#dimensions'+strs).append(' '+response["dimension"]);
				var path = '{{ asset('storage/uploaded/media/') }}';
				$('#ftimg'+strs).append('<img alt="'+ response["file_name"] +'" class="img-fluid" src="' + path + "/" + response["file_name"] + '"/>');
				$('#ftID'+strs).append('<input name="media_id" type="hidden" value="'+ response["id"] +'">');
				$('#ftslctd').append('<input name="str_slct" type="hidden" value="'+ path + "/" + response["file_name"] +'">');
				if (strs == '') {
					$("#rmvImg").removeClass('d-none');
				}
				},
				error:function(response)
				{
					console.log(response);
				}
			});
		}

		$("#rmvTags").on('click', '#delTag', function(event) {
			var rmvID = $(this).attr('data-target');
			var pID = $(this).find('#postID').val();
			// console.log(pID);
				$.ajaxSetup({
							headers: {
									'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							},
					});
				$.ajax({
					type: 'POST',
					url: '/posts/'+pID+'/tags/'+rmvID,
					dataType: 'json',
					data: {
						'id': rmvID,
						"_method": 'DELETE'
					},
					success:function(response){
						if (response.ajaxres == 'success') {
							$('#cont-'+response.id).remove();
							$("#category_lists_edit").append('<div class="mb-1"><input type="checkbox"  name="tag_id[]" value="'+response.id+'" class="zp-chkbox" id="tag_id_'+response.id+'"><label class="form-check-label" for="tag_id_'+response.id+'">'+response.tag_name+'</label></div>')
						}else{
							document.getElementById('errorTag').innerHTML = '';
							$('#errorTag').append('<div class="alert alert-danger">'+response.lt+'</div>')
						}
					}
				});
		});
		
		//drp
		let dropArea = _('newMedia');
		let file_name = _('file_name');

		{{--  let dropArea2 = _('featImgModal');
		let file_name2 = _('file_name2');  --}}

		function dropCall(id, input, uploadClass, selectSpan){
			let dropArea = _(id);
			let file_name = _(input);
			let upClass = _(uploadClass);
			let slctdFile = selectSpan;

			dropArea.classList.add('has-advance-upload');
			
			dropArea.addEventListener('drop', function(e){ handlerDrop(file_name, slctdFile, e) }, false);

			['dragenter','dragleave','dragover','drop'].forEach( eventName => {
				dropArea.addEventListener(eventName, preventDefaults, false);
			});

			['dragenter', 'dragover'].forEach( eventName => {
					dropArea.addEventListener(eventName, function(e){ highlight(upClass, e) }, false);
			});

			['dragleave', 'drop'].forEach( eventName => {
					dropArea.addEventListener(eventName, function(e){ unhighlight(upClass, e) }, false);
			});

			dropArea.addEventListener('dragenter', function(e){ highlight(upClass, e) }, false);
			dropArea.addEventListener('dragleave', function(e){ unhighlight(upClass, e) }, false);
			dropArea.addEventListener('dragover', function(e){ highlight(upClass, e) }, false);
			dropArea.addEventListener('drop', function(e){ unhighlight(upClass, e) }, false);
		}
		
    function preventDefaults(e){
      e.preventDefault();
      e.stopPropagation();
    }

		function highlight(highlightId, e){
			highlightId.classList.add('highlight');
		}

		function unhighlight(unhighlightId, e){
			unhighlightId.classList.remove('highlight');
		}

		dropArea.ondragover = dropArea.ondragenter = function (evt){
			evt.preventDefault();
		}

		function handlerDrop(file_name, file_selectd, e){
				file_name.files = e.dataTransfer.files;
				files = e.dataTransfer.files;
				_(file_selectd).innerHTML = '';
				console.log(file_name.files[0].name);
				$("#" + file_selectd).append(file_name.files[0].name);
				e.preventDefault();
		}

		dropCall('featImgModal', 'file_name2', 'upload2','slctdFile2');

		//tinyMCE
		dropCall('newMedia', 'file_name', 'upload','slctdFile');
		
	});
</script>
@endsection