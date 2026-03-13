@extends('layouts.public') <!-- Extend the main layout -->

@section('content')
    <main class="content px-3 py-4 col-12 home-bg d-flex justify-content-start align-items-center" id="page-top">
        <div class="container-fluid col-11 m-auto">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="row justify-content-center align-items-center gap-3">
                <div class="col-12">
                    <div class="d-flex flex-column flex-lg-row align-items-center gap-4">
                        <div class="flex-grow-1 text-center text-lg-start">
                            <div class="title-container mb-3 mb-lg-0">
                                <h6 class="text-light welcome-text m-0">Welcome to</h6>
                                <div class="my-3 my-lg-5">
                                    <h1 class="text-light home-title m-0">JPB Heritage Inland Resort</h1>
                                    <h6 class="text-light welcome-text m-0">Management Information System</h6>
                                </div>
                            </div>
                            <div class="home-description text-light">
                                <i>Preserving Heritage, Elevating Hospitality</i>
                            </div>
                        </div>
                        <div class="flex-shrink-0 text-center">
                            <img src="{{ asset('public/img/jbp-icon.jpg') }}" class="img-fluid" style="max-width: 300px;"
                                alt="jbp-logo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:400px;"> <!-- custom width -->
            <div class="modal-content">

                <div class="modal-header">
                    <div class="col-12">
                        <div class="text-end">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="text-center d-flex flex-column align-items-center">
                            <img src="{{ asset('public/img/jbp-icon.jpg') }}" width="70" alt="jbp-logo">
                            <b class="modal-title mt-2 text-bold" id="loginModalLabel">JPB Heritage Inland Resort</b>
                        </div>
                    </div>
                </div>

                <div class="modal-body">

                    <form action="{{ route('login') }}" method="post">
                        @csrf

                        <div class="mb-4 text-center">
                            <label class="h6 mb-0">Log in to your account</label>
                            <div>Enter your username and password to log in</div>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-theme-primary text-light">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    name="username" value="{{ old('username') }}" placeholder="Enter username" required>
                            </div>
                            @error('username')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-theme-primary text-light"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="passwordInput" name="password"
                                    placeholder="Enter password">
                                <span class="input-group-text bg-theme-primary text-light" style="cursor:pointer;"
                                    id="togglePasswordContainer">
                                    <!-- Inline SVG eye icon -->
                                    <svg class="svg-inline--fa fa-eye" id="togglePassword" aria-hidden="true"
                                        focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path fill="currentColor"
                                            d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success border-none bg-theme-primary text-light w-100 mt-2">
                            Login
                        </button>

                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // Show login modal if errors exist
        @if ($errors->any())
            var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();
        @endif

        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("passwordInput");

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener("click", function() {
                // Toggle password type
                if (passwordInput.type === "password") {
                    passwordInput.type = "text"; // show password
                } else {
                    passwordInput.type = "password"; // hide password
                }
            });
        }

    });
</script>
