@section('body-class')
	@if ( request()->is('dashboard*') )admin-dashboard @endif
	@if ( request()->is('hr*') )admin-department @endif
	@if ( request()->is('employees*') )admin-profile @endif
	@if ( request()->is('register') )admin-register @endif
	@if ( request()->is('password/reset') )admin-reset @endif
@endsection