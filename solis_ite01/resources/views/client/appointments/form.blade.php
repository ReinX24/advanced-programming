<form method="POST"
    action="{{ isset($appointment) ? route('appointments.update', $appointment) : route('appointments.store') }}">
    @csrf
    @isset($appointment)
        @method('PATCH')
    @endisset

    <div class="mb-3">
        <label for="student_id" class="form-label">Student <span class="text-danger">*</span></label>
        <select class="form-select @error('student_id') is-invalid @enderror" name="student_id">
            <option selected value="">Select student</option> {{-- IMPORTANT: Add value="" to the "Select student" option --}}
            @foreach ($students as $student)
                <option {{ $appointment->student->id ?? '' == $student->id ? 'selected' : '' }}
                    value="{{ $student->id }}">
                    {{ $student->lname }}, {{ $student->fname }}</option>
            @endforeach
        </select>

        @error('student_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="fname" class="form-label">Title <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
            value="{{ old('title', $appointment->title ?? '') }}" placeholder="Enter Appointment Title">
        @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="lname" class="form-label">Appointment Date <span class="text-danger">*</span></label>
        <input type="date" class="form-control @error('appointment_date') is-invalid @enderror" id="appointment_date"
            name="appointment_date"
            value="{{ old('appointment_date', $appointment->appointment_date ?? \Carbon\Carbon::now()->format('Y-m-d')) }}">
        @error('appointment_date')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="appointment_time" class="form-label">Appointment Time <span class="text-danger">*</span></label>
        <input type="time" step="1" class="form-control @error('appointment_time') is-invalid @enderror"
            id="appointment_time" name="appointment_time"
            value="{{ old('appointment_time', $appointment->appointment_time ?? \Carbon\Carbon::now()->format('H:i:s')) }}">
        @error('appointment_time')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="remarks" class="form-label">Remarks</label>
        <textarea placeholder="Additional Appointment Remarks" class="form-control @error('remarks') is-invalid @enderror"
            id="remarks" name="remarks" rows="4">{{ old('remarks', $appointment->remarks ?? '') }}</textarea>
        @error('remarks')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="d-grid gap-2 mt-4">
        <button type="submit" class="btn btn-primary btn-lg">{{ isset($appointment) ? 'Update' : 'Add' }}
            Appointment</button>
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary btn-lg">Back</a>
    </div>
