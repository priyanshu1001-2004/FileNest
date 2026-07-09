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

<div class="mt-5" id="data-table-container">
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

                    <div class="banner-edit-zone" onclick="document.getElementById('banner-upload').click();" style="position: absolute; top: 15px; right: 15px; z-index: 10;">
                        <button type="button" class="btn btn-sm btn-dark opacity-80">
                            <i class="fe fe-camera me-1"></i> Change Banner
                        </button>
                        <input type="file" id="banner-upload" style="display: none !important;" accept="image/*"
                               class="secure-crop-upload"
                               data-title="Store Banner Header"
                               data-route="{{ route('seller.profile.update', ['type' => 'banner']) }}"
                               data-preview-element=".custom-banner-target"
                               data-preview-type="image"
                               data-aspect="2.666" 
                               data-width="1200"
                               data-height="450"
                               data-quality="0.7">
                    </div>
                </div>

                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-xl-2 col-lg-3 text-center mb-3 mb-lg-0">
                            <div class="avatar-wrapper" onclick="document.getElementById('image-upload').click();" style="cursor: pointer; display: inline-block;">
                                <span class="avatar avatar-xxl bradius cover-image preview-logo-target"
                                    style="width: 110px; height: 110px; border: 4px solid #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.15); display: inline-block; background-image: url('{{ $seller && $seller->store_logo ? asset('storage/' . $seller->store_logo) : '../assets/images/users/21.jpg' }}'); background-size: cover; background-position: center; position: relative;">
                                    <div class="badge rounded-pill avatar-icons bg-primary position-absolute bottom-0 end-0 m-1" style="z-index: 5;">
                                        <i class="fe fe-edit fs-12 text-white"></i>
                                    </div>
                                </span>
                                <input type="file" id="image-upload" style="display: none !important;" accept="image/*"
                                       class="secure-crop-upload"
                                       data-title="Store Logo Profile"
                                       data-route="{{ route('seller.profile.update', ['type' => 'logo']) }}"
                                       data-preview-element=".preview-logo-target"
                                       data-preview-type="background"
                                       data-aspect="1" 
                                       data-width="400"
                                       data-height="400"
                                       data-quality="0.8">
                            </div>
                        </div>

                        <div class="col-xl-7 col-lg-6 mt-3 mt-lg-0">
                            <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
                                <h2 class="mb-0 fw-bold">PixelCraft Studio</h2>
                                <span class="badge bg-success"><i class="fe fe-check-circle"></i> Verified Seller</span>
                            </div>
                            <p class="text-muted mb-3">Premium Laravel Projects, UI Kits, Templates & Digital Assets.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection