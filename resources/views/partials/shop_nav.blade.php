<ul class="sidebar-menu">

  <li class="menu-header">İzlənmələr</li>
  <li class="{{ request()->is('/') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/') }}"><i class="fa fa-columns"></i> <span>Dashboard</span></a></li>
  <li class="{{ request()->is('products') ? 'active' : '' }}"><a href="{{ route('products.index') }}"><i class="fa fa-table"></i> <span>Məhsullar</span></a></li>
  <li class="{{ request()->is('shops') ? 'active' : '' }}"><a href="{{ route('shops.index') }}"><i class="fa fa-table"></i> <span>Mağazalar</span></a></li>
  <li class="{{ request()->is('shops/categories') ? 'active' : '' }}"><a href="{{ route('shops.categories') }}"><i class="fa fa-table"></i> <span>Mağaza kateqoriyaları</span></a></li>
  <li class="{{ request()->is('car_searches') ? 'active' : '' }}"><a href="{{ route('car_searches.index') }}"><i class="fa fa-table"></i> <span>Avtomobil axtarışı</span></a></li>

  <li class="menu-header">Sosial şəbəkə</li>
  <li class="{{ request()->is('social_reports') ? 'active' : '' }}"><a href="{{ route('social_reports.index') }}"><i class="fa fa-table"></i> <span>Müraciətlər</span></a></li>
  {{-- <li class="{{ request()->is('social_reports/reports') ? 'active' : '' }}"><a href="{{ route('social_reports.reports') }}"><i class="fa fa-chart-pie"></i> <span>Hesabat</span></a></li> --}}

</ul>
