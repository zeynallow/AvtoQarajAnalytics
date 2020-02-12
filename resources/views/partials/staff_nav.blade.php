<ul class="sidebar-menu">
  <li class="menu-header">Sosial şəbəkə</li>
  <li class="{{ request()->is('social_reports/create') ? 'active' : '' }}"><a href="{{ route('social_reports.create') }}"><i class="fa fa-plus"></i> <span>Müraciət yarat</span></a></li>
  <li class="{{ request()->is('social_reports') ? 'active' : '' }}"><a href="{{ route('social_reports.index') }}"><i class="fa fa-table"></i> <span>Müraciətlər</span></a></li>
  <li class="{{ request()->is('social_reports/reports') ? 'active' : '' }}"><a href="{{ route('social_reports.reports') }}"><i class="fa fa-chart-pie"></i> <span>Hesabat</span></a></li>
</ul>
