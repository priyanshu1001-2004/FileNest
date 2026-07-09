<script src="{{ asset('assets/js/jquery.min.js') }}"></script>


<!-- BOOTSTRAP JS -->
<script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- SPARKLINE JS -->
<script src="{{ asset('assets/js/jquery.sparkline.min.js') }}"></script>

<!-- STICKY JS -->
<script src="{{ asset('assets/js/sticky.js') }}"></script>

<!-- CHART CIRCLE JS -->
<script src="{{ asset('assets/js/circle-progress.min.js') }}"></script>

<!-- PEITY CHART JS -->
<script src="{{ asset('assets/plugins/peitychart/jquery.peity.min.js') }}"></script>
<script src="{{ asset('assets/plugins/peitychart/peitychart.init.js') }}"></script>

<!-- SIDEBAR JS -->
<script src="{{ asset('assets/plugins/sidebar/sidebar.js') }}"></script>

<!-- PERFECT SCROLLBAR JS -->
<script src="{{ asset('assets/plugins/p-scroll/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/plugins/p-scroll/pscroll.js') }}"></script>
<script src="{{ asset('assets/plugins/p-scroll/pscroll-1.js') }}"></script>

<!-- CHART JS -->
<script src="{{ asset('assets/plugins/chart/Chart.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/chart/rounded-barchart.js') }}"></script>
<script src="{{ asset('assets/plugins/chart/utils.js') }}"></script>

<!-- SELECT2 JS -->
<script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<!-- DATATABLE JS -->
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>

<!-- APEXCHART JS -->
<script src="{{ asset('assets/js/apexcharts.js') }}"></script>
<script src="{{ asset('assets/plugins/apexchart/irregular-data-series.js') }}"></script>

<!-- FLOT JS -->
<script src="{{ asset('assets/plugins/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('assets/plugins/flot/jquery.flot.fillbetween.js') }}"></script>
<script src="{{ asset('assets/plugins/flot/chart.flot.sampledata.js') }}"></script>
<script src="{{ asset('assets/plugins/flot/dashboard.sampledata.js') }}"></script>

<!-- VECTOR MAP JS -->
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

<!-- SIDEMENU JS -->
<script src="{{ asset('assets/plugins/sidemenu/sidemenu.js') }}"></script>

<!-- TYPEHEAD JS -->
<script src="{{ asset('assets/plugins/bootstrap5-typehead/autocomplete.js') }}"></script>
<script src="{{ asset('assets/js/typehead.js') }}"></script>

<!-- INDEX JS -->
<script src="{{ asset('assets/js/index1.js') }}"></script>

<!-- THEME COLOR JS -->
<script src="{{ asset('assets/js/themeColors.js') }}"></script>

<!-- CUSTOM JS -->
>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/switcher/js/switcher.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



