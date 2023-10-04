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
          <a href="#" class="nav-link "><i class="fas fa-home"></i><span>Dashboard</span></a>

        </li>
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="fab fa-gg"></i><span>Category</span></a>
          <ul class="dropdown-menu">
            {{-- <li><a class="nav-link" href="{{ route('categories.create') }}">Add Category</a></li>
            <li><a class="nav-link" href="{{ route('categories.list') }}">Category List</a></li> --}}
            <li><a class="nav-link" href="#">Add Category</a></li>
            <li><a class="nav-link" href="#">Category List</a></li>
          </ul>
        </li>
        {{-- <li class="dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="fab fa-gg"></i><span>Employee</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('employees.create') }}">Add Employee</a></li>
            <li><a class="nav-link" href="{{ route('employees.index') }}">Employee List</a></li>
          </ul>
        </li> --}}
        {{-- <li><a class="nav-link" href="{{ route('admin.logout') }}"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a></li> --}}

      </ul>
    </aside>
  </div>
