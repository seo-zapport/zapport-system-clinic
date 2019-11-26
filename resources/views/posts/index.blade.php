@extends('layouts.app')
@section('title', '| Posts')
@section('posts', 'active')
@section('heading-title')
	<i class="fas fa-book text-secondary"></i> Posts
@endsection
@section('dash-content')

<form method="get">
	<div class="form-row">
		<div class="form-group col-12 col-md-8 col-lg-4">
	        <div class="input-group">
	            <input type="search" name="search" class="form-control" value="{{ (!empty($search)) ? $search : '' }}" placeholder="Search for Post's Title">
	            <div class="input-group-append">
	                <button type="submit" class="btn btn-success mr-2">Search</button>
	                <a href="{{ route('post.index') }}" class="btn btn-info text-white">Clear</a>
	            </div>
	        </div>		 	
		</div>

	</div>
</form>

<div class="card mb-3">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>Title</th>
					<th width="15%">Date Published</th>
				</thead>
				<tbody>
					@forelse ($posts as $post)
						<tr>
							<td>
								{{ ucwords($post->title) }}
								<div class="row-actions">
									<a href="{{ route('post.show', ['post' => $post->slug]) }}" class="btn btn-link text-secondary"><i class="far fa-eye"></i> View</a> <span class="text-muted">|</span>
									<a href="{{ route('post.edit', ['post' => $post->slug]) }}" class="btn btn-link text-info"><i class="far fa-edit"></i> Edit</a>
								</div>
							</td>
							<td>
								{{ $post->created_at->format('M d, Y - h:i a') }}
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="3" class="text-center">
								<span class="mb-1 text-secondary">No Post Yet !</span>
								<a href="{{ route('post.create') }}">Create New Post here!</a>
							</td>
						</tr>
					@endforelse
				</tbody>
			</table>			
		</div>
	</div>
</div>
<div class="pagination-wrap">{{ $posts->links() }}</div>
@endsection