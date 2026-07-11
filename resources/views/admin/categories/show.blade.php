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
                            <span class="badge {{ $category->is_active ? 'bg-success' : 'bg-secondary' }} px-3 py-2">
                                <i class="fe {{ $category->is_active ? 'fe-check-circle' : 'fe-circle' }} me-1"></i>
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Featured</th>
                        <td>
                            @if($category->is_featured ?? false)
                            <span class="badge bg-warning"><i class="fe fe-star me-1"></i> Featured</span>
                            @else
                            <span class="text-muted">Not featured</span>
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
                        <th width="130">Parent</th>
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
                    <tr>
                        <th>Sub-Categories</th>
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
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Sub-Categories List -->
@if($category->children->count() > 0)
<div class="row mt-3">
    <div class="col-12">
        <div class="card shadow-none border">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="fe fe-list me-2"></i>Sub-Categories
                    <span class="badge bg-info ms-2">{{ $category->children->count() }}</span>
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-sm mb-0">
                        <thead class="">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($category->children as $child)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <i class="fe fe-folder text-warning me-1"></i>
                                    {{ $child->name }}
                                </td>
                                <td><code class="fs-12">{{ $child->slug }}</code></td>
                                <td>
                                    <span class="badge {{ $child->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $child->is_active ? 'Active' : 'Inactive' }}
                                    </span>
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

<!-- Timeline / Audit Info -->
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


