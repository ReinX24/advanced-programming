@extends('layouts.app', ['page_title' => 'Edit Appointment'])

@section('title', 'Edit Appointment')

@section('content')
    <div class="card shadow-sm"> {{-- Added shadow-sm for a subtle lift --}}
        <div class="card-header bg-primary text-white text-center"> {{-- Styled card header --}}
            <h2 class="mb-0">Edit Appointment</h2>
        </div>
        <div class="card-body">
            @include('client.appointments.form')
        </div>
    </div>
@endsection

@push('scripts')
    <script></script>
@endpush
