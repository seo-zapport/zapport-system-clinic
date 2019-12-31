<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="@if(request()->route()->getName() != 'frnt.show.post') dashboard @else / @endif"> <img src="{{ url('/images/logo.png') }}" alt="Zapport Clinic"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#hero">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#clinic">Clinic</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#post">Post</a>
          </li>
          </li>
          <li class="nav-item">
            <a  type="button" class="nav-link" data-toggle="modal" data-target="#frontModal">Notice</a>
          </li>
          @auth()
          <li class="nav-item">
              <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
          </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>
</header>