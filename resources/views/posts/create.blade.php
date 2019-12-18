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
			<div class="col-12 col-md-9">
				<div class="form-group posts-title">
					<label for="title"><strong>Title</strong></label>
					<input type="text" name="title" class="form-control" value="@yield('postEdit', old('title'))" placeholder="Enter Post Title Here!" required autocomplete="off" pattern="[a-zA-Z0-9\s]+" title="Special Characters are not allowed!">
				</div>
				<div class="form-group posts-description">
					<label for="description"><strong>Post Content</strong></label>
					<textarea name="description" id="description" rows="20" class="form-control" placeholder="Enter Your Content Here!">@yield('postEditDes', old('description'))</textarea>
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
				<br>

				@if (strstr(url()->current(), 'create'))
				<div class="card">
					<div class="card-body">
						<div class="header-title">
							<p><strong>Categories</strong></p>
							<hr>
							<a href="#" class="btn btn-info text-white btn-block mb-2" href="#" data-toggle="modal" data-target="#tagModal">Add Category</a>
						</div>
						<div>
							<select multiple name="tag_id[]" id="tag_id" class="form-control" required oninvalid="this.setCustomValidity('Please Select Category')" oninput="setCustomValidity('')">
								<option value="" selected="true" disabled="disabled"> Select Category </option>
								@forelse ($tags as $tag)
									<option value="{{ $tag->id }}">{{ $tag->tag_name }}</option>
								@empty
									<option disabled="disabled" value=""> Empty </option>
								@endforelse
							</select>
						</div>						
					</div>
				</div>
				@else
					@yield('tagsEdit')
				@endif
				<br>

				{{-- Important --}}
				@if (Gate::check('isAdmin') || Gate::check('isHr'))
					@if (strstr(url()->current(), 'create'))
						<div class="card">
							<div class="card-body">
								<div class="header-title">
									<p><strong>Important</strong></p>
									<hr>
								</div>
								<div class="form-check">
									<input type="checkbox" name="important" value="1" class="form-check-input">Check for Important posts
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
				<div class="card">
					<div class="card-body">
						<div class="header-title">
							<p><strong>Featured Image</strong></p>
							<hr>
							<a href="#" class="btn btn-info text-white btn-block mb-2" href="#" data-toggle="modal" data-target="#featImgModal">Add Featured Image</a>
						</div>
						<div>
							<span id="ftID"></span>
							<figure id="ftimg"></figure>
							<span id="rmvImg" class="btn btn-secondary btn-sm d-none">x</span>
						</div>						
					</div>
				</div>
				@else
					@yield('ftEdit')
				@endif
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
									<form id="addFileForm" enctype="multipart/form-data">
										@csrf
										<input type="file" name="file_name" class="form-control-file" required>
										<small id="errorlog" class="text-muted mb-2 mt-2"></small>
									</form>
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
							<button data-target="#upload" id="InsertPhoto" type="submit" class="btn btn-primary tinymcE">Select</button>
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
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add New Category</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="card">
					<div class="card-body">
						<div class="header-title">
							<p><strong>Categories</strong></p>
							<hr>
						</div>
						<div>
							<form id="tagForm" method="post">
								@csrf
								<input type="text" name="tag" class="form-control" placeholder="Add New Category" required autocomplete="off" pattern="[a-zA-Z0-9\s]+" title="Special Characters are not allowed!">
								<small id="errorlogTag" class="text-muted mt-2"></small>
							<hr>
							<div class="form-group text-center">
								<button class="btn btn-info text-white btn-block" type="submit">Add Category</button>
							</div>	
							</form>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Add -->
<div id="featImgModal" class="modal fade media-model zp-core-ui" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog media-dialog" role="document">
		<div class="media-modal-content modal-content" role="document">
			<button type="button" class="close media-modal-close" data-dismiss="modal" aria-label="Close">
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
									<h2 class="upload-instructions drop-instructions">Drop Files to upload</h2>
									<p class="upload-instructions drop-instructions">or</p>
									<form id="addFileForm2" enctype="multipart/form-data">
										@csrf
										<input type="file" name="file_name" class="form-control-file" required>
										<small id="errorlog2" class="text-muted mb-2 mt-2"></small>
									</form>
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
							<button data-target="#upload2" id="InsertPhoto-upload" type="submit" class="btn btn-primary tinymcE">Select</button>
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
			}else{
				var url = '/posts/edit/tag';
			}
			var tag = $('input[name="tag"]').val();
			console.log(url);
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
	        		$('select[name="tag_id[]"]').append('<option selected="true" value="'+ response.id +'">'+ response.tag_name +'</option>');
	        	},
	        	error: function(response){
	        		document.getElementById("errorlogTag").innerHTML = '';
					if (jQuery.isEmptyObject(response.responseJSON) == false) {
						var errors = response.responseJSON.errors.tag_name;
						errors.forEach(function(i){
						document.getElementById("errorlogTag").innerHTML += i + "<br>";
					});
					}
	        	}
	        });
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
						$("#rmvImg").removeClass('d-none');
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
	       		console.log(response)
	       		if (response.ajaxres == 'success') {
		       		$('#cont-'+response.id).remove();
		       		$('select[name="tag_id[]"]').append('<option value="'+ response.id +'">'+ response.tag_name +'</option>');
	       		}else{
	       			$('#errorTag').append('<div class="alert alert-danger">'+response.lt+'</div>')
	       		}
	       	}
	       });
		});

	});
</script>
@endsection