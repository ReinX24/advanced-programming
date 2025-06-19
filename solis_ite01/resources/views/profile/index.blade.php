@extends('layouts.app', ['page_title' => 'Profile'])

@section('title', 'Profile')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>{{ Auth::user()->name ?? 'User Not Found' }}</h4>
        </div>
        <div class="card-body">
            <p class="card-text"><strong>Email:</strong> {{ Auth::user()->email ?? 'N/A' }}</p>
            <p class="card-text"><strong>Account Created:</strong>
                {{ Auth::user()->created_at ? Auth::user()->created_at->format('M d, Y h:i A') : 'N/A' }}</p>
            {{-- <a href="#" class="btn btn-primary">Edit Profile</a> --}}
        </div>
    </div>
@endsection
