<style>

    /* Add to your custom.css or in the head */
.modal-xl {
    max-width: 90%;
}

.modal-body {
    max-height: calc(100vh - 150px);
    overflow-y: auto;
}

/* Custom scrollbar styling */
.modal-body::-webkit-scrollbar {
    width: 6px;
}

.modal-body::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.modal-body::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

</style>

<!-- View Product Modal -->
<div class="modal fade" id="viewProductModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" style="max-height: 90vh;">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fe fe-eye text-info me-2"></i>Product Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewProductContent" style="max-height: calc(90vh - 130px); overflow-y: auto; padding: 20px;">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading product details...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// ============================================
// VIEW PRODUCT - Populate Modal
// ============================================
$(document).on('click', '.view-product', function() {
    const data = $(this).data();
    
    // Remove any existing backdrop
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');

    let html = `
        <div class="row">
            <!-- Left Column: Basic Info -->
            <div class="col-md-6">
                <div class="card shadow-none border-0">
                    <div class="card-body p-0">
                        <h6 class="text-muted mb-3"><i class="fe fe-info me-2"></i>Basic Information</h6>

                        <table class="table table-bordered table-sm">
                            <tr>
                                <th width="130">ID</th>
                                <td><span class="badge bg-primary">${data.id}</span></td>
                            </tr>
                            <tr>
                                <th>Title</th>
                                <td><strong class="fs-5">${data.title}</strong></td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td><code>${data.slug || 'N/A'}</code></td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>${data.description || '<span class="text-muted">No description</span>'}</td>
                            </tr>
                            <tr>
                                <th>Short Description</th>
                                <td>${data.shortDescription || '<span class="text-muted">No short description</span>'}</td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td><span class="badge bg-info">${data.category || 'N/A'}</span></td>
                            </tr>
                            <tr>
                                <th>Product Type</th>
                                <td><span class="badge bg-secondary">${data.productType?.replace('_', ' ') || 'N/A'}</span></td>
                            </tr>
                            <tr>
                                <th>Seller</th>
                                <td>${data.seller || 'N/A'}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column: Pricing & Status -->
            <div class="col-md-6">
                <div class="card shadow-none border-0">
                    <div class="card-body p-0">
                        <h6 class="text-muted mb-3"><i class="fe fe-dollar-sign me-2"></i>Pricing & Status</h6>

                        <table class="table table-bordered table-sm">
                            <tr>
                                <th width="130">Price</th>
                                <td>
                                    ${data.comparePrice ? `<span class="text-muted text-decoration-line-through">$${parseFloat(data.comparePrice).toFixed(2)}</span><br>` : ''}
                                    <span class="fw-bold text-primary">$${parseFloat(data.price).toFixed(2)}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge ${getStatusBadge(data.status)}">${data.status ? data.status.charAt(0).toUpperCase() + data.status.slice(1) : 'N/A'}</span>
                                    ${data.isApproved ? '<span class="badge bg-success ms-1">Approved</span>' : ''}
                                    ${data.isFeatured ? '<span class="badge bg-warning ms-1"><i class="fe fe-star"></i> Featured</span>' : ''}
                                    ${data.rejectionReason ? `<br><small class="text-danger">Rejected: ${data.rejectionReason}</small>` : ''}
                                </td>
                            </tr>
                            <tr>
                                <th>Created</th>
                                <td>${data.createdAt || 'N/A'}</td>
                            </tr>
                            <tr>
                                <th>Delivery Type</th>
                                <td><span class="badge bg-info">${data.deliveryType?.replace('_', ' ') || 'N/A'}</span></td>
                            </tr>
                            <tr>
                                <th>Download Limit</th>
                                <td>${data.downloadLimit ? `${data.downloadLimit} downloads` : 'Unlimited'}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- ATTRIBUTES SECTION -->
        <!-- ============================================ -->
        <div id="attributesSection">
            <div class="text-center py-3">
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <span class="ms-2 text-muted">Loading attributes...</span>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- FILES SECTION -->
        <!-- ============================================ -->
        <div id="filesSection">
            <div class="text-center py-3">
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <span class="ms-2 text-muted">Loading files...</span>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- QUICK ACTIONS -->
        <!-- ============================================ -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex gap-2 justify-content-end border-top pt-3">
                    ${!data.isApproved ? `
                        <a href="/seller/products/${data.id}/edit" class="btn btn-outline-primary btn-sm">
                            <i class="fe fe-edit-2 me-1"></i> Edit Product
                        </a>
                    ` : `
                        <span class="badge bg-success p-2">
                            <i class="fe fe-check-circle me-1"></i> Approved - Cannot Edit
                        </span>
                    `}
                </div>
            </div>
        </div>
    `;

    $('#viewProductContent').html(html);

    // Load attributes and files after modal opens
    setTimeout(function() {
        loadProductAttributes(data.id);
        loadProductFiles(data.id);
    }, 300);
});

