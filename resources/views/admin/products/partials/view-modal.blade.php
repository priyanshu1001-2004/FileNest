{{-- resources/views/admin/products/partials/view-modal.blade.php --}}

<!-- ============================================ -->
<!-- VIEW PRODUCT MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="viewProductModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fe fe-eye text-info me-2"></i>Product Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">x</button>
            </div>
            <div class="modal-body" id="viewProductContent">
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
/**
 * ============================================
 * VIEW PRODUCT MODAL
 * ============================================
 */
$(document).ready(function() {

    // ============================================
    // VIEW PRODUCT - Build HTML from Data Attributes
    // ============================================
    $(document).on('click', '.view-product', function() {
        const data = $(this).data();
        const html = buildViewHtml(data);
        $('#viewProductContent').html(html);
    });

    // ============================================
    // HELPER: Build View HTML
    // ============================================
    function buildViewHtml(data) {
        return `
            <div class="row">
               
                <div class="col-md-12">
                    <table class="table table-bordered table-sm">
                        <tr><th width="150">ID</th><td><span class="badge bg-primary">${data.id}</span></td></tr>
                        <tr><th>Title</th><td><strong>${data.title}</strong></td></tr>
                        <tr><th>Slug</th><td><code>${data.slug || 'N/A'}</code></td></tr>
                        <tr><th>Category</th><td><span class="badge bg-info">${data.category || 'N/A'}</span></td></tr>
                        <tr><th>Seller</th><td>${data.seller || 'N/A'}</td></tr>
                        <tr><th>Price</th><td>
                            ${data.comparePrice ? `<span class="text-muted text-decoration-line-through">$${parseFloat(data.comparePrice).toFixed(2)}</span><br>` : ''}
                            <span class="fw-bold text-primary">$${parseFloat(data.price).toFixed(2)}</span>
                        </td></tr>
                        <tr><th>Product Type</th><td><span class="badge bg-secondary">${data.productType?.replace('_', ' ') || 'N/A'}</span></td></tr>
                        <tr><th>Status</th><td>
                            <span class="badge ${getStatusBadge(data.status)}">${data.status ? data.status.charAt(0).toUpperCase() + data.status.slice(1) : 'N/A'}</span>
                            ${data.isApproved ? '<span class="badge bg-success ms-1">Approved</span>' : ''}
                            ${data.isFeatured ? '<span class="badge bg-warning ms-1"><i class="fe fe-star"></i> Featured</span>' : ''}
                        </td></tr>
                        <tr><th>Created</th><td>${data.createdAt || 'N/A'}</td></tr>
                    </table>
                </div>
            </div>
            ${data.description ? `
            <div class="row mt-3">
                <div class="col-12">
                    <h6 class="text-muted">Description</h6>
                    <p>${data.description}</p>
                </div>
            </div>` : ''}
        `;
    }

    // ============================================
    // HELPER: Status Badge Color
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

});
</script>
@endpush