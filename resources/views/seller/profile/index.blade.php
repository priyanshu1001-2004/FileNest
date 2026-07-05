@extends('layouts.master')

@section('title', 'Profile')

@push('styles')
<style>
    /* ---- Modern polish layered on top of existing Bootstrap/fe classes ---- */
    .seller-hero{border-radius:18px; overflow:hidden;}
    .seller-hero .banner-wrap{
        height:190px;
        background:
            radial-gradient(120% 180% at 0% 0%, #6a5ff7 0%, transparent 60%),
            radial-gradient(120% 180% at 100% 100%, #4338ca 0%, transparent 55%),
            linear-gradient(120deg,#4f46e5,#6d28d9 60%, #312e81);
        position:relative;
    }
    .seller-hero .banner-wrap img{width:100%; height:100%; object-fit:cover; opacity:.18;}
    .seller-hero .banner-edit-btn{
        position:absolute; top:15px; right:15px;
        background:rgba(255,255,255,.18); backdrop-filter:blur(6px);
        border:1px solid rgba(255,255,255,.4); color:#fff;
    }
    .seller-hero .banner-edit-btn:hover{background:rgba(255,255,255,.3); color:#fff;}

    .seller-logo{
        width:110px; height:110px; border-radius:22px;
        border:5px solid #fff; margin-top:-55px; background:#fff;
        box-shadow:0 8px 24px -8px rgba(20,20,43,.25);
        object-fit:cover;
    }

    .completion-ring-card{
        background:#eef0fd; border:none; border-radius:14px;
    }
    .completion-ring{position:relative; width:64px; height:64px; flex:none;}
    .completion-ring svg{transform:rotate(-90deg);}
    .completion-ring-label{
        position:absolute; inset:0; display:flex; align-items:center; justify-content:center;
        font-weight:700; font-size:13px; color:#4f46e5;
    }

    .section-card{border-radius:16px; border:1px solid #edeef5; box-shadow:0 1px 2px rgba(20,20,43,.04), 0 8px 20px -14px rgba(20,20,43,.12);}
    .section-card .card-header{background:transparent; border-bottom:1px solid #f0f1f7; border-radius:16px 16px 0 0 !important;}
    .icon-chip{
        width:36px; height:36px; border-radius:10px;
        background:#eef0fd; color:#4f46e5;
        display:inline-flex; align-items:center; justify-content:center;
    }

    .policy-block{background:#f8f9fc; border:1px solid #eef0f5; border-radius:10px; padding:14px 16px;}
    .policy-block .fe{color:#4f46e5; margin-right:6px;}

    .social-item{
        display:flex; align-items:center; gap:12px;
        padding:10px 8px; border-radius:10px;
    }
    .social-item:hover{background:#f8f9fc;}
    .social-badge{
        width:36px; height:36px; border-radius:9px; flex:none;
        display:flex; align-items:center; justify-content:center; color:#fff;
    }

    .verify-tile{border:1px solid #edeef5; border-radius:12px; padding:16px 10px; text-align:center;}
    .verify-tile .fe{font-size:22px; display:block; margin-bottom:8px;}

    .stat-tile{border:1px solid #edeef5; border-radius:12px; padding:14px;}
    .stat-tile .num{font-size:20px; font-weight:700; color:#1c2033;}
    .stat-tile .lbl{font-size:12px; color:#767e94; font-weight:600; text-transform:uppercase; letter-spacing:.03em;}

    .quick-action-btn{
        border-radius:10px; font-size:13px; font-weight:600;
        display:flex; align-items:center; justify-content:flex-start; gap:8px;
        padding:12px 14px;
    }
</style>
@endpush

@section('content')

<div class="mt-5" id="data-table-container">
    <div class="row row-sm">
        <div class="col-lg-12">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <div>
                    <h3 class="mb-1 fw-bold">Seller Profile</h3>
                    <small class="text-muted">Manage how buyers see your store on the marketplace</small>
                </div>
            </div>

            <!-- ============ HERO / BANNER ============ -->
            <div class="card seller-hero overflow-hidden mb-4">
                <div class="banner-wrap">
                    <img src="https://placehold.co/1600x350?text=Store+Banner" alt="Store Banner">
                    <button class="btn btn-sm banner-edit-btn position-absolute">
                        <i class="fe fe-camera"></i> Change Banner
                    </button>
                </div>

                <div class="card-body">
                    <div class="row align-items-end">

                        <!-- Logo -->
                        <div class="col-xl-2 col-lg-3 text-center text-lg-start">
                            <img src="https://placehold.co/150x150?text=Logo" class="seller-logo shadow" alt="Store Logo">
                        </div>

                        <!-- Store Details -->
                        <div class="col-xl-7 col-lg-6 mt-3 mt-lg-0">
                            <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                                <h2 class="mb-0 fw-bold">PixelCraft Studio</h2>
                                <span class="badge bg-success">
                                    <i class="fe fe-check-circle"></i> Verified Seller
                                </span>
                                <span class="badge bg-warning text-dark">
                                    <i class="fe fe-star"></i> Featured
                                </span>
                            </div>

                            <p class="text-muted mb-3">
                                Premium Laravel Projects, UI Kits, Admin Dashboards, Templates & Digital Assets.
                            </p>

                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <small class="text-muted d-block">Seller Type</small>
                                    <strong>Individual</strong>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <small class="text-muted d-block">Country</small>
                                    <strong>India</strong>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <small class="text-muted d-block">Member Since</small>
                                    <strong>July 2026</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Completion -->
                        <div class="col-xl-3 col-lg-3 mt-3 mt-lg-0">
                            <div class="card completion-ring-card shadow-none">
                                <div class="card-body d-flex align-items-center gap-3">
                                    <div class="completion-ring">
                                        <svg width="64" height="64" viewBox="0 0 64 64">
                                            <circle cx="32" cy="32" r="27" fill="none" stroke="#dfe0fb" stroke-width="7"/>
                                            <circle cx="32" cy="32" r="27" fill="none" stroke="#4f46e5" stroke-width="7"
                                                stroke-linecap="round" stroke-dasharray="169.6" stroke-dashoffset="13.6"/>
                                        </svg>
                                        <div class="completion-ring-label">92%</div>
                                    </div>
                                    <div>
                                        <div class="fw-semibold small">Profile Completion</div>
                                        <small class="text-muted d-block mb-2">Almost there — boost buyer trust.</small>
                                        <button class="btn btn-primary btn-sm w-100">
                                            <i class="fe fe-edit"></i> Edit Profile
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ============ ROW 1: Store Information | Profile Status ============ -->
            <div class="row row-sm">
                <div class="col-lg-7 mb-4">
                    <div class="card section-card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <span class="icon-chip"><i class="fe fe-shopping-bag"></i></span>
                                <div>
                                    <h4 class="card-title mb-0">Store Information</h4>
                                    <small class="text-muted">Basic details buyers see first</small>
                                </div>
                            </div>
                            <button class="btn btn-outline-primary btn-sm"><i class="fe fe-edit"></i> Edit</button>
                        </div>
                        <div class="card-body">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <label class="text-muted small mb-1 d-block">Store Name</label>
                                    <h6 class="mb-0">PixelCraft Studio</h6>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small mb-1 d-block">Store Slug</label>
                                    <h6 class="mb-0">pixelcraft-studio</h6>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small mb-1 d-block">Store Tagline</label>
                                    <h6 class="mb-0">Premium Digital Products for Developers & Designers</h6>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small mb-1 d-block">Seller Type</label>
                                    <span class="badge bg-primary">Individual Seller</span>
                                </div>
                                <div class="col-12">
                                    <label class="text-muted small mb-1 d-block">Store Description</label>
                                    <p class="mb-0 text-muted">
                                        PixelCraft Studio specializes in premium Laravel projects, admin dashboards,
                                        website templates, source code, UI kits, AI tools, and other digital assets.
                                        Our mission is to deliver high-quality digital products that save developers
                                        and businesses valuable time.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 mb-4">
                    <div class="card section-card h-100">
                        <div class="card-header d-flex align-items-center gap-2">
                            <span class="icon-chip"><i class="fe fe-check-circle"></i></span>
                            <div>
                                <h4 class="card-title mb-0">Profile Status</h4>
                                <small class="text-muted">Overview at a glance</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted small">Completion</span>
                                <span class="fw-bold text-primary">92%</span>
                            </div>
                            <div class="progress mb-4" style="height:7px;">
                                <div class="progress-bar bg-primary" style="width:92%;"></div>
                            </div>

                            <ul class="list-unstyled mb-0">
                                <li class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted small">Verification</span>
                                    <span class="badge bg-success">Verified</span>
                                </li>
                                <li class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted small">Member Since</span>
                                    <strong class="small">July 05, 2026</strong>
                                </li>
                                <li class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">Last Updated</span>
                                    <strong class="small">July 15, 2026</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ ROW 2: Business | Contact ============ -->
            <div class="row row-sm">
                <div class="col-lg-6 mb-4">
                    <div class="card section-card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <span class="icon-chip"><i class="fe fe-briefcase"></i></span>
                                <div>
                                    <h4 class="card-title mb-0">Business Information</h4>
                                    <small class="text-muted">Used for seller verification</small>
                                </div>
                            </div>
                            <button class="btn btn-outline-primary btn-sm"><i class="fe fe-edit"></i> Edit</button>
                        </div>
                        <div class="card-body">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <label class="text-muted small d-block mb-1">Company Name</label>
                                    <div class="fw-semibold">PixelCraft Technologies</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block mb-1">Tax / GST Number</label>
                                    <div class="fw-semibold">GSTIN22ABCDE1234F1Z5</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block mb-1">Seller Type</label>
                                    <span class="badge bg-primary">Individual Seller</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block mb-1">Verification Status</label>
                                    <span class="badge bg-success"><i class="fe fe-check-circle"></i> Verified</span>
                                </div>
                                <div class="col-12">
                                    <label class="text-muted small d-block mb-1">Business Address</label>
                                    <div class="fw-semibold">
                                        221B Business Street,<br>
                                        New Delhi, Delhi - 110001,<br>
                                        India
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card section-card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <span class="icon-chip"><i class="fe fe-mail"></i></span>
                                <div>
                                    <h4 class="card-title mb-0">Contact Information</h4>
                                    <small class="text-muted">Visible to buyers</small>
                                </div>
                            </div>
                            <button class="btn btn-outline-primary btn-sm"><i class="fe fe-edit"></i> Edit</button>
                        </div>
                        <div class="card-body">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <label class="text-muted small d-block mb-1">Support Email</label>
                                    <div class="fw-semibold">support@pixelcraft.com</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block mb-1">Website</label>
                                    <a href="#" class="text-primary fw-semibold">pixelcraft.com</a>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block mb-1">Public Email</label>
                                    <div class="fw-semibold">hello@pixelcraft.com</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block mb-1">Response Time</label>
                                    <span class="badge bg-success">Usually within 24 Hours</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ ROW 3: Policies | Social Links ============ -->
            <div class="row row-sm">
                <div class="col-lg-6 mb-4">
                    <div class="card section-card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <span class="icon-chip"><i class="fe fe-file-text"></i></span>
                                <div>
                                    <h4 class="card-title mb-0">Store Policies</h4>
                                    <small class="text-muted">Support, refund & licensing</small>
                                </div>
                            </div>
                            <button class="btn btn-outline-primary btn-sm"><i class="fe fe-edit"></i> Edit</button>
                        </div>
                        <div class="card-body">
                            <label class="text-muted small d-block mb-2">Support Policy</label>
                            <div class="policy-block mb-3">
                                <i class="fe fe-life-buoy"></i>
                                We provide free technical support for all purchased products for up to 6 months.
                                Support is available Monday to Friday during business hours. Custom feature requests
                                and third-party modifications are not included.
                            </div>

                            <label class="text-muted small d-block mb-2">Refund Policy</label>
                            <div class="policy-block mb-3">
                                <i class="fe fe-rotate-ccw"></i>
                                Refund requests are accepted within 7 days of purchase if the product is defective
                                or cannot be downloaded. Refunds are not available for accidental purchases or
                                change of mind.
                            </div>

                            <label class="text-muted small d-block mb-2">License Information</label>
                            <div class="policy-block">
                                <i class="fe fe-shield"></i>
                                All products are licensed for personal and commercial use unless otherwise stated.
                                Redistribution, resale, or sharing of purchased files is strictly prohibited.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card section-card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <span class="icon-chip"><i class="fe fe-link"></i></span>
                                <div>
                                    <h4 class="card-title mb-0">Social & Portfolio Links</h4>
                                    <small class="text-muted">Connect buyers to your work</small>
                                </div>
                            </div>
                            <button class="btn btn-outline-primary btn-sm"><i class="fe fe-edit"></i> Edit</button>
                        </div>
                        <div class="card-body">

                            <div class="social-item">
                                <span class="social-badge" style="background:#1f2328;"><i class="fe fe-github text-white"></i></span>
                                <div>
                                    <small class="text-muted d-block">GitHub</small>
                                    <a href="#" class="text-dark fw-semibold">github.com/pixelcraft</a>
                                </div>
                            </div>

                            <div class="social-item">
                                <span class="social-badge" style="background:#ff0000;"><i class="fe fe-youtube text-white"></i></span>
                                <div>
                                    <small class="text-muted d-block">YouTube</small>
                                    <a href="#" class="text-danger fw-semibold">youtube.com/@pixelcraft</a>
                                </div>
                            </div>

                            <div class="social-item">
                                <span class="social-badge" style="background:#0a66c2;"><i class="fe fe-linkedin text-white"></i></span>
                                <div>
                                    <small class="text-muted d-block">LinkedIn</small>
                                    <a href="#" class="text-primary fw-semibold">linkedin.com/company/pixelcraft</a>
                                </div>
                            </div>

                            <div class="social-item">
                                <span class="social-badge" style="background:linear-gradient(135deg,#f58529,#dd2a7b,#8134af);"><i class="fe fe-instagram text-white"></i></span>
                                <div>
                                    <small class="text-muted d-block">Instagram</small>
                                    <a href="#" class="text-danger fw-semibold">@pixelcraftstudio</a>
                                </div>
                            </div>

                            <div class="social-item">
                                <span class="social-badge" style="background:#1da1f2;"><i class="fe fe-twitter text-white"></i></span>
                                <div>
                                    <small class="text-muted d-block">Twitter / X</small>
                                    <a href="#" class="text-dark fw-semibold">@pixelcraft</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ ROW 4: Verification | Analytics | Quick Actions ============ -->
            <div class="row row-sm">

                <div class="col-lg-4 mb-4">
                    <div class="card section-card h-100">
                        <div class="card-header d-flex align-items-center gap-2">
                            <span class="icon-chip"><i class="fe fe-shield"></i></span>
                            <div>
                                <h4 class="card-title mb-0">Verification</h4>
                                <small class="text-muted">Account trust status</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="verify-tile">
                                        <i class="fe fe-user-check text-success"></i>
                                        <small class="text-muted d-block mb-2">Account</small>
                                        <span class="badge bg-success">Active</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="verify-tile">
                                        <i class="fe fe-mail text-primary"></i>
                                        <small class="text-muted d-block mb-2">Email</small>
                                        <span class="badge bg-success">Verified</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="verify-tile">
                                        <i class="fe fe-award text-warning"></i>
                                        <small class="text-muted d-block mb-2">Seller</small>
                                        <span class="badge bg-success">Verified</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="verify-tile">
                                        <i class="fe fe-star text-warning"></i>
                                        <small class="text-muted d-block mb-2">Featured</small>
                                        <span class="badge bg-primary">Yes</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="card section-card h-100">
                        <div class="card-header d-flex align-items-center gap-2">
                            <span class="icon-chip"><i class="fe fe-bar-chart-2"></i></span>
                            <div>
                                <h4 class="card-title mb-0">Analytics</h4>
                                <small class="text-muted">Store performance</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="stat-tile">
                                        <div class="num">128</div>
                                        <div class="lbl">Products</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-tile">
                                        <div class="num">3,402</div>
                                        <div class="lbl">Sales</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-tile">
                                        <div class="num">$18.4k</div>
                                        <div class="lbl">Revenue</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stat-tile">
                                        <div class="num">9,870</div>
                                        <div class="lbl">Downloads</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="card section-card h-100">
                        <div class="card-header d-flex align-items-center gap-2">
                            <span class="icon-chip"><i class="fe fe-settings"></i></span>
                            <div>
                                <h4 class="card-title mb-0">Quick Actions</h4>
                                <small class="text-muted">Manage your store</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="#" class="btn btn-primary w-100 quick-action-btn">
                                        <i class="fe fe-edit"></i> Edit Profile
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-info w-100 quick-action-btn text-white">
                                        <i class="fe fe-image"></i> Change Logo
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-secondary w-100 quick-action-btn">
                                        <i class="fe fe-camera"></i> Change Banner
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-success w-100 quick-action-btn">
                                        <i class="fe fe-eye"></i> Preview Store
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-warning w-100 quick-action-btn">
                                        <i class="fe fe-package"></i> My Products
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-danger w-100 quick-action-btn">
                                        <i class="fe fe-dollar-sign"></i> Payouts
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection