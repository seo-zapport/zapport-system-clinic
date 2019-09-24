@extends('layouts.app')
@section('title', '| Posts')
@section('posts', 'active')
@section('dash-title', 'All Posts')
@section('heading-title')
	<i class="fas fa-book"></i> Posts
@endsection
@section('dash-content')

<form method="get">
	<div class="form-row">
		<div class="form-group col-md-4">
			<input type="search" name="search" class="form-control" value="{{ (!empty($search)) ? $search : '' }}" placeholder="Search for Post's Title">
		</div>
		<div class="form-group col-md-1 d-inline-flex">
			<button type="submit" class="btn btn-success mr-2">Search</button>
			<a href="{{ route('post.index') }}" class="btn btn-info text-white">Clear</a>
		</div>
	</div>
</form>

<table class="table table-hover">
	<thead class="thead-dark">
		<th>Date Posted</th>
		<th>Title</th>
	</thead>
	<tbody>
		@forelse ($posts as $post)
			<tr>
				<td>
					{{ $post->created_at->format('M d, Y - h:i a') }}
				</td>
				<td>
					{{ $post->title }}
					<a href="{{ route('post.show', ['post' => $post->title]) }}" class="btn btn-info float-right">View</a>
				</td>
			</tr>
		@empty
			<tr>
				<td colspan="2" class="text-center">
				No Post Yet!
				<a href="{{ route('post.create') }}">Create New Post here!</a>
			</td>
			</tr>
		@endforelse
	</tbody>
</table>
{{ $posts->links() }}
@endsection