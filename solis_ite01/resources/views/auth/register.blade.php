@extends('layouts.app', ['page_title' => 'Register'])

@section('title', 'Register')

@section('content')
    <div>
        <h2 class="text-center mb-4">Welcome!</h2>
        <p class="text-center text-muted mb-4">Register a new account</p>

        <!-- Login Form -->
        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Username</label>
                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" autocomplete="name" placeholder="John Doe">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" name="email" type="email"
                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                    autocomplete="email" placeholder="johndoe@example.com">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" name="password" type="password"
                    class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password"
                    class="form-control @error('password_confirmation') is-invalid @enderror
                    placeholder="••••••••">
                @error('password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    Register
                </button>
            </div>
        </form>

        <p class="text-center text-muted mt-4">
            Have an account?
            <a href="{{ route('login') }}" class="text-decoration-none">Login here</a>
        </p>
    </div>
@endsection
