{{-- resources/views/admin/products/files/index.blade.php --}}
@extends('layouts.master')

@section('title', 'Product Files')

@section('content')

<div class="mt-5" id="data-table-container">
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <!-- Card Header -->
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h3 class="card-title mb-1 fw-bold">
                            <i class="fe fe-file me-2 text-primary"></i>Product Files
                            <span class="badge bg-primary ms-1">{{ $files->count() }}</span>
                        </h3>
                        <p class="text-muted mb-0 fs-12">
                            Viewing files for: <strong>{{ $product->title }}</strong>
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fe fe-arrow-left me-1"></i> Back to Products
                        </a>
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
                                    <small class="text-muted">Total Files</small>
                                    <h6 class="mb-0">{{ $files->count() }}</h6>
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
                                    <th>File Name</th>
                                    <th>Type</th>
                                    <th>Size</th>
                                    <th>Downloads</th>
                                    <th>Limit</th>
                                    <th>Status</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($files as $file)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2 text-{{ $file->getColor() }}">
                                                <i class="fe {{ $file->getIcon() }} fs-4"></i>
                                            </div>
                                            <div>
                                                <span class="fw-semibold">{{ $file->original_name }}</span>
                                                <br>
                                                <small class="text-muted">{{ $file->file_type }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary text-uppercase fs-11">
                                            {{ $file->getFileExtension() }}
                                        </span>
                                    </td>
                                    <td>{{ $file->getFileSizeHuman() }}</td>
                                    <td>{{ $file->download_count }}</td>
                                    <td>
                                        @if($file->download_limit)
                                            <span class="badge bg-warning">{{ $file->download_limit }}</span>
                                        @else
                                            <span class="badge bg-success">Unlimited</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $file->is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $file->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('product.file.download', $file->id) }}" 
                                           class="btn btn-sm btn-outline-success" 
                                           target="_blank"
                                           title="Download File">
                                            <i class="fe fe-download"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="fe fe-file-off fs-1 text-muted d-block mb-3"></i>
                                        <h5 class="text-muted">No Files Found</h5>
                                        <p class="text-muted fs-12">This product has no files uploaded</p>
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