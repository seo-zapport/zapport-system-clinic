	<!-- Modal -->
	@if ($posts->where('important', 1)->count())
		<div class="modal fade" id="frontModal" tabindex="-1" role="dialog" aria-labelledby="frontModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header zp-bg-clan">
						<h5 class="modal-title text-white" id="frontModalLabel">Important Announcement</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					@foreach ($posts->where('important', 1) as $post)
						@if ($loop->first)
							<div class="modal-body">
								<div class="post-header">
									<h2 class="post-title">{{ strtoupper($post->title) }}</h2>
									<span class="zp-article-meta"><span class="text-muted meta-date"><i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}</span>
								</div>
								<div class="post-content">
									{!! Str::words(ucfirst($post->description), 100) !!}
								</div>
							</div>
							<div class="modal-footer">
								<a href="{{ route('frnt.show.post', ['post' => $post->slug]) }}" class="btn btn-outline-cylan m-auto">Read More</a>
							</div>
						@endif
					@endforeach
				</div>
			</div>
		</div>
	@endif