{{-- resources/views/admin/products/index.blade.php --}}
@extends('layouts.master')

@section('title', 'Admin | Products')

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
                    <div class="card bg-info img-card border-0 rounded-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="text-white">
                                    <h2 class="mb-0 number-font fw-bold">{{ $featuredProducts ?? 0 }}</h2>
                                    <p class="text-white-50 mb-0 fs-13">Featured</p>
                                </div>
                                <div class="ms-auto text-white-50">
                                    <i class="fe fe-star fs-30"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="card">
                <!-- Card Header -->
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h3 class="card-title mb-1 fw-bold">
                            <i class="fe fe-shopping-bag me-2 text-primary"></i>Products
                        </h3>
                        <p class="text-muted mb-0 fs-12">Manage your digital products</p>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#createProductModal">
                            <i class="fe fe-plus me-1"></i> Add Product
                        </button>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <!-- Filter Section -->
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
                                <select name="status" id="statusFilter" class="form-select select2">
                                    <option value="">All Status</option>
                                    <option value="draft" {{ request('status')=='draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="published" {{ request('status')=='published' ? 'selected' : '' }}>Published</option>
                                    <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="archived" {{ request('status')=='archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label fw-semibold fs-12 mb-1">Category</label>
                                <select name="category_id" id="categoryFilter" class="form-select select2">
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
                                <select name="product_type" id="typeFilter" class="form-select select2">
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

                    <!-- Table -->
                    <div class="table-responsive" id="table-container">
                        <table class="table table-hover table-bordered text-nowrap border-bottom">
                            <thead class="">
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Seller</th>
                                    <th>Created</th>
                                    <th width="120">Actions</th>
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
                                    </td>
                                    <td><span class="fs-12">{{ $product->seller->name ?? 'N/A' }}</span></td>
                                    <td><span class="fs-12">{{ $product->created_at->format('d M Y') }}</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <!-- View Button -->
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
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewProductModal"
                                                title="View">
                                                <i class="fe fe-eye"></i>
                                            </button>

                                            <!-- Edit Button -->
                                            <button type="button" class="btn btn-outline-primary edit-product"
                                                data-id="{{ $product->id }}"
                                                data-title="{{ $product->title }}"
                                                data-slug="{{ $product->slug }}"
                                                data-description="{{ $product->description }}"
                                                data-short-description="{{ $product->short_description }}"
                                                data-price="{{ $product->price }}"
                                                data-compare-price="{{ $product->compare_price }}"
                                                data-product-type="{{ $product->product_type }}"
                                                data-status="{{ $product->status }}"
                                                data-category-id="{{ $product->category_id }}"
                                                data-seller-id="{{ $product->seller_id }}"
                                                data-delivery-type="{{ $product->delivery_type }}"
                                                data-external-url="{{ $product->external_url }}"
                                                data-download-limit="{{ $product->download_limit }}"
                                                data-is-unlimited="{{ $product->is_unlimited ? 1 : 0 }}"
                                                data-is-featured="{{ $product->is_featured ? 1 : 0 }}"
                                                data-is-approved="{{ $product->is_approved ? 1 : 0 }}"
                                                data-thumbnail="{{ $product->thumbnail ?? asset('images/default-product.png') }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editProductModal"
                                                title="Edit">
                                                <i class="fe fe-edit-2"></i>
                                            </button>

                                            <!-- Delete Button -->
                                            <button type="button" class="btn btn-outline-danger delete-product"
                                                data-id="{{ $product->id }}"
                                                data-name="{{ $product->title }}"
                                                title="Delete">
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
                                        <p class="text-muted fs-12">Start by creating your first product</p>
                                        <button type="button" class="btn btn-primary btn-sm mt-2" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#createProductModal">
                                            <i class="fe fe-plus me-1"></i> Add Product
                                        </button>
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
<!-- MODALS - Each with their own logic -->
<!-- ============================================ -->

<!-- Create Modal -->
@include('admin.products.partials.create-modal', ['categories' => $categories ?? [], 'sellers' => $sellers ?? []])

<!-- Edit Modal -->
@include('admin.products.partials.edit-modal')

<!-- View Modal -->
@include('admin.products.partials.view-modal')

<!-- Delete Modal -->
@include('admin.products.partials.delete-modal')

@endsection