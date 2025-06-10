@extends('layouts.app', ['page_title' => 'Students'])

@section('css')
    <style>
        .title {
            text-align: center
        }
    </style>
@endsection

@section('title', 'Students List')

@section('content')
    <div class="title">{{ $user }}</div>
    <ul class="mt-4 list-group">
        @if ($isAdmin)
            @foreach ($students as $key => $student)
                <li class="text-lg list-group-item">{{ $key + 1 }}. {{ $student['name'] }}</li>
            @endforeach
        @else
            <div class="text-lg">Not Admin.</div>
        @endif
    </ul>
@endsection

@push('scripts')
    <script>
        // alert("Hello")
    </script>
@endpush
