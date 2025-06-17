@extends('layouts.app', ['page_title' => 'Student Details'])

@section('title', "Student #$student->id")

@section('content')
    <div class="container pb-4">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show fs-5" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center"> {{-- Changed to bg-info for a different color --}}
                        <h2 class="mb-0">Student Details: {{ $student->fname }} {{ $student->lname }}</h2>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">First Name:</dt>
                            <dd class="col-sm-8">{{ $student->fname }}</dd>

                            <dt class="col-sm-4">Last Name:</dt>
                            <dd class="col-sm-8">{{ $student->lname }}</dd>

                            <dt class="col-sm-4">Email:</dt>
                            <dd class="col-sm-8">{{ $student->email }}</dd>

                            <dt class="col-sm-4">Contact Number:</dt>
                            <dd class="col-sm-8">{{ $student->contact_number ?? 'N/A' }}</dd> {{-- Use ?? 'N/A' for nullable fields --}}

                            <dt class="col-sm-4">Gender:</dt>
                            <dd class="col-sm-8">{{ $student->gender ?? 'N/A' }}</dd>

                            <dt class="col-sm-4">Birthdate:</dt>
                            <dd class="col-sm-8">
                                {{ $student->birthdate ? \Carbon\Carbon::parse($student->birthdate)->format('F d, Y') : 'N/A' }}
                            </dd> {{-- Format date nicely --}}

                            <dt class="col-sm-4">Address:</dt>
                            <dd class="col-sm-8">{{ $student->complete_address ?? 'N/A' }}</dd>

                            <dt class="col-sm-4">Bio:</dt>
                            <dd class="col-sm-8">{{ $student->bio ?? 'N/A' }}</dd>

                            <dt class="col-sm-4">Joined Date:</dt>
                            <dd class="col-sm-8">{{ $student->created_at->format('F d, Y h:i A') }}</dd>
                            {{-- Display creation date --}}
                        </dl>

                        <div class="d-grid gap-2 mt-4">
                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary btn-lg">Edit
                                Student</a>
                            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-lg">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Any specific JavaScript for this page can go here
    </script>
@endpush