<!-- ============================================ -->
<!-- MAIN APPLICATION SCRIPT -->
<!-- ============================================ -->
<script>
    'use strict';

    // ============================================
    // PREVENT GSAP ERRORS - Check if elements exist
    // ============================================
    // Override GSAP if it exists to prevent errors
    if (typeof gsap !== 'undefined') {
        const originalTo = gsap.to;
        const originalFrom = gsap.from;

        gsap.to = function (target, vars) {
            if (target && $(target).length === 0) {
                console.warn('GSAP target not found:', target);
                return;
            }
            return originalTo.call(this, target, vars);
        };

        gsap.from = function (target, vars) {
            if (target && $(target).length === 0) {
                console.warn('GSAP target not found:', target);
                return;
            }
            return originalFrom.call(this, target, vars);
        };
    }

    // ============================================
    // LOADER MANAGEMENT
    // ============================================
    (function () {
        function hideLoader() {
            const loader = document.getElementById('global-loader');
            if (loader && loader.style.display !== 'none') {
                loader.style.transition = 'opacity 0.3s ease';
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 300);
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', hideLoader);
        } else {
            hideLoader();
        }

        window.addEventListener('load', hideLoader);
        setTimeout(hideLoader, 2000);

        window.hideGlobalLoader = hideLoader;
    })();

    // ============================================
    // SIDEBAR TOGGLE
    // ============================================
    $(document).ready(function () {
        // Sidebar toggle
        $('.app-sidebar__toggle').on('click', function (e) {
            e.preventDefault();
            $('body').toggleClass('sidebar-open');
            $('.app-sidebar').toggleClass('toggled');

            const isOpen = $('body').hasClass('sidebar-open');
            localStorage.setItem('sidebarOpen', isOpen);
        });

        // Restore sidebar state
        const sidebarState = localStorage.getItem('sidebarOpen');
        if (sidebarState === 'true' && $(window).width() > 992) {
            $('body').addClass('sidebar-open');
        }

        // Close sidebar on overlay click
        $('.app-sidebar__overlay').on('click', function () {
            $('body').removeClass('sidebar-open');
            localStorage.setItem('sidebarOpen', false);
        });

        // Close sidebar on window resize
        $(window).on('resize', function () {
            if ($(window).width() > 992) {
                if (sidebarState === 'true') {
                    $('body').addClass('sidebar-open');
                }
            } else {
                $('body').removeClass('sidebar-open');
            }
        });
    });



    // ============================================
    // FULL SCREEN TOGGLE
    // ============================================
    $(document).ready(function () {
        $('.full-screen-link').on('click', function (e) {
            e.preventDefault();

            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
                $('.fullscreen-button').removeClass('fe-maximize').addClass('fe-minimize');
            } else {
                document.exitFullscreen();
                $('.fullscreen-button').removeClass('fe-minimize').addClass('fe-maximize');
            }
        });
    });

    // ============================================
    // TOASTR SETUP
    // ============================================
    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: true,
        progressBar: true,
        positionClass: "toast-top-right",
        preventDuplicates: true,
        showDuration: 300,
        hideDuration: 1000,
        timeOut: 5000,
        extendedTimeOut: 1000
    };

    // ============================================
    // AJAX SETUP
    // ============================================
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // ============================================
    // BUTTON LOADER
    // ============================================
    window.showBtnLoader = function (button) {
        button = button instanceof jQuery ? button[0] : button;
        if (!button || button.disabled) return;

        button.setAttribute('data-original-content', button.innerHTML);
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Loading...';
    };

    window.resetBtnLoader = function (button) {
        button = button instanceof jQuery ? button[0] : button;
        if (!button) return;

        let originalContent = button.getAttribute('data-original-content');
        if (originalContent) {
            button.innerHTML = originalContent;
        }
        button.disabled = false;
    };

    window.validateForm = function (form) {

        let isValid = true;

        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.select2-invalid').removeClass('select2-invalid');
        form.find('.select2-selection').removeClass('is-invalid');
        form.find('.dynamic-error').remove();

        form.find('input, select, textarea').each(function () {

            let input = $(this);
            let value = $.trim(input.val() || '');
            let error = '';

            // Native HTML validation

            if (input.prop('required') && !value)
                error = 'This field is required';

            if (!error && input.attr('type') === 'email' && value &&
                !/^\S+@\S+\.\S+$/.test(value))
                error = 'Invalid email format';

            if (!error && input.attr('minlength') &&
                value.length < +input.attr('minlength'))
                error = `Minimum ${input.attr('minlength')} characters required`;

            if (!error && input.attr('maxlength') &&
                value.length > +input.attr('maxlength'))
                error = `Maximum ${input.attr('maxlength')} characters allowed`;

            if (!error && input.attr('type') === 'number' && value) {

                let min = input.attr('min');
                let max = input.attr('max');

                if (min && +value < +min)
                    error = `Minimum value is ${min}`;

                if (!error && max && +value > +max)
                    error = `Maximum value is ${max}`;
            }

            // Custom Rules

            if (!error && input.data('rules')) {

                let rules = input.data('rules').split('|');

                for (let rule of rules) {

                    let [name, param] = rule.split(':');

                    switch (name) {

                        case 'same':
                            let target = form.find(`[name="${param}"]`).val();
                            if (value !== target)
                                error = `Must match ${param.replaceAll('_', ' ')}`;
                            break;

                        case 'numeric':
                            if (value && !/^\d+$/.test(value))
                                error = 'Only numbers allowed';
                            break;

                        case 'alpha':
                            if (value && !/^[a-zA-Z\s]+$/.test(value))
                                error = 'Only letters allowed';
                            break;

                        case 'alpha_num':
                            if (value && !/^[a-zA-Z0-9]+$/.test(value))
                                error = 'Only letters and numbers allowed';
                            break;

                        case 'phone':
                            if (value && !/^[0-9]{10}$/.test(value))
                                error = 'Invalid phone number';
                            break;

                        case 'url':
                            try {
                                if (value) new URL(value);
                            } catch {
                                error = 'Invalid URL';
                            }
                            break;
                    }

                    if (error) break;
                }
            }

            if (error) {
                isValid = false;
                input.addClass('is-invalid');

                if (input.hasClass('select2-hidden-accessible')) {
                    input.next('.select2-container').addClass('select2-invalid');
                    input.next('.select2-container').find('.select2-selection').addClass('is-invalid');
                }

                let errorHtml = `
                 <div class="invalid-feedback dynamic-error d-block">
                    ${error}
                    </div>
                 `;

                if (input.hasClass('select2-hidden-accessible')) {
                    input.next('.select2-container').after(errorHtml);
                } else if (input.closest('.input-group').length) {
                    input.closest('.input-group').after(errorHtml);
                } else {
                    input.after(errorHtml);
                }

            }
        });

        return isValid;
    };

    // ===============================
    // Backend Laravel Validation
    // ===============================
    function showValidationErrors(form, errors) {
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.select2-invalid').removeClass('select2-invalid');
        form.find('.select2-selection').removeClass('is-invalid');
        form.find('.dynamic-error').remove();
        let messages = [];
        $.each(errors, function (key, value) {
            let message = value[0];
            let input;
            // Support array validation
            if (key.includes('.')) {
                let parts = key.split('.');
                let field = parts[0];
                let index = parseInt(parts[1]);
                input = form.find(`[name="${field}[]"]`).eq(index);
            } else {
                input = form.find(`[name="${key}"]`);
            }

            if (input.length) {
                input.addClass('is-invalid');

                if (input.hasClass('select2-hidden-accessible')) {
                    input.next('.select2-container').addClass('select2-invalid');
                    input.next('.select2-container').find('.select2-selection').addClass('is-invalid');
                }

                let errorHtml = `
                <div class="invalid-feedback dynamic-error d-block">
                   ${message}
                   </div>
                `;

                if (input.hasClass('select2-hidden-accessible')) {
                    input.next('.select2-container').after(errorHtml);
                } else if (input.closest('.input-group').length) {
                    input.closest('.input-group').after(errorHtml);
                } else {
                    input.after(errorHtml);
                }
            }

            messages.push(message);
        });

        toastr.error(messages.join('<br>'));
    }


    // ===============================
    // Global AJAX Form Submit
    // ===============================
    $(document).on('submit', '.ajax-form', function (e) {

        e.preventDefault();

        let form = $(this);
        let button = form.find('[type="submit"]');

        // Frontend Validation
        if (!validateForm(form)) {
            form.find('.is-invalid:first').focus();
            toastr.warning(
                'Please correct the highlighted errors.'
            );
            return;
        }

        showBtnLoader(button[0]);
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method') || 'POST',
            data: new FormData(form[0]),
            contentType: false,
            processData: false,
            success: function (response) {
                let modal = form.data('modal');
                if (modal) {
                    $(modal).modal('hide');
                }

                if (form.data('reset') == 1) {
                    form[0].reset();
                }

                resetBtnLoader(button[0]);

                toastr.success(response.message ?? 'Saved successfully');

                // Full page reload
                // if (form.data('reload') == 1) {
                //     location.reload();
                //     return;
                // }

                // Table refresh
                $('#table-container').load(location.href + ' #table-container > *', function (responseText, textStatus, xhr) {
                    if (textStatus === "error") {
                        console.error("Table refresh failed: " + xhr.status + " " + xhr.statusText);
                    }
                });
            },

            error: function (xhr) {
                resetBtnLoader(button[0]);
                if (xhr.status === 422) {
                    showValidationErrors(
                        form,
                        xhr.responseJSON.errors
                    );

                    return;
                }

                toastr.error(xhr.responseJSON?.message ?? 'Something went wrong.');
            }
        });
    });

    //global clear button 
    $('#clearaddBtn').click(() => $('#CreateForm')[0].reset());

    // Global delete handler - Add this once in your main JS file
    $(document).on('click', '.delete-btn', function (e) {
        let form = $(this).closest('form');
        if (form.length && confirm('Are you sure?')) {
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function (res) {
                    toastr.success(res.message);
                    $('#table-container').load(location.href + ' #table-container > *');
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Error!');
                }
            });
        }
        return false;
    });


    // ============================================
    // DOCUMENT READY - CLEAN VERSION
    // ============================================
    $(document).ready(function () {
        // 1. Initialize Select2
        if ($.fn.select2) {
            $('.select2').select2({ width: '100%' });
        }

        // 2. GLOBAL SUMMERNOTE INITIALIZATION
        if ($.fn.summernote) {
            $('.summernote').summernote({
                height: 150,
                minHeight: 150,
                maxHeight: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
        }

        // 3. GLOBAL TAGIFY INITIALIZATION - ONLY ONCE ON PAGE LOAD
        document.querySelectorAll('.tagify-input').forEach(function (el) {
            if (!el.hasAttribute('data-tagify-initialized')) {
                new Tagify(el, {
                    delimiters: ",",
                    keepInvalidTags: false,
                    originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
                });
                el.setAttribute('data-tagify-initialized', 'true');
            }
        });
    });

    // 4. Sync Tagify before form submission
    $(document).on('submit', '.ajax-form', function (e) {
        $(this).find('.tagify-input').each(function () {
            if (this.tagify) {
                let tags = this.tagify.value.map(item => item.value).join(',');
                this.value = tags;
            }
        });
    });

    $(document).on('hidden.bs.modal', '.modal', function () {
        // Reset form inside modal
        let form = $(this).find('form');
        if (form.length) {
            form[0].reset();

            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.dynamic-error').remove();

            if (form.find('.summernote').length && $.fn.summernote) {
                form.find('.summernote').summernote('code', '');
            }

            form.find('.tagify-input').each(function () {
                if (this.tagify) {
                    this.tagify.removeAllTags();
                }
            });

            form.find('.select2').each(function () {
                $(this).val(null).trigger('change');
            });
        }
    });


    //global toggle button 
    $(document).on('change', '.globalStatusToggle', function () {

        let checkbox = $(this);
        let url = "{{url('toggle-status')}}";
        let id = checkbox.data('id');
        let model = checkbox.data('model');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                model: model,
                id: id,
            },
            success: function (res) {

                toastr.success(res.message ?? 'Status updated successfully');

                // let badge = checkbox.closest('tr').find('td:last span');

                // if (res.status) {
                //     badge.removeClass('badge-danger')
                //         .addClass('badge-success')
                //         .text('Active');
                // } else {
                //     badge.removeClass('badge-success')
                //         .addClass('badge-danger')
                //         .text('Inactive');
                // }
                $('#table-container').load(location.href + ' #table-container > *');

            },
            error: function () {
                toastr.error('Failed to update status');

                // rollback
                checkbox.prop('checked', !checkbox.prop('checked'));
            }
        });
    });

    /* ==========================================================
   GLOBAL IMAGE CROPPER
   ========================================================== */

    const ImageCropper = {

        cropper: null,
        currentInput: null,

        presets: {

            profile: {
                aspectRatio: 1,
                width: 400,
                height: 400
            },

            banner: {
                aspectRatio: 3,
                width: 1500,
                height: 500
            },

            thumbnail: {
                aspectRatio: 16 / 9,
                width: 1200,
                height: 675
            },

            logo: {
                aspectRatio: 1,
                width: 500,
                height: 500
            }

        },

        init: function () {

            const self = this;

            $(document).on("change", ".image-cropper", function (e) {

                let input = this;

                if (!input.files.length)
                    return;

                self.currentInput = input;

                let presetName = $(input).data("preset");

                let config = self.presets[presetName];

                if (!config) {

                    alert("Invalid crop preset.");

                    return;

                }

                let reader = new FileReader();

                reader.onload = function (event) {

                    $("#cropperImage").attr("src", event.target.result);

                    let modal = new bootstrap.Modal(document.getElementById("imageCropperModal"));

                    modal.show();

                    $("#imageCropperModal").off("shown.bs.modal").on("shown.bs.modal", function () {

                        if (self.cropper)
                            self.cropper.destroy();

                        self.cropper = new Cropper(document.getElementById("cropperImage"), {

                            aspectRatio: config.aspectRatio,

                            viewMode: 1,

                            autoCropArea: 1,

                            responsive: true,

                            movable: true,

                            zoomable: true,

                            scalable: false,

                            rotatable: false

                        });

                    });

                };

                reader.readAsDataURL(input.files[0]);

            });

            $("#cropImageBtn").on("click", function () {

                self.crop();

            });

        },

        crop: function () {

            let input = $(this.currentInput);

            let preset = this.presets[input.data("preset")];

            let preview = input.data("preview");

            if (!this.cropper)
                return;

            let canvas = this.cropper.getCroppedCanvas({

                width: preset.width,

                height: preset.height

            });

            let base64 = canvas.toDataURL("image/jpeg", 0.9);

            if (preview) {

                $(preview).attr("src", base64);

            }

            canvas.toBlob(function (blob) {

                let file = new File([blob], "image.jpg", {

                    type: "image/jpeg"

                });

                let dt = new DataTransfer();

                dt.items.add(file);

                input[0].files = dt.files;

            });

            bootstrap.Modal.getInstance(document.getElementById("imageCropperModal")).hide();

            this.cropper.destroy();

            this.cropper = null;

        }

    };

    $(function () {

        ImageCropper.init();

    });


</script>