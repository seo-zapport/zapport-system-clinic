<nav>
	<ul class="breadcrumb">
		@foreach ($segments = request()->segments() as $index => $segment)
			<li class="breadcrumb-item">
				{{ var_dump( array_slice($segments, 0, $index + 1) ) }}
				<a href="">
					{{ title_case( $segment ) }}
				</a>
			</li>
		@endforeach		
	</ul>
</nav>
