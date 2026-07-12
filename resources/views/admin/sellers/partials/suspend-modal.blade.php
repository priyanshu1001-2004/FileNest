{{-- resources/views/admin/sellers/partials/suspend-modal.blade.php --}}

<!-- Suspend Seller Modal -->
<div class="modal fade" id="suspendSellerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    <i class="fe fe-alert-triangle me-2"></i>Suspend Seller
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fe fe-slash fs-1 text-danger"></i>
                </div>
                <p class="text-center">Are you sure you want to suspend this seller?</p>
                <div class="alert alert-warning text-center">
                    <strong>Seller:</strong> <span id="suspendSellerName"></span>
                </div>
                <div class="mb-3">
                    <label class="form-label">Suspension Reason <span class="text-danger">*</span></label>
                    <textarea id="suspensionReason" class="form-control" rows="3" 
                              placeholder="Why is this seller being suspended?" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Suspended Until (Optional)</label>
                    <input type="datetime-local" id="suspendedUntil" class="form-control">
                </div>
                <input type="hidden" id="suspendSellerId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmSuspend">
                    <i class="fe fe-slash me-1"></i> Suspend Seller
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// ============================================
// SUSPEND SELLER - Open Modal
// ============================================
$(document).on('click', '.suspend-seller', function() {
    const id = $(this).data('id');
    const name = $(this).data('name');

    $('#suspendSellerId').val(id);
    $('#suspendSellerName').text(name);
    $('#suspensionReason').val('');
    $('#suspendedUntil').val('');
    
    // Remove any existing backdrop
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
});

// ============================================
// CONFIRM SUSPEND
// ============================================
$(document).on('click', '#confirmSuspend', function() {
    const id = $('#suspendSellerId').val();
    const reason = $('#suspensionReason').val();
    const until = $('#suspendedUntil').val();

    if (!reason) {
        toastr.error('Please provide a suspension reason');
        return;
    }

    $.ajax({
        url: `/admin/sellers/${id}/suspend`,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            suspension_reason: reason,
            suspended_until: until || null
        },
        success: function(res) {
            toastr.success(res.message);
            $('#suspendSellerModal').modal('hide');
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            setTimeout(() => window.location.reload(), 800);
        },
        error: function(xhr) {
            toastr.error(xhr.responseJSON?.message || 'Failed to suspend seller');
        }
    });
});

// Remove backdrop when modal closes
$('#suspendSellerModal').on('hidden.bs.modal', function() {
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
});
</script>
@endpush