@extends('layouts.app', ['page_title' => 'Profile'])

@section('title', 'Profile')

@section('content')
    @session('success')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endsession

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Edit Profile</h2> {{-- Changed heading --}}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('profile.update', Auth::user()->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                {{-- Current Profile Photo Display --}}
                <div class="mb-3 text-center">
                    <label for="current_photo" class="form-label">Profile Photo</label>
                    <div>
                        @if (Auth::user()->profile_photo_path)
                            <img src="{{ Auth::user()->profilePhotoUrl() }}" alt="Profile Photo" class="img-thumbnail"
                                style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
                        @else
                            <p>No profile photo set.</p>
                        @endif
                    </div>
                    <p class="mt-2">Created at: {{ Auth::user()->registered_date }}</p>
                </div>

                {{-- Name --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', Auth::user()->name ?? '') }}" autofocus>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Email Address --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email', Auth::user()->email ?? '') }}">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label">{{ isset($user) ? 'New Password' : 'Password' }} <span
                            class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" autocomplete="new-password">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password <span
                            class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        autocomplete="new-password">
                    {{-- No @error for password_confirmation itself, as validation message comes from 'password' --}}
                </div>

                {{-- Profile photo upload input --}}
                <div class="mb-3">
                    <label for="photo" class="form-label">Change Profile Photo</label>
                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo"
                        name="photo">
                    @error('photo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-grid gap-2 mt-4">
                    @if (Auth::user())
                        <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                    @endif
                    <button type="submit" class="btn btn-primary">{{ 'Update Profile' }}</button>

                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteUserModal{{ Auth::user()->id }}">
                        Delete
                    </button>
                </div>
            </form>

            <div class="modal fade" id="deleteUserModal{{ Auth::user()->id }}" tabindex="-1"
                aria-labelledby="deleteUserModal{{ Auth::user()->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteProfileModalLabel">Confirm Deletion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete {{ Auth::user()->name }} {{ Auth::user()->email }}? This
                            action
                            cannot
                            be undone
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form action="{{ route('profile.destroy', Auth::user()->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
