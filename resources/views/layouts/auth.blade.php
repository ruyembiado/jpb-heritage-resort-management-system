<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JPB HERITAGE</title>

    <!-- Bootstrap Style -->
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Fontawesome Style -->
    <link href="{{ asset('public/css/fontawesome.min.css') }}" rel="stylesheet">
    <!-- Datatables -->
    <link href="{{ asset('public/css/datatables.min.css') }}" rel="stylesheet">
    <!-- Select2 Style -->
    <link href="{{ asset('public/css/select2.min.css') }}" rel="stylesheet">
    <!-- Custom Styles -->
    <link href="{{ asset('public/css/styles.css') }}" rel="stylesheet">
    <!-- Custom Styles -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar" class="bg-theme-primary expand">
            <div class="d-flex gap-1 justify-content-center pt-4">
                <div class="site-log">
                    <a href="/dashboard">
                        <img src="{{ asset('img/eggcellent-logo.webp') }}" width="70" alt="pereyras-logo">
                    </a>
                </div>
                <div class="sidebar-logo">
                    <a href="/dashboard">JPB HERITAGE</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="/dashboard" class="sidebar-link">
                        <i class="fa fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            </ul>
        </aside>
        <div class="main bg-gradient">
            <nav class="navbar navbar-expand px-4 py-3 bg-theme-secondary">
                <div class="navbar-collapse collapse">
                    <button class="toggle-btn" type="button">
                        <i class="fa-solid text-dark fa fa-bars fs-5"></i>
                    </button>
                    <ul class="navbar-nav ms-auto">
                        @auth
                            <span class="m-auto me-1">
                                @auth
                                    {{ auth()->user()->name }}
                                @endauth
                            </span>
                        @endauth
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-stat-icon pe-md-0">
                                <a data-bs-toggle="dropdown" class="nav-stat-icon pe-md-0" href="#">
                                    <i class="text-dark fas fa-user-circle avatar"></i>
                                </a>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end rounded animated--fade-in">
                                <a class="dropdown-item" href="">
                                    <i class="text-primary fas fa-user fa-sm fa-fw mr-2"></i>
                                    Profile
                                </a>
                                {{-- 
                                <a class="dropdown-item" href="#">
                                    <i class="text-primary fas fa-cogs fa-sm fa-fw mr-2"></i>
                                    Settings
                                </a>
                                <div class="dropdown-divider"></div> --}}
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#logoutModal">
                                    <i class="text-primary fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="content px-3 py-4 bg-theme-secondary" id="page-top">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="container-fluid">
                    @yield('content')
                </div>
            </main>
            <footer class="footer py-3 shadow text-center">
                <div class="d-flex justify-content-between px-3">
                    <div class="">© 2025 JPB OASIS. All rights reserved.</div>
                </div>
            </footer>
        </div>
    </div>

    <!-- jQuery Script -->
    <script src="{{ asset('public/js/jquery.min.js') }}"></script>
    <!-- Bootstrap Script -->
    <script src="{{ asset('public/js/bootstrap.min.js') }}"></script>
    <!-- Datatables -->
    <script src="{{ asset('public/js/datatables.min.js') }}"></script>
    <!-- Fontawesome Script -->
    <script src="{{ asset('public/js/fontawesome.min.js') }}"></script>
    <!-- Select2 Script -->
    <script src="{{ asset('public/js/select2.min.js') }}"></script>

    <!-- Print.js JS -->
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

    <!--Custom Script -->
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        function hideAlerts(delay = 3000) {
            console.log('Hiding alerts');
            if ($('.alert-success, .alert-danger').length) {
                setTimeout(function() {
                    $('.alert-success, .alert-danger').fadeOut('slow');
                }, delay);
            }
        }
        hideAlerts();
    </script>
</body>

</html>
