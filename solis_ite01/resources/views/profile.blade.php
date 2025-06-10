@extends('layouts.app', ['page_title' => 'Profile'])

@section('title', 'Profile')

@section('content')
    <h4>{{ $greetings ?? 'N/A' }}</h4>

    <button class="btn btn-primary">
        Button
    </button>
@endsection
