@extends('layouts.public') <!-- Extend the main layout -->

@section('content')
    <main class="content px-3 py-4 col-12 home-bg d-flex justify-content-start align-items-center" id="page-top">
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
        <div class="container-fluid col-10 m-auto">
            <div class="row justify-content-center align-items-center gap-3">
                <div class="title-container">
                    <h6 class="text-light welcome-text m-0">Welcome to</h6>
                    <h1 class="text-light home-title m-0">JPB Heritage Inland Resort</h1>
                </div>
                <div class="d-flex flex-column gap-5">
                    <div class="home-description text-light">
                        <i>"JPB OASIS: Preserving Heritage, Elevating Hospitality"</i>
                    </div>
                    @if (!auth()->check())
                        <div class="auth-buttons d-flex gap-3">
                            <!-- Button to toggle the Login Offcanvas -->
                            <button class="btn btn-light" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#loginOffcanvas" aria-controls="loginOffcanvas">
                                Login
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Offcanvas for the Login Form -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="loginOffcanvas" aria-labelledby="loginOffcanvasLabel">
        <div class="offcanvas-body">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="loginOffcanvasLabel">Login</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-logo text-center">
                <img src="{{ asset('public/img/jbp-icon.png') }}" alt="eggcellent-logo" class="img-fluid" width="200">
            </div>
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <form action="{{ route('login') }}" method="post">
                @csrf

                <div class="mb-2">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                        name="username" value="{{ old('username') }}" required>
                    @error('username')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" required>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-2">
                    <button type="submit" class="btn btn-warning">Login</button>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        @if ($errors->any())
            @if (old('email') && !old('name'))
                // Open login offcanvas if email exists but not name (login form)
                var loginOffcanvas = new bootstrap.Offcanvas(document.getElementById('loginOffcanvas'));
                loginOffcanvas.show();
            @else
                // Open register offcanvas if name exists (register form)
                var registerOffcanvas = new bootstrap.Offcanvas(document.getElementById('registerOffcanvas'));
                registerOffcanvas.show();
            @endif
        @endif
    });
</script>
