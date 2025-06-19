@extends('layouts.app', ['page_title' => 'Create User']) {{-- Changed page title --}}

@section('title', 'Add User') {{-- Changed section title --}}

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Add New User</h2> {{-- Changed heading --}}
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('users.store') }}"> {{-- Changed route to users.store --}}
                @csrf
                @include('client.users.form')
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Any specific JavaScript for this form can go here
    </script>
@endpush
