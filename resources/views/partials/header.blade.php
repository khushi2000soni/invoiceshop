<div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn"><i
                  class="fas fa-bars"></i></a></li>
            {{-- <li>
              <div class="search-group">
                <span class="nav-link nav-link-lg" id="search">
                  <i class="fa fa-search" aria-hidden="true"></i>
                </span>
                <input type="text" class="search-control" placeholder="search" aria-label="search"
                  aria-describedby="search">
              </div>
            </li> --}}
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
            <li>
                <a href="{{ route('products.index')}}" class="nav-link nav-link-lg btn btn-outline-dark icon-left default_btn add_item_btn">
                  <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="30" height="30" x="0" y="0" viewBox="0 0 13.758 13.758" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M3.76 3.44v.267l.53-.001V3.44c0-.884.703-1.588 1.587-1.588s1.587.704 1.587 1.588v.264h.53V3.44a2.118 2.118 0 0 0-4.234 0zm-1.587.793a.265.265 0 0 0-.264.247l-.53 7.673c-.01.153.111.282.265.282h6.859c-.918-.646-1.36-1.878-1.058-2.96C7.733 8.33 8.82 7.45 10.001 7.41l.046-.001-.202-2.93a.265.265 0 0 0-.264-.247zm2.36 1.588H7.22a.265.265 0 0 1 0 .529H4.534a.265.265 0 0 1 0-.53zm5.597 2.116a2.253 2.253 0 0 0-2.249 2.25 2.253 2.253 0 0 0 2.25 2.248 2.253 2.253 0 0 0 2.248-2.249 2.253 2.253 0 0 0-2.249-2.249zm0 1.059c.147 0 .265.118.265.264v.662h.661a.265.265 0 0 1 0 .529h-.661v.661a.265.265 0 0 1-.53 0v-.661h-.66a.265.265 0 0 1 0-.53h.66v-.66c0-.147.12-.265.265-.265z" fill="#fff" opacity="1" data-original="#fff" class=""></path></g></svg> @lang('quickadmin.dashboard.add_product')
                </a>
            </li>
            <li>
                <a href="{{ route('customers.index')}}" class="nav-link nav-link-lg btn btn-outline-dark icon-left mx-2 default_btn add_party_btn"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path fill="#fff" fill-rule="evenodd" d="M17 6A5 5 0 1 1 7 6a5 5 0 0 1 10 0zm-7 7a7 7 0 0 0-7 7 3 3 0 0 0 3 3h7.41c.431 0 .677-.528.453-.898A5.972 5.972 0 0 1 13 19a5.993 5.993 0 0 1 2.56-4.917c.364-.255.333-.839-.101-.93-.47-.1-.959-.153-1.459-.153zm9 2a1 1 0 0 1 1 1v2h2a1 1 0 1 1 0 2h-2v2a1 1 0 0 1-2 0v-2h-2a1 1 0 1 1 0-2h2v-2a1 1 0 0 1 1-1z" clip-rule="evenodd" opacity="1" data-original="#fff" class=""></path></g></svg> @lang('quickadmin.dashboard.add_customer')</a>
            </li>
            @can('invoice_create')
            <li>
                <a href="{{ route('orders.create')}}" class="nav-link nav-link-lg btn btn-outline-dark icon-left default_btn add_invoice_btn"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 48 48" style="enable-background:new 0 0 512 512" xml:space="preserve" fill-rule="evenodd" class=""><g><path d="M35 35h-3a1 1 0 0 0 0 2h3v3a1 1 0 0 0 2 0v-3h3a1 1 0 0 0 0-2h-3v-3a1 1 0 0 0-2 0zM10 19h20a1 1 0 0 0 0-2H10a1 1 0 0 0 0 2zM10 25h20a1 1 0 0 0 0-2H10a1 1 0 0 0 0 2zM10 31h12a1 1 0 0 0 0-2H10a1 1 0 0 0 0 2zM10 37h12a1 1 0 0 0 0-2H10a1 1 0 0 0 0 2z" fill="#000000" opacity="1" data-original="#000000"></path><path d="M34.804 46.936c-.262.042-.53.064-.804.064H6a5 5 0 0 1-5-5V6c0-1.326.527-2.598 1.464-3.536A5.004 5.004 0 0 1 6 1h18.343c1.326 0 2.598.527 3.536 1.464l9.657 9.657A5.004 5.004 0 0 1 39 15.657v9.758c4.615 1.307 8 5.554 8 10.585 0 6.071-4.929 11-11 11-.404 0-.802-.022-1.196-.064zM36 27c4.967 0 9 4.033 9 9s-4.033 9-9 9-9-4.033-9-9 4.033-9 9-9zm1-1.955v-9.388a3 3 0 0 0-.073-.657H30a5 5 0 0 1-5-5V3.073A3 3 0 0 0 24.343 3H6c-.796 0-1.559.316-2.121.879A2.996 2.996 0 0 0 3 6v36a3 3 0 0 0 3 3h23.677A10.99 10.99 0 0 1 25 36c0-6.071 4.929-11 11-11 .337 0 .67.015 1 .045zM35.586 13 27 4.414V10a3 3 0 0 0 3 3z" fill="#000000" opacity="1" data-original="#000000"></path></g></svg>@lang('quickadmin.dashboard.add_invoice')</a>
            </li>
            @endcan
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i class="fas fa-expand"></i>
                </a>
            </li>


          {{-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
              class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Notifications
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-icons">
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <span class="dropdown-item-icon bg-primary text-white">
                    <i class="fas fa-shopping-cart"></i>
                  </span>
                  <span class="dropdown-item-desc">
                    New Order
                    <span class="time">3 Hours Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <span class="dropdown-item-icon bg-info text-white">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                  </span>
                  <span class="dropdown-item-desc">
                    Application Error
                    <span class="time">7 Hours Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-icon bg-success text-white">
                    <i class="fa fa-power-off" aria-hidden="true"></i>
                  </span>
                  <span class="dropdown-item-desc">
                    Server restarted
                    <span class="time">9 Hours Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-icon bg-danger text-white">
                    <i class="fa fa-server" aria-hidden="true"></i>
                  </span>
                  <span class="dropdown-item-desc">
                    Your Subscription Expired
                    <span class="time">10 Hours Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-icon bg-purple text-white">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                  </span>
                  <span class="dropdown-item-desc">
                    You have <b>4</b> new followers
                    <span class="time">Yesterday</span>
                  </span>
                </a>
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li> --}}
          {{-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg"><i
                class="far fa-envelope"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Messages
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-message">
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="{{ asset('admintheme/assets/img/users/user-1.png') }}" class="image-square">
                  </span>
                  <span class="dropdown-item-desc">
                    <span class="message-user">Michael Gardner</span>
                    <span class="time messege-text">Analysis Project and Design Flowchart</span>
                    <span class="time">2 Min Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="{{ asset('admintheme/assets/img/users/user-2.png') }}" class="image-square">
                  </span>
                  <span class="dropdown-item-desc">
                    <span class="message-user">Nancy Burton</span>
                    <span class="time messege-text">Client meeting is cancelled</span>
                    <span class="time">5 Hour Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="{{ asset('admintheme/assets/img/users/user-5.png') }}" class="image-square">
                  </span>
                  <span class="dropdown-item-desc">
                    <span class="message-user">Amiah Smith</span>
                    <span class="time messege-text">Project Planning</span>
                    <span class="time">12 Hour Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="{{ asset('admintheme/assets/img/users/user-4.png') }}" class="image-square">
                  </span>
                  <span class="dropdown-item-desc">
                    <span class="message-user">John Doe</span>
                    <span class="time messege-text">Leave application !!</span>
                    <span class="time">1 Days Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="{{ asset('admintheme/assets/img/users/user-3.png') }}" class="image-square">
                  </span>
                  <span class="dropdown-item-desc">
                    <span class="message-user">Wiltor Stone</span>
                    <span class="time messege-text">Discussion about increment!</span>
                    <span class="time">2 Days Ago</span>
                  </span>
                </a>
                <a href="#" class="dropdown-item">
                  <span class="dropdown-item-avatar text-white">
                    <img alt="image" src="{{ asset('admintheme/assets/img/users/user-2.png') }}" class="image-square">
                  </span>
                  <span class="dropdown-item-desc">
                    <span class="message-user">Nancy Burton</span>
                    <span class="time messege-text">Upcoming project meeting</span>
                    <span class="time text-primary">3 Days Ago</span>
                  </span>
                </a>
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li> --}}

          <li class="dropdown"><a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img alt="image" src="{{ asset('admintheme/assets/img/user.png') }}" class="user-img-radious-style">
              <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title">Hello {{ Auth::user()->name }}</div>
              <a href="{{route('user.profile')}}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              <a href="{{route('user.change-password')}}" class="dropdown-item has-icon">
                <i class="fas fa-lock"></i> @lang('quickadmin.qa_change_password')
              </a>
              <div class="dropdown-divider"></div>
              <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
