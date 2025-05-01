<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">
    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="#" class="header-logo">
            <h6 class="text-white">Welcome ! {{ Auth::user()->first_name }}</h6>
        </a>
    </div>
    <!-- End::main-sidebar-header -->

    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">
        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>

            <ul class="main-menu">
                @if(Auth::user()->role === 'admin')
                    <!-- Admin sidebar links -->
                    <li class="slide">
                        <a href="{{ route('admin.dashboard') }}" class="side-menu__item">
                            <i class="side-menu__icon fe fe-home"></i>
                            <span class="side-menu__label">Dashboard</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('admin.products.index') }}" class="side-menu__item">
                            <i class="side-menu__icon fe fe-box"></i>
                            <span class="side-menu__label">Products</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('admin.stores.index') }}" class="side-menu__item">
                            <i class="side-menu__icon fe fe-shopping-cart"></i>
                            <span class="side-menu__label">Stores</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('admin.users.index') }}" class="side-menu__item">
                            <i class="side-menu__icon fe fe-users"></i>
                            <span class="side-menu__label">Users</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('admin.questionnaires.index') }}" class="side-menu__item">
                            <i class="side-menu__icon fe fe-edit"></i>
                            <span class="side-menu__label">Questionnaires</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('admin.settings.index') }}" class="side-menu__item">
                            <i class="side-menu__icon fe fe-settings"></i>
                            <span class="side-menu__label">Settings</span>
                        </a>
                    </li>
                @elseif(Auth::user()->role === 'store_manager')
                    <!-- Store Manager sidebar links -->
                    <li class="slide">
                        <a href="{{ route('store-manager.dashboard') }}" class="side-menu__item">
                            <i class="side-menu__icon fe fe-home"></i>
                            <span class="side-menu__label">Dashboard</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('store-manager.products') }}" class="side-menu__item">
                            <i class="side-menu__icon fe fe-box"></i>
                            <span class="side-menu__label">Store Products</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('store-manager.featuredproducts') }}" class="side-menu__item">
                            <i class="side-menu__icon fe fe-star"></i>
                            <span class="side-menu__label">Featured Products</span>
                        </a>
                    </li>
                @elseif(Auth::user()->role === 'user')
                    <li class="slide">
                        <a href="{{ route('user.dashboard') }}" class="side-menu__item">
                            <i class="side-menu__icon fe fe-home"></i>
                            <span class="side-menu__label">Dashboard</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="" class="side-menu__item">
                            <i class="side-menu__icon fe fe-box"></i>
                            <span class="side-menu__label">Questionnaires</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('user.products') }}" class="side-menu__item">
                            <i class="side-menu__icon fe fe-star"></i>
                            <span class="side-menu__label">Browse Wines</span>
                        </a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('user.featuredproducts') }}" class="side-menu__item">
                            <i class="side-menu__icon fe fe-star"></i>
                            <span class="side-menu__label">Featured Products</span>
                        </a>
                    </li>

                @endif
            </ul>
            <!-- End::ul.main-menu -->

            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg>
            </div>

        </nav>
        <!-- End::nav -->
    </div>
    <!-- End::main-sidebar -->
</aside>
<!-- End::app-sidebar -->