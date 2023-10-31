<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="#">
          <img alt="image" src="{{ getSetting('site_logo') ? getSetting('site_logo') : asset('admintheme/assets/img/logo.png') }}" class="header-logo" />
        </a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Main</li>
        <li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="nav-link">
                <i class="fas fa-home"></i><span>@lang('quickadmin.qa_dashboard')</span>
            </a>
        </li>

        {{-- @can('role_access')
        <li class="{{ Request::is('roles*') ? 'active' : '' }}">
            <a href="{{route('roles.index')}}" class="nav-link"><i class="fab fa-gg"></i><span>@lang('quickadmin.roles.title')</span></a>
        </li>
        @endcan --}}

        @can('staff_access')
        <li class="{{ Request::is('staff*') ? 'active' : '' }}">
            <a href="{{ route('staff.index') }}" class="nav-link">
                <i class="fab fa-gg"></i><span>@lang('quickadmin.user-management.title')</span>
            </a>
        </li>
        @endcan

        @can('customer_access')
        <li class="{{ Request::is('customers*') ? 'active' : '' }}">
            <a href="{{ route('customers.index') }}" class="nav-link">
                <i class="fab fa-gg"></i><span>@lang('quickadmin.customer-management.title')</span>
            </a>
        </li>
        @endcan

        @can('device_access')
        <li class="{{ Request::is('device*') ? 'active' : '' }}">
            <a href="{{ route('device.index') }}" class="nav-link">
                <i class="fab fa-gg"></i><span>@lang('quickadmin.device-management.title')</span>
            </a>
        </li>
        @endcan

        @can('invoice_access')
        <li class="{{ Request::is('orders*') ? 'active' : '' }}">
            <a href="{{ route('orders.index') }}" class="nav-link">
                <i class="fab fa-gg"></i><span>@lang('quickadmin.order-management.title')</span>
            </a>
        </li>
        @endcan

        @can('report_access')
        <li class="{{ Request::is('reports*') ? 'active' : '' }}">
            <a href="{{ route('reports') }}" class="nav-link">
                <i class="fab fa-gg"></i><span>@lang('quickadmin.report-management.title')</span>
            </a>
        </li>
        @endcan

        @can('master_access')
        <li class="dropdown">
            <a href="#" class="nav-link has-dropdown"><i class="fab fa-gg"></i><span>@lang('quickadmin.master-management.title')</span></a>
            <ul class="dropdown-menu">
                @can('address_access')
                <li class="{{ Request::is('address*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('address.index') }}">@lang('quickadmin.address.title')</a>
                </li>
                @endcan
                @can('category_access')
                <li class="{{ Request::is('categories*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('categories.index') }}">@lang('quickadmin.category.title')</a>
                </li>
                @endcan
                @can('product_access')
                <li class="{{ Request::is('products*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('products.index') }}">@lang('quickadmin.product-management.title')</a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
        @can('setting_access')
        <li class="{{ Request::is('settings*') ? 'active' : '' }}">
            <a href="{{ route('settings') }}" class="nav-link">
                <i class="fas fa-cog"></i><span>@lang('quickadmin.settings.title')</span>
            </a>
        </li>
        @endcan

        <li class="{{ Request::is('logout*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('logout') }}">
                <i class="fas fa-sign-out-alt"></i><span>Logout</span>
            </a>
        </li>
    </ul>

    </aside>
  </div>
