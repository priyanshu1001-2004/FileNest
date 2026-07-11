{{-- resources/views/admin/products/partials/edit-modal.blade.php --}}

<!-- ============================================ -->
<!-- EDIT PRODUCT MODAL -->
<!-- ============================================ -->
<!-- REMOVED: data-bs-backdrop="static" -->
<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fe fe-edit-2 text-primary me-2"></i>Edit Product
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editProductForm" class="ajax-form" method="POST" 
                  action="" 
                  data-modal="#editProductModal" 
                  data-reload="1">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div id="editProductErrors" class="alert alert-danger" style="display: none;"></div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Product Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="edit_title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <select name="category_id" id="edit_category_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    @php $categories = \App\Models\Category::where('status', true)->get(); @endphp
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Seller <span class="text-danger">*</span></label>
                                <select name="seller_id" id="edit_seller_id" class="form-select" required>
                                    <option value="">Select Seller</option>
                                    @php $sellers = \App\Models\User::where('role', 1)->get(); @endphp
                                    @foreach($sellers as $seller)
                                    <option value="{{ $seller->id }}">{{ $seller->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Product Type <span class="text-danger">*</span></label>
                                <select name="product_type" id="edit_product_type" class="form-select" required>
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
                                <input type="number" step="0.01" name="price" id="edit_price" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Compare Price</label>
                                <input type="number" step="0.01" name="compare_price" id="edit_compare_price" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="edit_status" class="form-select" required>
                                    <option value="draft">Draft</option>
                                    <option value="pending">Pending</option>
                                    <option value="published">Published</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="archived">Archived</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Delivery Type <span class="text-danger">*</span></label>
                                <select name="delivery_type" id="edit_delivery_type" class="form-select" required>
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
                                <textarea name="short_description" id="edit_short_description" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Full Description</label>
                                <textarea name="description" id="edit_description" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">External URL</label>
                                <input type="url" name="external_url" id="edit_external_url" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Download Limit</label>
                                <input type="number" name="download_limit" id="edit_download_limit" class="form-control" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check form-switch mx-5">
                                <input class="form-check-input" type="checkbox" name="is_unlimited" id="edit_is_unlimited" value="1">
                                <label class="form-check-label" for="edit_is_unlimited">Unlimited Downloads</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="edit_is_featured" value="1">
                                <label class="form-check-label" for="edit_is_featured">Featured Product</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_approved" id="edit_is_approved" value="1">
                                <label class="form-check-label" for="edit_is_approved">Approved</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fe fe-save me-1"></i> Update Product
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
 * EDIT PRODUCT MODAL
 * ============================================
 */
$(document).ready(function() {

    // ============================================
    // EDIT PRODUCT - Populate Form from Data Attributes
    // ============================================
    $(document).on('click', '.edit-product', function() {
        const data = $(this).data();

        // Set form action
        $('#editProductForm').attr('action', `/admin/products/${data.id}`);

        // Populate basic fields
        $('#edit_title').val(data.title || '');
        $('#edit_category_id').val(data.categoryId || '');
        $('#edit_seller_id').val(data.sellerId || '');
        $('#edit_product_type').val(data.productType || '');
        $('#edit_price').val(data.price || '');
        $('#edit_compare_price').val(data.comparePrice || '');
        $('#edit_status').val(data.status || '');
        $('#edit_delivery_type').val(data.deliveryType || '');
        $('#edit_short_description').val(data.shortDescription || '');
        $('#edit_description').val(data.description || '');
        $('#edit_external_url').val(data.externalUrl || '');
        $('#edit_download_limit').val(data.downloadLimit || '');

        // Checkboxes
        $('#edit_is_unlimited').prop('checked', data.isUnlimited == 1);
        $('#edit_is_featured').prop('checked', data.isFeatured == 1);
        $('#edit_is_approved').prop('checked', data.isApproved == 1);

        // Clear errors
        $('#editProductErrors').hide().empty();

        // Open modal
        const modal = new bootstrap.Modal(document.getElementById('editProductModal'));
        modal.show();
    });

    // ============================================
    // FIX: Properly cleanup modal on close
    // ============================================
    $('#editProductModal').on('hidden.bs.modal', function() {
        // Reset form fields
        $('#editProductForm')[0].reset();
        
        // Clear errors
        $('#editProductErrors').hide().empty();
        
        // Reset checkboxes
        $('#edit_is_unlimited').prop('checked', false);
        $('#edit_is_featured').prop('checked', false);
        $('#edit_is_approved').prop('checked', false);
        
        // Remove any leftover validation states
        $('#editProductForm .is-invalid').removeClass('is-invalid');
        $('#editProductForm .is-valid').removeClass('is-valid');
        
        // Reset form action
        $('#editProductForm').attr('action', '');
        
        // REMOVE BACKDROP MANUALLY (fix for stuck backdrop)
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        
    });

    // ============================================
    // Clear errors when modal is shown
    // ============================================
    $('#editProductModal').on('show.bs.modal', function() {
        $('#editProductErrors').hide().empty();
        $('#editProductForm .is-invalid').removeClass('is-invalid');
        $('#editProductForm .is-valid').removeClass('is-valid');
    });

});
</script>
@endpush