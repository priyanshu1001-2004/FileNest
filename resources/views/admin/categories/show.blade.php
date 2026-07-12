{{-- resources/views/admin/categories/show.blade.php --}}
<div class="row">
    <!-- Left Column: Basic Info -->
    <div class="col-md-6">
        <div class="card shadow-none border-0">
            <div class="card-body p-0">
                <h6 class="text-muted mb-3"><i class="fe fe-info me-2"></i>Basic Information</h6>

                <table class="table table-bordered table-sm">
                    <tr>
                        <th width="130">ID</th>
                        <td><span class="badge bg-primary">{{ $category->id }}</span></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><strong class="fs-5">{{ $category->name }}</strong></td>
                    </tr>
                    <tr>
                        <th>Slug</th>
                        <td><code>{{ $category->slug }}</code></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $category->description ?? '<span class="text-muted">No description</span>' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge {{ $category->status ? 'bg-success' : 'bg-secondary' }} px-3 py-2">
                                <i class="fe {{ $category->status ? 'fe-check-circle' : 'fe-circle' }} me-1"></i>
                                {{ $category->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Parent</th>
                        <td>
                            @if($category->parent)
                            <a href="#" class="text-primary">
                                <i class="fe fe-folder me-1"></i> {{ $category->parent->name }}
                            </a>
                            <br>
                            <small class="text-muted">ID: {{ $category->parent->id }}</small>
                            @else
                            <span class="badge bg-secondary">Root Category</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: Relationships -->
    <div class="col-md-6">
        <div class="card shadow-none border-0">
            <div class="card-body p-0">
                <h6 class="text-muted mb-3"><i class="fe fe-link me-2"></i>Relationships</h6>

                <table class="table table-bordered table-sm">
                    <tr>
                        <th width="130">Sub-Categories</th>
                        <td>
                            @if($category->children->count() > 0)
                            <span class="badge bg-info me-1">{{ $category->children->count() }}</span>
                            <span class="text-muted">sub-categories</span>
                            @else
                            <span class="text-muted">No sub-categories</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Products</th>
                        <td>
                            @if($category->products_count ?? 0 > 0)
                            <span class="badge bg-success me-1">{{ $category->products_count ?? 0 }}</span>
                            <span class="text-muted">products</span>
                            @else
                            <span class="text-muted">No products</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Creator</th>
                        <td>
                            @if($category->creator)
                            {{ $category->creator->name }}
                            <br>
                            <small class="text-muted">{{ $category->creator->email }}</small>
                            @else
                            <span class="text-muted">System</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created</th>
                        <td>{{ $category->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Last Updated</th>
                        <td>{{ $category->updated_at->format('d M Y, h:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- FIELD SCHEMA (Attributes Definition) -->
<!-- ============================================ -->
@if($category->field_schema && count($category->field_schema) > 0)
<div class="row mt-3">
    <div class="col-12">
        <div class="card shadow-none border">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h6 class="mb-0">
                    <i class="fe fe-list me-2"></i>Field Schema (Attributes)
                    <span class="badge bg-primary ms-2">{{ count($category->field_schema) }}</span>
                    <small class="text-muted fs-12 ms-2">Attributes defined for this category</small>
                </h6>
                <span class="badge bg-info">Dynamic Fields</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">#</th>
                                <th>Key</th>
                                <th>Label</th>
                                <th>Type</th>
                                <th width="80">Required</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($category->field_schema as $key => $field)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><code class="fs-12">{{ $key }}</code></td>
                                <td><strong>{{ $field['label'] ?? ucfirst($key) }}</strong></td>
                                <td>
                                    <span class="badge bg-secondary text-uppercase fs-11">
                                        {{ $field['type'] ?? 'text' }}
                                    </span>
                                </td>
                                <td>
                                    @if($field['required'] ?? false)
                                    <span class="badge bg-danger">Required</span>
                                    @else
                                    <span class="badge bg-secondary">Optional</span>
                                    @endif
                                </td>
                                <td>
                                    @if(isset($field['options']) && is_array($field['options']) && count($field['options']) > 0)
                                    <span class="text-muted">
                                        @foreach($field['options'] as $index => $option)
                                        <span class="badge bg-light text-dark border">{{ $option }}</span>
                                        @endforeach
                                    </span>
                                    @else
                                    <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- ============================================ -->
<!-- SUB-CATEGORIES LIST -->
<!-- ============================================ -->
@if($category->children->count() > 0)
<div class="row mt-3">
    <div class="col-12">
        <div class="card shadow-none border">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h6 class="mb-0">
                    <i class="fe fe-folder me-2"></i>Sub-Categories
                    <span class="badge bg-info ms-2">{{ $category->children->count() }}</span>
                </h6>
                <span class="badge bg-secondary">Child Categories</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Products</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($category->children as $child)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <i class="fe fe-folder text-warning me-1"></i>
                                    <a href="#" class="text-primary">{{ $child->name }}</a>
                                </td>
                                <td><code class="fs-12">{{ $child->slug }}</code></td>
                                <td>
                                    <span class="badge {{ $child->status ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $child->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $child->products_count ?? 0 }}</span>
                                </td>
                                <td>{{ $child->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- ============================================ -->
<!-- AUDIT INFORMATION -->
<!-- ============================================ -->
<div class="row mt-3">
    <div class="col-12">
        <div class="card shadow-none border">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fe fe-clock me-2"></i>Audit Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th width="150">Created At</th>
                                <td>{{ $category->created_at->format('d M Y, h:i:s A') }}</td>
                            </tr>
                            <tr>
                                <th>Created By</th>
                                <td>
                                    @if($category->creator)
                                    {{ $category->creator->name }}
                                    <br>
                                    <small class="text-muted">{{ $category->creator->email }}</small>
                                    @else
                                    <span class="text-muted">System</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th width="150">Updated At</th>
                                <td>{{ $category->updated_at->format('d M Y, h:i:s A') }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated By</th>
                                <td>
                                    @if($category->updater)
                                    {{ $category->updater->name }}
                                    <br>
                                    <small class="text-muted">{{ $category->updater->email }}</small>
                                    @else
                                    <span class="text-muted">{{ $category->creator->name ?? 'System' }}</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================ -->
<!-- QUICK ACTIONS -->
<!-- ============================================ -->
<div class="row mt-3">
    <div class="col-12">
        <div class="d-flex gap-2 justify-content-end border-top pt-3">
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="editCategory({{ $category->id }})">
                <i class="fe fe-edit-2 me-1"></i> Edit Category
            </button>
           
            @if($category->children->count() == 0)
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteCategory({{ $category->id }}, '{{ $category->name }}')">
                <i class="fe fe-trash-2 me-1"></i> Delete
            </button>
            @endif
        </div>
    </div>
</div>

<script>
// ============================================
// QUICK ACTION FUNCTIONS
// ============================================
function editCategory(id) {
    $('#viewCategoryModal').modal('hide');
    setTimeout(function() {
        $('.edit-category[data-id="' + id + '"]').click();
    }, 300);
}



function deleteCategory(id, name) {
    $('#viewCategoryModal').modal('hide');
    setTimeout(function() {
        $('.delete-category[data-id="' + id + '"]').click();
    }, 300);
}
</script>