@extends('layouts.master')

@section('title', 'Store Pending Approval')

@section('content')

<div class="mt-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-lg">
                <div class="card-body text-center py-5">
                    
                    <!-- Icon -->
                    <div class="mb-4">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-4">
                            <i class="fe fe-clock fs-1 text-warning"></i>
                        </div>
                    </div>

                    <!-- Title -->
                    <h3 class="mb-2">⏳ Store Pending Approval</h3>
                    <p class="text-muted mb-4">
                        Your store is currently under review by our admin team.
                    </p>

                    <!-- Store Info -->
                    @php
                        $sellerDetail = auth()->user()->sellerDetail;
                    @endphp

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
                                            <span class="badge bg-warning text-dark px-3 py-2">
                                                <i class="fe fe-clock me-1"></i> Pending Review
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <small class="text-muted">Submitted On</small>
                                        <p class="fw-bold mb-0">{{ $sellerDetail->created_at->format('d M Y, h:i A') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">Type</small>
                                        <p class="fw-bold mb-0">{{ ucfirst($sellerDetail->seller_type ?? 'Individual') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Message -->
                    <div class="alert alert-info text-start">
                        <i class="fe fe-info me-2"></i>
                        <strong>What happens next?</strong>
                        <ul class="mb-0 mt-2">
                            <li>📋 Our admin team will review your store details</li>
                            <li>✅ You will receive a notification once approved</li>
                            <li>🚀 After approval, you can start selling immediately</li>
                            <li>⏱️ This usually takes 24-48 hours</li>
                        </ul>
                    </div>

                  
                    <!-- Contact Support -->
                    <div class="mt-4 pt-3 border-top">
                        <small class="text-muted">
                            <i class="fe fe-help-circle me-1"></i>
                            Need help? <a href="mailto:support@yourplatform.com" class="text-primary">Contact Support</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection