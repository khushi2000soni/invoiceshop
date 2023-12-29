<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="#">
          <div class="circleimg"><img alt="image" src="{{ getSetting('site_logo') ? getSetting('site_logo') : asset('admintheme/assets/img/shopping-bag.png') }}" class="header-logo" /></div>
          <span>@lang('quickadmin.qa_company_name')</span>
        </a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Main</li>
        <li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="nav-link">
                <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.92416 2.72727V6.36364C9.92416 7.08695 9.63682 7.78065 9.12536 8.29211C8.6139 8.80357 7.92021 9.09091 7.19689 9.09091H3.56052C2.83721 9.09091 2.14351 8.80357 1.63205 8.29211C1.12059 7.78065 0.833252 7.08695 0.833252 6.36364V2.72727C0.833252 2.00396 1.12059 1.31026 1.63205 0.7988C2.14351 0.287337 2.83721 0 3.56052 0H7.19689C7.92021 0 8.6139 0.287337 9.12536 0.7988C9.63682 1.31026 9.92416 2.00396 9.92416 2.72727ZM18.106 0H14.4696C13.7463 0 13.0526 0.287337 12.5411 0.7988C12.0297 1.31026 11.7423 2.00396 11.7423 2.72727V6.36364C11.7423 7.08695 12.0297 7.78065 12.5411 8.29211C13.0526 8.80357 13.7463 9.09091 14.4696 9.09091H18.106C18.8293 9.09091 19.523 8.80357 20.0345 8.29211C20.5459 7.78065 20.8333 7.08695 20.8333 6.36364V2.72727C20.8333 2.00396 20.5459 1.31026 20.0345 0.7988C19.523 0.287337 18.8293 0 18.106 0ZM7.19689 10.9091H3.56052C2.83721 10.9091 2.14351 11.1964 1.63205 11.7079C1.12059 12.2194 0.833252 12.913 0.833252 13.6364V17.2727C0.833252 17.996 1.12059 18.6897 1.63205 19.2012C2.14351 19.7127 2.83721 20 3.56052 20H7.19689C7.92021 20 8.6139 19.7127 9.12536 19.2012C9.63682 18.6897 9.92416 17.996 9.92416 17.2727V13.6364C9.92416 12.913 9.63682 12.2194 9.12536 11.7079C8.6139 11.1964 7.92021 10.9091 7.19689 10.9091ZM18.106 10.9091H14.4696C13.7463 10.9091 13.0526 11.1964 12.5411 11.7079C12.0297 12.2194 11.7423 12.913 11.7423 13.6364V17.2727C11.7423 17.996 12.0297 18.6897 12.5411 19.2012C13.0526 19.7127 13.7463 20 14.4696 20H18.106C18.8293 20 19.523 19.7127 20.0345 19.2012C20.5459 18.6897 20.8333 17.996 20.8333 17.2727V13.6364C20.8333 12.913 20.5459 12.2194 20.0345 11.7079C19.523 11.1964 18.8293 10.9091 18.106 10.9091Z" fill="#B0B3B7"/>
                </svg><span>@lang('quickadmin.qa_dashboard')</span>
            </a>
        </li>

        @can('role_access')
        <li class="{{ Request::is('roles*') ? 'active' : '' }}">
            <a href="{{route('roles.index')}}" class="nav-link"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_212_3741)">
                <path d="M13.3692 11.6667H6.63083C5.53567 11.6681 4.48575 12.1037 3.71135 12.8781C2.93696 13.6525 2.50132 14.7024 2.5 15.7976V20.0001H17.5V15.7976C17.4987 14.7024 17.063 13.6525 16.2886 12.8781C15.5143 12.1037 14.4643 11.6681 13.3692 11.6667Z" fill="#B0B3B7"/>
                <path d="M10 10C12.7614 10 15 7.76142 15 5C15 2.23858 12.7614 0 10 0C7.23858 0 5 2.23858 5 5C5 7.76142 7.23858 10 10 10Z" fill="#B0B3B7"/>
                </g>
                <defs>
                <clipPath id="clip0_212_3741">
                <rect width="20" height="20" fill="white"/>
                </clipPath>
                </defs>
                </svg>
            <span>@lang('quickadmin.roles.title')</span></a>
        </li>
        @endcan

        @can('staff_access')
        <li class="{{ Request::is('staff*') ? 'active' : '' }}">
            <a href="{{ route('staff.index') }}" class="nav-link">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 4.21055C3 1.88512 4.79086 0 7 0C9.20917 0 11 1.88512 11 4.21055C11 6.53597 9.20917 8.42109 7 8.42109C4.79086 8.42109 3 6.53597 3 4.21055Z" fill="#B0B3B7"/>
                <path d="M11 0.428779C11.9611 1.39475 12.556 2.73242 12.556 4.21055C12.556 5.68867 11.9611 7.02633 11 7.99229C11.5533 8.26693 12.1758 8.42109 12.8338 8.42109C15.1348 8.42109 17 6.53597 17 4.21055C17 1.88512 15.1348 0 12.8338 0C12.1758 0 11.5533 0.154196 11 0.428779Z" fill="#B0B3B7"/>
                <path d="M0 15.2151C0 12.5726 1.81506 10.4304 4.05407 10.4304H10.5406C12.7796 10.4304 14.5946 12.5726 14.5946 15.2151C14.5946 17.8577 12.7796 19.9998 10.5406 19.9998H4.05407C1.81506 19.9998 0 17.8577 0 15.2151Z" fill="#B0B3B7"/>
                <path d="M15.8857 15.4737C15.8857 16.7683 15.5518 17.967 14.9841 18.9474H16.1429C18.2731 18.9474 20 16.8266 20 14.2105C20 11.5944 18.2731 9.47363 16.1429 9.47363H11C13.6984 9.47363 15.8857 12.1599 15.8857 15.4737Z" fill="#B0B3B7"/>
                </svg><span>@lang('quickadmin.user-management.title')</span>
            </a>
        </li>
        @endcan

        @can('customer_access')
        <li class="{{ Request::is('customers*') ? 'active' : '' }}">
            <a href="{{ route('customers.index') }}" class="nav-link">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_212_3171)">
                <path d="M7.5 10C4.7425 10 2.5 7.7575 2.5 5C2.5 2.2425 4.7425 0 7.5 0C10.2575 0 12.5 2.2425 12.5 5C12.5 7.7575 10.2575 10 7.5 10ZM18.9133 15.945L18.1017 15.4767C18.24 15.0625 18.3333 14.6275 18.3333 14.1667C18.3333 13.7058 18.2408 13.2708 18.1017 12.8567L18.9133 12.3883C19.3117 12.1583 19.4483 11.6483 19.2183 11.25C18.9875 10.8508 18.4792 10.7133 18.08 10.945L17.2692 11.4133C16.6817 10.7517 15.8992 10.2675 15 10.085V9.1675C15 8.7075 14.6267 8.33417 14.1667 8.33417C13.7067 8.33417 13.3333 8.7075 13.3333 9.1675V10.085C12.4342 10.2683 11.6517 10.7525 11.0642 11.4133L10.2533 10.945C9.85333 10.7142 9.345 10.8508 9.115 11.25C8.885 11.6492 9.02167 12.1583 9.42 12.3883L10.2317 12.8567C10.0933 13.2708 10 13.7058 10 14.1667C10 14.6275 10.0925 15.0625 10.2317 15.4767L9.42 15.945C9.02167 16.175 8.885 16.685 9.115 17.0833C9.27 17.3508 9.54917 17.5 9.8375 17.5C9.97833 17.5 10.1217 17.4642 10.2533 17.3883L11.0642 16.92C11.6517 17.5817 12.4342 18.0658 13.3333 18.2483V19.1658C13.3333 19.6258 13.7067 19.9992 14.1667 19.9992C14.6267 19.9992 15 19.6258 15 19.1658V18.2483C15.8992 18.065 16.6817 17.5808 17.2692 16.92L18.08 17.3883C18.2117 17.4642 18.355 17.5 18.4958 17.5C18.7842 17.5 19.0642 17.3508 19.2183 17.0833C19.4483 16.6842 19.3117 16.175 18.9133 15.945ZM14.1667 15.4167C13.4775 15.4167 12.9167 14.8558 12.9167 14.1667C12.9167 13.4775 13.4775 12.9167 14.1667 12.9167C14.8558 12.9167 15.4167 13.4775 15.4167 14.1667C15.4167 14.8558 14.8558 15.4167 14.1667 15.4167ZM6.66667 14.1667C6.66667 13.2967 6.8225 12.4642 7.095 11.6875C3.14833 11.8992 0 15.1683 0 19.1667C0 19.6267 0.373333 20 0.833333 20H9.4575C7.75667 18.625 6.66667 16.5242 6.66667 14.1667Z" fill="#B0B3B7"/>
                </g>
                <defs>
                <clipPath id="clip0_212_3171">
                <rect width="20" height="20" fill="white"/>
                </clipPath>
                </defs>
                </svg>
                <span>@lang('quickadmin.customer-management.title')</span>
            </a>
        </li>
        @endcan

        @can('device_access')
        <li class="{{ Request::is('device*') ? 'active' : '' }}">
            <a href="{{ route('device.index') }}" class="nav-link">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_212_3173)">
                <path d="M17.5 5.83325C17.9583 5.83325 18.3333 5.45825 18.3333 4.99992C18.3333 2.69992 16.4667 0.833252 14.1667 0.833252H4.16667C1.86667 0.833252 0 2.69992 0 4.99992V10.8333C0 13.1333 1.86667 14.9999 4.16667 14.9999H8.33333V16.6666H5.83333C5.375 16.6666 5 17.0416 5 17.4999C5 17.9583 5.375 18.3333 5.83333 18.3333H9.16667C9.625 18.3333 10 17.9583 10 17.4999V10.8333C10 8.07492 12.2417 5.83325 15 5.83325H17.5ZM16.6667 7.49992H15C13.1583 7.49992 11.6667 8.99159 11.6667 10.8333V16.6666C11.6667 18.5083 13.1583 19.9999 15 19.9999H16.6667C18.5083 19.9999 20 18.5083 20 16.6666V10.8333C20 8.99159 18.5083 7.49992 16.6667 7.49992Z" fill="#B0B3B7"/>
                </g>
                <defs>
                <clipPath id="clip0_212_3173">
                <rect width="20" height="20" fill="white"/>
                </clipPath>
                </defs>
                </svg><span>@lang('quickadmin.device-management.title')</span>
            </a>
        </li>
        @endcan

        @can('invoice_access')
        <li class="{{ Request::is('orders*') ? 'active' : '' }}">
            <a href="{{ route('orders.index') }}" class="nav-link">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_212_3177)">
                <path d="M11.6667 5.83333V0.383333C12.4276 0.671667 13.1276 1.11583 13.7209 1.70833L16.6242 4.61333C17.2176 5.20583 17.6617 5.90583 17.9501 6.66667H12.5001C12.0401 6.66667 11.6667 6.2925 11.6667 5.83333ZM12.9167 12.5H7.08341C6.85341 12.5 6.66675 12.6867 6.66675 12.9167V14.5833C6.66675 14.8133 6.85341 15 7.08341 15H12.9167C13.1467 15 13.3334 14.8133 13.3334 14.5833V12.9167C13.3334 12.6867 13.1467 12.5 12.9167 12.5ZM18.3334 8.7375V15.8333C18.3334 18.1308 16.4642 20 14.1667 20H5.83341C3.53591 20 1.66675 18.1308 1.66675 15.8333V4.16667C1.66675 1.86917 3.53591 0 5.83341 0H9.59592C9.73175 0 9.86592 0.0108333 10.0001 0.02V5.83333C10.0001 7.21167 11.1217 8.33333 12.5001 8.33333H18.3134C18.3226 8.4675 18.3334 8.60167 18.3334 8.7375ZM5.00008 5C5.00008 5.46 5.37341 5.83333 5.83341 5.83333H7.50008C7.96008 5.83333 8.33342 5.46 8.33342 5C8.33342 4.54 7.96008 4.16667 7.50008 4.16667H5.83341C5.37341 4.16667 5.00008 4.54 5.00008 5ZM5.00008 8.33333C5.00008 8.79333 5.37341 9.16667 5.83341 9.16667H7.50008C7.96008 9.16667 8.33342 8.79333 8.33342 8.33333C8.33342 7.87333 7.96008 7.5 7.50008 7.5H5.83341C5.37341 7.5 5.00008 7.87333 5.00008 8.33333ZM15.0001 12.9167C15.0001 11.7683 14.0651 10.8333 12.9167 10.8333H7.08341C5.93508 10.8333 5.00008 11.7683 5.00008 12.9167V14.5833C5.00008 15.7317 5.93508 16.6667 7.08341 16.6667H12.9167C14.0651 16.6667 15.0001 15.7317 15.0001 14.5833V12.9167Z" fill="#B0B3B7"/>
                </g>
                <defs>
                <clipPath id="clip0_212_3177">
                <rect width="20" height="20" fill="white"/>
                </clipPath>
                </defs>
                </svg><span>@lang('quickadmin.order-management.title')</span>
            </a>
        </li>
        @endcan

        @can('report_access')
        <li class="{{ Request::is('reports*') ? 'active' : '' }}">
            <a href="{{ route('reports') }}" class="nav-link">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_212_3181)">
                <path d="M1.66675 5.83333V15.8333C1.66675 18.1308 3.53591 20 5.83341 20H14.1667C16.4642 20 18.3334 18.1308 18.3334 15.8333V5.83333H1.66675ZM10.0001 15H6.66675C6.20675 15 5.83341 14.6275 5.83341 14.1667C5.83341 13.7058 6.20675 13.3333 6.66675 13.3333H10.0001C10.4601 13.3333 10.8334 13.7058 10.8334 14.1667C10.8334 14.6275 10.4601 15 10.0001 15ZM13.3334 10.8333H6.66675C6.20675 10.8333 5.83341 10.4608 5.83341 10C5.83341 9.53917 6.20675 9.16667 6.66675 9.16667H13.3334C13.7934 9.16667 14.1667 9.53917 14.1667 10C14.1667 10.4608 13.7934 10.8333 13.3334 10.8333ZM18.3334 4.16667H1.66675C1.66675 1.86917 3.53591 0 5.83341 0H14.1667C16.4642 0 18.3334 1.86917 18.3334 4.16667Z" fill="#B0B3B7"/>
                </g>
                <defs>
                <clipPath id="clip0_212_3181">
                <rect width="20" height="20" fill="white"/>
                </clipPath>
                </defs>
                </svg><span>@lang('quickadmin.report-management.title')</span>
            </a>
        </li>
        @endcan
        @can('customer_access')
        <li class="{{ Request::is('phone-book*') ? 'active' : '' }}">
            <a href="{{ route('showPhoneBook') }}" class="nav-link">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_212_3171)">
                <path d="M7.5 10C4.7425 10 2.5 7.7575 2.5 5C2.5 2.2425 4.7425 0 7.5 0C10.2575 0 12.5 2.2425 12.5 5C12.5 7.7575 10.2575 10 7.5 10ZM18.9133 15.945L18.1017 15.4767C18.24 15.0625 18.3333 14.6275 18.3333 14.1667C18.3333 13.7058 18.2408 13.2708 18.1017 12.8567L18.9133 12.3883C19.3117 12.1583 19.4483 11.6483 19.2183 11.25C18.9875 10.8508 18.4792 10.7133 18.08 10.945L17.2692 11.4133C16.6817 10.7517 15.8992 10.2675 15 10.085V9.1675C15 8.7075 14.6267 8.33417 14.1667 8.33417C13.7067 8.33417 13.3333 8.7075 13.3333 9.1675V10.085C12.4342 10.2683 11.6517 10.7525 11.0642 11.4133L10.2533 10.945C9.85333 10.7142 9.345 10.8508 9.115 11.25C8.885 11.6492 9.02167 12.1583 9.42 12.3883L10.2317 12.8567C10.0933 13.2708 10 13.7058 10 14.1667C10 14.6275 10.0925 15.0625 10.2317 15.4767L9.42 15.945C9.02167 16.175 8.885 16.685 9.115 17.0833C9.27 17.3508 9.54917 17.5 9.8375 17.5C9.97833 17.5 10.1217 17.4642 10.2533 17.3883L11.0642 16.92C11.6517 17.5817 12.4342 18.0658 13.3333 18.2483V19.1658C13.3333 19.6258 13.7067 19.9992 14.1667 19.9992C14.6267 19.9992 15 19.6258 15 19.1658V18.2483C15.8992 18.065 16.6817 17.5808 17.2692 16.92L18.08 17.3883C18.2117 17.4642 18.355 17.5 18.4958 17.5C18.7842 17.5 19.0642 17.3508 19.2183 17.0833C19.4483 16.6842 19.3117 16.175 18.9133 15.945ZM14.1667 15.4167C13.4775 15.4167 12.9167 14.8558 12.9167 14.1667C12.9167 13.4775 13.4775 12.9167 14.1667 12.9167C14.8558 12.9167 15.4167 13.4775 15.4167 14.1667C15.4167 14.8558 14.8558 15.4167 14.1667 15.4167ZM6.66667 14.1667C6.66667 13.2967 6.8225 12.4642 7.095 11.6875C3.14833 11.8992 0 15.1683 0 19.1667C0 19.6267 0.373333 20 0.833333 20H9.4575C7.75667 18.625 6.66667 16.5242 6.66667 14.1667Z" fill="#B0B3B7"/>
                </g>
                <defs>
                <clipPath id="clip0_212_3171">
                <rect width="20" height="20" fill="white"/>
                </clipPath>
                </defs>
                </svg>
                <span>@lang('quickadmin.phone-book.title')</span>
            </a>
        </li>
        @endcan
        @can('master_access')
        <li class="dropdown {{ Request::is('address*', 'categories*', 'products*') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_212_3741)">
            <path d="M13.3692 11.6667H6.63083C5.53567 11.6681 4.48575 12.1037 3.71135 12.8781C2.93696 13.6525 2.50132 14.7024 2.5 15.7976V20.0001H17.5V15.7976C17.4987 14.7024 17.063 13.6525 16.2886 12.8781C15.5143 12.1037 14.4643 11.6681 13.3692 11.6667Z" fill="#B0B3B7"/>
            <path d="M10 10C12.7614 10 15 7.76142 15 5C15 2.23858 12.7614 0 10 0C7.23858 0 5 2.23858 5 5C5 7.76142 7.23858 10 10 10Z" fill="#B0B3B7"/>
            </g>
            <defs>
            <clipPath id="clip0_212_3741">
            <rect width="20" height="20" fill="white"/>
            </clipPath>
            </defs>
            </svg><span>@lang('quickadmin.master-management.title')</span></a>
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
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.33926 15C2.02856 16.1963 3.55719 16.6073 4.75352 15.918C4.75434 15.9176 4.75512 15.9171 4.75594 15.9166L5.12676 15.7025C5.82676 16.3014 6.63137 16.7658 7.50008 17.0725V17.5C7.50008 18.8807 8.61938 20 10.0001 20C11.3808 20 12.5001 18.8807 12.5001 17.5V17.0725C13.3689 16.7654 14.1736 16.3004 14.8734 15.7008L15.2459 15.9158C16.4425 16.6062 17.9722 16.1958 18.6626 14.9991C19.3529 13.8025 18.9425 12.2728 17.7459 11.5825L17.3759 11.3691C17.5425 10.4629 17.5425 9.53379 17.3759 8.62746L17.7459 8.41414C18.9425 7.72379 19.3529 6.1941 18.6626 4.99746C17.9722 3.80086 16.4425 3.39043 15.2459 4.08078L14.8751 4.29496C14.1744 3.6968 13.3692 3.2332 12.5001 2.9275V2.5C12.5001 1.1193 11.3808 0 10.0001 0C8.61938 0 7.50008 1.1193 7.50008 2.5V2.9275C6.63125 3.23465 5.8266 3.69965 5.12676 4.29918L4.75426 4.08336C3.55762 3.39297 2.02793 3.8034 1.33758 5C0.64723 6.1966 1.05762 7.72633 2.25426 8.41668L2.62426 8.63C2.4577 9.53629 2.4577 10.4654 2.62426 11.3717L2.25426 11.585C1.06094 12.2772 0.651878 13.8039 1.33926 15ZM10.0001 6.66668C11.841 6.66668 13.3334 8.15906 13.3334 10C13.3334 11.8409 11.841 13.3333 10.0001 13.3333C8.15914 13.3333 6.66676 11.8409 6.66676 10C6.66676 8.15906 8.15914 6.66668 10.0001 6.66668Z" fill="#B0B3B7"/>
                </svg><span>@lang('quickadmin.settings.title')</span>
            </a>
        </li>
        @endcan

        <li class="{{ Request::is('logout*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('logout') }}">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_212_3194)">
                <path d="M14.0425 11.02C13.8466 11.0039 13.6524 11.0661 13.5023 11.193C13.3523 11.3199 13.2587 11.5011 13.2421 11.697C13.1765 12.4712 13.0952 13.1446 13.0241 13.4985V13.5028C12.8144 14.5848 11.7894 15.6544 10.7382 15.8895C10.6472 15.9083 10.5558 15.9263 10.4648 15.9434C10.5429 14.9384 10.6011 13.6532 10.5933 12.6622C10.605 11.1481 10.4601 8.81688 10.3316 7.88915C10.1007 6.18094 9.05031 4.28641 7.8882 3.48133L7.88117 3.47665C7.07316 2.93079 6.20721 2.47606 5.29914 2.12079C5.13716 2.05803 4.97713 1.99943 4.81906 1.945C5.68109 1.81173 6.55226 1.74642 7.42453 1.74969C8.61203 1.74969 9.69601 1.85789 10.7382 2.0743C11.7894 2.30868 12.8144 3.37899 13.0241 4.46102V4.46532C13.0948 4.81688 13.1761 5.49032 13.2417 6.26219C13.2584 6.45836 13.3523 6.63987 13.5028 6.76678C13.6533 6.8937 13.8481 6.95563 14.0443 6.93895C14.2404 6.92227 14.4219 6.82835 14.5488 6.67784C14.6758 6.52734 14.7377 6.33258 14.721 6.13641C14.6499 5.30086 14.5624 4.58641 14.4804 4.17547C14.1566 2.51102 12.6835 0.984067 11.0538 0.623129L11.0444 0.621176C9.89913 0.383676 8.71554 0.26727 7.42179 0.264926C6.12804 0.262583 4.94913 0.382114 3.80382 0.621567L3.79406 0.62352C3.06671 0.784848 2.37101 1.1786 1.79445 1.71258C1.63862 1.83008 1.50243 1.97155 1.39093 2.13172C0.881557 2.72625 0.511635 3.43758 0.367885 4.17547C0.187807 5.07821 -0.0157088 7.41922 -8.37607e-05 8.98172C-0.00867751 9.82 0.0456194 10.8825 0.126088 11.8266C0.169057 12.4321 0.217885 12.9595 0.26476 13.2977C0.495619 15.0059 1.54601 16.9005 2.70851 17.7056L2.71515 17.7102C3.52334 18.256 4.38942 18.7107 5.29757 19.0661C6.2171 19.4231 7.06085 19.6395 7.87765 19.7278H7.88468C8.98234 19.8259 9.97999 18.8731 10.2819 17.4802C10.5374 17.4395 10.7907 17.3933 11.0417 17.3415L11.0511 17.3395C12.6812 16.9786 14.1538 15.4516 14.4777 13.7872C14.5597 13.3755 14.6476 12.6595 14.7187 11.822C14.7352 11.626 14.6733 11.4314 14.5465 11.2811C14.4197 11.1307 14.2385 11.0368 14.0425 11.02Z" fill="#B0B3B7"/>
                <path d="M20.0034 8.98056C20.0034 8.95595 20.0034 8.93134 19.9995 8.90673C19.9997 8.90517 19.9997 8.9036 19.9995 8.90204C19.9972 8.87896 19.9937 8.85601 19.989 8.83329V8.82821C19.9597 8.68715 19.8897 8.55775 19.7878 8.45595L17.1315 5.79735C16.9924 5.65811 16.8036 5.57987 16.6067 5.57983C16.4098 5.5798 16.221 5.65797 16.0817 5.79716C15.9425 5.93634 15.8643 6.12514 15.8642 6.32202C15.8642 6.5189 15.9424 6.70772 16.0815 6.84696L17.4749 8.23993H12.3511C12.1542 8.23993 11.9655 8.31813 11.8263 8.45731C11.6871 8.5965 11.6089 8.78528 11.6089 8.98212C11.6089 9.17896 11.6871 9.36774 11.8263 9.50692C11.9655 9.64611 12.1542 9.72431 12.3511 9.72431H17.4683L16.0761 11.1165C15.9374 11.2558 15.8596 11.4444 15.8598 11.641C15.86 11.8376 15.9382 12.026 16.0772 12.165C16.2162 12.304 16.4046 12.3822 16.6012 12.3824C16.7978 12.3826 16.9864 12.3048 17.1257 12.1661L19.7698 9.52196C19.8657 9.43215 19.9359 9.31832 19.9729 9.19228C19.9797 9.1698 19.9851 9.14698 19.9894 9.12392C19.9895 9.12066 19.9895 9.1174 19.9894 9.11415C19.9929 9.09423 19.9964 9.07509 19.9983 9.05399C20.0003 9.0329 19.9983 9.02352 19.9983 9.00868C19.9983 9.00009 19.9983 8.99149 19.9983 8.9829L20.0034 8.98056Z" fill="#B0B3B7"/>
                </g>
                <defs>
                <clipPath id="clip0_212_3194">
                <rect width="20" height="20" fill="white"/>
                </clipPath>
                </defs>
                </svg><span>Logout</span>
            </a>
        </li>
    </ul>

    </aside>
  </div>
