{{-- resources/views/seller/products/index.blade.php --}}
@extends('layouts.master')

@section('title', 'My Products')

@section('content')

<div class="mt-5" id="data-table-container">
    <div class="row row-sm">
        <div class="col-lg-12">
            
            <!-- ============================================ -->
            <!-- ALERT MESSAGES -->
            <!-- ============================================ -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fe fe-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fe fe-alert-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fe fe-alert-circle me-2"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

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

            <!-- Main Card -->
            <div class="card">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h3 class="card-title mb-1 fw-bold">
                            <i class="fe fe-shopping-bag me-2 text-primary"></i>My Products
                        </h3>
                        <p class="text-muted mb-0 fs-12">Manage your digital products</p>
                    </div>
                    <div>
                        <a href="{{ route('seller.products.create') }}" class="btn btn-primary btn-sm">
                            <i class="fe fe-plus me-1"></i> Add Product
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filter Section -->
                    <form id="filterForm" method="GET" action="{{ route('seller.products.index') }}" class="mb-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold fs-12 mb-1">Search</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fe fe-search"></i></span>
                                    <input type="text" name="search" id="searchInput" class="form-control"
                                        placeholder="Search products..." value="{{ request('search') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold fs-12 mb-1">Status</label>
                                <select name="status" id="statusFilter" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="published" {{ request('status')=='published' ? 'selected' : '' }}>Published</option>
                                    <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="archived" {{ request('status')=='archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold fs-12 mb-1">Category</label>
                                <select name="category_id" id="categoryFilter" class="form-select">
                                    <option value="">All Categories</option>
                                    @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
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
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Approval</th>
                                    <th>Date</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr>
                                    <td>{{ $products->firstItem() + $loop->index }}</td>
                                    <td>
                                        <span class="fw-semibold">{{ Str::limit($product->title, 30) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $product->category->name ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        @if($product->compare_price && $product->price < $product->compare_price)
                                        <span class="text-muted text-decoration-line-through fs-12">${{ number_format($product->compare_price, 2) }}</span>
                                        <br>
                                        @endif
                                        <span class="fw-bold">${{ number_format($product->price, 2) }}</span>
                                    </td>
                                    <td>
                                        @php
                                        $statusColors = [
                                            'pending' => 'bg-warning text-dark',
                                            'published' => 'bg-success',
                                            'rejected' => 'bg-danger',
                                            'draft' => 'bg-secondary',
                                            'archived' => 'bg-dark'
                                        ];
                                        @endphp
                                        <span class="badge {{ $statusColors[$product->status] ?? 'bg-secondary' }}">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                        @if($product->status == 'archived')
                                        <br>
                                        <span class="badge bg-dark">Hidden</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product->is_approved)
                                        <span class="badge bg-success">Approved</span>
                                        @elseif($product->status == 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                        @if($product->rejection_reason)
                                        <br>
                                        <small class="text-danger" title="{{ $product->rejection_reason }}">
                                            <i class="fe fe-info"></i> {{ Str::limit($product->rejection_reason, 20) }}
                                        </small>
                                        @endif
                                        @elseif($product->status == 'archived')
                                        <span class="badge bg-secondary">Archived</span>
                                        @else
                                        <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fs-12">{{ $product->created_at->format('d M Y') }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <!-- View Button -->
                                            <button type="button" class="btn btn-outline-info view-product"
                                                data-id="{{ $product->id }}"
                                                data-title="{{ $product->title }}"
                                                data-slug="{{ $product->slug }}"
                                                data-description="{{ $product->description }}"
                                                data-short-description="{{ $product->short_description }}"
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
                                                data-rejection-reason="{{ $product->rejection_reason ?? '' }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewProductModal"
                                                title="View Details">
                                                <i class="fe fe-eye"></i>
                                            </button>

                                            <!-- Edit Button - Based on status -->
                                            @if($product->status != 'archived')
                                                @if($product->status == 'published' && $product->is_approved)
                                                    <a href="{{ route('seller.products.edit', $product->id) }}"
                                                       class="btn btn-outline-warning" title="Edit (Changes will be reviewed)">
                                                        <i class="fe fe-edit-2"></i>
                                                    </a>
                                                @elseif($product->status != 'published')
                                                    <a href="{{ route('seller.products.edit', $product->id) }}"
                                                       class="btn btn-outline-primary" title="Edit Product">
                                                        <i class="fe fe-edit-2"></i>
                                                    </a>
                                                @endif
                                            @endif

                                            <!-- Delete Button - Only for non-published products -->
                                            @if($product->status != 'published' && $product->status != 'archived')
                                            <button type="button" class="btn btn-outline-danger delete-product"
                                                data-id="{{ $product->id }}"
                                                data-name="{{ $product->title }}"
                                                title="Delete Product">
                                                <i class="fe fe-trash-2"></i>
                                            </button>
                                            @endif

                                            <!-- Archive/Unarchive for Published products -->
                                            @if($product->status == 'published' && $product->is_approved)
                                            <button type="button" class="btn btn-outline-secondary archive-product"
                                                data-id="{{ $product->id }}"
                                                data-name="{{ $product->title }}"
                                                title="Archive (Remove from public view)">
                                                <i class="fe fe-archive"></i>
                                            </button>
                                            @endif

                                            @if($product->status == 'archived')
                                            <button type="button" class="btn btn-outline-success unarchive-product"
                                                data-id="{{ $product->id }}"
                                                data-name="{{ $product->title }}"
                                                title="Unarchive (Restore to public view)">
                                                <i class="fe fe-refresh-ccw"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="fe fe-shopping-bag fs-1 text-muted d-block mb-3"></i>
                                        <h5 class="text-muted">No Products Found</h5>
                                        <p class="text-muted fs-12">Start by creating your first product</p>
                                        <a href="{{ route('seller.products.create') }}" class="btn btn-primary btn-sm mt-2">
                                            <i class="fe fe-plus me-1"></i> Add Product
                                        </a>
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
<!-- DELETE CONFIRMATION MODAL -->
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
                <button type="button" class="btn btn-danger" id="confirmDelete">
                    <i class="fe fe-trash-2 me-1"></i> Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- VIEW PRODUCT MODAL -->
<!-- ============================================ -->
@include('seller.products.partials.view-modal')

@endsection

@push('scripts')
<script>
$(document).ready(function() {

    // ============================================
    // RESET FILTERS
    // ============================================
    $(document).on('click', '#resetFilters', function() {
        $('#filterForm')[0].reset();
        window.location.href = "{{ route('seller.products.index') }}";
    });

    // ============================================
    // DELETE PRODUCT - Open Confirmation
    // ============================================
    $(document).on('click', '.delete-product', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');

        $('#deleteProductName').text(name);
        $('#deleteProductId').val(id);

        const modal = new bootstrap.Modal(document.getElementById('deleteProductModal'));
        modal.show();
    });

    // ============================================
    // CONFIRM DELETE
    // ============================================
    $(document).on('click', '#confirmDelete', function() {
        const id = $('#deleteProductId').val();
        const button = $(this);
        const original = button.html();

        button.prop('disabled', true);
        button.html('<span class="spinner-border spinner-border-sm me-1"></span>');

        $.ajax({
            url: `/seller/products/${id}`,
            type: 'DELETE',
            data: { _token: $('meta[name="csrf-token"]').attr('content') },
            success: function(res) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteProductModal'));
                if (modal) modal.hide();
                toastr.success(res.message);
                button.prop('disabled', false);
                button.html(original);
                setTimeout(() => window.location.reload(), 800);
            },
            error: function(xhr) {
                button.prop('disabled', false);
                button.html(original);
                toastr.error(xhr.responseJSON?.message || 'Failed to delete');
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteProductModal'));
                if (modal) modal.hide();
            }
        });
    });

    // ============================================
    // ARCHIVE PRODUCT
    // ============================================
    $(document).on('click', '.archive-product', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');

        if (confirm(`Are you sure you want to archive "${name}"? It will be removed from public view.`)) {
            $.ajax({
                url: `/seller/products/${id}/archive`,
                type: 'POST',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    toastr.success(res.message);
                    setTimeout(() => window.location.reload(), 800);
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Failed to archive product');
                }
            });
        }
    });

    // ============================================
    // UNARCHIVE PRODUCT
    // ============================================
    $(document).on('click', '.unarchive-product', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');

        if (confirm(`Are you sure you want to unarchive "${name}"? It will be visible to public again.`)) {
            $.ajax({
                url: `/seller/products/${id}/unarchive`,
                type: 'POST',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    toastr.success(res.message);
                    setTimeout(() => window.location.reload(), 800);
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Failed to unarchive product');
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