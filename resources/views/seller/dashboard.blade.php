{{-- resources/views/seller/dashboard.blade.php --}}
@extends('layouts.master')

@section('title', 'Seller Dashboard')

@section('content')

<div class="mt-5" id="data-table-container">
    <div class="row row-sm">
        <div class="col-lg-12">
            <!-- Welcome Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <h4>Welcome back, {{ auth()->user()->name }}! 👋</h4>
                    <p class="text-muted">Manage your products and track your sales</p>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-md-3">
                    <div class="card bg-primary img-card border-0 rounded-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="text-white">
                                    <h2 class="mb-0 number-font fw-bold">{{ $totalProducts ?? 0 }}</h2>
                                    <p class="text-white-50 mb-0 fs-13">Total Products</p>
                                </div>
                                <div class="ms-auto text-white-50">
                                    <i class="fe fe-shopping-bag fs-30"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="card bg-warning img-card border-0 rounded-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="text-white">
                                    <h2 class="mb-0 number-font fw-bold">{{ $pendingProducts ?? 0 }}</h2>
                                    <p class="text-white-50 mb-0 fs-13">Pending Review</p>
                                </div>
                                <div class="ms-auto text-white-50">
                                    <i class="fe fe-clock fs-30"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="card bg-success img-card border-0 rounded-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="text-white">
                                    <h2 class="mb-0 number-font fw-bold">{{ $publishedProducts ?? 0 }}</h2>
                                    <p class="text-white-50 mb-0 fs-13">Published</p>
                                </div>
                                <div class="ms-auto text-white-50">
                                    <i class="fe fe-check-circle fs-30"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="card bg-danger img-card border-0 rounded-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="text-white">
                                    <h2 class="mb-0 number-font fw-bold">{{ $rejectedProducts ?? 0 }}</h2>
                                    <p class="text-white-50 mb-0 fs-13">Rejected</p>
                                </div>
                                <div class="ms-auto text-white-50">
                                    <i class="fe fe-x-circle fs-30"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales & Revenue -->
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="card bg-info img-card border-0 rounded-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="text-white">
                                    <h2 class="mb-0 number-font fw-bold">{{ $totalSales ?? 0 }}</h2>
                                    <p class="text-white-50 mb-0 fs-13">Total Sales</p>
                                </div>
                                <div class="ms-auto text-white-50">
                                    <i class="fe fe-trending-up fs-30"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card bg-dark img-card border-0 rounded-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="text-white">
                                    <h2 class="mb-0 number-font fw-bold">${{ number_format($totalRevenue ?? 0, 2) }}</h2>
                                    <p class="text-white-50 mb-0 fs-13">Total Revenue</p>
                                </div>
                                <div class="ms-auto text-white-50">
                                    <i class="fe fe-dollar-sign fs-30"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="card">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h3 class="card-title mb-1 fw-bold">
                            <i class="fe fe-shopping-bag me-2 text-primary"></i>Recent Products
                        </h3>
                        <p class="text-muted mb-0 fs-12">Your latest products</p>
                    </div>
                    <div>
                        <a href="#" class="btn btn-primary btn-sm">
                            <i class="fe fe-plus me-1"></i> Add Product
                        </a>
                        <a href="#" class="btn btn-outline-secondary btn-sm">
                            <i class="fe fe-list me-1"></i> View All
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(isset($recentProducts) && $recentProducts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered text-nowrap border-bottom">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Approval</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentProducts as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <span class="fw-semibold">{{ Str::limit($product->title, 30) }}</span>
                                        </td>
                                        <td>${{ number_format($product->price, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $product->status == 'published' ? 'success' : 'warning' }}">
                                                {{ ucfirst($product->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($product->is_approved)
                                                <span class="badge bg-success">Approved</span>
                                            @elseif($product->status == 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ $product->created_at->format('d M Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fe fe-shopping-bag fs-1 text-muted d-block mb-3"></i>
                            <h5 class="text-muted">No Products Yet</h5>
                            <p class="text-muted fs-12">Start selling by creating your first product</p>
                            <a href="#" class="btn btn-primary btn-sm mt-2">
                                <i class="fe fe-plus me-1"></i> Create Product
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection