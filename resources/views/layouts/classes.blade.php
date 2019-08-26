@section('body-class')
	@if ( request()->is('dashboard*') )admin-dashboard @endif
	@if ( request()->is('hr*') )admin-department @endif
@endsection