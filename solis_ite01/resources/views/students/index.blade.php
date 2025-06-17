@extends('layouts.app', ['page_title' => 'Students'])

@section('css')
    <style>
        .title {
            text-align: center;
            font-size: 2rem;
        }
    </style>
@endsection

@section('title', 'Students List')

@section('content')
    <div class="title">{{ $user->name }}</div>

    <div class="mb-3">
        <a href="{{ route('students.create') }}" class="btn btn-primary">Add Student</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show fs-5" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Your form goes here --}}

    <ul class="mt-4 list-group list-group-flush">
        @if ($isAdmin)
            @forelse ($students as $key => $student)
                <li class="text-lg list-group-item">
                    <a href="{{ route('students.show', $student) }}" style="text-decoration:none;">
                        {{ $student->id }}. {{ $student->fname }} {{ $student->lname }}
                    </a>
                </li>
            @empty
                <div>No Recorded Students.</div>
            @endforelse
        @else
            <div class="text-lg">Not Admin.</div>
        @endif
    </ul>

    {{-- Pagination links --}}
    <div class="mt-4">
        {{ $students->links() }}
    </div>
@endsection

@push('scripts')
    <script>
        // alert("Hello")
    </script>
@endpush
