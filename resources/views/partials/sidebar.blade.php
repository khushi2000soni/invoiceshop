<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="#">
          <img alt="image" src="{{ asset('admintheme/assets/img/logo.png') }}" class="header-logo" />
          <span class="logo-name">Grexa</span>
        </a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Main</li>
        <li class="dropdown active">
          {{-- <a href="{{ route('admin.dashboard') }}" class="nav-link "><i class="fas fa-home"></i><span>Dashboard</span></a> --}}
          <a href="#" class="nav-link "><i class="fas fa-home"></i><span>@lang('quickadmin.qa_dashboard')</span></a>
        </li>
        @can('role_access')
        <li class="dropdown">
            <a href="{{route('roles.index')}}" class="nav-link"><i class="fab fa-gg"></i><span>@lang('quickadmin.roles.title')</span></a>
        </li>
        @endcan

        @can('staff_access')
        <li class="dropdown">
            <a href="{{route('staff.index')}}" class="nav-link"><i class="fab fa-gg"></i><span>@lang('quickadmin.user-management.title')</span></a>
        </li>
        @endcan
        @can('customer_access')
        <li class="dropdown">
            <a href="{{route('customers.index')}}" class="nav-link"><i class="fab fa-gg"></i><span>@lang('quickadmin.customer-management.title')</span></a>
        </li>
        @endcan

        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="fab fa-gg"></i><span>@lang('quickadmin.master-management.title')</span></a>
          <ul class="dropdown-menu">
            @can('address_access')
            <li><a class="nav-link" href="{{route('address.index')}}">@lang('quickadmin.address.title')</a></li>
            @endcan
            @can('category_access')
            <li><a class="nav-link" href="{{route('categories.index')}}">@lang('quickadmin.category.title')</a></li>
            @endcan

          </ul>
        </li>
        {{-- <li class="dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="fab fa-gg"></i><span>Employee</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('employees.create') }}">Add Employee</a></li>
            <li><a class="nav-link" href="{{ route('employees.index') }}">Employee List</a></li>
          </ul>
        </li> --}}
        <li><a class="nav-link" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></li>

      </ul>
    </aside>
  </div>
