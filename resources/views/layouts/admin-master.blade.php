<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>
    @yield('page-title') - {{ setting('app_name') }}</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css')}}">

  <!-- Local CSS -->
  <style type="text/css">


  </style>
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        @include('partials.topnav')
      </nav>  
      
      <div class=" main-sidebar sidebar-style-2 bg-dark text-white">
        @include('partials.sidebar')
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section ">
          <div class="section-header">
            <h1>@yield('page-heading')</h1>
            @yield('breadcrumbs')
          </div>
          <div class="section-body">
            @yield('content')
          </div>
        </section>
      </div>
      <footer class="main-footer">
        @include('partials.footer')
      </footer>
    </div>
  </div>

  {{-- <script src="{{ route('js.dynamic') }}"></script> --}}
  <script src="{{ asset('assets/js/vendor.js') }}"></script>
  <script src="{{ asset('assets/js/as/app.js') }}"></script>
  {{-- <script src="{{ asset('js/app.js') }}?{{ uniqid() }}"></script> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="{{ asset('assets/js/moment.min.js') }}"></script>
  {{-- <script src="{{ asset('assets/js/stisla.js') }}"></script> --}}
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  @yield('scripts')
</body>
</html>
