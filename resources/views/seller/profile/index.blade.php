@extends('layouts.master')

@section('title', 'Profile')

<style>
    /* ---- Profile Page Layout Setup ---- */
    .seller-hero {
        border-radius: 18px;
        overflow: hidden;
    }

    .seller-hero .banner-wrap {
        height: 190px;
        background:
            radial-gradient(120% 180% at 0% 0%, #6a5ff7 0%, transparent 60%),
            radial-gradient(120% 180% at 100% 100%, #4338ca 0%, transparent 55%),
            linear-gradient(120deg, #4f46e5, #6d28d9 60%, #312e81);
        position: relative;
    }

    .seller-hero .banner-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Fixed: The banner container click area layout setup */
    .banner-edit-zone {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 10;
    }

    .seller-hero .banner-edit-btn {
        background: rgba(255, 255, 255, .18);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255, 255, 255, .4);
        color: #fff;
        cursor: pointer !important;
    }

    .avatar-wrapper {
        position: relative;
        display: inline-block;
        cursor: pointer !important;
    }

    .avatar-wrapper * {
        pointer-events: none;
    }

    .secure-crop-upload {
        pointer-events: auto !important;
    }
</style>

@section('content')

<div class="mt-5" id="table-container">
    <div class="row row-sm">
        <div class="col-lg-12">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <div>
                    <h3 class="mb-1 fw-bold">Seller Profile</h3>
                    <small class="text-muted">Manage how buyers see your store on the marketplace</small>
                </div>
            </div>

            <div class="card seller-hero overflow-hidden mb-4">
                <div class="banner-wrap" style="position: relative; overflow: hidden; cursor: pointer;">
                    <img id="current-store-banner" class="custom-banner-target w-100"
                        src="{{ $seller && $seller->store_banner ? asset('storage/' . $seller->store_banner) : 'https://placehold.co/1600x350?text=Store+Banner' }}"
                        alt="Store Banner"
                        style="height: 250px; object-fit: cover; transition: opacity 0.3s ease; {{ $seller && $seller->store_banner ? 'opacity: 1;' : 'opacity: .18;' }}">

                    <div class="banner-edit-zone" onclick="document.getElementById('banner-upload').click();"
                        style="position: absolute; top: 15px; right: 15px; z-index: 10;">
                        <button type="button" class="btn btn-sm btn-dark opacity-80">
                            <i class="fe fe-camera me-1"></i> Change Banner
                        </button>
                        <input type="file" id="banner-upload" style="display: none !important;" accept="image/*"
                            class="secure-crop-upload" data-title="Store Banner Header"
                            data-route="{{ route('seller.profile.update', ['type' => 'banner']) }}"
                            data-preview-element=".custom-banner-target" data-preview-type="image" data-aspect="2.666"
                            data-width="1200" data-height="450" data-quality="0.7">
                    </div>
                </div>

                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-xl-2 col-lg-3 text-center mb-3 mb-lg-0">
                            <div class="avatar-wrapper" onclick="document.getElementById('image-upload').click();"
                                style="cursor: pointer; display: inline-block;">
                                <span class="avatar avatar-xxl bradius cover-image preview-logo-target"
                                    style="width: 110px; height: 110px; border: 4px solid #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.15); display: inline-block; background-image: url('{{ $seller && $seller->store_logo ? asset('storage/' . $seller->store_logo) : '../assets/images/users/21.jpg' }}'); background-size: cover; background-position: center; position: relative;">
                                    <div class="badge rounded-pill avatar-icons bg-primary position-absolute bottom-0 end-0 m-1"
                                        style="z-index: 5;">
                                        <i class="fe fe-edit fs-12 text-white"></i>
                                    </div>
                                </span>
                                <input type="file" id="image-upload" style="display: none !important;" accept="image/*"
                                    class="secure-crop-upload" data-title="Store Logo Profile"
                                    data-route="{{ route('seller.profile.update', ['type' => 'logo']) }}"
                                    data-preview-element=".preview-logo-target" data-preview-type="background"
                                    data-aspect="1" data-width="400" data-height="400" data-quality="0.8">
                            </div>
                        </div>

                        <div class="col-xl-7 col-lg-6 mt-3 mt-lg-0">
                            <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                                <h2 class="mb-0 fw-bold text-body">{{ $seller->store_name ?? 'Set Your Store Name' }}
                                </h2>

                                @if($seller && $seller->is_verified)
                                <span class="badge bg-success"><i class="fe fe-check-circle me-1"></i> Verified
                                    Seller</span>
                                @else
                                <span class="badge bg-warning text-dark"><i class="fe fe-clock me-1"></i> Under
                                    Review</span>
                                @endif
                            </div>

                            <p class="text-muted mb-3">
                                {{ $seller->store_tagline ?? 'Add a descriptive store tagline or vision benchmark
                                statement using the Edit form below.' }}
                            </p>
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
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#storeInfoModal">
                        <i class="fe fe-edit"></i> Edit
                    </button>
                </div>
                <div class="card-body">
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <label class="text-muted small mb-1 d-block">Store Name</label>
                            <h6 class="mb-0">{{ $seller->store_name ?? 'Not Set' }}</h6>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1 d-block">Store Slug</label>
                            <h6 class="mb-0 text-primary">{{ $seller->store_slug ?? 'not-configured' }}</h6>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1 d-block">Store Tagline</label>
                            <h6 class="mb-0">{{ $seller->store_tagline ?? 'No tagline added yet.' }}</h6>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small mb-1 d-block">Seller Type</label>
                            <span
                                class="badge {{ ($seller->seller_type ?? 'individual') === 'business' ? 'bg-success' : 'bg-primary' }}">
                                {{ ucfirst($seller->seller_type ?? 'individual') }} Seller
                            </span>
                        </div>
                        <div class="col-12">
                            <label class="text-muted small mb-1 d-block">Store Description</label>
                            <p class="mb-0 text-muted">
                                {{ $seller->store_description ?? 'Provide a short summary detailing your digital
                                repository assets.' }}
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
                    @php
                    // Dynamic Profile Completion Counter Engine
                    $totalFields = 10;
                    $filledFields = 0;

                    if(!empty($seller->store_name)) $filledFields++;
                    if(!empty($seller->store_tagline)) $filledFields++;
                    if(!empty($seller->store_description)) $filledFields++;
                    if(!empty($seller->company_name)) $filledFields++;
                    if(!empty($seller->tax_number)) $filledFields++;
                    if(!empty($seller->support_email)) $filledFields++;
                    if(!empty($seller->website)) $filledFields++;
                    if(!empty($seller->github_url) || !empty($seller->linkedin_url)) $filledFields++;
                    if(!empty($seller->support_policy)) $filledFields++;
                    if(!empty($seller->business_address)) $filledFields++;

                    $percentage = min(100, max(20, round(($filledFields / $totalFields) * 100)));
                    @endphp

                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Completion</span>
                        <span class="fw-bold text-primary">{{ $percentage }}%</span>
                    </div>
                    <div class="progress mb-4" style="height:7px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percentage }}%;"
                            aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted small">Verification</span>
                            @if($seller && $seller->is_verified)
                            <span class="badge bg-success"><i class="fe fe-check me-1"></i>Verified</span>
                            @else
                            <span class="badge bg-warning text-dark"><i class="fe fe-clock me-1"></i>Pending</span>
                            @endif
                        </li>
                        <li class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted small">Member Since</span>
                            <strong class="small text-body">
                                {{ $seller && $seller->created_at ? $seller->created_at->format('M d, Y') :
                                now()->format('M d, Y') }}
                            </strong>
                        </li>
                        <li class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">Last Updated</span>
                            <strong class="small text-body">
                                {{ $seller && $seller->updated_at ? $seller->updated_at->format('M d, Y') :
                                now()->format('M d, Y') }}
                            </strong>
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
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#businessInfoModal">
                        <i class="fe fe-edit"></i> Edit
                    </button>
                </div>
                <div class="card-body">
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <label class="text-muted small d-block mb-1">Company Name</label>
                            <div class="fw-semibold">{{ $seller->company_name ?? 'Not Set' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block mb-1">Tax / GST Number</label>
                            <div class="fw-semibold">{{ $seller->tax_number ?? 'Not Provided' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block mb-1">Seller Type</label>
                            <span
                                class="badge {{ ($seller->seller_type ?? 'individual') === 'business' ? 'bg-success' : 'bg-primary' }}">
                                {{ ucfirst($seller->seller_type ?? 'individual') }} Seller
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block mb-1">Verification Status</label>
                            @if($seller && $seller->is_verified)
                            <span class="badge bg-success"><i class="fe fe-check-circle me-1"></i> Verified</span>
                            @else
                            <span class="badge bg-warning text-dark"><i class="fe fe-alert-circle me-1"></i> Pending
                                Verification</span>
                            @endif
                        </div>
                        <div class="col-12">
                            <label class="text-muted small d-block mb-1">Business Address</label>
                            <div class="fw-semibold text-muted" style="white-space: pre-line;">{{
                                $seller->business_address ?? 'No address registered.' }}</div>
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
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#contactInfoModal">
                        <i class="fe fe-edit"></i> Edit
                    </button>
                </div>
                <div class="card-body">
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <label class="text-muted small d-block mb-1">Support Email</label>
                            <div class="fw-semibold">{{ $seller->support_email ?? 'Not Set' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block mb-1">Website</label>
                            @if(!empty($seller->website))
                            <a href="{{ $seller->website }}" target="_blank"
                                class="text-primary fw-semibold d-block text-truncate">{{ parse_url($seller->website,
                                PHP_URL_HOST) ?? $seller->website }}</a>
                            @else
                            <div class="text-muted small fw-semibold">No URL Link</div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small d-block mb-1">Location Details</label>
                            <div class="fw-semibold text-muted">
                                @if(!empty($seller->city) || !empty($seller->country))
                                {{ filter_var(implode(', ', array_filter([$seller->city, $seller->state,
                                $seller->country])), FILTER_DEFAULT) }}
                                @else
                                No Location Set
                                @endif
                            </div>
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
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#storePoliciesModal">
                        <i class="fe fe-edit"></i> Edit
                    </button>
                </div>
                <div class="card-body">
                    <label class="text-muted small d-block mb-2">Support Policy</label>
                    <div class="policy-block mb-3" style="white-space: pre-line;">
                        <i class="fe fe-life-buoy"></i>
                        {{ $seller->support_policy ?? 'We provide professional technical support for all our digital
                        products. Please update this field to outline your support hours and inclusions.' }}
                    </div>

                    <label class="text-muted small d-block mb-2">Refund Policy</label>
                    <div class="policy-block mb-3" style="white-space: pre-line;">
                        <i class="fe fe-rotate-ccw"></i>
                        {{ $seller->refund_policy ?? 'Refund requests are subject to evaluation based on file
                        eligibility. Update this policy to establish terms regarding digital product returns.' }}
                    </div>

                    <label class="text-muted small d-block mb-2">License Information</label>
                    <div class="policy-block" style="white-space: pre-line;">
                        <i class="fe fe-shield"></i>
                        {{ $seller->license_information ?? 'All digital source files are protected by licensing
                        frameworks. Specify your developer terms, multi-use, or deployment constraints here.' }}
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
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#socialLinksModal">
                        <i class="fe fe-edit"></i> Edit
                    </button>
                </div>
                <div class="card-body">

                    <div class="social-item mb-3 d-flex align-items-center gap-3">
                        <span
                            class="social-badge d-inline-flex align-items-center justify-content-center rounded-circle"
                            style="background:#1f2328; width: 36px; height: 36px;"><i
                                class="fe fe-github text-white"></i></span>
                        <div>
                            <small class="text-muted d-block">GitHub</small>
                            @if(!empty($seller->github_url))
                            <a href="{{ $seller->github_url }}" target="_blank"
                                class="text-reset fw-semibold text-break">{{ parse_url($seller->github_url,
                                PHP_URL_PATH) ? 'github.com' . parse_url($seller->github_url, PHP_URL_PATH) :
                                $seller->github_url }}</a>
                            @else
                            <span class="text-muted small fw-normal">Not Linked</span>
                            @endif
                        </div>
                    </div>

                    <div class="social-item mb-3 d-flex align-items-center gap-3">
                        <span
                            class="social-badge d-inline-flex align-items-center justify-content-center rounded-circle"
                            style="background:#ff0000; width: 36px; height: 36px;"><i
                                class="fe fe-youtube text-white"></i></span>
                        <div>
                            <small class="text-muted d-block">YouTube</small>
                            @if(!empty($seller->youtube_url))
                            <a href="{{ $seller->youtube_url }}" target="_blank"
                                class="text-danger fw-semibold text-break">{{ parse_url($seller->youtube_url,
                                PHP_URL_PATH) ? 'youtube.com' . parse_url($seller->youtube_url, PHP_URL_PATH) :
                                $seller->youtube_url }}</a>
                            @else
                            <span class="text-muted small fw-normal">Not Linked</span>
                            @endif
                        </div>
                    </div>

                    <div class="social-item mb-3 d-flex align-items-center gap-3">
                        <span
                            class="social-badge d-inline-flex align-items-center justify-content-center rounded-circle"
                            style="background:#0a66c2; width: 36px; height: 36px;"><i
                                class="fe fe-linkedin text-white"></i></span>
                        <div>
                            <small class="text-muted d-block">LinkedIn</small>
                            @if(!empty($seller->linkedin_url))
                            <a href="{{ $seller->linkedin_url }}" target="_blank"
                                class="text-primary fw-semibold text-break">{{ parse_url($seller->linkedin_url,
                                PHP_URL_PATH) ? 'linkedin.com' . parse_url($seller->linkedin_url, PHP_URL_PATH) :
                                $seller->linkedin_url }}</a>
                            @else
                            <span class="text-muted small fw-normal">Not Linked</span>
                            @endif
                        </div>
                    </div>

                    <div class="social-item mb-3 d-flex align-items-center gap-3">
                        <span
                            class="social-badge d-inline-flex align-items-center justify-content-center rounded-circle"
                            style="background:linear-gradient(135deg,#f58529,#dd2a7b,#8134af); width: 36px; height: 36px;"><i
                                class="fe fe-instagram text-white"></i></span>
                        <div>
                            <small class="text-muted d-block">Instagram</small>
                            @if(!empty($seller->instagram_url))
                            <a href="{{ $seller->instagram_url }}" target="_blank"
                                class="text-danger fw-semibold text-break">{{ parse_url($seller->instagram_url,
                                PHP_URL_PATH) ? '@' . basename(parse_url($seller->instagram_url, PHP_URL_PATH)) :
                                $seller->instagram_url }}</a>
                            @else
                            <span class="text-muted small fw-normal">Not Linked</span>
                            @endif
                        </div>
                    </div>

                    <div class="social-item d-flex align-items-center gap-3">
                        <span
                            class="social-badge d-inline-flex align-items-center justify-content-center rounded-circle"
                            style="background:#1da1f2; width: 36px; height: 36px;"><i
                                class="fe fe-twitter text-white"></i></span>
                        <div>
                            <small class="text-muted d-block">Twitter / X</small>
                            @if(!empty($seller->twitter_url))
                            <a href="{{ $seller->twitter_url }}" target="_blank"
                                class="text-reset fw-semibold text-break">{{ parse_url($seller->twitter_url,
                                PHP_URL_PATH) ? '@' . basename(parse_url($seller->twitter_url, PHP_URL_PATH)) :
                                $seller->twitter_url }}</a>
                            @else
                            <span class="text-muted small fw-normal">Not Linked</span>
                            @endif
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


    <div class="modal fade" id="storeInfoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form class="modal-content bg-body text-body ajax-form" action="{{ route('seller.profile.update') }}"
                method="POST" data-modal="#storeInfoModal">
                @csrf
                @method('PUT')
                <input type="hidden" name="tab_name" value="store_info">

                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold"><i class="fe fe-shopping-bag me-2 text-primary"></i>Store
                        Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Store Name <span class="text-danger">*</span></label>
                            <input type="text" name="store_name" class="form-control"
                                value="{{ $seller->store_name ?? '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Store Tagline</label>
                            <input type="text" name="store_tagline" class="form-control"
                                value="{{ $seller->store_tagline ?? '' }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Store Description</label>
                            <textarea name="store_description" class="form-control"
                                rows="4">{{ $seller->store_description ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Save Profile</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="businessInfoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form class="modal-content bg-body text-body ajax-form" action="{{ route('seller.profile.update') }}"
                method="POST" data-modal="#businessInfoModal">
                @csrf
                @method('PUT')
                <input type="hidden" name="tab_name" value="business_info">

                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">
                        <i class="fe fe-briefcase me-2 text-primary"></i>Modify Business Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Seller Operational Type</label>
                            <select name="seller_type" class="form-select">
                                <option value="individual" {{ ($seller->seller_type ?? 'individual') === 'individual' ?
                                    'selected' : '' }}>Individual Seller</option>
                                <option value="business" {{ ($seller->seller_type ?? '') === 'business' ? 'selected' :
                                    '' }}>Business Entity / Corporation</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Company Name</label>
                            <input type="text" name="company_name" class="form-control"
                                value="{{ $seller->company_name ?? '' }}"
                                placeholder="e.g., PixelCraft Technologies Private Limited">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Tax / GST Identification Number</label>
                            <input type="text" name="tax_number" class="form-control"
                                value="{{ $seller->tax_number ?? '' }}" placeholder="e.g., GSTIN22ABCDE1234F1Z5">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Registered Business Address</label>
                            <textarea name="business_address" class="form-control" rows="4"
                                placeholder="Enter the complete operational layout address details...">{{ $seller->business_address ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Update Details</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="contactInfoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form class="modal-content bg-body text-body ajax-form" action="{{ route('seller.profile.update') }}"
                method="POST" data-modal="#contactInfoModal">
                @csrf
                @method('PUT')
                <input type="hidden" name="tab_name" value="contact_info">

                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">
                        <i class="fe fe-mail me-2 text-primary"></i>Modify Contact Layout
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Support Email <span
                                    class="text-danger">*</span></label>
                            <input type="email" name="support_email" class="form-control"
                                value="{{ $seller->support_email ?? '' }}" required
                                placeholder="e.g., support@yourdomain.com">
                            <div class="invalid-feedback">Please enter a valid support email address.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Website Link</label>
                            <input type="url" name="website" class="form-control" value="{{ $seller->website ?? '' }}"
                                placeholder="https://yourdomain.com">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Country</label>
                            <input type="text" name="country" class="form-control" value="{{ $seller->country ?? '' }}"
                                placeholder="e.g., India">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">State</label>
                            <input type="text" name="state" class="form-control" value="{{ $seller->state ?? '' }}"
                                placeholder="e.g., Delhi">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">City</label>
                            <input type="text" name="city" class="form-control" value="{{ $seller->city ?? '' }}"
                                placeholder="e.g., New Delhi">
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Save Contacts</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="storePoliciesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form class="modal-content bg-body text-body ajax-form" action="{{ route('seller.profile.update') }}"
                method="POST" data-modal="#storePoliciesModal">
                @csrf
                @method('PUT')
                <input type="hidden" name="tab_name" value="store_policies">

                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">
                        <i class="fe fe-file-text me-2 text-primary"></i>Edit Store Guidelines & Policies
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Support Policy</label>
                            <textarea name="support_policy" class="form-control" rows="4"
                                placeholder="Detail your technical support criteria, active channels, and business hour windows...">{{ $seller->support_policy ?? '' }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Refund Policy</label>
                            <textarea name="refund_policy" class="form-control" rows="4"
                                placeholder="Outline clear rules regarding cancellations, change of mind, or defective digital deliverables...">{{ $seller->refund_policy ?? '' }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">License Information</label>
                            <textarea name="license_information" class="form-control" rows="4"
                                placeholder="State restrictions regarding code redistribution, personal versus commercial deployment usage...">{{ $seller->license_information ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Apply Policies</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="socialLinksModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form class="modal-content bg-body text-body ajax-form" action="{{ route('seller.profile.update') }}"
                method="POST" data-modal="#socialLinksModal">
                @csrf
                @method('PUT')
                <input type="hidden" name="tab_name" value="social_links">

                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">
                        <i class="fe fe-link me-2 text-primary"></i>Sync Social Profiles
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">GitHub URL</label>
                            <input type="url" name="github_url" class="form-control"
                                value="{{ $seller->github_url ?? '' }}" placeholder="https://github.com/your-username">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">YouTube Channel URL</label>
                            <input type="url" name="youtube_url" class="form-control"
                                value="{{ $seller->youtube_url ?? '' }}"
                                placeholder="https://youtube.com/@your-channel">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">LinkedIn Profile URL</label>
                            <input type="url" name="linkedin_url" class="form-control"
                                value="{{ $seller->linkedin_url ?? '' }}"
                                placeholder="https://linkedin.com/in/your-username">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Instagram Profile URL</label>
                            <input type="url" name="instagram_url" class="form-control"
                                value="{{ $seller->instagram_url ?? '' }}"
                                placeholder="https://instagram.com/your-username">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Twitter / X URL</label>
                            <input type="url" name="twitter_url" class="form-control"
                                value="{{ $seller->twitter_url ?? '' }}" placeholder="https://x.com/your-username">
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4">Link Profiles</button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection