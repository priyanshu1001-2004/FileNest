{{-- resources/views/errors/500.blade.php --}}
@extends('errors.layout')

@section('title', 'Server Error')

@section('content')

<div class="mb-4">
    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex p-4">
        <i class="fe fe-alert-triangle fs-1 text-danger"></i>
    </div>
</div>

<h1 class="display-1 mb-2 text-danger">500</h1>
<h3 class="mb-2">Server Error</h3>
<p class="text-muted mb-4">
    Something went wrong on our end. Please try again later.
</p>

<div class="alert alert-info text-start">
    <i class="fe fe-info me-2"></i>
    <strong>What to do?</strong>
    <ul class="mb-0 mt-2">
        <li>🔄 Refresh the page</li>
        <li>⏳ Wait a few minutes and try again</li>
        <li>📧 Contact support if the issue persists</li>
    </ul>
</div>

<div class="d-flex justify-content-center gap-3 flex-wrap mt-3">
    <a href="{{ route('dashboard') }}" class="btn btn-primary">
        <i class="fe fe-home me-1"></i> Go to Dashboard
    </a>
    <a href="mailto:support@yourplatform.com" class="btn btn-outline-secondary">
        <i class="fe fe-help-circle me-1"></i> Contact Support
    </a>
</div>

@endsection