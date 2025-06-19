<form method="POST" action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}">
    @csrf
    @isset($user)
        @method('PATCH')
    @endisset

    {{-- Name --}}
    <div class="mb-3">
        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
            value="{{ old('name', $user->name ?? '') }}" autofocus>
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Email Address --}}
    <div class="mb-3">
        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
            value="{{ old('email', $user->email ?? '') }}">
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

    @if (empty($user))
        {{-- Confirm Password --}}
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password <span
                    class="text-danger">*</span></label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                autocomplete="new-password">
            {{-- No @error for password_confirmation itself, as validation message comes from 'password' --}}
        </div>
    @endif

    <div class="d-grid gap-2 mt-4">
        @isset($user)
            <input type="hidden" name="id" value="{{ $user->id }}">
        @endisset
        <button type="submit" class="btn btn-primary btn-lg">{{ isset($user) ? 'Update User' : 'Create' }}</button>
    </div>
