{{-- resources/views/errors/404.blade.php --}}
@extends('errors.layout')

@section('title', 'Page Not Found')

@section('content')

<div class="mb-4">
    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-4">
        <i class="fe fe-search fs-1 text-warning"></i>
    </div>
</div>

<h1 class="display-1 mb-2 text-warning">404</h1>
<h3 class="mb-2">Page Not Found</h3>
<p class="text-muted mb-4">
    Sorry, the page you are looking for could not be found.
</p>

<div class="d-flex justify-content-center gap-3 flex-wrap mt-3">
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
        <i class="fe fe-arrow-left me-1"></i> Go Back
    </a>
    <a href="{{ route('dashboard') }}" class="btn btn-primary">
        <i class="fe fe-home me-1"></i> Go to Dashboard
    </a>
</div>

@endsection