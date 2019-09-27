@extends('layouts.app')
@section('title', '| New Post')

@section('heading-title')
	<i class="fas fa-book"></i> New Posts
@endsection
@section('dash-content')
{{-- {{ phpinfo() }} --}}
	<form method="post" action="@yield('postAction', route('post.store'))" enctype="multipart/form-data">
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
				@if (strstr(url()->current(), 'create'))
				<div class="card">
					<div class="card-body">
						<div class="header-title">
							<p><strong>Categories</strong></p>
							<hr>
							<a href="#" class="btn btn-info text-white btn-block mb-2" href="#" data-toggle="modal" data-target="#tagModal">Add Category</a>
						</div>
						<div>
							<select name="tag_id" id="tag_id" class="form-control" required oninvalid="this.setCustomValidity('Please Select Category')" oninput="setCustomValidity('')">
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
				<br>
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
{{-- 	@if (strstr(url()->current(), 'create'))
	<div class="col-12 offset-md-1 col-md-2">
		<div class="card">
			<div class="card-body">
				<div class="header-title">
					<p><strong>Tags</strong></p>
					<hr>
				</div>
				<div>
					<form id="tagForm" method="post" action="{{ route('add.tag') }}">
						@csrf
						<input type="text" name="tag" class="form-control" placeholder="Add New Tags">
						<small id="errorlogTag" class="text-muted mt-2"></small>
					<hr>
					<div class="form-group text-center">
						<button class="btn btn-info text-white btn-block" type="submit">Add Tag</button>
					</div>	
					</form>
				</div>						
			</div>
		</div>
	</div>
	@endif --}}

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
{{-- 							<form id="addFileForm" enctype="multipart/form-data">
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
							<ul id="allFT" tabindex="-1" class="attachment ui-media">
{{-- 								<form id="addFileForm" enctype="multipart/form-data" method="post">
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
								</form> --}}

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
							<form id="tagForm" method="post" action="{{ route('add.tag') }}">
								@csrf
								<input type="text" name="tag" class="form-control" placeholder="Add New Category">
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

	<!-- Large modal -->
	<div id="featImgModal" class="modal fade media-model zp-core-ui" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog media-dialog">
			<div class="media-modal-content modal-content" role="document">
				<div class="edit-attachment-frame mode-select hide-menu hide-router">
					<div class="edit-media-header">
						<button type="button" class="close media-modal-close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true" class="media-modal-icon">×</span>
						</button>
					</div>
					<div class="media-frame-title">
						<h1 id="myLargeModalLabel">Select Featured Image</h1>
					</div>
					<div class="media-frame-content">
						<div class="attachment-details save-ready">
							<div class="attachment-media-view landscape">
								<div class="thumbnail thumbnail-image">
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
								</div>
							</div>
							<div class="attachment-info">
								<div class="details">
									<div class="filename"><strong>File name:</strong><span id="filename"></span></div>
									<div class="filetype"><strong>File type:</strong><span id="filetype"></span></div>
									<div class="uploaded"><strong>Uploaded on:</strong><span id="uploaded_date"></span></div>
									<div class="file-size"><strong>File size:</strong><span id="filesize"></span></div>
									<div class="dimensions"><strong>Dimensions:</strong><span id="dimensions"></span></div>
								</div>
									{{--  --}}
								<div class="actions">
									<button class="btn btn-info" data-dismiss="modal" aria-label="Close">insert</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 text-center">
			</div>
		</div>
	</div>


	<script type="application/javascript">
		$(document).ready(function(){
			var count = 0;
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
				// count = $('#imgs').length;
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
						// count += 1;
						// if (count == 1) {
						// 	$('.posts-title').append('<input id="imgs" type="hidden" name="media_id" value="'+ response.id +'">');
						// }else{
						// 	$('.posts-title').append('<input id="imgs" type="hidden" value="'+ response.id +'">');
						// }
						// console.log(count);
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
				var tag = $('input[name="tag"]').val();
		       $.ajaxSetup({
		            headers: {
		                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		            },
		        });
		        $.ajax({
		        	type: 'POST',
		        	url: 'create/tag',
		        	data: {tag_name:tag},
		        	dataType: 'json',
		        	success: function(response){
		        		$('#tagForm')[0].reset();
		        		$("#tagModal").modal('hide');
		        		$('select[name="tag_id"]').append('<option value="'+ response.id +'">'+ response.tag_name +'</option>');
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

			$("#featImgModal").on('click', '#ftdimg', function(event) {
			  event.preventDefault();
			  var ft_id = $(this).attr('data-target');
			  var strs = '';
			  selectMedia(ft_id, strs);
			  // var loc3 = location.href;
			  // var ft_id = $(this).attr('data-target');
			  // if (loc3 === 'http://clinic/posts/create') {
				 //  var url = 'create/featured/';
			  // }else{
				 //  var url = '/posts/edit/featured/';
			  // }
			  // console.log(ft_id.replace('#modal-', ''));
			  // document.getElementById("filename").innerHTML = '';
			  // document.getElementById("filetype").innerHTML = '';
			  // document.getElementById("uploaded_date").innerHTML = '';
			  // document.getElementById("filesize").innerHTML = '';
			  // document.getElementById("dimensions").innerHTML = '';
			  // document.getElementById("ftimg").innerHTML = '';
			  // document.getElementById("ftID").innerHTML = '';
			  // $.ajax({
			  //   type: 'GET',
			  //   url: url+ft_id.replace('#modal-', ''),
			  //   dataType : "json",
			  //   success: function(response)
			  //   {
			  //     console.log(response);
			  //     $('#filename').append(' '+response["file_name"]);
			  //     $('#filetype').append(' '+response["fileType"]);
			  //     $('#uploaded_date').append(' '+response["created_at"]);
			  //     $('#filesize').append(' '+response["filesize"]);
			  //     $('#dimensions').append(' '+response["dimension"]);
				 //  var path = ' asset('storage/uploaded/media/') ';
				 //  $('#ftimg').append('<img alt="'+ response["file_name"] +'" class="img-fluid" src="' + path + "/" + response["file_name"] + '"/>');
				 //  $('#ftID').append('<input name="media_id" type="hidden" value="'+ response["id"] +'">');
				 //  $("#rmvImg").removeClass('d-none');
			  //   },
			  //   error:function(response)
			  //   {
			  //   	console.log(response);
			  //   }
			  // });
			});

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
			  if (loc3 === 'http://clinic/posts/create') {
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

		});
	</script>

@endsection