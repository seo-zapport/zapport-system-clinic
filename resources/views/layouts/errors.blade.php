@if ($errors->any())
	@foreach($errors->all() as $error)

		<div class="alert alert-danger alert-posts" role="alert">{{ $error }}</div>

	@endforeach
@endif