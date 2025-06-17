@extends('layouts.app', ['page_title' => 'Create Students'])

@section('title', 'Add Student')

@section('content')
    <div class="container pb-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm"> {{-- Added shadow-sm for a subtle lift --}}
                    <div class="card-header bg-primary text-white text-center"> {{-- Styled card header --}}
                        <h2 class="mb-0">Add New Student</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('students.store') }}">
                            @csrf

                            {{-- First Name --}}
                            <div class="mb-3">
                                <label for="fname" class="form-label">First Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('fname') is-invalid @enderror"
                                    id="fname" name="fname" value="{{ old('fname') }}">
                                @error('fname')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Last Name --}}
                            <div class="mb-3">
                                <label for="lname" class="form-label">Last Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('lname') is-invalid @enderror"
                                    id="lname" name="lname" value="{{ old('lname') }}">
                                @error('lname')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Contact Number --}}
                            <div class="mb-3">
                                <label for="contact_number" class="form-label">Contact Number</label>
                                <input type="text" class="form-control @error('contact_number') is-invalid @enderror"
                                    id="contact_number" name="contact_number" value="{{ old('contact_number') }}">
                                @error('contact_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Gender (Using Radio Buttons for Bootstrap 5 look) --}}
                            <div class="mb-3">
                                <label class="form-label">Gender</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio"
                                        name="gender" id="genderMale" value="Male"
                                        {{ old('gender') == 'Male' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="genderMale">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio"
                                        name="gender" id="genderFemale" value="Female"
                                        {{ old('gender') == 'Female' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="genderFemale">Female</label>
                                </div>
                                @error('gender')
                                    <div class="invalid-feedback d-block"> {{-- d-block to force display for radio errors --}}
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Birthdate --}}
                            <div class="mb-3">
                                <label for="birthdate" class="form-label">Birthdate</label>
                                <input type="date" class="form-control @error('birthdate') is-invalid @enderror"
                                    id="birthdate" name="birthdate" value="{{ old('birthdate') }}">
                                @error('birthdate')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Complete Address --}}
                            <div class="mb-3">
                                <label for="complete_address" class="form-label">Complete Address</label>
                                <input type="text" class="form-control @error('complete_address') is-invalid @enderror"
                                    id="complete_address" name="complete_address" value="{{ old('complete_address') }}">
                                @error('complete_address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Bio --}}
                            <div class="mb-3">
                                <label for="bio" class="form-label">Biography</label>
                                <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4">{{ old('bio') }}</textarea>
                                @error('bio')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 mt-4"> {{-- Added mt-4 for top margin --}}
                                <button type="submit" class="btn btn-primary btn-lg">Add Student</button>
                                {{-- Larger button --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // alert("Hello")
    </script>
@endpush
