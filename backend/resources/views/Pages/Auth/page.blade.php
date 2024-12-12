@extends('Layout.app')

@section('title', 'Login')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100  px-4">
        <div class="col-12 col-md-6 col-lg-5">
            <div class="card shadow-lg p-4">
                <!-- Centered Logo -->
                <div class="text-center mb-4">
                    <img src="{{ url('api/images/default.jpg') }}" alt="Logo" class="rounded-circle"
                        style="width: 80px; height: 80px;">
                </div>

                <!-- Form Title -->
                <h2 class="text-center mb-4">Welcome Back</h2>

                <!-- Error Message Display -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('validateLogin') }}" method="POST">
                    @csrf
                    <!-- Email Input -->
                    <div class="mb-3">
                        <label for="email" class="form-label text-secondary">Email Address</label>
                        <input type="email" class="form-control bg-light" id="email" name="email"
                            placeholder="Enter your email" value="{{ old('email') }}" autocomplete="email">
                    </div>

                    <!-- Password Input -->
                    <div class="mb-3">
                        <label for="password" class="form-label text-secondary">Password</label>
                        <input type="password" class="form-control bg-light" id="password" name="password"
                            placeholder="Enter your password" autocomplete="current-password">
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>

                    <!-- Login Button -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-2">Login</button>
                    </div>
                </form>

                <!-- Register Link -->
                <p class="text-center text-muted mt-3 small">
                    Don't have an account?
                    {{-- {{ route('register') }} --}}
                    <a href="#" class="text-primary text-decoration-none">Register here</a>
                </p>
            </div>
        </div>
    </div>
@endsection
