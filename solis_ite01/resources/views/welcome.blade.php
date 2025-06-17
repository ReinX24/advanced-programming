@extends('layouts.app', ['page_title' => 'ITP17 - Project'])

@section('content')
    <div class="container my-5">
        <div class="p-5 text-center bg-body-tertiary rounded-3">
            <div class="d-flex justify-content-center"> <!-- Optional: Center the image horizontally -->
                <img src="{{ asset('images/students.png') }}" alt="student icon" class="img-fluid w-25">
            </div>
            <h1 class="text-body-emphasis my-3">Student Management System</h1>
            <p class="col-lg-8 mx-auto fs-5 text-muted">
                A system for managing student information.
            </p>
            <div class="d-inline-flex gap-2 mb-5">
                <a class="d-inline-flex align-items-center btn btn-primary btn-lg px-4 rounded-pill"
                    href="{{ route('login') }}">
                    Login
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        class="ms-2 bi bi-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8" />
                    </svg>
                </a>
                <a class="btn btn-outline-secondary btn-lg px-4 rounded-pill" href="{{ route('register') }}">
                    Register
                </a>
            </div>
        </div>
    </div>
@endsection
