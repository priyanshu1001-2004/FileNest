{{-- resources/views/admin/products/index.blade.php --}}
@extends('layouts.master')

@section('title', 'Admin | Products')

@section('content')

<div class="mt-5" id="data-table-container">
    <div class="row row-sm">
        <div class="col-lg-12">
            <!-- ============================================ -->
            <!-- STATISTICS CARDS -->
            <!-- ============================================ -->
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
                                    <h2 class="mb-0 number-font fw-bold">{{ $approvedProducts ?? 0 }}</h2>
                                    <p class="text-white-50 mb-0 fs-13">Approved</p>
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

            <!-- ============================================ -->
            <!-- MAIN CARD -->
            <!-- ============================================ -->
            <div class="card">
                <!-- Card Header -->
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h3 class="card-title mb-1 fw-bold">
                            <i class="fe fe-shopping-bag me-2 text-primary"></i>Products
                        </h3>
                        <p class="text-muted mb-0 fs-12">Review, approve, and manage seller products</p>
                    </div>
                    <div>
                        <span class="badge bg-warning text-dark fs-14">
                            <i class="fe fe-clock me-1"></i> {{ $pendingProducts ?? 0 }} Pending
                        </span>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <!-- ============================================ -->
                    <!-- FILTER SECTION -->
                    <!-- ============================================ -->
                    <form id="filterForm" method="GET" action="{{ route('admin.products.index') }}" class="mb-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold fs-12 mb-1">Search</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fe fe-search"></i></span>
                                    <input type="text" name="search" id="searchInput" class="form-control"
                                        placeholder="Search products..." value="{{ request('search') }}">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label fw-semibold fs-12 mb-1">Status</label>
                                <select name="status" id="statusFilter" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>
                                        <span class="badge bg-warning">Pending</span>
                                    </option>
                                    <option value="published" {{ request('status')=='published' ? 'selected' : '' }}>
                                        <span class="badge bg-success">Approved</span>
                                    </option>
                                    <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>
                                        <span class="badge bg-danger">Rejected</span>
                                    </option>
                                    <option value="draft" {{ request('status')=='draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="archived" {{ request('status')=='archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label fw-semibold fs-12 mb-1">Category</label>
                                <select name="category_id" id="categoryFilter" class="form-select">
                                    <option value="">All Categories</option>
                                    @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id')==$category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label fw-semibold fs-12 mb-1">Product Type</label>
                                <select name="product_type" id="typeFilter" class="form-select">
                                    <option value="">All Types</option>
                                    <option value="ebook" {{ request('product_type')=='ebook' ? 'selected' : '' }}>E-Book</option>
                                    <option value="template" {{ request('product_type')=='template' ? 'selected' : '' }}>Template</option>
                                    <option value="video_course" {{ request('product_type')=='video_course' ? 'selected' : '' }}>Video Course</option>
                                    <option value="software" {{ request('product_type')=='software' ? 'selected' : '' }}>Software</option>
                                    <option value="design_asset" {{ request('product_type')=='design_asset' ? 'selected' : '' }}>Design Asset</option>
                                    <option value="audio" {{ request('product_type')=='audio' ? 'selected' : '' }}>Audio</option>
                                    <option value="other" {{ request('product_type')=='other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="col-md-1">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary w-100"><i class="fe fe-search"></i></button>
                                    <button type="button" class="btn btn-outline-secondary" id="resetFilters"><i class="fe fe-refresh-ccw"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- ============================================ -->
                    <!-- TABLE -->
                    <!-- ============================================ -->
                    <div class="table-responsive" id="table-container">
                        <table class="table table-hover table-bordered text-nowrap border-bottom">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Seller</th>
                                    <th>Created</th>
                                    <th width="220">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr>
                                    <td>{{ $products->firstItem() + $loop->index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <span class="fw-semibold">{{ Str::limit($product->title, 30) }}</span>
                                                @if($product->is_featured)
                                                <span class="badge bg-warning ms-1"><i class="fe fe-star"></i></span>
                                                @endif
                                                @if($product->is_approved)
                                                <span class="badge bg-success ms-1">✓</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-info">{{ $product->category->name ?? 'N/A' }}</span></td>
                                    <td>
                                        @if($product->compare_price && $product->price < $product->compare_price)
                                        <span class="text-muted text-decoration-line-through fs-12">${{ number_format($product->compare_price, 2) }}</span>
                                        <br>
                                        @endif
                                        <span class="fw-bold">${{ number_format($product->price, 2) }}</span>
                                        @if($product->getDiscountPercentage() > 0)
                                        <span class="badge bg-danger ms-1">-{{ $product->getDiscountPercentage() }}%</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary text-uppercase fs-11">{{ str_replace('_', ' ', $product->product_type) }}</span>
                                    </td>
                                    <td>
                                        @php
                                        $statusColors = [
                                            'draft' => 'bg-secondary',
                                            'pending' => 'bg-warning text-dark',
                                            'published' => 'bg-success',
                                            'rejected' => 'bg-danger',
                                            'archived' => 'bg-dark'
                                        ];
                                        @endphp
                                        <span class="badge {{ $statusColors[$product->status] ?? 'bg-secondary' }}">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                        @if($product->is_approved)
                                        <br>
                                        <span class="badge bg-success">Approved</span>
                                        @endif
                                        @if($product->rejection_reason)
                                        <br>
                                        <small class="text-danger" title="{{ $product->rejection_reason }}">
                                            <i class="fe fe-info"></i> Rejected
                                        </small>
                                        @endif
                                    </td>
                                    <td><span class="fs-12">{{ $product->seller->name ?? 'N/A' }}</span></td>
                                    <td><span class="fs-12">{{ $product->created_at->format('d M Y') }}</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm flex-wrap" style="gap: 2px;">
                                            <!-- ========== VIEW ========== -->
                                            <button type="button" class="btn btn-outline-info view-product"
                                                data-id="{{ $product->id }}"
                                                data-title="{{ $product->title }}"
                                                data-slug="{{ $product->slug }}"
                                                data-description="{{ $product->description }}"
                                                data-price="{{ $product->price }}"
                                                data-compare-price="{{ $product->compare_price }}"
                                                data-product-type="{{ $product->product_type }}"
                                                data-status="{{ $product->status }}"
                                                data-is-approved="{{ $product->is_approved }}"
                                                data-is-featured="{{ $product->is_featured }}"
                                                data-category="{{ $product->category->name ?? 'N/A' }}"
                                                data-seller="{{ $product->seller->name ?? 'N/A' }}"
                                                data-created-at="{{ $product->created_at->format('d M Y, h:i A') }}"
                                                data-thumbnail="{{ $product->thumbnail ?? asset('images/default-product.png') }}"
                                                data-bs-toggle="modal" data-bs-target="#viewProductModal" title="View Details">
                                                <i class="fe fe-eye"></i>
                                            </button>

                                            <!-- ========== ATTRIBUTES ========== -->
                                            <a href="{{ route('admin.products.attributes.index', $product->id) }}"
                                                class="btn btn-outline-secondary" title="View Attributes">
                                                <i class="fe fe-list"></i>
                                            </a>

                                            <!-- ========== FILES ========== -->
                                            <a href="{{ route('admin.products.files.index', $product->id) }}"
                                                class="btn btn-outline-secondary" title="View Files">
                                                <i class="fe fe-file"></i>
                                            </a>

                                            <!-- ========== APPROVE / REJECT (Only for pending) ========== -->
                                            @if($product->status == 'pending')
                                                <button type="button" 
                                                        class="btn btn-outline-success approve-product"
                                                        data-id="{{ $product->id }}"
                                                        data-title="{{ $product->title }}"
                                                        title="Approve Product">
                                                    <i class="fe fe-check"></i>
                                                </button>
                                                <button type="button" 
                                                        class="btn btn-outline-danger reject-product"
                                                        data-id="{{ $product->id }}"
                                                        data-title="{{ $product->title }}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#rejectProductModal"
                                                        title="Reject Product">
                                                    <i class="fe fe-x"></i>
                                                </button>
                                            @endif

                                            <!-- ========== FEATURE TOGGLE (For approved products) ========== -->
                                            @if($product->status == 'published' && $product->is_approved)
                                                <button type="button" 
                                                        class="btn btn-outline-{{ $product->is_featured ? 'warning' : 'secondary' }} toggle-featured"
                                                        data-id="{{ $product->id }}"
                                                        data-featured="{{ $product->is_featured ? 1 : 0 }}"
                                                        title="{{ $product->is_featured ? 'Remove Featured' : 'Mark as Featured' }}">
                                                    <i class="fe fe-star"></i>
                                                </button>
                                            @endif

                                            <!-- ========== DELETE ========== -->
                                            <button type="button" class="btn btn-outline-danger delete-product"
                                                data-id="{{ $product->id }}" data-name="{{ $product->title }}"
                                                title="Delete Product">
                                                <i class="fe fe-trash-2"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <i class="fe fe-shopping-bag fs-1 text-muted d-block mb-3"></i>
                                        <h5 class="text-muted">No Products Found</h5>
                                        <p class="text-muted fs-12">Products uploaded by sellers will appear here</p>
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
                                Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }}
                                of {{ $products->total() }} products
                            </span>
                        </div>
                        <div>
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- VIEW PRODUCT MODAL -->
<!-- ============================================ -->
@include('admin.products.partials.view-modal')

<!-- ============================================ -->
<!-- REJECT PRODUCT MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="rejectProductModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    <i class="fe fe-alert-triangle me-2"></i>Reject Product
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fe fe-x-circle fs-1 text-danger"></i>
                </div>
                <p class="text-center">Are you sure you want to reject this product?</p>
                <div class="alert alert-warning text-center">
                    <strong>Product:</strong> <span id="rejectProductName"></span>
                </div>
                <div class="mb-3">
                    <label class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                    <textarea id="rejectionReason" class="form-control" rows="3" 
                              placeholder="Why is this product being rejected?" required></textarea>
                </div>
                <input type="hidden" id="rejectProductId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmReject">
                    <i class="fe fe-x me-1"></i> Reject Product
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- DELETE PRODUCT MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="deleteProductModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    <i class="fe fe-alert-triangle me-2"></i>Delete Product
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fe fe-shopping-bag fs-1 text-danger"></i>
                </div>
                <p class="text-center">Are you sure you want to delete this product?</p>
                <div class="alert alert-warning text-center">
                    <strong>Product:</strong> <span id="deleteProductName"></span>
                </div>
                <p class="text-danger text-center small">
                    <i class="fe fe-info me-1"></i> This action cannot be undone.
                </p>
                <input type="hidden" id="deleteProductId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteProduct">
                    <i class="fe fe-trash-2 me-1"></i> Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {

    // ============================================
    // RELOAD TABLE FUNCTION
    // ============================================
    function reloadTable() {
        let currentUrl = window.location.href.split('?')[0];
        $('#table-container').load(currentUrl + ' #table-container > *', function(responseText, textStatus, xhr) {
            if (textStatus === "error") {
                console.error("Table refresh failed: " + xhr.status);
            } else {
                console.log("✅ Table refreshed");
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
        window.location.href = "{{ route('admin.products.index') }}";
    });

    // ============================================
    // VIEW PRODUCT - Populate Modal
    // ============================================
    $(document).on('click', '.view-product', function() {
        const data = $(this).data();
        // ... view modal population code
    });

    // ============================================
    // APPROVE PRODUCT
    // ============================================
    $(document).on('click', '.approve-product', function() {
        const id = $(this).data('id');
        const title = $(this).data('title');
        const button = $(this);
        const originalHtml = button.html();

        if (confirm(`Are you sure you want to approve "${title}"?`)) {
            button.prop('disabled', true);
            button.html('<span class="spinner-border spinner-border-sm me-1"></span>');

            $.ajax({
                url: `/admin/products/${id}/approve`,
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
                    toastr.error(xhr.responseJSON?.message || 'Failed to approve product');
                }
            });
        }
    });

    // ============================================
    // REJECT PRODUCT
    // ============================================
    $(document).on('click', '.reject-product', function() {
        const id = $(this).data('id');
        const title = $(this).data('title');
        
        $('#rejectProductId').val(id);
        $('#rejectProductName').text(title);
        $('#rejectionReason').val('');
    });

    $(document).on('click', '#confirmReject', function() {
        const id = $('#rejectProductId').val();
        const reason = $('#rejectionReason').val();
        const button = $(this);
        const originalHtml = button.html();

        if (!reason) {
            toastr.error('Please provide a rejection reason');
            return;
        }

        button.prop('disabled', true);
        button.html('<span class="spinner-border spinner-border-sm me-1"></span>');

        $.ajax({
            url: `/admin/products/${id}/reject`,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                rejection_reason: reason
            },
            success: function(res) {
                toastr.success(res.message);
                $('#rejectProductModal').modal('hide');
                button.prop('disabled', false);
                button.html(originalHtml);
                reloadTable();
            },
            error: function(xhr) {
                button.prop('disabled', false);
                button.html(originalHtml);
                toastr.error(xhr.responseJSON?.message || 'Failed to reject product');
            }
        });
    });

    // ============================================
    // TOGGLE FEATURED
    // ============================================
    $(document).on('click', '.toggle-featured', function() {
        const id = $(this).data('id');
        const isFeatured = $(this).data('featured');
        const button = $(this);
        const originalHtml = button.html();

        button.prop('disabled', true);
        button.html('<span class="spinner-border spinner-border-sm me-1"></span>');

        $.ajax({
            url: `/admin/products/${id}/toggle-featured`,
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
                toastr.error(xhr.responseJSON?.message || 'Failed to update featured status');
            }
        });
    });

    // ============================================
    // DELETE PRODUCT
    // ============================================
    $(document).on('click', '.delete-product', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const button = $(this);
        const originalHtml = button.html();

        if (confirm(`Are you sure you want to delete "${name}"?`)) {
            button.prop('disabled', true);
            button.html('<span class="spinner-border spinner-border-sm me-1"></span>');

            $.ajax({
                url: `/admin/products/${id}`,
                type: 'DELETE',
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
                    toastr.error(xhr.responseJSON?.message || 'Failed to delete product');
                }
            });
        }
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