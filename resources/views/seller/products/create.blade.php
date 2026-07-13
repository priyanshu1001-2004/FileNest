{{-- resources/views/seller/products/create.blade.php --}}
@extends('layouts.master')

@section('title', 'Add Product')

@section('content')

<div class="mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fe fe-plus-circle me-2 text-primary"></i>Add New Product
                    </h3>
                    <div class="card-actions">
                        <a href="{{ route('seller.products.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fe fe-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="productForm" method="POST" action="{{ route('seller.products.store') }}" 
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- LEFT COLUMN: Basic Details -->
                            <div class="col-md-6">
                                <h6 class="text-muted mb-3">Basic Information</h6>

                                <div class="mb-3">
                                    <label class="form-label">Product Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" 
                                           value="{{ old('title') }}" placeholder="Enter product title" required>
                                    @error('title')
                                    <span class="text-danger fs-12">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="form-select" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <span class="text-danger fs-12">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Product Type <span class="text-danger">*</span></label>
                                    <select name="product_type" class="form-select" required>
                                        <option value="">Select Type</option>
                                        <option value="ebook" {{ old('product_type') == 'ebook' ? 'selected' : '' }}>E-Book</option>
                                        <option value="template" {{ old('product_type') == 'template' ? 'selected' : '' }}>Template</option>
                                        <option value="video_course" {{ old('product_type') == 'video_course' ? 'selected' : '' }}>Video Course</option>
                                        <option value="software" {{ old('product_type') == 'software' ? 'selected' : '' }}>Software</option>
                                        <option value="design_asset" {{ old('product_type') == 'design_asset' ? 'selected' : '' }}>Design Asset</option>
                                        <option value="audio" {{ old('product_type') == 'audio' ? 'selected' : '' }}>Audio</option>
                                        <option value="other" {{ old('product_type') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('product_type')
                                    <span class="text-danger fs-12">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Price <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" name="price" class="form-control" 
                                                   value="{{ old('price') }}" placeholder="0.00" required>
                                            @error('price')
                                            <span class="text-danger fs-12">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Compare Price</label>
                                            <input type="number" step="0.01" name="compare_price" class="form-control" 
                                                   value="{{ old('compare_price') }}" placeholder="0.00">
                                            @error('compare_price')
                                            <span class="text-danger fs-12">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Delivery Type <span class="text-danger">*</span></label>
                                    <select name="delivery_type" id="delivery_type" class="form-select" required>
                                        <option value="direct_download" {{ old('delivery_type') == 'direct_download' ? 'selected' : '' }}>Direct Download</option>
                                        <option value="external_link" {{ old('delivery_type') == 'external_link' ? 'selected' : '' }}>External Link</option>
                                        <option value="email_delivery" {{ old('delivery_type') == 'email_delivery' ? 'selected' : '' }}>Email Delivery</option>
                                    </select>
                                    @error('delivery_type')
                                    <span class="text-danger fs-12">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3" id="external_url_field" style="display:none;">
                                    <label class="form-label">External URL</label>
                                    <input type="url" name="external_url" class="form-control" 
                                           value="{{ old('external_url') }}" placeholder="https://example.com/product">
                                    @error('external_url')
                                    <span class="text-danger fs-12">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Download Limit</label>
                                            <input type="number" name="download_limit" class="form-control" 
                                                   value="{{ old('download_limit', 5) }}" min="0">
                                            @error('download_limit')
                                            <span class="text-danger fs-12">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch mt-4">
                                            <input type="hidden" name="is_unlimited" value="0">
                                            <input type="checkbox" name="is_unlimited" id="is_unlimited" class="form-check-input" value="1" {{ old('is_unlimited') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_unlimited">Unlimited Downloads</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT COLUMN: Attributes -->
                            <div class="col-md-6">
                                <h6 class="text-muted mb-3">Product Attributes</h6>
                                <div id="attributesContainer">
                                    <div class="alert alert-info">
                                        <i class="fe fe-info me-2"></i>
                                        Select a category to see product attributes
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6 class="text-muted mb-3">Description</h6>
                                <div class="mb-3">
                                    <label class="form-label">Short Description</label>
                                    <textarea name="short_description" class="form-control" rows="2">{{ old('short_description') }}</textarea>
                                    @error('short_description')
                                    <span class="text-danger fs-12">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Full Description</label>
                                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Main File <span class="text-danger">*</span></label>
                                            <input type="file" name="main_file" class="form-control" required>
                                            <small class="text-muted">Max size: 20MB</small>
                                            @error('main_file')
                                            <span class="text-danger fs-12">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Preview File</label>
                                            <input type="file" name="preview_file" class="form-control">
                                            <small class="text-muted">Optional preview file (Max: 20MB)</small>
                                            @error('preview_file')
                                            <span class="text-danger fs-12">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-3">
                            <a href="{{ route('seller.products.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fe fe-save me-1"></i> Submit for Review
                            </button>
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

        // Show loading
        $('#attributesContainer').html(`
            <div class="text-center py-3">
                <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                <span class="ms-2">Loading attributes...</span>
            </div>
        `);

        // Fetch attributes
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