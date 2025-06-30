@extends('layouts.app', ['page_title' => 'Login'])

@section('title', 'Login')

@section('content')
    <div>
        <h2 class="text-center mb-4">Welcome Back!</h2>
        <p class="text-center text-muted mb-4">Sign in to your account</p>

        <!-- Login Form -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" autocomplete="email" placeholder="you@example.com">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" name="password" type="password"
                    class="form-control @error('password') is-invalid @enderror" autocomplete="current-password"
                    placeholder="••••••••">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                    <label class="form-check-label" for="remember_me">
                        Remember me
                    </label>
                </div>
                <div>
                    <a href="#" class="text-decoration-none">Forgot your password?</a>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    Login
                </button>
            </div>
        </form>

        <p class="text-center text-muted mt-4">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-decoration-none">Register here</a>
        </p>
    </div>
@endsection
