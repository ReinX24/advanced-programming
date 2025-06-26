@extends('layouts.app', ['page_title' => 'Appointment Details'])

@section('title', "Appointment #$appointment->id")

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show fs-5" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center"> {{-- Changed to bg-info for a different color --}}
            <h2 class="mb-0">{{ $appointment->title }}</h2>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Student:</dt>
                <dd class="col-sm-8">
                    <a href="{{ route('students.show', $appointment->student) }}">
                        {{ $appointment->student->lname }}, {{ $appointment->student->fname }}
                    </a>
                </dd>

                <dt class="col-sm-4">Appointment Date:</dt>
                <dd class="col-sm-8">
                    {{ $appointment->appointment_date ? \Carbon\Carbon::parse($appointment->appointment_date)->format('F d, Y') : 'N/A' }}
                </dd>

                <dt class="col-sm-4">Appointment Time:</dt>
                <dd class="col-sm-8">{{ $appointment->appointment_time }}</dd>

                <dt class="col-sm-4">Remarks:</dt>
                <dd class="col-sm-8">{{ $appointment->remarks ?? 'N/A' }}</dd>

                <dt class="col-sm-4">Created Date:</dt>
                <dd class="col-sm-8">{{ $appointment->created_at->format('F d, Y h:i A') }}</dd>
                {{-- Display creation date --}}

                <dt class="col-sm-4">Status:</dt>
                <dd class="col-sm-8">
                    <span class="{{ $appointment->status == 'Pending' ? 'text-warning' : 'text-success' }} fw-bold">
                        {{ $appointment->status }}
                    </span>
                </dd>
            </dl>

            <div class="d-grid gap-2 mt-4">
                <form id="toggleStatus{{ $appointment->id }}"
                    action="{{ route('appointments.toggleStatus', $appointment) }}" method="POST">
                    @csrf
                    @method('PATCH')
                </form>
                <button form="toggleStatus{{ $appointment->id }}" type="submit"
                    class="btn {{ $appointment->status === 'Pending' ? 'btn-success' : 'btn-warning' }}">Mark as
                    {{ $appointment->status == 'Pending' ? 'Completed' : 'Pending' }}</button>
                <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-primary">Edit
                    Appointment</a>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Any specific JavaScript for this page can go here
    </script>
@endpush
