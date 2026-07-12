{{-- resources/views/admin/products/attributes/index.blade.php --}}
@extends('layouts.master')

@section('title', 'Product Attributes')

@section('content')

<div class="mt-5" id="data-table-container">
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <!-- Card Header -->
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h3 class="card-title mb-1 fw-bold">
                            <i class="fe fe-list me-2 text-primary"></i>Product Attributes
                            <span class="badge bg-primary ms-1">{{ $attributes->count() }}</span>
                        </h3>
                        <p class="text-muted mb-0 fs-12">
                            Viewing attributes for: <strong>{{ $product->title }}</strong>
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fe fe-arrow-left me-1"></i> Back to Products
                        </a>
                        {{-- ❌ REMOVED: Add Attribute Button (Admin only views) --}}
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <!-- Product Info Summary -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="card bg-light border-0">
                                <div class="card-body py-2">
                                    <small class="text-muted">Product</small>
                                    <h6 class="mb-0">{{ $product->title }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light border-0">
                                <div class="card-body py-2">
                                    <small class="text-muted">Category</small>
                                    <h6 class="mb-0">{{ $product->category->name ?? 'N/A' }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light border-0">
                                <div class="card-body py-2">
                                    <small class="text-muted">Status</small>
                                    <h6 class="mb-0">
                                        <span class="badge {{ $product->status == 'published' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light border-0">
                                <div class="card-body py-2">
                                    <small class="text-muted">Total Attributes</small>
                                    <h6 class="mb-0">{{ $attributes->count() }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive" id="table-container">
                        <table class="table table-hover table-bordered text-nowrap border-bottom">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">#</th>
                                    <th>Key</th>
                                    <th>Label</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                    <th width="100">Required</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attributes as $attribute)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><code class="fs-12">{{ $attribute->key }}</code></td>
                                    <td>{{ $attribute->label }}</td>
                                    <td>
                                        <span class="badge bg-secondary text-uppercase fs-11">
                                            {{ $attribute->type }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($attribute->type === 'file' && $attribute->file_name)
                                            <a href="{{ $attribute->getFileUrl() }}" target="_blank" class="text-primary">
                                                <i class="fe fe-file me-1"></i> {{ $attribute->file_name }}
                                            </a>
                                        @elseif($attribute->type === 'boolean')
                                            <span class="badge {{ $attribute->value_boolean ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $attribute->value_boolean ? 'Yes' : 'No' }}
                                            </span>
                                        @elseif(in_array($attribute->type, ['select', 'multiselect']))
                                            {{ implode(', ', $attribute->selected_options ?? []) }}
                                        @else
                                            {{ $attribute->getValue() ?? '—' }}
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $attribute->is_required ? 'bg-danger' : 'bg-secondary' }}">
                                            {{ $attribute->is_required ? 'Required' : 'Optional' }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fe fe-list fs-1 text-muted d-block mb-3"></i>
                                        <h5 class="text-muted">No Attributes Found</h5>
                                        <p class="text-muted fs-12">This product has no attributes defined</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection