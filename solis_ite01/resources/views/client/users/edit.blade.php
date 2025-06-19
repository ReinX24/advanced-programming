@extends('layouts.app', ['page_title' => 'Edit User']) {{-- Changed page title --}}

@section('title', 'Edit User') {{-- Changed section title --}}

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Edit User</h2> {{-- Changed heading --}}
        </div>
        <div class="card-body">
            @csrf
            @include('client.users.form')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Any specific JavaScript for this form can go here
    </script>
@endpush
