@extends('layouts.app', ['page_title' => 'Users'])

@section('css')
    <style></style>
@endsection

@section('title', 'Manage Users')

@section('content')
    @session('success')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endsession

    <div class="card">
        <div class="card-header">
            <h4>{{ $user->name ?? 'User Not Found' }}</h4>
        </div>
        <div class="card-body">
            <p class="card-text"><strong>Email:</strong> {{ $user->email ?? 'N/A' }}</p>
            <p class="card-text"><strong>Account Created:</strong>{{ $user->created_date }}</p>
        </div>
    </div>

@endsection

@push('scripts')
    <script></script>
@endpush
