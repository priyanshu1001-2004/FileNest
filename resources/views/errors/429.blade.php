{{-- resources/views/errors/429.blade.php --}}
@extends('errors.layout')

@section('title', 'Too Many Requests')

@section('content')

<div class="mb-4">
    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex p-4">
        <i class="fe fe-alert-circle fs-1 text-danger"></i>
    </div>
</div>

<h1 class="display-1 mb-2 text-danger">429</h1>
<h3 class="mb-2">Too Many Requests</h3>
<p class="text-muted mb-4">
    You have made too many requests. Please slow down and try again later.
</p>

<div class="alert alert-info text-start">
    <i class="fe fe-info me-2"></i>
    <strong>Please wait</strong>
    <ul class="mb-0 mt-2">
        <li>⏳ Wait a few minutes before trying again</li>
        <li>🔄 Refresh the page after some time</li>
    </ul>
</div>

<a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
    <i class="fe fe-arrow-left me-1"></i> Go Back
</a>

@endsection