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
    <link href="{{ asset('public/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/fontawesome.min.css') }}" rel="stylesheet">
    <!-- Datatables -->
    <link href="{{ asset('public/css/datatables.min.css') }}" rel="stylesheet">
    <!-- Select2 Style -->
    <link href="{{ asset('public/css/select2.min.css') }}" rel="stylesheet">
    <!-- Select2 Bootstrap Styles -->
    <link href="{{ asset('public/css/select2-bootstrap4.min.css') }}" rel="stylesheet">
    <!-- Custom Styles -->
    <link href="{{ asset('public/css/styles.css') }}" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar" class="bg-primary-theme expand">
            <div class="d-flex flex-column gap-1 align-items-center justify-content-center pt-4">
                <div class="site-log">
                    <a href="{{ url('/dashboard') }}">
                        <img src="{{ asset('public/img/jbp-icon.jpg') }}" width="60" alt="jbp-logo">
                    </a>
                </div>
                <div class="sidebar-logo">
                    <a href="{{ url('/dashboard') }}">JPB Heritage Inland Resort</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <hr class="sidebar-hr text-light mt-2 mb-1">
                <li class="sidebar-item">
                    <a href="{{ url('/dashboard') }}"
                        class="sidebar-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <hr class="sidebar-hr text-light mt-1 mb-2">
                <b class="text-light ms-2">GUEST</b>
                <li class="sidebar-item mt-1">
                    <a href="{{ url('/entrances') }}" class="sidebar-link {{ Request::is('entrances*') || Request::is('meals*') || Request::is('accommodations*') || Request::is('function-halls*') || Request::is('cottages*') || Request::is('beverages*') ? 'active' : '' }}">
                        <i class="fa fa-book"></i>
                        <span>Availed Services</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('/bill-history') }}" class="sidebar-link {{ Request::is('bill-history') ? 'active' : '' }}">
                        <i class="fa fa-money-bill"></i>
                        <span>Bill History</span>
                    </a>
                </li>
                <hr class="sidebar-hr text-light mt-1 mb-2">
                <b class="text-light ms-2">STAFF</b>
                <li class="sidebar-item">
                    <a href="{{ url('/staff') }}" class="sidebar-link {{ Request::is('staff*') ? 'active' : '' }}">
                        <i class="fa fa-users"></i>
                        <span>List & Attendance</span>
                    </a>
                </li>
                <hr class="sidebar-hr text-light mt-1 mb-2">
                <b class="text-light ms-2">REPORT</b>
                <li class="sidebar-item">
                    <a href="{{ url('/bills') }}" class="sidebar-link">
                        <i class="fa fa-money-bill"></i>
                        <span>Bill Income</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('/report') }}" class="sidebar-link">
                        <i class="fa fa-file"></i>
                        <span>List of Guest</span>
                    </a>
                </li>
                <hr class="sidebar-hr text-light mt-1 mb-2">
                <b class="text-light ms-2">SETTINGS</b>
                <li class="sidebar-item">
                    <a href="{{ url('/services') }}" class="sidebar-link">
                        <i class="fa fa-cog"></i>
                        <span>Services</span>
                    </a>
                </li>
            </ul>
        </aside>
        <div class="main bg-gradient">
            <nav class="navbar navbar-expand px-4 py-3 bg-dark">
                <div class="navbar-collapse collapse">
                    <button class="toggle-btn" type="button">
                        <i class="fa-solid text-light fa fa-bars fs-5"></i>
                    </button>
                    <ul class="navbar-nav ms-auto">
                        @auth
                            <span class="m-auto me-1 text-light">
                                @auth
                                    {{ auth()->user()->name }}
                                @endauth
                            </span>
                        @endauth
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-stat-icon pe-md-0">
                                <i class="text-light fas fa-user-circle avatar"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end rounded animated--fade-in">
                                {{-- <a class="dropdown-item" href="">
                                    <i class="text-primary fas fa-user fa-sm fa-fw mr-2"></i>
                                    Profile
                                </a> --}}
                                <a class="dropdown-item" href="{{ url('/logout') }}">
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
            <footer class="footer bg-dark py-3 shadow text-center">
                <div class="d-flex justify-content-center px-3">
                    <div class="text-light">© {{ date('Y') }}. Developed by IS-FLUTTERTECH INFINITY. All rights
                        reserved.</div>
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
    <script src="{{ asset('public/js/all.min.js') }}"></script>
    {{-- <script src="{{ asset('public/js/fontawesome.min.js') }}"></script> --}}
    <!-- Select2 Script -->
    <script src="{{ asset('public/js/select2.min.js') }}"></script>

    <!-- Print.js JS -->
    <script src="{{ asset('public/js/print.min.js') }}"></script>

    <!-- FullCalendar JS -->
    <script src="{{ asset('public/js/index.global.min.js') }}"></script>

    <!--Custom Script -->
    <script src="{{ asset('public/js/script.js') }}"></script>
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
