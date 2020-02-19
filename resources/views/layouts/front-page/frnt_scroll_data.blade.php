@foreach ($limit->where('important', 0) as $post)
  <div class="col-12 col-lg-4 mb-3">
    <div class="card p-2 loadCardPosts">
      <div class="img-wrap">
        <a href="{{ route('frnt.show.post', ['post' => $post->slug]) }}"><img src="{{ ($post->medias != null) ? asset('storage/uploaded/media/'.$post->medias->file_name) : asset('storage/uploaded/media/No_image.png') }}" class="card-img-top"></a>
      </div>
      <div class="card-body p-3">
        <a href="{{ route('frnt.show.post', ['post' => $post->slug]) }}">
          <h5 class="card-title">{{ Str::limit(strtoupper($post->title), 50) }}</h5>
        </a>
      </div>
    </div>							
  </div>
@endforeach