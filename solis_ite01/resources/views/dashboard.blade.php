@extends('layouts.app', ['page_title' => 'Dashboard'])

@section('title', 'Dashboard')

@section('content')
    <div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show fs-5" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Students Card -->
            <div class="col-md-6 col-lg-6">
                <div class="card shadow-sm h-100 border-primary">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary">Recorded Students</h5>
                        <p class="card-text display-4 fw-bold mb-0">{{ $studentCount }}</p>
                        <p class="text-muted">Total number of students</p>
                    </div>
                    <div class="card-footer bg-light border-0">
                        <a href="{{ route('students.index') }}" class="btn btn-md btn-outline-primary w-100">View All
                            Students</a>
                    </div>
                </div>
            </div>

            <!-- Users Card -->
            <div class="col-md-6 col-lg-6">
                <div class="card shadow-sm h-100 border-success">
                    <div class="card-body text-center">
                        <h5 class="card-title text-success">Recorded Users</h5>
                        <p class="card-text display-4 fw-bold mb-0">{{ $profileCount }}</p>
                        <p class="text-muted">Total number of users</p>
                    </div>
                    <div class="card-footer bg-light border-0">
                        <a href="{{ route('users.index') }}" class="btn btn-md btn-outline-success w-100">View Users</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
