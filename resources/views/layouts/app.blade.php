<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ secure_asset('js/app,js')}}')" defer></script>

    <link rel="icon" href="{{ secure_asset('images/favicon.ico')}}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/bootstrap/css/bootstrap.min.css') }}">
    <!-- waves.css -->
    <link rel="stylesheet" href="{{ secure_asset('pages/waves/css/waves.min.css') }}" type="text/css" media="all">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('icon/themify-icons/themify-icons.css') }}">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href=" {{ secure_asset('icon/icofont/css/icofont.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('icon/font-awesome/css/font-awesome.min.css') }}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{secure_asset('css/style.css') }}">
     <!-- Style.css -->
     <link rel="stylesheet" type="text/css" href="{{secure_asset('css/custom.css') }}">
</head>
<body @yield('theme')>
  <!-- Pre-loader start -->
  <div id="app">
  <div class="theme-loader">
      <div class="loader-track">
          <div class="preloader-wrapper">
              <div class="spinner-layer spinner-blue">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
              <div class="spinner-layer spinner-red">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
            
              <div class="spinner-layer spinner-yellow">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
            
              <div class="spinner-layer spinner-green">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- Pre-loader end -->
  <!--content-->
    @yield('content')
  <!-- #region -->
  </div>
    <script type="text/javascript" src="{{ secure_asset('js/app.js') }}"></script>
    <!-- Required Jquery -->
    <script type="text/javascript" src="{{ secure_asset('js/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ secure_asset('js/jquery-ui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ secure_asset('js/popper.js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ secure_asset('js/bootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ secure_asset('pages/widget/excanvas.js')}} "></script>
    <!-- waves js -->
    <script src="{{ secure_asset('pages/waves/js/waves.min.js') }}"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{ secure_asset('js/jquery-slimscroll/jquery.slimscroll.js') }}"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{ secure_asset('js/modernizr/modernizr.js') }}"></script>
    <!-- slimscroll js -->
    <script type="text/javascript" src="{{ secure_asset('js/SmoothScroll.js') }}"></script>
    <script src="{{ asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Chart js -->
    <script type="text/javascript" src="{{ secure_asset('js/chart.js/Chart.js') }}"></script>
    <!-- amchart js -->
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="{{ secure_asset('pages/widget/amchart/gauge.js') }}"></script>
    <script src="{{ secure_asset('pages/widget/amchart/serial.js') }}"></script>
    <script src="{{ secure_asset('pages/widget/amchart/light.js') }}"></script>
    <script src="{{ secure_asset('pages/widget/amchart/pie.min.js') }}"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <!-- menu js -->
    <script src="{{ secure_asset('js/pcoded.min.js') }}"></script>
    <script src="{{ secure_asset('js/vertical-layout.min.js') }}"></script>
    <!-- custom js -->
    <script type="text/javascript" src="{{ secure_asset('pages/dashboard/custom-dashboard.js') }}"></script>
    <script type="text/javascript" src="{{ secure_asset('js/script.js') }}"></script>
    @yield("customScripts")
    @yield("viewModalScript")
</body>
</html>
