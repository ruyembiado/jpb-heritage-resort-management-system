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
</head>

<body>
    <div class="wrapper">
        <div class="main">
            <nav class="navbar-expand bg-black px-4 py-1 shadow-sm">
                <div class="col-10 m-auto d-flex justify-content-between flex-wrap align-items-center">
                    <div class="d-flex flex-wrap align-items-center">
                        <img src="{{ asset('public/img/jbp-icon.jpg') }}" width="70" alt="jbp-logo">
                        <h5 class="ms-2 mb-0 text-light">JPB OASIS: HERITAGE INLAND RESORT</h5>
                    </div>
                    <div class="d-flex align-items-center gap-5">
                        @if (auth()->user())
                            <ul class="navbar-nav ms-auto">
                                <span class="m-auto me-1 text-light">{{ Str::ucfirst(auth()->user()->username) }}</span>
                                <li class="nav-item dropdown">
                                    <a href="#" data-bs-toggle="dropdown" class="nav-stat-icon pe-md-0">
                                        <a data-bs-toggle="dropdown" class="nav-stat-icon pe-md-0"
                                            href="#">
                                            <i class="text-light fas fa-user-circle avatar"></i>
                                        </a>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end rounded animated--fade-in">
                                        {{-- <a class="dropdown-item" href="#">
                                            <i class="text-primary fas fa-user fa-sm fa-fw mr-2"></i>
                                            Profile
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="text-primary fas fa-cogs fa-sm fa-fw mr-2"></i>
                                            Settings
                                        </a>
                                        <div class="dropdown-divider"></div> --}}
                                        <a class="dropdown-item" href="" data-toggle="modal"
                                            data-target="#logoutModal">
                                            <i class="text-primary fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                                            Logout
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        @endif
                    </div>
                </div>
            </nav>

            @yield('content')

            <footer class="footer py-2 shadow text-center bg-black text-light">
                <div class="m-auto">
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
    <!-- Custom Script -->
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
