{{-- resources/views/seller/products/edit.blade.php --}}
@extends('layouts.master')

@section('title', 'Edit Product')

@section('content')

<div class="mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fe fe-edit-2 me-2 text-primary"></i>Edit Product
                    </h3>
                    <div class="card-actions">
                        <a href="{{ route('seller.products.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fe fe-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- ============================================ -->
                    <!-- STATUS WARNINGS -->
                    <!-- ============================================ -->
                    @if(isset($warning) && $warning)
                        <div class="alert alert-warning alert-dismissible fade show">
                            <i class="fe fe-alert-triangle me-2"></i>
                            {!! $warning !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(isset($canEdit) && $canEdit === false)
                        <div class="alert alert-danger">
                            <i class="fe fe-lock me-2"></i>
                            This product is archived and cannot be edited.
                        </div>
                    @endif

                    <!-- Status Info -->
                    <div class="alert alert-info">
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <i class="fe fe-info me-2"></i>
                            <strong>Status:</strong> 
                            <span class="badge {{ $product->status == 'published' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                            |
                            <strong>Approval:</strong> 
                            @if($product->is_approved)
                                <span class="badge bg-success">✅ Approved</span>
                                @if($product->status == 'published')
                                    <span class="badge bg-secondary ms-2">
                                        <i class="fe fe-eye me-1"></i> Live on Platform
                                    </span>
                                    <br>
                                    <small class="text-muted mt-1">
                                        <i class="fe fe-info me-1"></i> 
                                        <strong>Minor changes</strong> (Price, Description) update instantly. 
                                        <strong>Major changes</strong> (Title, Category, Files) require re-approval.
                                    </small>
                                @endif
                            @elseif($product->status == 'rejected')
                                <span class="badge bg-danger">❌ Rejected</span>
                                @if($product->rejection_reason)
                                    <br>
                                    <small class="text-danger mt-1">
                                        <i class="fe fe-info me-1"></i> Reason: {{ $product->rejection_reason }}
                                    </small>
                                @endif
                            @else
                                <span class="badge bg-warning">⏳ Pending</span>
                            @endif
                        </div>
                    </div>

                    <!-- ============================================ -->
                    <!-- EDIT FORM - ALL FIELDS EDITABLE -->
                    <!-- ============================================ -->
                    <form id="productForm" method="POST" action="{{ route('seller.products.update', $product->id) }}" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- LEFT COLUMN: Basic Details -->
                            <div class="col-md-6">
                                <h6 class="text-muted mb-3">Basic Information</h6>

                                <!-- Only disable if archived -->
                                @php
                                    $disabled = (isset($canEdit) && $canEdit === false) ? 'disabled' : '';
                                @endphp

                                <!-- Title -->
                                <div class="mb-3">
                                    <label class="form-label">Product Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" 
                                           value="{{ old('title', $product->title) }}" 
                                           {{ $disabled }} required>
                                    @error('title')
                                    <span class="text-danger fs-12">{{ $message }}</span>
                                    @enderror
                                    @if($product->status == 'published' && $product->is_approved)
                                    <small class="text-warning">
                                        <i class="fe fe-alert-triangle me-1"></i> Changing title will require re-approval
                                    </small>
                                    @endif
                                </div>

                                <!-- Category -->
                                <div class="mb-3">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="form-select" 
                                            {{ $disabled }} required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <span class="text-danger fs-12">{{ $message }}</span>
                                    @enderror
                                    @if($product->status == 'published' && $product->is_approved)
                                    <small class="text-warning">
                                        <i class="fe fe-alert-triangle me-1"></i> Changing category will require re-approval
                                    </small>
                                    @endif
                                </div>

                                <!-- Product Type -->
                                <div class="mb-3">
                                    <label class="form-label">Product Type <span class="text-danger">*</span></label>
                                    <select name="product_type" class="form-select" {{ $disabled }} required>
                                        <option value="ebook" {{ $product->product_type == 'ebook' ? 'selected' : '' }}>E-Book</option>
                                        <option value="template" {{ $product->product_type == 'template' ? 'selected' : '' }}>Template</option>
                                        <option value="video_course" {{ $product->product_type == 'video_course' ? 'selected' : '' }}>Video Course</option>
                                        <option value="software" {{ $product->product_type == 'software' ? 'selected' : '' }}>Software</option>
                                        <option value="design_asset" {{ $product->product_type == 'design_asset' ? 'selected' : '' }}>Design Asset</option>
                                        <option value="audio" {{ $product->product_type == 'audio' ? 'selected' : '' }}>Audio</option>
                                        <option value="other" {{ $product->product_type == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('product_type')
                                    <span class="text-danger fs-12">{{ $message }}</span>
                                    @enderror
                                    @if($product->status == 'published' && $product->is_approved)
                                    <small class="text-warning">
                                        <i class="fe fe-alert-triangle me-1"></i> Changing product type will require re-approval
                                    </small>
                                    @endif
                                </div>

                                <!-- Price -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Price <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="price" class="form-control" 
                                                   value="{{ old('price', $product->price) }}" 
                                                   {{ $disabled }} required>
                                            @error('price')
                                            <span class="text-danger fs-12">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Compare Price</label>
                                            <input type="number" step="0.01" name="compare_price" class="form-control" 
                                                   value="{{ old('compare_price', $product->compare_price) }}" 
                                                   {{ $disabled }}>
                                            @error('compare_price')
                                            <span class="text-danger fs-12">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Delivery Type -->
                                <div class="mb-3">
                                    <label class="form-label">Delivery Type <span class="text-danger">*</span></label>
                                    <select name="delivery_type" id="delivery_type" class="form-select" {{ $disabled }} required>
                                        <option value="direct_download" {{ $product->delivery_type == 'direct_download' ? 'selected' : '' }}>Direct Download</option>
                                        <option value="external_link" {{ $product->delivery_type == 'external_link' ? 'selected' : '' }}>External Link</option>
                                        <option value="email_delivery" {{ $product->delivery_type == 'email_delivery' ? 'selected' : '' }}>Email Delivery</option>
                                    </select>
                                    @error('delivery_type')
                                    <span class="text-danger fs-12">{{ $message }}</span>
                                    @enderror
                                    @if($product->status == 'published' && $product->is_approved)
                                    <small class="text-warning">
                                        <i class="fe fe-alert-triangle me-1"></i> Changing delivery type will require re-approval
                                    </small>
                                    @endif
                                </div>

                                <!-- External URL -->
                                <div class="mb-3" id="external_url_field" style="{{ $product->delivery_type == 'external_link' ? '' : 'display:none;' }}">
                                    <label class="form-label">External URL</label>
                                    <input type="url" name="external_url" class="form-control" 
                                           value="{{ old('external_url', $product->external_url) }}" 
                                           {{ $disabled }} placeholder="https://example.com/product">
                                    @error('external_url')
                                    <span class="text-danger fs-12">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Download Limit -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Download Limit</label>
                                            <input type="number" name="download_limit" class="form-control" 
                                                   value="{{ old('download_limit', $product->download_limit) }}" 
                                                   {{ $disabled }} min="0">
                                            @error('download_limit')
                                            <span class="text-danger fs-12">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch mt-4">
                                            <input type="hidden" name="is_unlimited" value="0" {{ $disabled }}>
                                            <input type="checkbox" name="is_unlimited" id="is_unlimited" 
                                                   class="form-check-input" value="1" 
                                                   {{ $product->is_unlimited ? 'checked' : '' }}
                                                   {{ $disabled }}>
                                            <label class="form-check-label" for="is_unlimited">Unlimited Downloads</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT COLUMN: Attributes -->
                            <div class="col-md-6">
                                <h6 class="text-muted mb-3">Product Attributes</h6>
                                <div id="attributesContainer">
                                    @if($product->attributes->count() > 0)
                                        @foreach($product->attributes as $attribute)
                                        <div class="mb-3">
                                            <label class="form-label">{{ $attribute->label }}</label>
                                            @if($attribute->type === 'boolean')
                                                <div class="form-check form-switch">
                                                    <input type="hidden" name="attributes[{{ $attribute->key }}]" value="0" {{ $disabled }}>
                                                    <input type="checkbox" name="attributes[{{ $attribute->key }}]" 
                                                           value="1" class="form-check-input" 
                                                           {{ $attribute->value_boolean ? 'checked' : '' }}
                                                           {{ $disabled }}>
                                                </div>
                                            @elseif($attribute->type === 'select')
                                                <select name="attributes[{{ $attribute->key }}]" class="form-select" {{ $disabled }}>
                                                    <option value="">Select...</option>
                                                    @foreach($attribute->options ?? [] as $option)
                                                    <option value="{{ $option }}" {{ $attribute->getValue() == $option ? 'selected' : '' }}>
                                                        {{ $option }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input type="{{ $attribute->type === 'number' ? 'number' : 'text' }}" 
                                                       name="attributes[{{ $attribute->key }}]" 
                                                       class="form-control" 
                                                       value="{{ $attribute->getValue() }}" 
                                                       {{ $attribute->is_required ? 'required' : '' }}
                                                       {{ $disabled }}>
                                            @endif
                                            @if($product->status == 'published' && $product->is_approved)
                                            <small class="text-warning">
                                                <i class="fe fe-alert-triangle me-1"></i> Changing attributes will require re-approval
                                            </small>
                                            @endif
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-info">
                                            <i class="fe fe-info me-2"></i>
                                            Select a category to see product attributes
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="text-muted mb-3">Description</h6>
                                <div class="mb-3">
                                    <label class="form-label">Short Description</label>
                                    <textarea name="short_description" class="form-control" rows="2" 
                                              {{ $disabled }}>{{ old('short_description', $product->short_description) }}</textarea>
                                    @error('short_description')
                                    <span class="text-danger fs-12">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Full Description</label>
                                    <textarea name="description" class="form-control" rows="4" 
                                              {{ $disabled }}>{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                    <span class="text-danger fs-12">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Files -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="text-muted mb-3">Files</h6>
                                
                                <!-- Current Files -->
                                @if($product->files->count() > 0)
                                <div class="mb-3">
                                    <label class="form-label">Current Files</label>
                                    <div class="list-group">
                                        @foreach($product->files as $file)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <span>
                                                <i class="fe fe-file me-2"></i>
                                                {{ $file->original_name }}
                                                <span class="badge bg-secondary ms-2">{{ $file->file_type }}</span>
                                                <span class="badge bg-light ms-2">{{ $file->getFileSizeHuman() }}</span>
                                            </span>
                                            <a href="{{ route('product.file.download', $file->id) }}" 
                                               class="btn btn-sm btn-outline-success" target="_blank">
                                                <i class="fe fe-download"></i>
                                            </a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Main File</label>
                                            <input type="file" name="main_file" class="form-control" {{ $disabled }}>
                                            <small class="text-muted">Upload new file to replace (Max: 20MB)</small>
                                            @if($product->status == 'published' && $product->is_approved)
                                            <small class="text-warning d-block">
                                                <i class="fe fe-alert-triangle me-1"></i> Changing main file will require re-approval
                                            </small>
                                            @endif
                                            @error('main_file')
                                            <span class="text-danger fs-12">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Preview File</label>
                                            <input type="file" name="preview_file" class="form-control" {{ $disabled }}>
                                            <small class="text-muted">Upload new file to replace (Max: 20MB)</small>
                                            @if($product->status == 'published' && $product->is_approved)
                                            <small class="text-warning d-block">
                                                <i class="fe fe-alert-triangle me-1"></i> Changing preview file will require re-approval
                                            </small>
                                            @endif
                                            @error('preview_file')
                                            <span class="text-danger fs-12">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="text-end mt-3">
                            <a href="{{ route('seller.products.index') }}" class="btn btn-secondary">Cancel</a>
                            @if(!isset($canEdit) || $canEdit !== false)
                                @if($product->status == 'published' && $product->is_approved)
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fe fe-refresh-ccw me-1"></i> Update & Resubmit for Review
                                    </button>
                                @elseif($product->status == 'rejected')
                                    <button type="submit" class="btn btn-success">
                                        <i class="fe fe-check me-1"></i> Resubmit for Review
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fe fe-save me-1"></i> Update Product
                                    </button>
                                @endif
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {

    // ============================================
    // TOGGLE EXTERNAL URL FIELD
    // ============================================
    $('#delivery_type').on('change', function() {
        if ($(this).val() === 'external_link') {
            $('#external_url_field').show();
        } else {
            $('#external_url_field').hide();
        }
    });

    // ============================================
    // LOAD ATTRIBUTES ON CATEGORY CHANGE
    // ============================================
    $('#category_id').on('change', function() {
        const categoryId = $(this).val();
        
        if (!categoryId) {
            $('#attributesContainer').html(`
                <div class="alert alert-info">
                    <i class="fe fe-info me-2"></i>
                    Select a category to see product attributes
                </div>
            `);
            return;
        }

        $('#attributesContainer').html(`
            <div class="text-center py-3">
                <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                <span class="ms-2">Loading attributes...</span>
            </div>
        `);

        $.ajax({
            url: `/seller/categories/${categoryId}/attributes`,
            type: 'GET',
            success: function(response) {
                if (response.success && response.fields) {
                    renderAttributes(response.fields);
                } else {
                    $('#attributesContainer').html(`
                        <div class="alert alert-info">
                            No attributes defined for this category
                        </div>
                    `);
                }
            },
            error: function() {
                $('#attributesContainer').html(`
                    <div class="alert alert-danger">
                        Failed to load attributes. Please try again.
                    </div>
                `);
            }
        });
    });

    // ============================================
    // RENDER ATTRIBUTE FIELDS
    // ============================================
    function renderAttributes(fields) {
        let html = '';
        
        for (const [key, field] of Object.entries(fields)) {
            const required = field.required ? '<span class="text-danger">*</span>' : '';
            const label = field.label || key;
            const type = field.type || 'text';
            const options = field.options || [];
            
            html += `<div class="mb-3">`;
            html += `<label class="form-label">${label} ${required}</label>`;
            
            switch (type) {
                case 'textarea':
                    html += `<textarea name="attributes[${key}]" class="form-control" rows="2"></textarea>`;
                    break;
                case 'select':
                    html += `<select name="attributes[${key}]" class="form-select">`;
                    html += `<option value="">Select...</option>`;
                    options.forEach(opt => {
                        html += `<option value="${opt}">${opt}</option>`;
                    });
                    html += `</select>`;
                    break;
                case 'boolean':
                    html += `
                        <div class="form-check form-switch">
                            <input type="hidden" name="attributes[${key}]" value="0">
                            <input type="checkbox" name="attributes[${key}]" value="1" class="form-check-input">
                        </div>
                    `;
                    break;
                case 'number':
                    html += `<input type="number" name="attributes[${key}]" class="form-control" step="any">`;
                    break;
                case 'date':
                    html += `<input type="date" name="attributes[${key}]" class="form-control">`;
                    break;
                default:
                    html += `<input type="text" name="attributes[${key}]" class="form-control">`;
            }
            
            html += `</div>`;
        }
        
        $('#attributesContainer').html(html);
    }

});
</script>
@endpush