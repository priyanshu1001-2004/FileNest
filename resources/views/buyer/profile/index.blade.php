@extends('layouts.master')

@section('title', 'Buyer Profile')

@section('content')

<div class="mt-5" id="table-container">
    <div class="row row-sm">
        <div class="col-lg-12">

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <div>
                    <h3 class="mb-1 fw-bold">Buyer Profile</h3>
                    <small class="text-muted">Your personal details and marketplace preferences</small>
                </div>
            </div>

            <div class="card buyer-hero overflow-hidden mb-4">
                <div class="banner-wrap"></div>

                <div class="card-body">
                    <div class="row align-items-end">

                        <div class="col-xl-2 col-lg-3 text-center text-lg-start">
                            <div class="avatar-wrapper"
                                onclick="document.getElementById('buyer-avatar-upload').click();"
                                style="cursor: pointer; display: inline-block;">
                                {{-- @dd($user) --}}

                                <span class="avatar avatar-xxl bradius cover-image preview-avatar-target"
                                    style="width: 110px; height: 110px; 
                   border: 4px solid #fff; 
                   box-shadow: 0 4px 15px rgba(0,0,0,0.15); 
                   display: inline-block; 
                   background-size: cover; 
                   background-position: center; 
                   background-repeat: no-repeat;
                   background-image: url('{{ !empty($user->avatar) ? asset('storage/' . $user->avatar) . '?v=' . time() : asset('assets/images/users/21.jpg') }}');">

                                    <div class="badge rounded-pill avatar-icons bg-primary position-absolute bottom-0 end-0 m-1"
                                        style="z-index: 5;">
                                        <i class="fe fe-edit fs-12 text-white"></i>
                                    </div>
                                </span>

                                <input type="file" name="avatar" id="buyer-avatar-upload"
                                    style="display: none !important;" accept="image/*" class="secure-crop-upload"
                                    data-title="Buyer Avatar Profile"
                                    data-route="{{ route('buyer.profile.update', ['tab_name' => 'avatar_upload']) }}"
                                    data-preview-element=".preview-avatar-target" data-preview-type="background"
                                    data-aspect="1" data-width="400" data-height="400" data-quality="0.8">
                            </div>
                        </div>

                        <div class="col-xl-7 col-lg-6 mt-3 mt-lg-0">
                            <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                                <h2 class="mb-0 fw-bold text-body">{{ $buyer->display_name ?? $user->name ?? 'Setup
                                    Name' }}</h2>

                                @if(!empty($buyer->is_verified) && $buyer->is_verified)
                                <span class="badge bg-success">
                                    <i class="fe fe-check-circle me-1"></i> Verified Buyer
                                </span>
                                @else
                                <span class="badge bg-warning text-dark">
                                    <i class="fe fe-clock me-1"></i> Standard Account
                                </span>
                                @endif
                            </div>

                            <p class="text-muted mb-3">
                                {{ $buyer->bio ?? 'No biography summary added yet. Click edit options below to state
                                your design preference.' }}
                            </p>

                            <div class="d-flex flex-wrap gap-2">
                                <span class="location-chip">
                                    <i class="fe fe-map-pin me-1"></i>
                                    @if(!empty($buyer->city) || !empty($buyer->country))
                                    {{ implode(', ', array_filter([$buyer->city ?? '', $buyer->state ?? '',
                                    $buyer->country ?? ''])) }}
                                    @else
                                    Global Marketplace Citizen
                                    @endif
                                </span>
                                <span class="location-chip">
                                    <i class="fe fe-globe me-1"></i> {{ $buyer->preferred_language ?? 'English' }}
                                </span>
                                <span class="location-chip">
                                    <i class="fe fe-dollar-sign me-1"></i> {{ $buyer->preferred_currency ?? 'USD' }}
                                </span>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-3 mt-3 mt-lg-0 text-lg-end">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#personalDetailsModal">
                                <i class="fe fe-edit"></i> Edit Profile
                            </button>
                            <small class="text-muted d-block mt-2">
                                Member since {{ $user->created_at ? $user->created_at->format('M d, Y') : 'Jul 05, 2026'
                                }}
                            </small>
                        </div>

                    </div>
                </div>
            </div>

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
                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#personalDetailsModal">
                                <i class="fe fe-edit"></i> Edit
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row gy-4">
                                <div class="col-md-4">
                                    <label class="text-muted small mb-1 d-block">Display Name</label>
                                    <h6 id="display-name-val" class="mb-0 fw-semibold text-body">{{ $buyer->display_name
                                        ?? $user->name ?? 'Not Configured' }}</h6>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-muted small mb-1 d-block">Account Email</label>
                                    <h6 id="email-val" class="mb-0 text-body">{{ $user->email ?? 'Not Available' }}</h6>
                                </div>

                                <div class="col-md-4">
                                    <label class="text-muted small mb-1 d-block">Phone Number</label>
                                    <h6 id="phone-val" class="mb-0 text-body">{{ $user->phone ?? 'None Linked' }}</h6>
                                </div>
                               

                                <div class="col-12">
                                    <label class="text-muted small mb-1 d-block">Bio</label>
                                    <p id="bio-val" class="mb-0 text-muted" style="white-space: pre-line;">
                                        {{ $buyer->bio ?? 'No bio framework configured.' }}
                                    </p>
                                </div>

                                <div class="col-md-4">
                                    <label class="text-muted small mb-1 d-block">Country</label>
                                    <h6 id="country-val" class="mb-0 text-body">{{ $buyer->country ?? 'Not Set' }}</h6>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-muted small mb-1 d-block">State</label>
                                    <h6 id="state-val" class="mb-0 text-body">{{ $buyer->state ?? 'Not Set' }}</h6>
                                </div>
                                <div class="col-md-4">
                                    <label class="text-muted small mb-1 d-block">City</label>
                                    <h6 id="city-val" class="mb-0 text-body">{{ $buyer->city ?? 'Not Set' }}</h6>
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
                           
                        </div>
                        <div class="card-body">
                            <div
                                class="pref-row d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom border-dashed">
                                <span class="pref-label text-muted small"><i class="fe fe-globe me-2"></i>Preferred
                                    Language</span>
                                <strong class="small text-body">{{ $buyer->preferred_language ?? 'English' }}</strong>
                            </div>
                            <div
                                class="pref-row d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom border-dashed">
                                <span class="pref-label text-muted small"><i
                                        class="fe fe-dollar-sign me-2"></i>Preferred Currency</span>
                                <strong class="small text-body">{{ $buyer->preferred_currency ?? 'USD' }}</strong>
                            </div>
                            <div
                                class="pref-row d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom border-dashed">
                                <span class="pref-label text-muted small"><i class="fe fe-mail me-2"></i>Newsletter
                                    Updates</span>
                                @if(isset($buyer->newsletter) && $buyer->newsletter)
                                <span class="badge bg-success-soft text-success"><i
                                        class="fe fe-check me-1"></i>Subscribed</span>
                                @else
                                <span class="badge bg-secondary-soft text-muted"><i
                                        class="fe fe-x me-1"></i>Unsubscribed</span>
                                @endif
                            </div>
                            <div class="pref-row d-flex justify-content-between align-items-center">
                                <span class="pref-label text-muted small"><i class="fe fe-shield me-2"></i>Verification
                                    Status</span>
                                @if(!empty($buyer->is_verified) && $buyer->is_verified)
                                <span class="badge bg-success"><i class="fe fe-check me-1"></i>Verified Status</span>
                                @else
                                <span class="badge bg-warning text-dark"><i
                                        class="fe fe-clock me-1"></i>Unverified</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                            <div class="row text-center text-md-start">
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <label class="text-muted small d-block mb-1">Verification Track</label>
                                    @if(!empty($buyer->is_verified) && $buyer->is_verified)
                                    <span class="badge bg-success">Verified Secure</span>
                                    @else
                                    <span class="badge bg-warning text-dark">Standard Access</span>
                                    @endif
                                </div>
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <label class="text-muted small d-block mb-1">Newsletter Channel</label>
                                    <span
                                        class="badge {{ (!isset($buyer->newsletter) || $buyer->newsletter) ? 'bg-success' : 'bg-secondary' }}">
                                        {{ (!isset($buyer->newsletter) || $buyer->newsletter) ? 'Active Sync' :
                                        'Disabled' }}
                                    </span>
                                </div>
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <label class="text-muted small d-block mb-1">Joined Registry</label>
                                    <strong class="small text-body">{{ $user->created_at ? $user->created_at->format('M
                                        d, Y') : 'Jul 05, 2026' }}</strong>
                                </div>
                                <div class="col-md-3">
                                    <label class="text-muted small d-block mb-1">Last Matrix Sync</label>
                                    <strong class="small text-body">{{ $buyer->updated_at ?
                                        $buyer->updated_at->format('M d, Y') : 'Jul 15, 2026' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="personalDetailsModal" tabindex="-1" aria-labelledby="personalDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="profileUpdateForm" 
              action="{{ route('buyer.profile.update') }}" 
              method="POST" 
              class="ajax-form" 
              data-modal="#personalDetailsModal" 
              data-reset="0">
            
            @csrf
            @method('PUT') <input type="hidden" name="tab_name" value="personal_details">
            
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="personalDetailsModalLabel">Edit Personal Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Display Name</label>
                            <input type="text" name="display_name" class="form-control" 
                                   value="{{ $buyer->display_name ?? $user->name }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Account Email</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                            <small class="text-muted">Email cannot be changed.</small>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                        </div>

                       

                        <div class="col-12">
                            <label class="form-label">Bio</label>
                            <textarea name="bio" class="form-control" rows="3">{{ $buyer->bio ?? '' }}</textarea>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" class="form-control" value="{{ $buyer->country ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">State</label>
                            <input type="text" name="state" class="form-control" value="{{ $buyer->state ?? '' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" value="{{ $buyer->city ?? '' }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>



@endsection