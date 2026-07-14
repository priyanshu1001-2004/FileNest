{{-- resources/views/admin/categories/index.blade.php --}}
@extends('layouts.master')

@section('title', 'Admin | Categories')

@section('content')

<div class="mt-5" id="data-table-container">
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <!-- Card Header -->
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h3 class="card-title mb-1 fw-bold">
                            <i class="fe fe-folder me-2 text-primary"></i>Categories
                        </h3>
                        <p class="text-muted mb-0 fs-12">Manage your product categories</p>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#createCategoryModal">
                            <i class="fe fe-plus me-1"></i> Add Category
                        </button>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body">
                    <!-- Statistics -->
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6 col-md-3">
                            <div class="card bg-primary img-card border-0 rounded-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="text-white">
                                            <h2 class="mb-0 number-font fw-bold">{{ $totalCategories ?? 0 }}</h2>
                                            <p class="text-white-50 mb-0 fs-13">Total Categories</p>
                                        </div>
                                        <div class="ms-auto text-white-50">
                                            <i class="fe fe-folder fs-30"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-3">
                            <div class="card bg-info img-card border-0 rounded-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="text-white">
                                            <h2 class="mb-0 number-font fw-bold">{{ $rootCategories ?? 0 }}</h2>
                                            <p class="text-white-50 mb-0 fs-13">Root Categories</p>
                                        </div>
                                        <div class="ms-auto text-white-50">
                                            <i class="fe fe-layers fs-30"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-3">
                            <div class="card bg-warning img-card border-0 rounded-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="text-white">
                                            <h2 class="mb-0 number-font fw-bold">{{ $subCategories ?? 0 }}</h2>
                                            <p class="text-white-50 mb-0 fs-13">Sub Categories</p>
                                        </div>
                                        <div class="ms-auto text-white-50">
                                            <i class="fe fe-folder-plus fs-30"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-3">
                            <div class="card bg-success img-card border-0 rounded-4">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="text-white">
                                            <h2 class="mb-0 number-font fw-bold">{{ $activeCategories ?? 0 }}</h2>
                                            <p class="text-white-50 mb-0 fs-13">Active Categories</p>
                                        </div>
                                        <div class="ms-auto text-white-50">
                                            <i class="fe fe-check-circle fs-30"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Section -->
                    <form id="filterForm" method="GET" action="{{ route('admin.categories.index') }}" class="mb-4">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold fs-12 mb-1">Search</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fe fe-search"></i></span>
                                    <input type="text" name="search" id="searchInput" class="form-control"
                                        placeholder="Search categories..." value="{{ request('search') }}">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label fw-semibold fs-12 mb-1">Status</label>
                                <select name="status" id="statusFilter" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status')=='inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold fs-12 mb-1">Parent Category</label>
                                <select name="parent_id" id="parentFilter" class="form-select">
                                    <option value="">All Categories</option>
                                    <option value="null" {{ request('parent_id')=='null' ? 'selected' : '' }}>Root Categories</option>
                                    @foreach($categoryOptions ?? [] as $id => $name)
                                    <option value="{{ $id }}" {{ request('parent_id')==$id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label fw-semibold fs-12 mb-1">Created</label>
                                <select name="date_filter" id="dateFilter" class="form-select">
                                    <option value="">All Time</option>
                                    <option value="today" {{ request('date_filter')=='today' ? 'selected' : '' }}>Today</option>
                                    <option value="week" {{ request('date_filter')=='week' ? 'selected' : '' }}>This Week</option>
                                    <option value="month" {{ request('date_filter')=='month' ? 'selected' : '' }}>This Month</option>
                                    <option value="year" {{ request('date_filter')=='year' ? 'selected' : '' }}>This Year</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fe fe-search me-1"></i> Search
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="resetFilters"
                                        title="Reset Filters">
                                        <i class="fe fe-refresh-ccw"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive" id="table-container">
                        <table class="table table-hover table-bordered text-nowrap border-bottom">
                            <thead class="">
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Slug</th>
                                    <th>Parent</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th width="120">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                <tr>
                                    <td>{{ $categories->firstItem() + $loop->index }}</td>
                                    <td>
                                        <span class="fw-semibold">{{ $category->name }}</span>
                                        @if($category->children->count() > 0)
                                        <span class="badge bg-info ms-1">{{ $category->children->count() }} sub</span>
                                        @endif
                                    </td>
                                    <td><code class="fs-12">{{ $category->slug }}</code></td>
                                    <td>{{ $category->parent->name ?? '—' }}</td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <label class="custom-switch form-switch">
                                                <input type="checkbox" name="status_{{ $category->id }}"
                                                    class="custom-switch-input statusToggle globalStatusToggle"
                                                    data-id="{{ $category->id }}" data-model="Category"
                                                    {{ $category->status == 1 ? 'checked' : '' }}>
                                                <span class="custom-switch-indicator"></span>
                                                <span class="custom-switch-description badge p-0 text-dark ms-2">
                                                    {{ $category->status == 1 ? 'Active' : 'Inactive' }}
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fs-12">{{ $category->created_at->format('d M Y') }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-outline-info view-category"
                                                data-id="{{ $category->id }}" data-bs-toggle="modal"
                                                data-bs-target="#viewCategoryModal">
                                                <i class="fe fe-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-primary edit-category"
                                                data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                                                data-slug="{{ $category->slug }}"
                                                data-description="{{ $category->description }}"
                                                data-parent="{{ $category->parent_id }}"
                                                data-status="{{ $category->status ? 1 : 0 }}"
                                                data-schema="{{ json_encode($category->field_schema ?? []) }}">
                                                <i class="fe fe-edit-2"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger delete-category"
                                                data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                                                <i class="fe fe-trash-2"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="fe fe-folder-off fs-1 text-muted d-block mb-3"></i>
                                        <h5 class="text-muted">No Categories Found</h5>
                                        <button type="button" class="btn btn-primary btn-sm mt-2" data-bs-toggle="modal"
                                            data-bs-target="#createCategoryModal">
                                            <i class="fe fe-plus me-1"></i> Create Category
                                        </button>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex flex-wrap align-items-center justify-content-between mt-4">
                        <div>
                            <span class="text-muted fs-13">
                                Showing {{ $categories->firstItem() ?? 0 }} to {{ $categories->lastItem() ?? 0 }}
                                of {{ $categories->total() }} categories
                            </span>
                        </div>
                        <div>
                            {{ $categories->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- CREATE CATEGORY MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="createCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fe fe-plus-circle text-primary me-2"></i>Add New Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createCategoryForm" class="ajax-form" method="POST" action="{{ route('admin.categories.store') }}"
                data-modal="#createCategoryModal" data-reload="1">
                @csrf
                <div class="modal-body">
                    <div id="createCategoryErrors" class="alert alert-danger" style="display: none;"></div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Enter category name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control" placeholder="Auto-generated if empty">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2"
                            placeholder="Optional category description"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Parent Category</label>
                            <select name="parent_id" class="form-select">
                                <option value="">None (Root Category)</option>
                                @foreach($categoryOptions ?? [] as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Field Schema Builder -->
                    <hr>
                    <h6 class="text-primary mb-3">
                        <i class="fe fe-list me-2"></i>Product Attributes (Field Schema)
                        <small class="text-muted fs-12">Define attributes for products in this category</small>
                    </h6>

                    <div id="fieldSchemaContainer">
                        <div class="text-center text-muted py-3" id="noFieldsMessage">
                            <i class="fe fe-info me-1"></i> No attributes defined. Click "Add Field" to create.
                        </div>
                    </div>

                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="addFieldBtn">
                        <i class="fe fe-plus me-1"></i> Add Field
                    </button>

                    <input type="hidden" name="field_schema" id="fieldSchemaInput" value="">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fe fe-save me-1"></i> Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- EDIT CATEGORY MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fe fe-edit-2 text-primary me-2"></i>Edit Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editCategoryForm" class="ajax-form" method="POST" action="" data-modal="#editCategoryModal"
                data-reload="1">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div id="editCategoryErrors" class="alert alert-danger" style="display: none;"></div>

                    <div class="row">
                        <!-- LEFT COLUMN: Basic Info -->
                        <div class="col-md-5">
                            <h6 class="text-muted mb-3"><i class="fe fe-info me-2"></i>Basic Information</h6>

                            <div class="mb-3">
                                <label class="form-label">Category Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="edit_name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" name="slug" id="edit_slug" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Parent Category</label>
                                    <select name="parent_id" id="edit_parent_id" class="form-select">
                                        <option value="">None (Root Category)</option>
                                        @foreach($categoryOptions ?? [] as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" id="edit_status" class="form-select">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN: Field Schema -->
                        <div class="col-md-7">
                            <h6 class="text-muted mb-3">
                                <i class="fe fe-list me-2"></i>Product Attributes (Field Schema)
                                <small class="text-muted fs-12 d-block">Define attributes for products in this category</small>
                            </h6>

                            <div id="editFieldSchemaContainer">
                                <div class="text-center text-muted py-3" id="editNoFieldsMessage">
                                    <i class="fe fe-info me-1"></i> No attributes defined. Click "Add Field" to create.
                                </div>
                            </div>

                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="editAddFieldBtn">
                                <i class="fe fe-plus me-1"></i> Add Field
                            </button>

                            <input type="hidden" name="field_schema" id="editFieldSchemaInput" value="">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fe fe-save me-1"></i> Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- VIEW CATEGORY MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="viewCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fe fe-eye text-info me-2"></i>Category Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewCategoryContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- DELETE CONFIRMATION MODAL -->
<!-- ============================================ -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    <i class="fe fe-alert-triangle me-2"></i>Delete Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fe fe-folder-off fs-1 text-danger"></i>
                </div>
                <p class="text-center">Are you sure you want to delete this category?</p>
                <div class="alert alert-warning text-center">
                    <strong>Category:</strong> <span id="deleteCategoryName"></span>
                </div>
                <p class="text-danger text-center small">
                    <i class="fe fe-info me-1"></i> This action cannot be undone.
                </p>
                <input type="hidden" id="deleteCategoryId">
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

@endsection

@push('scripts')
<script>
/**
 * ============================================
 * CATEGORY MANAGEMENT - COMPLETE
 * ============================================
 */

(function($) {
    'use strict';

    $(document).ready(function() {

        // ============================================
        // FIELD SCHEMA BUILDER
        // ============================================
        let fieldIndex = 0;

        // Create Modal - Add Field
        $('#addFieldBtn').on('click', function() {
            addField('fieldSchemaContainer', 'fieldSchemaInput', 'noFieldsMessage');
        });

        // Edit Modal - Add Field
        $('#editAddFieldBtn').on('click', function() {
            addField('editFieldSchemaContainer', 'editFieldSchemaInput', 'editNoFieldsMessage');
        });

        function addField(containerId, inputId, messageId) {
            const index = fieldIndex++;
            const container = document.getElementById(containerId);
            const message = document.getElementById(messageId);
            if (message) message.style.display = 'none';

            const fieldHtml = `
                <div class="field-item border p-2 rounded-3 mb-2 bg-light" data-index="${index}">
                    <div class="row g-1">
                        <div class="col-md-3">
                            <label class="form-label fs-12">Key</label>
                            <input type="text" class="form-control form-control-sm field-key" 
                                   placeholder="e.g., pages" value="field_${index}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fs-12">Label</label>
                            <input type="text" class="form-control form-control-sm field-label" 
                                   placeholder="e.g., Page Count">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fs-12">Type</label>
                            <select class="form-select form-select-sm field-type">
                                <option value="text">Text</option>
                                <option value="textarea">Textarea</option>
                                <option value="number">Number</option>
                                <option value="decimal">Decimal</option>
                                <option value="boolean">Boolean</option>
                                <option value="date">Date</option>
                                <option value="select">Select</option>
                                <option value="multiselect">Multi Select</option>
                                <option value="json">JSON</option>
                                <option value="file">File</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fs-12">Required</label>
                            <div class="form-check mt-1">
                                <input type="checkbox" class="form-check-input field-required">
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <button type="button" class="btn btn-danger btn-sm remove-field mt-1">
                                <i class="fe fe-trash-2"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row mt-1 field-options" style="display:none;">
                        <div class="col-md-6">
                            <label class="form-label fs-12">Options (comma separated)</label>
                            <input type="text" class="form-control form-control-sm field-options-input" 
                                   placeholder="Option 1, Option 2, Option 3">
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', fieldHtml);
            updateFieldSchema(inputId);
        }

        // Remove Field
        $(document).on('click', '.remove-field', function() {
            const field = $(this).closest('.field-item');
            field.remove();
            updateFieldSchema('fieldSchemaInput');
            updateFieldSchema('editFieldSchemaInput');

            const container = field.closest('#fieldSchemaContainer, #editFieldSchemaContainer');
            if (container.find('.field-item').length === 0) {
                container.find('#noFieldsMessage, #editNoFieldsMessage').show();
            }
        });

        // Toggle Options for Select Types
        $(document).on('change', '.field-type', function() {
            const type = $(this).val();
            const optionsDiv = $(this).closest('.field-item').find('.field-options');
            optionsDiv.toggle(type === 'select' || type === 'multiselect');
        });

        // Update Schema on Change
        $(document).on('change', '.field-key, .field-label, .field-type, .field-required, .field-options-input', function() {
            const container = $(this).closest('#fieldSchemaContainer, #editFieldSchemaContainer');
            const inputId = container.attr('id') === 'fieldSchemaContainer' ? 'fieldSchemaInput' : 'editFieldSchemaInput';
            updateFieldSchema(inputId);
        });

        function updateFieldSchema(inputId) {
            const container = $('#' + inputId).closest('.modal-body').find('#fieldSchemaContainer, #editFieldSchemaContainer');
            const fields = container.find('.field-item');
            const schema = {};

            fields.each(function() {
                const key = $(this).find('.field-key').val().trim();
                if (key) {
                    schema[key] = {
                        label: $(this).find('.field-label').val().trim() || key,
                        type: $(this).find('.field-type').val() || 'text',
                        required: $(this).find('.field-required').is(':checked'),
                        options: $(this).find('.field-options-input').val()
                            ? $(this).find('.field-options-input').val().split(',').map(s => s.trim())
                            : null
                    };
                }
            });

            $('#' + inputId).val(JSON.stringify(schema));
        }

        // ============================================
        // EDIT CATEGORY - Populate & Open Modal
        // ============================================
        $(document).on('click', '.edit-category', function(e) {
            e.preventDefault();

            var data = $(this).data();
            var id = data.id;

            // Set form action
            var actionUrl = '/admin/categories/' + id;
            $('#editCategoryForm').attr('action', actionUrl);

            // Populate basic fields
            $('#edit_name').val(data.name || '');
            $('#edit_slug').val(data.slug || '');
            $('#edit_description').val(data.description || '');
            $('#edit_parent_id').val(data.parent || '');
            $('#edit_status').val(data.status !== undefined ? data.status : 1);

            $('#editCategoryErrors').hide().empty();

            // Load field schema into edit modal
            setTimeout(function() {
                populateEditSchema(data.schema);
            }, 300);

            // Open modal
            var modal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
            modal.show();
        });

        // ============================================
        // POPULATE SCHEMA IN EDIT MODAL
        // ============================================
        function populateEditSchema(schemaJson) {
            if (!schemaJson || schemaJson === 'null' || schemaJson === '[]') {
                $('#editFieldSchemaContainer').html(`
                    <div class="text-center text-muted py-3" id="editNoFieldsMessage">
                        <i class="fe fe-info me-1"></i> No attributes defined. Click "Add Field" to create.
                    </div>
                `);
                return;
            }

            try {
                const schema = typeof schemaJson === 'string' ? JSON.parse(schemaJson) : schemaJson;
                const container = document.getElementById('editFieldSchemaContainer');

                // Clear existing
                container.querySelectorAll('.field-item').forEach(el => el.remove());

                const message = document.getElementById('editNoFieldsMessage');
                if (message) message.style.display = 'none';

                if (Object.keys(schema).length === 0) {
                    $('#editFieldSchemaContainer').html(`
                        <div class="text-center text-muted py-3" id="editNoFieldsMessage">
                            <i class="fe fe-info me-1"></i> No attributes defined. Click "Add Field" to create.
                        </div>
                    `);
                    return;
                }

                let html = '';
                for (const [key, field] of Object.entries(schema)) {
                    const isSelect = field.type === 'select' || field.type === 'multiselect';
                    const optionsValue = field.options ? field.options.join(', ') : '';

                    html += `
                        <div class="field-item border p-2 rounded-3 mb-2 bg-light">
                            <div class="row g-1">
                                <div class="col-md-3">
                                    <label class="form-label fs-12">Key</label>
                                    <input type="text" class="form-control form-control-sm field-key" value="${key}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fs-12">Label</label>
                                    <input type="text" class="form-control form-control-sm field-label" value="${field.label || key}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fs-12">Type</label>
                                    <select class="form-select form-select-sm field-type">
                                        <option value="text" ${field.type === 'text' ? 'selected' : ''}>Text</option>
                                        <option value="textarea" ${field.type === 'textarea' ? 'selected' : ''}>Textarea</option>
                                        <option value="number" ${field.type === 'number' ? 'selected' : ''}>Number</option>
                                        <option value="decimal" ${field.type === 'decimal' ? 'selected' : ''}>Decimal</option>
                                        <option value="boolean" ${field.type === 'boolean' ? 'selected' : ''}>Boolean</option>
                                        <option value="date" ${field.type === 'date' ? 'selected' : ''}>Date</option>
                                        <option value="select" ${field.type === 'select' ? 'selected' : ''}>Select</option>
                                        <option value="multiselect" ${field.type === 'multiselect' ? 'selected' : ''}>Multi Select</option>
                                        <option value="json" ${field.type === 'json' ? 'selected' : ''}>JSON</option>
                                        <option value="file" ${field.type === 'file' ? 'selected' : ''}>File</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fs-12">Required</label>
                                    <div class="form-check mt-1">
                                        <input type="checkbox" class="form-check-input field-required" ${field.required ? 'checked' : ''}>
                                    </div>
                                </div>
                                <div class="col-md-2 text-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-field mt-1">
                                        <i class="fe fe-trash-2"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row mt-1 field-options" style="${isSelect ? '' : 'display:none;'}">
                                <div class="col-md-6">
                                    <label class="form-label fs-12">Options (comma separated)</label>
                                    <input type="text" class="form-control form-control-sm field-options-input" value="${optionsValue}">
                                </div>
                            </div>
                        </div>
                    `;
                }

                container.insertAdjacentHTML('beforeend', html);
                updateFieldSchema('editFieldSchemaInput');

            } catch (e) {
                console.error('Error parsing schema:', e);
                $('#editFieldSchemaContainer').html(`
                    <div class="alert alert-danger">
                        <i class="fe fe-alert-circle me-2"></i> 
                        Error loading field schema. Please try again.
                    </div>
                `);
            }
        }

        // ============================================
        // VIEW CATEGORY
        // ============================================
        $(document).on('click', '.view-category', function() {
            const id = $(this).data('id');
            const content = $('#viewCategoryContent');

            content.html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `);

            $.ajax({
                url: '/admin/categories/' + id,
                type: 'GET',
                success: function(response) {
                    content.html(response);
                },
                error: function() {
                    content.html(`
                        <div class="alert alert-danger m-3">
                            <i class="fe fe-alert-circle me-2"></i> 
                            Failed to load category details.
                        </div>
                    `);
                }
            });
        });

        // ============================================
        // DELETE CATEGORY
        // ============================================
        $(document).on('click', '.delete-category', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');

            $('#deleteCategoryName').text(name);
            $('#deleteCategoryId').val(id);

            const modal = new bootstrap.Modal(document.getElementById('deleteCategoryModal'));
            modal.show();
        });

        $(document).on('click', '#confirmDelete', function() {
            const id = $('#deleteCategoryId').val();
            const button = $(this);
            const original = button.html();

            button.prop('disabled', true);
            button.html('<span class="spinner-border spinner-border-sm me-1"></span>');

            $.ajax({
                url: '/admin/categories/' + id,
                type: 'DELETE',
                data: { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function(res) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('deleteCategoryModal'));
                    if (modal) modal.hide();
                    toastr.success(res.message);
                    button.prop('disabled', false);
                    button.html(original);
                    setTimeout(() => window.location.reload(), 800);
                },
                error: function(xhr) {
                    button.prop('disabled', false);
                    button.html(original);
                    toastr.error(xhr.responseJSON?.message || 'Failed to delete');
                    const modal = bootstrap.Modal.getInstance(document.getElementById('deleteCategoryModal'));
                    if (modal) modal.hide();
                }
            });
        });

        // ============================================
        // RESET FILTERS
        // ============================================
        $(document).on('click', '#resetFilters', function() {
            $('#filterForm')[0].reset();
            window.location.href = "{{ route('admin.categories.index') }}";
        });

        // ============================================
        // REMOVE BACKDROP ON MODAL CLOSE
        // ============================================
        function removeModalBackdrop() {
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $('body').css('padding-right', '');
        }

        $('#createCategoryModal').on('hidden.bs.modal', function() {
            removeModalBackdrop();
        });

        $('#editCategoryModal').on('hidden.bs.modal', function() {
            removeModalBackdrop();
        });

        $('#viewCategoryModal').on('hidden.bs.modal', function() {
            removeModalBackdrop();
        });

        $('#deleteCategoryModal').on('hidden.bs.modal', function() {
            removeModalBackdrop();
        });

        // ============================================
        // TOASTR CONFIG
        // ============================================
        if (typeof toastr !== 'undefined') {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 3000,
                extendedTimeOut: 1000
            };
        }

        console.log('✅ Category Management Loaded');

    });

})(jQuery);
</script>
@endpush