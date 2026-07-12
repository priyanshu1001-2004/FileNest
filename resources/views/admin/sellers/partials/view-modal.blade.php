{{-- resources/views/admin/sellers/partials/view-modal.blade.php --}}

<!-- View Seller Modal -->
<div class="modal fade" id="viewSellerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fe fe-user text-info me-2"></i>Seller Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">x</button>
            </div>
            <div class="modal-body" id="viewSellerContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading seller details...</p>
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
// VIEW SELLER - Populate Modal
// ============================================
$(document).on('click', '.view-seller', function() {
    const data = $(this).data();
    
    // Remove any existing backdrop
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');

    // Safe access with null checks
    const store = data.store || 'N/A';
    const storeType = data.storeType || 'Individual';
    const company = data.company || 'N/A';
    const country = data.country || 'N/A';
    const state = data.state || 'N/A';
    const city = data.city || 'N/A';
    const website = data.website || 'N/A';
    const supportEmail = data.supportEmail || 'N/A';
    const rating = parseFloat(data.rating || 0).toFixed(1);
    const totalProducts = data.totalProducts || 0;
    const totalSales = data.totalSales || 0;
    const isVerified = data.isVerified == 1;
    const isSuspended = data.isSuspended == 1;
    const isFeatured = data.isFeatured == 1;
    const suspensionReason = data.suspensionReason || '';
    const avatar = data.avatar || null;
    const name = data.name || 'Unknown';
    const email = data.email || '';
    const phone = data.phone || '';
    const createdAt = data.createdAt || 'N/A';

    let html = `
        <div class="row">
            <div class="col-md-4 text-center">
                ${avatar ? 
                    `<img src="/storage/${avatar}" alt="${name}" class="rounded-circle" width="120" height="120">` :
                    `<div class="avatar bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px; font-size: 48px;">
                        ${name.charAt(0).toUpperCase()}
                    </div>`
                }
                <h4 class="mt-3">${name}</h4>
                <p class="text-muted">${email}</p>
                ${phone ? `<p class="text-muted"><i class="fe fe-phone me-1"></i> ${phone}</p>` : ''}
                ${website !== 'N/A' ? `<p class="text-muted"><i class="fe fe-globe me-1"></i> <a href="${website}" target="_blank">${website}</a></p>` : ''}
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Store</h6>
                                <p class="fw-bold">${store}</p>
                                <small class="text-muted">Type: ${storeType}</small>
                                ${company !== 'N/A' ? `<br><small class="text-muted">Company: ${company}</small>` : ''}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Location</h6>
                                <p class="fw-bold">${city !== 'N/A' ? city : '—'}</p>
                                <small class="text-muted">${state !== 'N/A' ? state : ''} ${country !== 'N/A' ? country : ''}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Products</h6>
                                <p class="fw-bold">${totalProducts}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Sales</h6>
                                <p class="fw-bold">${totalSales}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Rating</h6>
                                <p class="fw-bold">${rating} ★</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Status</h6>
                                ${isSuspended ? 
                                    `<span class="badge bg-danger">Suspended</span>` :
                                    `<span class="badge bg-success">Active</span>`
                                }
                                ${isVerified ? 
                                    `<span class="badge bg-success ms-1">Verified</span>` :
                                    `<span class="badge bg-warning ms-1">Pending</span>`
                                }
                                ${isFeatured ? 
                                    `<span class="badge bg-warning ms-1"><i class="fe fe-star"></i> Featured</span>` : ''
                                }
                                ${isSuspended && suspensionReason ? 
                                    `<br><small class="text-danger mt-1 d-block">Reason: ${suspensionReason}</small>` : ''
                                }
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Support</h6>
                                ${supportEmail !== 'N/A' ? 
                                    `<p class="fw-bold mb-0"><i class="fe fe-mail me-1"></i> ${supportEmail}</p>` :
                                    `<p class="text-muted">No support email</p>`
                                }
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6>Joined</h6>
                                <p class="fw-bold mb-0">${createdAt}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    $('#viewSellerContent').html(html);
});

// Remove backdrop when modal closes
$('#viewSellerModal').on('hidden.bs.modal', function() {
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
});
</script>
@endpush