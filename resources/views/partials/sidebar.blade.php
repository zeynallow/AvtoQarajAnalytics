<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="">{{ env('APP_NAME') }}</a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="#">{{ strtoupper(substr(env('APP_NAME'), 0, 2)) }}</a>
  </div>
  <ul class="sidebar-menu">
    <li class="menu-header">Dashboard</li>
    <li class="{{ request()->is('/') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/') }}"><i class="fa fa-columns"></i> <span>Dashboard</span></a></li>
    <li class="{{ request()->is('products') ? 'active' : '' }}"><a href="{{ route('products.index') }}"><i class="fa fa-table"></i> <span>Məhsullar</span></a></li>
    <li class="menu-header">İstifadəçilər</li>
    <li><a class="nav-link" href=""><i class="fa fa-users"></i> <span>İstifadəçilər</span></a></li>
  </ul>
</aside>
