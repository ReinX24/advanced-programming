@extends('layouts.app', ['page_title' => 'Edit Students'])

@section('title', 'Edit Student')

@section('content')
    <div class="card shadow-sm"> {{-- Added shadow-sm for a subtle lift --}}
        <div class="card-header bg-primary text-white text-center"> {{-- Styled card header --}}
            <h2 class="mb-0">Edit Student #{{ $student->id }}</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('students.update', $student->id) }}">
                @csrf
                @method('PATCH')

                {{-- First Name --}}
                <div class="mb-3">
                    <label for="fname" class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('fname') is-invalid @enderror" id="fname"
                        name="fname" value="{{ old('fname', $student->fname) }}">
                    {{-- Pre-fill with student data --}}
                    @error('fname')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Last Name --}}
                <div class="mb-3">
                    <label for="lname" class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('lname') is-invalid @enderror" id="lname"
                        name="lname" value="{{ old('lname', $student->lname) }}">
                    {{-- Pre-fill with student data --}}
                    @error('lname')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email', $student->email) }}">
                    {{-- Pre-fill with student data --}}
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
                        id="contact_number" name="contact_number"
                        value="{{ old('contact_number', $student->contact_number) }}"> {{-- Pre-fill with student data --}}
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
                        <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender"
                            id="genderMale" value="Male"
                            {{ old('gender', $student->gender) == 'Male' ? 'checked' : '' }}>
                        {{-- Pre-fill and check --}}
                        <label class="form-check-label" for="genderMale">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender"
                            id="genderFemale" value="Female"
                            {{ old('gender', $student->gender) == 'Female' ? 'checked' : '' }}>
                        {{-- Pre-fill and check --}}
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
                    <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate"
                        name="birthdate" value="{{ old('birthdate', $student->birthdate) }}">
                    {{-- Pre-fill with student data --}}
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
                        id="complete_address" name="complete_address"
                        value="{{ old('complete_address', $student->complete_address) }}">
                    {{-- Pre-fill with student data --}}
                    @error('complete_address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Bio --}}
                <div class="mb-3">
                    <label for="bio" class="form-label">Biography</label>
                    <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4">{{ old('bio', $student->bio) }}</textarea> {{-- Pre-fill textarea --}}
                    @error('bio')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Update Student</button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteStudentModal">
                        Delete Student
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete student modal using bootstrap --}}
    <div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-labelledby="deleteStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteStudentModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete {{ $student->fname }} {{ $student->lname }}? This action cannot be
                    undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                        style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Any custom JS for this form goes here
    </script>
@endpush
