<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="">{{ env('APP_NAME') }}</a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="#">{{ strtoupper(substr(env('APP_NAME'), 0, 2)) }}</a>
  </div>

  @if(auth()->user()->role_id == 1)
    @include('partials.admin_nav')
  @elseif(auth()->user()->role_id == 2)
    @include('partials.shop_nav')
  @elseif(auth()->user()->role_id == 3)
    @include('partials.staff_nav')
  @endif

</aside>
