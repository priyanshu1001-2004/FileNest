<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header">
            <a class="header-brand1" href="index.html">
                <img src="../assets/images/brand/flogo.png" class="header-brand-img desktop-logo" alt="logo">
                <img src="../assets/images/brand/hlogo.png" class="header-brand-img toggle-logo" alt="logo">
                <img src="../assets/images/brand/black-hlogo.png" class="header-brand-img light-logo" alt="logo">
                <img src="../assets/images/brand/black-flogo.png" class="header-brand-img light-logo1" alt="logo">
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

                <!-- ========== PROFILE SECTION ========== -->
                <li class="sub-category">
                    <h3>Profile</h3>
                </li>

                @if(auth()->user()->isAdmin())
                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}"
                        href="{{ route('admin.users.index') }}">
                        <i class="side-menu__icon fe fe-user"></i>
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
                        <i class="side-menu__icon fe fe-box"></i>
                        <span class="side-menu__label">Products</span>
                    </a>
                </li>
                @endif

                @if(auth()->user()->isSeller())

                <li class="slide">
                    <a class="side-menu__item {{ request()->routeIs('seller.products.*') ? 'active' : '' }}"
                        href="{{ route('seller.products.index') }}">
                        <i class="side-menu__icon fe fe-box"></i>
                        <span class="side-menu__label">Products</span>
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