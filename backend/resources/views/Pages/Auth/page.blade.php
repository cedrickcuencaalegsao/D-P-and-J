@extends('Layout.app')

@section('title', 'Login')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-md-4 col-lg-4 col-xl-4">
            <div class="shadow p-3 mb-5 bg-body-tertiary rounded">
                <form action="{{ route('validateLogin') }}" method="POST">
                    @csrf
                    <div class="card-header">
                        <h1 class="display-5">Login</h1>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" class="form-control" id="email"
                            aria-describedby="emailHelp" autocomplete="email">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password"
                            autocomplete="current-password">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
