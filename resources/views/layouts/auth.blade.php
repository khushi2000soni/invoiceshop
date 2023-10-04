<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <meta name="description" content="">
 @include('partials.hscript')

</head>
<body class="background-image-body">
    <div class="loader"></div>
    <div id="app">
        @yield('main-content')
    </div>
    <!-- General JS Scripts -->
  <script src="{{ asset('admintheme/assets/js/app.min.js') }}"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="{{ asset('admintheme/assets/js/scripts.js') }}"></script>

  </body>



</html>
