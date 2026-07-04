@extends('layouts.master')

@section('title', 'Admin | Users')

@section('content')

<div class="mt-5" id="data-table-container">
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <h3 class="card-title mb-1 fw-bold">Users Management</h3>
                        <p class="text-muted mb-0 fs-12">Manage your users and their permissions</p>
                    </div>
                </div>

                <!-- // Users Statistics Cards -->
                <div class="row mt-5 px-5">
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                        <div class="card bg-primary img-card box-primary-shadow border-0 rounded-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="text-white">
                                        <h2 class="mb-0 number-font fw-bold">{{ $totalUsers ?? 0 }}</h2>
                                        <p class="text-white-50 mb-0 fs-13">Total Users</p>
                                    </div>
                                    <div class="ms-auto text-white-50">
                                        <i class="fe fe-users fs-30"></i>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                        <div class="card bg-info img-card box-info-shadow border-0 rounded-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="text-white">
                                        <h2 class="mb-0 number-font fw-bold">{{ $totalSellers ?? 0 }}</h2>
                                        <p class="text-white-50 mb-0 fs-13">Total Sellers</p>
                                    </div>
                                    <div class="ms-auto text-white-50">
                                        <i class="fe fe-shopping-bag fs-30"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                        <div class="card bg-warning img-card box-warning-shadow border-0 rounded-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="text-white">
                                        <h2 class="mb-0 number-font fw-bold">{{ $totalBuyers ?? 0 }}</h2>
                                        <p class="text-white-50 mb-0 fs-13">Total Buyers</p>
                                    </div>
                                    <div class="ms-auto text-white-50">
                                        <i class="fe fe-shopping-cart fs-30"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                        <div class="card bg-success img-card box-success-shadow border-0 rounded-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="text-white">
                                        <h2 class="mb-0 number-font fw-bold">{{ $activeUsers ?? 0 }}</h2>
                                        <p class="text-white-50 mb-0 fs-13">Active Accounts</p>
                                    </div>
                                    <div class="ms-auto text-white-50">
                                        <i class="fe fe-check-circle fs-30"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- // Filter Form -->
                <div class="row row-sm ">
                    <div class="col-lg-12">
                        <div class="card border-0  rounded-4">
                            <div class="card-body py-0">
                                <form method="GET" action="{{ route('admin.users.index') }}"
                                    class="row g-3 align-items-end">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold text-muted fs-12">Search Name /
                                            Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0"><i
                                                    class="fe fe-search text-muted"></i></span>
                                            <input type="text" name="search"
                                                class="form-control bg-light border-start-0"
                                                value="{{ request('search') }}" placeholder="Type keywords...">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold text-muted fs-12">Account Role</label>
                                        <select name="role" class="form-control form-select bg-light">
                                            <option value="">All Roles</option>
                                            <option value="1" {{ request('role')==='1' ? 'selected' : '' }}>Seller
                                            </option>
                                            <option value="2" {{ request('role')==='2' ? 'selected' : '' }}>Buyer
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold text-muted fs-12">Account Status</label>
                                        <select name="status" class="form-control form-select bg-light">
                                            <option value="">All Statuses</option>
                                            <option value="1" {{ request('status')==='1' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ request('status')==='0' ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 d-flex gap-2">
                                        <button type="submit" class="btn btn-primary w-100 rounded-pill px-3">
                                            <i class="fe fe-sliders me-1"></i>Filter
                                        </button>
                                        <a href="{{ route('admin.users.index') }}"
                                            class="btn btn-light w-100 rounded-pill px-3">
                                            Reset
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- // Users Table -->
                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <div id="table-container">
                            <table class="table table-bordered text-nowrap border-bottom">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $index => $user)
                                    <tr>
                                        <td>{{ $users->firstItem() + $index }}</td>
                                        <td>
                                            <strong>{{ $user->name }}</strong>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->role === 1)
                                            <span class="badge bg-primary">Seller</span>
                                            @elseif($user->role === 2)
                                            <span class="badge bg-warning">Buyer</span>
                                            @else
                                            <span class="badge bg-secondary">User</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->status)
                                            <span class="badge bg-success status-badge">Active</span>
                                            @else
                                            <span class="badge bg-danger status-badge">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-list d-flex gap-2 align-items-center">
                                                <button class="btn btn-sm btn-outline-primary edit-btn rounded-pill"
                                                    data-id="{{ $user->id }}" data-name="{{ $user->name }}"
                                                    data-email="{{ $user->email }}" data-role="{{ $user->role }}">
                                                    <i class="fe fe-edit-2 me-1"></i>Edit
                                                </button>

                                                <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger rounded-pill delete-btn mb-2">
                                                        <i class="fe fe-trash-2 me-1"></i>Delete
                                                    </button>
                                                </form>

                                                <div class="form-group">
                                                    <label class="custom-switch form-switch">
                                                        <input type="checkbox" name="status_{{ $user->id }}"
                                                            class="custom-switch-input statusToggle globalStatusToggle"
                                                            data-id="{{ $user->id }}" data-model="User" {{ $user->status
                                                        == 1 ? 'checked' : '' }}>
                                                        <span class="custom-switch-indicator"></span>
                                                        <span
                                                            class="custom-switch-description badge p-0 text-dark ms-2">{{
                                                            $user->status == 1 ? 'Active' : 'Inactive' }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <i class="fe fe-share-2 fs-48 text-muted"></i>
                                            <p class="text-muted mt-2 mb-0">No Users found.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-4">{{ $users->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-0 pt-4 px-4">
                <div>
                    <h5 class="modal-title fw-bold">
                        <i class="fe fe-edit-2 me-2"></i>Edit User
                    </h5>
                    <p class="text-muted mb-0 fs-12 mt-1">Update user account profile details</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal">x</button>
            </div>

            <form id="editUserForm" class="ajax-form" method="POST" data-modal="#editModal" data-reset="0">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-3">
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">
                                <i class="fe fe-user me-1"></i>Name *
                            </label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">
                                <i class="fe fe-activity me-1"></i>Status *
                            </label>
                            <select name="status" id="edit_status" class="form-control form-select" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fe fe-mail me-1"></i>Email Address *
                        </label>
                        <input type="email" name="email" id="edit_email" class="form-control" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="fe fe-shield me-1"></i>Account Role *
                        </label>
                        <select name="role" id="edit_role" class="form-control form-select" disabled>
                            <option value="1">Seller</option>
                            <option value="2">Buyer</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light rounded-pill px-4"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-5">
                        <i class="fe fe-save me-2"></i>Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $(document).on('click', '.edit-btn', function () {
            let btn = $(this);

            // Extract attributes from clicked button
            let id = btn.data('id');
            let name = btn.data('name');
            let email = btn.data('email');
            let role = btn.data('role');
            let status = (btn.data('status') == true || btn.data('status') == 1) ? 0 : 1;

            // Populate form values in modal
            $('#edit_name').val(name);
            $('#edit_email').val(email);
            $('#edit_role').val(role);
            $('#edit_status').val(status);

            // Construct and update dynamic route action string
            let baseUrl = "{{ route('admin.users.update', ':id') }}";
            let updateUrl = baseUrl.replace(':id', id);
            $('#editUserForm').attr('action', updateUrl);

            // Show modal
            $('#editModal').modal('show');
        });
    });
</script>

@endsection