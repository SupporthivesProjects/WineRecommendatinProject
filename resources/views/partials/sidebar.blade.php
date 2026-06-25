<style>
    /* Sidebar hover text color change */
    .side-menu__item:hover .side-menu__label {
        color: var(--primary-color) !important;
    }
    .admin-scroll {
        max-height: calc(100vh - 120px);
        overflow-y: auto;
        scrollbar-width: thin;
    }

    .admin-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .admin-scroll::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: 10px;
    }
</style>

@if(Auth::check() && (
    Auth::user()->role === 'admin' || 
    Auth::user()->role === 'store_manager' || 
    Auth::user()->role === 'main_manager'
))
    <!-- Start::app-sidebar -->
    <aside class="app-sidebar sticky" id="sidebar" style="transition: all 1s ease;">
        <!-- Start::main-sidebar-header -->
        <div class="main-sidebar-header" style="position: unset;transition: all 1s ease;">
            <div style="display: flex;flex-direction: column;justify-content: flex-start;align-items: center;gap: 16px;">
                <img id="dash-logo" src="{{ asset('images/logofullwhite.png') }}" style="max-width: 90px;transition: max-width 1s ease;" class="mx-auto">
                <a href="#" class="header-logo" id="admin-name" style="opacity: 1;transition: opacity 1s ease;">
                    <h6 class="text-white">Welcome ! {{ ucfirst(Auth::user()->first_name) }}</h6>
                </a>
            </div>
        </div>
        <!-- End::main-sidebar-header -->

        <!-- Start::main-sidebar -->
        <!-- <div class="main-sidebar mt-0" id="sidebar-scroll"> -->
        <div class="main-sidebar mt-0 {{ Auth::user()->role === 'admin' ? 'admin-scroll' : '' }}" id="sidebar-scroll">
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
                                <i class="side-menu__icon fe fe-home" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Dashboard</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.products.index') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-droplet" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Wine Products</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.cheese-products.index') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-box" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Cheese Products</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.testimonials.index') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-message-square" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Testimonials</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.reviews.index') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-star" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Reviews</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.stores.index') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-shopping-cart" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Stores</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.users.index') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-users" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Users</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.main_manager') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-users" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Store Parent</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.questionnaires.index') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-edit" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Questionnaires</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.questionnaires.images') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-edit" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Questionnaire Images</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.invoice.uploads') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-settings" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Invoices</span>
                            </a>
                        </li>
                        <!-- <li class="slide">
                            <a href="{{ route('admin.api.master.data') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-settings" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">API Product Master</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.api.stock.data') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-settings" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">API Product Stock</span>
                            </a>
                        </li> -->
                        <li class="slide">
                            <a href="{{ route('admin.templates.index') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-file-text" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Templates</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.features.index') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-layers" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Features</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.users.loginhistory') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-clock" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">User Login History</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('admin.api.documentation') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-clock" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">API Documentation</span>
                            </a>
                        </li>
                        





   
                        {{--
                        <li class="slide">
                            <a href="{{ route('admin.settings.index') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-settings" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Settings</span>
                            </a>
                        </li>--}}
                    @elseif(Auth::user()->role === 'store_manager')
                        <!-- Store Manager sidebar links -->
                        <li class="slide">
                            <a href="{{ route('store-manager.dashboard') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-home" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Dashboard</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('store-manager.products') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-droplet" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Wine Products</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('store-manager.cheese-products.index') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-box" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Cheese Products</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('store-manager.checkouts') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-shopping-cart" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Checkouts</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('store-manager.uploads') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-shopping-cart" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Uploads</span>
                            </a>
                        </li>
                    @elseif(Auth::user()->role === 'main_manager')
                        <!-- Main Manager sidebar links -->
                        <li class="slide">
                            <a href="{{ route('main-manager.dashboard') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-home" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Dashboard</span>
                            </a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('main-manager.allStores') }}" class="side-menu__item">
                                <i class="side-menu__icon fe fe-box" style="color:var(--primary-color);"></i>
                                <span class="side-menu__label">Stores</span>
                            </a>
                        </li>
                    @endif
                </ul>

                <div class="slide-right" id="slide-right">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                    </svg>
                </div>
            </nav>
        </div>
        <!-- End::main-sidebar -->
    </aside>
    <!-- End::app-sidebar -->
@endif
