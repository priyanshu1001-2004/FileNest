{{-- resources/views/seller/suspended.blade.php --}}
@extends('layouts.master')

@section('title', 'Store Suspended')

@section('content')

<div class="mt-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center py-5">

                    <!-- Icon -->
                    <div class="mb-4">
                        <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex p-4">
                            <i class="fe fe-slash fs-1 text-danger"></i>
                        </div>
                    </div>

                    <!-- Title -->
                    <h3 class="mb-2 text-danger">🚫 Store Suspended</h3>

                    <!-- Message -->
                    <div class="alert alert-danger text-start">
                        <i class="fe fe-alert-triangle me-2"></i>
                        <strong>Your store has been suspended.</strong>
                        <br>
                        {{ $message ?? 'Please contact admin for more information.' }}
                    </div>

                    <!-- Store Info -->
                    @if($sellerDetail)
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">Store Name</small>
                                    <p class="fw-bold mb-0">{{ $sellerDetail->store_name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Status</small>
                                    <p class="mb-0">
                                        {{-- ✅ Uses existing getStatusBadge() and getStatusLabel() --}}
                                        <span class="badge bg-{{ $sellerDetail->getStatusBadge() }} px-3 py-2">
                                            {{ $sellerDetail->getStatusLabel() }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                   

                    <!-- Contact Support -->
                    <div class="mt-4 pt-3 border-top">
                        <small class="text-muted">
                            <i class="fe fe-help-circle me-1"></i>
                            Need help? <a href="mailto:support@yourplatform.com" class="text-primary">Contact
                                Support</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection