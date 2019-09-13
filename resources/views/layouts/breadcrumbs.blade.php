<nav aria-label="breadcrumb">
	<ul class="breadcrumb">
		@foreach (request()->breadcrumbs()->segments() as $segment)
			<li class="breadcrumb-item">
				<a href="{{ $segment->url() }}">{{ optional( $segment->model() )->title ?: $segment->name() }}</a>
			</li>
		@endforeach
	</ul>
</nav>