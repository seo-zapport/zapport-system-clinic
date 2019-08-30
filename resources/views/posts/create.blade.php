@extends('layouts.app')
@section('title', '| New Post')
@section('new_post', 'active')
@section('dash-title', 'New Post')
@section('dash-content')

	<form method="post" action="@yield('postAction', route('post.store'))">
		@csrf
		@yield('postMethod')
		<div class="form-group">
			<label for="title">Title</label>
			<input type="text" name="title" class="form-control" value="@yield('postEdit')" placeholder="Enter Post Title Here!" required>
		</div>
		<div class="form-group">
			<label for="description">Post description</label>
			<textarea name="description" id="description" rows="20" class="form-control" placeholder="Enter Your Content Here!" required>@yield('postEditDes')</textarea>
		</div>
		<div class="form-group">
			<button class="btn btn-info" type="submit">Submit</button>
		</div>
	</form>

@include('layouts.errors')

	<!-- Modal Add -->
	<div class="modal fade bd-example-modal-lg" id="newMedia" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Media</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<ul class="nav nav-tabs ml-0" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="upload-tab" data-toggle="tab" href="#upload" role="tab" aria-controls="upload" aria-selected="true">Upload</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="media-tab" data-toggle="tab" href="#media" role="tab" aria-controls="media" aria-selected="false">Media</a>
						</li>
					</ul>
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="upload" role="tabpanel" aria-labelledby="upload-tab">
							<form id="addFileForm" enctype="multipart/form-data" method="post">
								@csrf
								<div class="mt-5 mb-5">
									<input type="file" name="file_name" class="form-control-file" required>
								</div>
									<small id="errorlog" class="text-muted"></small>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button id="InsertPhoto" type="submit" class="btn btn-primary">Save changes</button>
								</div>
							</form>
						</div>
						<div class="tab-pane fade" id="media" role="tabpanel" aria-labelledby="media-tab">
							<form id="addFileForm" enctype="multipart/form-data" method="post">
								@method('DELETE')
								@csrf
								<div class="row">
									@forelse ($employees as $pics)
										<div id="img_cont" class="btn btn-link text-info col-3" data-id="{{ $pics->id }}" data-toggle="modal" data-target="#Media">
											<img id="edit_id" src="{{ asset('storage/uploaded/media/'.$pics->file_name) }}" alt="" class="img-fluid d-inline-flex">
										</div>
										@empty
											<div class="p-5 text-center">No Image Yet!</div>
									@endforelse
								</div>
							</form>
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
				btn.prop('disabled', true);
           		setTimeout(function(){btn.prop('disabled', false); }, 3000);
		       $.ajaxSetup({
		            headers: {
		                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		            },
		        });
				$.ajax({
					type: "POST",
					url: "create/media",
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
			})

		});
	</script>

@endsection