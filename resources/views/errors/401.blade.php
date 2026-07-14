{{-- resources/views/errors/401.blade.php --}}
@extends('errors.layout')

@section('title', 'Unauthorized')

@section('content')

<div class="mb-4">
    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-4">
        <i class="fe fe-lock fs-1 text-warning"></i>
    </div>
</div>

<h1 class="display-1 mb-2 text-warning">401</h1>
<h3 class="mb-2">Unauthorized Access</h3>
<p class="text-muted mb-4">
    Please log in to access this page.
</p>

<div class="d-flex justify-content-center gap-3 flex-wrap mt-3">
    <a href="{{ route('login') }}" class="btn btn-primary">
        <i class="fe fe-log-in me-1"></i> Login
    </a>
    <a href="{{ route('register') }}" class="btn btn-outline-secondary">
        <i class="fe fe-user-plus me-1"></i> Register
    </a>
</div>

@endsection