{{-- resources/views/errors/403.blade.php --}}
@extends('errors.layout')

@php
$user = auth()->user();
$sellerDetail = $user?->sellerDetail;
$isAdmin = $user?->isAdmin();
$isSeller = $user?->isSeller();
$isBuyer = $user?->isBuyer();
$isPending = $sellerDetail && !$sellerDetail->is_verified;
$isSuspended = $sellerDetail && $sellerDetail->isSuspended();
@endphp

@section('title', $title ?? 'Access Denied')

@section('content')

@if($isPending)
<!-- ============================================ -->
<!-- CASE 1: SELLER PENDING APPROVAL -->
<!-- ============================================ -->
<div class="mb-4">
    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-4">
        <i class="fe fe-clock fs-1 text-warning"></i>
    </div>
</div>
<h1 class="display-1 mb-2 text-warning">⏳</h1>
<h3 class="mb-2">Store Pending Approval</h3>
<p class="text-muted mb-4">
    Your store is currently under review by our admin team.
</p>

@if($sellerDetail)
<div class="card bg-dark bg-opacity-25 mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <small class="text-muted">Store</small>
                <p class="fw-bold mb-0 text-white">{{ $sellerDetail->store_name }}</p>
            </div>
            <div class="col-6">
                <small class="text-muted">Status</small>
                <p class="mb-0">
                    <span class="badge bg-warning text-dark">Pending Review</span>
                </p>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-6">
                <small class="text-muted">Submitted</small>
                <p class="fw-bold mb-0 text-white">{{ $sellerDetail->created_at->format('d M Y, h:i A') }}</p>
            </div>
            <div class="col-6">
                <small class="text-muted">Type</small>
                <p class="fw-bold mb-0 text-white">{{ ucfirst($sellerDetail->seller_type ?? 'Individual') }}</p>
            </div>
        </div>
    </div>
</div>
@endif

<div class="alert alert-info text-start">
    <i class="fe fe-info me-2"></i>
    <strong>What happens next?</strong>
    <ul class="mb-0 mt-2">
        <li>📋 Our admin team will review your store details</li>
        <li>✅ You will receive a notification once approved</li>
        <li>🚀 After approval, you can start selling immediately</li>
    </ul>
</div>

<div class="d-flex justify-content-center gap-3 flex-wrap mt-3">
    <a href="{{ route('seller.profile.index') }}" class="btn btn-outline-primary">
        <i class="fe fe-edit-2 me-1"></i> Edit Profile
    </a>
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
    @csrf

    <button type="submit" class="btn btn-outline-danger">
        <i class="fe fe-log-out me-1"></i>
        Logout
    </button>
</form>
</div>

@elseif($isSuspended)
<!-- ============================================ -->
<!-- CASE 2: SELLER SUSPENDED -->
<!-- ============================================ -->
<div class="mb-4">
    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex p-4">
        <i class="fe fe-slash fs-1 text-danger"></i>
    </div>
</div>
<h1 class="display-1 mb-2 text-danger">🚫</h1>
<h3 class="mb-2 text-danger">Store Suspended</h3>

<div class="alert alert-danger text-start">
    <i class="fe fe-alert-triangle me-2"></i>
    <strong>Your store has been suspended.</strong>
    @if($sellerDetail->suspension_reason)
    <br>
    <strong>Reason:</strong> {{ $sellerDetail->suspension_reason }}
    @endif
    @if($sellerDetail->suspended_until)
    <br>
    <small>🕐 Suspension lifts on: {{ $sellerDetail->suspended_until->format('d M Y, h:i A') }}</small>
    @else
    <br>
    <small>⚠️ This is a permanent suspension.</small>
    @endif
</div>

<div class="d-flex justify-content-center gap-3 flex-wrap mt-3">
   <form action="{{ route('logout') }}" method="POST" class="d-inline">
    @csrf

    <button type="submit" class="btn btn-outline-danger">
        <i class="fe fe-log-out me-1"></i>
        Logout
    </button>
</form>
    <a href="mailto:support@yourplatform.com" class="btn btn-outline-secondary">
        <i class="fe fe-help-circle me-1"></i> Contact Support
    </a>
</div>

@elseif($isAdmin && !$user?->status)
<!-- ============================================ -->
<!-- CASE 3: ADMIN ACCOUNT DEACTIVATED -->
<!-- ============================================ -->
<div class="mb-4">
    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex p-4">
        <i class="fe fe-user-x fs-1 text-danger"></i>
    </div>
</div>
<h1 class="display-1 mb-2 text-danger">🔒</h1>
<h3 class="mb-2 text-danger">Account Deactivated</h3>
<p class="text-muted mb-4">
    Your admin account has been deactivated. Please contact the system administrator.
</p>
<form action="{{ route('logout') }}" method="POST" class="d-inline">
    @csrf

    <button type="submit" class="btn btn-outline-danger">
        <i class="fe fe-log-out me-1"></i>
        Logout
    </button>
</form>

@elseif($isAdmin && !$sellerDetail)
<!-- ============================================ -->
<!-- CASE 4: ADMIN - No Seller Profile -->
<!-- ============================================ -->
<div class="mb-4">
    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex p-4">
        <i class="fe fe-info fs-1 text-info"></i>
    </div>
</div>
<h1 class="display-1 mb-2 text-info">📝</h1>
<h3 class="mb-2">Complete Your Profile</h3>
<p class="text-muted mb-4">
    Please complete your seller profile to access the seller panel.
</p>
<a href="{{ route('seller.profile.index') }}" class="btn btn-primary">
    <i class="fe fe-edit-2 me-1"></i> Complete Profile
</a>

@elseif($isBuyer)
<!-- ============================================ -->
<!-- CASE 5: BUYER ACCESSING SELLER AREA -->
<!-- ============================================ -->
<div class="mb-4">
    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex p-4">
        <i class="fe fe-shield-off fs-1 text-danger"></i>
    </div>
</div>
<h1 class="display-1 mb-2 text-danger">403</h1>
<h3 class="mb-2">Access Denied</h3>
<p class="text-muted mb-4">
    You are logged in as a Buyer. This area is for Sellers only.
</p>
<div class="d-flex justify-content-center gap-3 flex-wrap mt-3">
    <a href="{{ route('buyer.dashboard') }}" class="btn btn-primary">
        <i class="fe fe-arrow-left me-1"></i> Go to Buyer Dashboard
    </a>
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
    @csrf

    <button type="submit" class="btn btn-outline-danger">
        <i class="fe fe-log-out me-1"></i>
        Logout
    </button>
</form>
</div>

@else
<!-- ============================================ -->
<!-- CASE 6: DEFAULT 403 -->
<!-- ============================================ -->
<div class="mb-4">
    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex p-4">
        <i class="fe fe-shield-off fs-1 text-danger"></i>
    </div>
</div>
<h1 class="display-1 mb-2 text-danger">403</h1>
<h3 class="mb-2">Access Denied</h3>
<p class="text-muted mb-4">
    {{ $exception->getMessage() ?? 'You do not have permission to access this page.' }}
</p>
<div class="d-flex justify-content-center gap-3 flex-wrap mt-3">
    <a href="{{ route('dashboard') }}" class="btn btn-primary">
        <i class="fe fe-arrow-left me-1"></i> Back to Dashboard
    </a>
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
    @csrf

    <button type="submit" class="btn btn-outline-danger">
        <i class="fe fe-log-out me-1"></i>
        Logout
    </button>
</form>
</div>
@endif

@endsection