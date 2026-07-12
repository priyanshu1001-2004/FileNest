{{-- resources/views/admin/sellers/index.blade.php --}}
@extends('layouts.master')

@section('title', 'Admin | Sellers')

@section('content')

<div class="mt-5" id="data-table-container">
    <div class="row row-sm">
        <div class="col-lg-12">
            <!-- Statistics Cards -->
            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-md-3">
                    <div class="card bg-primary img-card border-0 rounded-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="text-white">
                                    <h2 class="mb-0 number-font fw-bold">{{ $totalSellers ?? 0 }}</h2>
                                    <p class="text-white-50 mb-0 fs-13">Total Sellers</p>
                                </div>
                                <div class="ms-auto text-white-50">
                                    <i class="fe fe-users fs-30"></i>
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
                                    <h2 class="mb-0 number-font fw-bold">{{ $verifiedSellers ?? 0 }}</h2>
                                    <p class="text-white-50 mb-0 fs-13">Verified</p>
                                </div>
                                <div class="ms-auto text-white-50">
                                    <i class="fe fe-check-circle fs-30"></i>
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
                                    <h2 class="mb-0 number-font fw-bold">{{ $pendingSellers ?? 0 }}</h2>
                                    <p class="text-white-50 mb-0 fs-13">Pending</p>
                                </div>
                                <div class="ms-auto text-white-50">
                                    <i class="fe fe-clock fs-30"></i>
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
                                    <h2 class="mb-0 number-font fw-bold">{{ $suspendedSellers ?? 0 }}</h2>
                                    <p class="text-white-50 mb-0 fs-13">Suspended</p>
                                </div>
                                <div class="ms-auto text-white-50">
                                    <i class="fe fe-slash fs-30"></i>
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
                            <i class="fe fe-users me-2 text-primary"></i>Sellers
                        </h3>
                        <p class="text-muted mb-0 fs-12">Manage all sellers on the platform</p>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filter Section -->
                    <form id="filterForm" method="GET" action="{{ route('admin.sellers.index') }}" class="mb-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold fs-12 mb-1">Search</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fe fe-search"></i></span>
                                    <input type="text" name="search" id="searchInput" class="form-control"
                                        placeholder="Search by name or email..." value="{{ request('search') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold fs-12 mb-1">Status</label>
                                <select name="status" id="statusFilter" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>Active</option>
                                    <option value="suspended" {{ request('status')=='suspended' ? 'selected' : '' }}>Suspended</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold fs-12 mb-1">Verification</label>
                                <select name="verification" id="verificationFilter" class="form-select">
                                    <option value="">All</option>
                                    <option value="verified" {{ request('verification')=='verified' ? 'selected' : '' }}>Verified</option>
                                    <option value="pending" {{ request('verification')=='pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary w-100"><i class="fe fe-search"></i></button>
                                    <button type="button" class="btn btn-outline-secondary" id="resetFilters"><i class="fe fe-refresh-ccw"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive" id="table-container">
                        <table class="table table-hover table-bordered text-nowrap border-bottom">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Seller</th>
                                    <th>Store</th>
                                    <th>Products</th>
                                    <th>Sales</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th width="100">Access</th>
                                    <th width="100">Verified</th>
                                    <th width="280">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sellers as $seller)
                                <tr>
                                    <td>{{ $sellers->firstItem() + $loop->index }}</td>

                                    <!-- Seller Info -->
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($seller->avatar)
                                            <img src="{{ asset('storage/' . $seller->avatar) }}"
                                                alt="{{ $seller->name }}" width="35" height="35"
                                                class="rounded-circle me-2 border">
                                            @else
                                            <div class="avatar avatar-sm bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                {{ strtoupper(substr($seller->name, 0, 1)) }}
                                            </div>
                                            @endif
                                            <div>
                                                <span class="fw-semibold">{{ $seller->name }}</span>
                                                <br>
                                                <small class="text-muted">{{ $seller->email }}</small>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Store -->
                                    <td>
                                        @if($seller->sellerDetail)
                                        <span class="fw-semibold">{{ $seller->sellerDetail->store_name }}</span>
                                        <br>
                                        <small class="text-muted">{{ ucfirst($seller->sellerDetail->seller_type ?? 'individual') }}</small>
                                        @else
                                        <span class="text-muted">No store</span>
                                        @endif
                                    </td>

                                    <!-- Products -->
                                    <td>
                                        <span class="badge bg-info">{{ $seller->products_count ?? 0 }}</span>
                                    </td>

                                    <!-- Sales -->
                                    <td>
                                        <span class="badge bg-success">{{ $seller->sellerDetail->total_sales ?? 0 }}</span>
                                    </td>

                                    <!-- Rating -->
                                    <td>
                                        @if(($seller->sellerDetail->seller_rating ?? 0) > 0)
                                        <span class="badge bg-warning text-dark">
                                            {{ number_format($seller->sellerDetail->seller_rating, 1) }} ★
                                        </span>
                                        @else
                                        <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        @if($seller->sellerDetail && $seller->sellerDetail->is_suspended)
                                        <span class="badge bg-danger">Suspended</span>
                                        @elseif($seller->sellerDetail && $seller->sellerDetail->is_verified)
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>

                                    <!-- Access Permission -->
                                    <td>
                                        <div class="form-group mb-0">
                                            <label class="custom-switch form-switch">
                                                <input type="checkbox" name="status_{{ $seller->id }}"
                                                    class="custom-switch-input statusToggle globalStatusToggle"
                                                    data-id="{{ $seller->id }}" data-model="User" {{ $seller->status == 1 ? 'checked' : '' }}>
                                                <span class="custom-switch-indicator"></span>
                                                
                                            </label>
                                        </div>
                                    </td>

                                    <!-- Verified -->
                                    <td>
                                        @if($seller->sellerDetail && $seller->sellerDetail->is_verified)
                                        <span class="badge bg-success">Verified</span>
                                        @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <!-- View Button -->
                                            <button type="button" class="btn btn-outline-info btn-sm view-seller"
                                                title="View Details" data-id="{{ $seller->id }}"
                                                data-name="{{ $seller->name }}" data-email="{{ $seller->email }}"
                                                data-avatar="{{ $seller->avatar }}" data-phone="{{ $seller->phone }}"
                                                data-store="{{ $seller->sellerDetail->store_name ?? 'N/A' }}"
                                                data-store-type="{{ ucfirst($seller->sellerDetail->seller_type ?? 'individual') }}"
                                                data-company="{{ $seller->sellerDetail->company_name ?? 'N/A' }}"
                                                data-country="{{ $seller->sellerDetail->country ?? 'N/A' }}"
                                                data-state="{{ $seller->sellerDetail->state ?? 'N/A' }}"
                                                data-city="{{ $seller->sellerDetail->city ?? 'N/A' }}"
                                                data-website="{{ $seller->sellerDetail->website ?? 'N/A' }}"
                                                data-support-email="{{ $seller->sellerDetail->support_email ?? 'N/A' }}"
                                                data-rating="{{ $seller->sellerDetail->seller_rating ?? 0 }}"
                                                data-total-products="{{ $seller->products_count ?? 0 }}"
                                                data-total-sales="{{ $seller->sellerDetail->total_sales ?? 0 }}"
                                                data-is-verified="{{ $seller->sellerDetail ? $seller->sellerDetail->is_verified ? 1 : 0 : 0 }}"
                                                data-is-suspended="{{ $seller->sellerDetail ? $seller->sellerDetail->is_suspended ? 1 : 0 : 0 }}"
                                                data-is-featured="{{ $seller->sellerDetail ? $seller->sellerDetail->is_featured ? 1 : 0 : 0 }}"
                                                data-suspension-reason="{{ $seller->sellerDetail->suspension_reason ?? '' }}"
                                                data-created-at="{{ $seller->created_at->format('d M Y, h:i A') }}"
                                                data-bs-toggle="modal" data-bs-target="#viewSellerModal">
                                                <i class="fe fe-eye"></i>
                                                <span class="d-none d-md-inline ms-1">View</span>
                                            </button>

                                            @if($seller->sellerDetail)
                                                <!-- Verify/Unverify Button -->
                                                @if($seller->sellerDetail->is_verified)
                                                <button type="button" class="btn btn-outline-warning btn-sm unverify-seller"
                                                    title="Unverify Seller" data-id="{{ $seller->sellerDetail->id }}"
                                                    data-store="{{ $seller->sellerDetail->store_name }}">
                                                    <i class="fe fe-x-circle"></i>
                                                    <span class="d-none d-md-inline ms-1">Unverify</span>
                                                </button>
                                                @else
                                                <button type="button" class="btn btn-outline-success btn-sm verify-seller"
                                                    title="Verify Seller" data-id="{{ $seller->sellerDetail->id }}">
                                                    <i class="fe fe-check"></i>
                                                    <span class="d-none d-md-inline ms-1">Verify</span>
                                                </button>
                                                @endif

                                                <!-- Feature Button -->
                                                <button type="button"
                                                    class="btn btn-outline-{{ $seller->sellerDetail->is_featured ? 'warning' : 'secondary' }} btn-sm toggle-feature"
                                                    title="{{ $seller->sellerDetail->is_featured ? 'Remove Featured' : 'Mark as Featured' }}"
                                                    data-id="{{ $seller->sellerDetail->id }}">
                                                    <i class="fe fe-star"></i>
                                                    <span class="d-none d-md-inline ms-1">{{ $seller->sellerDetail->is_featured ? 'Unfeature' : 'Feature' }}</span>
                                                </button>

                                                <!-- Suspend/Unsuspend Button -->
                                                @if($seller->sellerDetail->is_suspended)
                                                <button type="button" class="btn btn-outline-success btn-sm unsuspend-seller"
                                                    title="Unsuspend Seller" data-id="{{ $seller->sellerDetail->id }}">
                                                    <i class="fe fe-play"></i>
                                                    <span class="d-none d-md-inline ms-1">Unsuspend</span>
                                                </button>
                                                @else
                                                <button type="button" class="btn btn-outline-danger btn-sm suspend-seller"
                                                    title="Suspend Seller" data-id="{{ $seller->sellerDetail->id }}"
                                                    data-name="{{ $seller->sellerDetail->store_name }}"
                                                    data-bs-toggle="modal" data-bs-target="#suspendSellerModal">
                                                    <i class="fe fe-slash"></i>
                                                    <span class="d-none d-md-inline ms-1">Suspend</span>
                                                </button>
                                                @endif
                                            @else
                                                <!-- Create Seller Detail Button -->
                                                <button type="button" class="btn btn-outline-success btn-sm create-seller-detail"
                                                    title="Create Seller Profile" data-id="{{ $seller->id }}"
                                                    data-name="{{ $seller->name }}">
                                                    <i class="fe fe-plus-circle"></i>
                                                    <span class="d-none d-md-inline ms-1">Create Profile</span>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <i class="fe fe-users fs-1 text-muted d-block mb-3"></i>
                                        <h5 class="text-muted">No Sellers Found</h5>
                                        <p class="text-muted fs-12">Sellers will appear here once they register</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between mt-4">
                        <div>
                            <span class="text-muted fs-13">
                                Showing {{ $sellers->firstItem() ?? 0 }} to {{ $sellers->lastItem() ?? 0 }}
                                of {{ $sellers->total() }} sellers
                            </span>
                        </div>
                        <div>
                            {{ $sellers->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- MODALS -->
<!-- ============================================ -->

<!-- View Modal -->
@include('admin.sellers.partials.view-modal')

<!-- Suspend Modal -->
@include('admin.sellers.partials.suspend-modal')

@endsection

@push('scripts')
<script>
$(document).ready(function() {

    // ============================================
    // RELOAD TABLE ONLY FUNCTION
    // ============================================
    function reloadTable() {
        let currentUrl = window.location.href.split('?')[0];
        $('#table-container').load(currentUrl + ' #table-container > *', function(responseText, textStatus, xhr) {
            if (textStatus === "error") {
                console.error("Table refresh failed: " + xhr.status);
            } else {
                console.log("✅ Table refreshed successfully");
                // Re-initialize select2 if exists
                if ($.fn.select2) {
                    $('.select2').select2({ width: '100%' });
                }
            }
        });
    }

    // ============================================
    // RESET FILTERS
    // ============================================
    $(document).on('click', '#resetFilters', function() {
        $('#filterForm')[0].reset();
        window.location.href = "{{ route('admin.sellers.index') }}";
    });

    // ============================================
    // REMOVE BACKDROP ON MODAL CLOSE
    // ============================================
    function removeModalBackdrop() {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        $('body').css('padding-right', '');
    }

    // ============================================
    // VERIFY SELLER
    // ============================================
    $(document).on('click', '.verify-seller', function() {
        const id = $(this).data('id');
        const button = $(this);
        const originalHtml = button.html();

        if (confirm('Are you sure you want to verify this seller?')) {
            button.prop('disabled', true);
            button.html('<span class="spinner-border spinner-border-sm me-1"></span>');

            $.ajax({
                url: `/admin/sellers/${id}/verify`,
                type: 'POST',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    toastr.success(res.message);
                    button.prop('disabled', false);
                    button.html(originalHtml);
                    reloadTable();
                },
                error: function(xhr) {
                    button.prop('disabled', false);
                    button.html(originalHtml);
                    toastr.error(xhr.responseJSON?.message || 'Failed to verify seller');
                }
            });
        }
    });

    // ============================================
    // UNVERIFY SELLER
    // ============================================
    $(document).on('click', '.unverify-seller', function() {
        const id = $(this).data('id');
        const store = $(this).data('store');
        const button = $(this);
        const originalHtml = button.html();

        if (confirm(`Are you sure you want to unverify "${store || 'this seller'}"?`)) {
            button.prop('disabled', true);
            button.html('<span class="spinner-border spinner-border-sm me-1"></span>');

            $.ajax({
                url: `/admin/sellers/${id}/unverify`,
                type: 'POST',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    toastr.success(res.message);
                    button.prop('disabled', false);
                    button.html(originalHtml);
                    reloadTable();
                },
                error: function(xhr) {
                    button.prop('disabled', false);
                    button.html(originalHtml);
                    toastr.error(xhr.responseJSON?.message || 'Failed to unverify seller');
                }
            });
        }
    });

    // ============================================
    // TOGGLE FEATURE
    // ============================================
    $(document).on('click', '.toggle-feature', function() {
        const id = $(this).data('id');
        const button = $(this);
        const originalHtml = button.html();

        button.prop('disabled', true);
        button.html('<span class="spinner-border spinner-border-sm me-1"></span>');

        $.ajax({
            url: `/admin/sellers/${id}/toggle-feature`,
            type: 'POST',
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                toastr.success(res.message);
                button.prop('disabled', false);
                button.html(originalHtml);
                reloadTable();
            },
            error: function(xhr) {
                button.prop('disabled', false);
                button.html(originalHtml);
                toastr.error(xhr.responseJSON?.message || 'Failed to update feature status');
            }
        });
    });

    // ============================================
    // UNSUSPEND SELLER
    // ============================================
    $(document).on('click', '.unsuspend-seller', function() {
        const id = $(this).data('id');
        const button = $(this);
        const originalHtml = button.html();

        if (confirm('Are you sure you want to unsuspend this seller?')) {
            button.prop('disabled', true);
            button.html('<span class="spinner-border spinner-border-sm me-1"></span>');

            $.ajax({
                url: `/admin/sellers/${id}/unsuspend`,
                type: 'POST',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    toastr.success(res.message);
                    button.prop('disabled', false);
                    button.html(originalHtml);
                    reloadTable();
                },
                error: function(xhr) {
                    button.prop('disabled', false);
                    button.html(originalHtml);
                    toastr.error(xhr.responseJSON?.message || 'Failed to unsuspend seller');
                }
            });
        }
    });

    // ============================================
    // SUSPEND SELLER - Open Modal
    // ============================================
    $(document).on('click', '.suspend-seller', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');

        $('#suspendSellerId').val(id);
        $('#suspendSellerName').text(name);
        $('#suspensionReason').val('');
        $('#suspendedUntil').val('');
        removeModalBackdrop();
    });

    // ============================================
    // CONFIRM SUSPEND
    // ============================================
    $(document).on('click', '#confirmSuspend', function() {
        const id = $('#suspendSellerId').val();
        const reason = $('#suspensionReason').val();
        const until = $('#suspendedUntil').val();
        const button = $(this);
        const originalHtml = button.html();

        if (!reason) {
            toastr.error('Please provide a suspension reason');
            return;
        }

        button.prop('disabled', true);
        button.html('<span class="spinner-border spinner-border-sm me-1"></span>');

        $.ajax({
            url: `/admin/sellers/${id}/suspend`,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                suspension_reason: reason,
                suspended_until: until || null
            },
            success: function(res) {
                toastr.success(res.message);
                $('#suspendSellerModal').modal('hide');
                removeModalBackdrop();
                button.prop('disabled', false);
                button.html(originalHtml);
                reloadTable();
            },
            error: function(xhr) {
                button.prop('disabled', false);
                button.html(originalHtml);
                toastr.error(xhr.responseJSON?.message || 'Failed to suspend seller');
            }
        });
    });

    // ============================================
    // VIEW SELLER - Populate Modal
    // ============================================
    $(document).on('click', '.view-seller', function() {
        const data = $(this).data();
        
        removeModalBackdrop();

        const store = data.store || 'N/A';
        const storeType = data.storeType || 'Individual';
        const company = data.company || 'N/A';
        const country = data.country || 'N/A';
        const state = data.state || 'N/A';
        const city = data.city || 'N/A';
        const website = data.website || 'N/A';
        const supportEmail = data.supportEmail || 'N/A';
        const rating = parseFloat(data.rating || 0).toFixed(1);
        const totalProducts = data.totalProducts || 0;
        const totalSales = data.totalSales || 0;
        const isVerified = data.isVerified == 1;
        const isSuspended = data.isSuspended == 1;
        const isFeatured = data.isFeatured == 1;
        const suspensionReason = data.suspensionReason || '';
        const avatar = data.avatar || null;
        const name = data.name || 'Unknown';
        const email = data.email || '';
        const phone = data.phone || '';
        const createdAt = data.createdAt || 'N/A';

        let html = `
            <div class="row">
                <div class="col-md-4 text-center">
                    ${avatar ? 
                        `<img src="/storage/${avatar}" alt="${name}" class="rounded-circle" width="120" height="120">` :
                        `<div class="avatar bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px; font-size: 48px;">
                            ${name.charAt(0).toUpperCase()}
                        </div>`
                    }
                    <h4 class="mt-3">${name}</h4>
                    <p class="text-muted">${email}</p>
                    ${phone ? `<p class="text-muted"><i class="fe fe-phone me-1"></i> ${phone}</p>` : ''}
                    ${website !== 'N/A' ? `<p class="text-muted"><i class="fe fe-globe me-1"></i> <a href="${website}" target="_blank">${website}</a></p>` : ''}
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6>Store</h6>
                                    <p class="fw-bold">${store}</p>
                                    <small class="text-muted">Type: ${storeType}</small>
                                    ${company !== 'N/A' ? `<br><small class="text-muted">Company: ${company}</small>` : ''}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6>Location</h6>
                                    <p class="fw-bold">${city !== 'N/A' ? city : '—'}</p>
                                    <small class="text-muted">${state !== 'N/A' ? state : ''} ${country !== 'N/A' ? country : ''}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6>Products</h6>
                                    <p class="fw-bold">${totalProducts}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6>Sales</h6>
                                    <p class="fw-bold">${totalSales}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6>Rating</h6>
                                    <p class="fw-bold">${rating} ★</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6>Status</h6>
                                    ${isSuspended ? 
                                        `<span class="badge bg-danger">Suspended</span>` :
                                        `<span class="badge bg-success">Active</span>`
                                    }
                                    ${isVerified ? 
                                        `<span class="badge bg-success ms-1">Verified</span>` :
                                        `<span class="badge bg-warning ms-1">Pending</span>`
                                    }
                                    ${isFeatured ? 
                                        `<span class="badge bg-warning ms-1"><i class="fe fe-star"></i> Featured</span>` : ''
                                    }
                                    ${isSuspended && suspensionReason ? 
                                        `<br><small class="text-danger mt-1 d-block">Reason: ${suspensionReason}</small>` : ''
                                    }
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6>Support</h6>
                                    ${supportEmail !== 'N/A' ? 
                                        `<p class="fw-bold mb-0"><i class="fe fe-mail me-1"></i> ${supportEmail}</p>` :
                                        `<p class="text-muted">No support email</p>`
                                    }
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6>Joined</h6>
                                    <p class="fw-bold mb-0">${createdAt}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('#viewSellerContent').html(html);
    });

    // ============================================
    // CREATE SELLER DETAIL (Quick Fix)
    // ============================================
    $(document).on('click', '.create-seller-detail', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const button = $(this);
        const originalHtml = button.html();

        if (confirm(`Create seller profile for "${name}"?`)) {
            button.prop('disabled', true);
            button.html('<span class="spinner-border spinner-border-sm me-1"></span>');

            $.ajax({
                url: `/admin/sellers/${id}/create-detail`,
                type: 'POST',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    toastr.success(res.message);
                    button.prop('disabled', false);
                    button.html(originalHtml);
                    reloadTable();
                },
                error: function(xhr) {
                    button.prop('disabled', false);
                    button.html(originalHtml);
                    toastr.error(xhr.responseJSON?.message || 'Failed to create seller profile');
                }
            });
        }
    });

    // ============================================
    // REMOVE BACKDROP ON MODAL CLOSE
    // ============================================
    $('#viewSellerModal').on('hidden.bs.modal', function() {
        removeModalBackdrop();
    });

    $('#suspendSellerModal').on('hidden.bs.modal', function() {
        removeModalBackdrop();
    });

    // ============================================
    // TOASTR CONFIG
    // ============================================
    if (typeof toastr !== 'undefined') {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000
        };
    }

});
</script>
@endpush