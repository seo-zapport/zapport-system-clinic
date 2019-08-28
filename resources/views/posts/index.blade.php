@extends('layouts.app')
@section('title', 'Dashboard')
@section('posts', 'active')
@section('dash-title', 'All Posts')
@section('dash-content')

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
					<a href="{{ route('post.show', ['post' => $post->id]) }}" class="btn btn-info float-right">View</a>
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