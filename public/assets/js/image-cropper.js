/**
 * ==========================================================
 * Global Image Cropper
 * ==========================================================
 */

const ImageCropper = {

    /**
     * Cropper Instance
     */
    cropper: null,

    /**
     * Configuration
     */
    config: {

        inputSelector: '.image-cropper',

        modalId: 'imageCropperModal',

        imageId: 'cropperImage'

    },

    /**
     * Initialize
     */
    init: function () {

        console.log('✅ Image Cropper Initialized');

        this.bindEvents();

    },

    /**
     * Register Events
     */
    bindEvents: function () {

        const self = this;

        $(document).on('change', this.config.inputSelector, function () {

            self.handleFileSelect(this);

        });

    },

    /**
     * Handle Image Selection
     */
    handleFileSelect: function (input) {

        if (!input.files || !input.files.length) {

            return;

        }

        const file = input.files[0];

        this.readFile(file);

    },

    /**
     * Read Image
     */
    readFile: function (file) {

        const self = this;

        const reader = new FileReader();

        reader.onload = function (e) {

            self.openModal(e.target.result);

        };

        reader.readAsDataURL(file);

    },

    /**
     * Open Modal
     */
    openModal: function (imageUrl) {

        const self = this;

        $('#' + this.config.imageId).attr('src', imageUrl);

        const modalElement = document.getElementById(this.config.modalId);

        const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

        /**
         * Remove old cropper if exists
         */
        this.destroyCropper();

        /**
         * Wait until modal is visible
         */
        modalElement.addEventListener('shown.bs.modal', function () {

            self.initializeCropper();

        }, { once: true });

        modal.show();

    },

    /**
     * Initialize Cropper
     */
    initializeCropper: function () {

        const image = document.getElementById(this.config.imageId);

        this.cropper = new Cropper(image, {

            viewMode: 1,

            dragMode: 'move',

            autoCropArea: 1,

            responsive: true,

            restore: false,

            guides: true,

            center: true,

            highlight: true,

            cropBoxMovable: true,

            cropBoxResizable: true,

            toggleDragModeOnDblclick: false

        });

        console.log('✅ Cropper Initialized');

    },

    /**
     * Destroy Existing Cropper
     */
    destroyCropper: function () {

        if (this.cropper) {

            this.cropper.destroy();

            this.cropper = null;

        }

    }

};


/**
 * Initialize
 */
$(function () {

    ImageCropper.init();

});