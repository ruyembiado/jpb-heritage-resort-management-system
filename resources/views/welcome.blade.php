@extends('layouts.public') <!-- Extend the main layout -->

@section('content')
    <main style="height: 85vh !important;"
        class="content px-3 py-1 col-12 home-bg d-flex justify-content-start align-items-center" id="page-top">
        <div class="container-fluid col-10 m-auto">
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

            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <div class="col-8 justify-content-center align-items-center gap-3">
                    <div class="title-container text-center">
                        <img src="{{ asset('public/img/jbp-icon.jpg') }}" class="img-fluid" width="20%" alt="jpb-logo">
                        <h1 class="text-light home-title m-0 text-uppercase mt-4">JPB Oasis: Heritage Inland Resort</h1>
                    </div>
                    <div class="d-flex flex-column gap-5 mt-5">
                        <div class="home-description text-center text-light">
                            <span>Management Information System for JPB Inland Resort</span><br>
                            <span>Progreso Street Illauod, Bugasong, Antique</span>
                        </div>
                    </div>
                </div>
                <div class="col-4 m-auto d-flex justify-content-center align-items-center">
                    <div class="container d-flex justify-content-center align-items-center py-5">
                        <div class="card shadow border-0 rounded-4" style="max-width:400px; width:100%;">
                            <div class="card-body p-3">
                                <div class="text-center text-light d-flex flex-column align-items-center mb-4 bg-theme-primary rounded-4 p-3">
                                    <img src="{{ asset('public/img/jbp-icon.jpg') }}" alt="jpb-logo" class="img-fluid"
                                        width="100">

                                    <h4 class="mt-2 fw-bold">
                                        ADMIN
                                    </h4>
                                    <small>
                                        Enter your username and password to log in
                                    </small>
                                </div>

                                <form action="{{ route('login') }}" method="post">
                                    @csrf

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            @foreach ($errors->all() as $error)
                                                <div>{{ $error }}</div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- USERNAME -->
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>

                                        <div class="input-group">
                                            <span class="input-group-text bg-theme-primary text-light">
                                                <i class="fas fa-user"></i>
                                            </span>

                                            <input type="text"
                                                class="form-control @error('username') is-invalid @enderror" name="username"
                                                value="{{ old('username') }}" placeholder="Enter username" required>
                                        </div>

                                        @error('username')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- PASSWORD -->
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>

                                        <div class="input-group">
                                            <span class="input-group-text bg-theme-primary text-light">
                                                <i class="fas fa-lock"></i>
                                            </span>

                                            <input type="password" class="form-control" id="passwordInput" name="password"
                                                placeholder="Enter password">

                                            <span class="input-group-text bg-theme-primary text-light"
                                                style="cursor:pointer;" id="togglePasswordContainer">

                                                <svg class="svg-inline--fa fa-eye" id="togglePassword" aria-hidden="true"
                                                    focusable="false" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 576 512" width="18">

                                                    <path fill="currentColor"
                                                        d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z">
                                                    </path>
                                                </svg>
                                            </span>
                                        </div>

                                        @error('password')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- BUTTON -->
                                    <button type="submit" class="btn bg-theme-primary text-light w-100 py-2 rounded-3">
                                        Login
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
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
