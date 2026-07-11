{{-- resources/views/admin/products/partials/delete-modal.blade.php --}}

<!-- ============================================ -->
<!-- DELETE PRODUCT MODAL -->
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

@push('scripts')
<script>
/**
 * ============================================
 * DELETE PRODUCT MODAL
 * ============================================
 */
$(document).ready(function() {

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
        const originalText = button.html();

        button.prop('disabled', true);
        button.html('<span class="spinner-border spinner-border-sm me-1"></span> Deleting...');

        $.ajax({
            url: '/admin/products/' + id,
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteProductModal'));
                if (modal) modal.hide();

                toastr.success(response.message);

                button.prop('disabled', false);
                button.html(originalText);

                setTimeout(() => window.location.reload(), 800);
            },
            error: function(xhr) {
                button.prop('disabled', false);
                button.html(originalText);

                const message = xhr.responseJSON?.message || 'Failed to delete product';
                toastr.error(message);

                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteProductModal'));
                if (modal) modal.hide();
            }
        });
    });

});
</script>
@endpush