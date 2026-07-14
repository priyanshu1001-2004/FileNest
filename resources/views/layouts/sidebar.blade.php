<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header">
            <a class="header-brand1" href="{{ route('dashboard') }}">
                <img src="{{ asset('assets/images/brand/flogo.png') }}" class="header-brand-img desktop-logo" alt="logo">
                <img src="{{ asset('assets/images/brand/hlogo.png') }}" class="header-brand-img toggle-logo" alt="logo">
                <img src="{{ asset('assets/images/brand/black-hlogo.png') }}" class="header-brand-img light-logo" alt="logo">
                <img src="{{ asset('assets/images/brand/black-flogo.png') }}" class="header-brand-img light-logo1" alt="logo">
            </a>
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg>
            </div>

            <ul class="side-menu">
                <!-- ========== MAIN SECTION ========== -->
                <li class="sub-category">
                    <h3>Main</h3>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <i class="side-menu__icon fe fe-home"></i>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>

                <!-- ========== ADMIN MENU ========== -->
                @if(auth()->user()->isAdmin())
                    <li class="sub-category">
                        <h3>Management</h3>
                    </li>
                    
                    <li class="slide">
                        <a class="side-menu__item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}"
                            href="{{ route('admin.users.index') }}">
                            <i class="side-menu__icon fe fe-users"></i>
                            <span class="side-menu__label">Users</span>
                        </a>
                    </li>

                    <li class="slide">
                        <a class="side-menu__item {{ request()->routeIs('admin.sellers.*') ? 'active' : '' }}"
                            href="{{ route('admin.sellers.index') }}">
                            <i class="side-menu__icon fe fe-shield"></i>
                            <span class="side-menu__label">Sellers</span>
                        </a>
                    </li>

                    <li class="slide">
                        <a class="side-menu__item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                            href="{{ route('admin.categories.index') }}">
                            <i class="side-menu__icon fe fe-folder"></i>
                            <span class="side-menu__label">Categories</span>
                        </a>
                    </li>

                    <li class="slide">
                        <a class="side-menu__item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                            href="{{ route('admin.products.index') }}">
                            <i class="side-menu__icon fe fe-shopping-bag"></i>
                            <span class="side-menu__label">Products</span>
                        </a>
                    </li>
                @endif

                <!-- ========== SELLER MENU ========== -->
                @if(auth()->user()->isSeller())
                    @php
                        $sellerDetail = auth()->user()->sellerDetail;
                        $isVerified = $sellerDetail && $sellerDetail->is_verified;
                    @endphp

                    <li class="sub-category">
                        <h3>My Store</h3>
                    </li>
                   
                    @if($isVerified)
                        <li class="slide">
                            <a class="side-menu__item {{ request()->routeIs('seller.products.*') ? 'active' : '' }}"
                                href="{{ route('seller.products.index') }}">
                                <i class="side-menu__icon fe fe-shopping-bag"></i>
                                <span class="side-menu__label">My Products</span>
                            </a>
                        </li>
                    @else
                        <li class="slide">
                            <a class="side-menu__item" href="#">
                                <i class="side-menu__icon fe fe-clock"></i>
                                <span class="side-menu__label">Awaiting Approval</span>
                                <span class="badge bg-warning ms-auto">⏳</span>
                            </a>
                        </li>
                    @endif
                @endif

                <!-- ========== BUYER MENU ========== -->
                @if(auth()->user()->isBuyer())
                    <li class="sub-category">
                        <h3>My Account</h3>
                    </li>

                    <li class="slide">
                        <a class="side-menu__item {{ request()->routeIs('buyer.orders.*') ? 'active' : '' }}"
                            href="{{ route('buyer.orders.index') }}">
                            <i class="side-menu__icon fe fe-shopping-cart"></i>
                            <span class="side-menu__label">My Orders</span>
                        </a>
                    </li>

                    <li class="slide">
                        <a class="side-menu__item {{ request()->routeIs('buyer.wishlist.*') ? 'active' : '' }}"
                            href="{{ route('buyer.wishlist.index') }}">
                            <i class="side-menu__icon fe fe-heart"></i>
                            <span class="side-menu__label">Wishlist</span>
                        </a>
                    </li>

                    <li class="slide">
                        <a class="side-menu__item {{ request()->routeIs('buyer.downloads.*') ? 'active' : '' }}"
                            href="{{ route('buyer.downloads.index') }}">
                            <i class="side-menu__icon fe fe-download"></i>
                            <span class="side-menu__label">My Downloads</span>
                        </a>
                    </li>
                @endif

              
            </ul>

            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg>
            </div>
        </div>
    </div>
</div>