{{-- resources/views/admin/products/partials/create-modal.blade.php --}}

<!-- ============================================ -->
<!-- CREATE PRODUCT MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="createProductModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fe fe-plus-circle text-primary me-2"></i>Add New Product
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createProductForm" class="ajax-form" method="POST" action="{{ route('admin.products.store') }}"
                data-modal="#createProductModal" data-reload="1">
                @csrf
                <div class="modal-body">
                    <div id="createProductErrors" class="alert alert-danger" style="display: none;"></div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Product Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" placeholder="Enter product title"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Seller <span class="text-danger">*</span></label>
                                <select name="seller_id" class="form-select" required>
                                    <option value="">Select Seller</option>
                                    @php $sellers = \App\Models\User::where('role', 1)->get(); @endphp
                                    @foreach($sellers as $seller)
                                    <option value="{{ $seller->id }}">{{ $seller->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Product Type <span class="text-danger">*</span></label>
                                <select name="product_type" class="form-select" required>
                                    <option value="">Select Type</option>
                                    <option value="ebook">E-Book</option>
                                    <option value="template">Template</option>
                                    <option value="video_course">Video Course</option>
                                    <option value="software">Software</option>
                                    <option value="design_asset">Design Asset</option>
                                    <option value="audio">Audio</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Price <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Compare Price</label>
                                <input type="number" step="0.01" name="compare_price" class="form-control"
                                    placeholder="0.00">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="draft">Draft</option>
                                    <option value="pending">Pending</option>
                                    <option value="published">Published</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="archived">Archived</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Delivery Type <span class="text-danger">*</span></label>
                                <select name="delivery_type" class="form-select" required>
                                    <option value="direct_download">Direct Download</option>
                                    <option value="external_link">External Link</option>
                                    <option value="email_delivery">Email Delivery</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Short Description</label>
                                <textarea name="short_description" class="form-control" rows="2"
                                    placeholder="Brief product description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Full Description</label>
                                <textarea name="description" class="form-control" rows="4"
                                    placeholder="Detailed product description"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">External URL</label>
                                <input type="url" name="external_url" class="form-control"
                                    placeholder="https://example.com/product">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Download Limit</label>
                                <input type="number" name="download_limit" class="form-control" value="5" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check form-switch mx-5">
                                <input class="form-check-input" type="checkbox" name="is_unlimited"
                                    id="create_is_unlimited" value="1" checked>
                                <label class="form-check-label" for="create_is_unlimited">Unlimited Downloads</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_featured"
                                    id="create_is_featured" value="1">
                                <label class="form-check-label" for="create_is_featured">Featured Product</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_approved"
                                    id="create_is_approved" value="1">
                                <label class="form-check-label" for="create_is_approved">Approved</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fe fe-save me-1"></i> Create Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    /**
     * ============================================
     * CREATE PRODUCT MODAL
     * ============================================
     */
    $(document).ready(function () {
        // Any additional create-specific logic here
        // Form is handled by global ajax-form
        console.log('✅ Create Product Modal Ready');
    });
</script>
@endpush