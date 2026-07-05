<!-- app-Header -->
<div class="app-header header sticky">
    <div class="container-fluid main-container">
        <div class="d-flex">
            <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar"
                href="javascript:void(0)"></a>
            <!-- sidebar-toggle-->
            <a class="logo-horizontal " href="#">
                <img src="{{ asset('assets/images/brand/hlogo.png') }}" class="header-brand-img desktop-logo h-20 w-20"
                    alt="logo">
                <img src="{{ asset('assets/images/brand/black-hlogo.png') }}"
                    class="header-brand-img light-logo1 h-25 w-25" alt="logo">
            </a>
            <!-- LOGO -->

            <div class="d-flex order-lg-2 ms-auto header-right-icons">
                <div class="dropdown d-none">
                    <a href="javascript:void(0)" class="nav-link icon" data-bs-toggle="dropdown">
                        <i class="fe fe-search"></i>
                    </a>
                    <div class="dropdown-menu header-search dropdown-menu-start">
                        <div class="input-group w-100 p-2">
                            <input type="text" class="form-control" placeholder="Search....">
                            <div class="input-group-text btn btn-primary">
                                <i class="fe fe-search" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- SEARCH -->
                <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
                    aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon fe fe-more-vertical"></span>
                </button>
                <div class="navbar navbar-collapse responsive-navbar p-0">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <div class="d-flex order-lg-2">
                            <div class="dropdown d-lg-none d-flex">
                                <a href="javascript:void(0)" class="nav-link icon" data-bs-toggle="dropdown">
                                    <i class="fe fe-search"></i>
                                </a>
                                <div class="dropdown-menu header-search dropdown-menu-start">
                                    <div class="input-group w-100 p-2">
                                        <input type="text" class="form-control" placeholder="Search....">
                                        <div class="input-group-text btn btn-primary">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex country">
                                <a class="nav-link icon theme-layout nav-link-bg layout-setting">
                                    <span class="dark-layout"><i class="fe fe-moon"></i></span>
                                    <span class="light-layout"><i class="fe fe-sun"></i></span>
                                </a>
                            </div>
                            <!-- Theme-Layout -->

                            <!-- CART -->
                            <div class="dropdown d-flex">
                                <a class="nav-link icon full-screen-link nav-link-bg">
                                    <i class="fe fe-minimize fullscreen-button"></i>
                                </a>
                            </div>
                            <!-- FULL-SCREEN -->

                            <div class="dropdown d-flex profile-1">
                                <a href="javascript:void(0)" data-bs-toggle="dropdown"
                                    class="nav-link leading-none d-flex">
                                    <img src="../assets/images/users/21.jpg" alt="profile-user"
                                        class="avatar  profile-user brround cover-image">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <div class="drop-heading">
                                        <div class="text-center">
                                            <h5 class="text-dark mb-0 fs-14 fw-semibold">Percy Kewshun</h5>
                                            <small class="text-muted">Senior Admin</small>
                                        </div>
                                    </div>
                                    <div class="dropdown-divider m-0"></div>

                                    @if(auth()->user()->role == 0)
                                    <a class="dropdown-item" href="{{ route('admin.profile.show') }}">
                                        <i class="dropdown-icon fe fe-user"></i> Profile
                                    </a>
                                    @elseif(auth()->user()->role == 1)
                                    <a class="dropdown-item" href="{{ route('seller.profile.index') }}">
                                        <i class="dropdown-icon fe fe-user"></i> Profile
                                    </a>
                                    @elseif(auth()->user()->role == 2)
                                    <a class="dropdown-item" href="{{ route('buyer.profile.index') }}">
                                        <i class="dropdown-icon fe fe-user"></i> Profile
                                    </a>
                                    @endif

                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                            <i class="dropdown-icon fe fe-alert-circle"></i> Sign out
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /app-Header -->