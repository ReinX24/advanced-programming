@extends('layouts.app', ['page_title' => 'Appointments'])

@section('css')
    <style>
    </style>
@endsection

@section('title', 'Appointment')

@section('content')

    <div class="mb-3">
        <a href="{{ route('appointments.create') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-plus-circle"></i>
            Add Appointment</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show fs-5" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Appointment Date</th>
                <th scope="col">Appointment Time</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($appointments as $key => $appointment)
                <tr class="{{ $appointment->status === 'Pending' ? 'table-warning' : 'table-success' }}">
                    <th scope="row">{{ $appointment->id }}</th>
                    <td>
                        <a href="{{ route('appointments.show', $appointment) }}">
                            {{ $appointment->title }}
                        </a>
                    </td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>{{ $appointment->appointment_time }}</td>
                    <td>
                        {{ $appointment->status }}
                    </td>
                    <td>
                        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-secondary btn-sm">Edit</a>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deleteUserModal{{ $appointment->id }}">
                            Delete
                        </button>
                    </td>
                </tr>

                {{-- Delete student modal using bootstrap --}}
                <div class="modal fade" id="deleteUserModal{{ $appointment->id }}" tabindex="-1"
                    aria-labelledby="deleteUserModal{{ $appointment->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteStudentModalLabel">Confirm Deletion</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete {{ $appointment->title }}? This action cannot be undone.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('appointments.destroy', $appointment) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <td class="text-center" colspan="5">No Recorded Users.</td>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination links --}}
    <div class="mt-4">
        {{ $appointments->links() }}
    </div>
@endsection

@push('scripts')
    <script>
        // alert("Hello")
    </script>
@endpush
