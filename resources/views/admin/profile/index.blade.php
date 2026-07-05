@extends('layouts.master')

@section('title', 'Admin Profile')

@section('content')

<div class="mt-5">

    <!-- Header -->
    <div class="row">
        <div class="col-xl-12">

            <div class="card overflow-hidden">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col-xl-2 text-center">

                            <img src="https://placehold.co/150x150?text=Admin" class="rounded-circle border shadow"
                                width="130">

                        </div>

                        <div class="col-xl-7">

                            <div class="d-flex align-items-center mb-2">

                                <h2 class="fw-bold mb-0 me-2">
                                    Super Administrator
                                </h2>

                                <span class="badge bg-success">
                                    <i class="fe fe-check-circle"></i>
                                    Active
                                </span>

                            </div>

                            <p class="text-muted mb-3">
                                Manage users, sellers, buyers, products, categories,
                                orders, reports and marketplace settings.
                            </p>

                            <div class="row">

                                <div class="col-md-4">
                                    <small class="text-muted d-block">
                                        Role
                                    </small>

                                    <strong>Administrator</strong>
                                </div>

                                <div class="col-md-4">
                                    <small class="text-muted d-block">
                                        Email
                                    </small>

                                    <strong>admin@example.com</strong>
                                </div>

                                <div class="col-md-4">
                                    <small class="text-muted d-block">
                                        Member Since
                                    </small>

                                    <strong>July 2026</strong>
                                </div>

                            </div>

                        </div>

                        <div class="col-xl-3 text-end">

                            <a href="#" class="btn btn-primary">

                                <i class="fe fe-edit"></i>

                                Edit Profile

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- Row 1 -->
    <div class="row">

        <div class="col-xl-8">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        Personal Information
                    </h3>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-4">

                            <small class="text-muted">
                                Full Name
                            </small>

                            <h6>Super Admin</h6>

                        </div>

                        <div class="col-md-6 mb-4">

                            <small class="text-muted">
                                Email
                            </small>

                            <h6>admin@example.com</h6>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted">
                                Phone
                            </small>

                            <h6>+91 9876543210</h6>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted">
                                Role
                            </small>

                            <h6>Administrator</h6>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-4">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        Account Status
                    </h3>
                </div>

                <div class="card-body">

                    <div class="mb-4">

                        <small class="text-muted">
                            Account Status
                        </small>

                        <br>

                        <span class="badge bg-success">
                            Active
                        </span>

                    </div>

                    <div class="mb-4">

                        <small class="text-muted">
                            Email Verification
                        </small>

                        <br>

                        <span class="badge bg-success">
                            Verified
                        </span>

                    </div>

                    <div>

                        <small class="text-muted">
                            Last Login
                        </small>

                        <h6>Today, 10:15 AM</h6>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Row 2 -->
    <div class="row">

        <div class="col-xl-6">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        Security
                    </h3>
                </div>

                <div class="card-body">

                    <p class="mb-3">
                        <strong>Password :</strong>
                        ************
                    </p>

                    <p class="mb-3">
                        <strong>Email Verified :</strong>
                        Yes
                    </p>

                    <p class="mb-0">
                        <strong>Remember Token :</strong>
                        Active
                    </p>

                </div>

            </div>

        </div>

        <div class="col-xl-6">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        Recent Activity
                    </h3>
                </div>

                <div class="card-body">

                    <p class="mb-3">
                        Account Created :
                        <strong>05 Jul 2026</strong>
                    </p>

                    <p class="mb-3">
                        Last Updated :
                        <strong>18 Jul 2026</strong>
                    </p>

                    <p class="mb-0">
                        Last Login :
                        <strong>Today 10:15 AM</strong>
                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- Quick Actions -->
    <div class="row">

        <div class="col-xl-12">

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">
                        Quick Actions
                    </h3>

                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-xl-3 mb-3">
                            <a href="#" class="btn btn-primary w-100 py-3">
                                <i class="fe fe-edit me-2"></i>
                                Edit Profile
                            </a>
                        </div>

                        <div class="col-xl-3 mb-3">
                            <a href="#" class="btn btn-info w-100 py-3">
                                <i class="fe fe-image me-2"></i>
                                Change Avatar
                            </a>
                        </div>

                        <div class="col-xl-3 mb-3">
                            <a href="#" class="btn btn-warning w-100 py-3">
                                <i class="fe fe-lock me-2"></i>
                                Change Password
                            </a>
                        </div>

                        <div class="col-xl-3 mb-3">
                            <a href="#" class="btn btn-success w-100 py-3">
                                <i class="fe fe-settings me-2"></i>
                                System Settings
                            </a>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection