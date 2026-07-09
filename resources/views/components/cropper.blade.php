<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

<div class="modal fade" id="globalCropperModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true"
    style="z-index: 9999;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0 bg-dark text-white" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header border-bottom border-secondary py-3" style="background: #1a1a24;">
                <h5 class="modal-title fw-bold text-white" id="globalCropperTitle">
                    <i class="fe fe-crop me-2 text-primary"></i>Adjust Layout Frame
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    id="globalCropperCloseBtn"></button>
            </div>
            <div class="modal-body p-4" style="background: #13131a;">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-9 text-center">
                        <div
                            style="width: 100%; max-height: 420px; background-color: #0f0f12; border-radius: 12px; overflow: hidden; position: relative; border: 1px solid #2d2d3d;">
                            <img id="globalCropperPreview"
                                style="display: block; max-width: 100%; height: auto; margin: 0 auto;">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="p-3 rounded-3 border border-secondary h-100 d-flex flex-column gap-2"
                            style="background: #1a1a24;">
                            <small class="text-muted d-block text-center text-uppercase fw-bold"
                                style="font-size: 11px; letter-spacing: 0.5px;">Controls</small>
                            <button id="g-rotate-btn" type="button" class="btn btn-outline-light w-100 btn-sm"><i
                                    class="fe fe-rotate-cw me-2"></i>Rotate 90°</button>
                            <button id="g-zoom-in-btn" type="button" class="btn btn-outline-light w-100 btn-sm"><i
                                    class="fe fe-zoom-in me-2"></i>Zoom In</button>
                            <button id="g-zoom-out-btn" type="button" class="btn btn-outline-light w-100 btn-sm"><i
                                    class="fe fe-zoom-out me-2"></i>Zoom Out</button>
                            <hr class="border-secondary my-2">
                            <button id="globalSaveBtn" type="button" class="btn btn-success w-100 fw-bold py-2">
                                <i class="fe fe-check me-2"></i>Apply Crop
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .cropper-container {
        width: 100% !important;
        margin: 0 auto;
    }

    .cropper-bg {
        background-image: none !important;
        background-color: #0f0f12 !important;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let cropperInstance = null;
        let activeInputFile = null;

        let currentConfig = { route: '', width: 400, height: 400, aspect: 1, quality: 0.8, previewSelector: '', previewType: 'image', tabName: 'logo' };

        const modalEl = document.getElementById('globalCropperModal');
        const bsModal = new bootstrap.Modal(modalEl);
        const imagePreview = document.getElementById('globalCropperPreview');

        document.addEventListener('change', function (e) {
            if (!e.target.classList.contains('secure-crop-upload')) return;

            const file = e.target.files[0];
            if (!file) return;

            activeInputFile = e.target;

            currentConfig.route = activeInputFile.getAttribute('data-route');
            currentConfig.width = parseInt(activeInputFile.getAttribute('data-width')) || 400;
            currentConfig.height = parseInt(activeInputFile.getAttribute('data-height')) || 400;
            currentConfig.aspect = parseFloat(activeInputFile.getAttribute('data-aspect')) || 1;
            currentConfig.quality = parseFloat(activeInputFile.getAttribute('data-quality')) || 0.7;
            currentConfig.previewSelector = activeInputFile.getAttribute('data-preview-element');
            currentConfig.previewType = activeInputFile.getAttribute('data-preview-type') || 'image';

            currentConfig.tabName = currentConfig.previewSelector.includes('banner') ? 'banner' : 'logo';

            document.getElementById('globalCropperTitle').innerHTML = `<i class="fe fe-crop me-2 text-primary"></i> ${activeInputFile.getAttribute('data-title') || 'Adjust Graphic'}`;

            const reader = new FileReader();
            reader.onload = function (ev) {
                if (cropperInstance) cropperInstance.destroy();
                imagePreview.src = ev.target.result;
                bsModal.show();
            };
            reader.readAsDataURL(file);
        });

        modalEl.addEventListener('shown.bs.modal', function () {
            cropperInstance = new Cropper(imagePreview, {
                aspectRatio: currentConfig.aspect,
                viewMode: 1,
                autoCropArea: 0.9,
                responsive: true,
                background: false
            });
        });

        modalEl.addEventListener('hidden.bs.modal', function () {
            if (cropperInstance) {
                cropperInstance.destroy();
                cropperInstance = null;
            }
            if (activeInputFile) activeInputFile.value = '';
        });

        document.getElementById('g-zoom-in-btn').onclick = () => cropperInstance?.zoom(0.1);
        document.getElementById('g-zoom-out-btn').onclick = () => cropperInstance?.zoom(-0.1);
        document.getElementById('g-rotate-btn').onclick = () => cropperInstance?.rotate(90);

        document.getElementById('globalSaveBtn').onclick = function () {
            if (!cropperInstance) return;

            const saveBtn = $(this);
            if (typeof window.showBtnLoader === 'function') {
                window.showBtnLoader(saveBtn);
            } else {
                saveBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Processing...');
            }

            // CRITICAL FIX: Limit max resolution strictly to ensure the base64 string remains extremely tiny
            let targetWidth = currentConfig.width;
            let targetHeight = currentConfig.height;

            if (currentConfig.tabName === 'banner') {
                targetWidth = 1000; // Scaled down to prevent massive memory payloads
                targetHeight = Math.round(1000 / currentConfig.aspect);
            } else {
                targetWidth = 300;
                targetHeight = 300;
            }

            const canvas = cropperInstance.getCroppedCanvas({
                width: targetWidth,
                height: targetHeight,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'medium' // Slightly faster/lighter buffer
            });

            // Use lower quality (0.5 - 0.6) for banner to forcefully restrict base64 text length
            const compressionFactor = currentConfig.tabName === 'banner' ? 0.5 : 0.7;
            const base64ImageString = canvas.toDataURL('image/jpeg', compressionFactor);

            // CRITICAL FIX: Send data as JSON payload instead of standard Form URL Encoded variables
            // This prevents your PHP from using standard POST buffering models that are breaking on your machine.
            $.ajax({
                url: currentConfig.route,
                type: 'POST',
                dataType: 'json',
                contentType: 'application/json', // Force JSON transport protocol
                data: JSON.stringify({
                    image_data: base64ImageString,
                    tab_name: currentConfig.tabName,
                    _method: 'PUT'
                }),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        const previewTarget = $(currentConfig.previewSelector);
                        if (previewTarget.length) {
                            const cleanUrl = response.path + '?v=' + new Date().getTime();
                            if (currentConfig.previewType === 'background') {
                                previewTarget.css('background-image', `url('${cleanUrl}')`);
                            } else {
                                previewTarget.attr('src', cleanUrl).css('opacity', '1');
                            }
                        }
                        if (typeof toastr !== 'undefined') toastr.success(response.message);
                        bsModal.hide();

                        const tableContainer = $('#data-table-container');
                        if (tableContainer.length) {
                            tableContainer.load(location.href + ' #data-table-container > *');
                        }
                    } else {
                        if (typeof toastr !== 'undefined') toastr.error(response.message);
                    }
                },
                error: function (xhr) {
                    console.error("[Global Crop Processing Failure]", xhr);
                    let errMsg = 'Upload failed due to server constraints.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errMsg = xhr.responseJSON.message;
                    }
                    if (typeof toastr !== 'undefined') toastr.error(errMsg);
                },
                complete: function () {
                    if (typeof window.resetBtnLoader === 'function') {
                        window.resetBtnLoader(saveBtn);
                    } else {
                        saveBtn.prop('disabled', false).html('<i class="fe fe-check me-2"></i>Apply Crop');
                    }
                }
            });
        };
    });
</script>