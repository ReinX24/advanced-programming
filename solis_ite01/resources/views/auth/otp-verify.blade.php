@extends('layouts.app', ['page_title' => 'Login OTP'])

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>
                    <div class="card-body">

                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show fs-5" role="alert">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('otp.verify') }}">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">

                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end" for="otp">One-Time Password</label>

                                <div class="col-md-6">
                                    <input class="form-control @error('email') is-invalid @enderror" id="otp"
                                        type="text" name="otp" required autofocus>
                                </div>

                                @error('otp')
                                    <span>{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Verify OTP</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