// ============================================
// LOAD ATTRIBUTES
// ============================================
function loadProductAttributes(productId) {
    $('#attributesSection').html(`
        <div class="text-center py-3">
            <div class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <span class="ms-2 text-muted">Loading attributes...</span>
        </div>
    `);

    $.ajax({
        url: `/seller/products/${productId}/attributes`,
        type: 'GET',
        success: function(response) {
            if (response.success && response.data && response.data.length > 0) {
                let html = `
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card shadow-none border">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fe fe-list me-2"></i>Product Attributes
                                        <span class="badge bg-primary ms-2">${response.data.length}</span>
                                    </h6>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-sm mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Key</th>
                                                    <th>Label</th>
                                                    <th>Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                ${response.data.map((attr, index) => `
                                                    <tr>
                                                        <td>${index + 1}</td>
                                                        <td><code>${attr.key}</code></td>
                                                        <td>${attr.label}</td>
                                                        <td>${attr.value}</td>
                                                    </tr>
                                                `).join('')}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                $('#attributesSection').html(html);
            } else {
                $('#attributesSection').html(`
                    <div class="text-center text-muted py-3">
                        <i class="fe fe-info me-1"></i> No attributes defined for this product
                    </div>
                `);
            }
        },
        error: function() {
            $('#attributesSection').html(`
                <div class="alert alert-danger m-0">
                    <i class="fe fe-alert-circle me-2"></i> Failed to load attributes
                </div>
            `);
        }
    });
}

// ============================================
// LOAD FILES
// ============================================
function loadProductFiles(productId) {
    $('#filesSection').html(`
        <div class="text-center py-3">
            <div class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <span class="ms-2 text-muted">Loading files...</span>
        </div>
    `);

    $.ajax({
        url: `/seller/products/${productId}/files`,
        type: 'GET',
        success: function(response) {
            if (response.success && response.data && response.data.length > 0) {
                let html = `
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card shadow-none border">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fe fe-file me-2"></i>Product Files
                                        <span class="badge bg-primary ms-2">${response.data.length}</span>
                                    </h6>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-sm mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>File Name</th>
                                                    <th>Type</th>
                                                    <th>Size</th>
                                                    <th>Downloads</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                ${response.data.map((file, index) => `
                                                    <tr>
                                                        <td>${index + 1}</td>
                                                        <td>${file.original_name}</td>
                                                        <td><span class="badge bg-secondary">${file.file_type}</span></td>
                                                        <td>${file.file_size}</td>
                                                        <td>${file.download_count || 0}</td>
                                                        <td>
                                                            <a href="/download/file/${file.id}" class="btn btn-sm btn-outline-success" target="_blank">
                                                                <i class="fe fe-download"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                `).join('')}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                $('#filesSection').html(html);
            } else {
                $('#filesSection').html(`
                    <div class="text-center text-muted py-3">
                        <i class="fe fe-info me-1"></i> No files uploaded for this product
                    </div>
                `);
            }
        },
        error: function() {
            $('#filesSection').html(`
                <div class="alert alert-danger m-0">
                    <i class="fe fe-alert-circle me-2"></i> Failed to load files
                </div>
            `);
        }
    });
}

// ============================================
// HELPER FUNCTION - Status Badge Color
// ============================================
function getStatusBadge(status) {
    const colors = {
        'draft': 'bg-secondary',
        'pending': 'bg-warning text-dark',
        'published': 'bg-success',
        'rejected': 'bg-danger',
        'archived': 'bg-dark'
    };
    return colors[status] || 'bg-secondary';
}

// ============================================
// REMOVE BACKDROP ON MODAL CLOSE
// ============================================
$('#viewProductModal').on('hidden.bs.modal', function() {
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
    $('body').css('padding-right', '');
});
</script>
@endpush