<!DOCTYPE html>
<html lang="en">
<head>
  <title>@yield('title')</title>
  <meta name="description" content="@yield('metdescp')">
 @include('partials.hscript')
 <meta name="csrf-token" content="{{ csrf_token() }}" >
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      @include('partials.header')

      @include('partials.sidebar')
      <!-- Main Content -->
      <div class="main-content">

        @yield('main-content')

      </div>
      @include('partials.footer')
    </div>
  </div>
  @include('partials.fscript')

</body>

<script type="text/javascript">
  $.ajaxSetup({
      headers:{
        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
      }

  })

</script>

@yield('customJS')
</html>
