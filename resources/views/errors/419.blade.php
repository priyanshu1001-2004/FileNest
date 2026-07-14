{{-- resources/views/errors/419.blade.php --}}
@extends('errors.layout')

@section('title', 'Session Expired')

@section('content')

<div class="mb-4">
    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-4">
        <i class="fe fe-clock fs-1 text-warning"></i>
    </div>
</div>

<h1 class="display-1 mb-2 text-warning">419</h1>
<h3 class="mb-2">Session Expired</h3>
<p class="text-muted mb-4">
    Your session has expired. Please refresh the page and try again.
</p>

<div class="d-flex justify-content-center gap-3 flex-wrap mt-3">
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
        <i class="fe fe-refresh-ccw me-1"></i> Refresh Page
    </a>
    <a href="{{ route('login') }}" class="btn btn-primary">
        <i class="fe fe-log-in me-1"></i> Login Again
    </a>
</div>

@endsection