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

                    <div class="row mt-5 px-5">

                        <!-- Total Categories -->
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
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

                        <!-- Root Categories -->
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
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

                        <!-- Sub Categories -->
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
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

                        <!-- Active Categories -->
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
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


                    <!-- ============================================ -->
                    <!-- FILTER SECTION -->
                    <!-- ============================================ -->
                    <div class="row g-3 mb-4 align-items-end">

                        <!-- ============================================ -->
                        <!-- FILTER SECTION -->
                        <!-- ============================================ -->
                        <form id="filterForm" method="GET" action="{{ route('admin.categories.index') }}">
                            <div class="row g-3 mb-4 align-items-end">

                                <!-- Search -->
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold fs-12 mb-1">Search</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fe fe-search"></i></span>
                                        <input type="text" name="search" id="searchInput" class="form-control"
                                            placeholder="Search categories..." value="{{ request('search') }}">
                                    </div>
                                </div>

                                <!-- Status Filter -->
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold fs-12 mb-1">Status</label>
                                    <select name="status" id="statusFilter" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="inactive" {{ request('status')=='inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                </div>

                                <!-- Parent Category Filter -->
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold fs-12 mb-1">Parent Category</label>
                                    <select name="parent_id" id="parentFilter" class="form-select">
                                        <option value="">All Categories</option>
                                        <option value="null" {{ request('parent_id')=='null' ? 'selected' : '' }}>Root
                                            Categories</option>
                                        @foreach($categoryOptions ?? [] as $id => $name)
                                        <option value="{{ $id }}" {{ request('parent_id')==$id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Date Filter -->
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold fs-12 mb-1">Created</label>
                                    <select name="date_filter" id="dateFilter" class="form-select">
                                        <option value="">All Time</option>
                                        <option value="today" {{ request('date_filter')=='today' ? 'selected' : '' }}>
                                            Today</option>
                                        <option value="week" {{ request('date_filter')=='week' ? 'selected' : '' }}>This
                                            Week</option>
                                        <option value="month" {{ request('date_filter')=='month' ? 'selected' : '' }}>
                                            This Month</option>
                                        <option value="year" {{ request('date_filter')=='year' ? 'selected' : '' }}>This
                                            Year</option>
                                    </select>
                                </div>

                                <!-- Action Buttons -->
                                <div class="col-md-2">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary w-100" id="applyFilters">
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

                    </div>

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
                                        <!-- GLOBAL STATUS TOGGLE -->
                                        <div class="form-group mb-0">
                                            <label class="custom-switch form-switch">
                                                <input type="checkbox" name="status_{{ $category->id }}"
                                                    class="custom-switch-input statusToggle globalStatusToggle"
                                                    data-id="{{ $category->id }}" data-model="Category" {{
                                                    $category->status == 1 ? 'checked' : '' }}>
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
                                            <!-- View Button -->
                                            <button type="button" class="btn btn-outline-info view-category"
                                                data-id="{{ $category->id }}" data-bs-toggle="modal"
                                                data-bs-target="#viewCategoryModal">
                                                <i class="fe fe-eye"></i>
                                            </button>

                                            <!-- Edit Button -->
                                            <button type="button" class="btn btn-outline-primary edit-category"
                                                data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                                                data-slug="{{ $category->slug }}"
                                                data-description="{{ $category->description }}"
                                                data-parent="{{ $category->parent_id }}"
                                                data-status="{{ $category->status ? 1 : 0 }}">
                                                <i class="fe fe-edit-2"></i>
                                            </button>

                                            <!-- Delete Button -->
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fe fe-plus-circle text-primary me-2"></i>Add New Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">x</button>
            </div>
            <form id="createCategoryForm" class="ajax-form" method="POST" action="{{ route('admin.categories.store') }}"
                data-modal="#createCategoryModal" data-reload="1">
                @csrf
                <div class="modal-body">
                    <div id="createCategoryErrors" class="alert alert-danger" style="display: none;"></div>

                    <div class="mb-3">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter category name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" class="form-control" placeholder="Auto-generated if empty">
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fe fe-edit-2 text-primary me-2"></i>Edit Category
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal">x</button>
            </div>
            <form id="editCategoryForm" class="ajax-form" method="POST" action="" data-modal="#editCategoryModal"
                data-reload="1">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div id="editCategoryErrors" class="alert alert-danger" style="display: none;"></div>

                    <div class="mb-3">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_name" class="form-control"
                            placeholder="Enter category name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" name="slug" id="edit_slug" class="form-control"
                            placeholder="Auto-generated if empty">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="2"
                            placeholder="Optional category description"></textarea>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal">x</button>
            </div>
            <div class="modal-body" id="viewCategoryContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading category details...</p>
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
     * CATEGORY MANAGEMENT - Complete jQuery Solution
     * ============================================
     */

    (function ($) {
        'use strict';

        $(document).ready(function () {

            console.log('✅ Category Management Loaded');

            // ============================================
            // GLOBAL FUNCTIONS (Accessible from anywhere)
            // ============================================

            window.editCategory = function (id) {
                $('#viewCategoryModal').modal('hide');
                setTimeout(function () {
                    $('.edit-category[data-id="' + id + '"]').click();
                }, 300);
            };

            window.toggleStatus = function (id) {
                $('#viewCategoryModal').modal('hide');
                setTimeout(function () {
                    $('.toggle-status[data-id="' + id + '"]').click();
                }, 300);
            };

            window.deleteCategory = function (id, name) {
                $('#viewCategoryModal').modal('hide');
                setTimeout(function () {
                    $('.delete-category[data-id="' + id + '"]').click();
                }, 300);
            };

            // ============================================
            // VIEW MODAL ACTION BUTTONS
            // ============================================
            $(document).on('click', '.view-action-edit', function () {
                var id = $(this).data('id');
                window.editCategory(id);
            });

            $(document).on('click', '.view-action-toggle', function () {
                var id = $(this).data('id');
                window.toggleStatus(id);
            });

            $(document).on('click', '.view-action-delete', function () {
                var id = $(this).data('id');
                var name = $(this).data('name');
                window.deleteCategory(id, name);
            });

            // ============================================
            // 1. EDIT CATEGORY - Populate & Open Modal
            // ============================================
            $(document).on('click', '.edit-category', function (e) {
                e.preventDefault();

                var data = $(this).data();
                var id = data.id;

                console.log('📝 Edit Data:', data);

                var actionUrl = '/admin/categories/' + id;
                $('#editCategoryForm').attr('action', actionUrl);

                $('#edit_name').val(data.name || '');
                $('#edit_slug').val(data.slug || '');
                $('#edit_description').val(data.description || '');
                $('#edit_parent_id').val(data.parent || '');
                $('#edit_status').val(data.status !== undefined ? data.status : 1);

                $('#editCategoryErrors').hide().empty();

                var modalElement = document.getElementById('editCategoryModal');
                var modal = new bootstrap.Modal(modalElement);
                modal.show();

                console.log('✅ Edit modal opened');
            });

            // ============================================
            // 2. VIEW CATEGORY - Load via AJAX
            // ============================================
            $(document).on('click', '.view-category', function () {
                var id = $(this).data('id');
                var content = $('#viewCategoryContent');

                content.html(`
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading category details...</p>
                </div>
            `);

                $.ajax({
                    url: '/admin/categories/' + id,
                    type: 'GET',
                    success: function (response) {
                        content.html(response);
                        console.log('✅ View loaded');
                    },
                    error: function (xhr) {
                        console.error('❌ View Error:', xhr);
                        content.html(`
                        <div class="alert alert-danger m-3">
                            <i class="fe fe-alert-circle me-2"></i> 
                            Failed to load category details. Please try again.
                        </div>
                    `);
                    }
                });
            });

            // ============================================
            // 3. DELETE CATEGORY - Open Confirmation
            // ============================================
            $(document).on('click', '.delete-category', function () {
                var id = $(this).data('id');
                var name = $(this).data('name');

                $('#deleteCategoryName').text(name);
                $('#deleteCategoryId').val(id);

                var modalElement = document.getElementById('deleteCategoryModal');
                var modal = new bootstrap.Modal(modalElement);
                modal.show();
            });

            // ============================================
            // 4. CONFIRM DELETE
            // ============================================
            $(document).on('click', '#confirmDelete', function () {
                var id = $('#deleteCategoryId').val();
                var button = $(this);
                var originalText = button.html();

                button.prop('disabled', true);
                button.html(`
                <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                Deleting...
            `);

                $.ajax({
                    url: '/admin/categories/' + id,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        var modal = bootstrap.Modal.getInstance(document.getElementById('deleteCategoryModal'));
                        if (modal) modal.hide();

                        if (typeof toastr !== 'undefined') {
                            toastr.success(response.message);
                        } else {
                            alert(response.message);
                        }

                        button.prop('disabled', false);
                        button.html(originalText);

                        setTimeout(function () {
                            window.location.reload();
                        }, 800);
                    },
                    error: function (xhr) {
                        console.error('❌ Delete Error:', xhr);
                        button.prop('disabled', false);
                        button.html(originalText);

                        var message = xhr.responseJSON?.message || 'Failed to delete category';
                        if (typeof toastr !== 'undefined') {
                            toastr.error(message);
                        } else {
                            alert(message);
                        }

                        var modal = bootstrap.Modal.getInstance(document.getElementById('deleteCategoryModal'));
                        if (modal) modal.hide();
                    }
                });
            });


            $(document).on('click', '#resetFilters', function () {
                $('#filterForm')[0].reset();
                window.location.href = "{{ route('admin.categories.index') }}";
            });


            // ============================================
            // 6. TOASTR CONFIG
            // ============================================
            if (typeof toastr !== 'undefined') {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    positionClass: 'toast-top-right',
                    timeOut: 3000,
                    extendedTimeOut: 1000,
                    showMethod: 'fadeIn',
                    hideMethod: 'fadeOut'
                };
            }

            console.log('✅ Category Management Ready');

        }); // End of document ready

    })(jQuery); // End of safe wrapper
</script>
@endpush