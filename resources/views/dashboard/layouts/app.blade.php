<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin Panel') | {{ domain_name() }}</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ favicon_url() }}">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">

    <!-- Dashboard theme -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}?v=20260925">

    @yield('page-css')
</head>
<body class="rsd-body">

    @include('dashboard.partials.sidebar')

    <div class="rsd-overlay" id="rsdOverlay"></div>

    <div class="rsd-main">
        @include('dashboard.partials.navbar')

        <main class="rsd-content">
            @yield('content')
        </main>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- Bootstrap bundle -->
    <script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Sidebar toggle -->
    <script>
        (function () {
            var sidebar = document.getElementById('rsdSidebar');
            var overlay = document.getElementById('rsdOverlay');

            window.rsdToggleSidebar = function () {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('show');
            };

            overlay.addEventListener('click', function () {
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
            });
        })();
    </script>

    @yield('page-js')
</body>
</html>
