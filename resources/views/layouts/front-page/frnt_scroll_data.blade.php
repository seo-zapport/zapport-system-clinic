@foreach ($limit->where('important', 0) as $post)
  <div class="col-12 col-lg-4 mb-3">
    <div class="card p-2">
      <div class="img-wrap">
        <img src="{{ ($post->medias != null) ? asset('storage/uploaded/media/'.$post->medias->file_name) : asset('storage/uploaded/media/No_image.png') }}" class="card-img-top">
      </div>
      <div class="card-body">
        <a href="{{ route('frnt.show.post', ['post' => $post->slug]) }}">
          <h5 class="card-title">{{ strtoupper($post->title) }}</h5>
        </a>
      </div>
    </div>							
  </div>
@endforeach