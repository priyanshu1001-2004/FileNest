{{-- resources/views/errors/503.blade.php --}}
@extends('errors.layout')

@section('title', 'Maintenance Mode')

@section('content')

<div class="mb-4">
    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-4">
        <i class="fe fe-settings fs-1 text-warning"></i>
    </div>
</div>

<h1 class="display-1 mb-2 text-warning">🔧</h1>
<h3 class="mb-2">Under Maintenance</h3>
<p class="text-muted mb-4">
    We're currently performing scheduled maintenance. We'll be back shortly.
</p>

<div class="alert alert-info text-start">
    <i class="fe fe-info me-2"></i>
    <strong>Maintenance Information</strong>
    <ul class="mb-0 mt-2">
        <li>⏳ Estimated downtime: <strong>{{ $retryAfter ?? '30 minutes' }}</strong></li>
        <li>🔄 Please refresh the page after maintenance</li>
        <li>📧 Contact support for urgent issues</li>
    </ul>
</div>

<div class="d-flex justify-content-center gap-3 flex-wrap mt-3">
    <a href="mailto:support@yourplatform.com" class="btn btn-outline-secondary">
        <i class="fe fe-help-circle me-1"></i> Contact Support
    </a>
</div>

@endsection