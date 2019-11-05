<form class="form-inline mr-auto" action="">
  <ul class="navbar-nav mr-3">
    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
  </ul>
</form>
<ul class="navbar-nav navbar-right">

  @if (Route::has('login'))
          @auth
            <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <div class="d-sm-none d-lg-inline-block">{{(auth()->check()) ? auth()->user()->name : ''}}</div></a>
              <div class="dropdown-menu dropdown-menu-right">
                <a href="{{route('logout')}}" class="dropdown-item has-icon text-danger">
                  <i class="fas fa-sign-out-alt"></i> Çıxış
                </a>
              </div>
            </li>
          @else
              <a href="{{ route('login') }}">Daxil ol</a>
          @endauth
  @endif


</ul>
