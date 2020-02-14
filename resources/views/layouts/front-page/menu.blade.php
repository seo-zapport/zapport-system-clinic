<header class="fixed-top">
  @auth()
    <div id="dashboardMenu" class="px-4 bg-dark text-white">
      <div class="d-flex justify-content-between container-fluid">
        <ul class="mb-0 navbar-nav">
          <li class="nav-item dropdown">
            <a href="/dashboard" class="nav-link py-1" role="button"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</a>
          </li>
        </ul>
        <ul class="mb-0 navbar-nav">
          <li class="nav-item dropdown">
            <a href="/dashboard" class="nav-link py-1 dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }} </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a> <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
            </div>
          </li>
        </ul>
      </div>
    </div>
  @endauth
  {{--  color for text of link 52bec2  --}}
  <nav class="navbar navbar-expand-lg navbar-dark bg-secondary" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="/"> <img src="{{ url('/images/logo.png') }}" alt="Zapport Clinic"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="@if(request()->route()->getName() != 'frnt.show.post') #hero @else / @endif">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="@if(request()->route()->getName() != 'frnt.show.post') #clinic @else /#clinic @endif">Clinic</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="@if(request()->route()->getName() != 'frnt.show.post') #post @else /#post @endif">Post</a>
          </li>
          </li>
          <li class="nav-item">
            <a  type="button" class="nav-link" data-toggle="modal" data-target="#frontModal">Notice</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>