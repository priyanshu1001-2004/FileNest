@extends('layouts.master')

@section('title', 'Profile')

@push('styles')
<style>
    .buyer-hero{border-radius:18px; overflow:hidden;}
    .buyer-hero .banner-wrap{
        height:140px;
        background:
            radial-gradient(120% 180% at 0% 0%, #34d399 0%, transparent 60%),
            radial-gradient(120% 180% at 100% 100%, #0ea5e9 0%, transparent 55%),
            linear-gradient(120deg,#059669,#0284c7 70%, #075985);
        position:relative;
    }

    .buyer-avatar{
        width:110px; height:110px; border-radius:50%;
        border:5px solid #fff; margin-top:-55px; background:#fff;
        box-shadow:0 8px 24px -8px rgba(20,20,43,.25);
        object-fit:cover;
    }

    .section-card{border-radius:16px; border:1px solid #edeef5; box-shadow:0 1px 2px rgba(20,20,43,.04), 0 8px 20px -14px rgba(20,20,43,.12);}
    .section-card .card-header{background:transparent; border-bottom:1px solid #f0f1f7; border-radius:16px 16px 0 0 !important;}
    .icon-chip{
        width:36px; height:36px; border-radius:10px;
        background:#eef0fd; color:#4f46e5;
        display:inline-flex; align-items:center; justify-content:center;
    }
    .icon-chip.green{background:#e6f9f0; color:#059669;}

    .pref-row{
        display:flex; align-items:center; justify-content:space-between;
        padding:12px 0; border-bottom:1px solid #f2f3f8;
    }
    .pref-row:last-child{border-bottom:none;}
    .pref-row .pref-label{display:flex; align-items:center; gap:10px; font-size:13.5px; font-weight:500; color:#41465c;}
    .pref-row .pref-label .fe{color:#767e94;}

    .toggle-pill{
        display:inline-flex; align-items:center; gap:6px;
        padding:4px 12px; border-radius:999px; font-size:12px; font-weight:700;
    }
    .toggle-pill.on{background:#e6f9f0; color:#059669;}
    .toggle-pill.off{background:#f1f2f6; color:#8a8fa3;}

    .location-chip{
        display:inline-flex; align-items:center; gap:6px;
        background:#f1f2f6; border-radius:999px; padding:5px 12px; font-size:12.5px; font-weight:600; color:#41465c;
    }
</style>
@endpush

@section('content')

<div class="mt-5" id="data-table-container">
    <div class="row row-sm">
        <div class="col-lg-12">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <div>
                    <h3 class="mb-1 fw-bold">Buyer Profile</h3>
                    <small class="text-muted">Your personal details and marketplace preferences</small>
                </div>
            </div>

            <!-- ============ HERO ============ -->
            <div class="card buyer-hero overflow-hidden mb-4">
                <div class="banner-wrap"></div>

                <div class="card-body">
                    <div class="row align-items-end">

                        <!-- Avatar -->
                        <div class="col-xl-2 col-lg-3 text-center text-lg-start">
                            <img src="https://placehold.co/150x150?text=Avatar" class="buyer-avatar shadow" alt="Avatar">
                        </div>

                        <!-- Details -->
                        <div class="col-xl-7 col-lg-6 mt-3 mt-lg-0">
                            <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                                <h2 class="mb-0 fw-bold">Ravi Sharma</h2>

                                <span class="badge bg-success">
                                    <i class="fe fe-check-circle"></i> Verified
                                </span>
                            </div>

                            <p class="text-muted mb-3">
                                Frontend developer & digital product enthusiast. Always on the lookout for clean UI kits and Laravel starter templates.
                            </p>

                            <div class="d-flex flex-wrap gap-2">
                                <span class="location-chip">
                                    <i class="fe fe-map-pin"></i> Ludhiana, Punjab, India
                                </span>
                                <span class="location-chip">
                                    <i class="fe fe-globe"></i> English
                                </span>
                                <span class="location-chip">
                                    <i class="fe fe-dollar-sign"></i> USD
                                </span>
                            </div>
                        </div>

                        <!-- Edit -->
                        <div class="col-xl-3 col-lg-3 mt-3 mt-lg-0 text-lg-end">
                            <button class="btn btn-primary">
                                <i class="fe fe-edit"></i> Edit Profile
                            </button>
                            <small class="text-muted d-block mt-2">
                                Member since Jul 05, 2026
                            </small>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ============ ROW 1: Personal Details | Preferences ============ -->
            <div class="row row-sm">
                <div class="col-lg-7 mb-4">
                    <div class="card section-card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <span class="icon-chip"><i class="fe fe-user"></i></span>
                                <div>
                                    <h4 class="card-title mb-0">Personal Details</h4>
                                    <small class="text-muted">Basic information about you</small>
                                </div>
                            </div>
                            <button class="btn btn-outline-primary btn-sm"><i class="fe fe-edit"></i> Edit</button>
                        </div>
                        <div class="card-body">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <label class="text-muted small mb-1 d-block">Display Name</label>
                                    <h6 class="mb-0">Ravi Sharma</h6>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small mb-1 d-block">Account Email</label>
                                    <h6 class="mb-0">ravi.sharma@example.com</h6>
                                </div>

                                <div class="col-12">
                                    <label class="text-muted small mb-1 d-block">Bio</label>
                                    <p class="mb-0 text-muted">
                                        Frontend developer & digital product enthusiast. Always on the lookout
                                        for clean UI kits and Laravel starter templates.
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <label class="text-muted small mb-1 d-block">Country</label>
                                    <h6 class="mb-0">India</h6>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-muted small mb-1 d-block">State</label>
                                    <h6 class="mb-0">Punjab</h6>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-muted small mb-1 d-block">City</label>
                                    <h6 class="mb-0">Ludhiana</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 mb-4">
                    <div class="card section-card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <span class="icon-chip green"><i class="fe fe-sliders"></i></span>
                                <div>
                                    <h4 class="card-title mb-0">Preferences</h4>
                                    <small class="text-muted">Language, currency & alerts</small>
                                </div>
                            </div>
                            <button class="btn btn-outline-primary btn-sm"><i class="fe fe-edit"></i> Edit</button>
                        </div>
                        <div class="card-body">
                            <div class="pref-row">
                                <span class="pref-label"><i class="fe fe-globe"></i> Preferred Language</span>
                                <strong class="small">English</strong>
                            </div>
                            <div class="pref-row">
                                <span class="pref-label"><i class="fe fe-dollar-sign"></i> Preferred Currency</span>
                                <strong class="small">USD</strong>
                            </div>
                            <div class="pref-row">
                                <span class="pref-label"><i class="fe fe-mail"></i> Newsletter</span>
                                <span class="toggle-pill on"><i class="fe fe-check"></i> Subscribed</span>
                            </div>
                            <div class="pref-row">
                                <span class="pref-label"><i class="fe fe-shield"></i> Verification Status</span>
                                <span class="badge bg-success">Verified</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============ ROW 2: Account Overview ============ -->
            <div class="row row-sm">
                <div class="col-lg-12 mb-4">
                    <div class="card section-card">
                        <div class="card-header d-flex align-items-center gap-2">
                            <span class="icon-chip"><i class="fe fe-info"></i></span>
                            <div>
                                <h4 class="card-title mb-0">Account Overview</h4>
                                <small class="text-muted">Timeline & status</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <label class="text-muted small d-block mb-1">Verification</label>
                                    <span class="badge bg-success">Verified</span>
                                </div>
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <label class="text-muted small d-block mb-1">Newsletter</label>
                                    <span class="badge bg-success">Subscribed</span>
                                </div>
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <label class="text-muted small d-block mb-1">Joined</label>
                                    <strong class="small">Jul 05, 2026</strong>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-muted small d-block mb-1">Last Updated</label>
                                    <strong class="small">Jul 15, 2026</strong>
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