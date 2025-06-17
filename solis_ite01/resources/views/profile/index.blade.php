@extends('layouts.app', ['page_title' => 'Profile'])

@section('title', 'Profile')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>{{ $user->name ?? 'User Not Found' }}</h4>
        </div>
        <div class="card-body">
            <p class="card-text"><strong>Email:</strong> {{ $user->email ?? 'N/A' }}</p>
            <p class="card-text"><strong>Account Created:</strong>
                {{ $user->created_at ? $user->created_at->format('M d, Y h:i A') : 'N/A' }}</p>
            <a href="#" class="btn btn-primary">Edit Profile</a>
        </div>
    </div>
@endsection
