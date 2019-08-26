@extends('layouts.app')
@section('title', 'Dashboard')
@section('new_post', 'active')
@section('dash-title', 'New Post')
@section('dash-content')

	<form method="post" action="{{ route('post.store') }}">
		@csrf
		<div class="form-group">
			<label for="title">Title</label>
			<input type="text" name="title" class="form-control" placeholder="Enter Post Title Here!">
		</div>
		<div class="form-group">
			<label for="description">Post description</label>
			<textarea name="description" id="description" rows="20" class="form-control" placeholder="Enter Your Content Here!"></textarea>
		</div>
		<div class="form-group">
			<button class="btn btn-info" type="submit">Submit</button>
		</div>
	</form>


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
							<div class="mt-5 mb-5">
								<form action="post" enctype="multipart/form-data">
									@csrf
									<input type="file" class="form-control-file">
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button id="InsertPhoto" type="submit" class="btn btn-primary">Save changes</button>
							</div>
						</div>
						<div class="tab-pane fade" id="media" role="tabpanel" aria-labelledby="media-tab">
							<div class="row">
								@foreach ($employees as $pics)
									<div id="img_cont" class="btn btn-link text-info col-3" data-toggle="modal" data-target="#Media">
										<img id="edit_id" src="{{ asset('storage/uploaded/'.$pics->profile_img) }}" alt="" class="img-fluid d-inline-flex">
									</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection