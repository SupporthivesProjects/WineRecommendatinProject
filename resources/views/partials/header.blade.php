 <!-- app-header -->
 <header class="app-header">
    <!-- Start::main-header-container -->
    <div class="main-header-container container-fluid">

        <!-- Start::header-content-left -->
        <div class="header-content-left">

            <!-- Start::header-element -->
            <div class="header-element">
                <div class="horizontal-logo">
                    <a href="index.html" class="header-logo">
                        <img src="{{ asset('assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
                        <img src="{{ asset('assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
                        <img src="{{ asset('assets/images/brand-logos/desktop-dark.png') }}" alt="logo" class="desktop-dark">
                        <img src="{{ asset('assets/images/brand-logos/toggle-dark.png') }}" alt="logo" class="toggle-dark">
                        <img src="{{ asset('assets/images/brand-logos/desktop-white.png') }}" alt="logo" class="desktop-white">
                        <img src="{{ asset('assets/images/brand-logos/toggle-white.png') }}" alt="logo" class="toggle-white">
                    </a>
                </div>
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="header-element">
                <!-- Start::header-link -->
                <a aria-label="Hide Sidebar" class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle" data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
                <!-- End::header-link -->
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="main-header-center d-none d-lg-block  header-link">
                <div class="input-group">
                    <!-- <div class="input-group-btn search-panel">
                        <select class="js-example-basic-single" name="state" data-trigger>
                            <option value="s-1">Choose one</option>
                            <option value="s-2">T-Projects...</option>
                            <option value="s-3">Microsoft Project</option>
                            <option value="s-4">Risk Management</option>
                            <option value="s-5">Team Building</option>
                        </select>
                    </div> -->
                    <input type="text" class="form-control" id="typehead" placeholder="Search for results..."
                    autocomplete="off">
                <button class="btn btn-primary"><i class="fe fe-search" aria-hidden="true"></i></button>
                </div>
                <div id="headersearch" class="header-search">
                    <div class="p-3">
                        <div class="">
                            <p class="fw-semibold text-muted mb-2 fs-13">Recent Searches</p>
                            <div class="ps-2">
                                <a  href="javascript:void(0)" class="search-tags"><i class="fe fe-search me-2"></i>People<span></span></a>
                                <a  href="javascript:void(0)" class="search-tags"><i class="fe fe-search me-2"></i>Pages<span></span></a>
                                <a  href="javascript:void(0)" class="search-tags"><i class="fe fe-search me-2"></i>Articles<span></span></a>
                            </div>
                        </div>
                         <div class="mt-3">
                            <p class="fw-semibold text-muted mb-2 fs-13">Apps and pages</p>
                            <ul class="ps-2 list-unstyled">
                                <li class="p-1 d-flex align-items-center text-muted mb-2 search-app">
                                    <a href="full-calendar.html"><span><i class='bx bx-calendar me-2 fs-14 bg-primary-transparent p-2 rounded-circle '></i>Calendar</span></a>
                                </li>
                                <li class="p-1 d-flex align-items-center text-muted mb-2 search-app">
                                    <a href="mail-inbox.html"><span><i class='bx bx-envelope me-2 fs-14 bg-primary-transparent p-2 rounded-circle'></i>Mail</span></a>
                                </li>
                                <li class="p-1 d-flex align-items-center text-muted mb-2 search-app">
                                    <a href="buttons.html"><span><i class='bx bx-dice-1 me-2 fs-14 bg-primary-transparent p-2 rounded-circle '></i>Buttons</span></a>
                                </li>
                            </ul>
                        </div>
                        <div class="mt-3">
                           <p class="fw-semibold text-muted mb-2 fs-13">Links</p>
                           <ul class="ps-2 list-unstyled">
                                <li class="p-1 align-items-center text-muted mb-1 search-app">
                                        <a href="javascript:void(0)" class="text-primary"><u>http://spruko/html/spruko.com</u></a>
                                </li>
                                <li class="p-1 align-items-center text-muted mb-1 search-app">
                                        <a href="javascript:void(0)" class="text-primary"><u>http://spruko/demo/spruko.com</u></a>
                                </li>
                            </ul>
                       </div>
                    </div>
                    <div class="py-3 border-top px-0">
                        <div class="text-center">
                            <a href="javascript:void(0)" class="text-primary text-decoration-underline fs-15">View all</a>
                        </div>
                    </div>
                </div>
            </div>
             <!-- End::header-element -->

        </div>
        <!-- End::header-content-left -->

        <!-- Start::header-content-right -->
        <div class="header-content-right">

            <!-- Start::header-element -->
            <div class="header-element header-theme-mode">
                <!-- Start::header-link|layout-setting -->
                <a href="javascript:void(0);" class="header-link layout-setting">
                    <span class="light-layout">
                        <!-- Start::header-link-icon -->
                    <i class="fe fe-moon header-link-icon lh-2"></i>
                        <!-- End::header-link-icon -->
                    </span>
                    <span class="dark-layout">
                        <!-- Start::header-link-icon -->
                    <i class="fe fe-sun header-link-icon lh-2"></i>
                        <!-- End::header-link-icon -->
                    </span>
                </a>
                <!-- End::header-link|layout-setting -->
            </div>
            <!-- End::header-element -->

            

            <!-- Start::header-element -->
            <div class="header-element header-fullscreen  d-xl-flex d-none">
                <!-- Start::header-link -->
                <a onclick="openFullscreen();" href="javascript:void(0);" class="header-link">
                    <i class="fe fe-maximize full-screen-open header-link-icon"></i>
                    <i class="fe fe-minimize full-screen-close header-link-icon d-none"></i>
                </a>
                <!-- End::header-link -->
            </div>
            <!-- End::header-element -->

           
           
            <!-- Start::header-element -->
            <div class="header-element right-sidebar d-xl-flex d-none">
                <a href="javascript:void(0);" class="header-link right-sidebar" data-bs-toggle="offcanvas" data-bs-target="#right-sidebar-canvas">
                    <i class="fe fe-align-right header-icons header-link-icon"></i>
                </a>
            </div>
            <!-- End::header-element -->

            <!-- Start::header-element -->
            <div class="header-element">
                <!-- Start::header-link|switcher-icon -->
                <a href="javascript:void(0);" class="header-link switcher-icon" data-bs-toggle="offcanvas" data-bs-target="#switcher-canvas">
                    <i class="fe fe-settings header-link-icon"></i>
                </a>
                <!-- End::header-link|switcher-icon -->
            </div>
            <!-- End::header-element -->

        </div>
        <!-- End::header-content-right -->

    </div>
    <!-- End::main-header-container -->

</header>
<!-- /app-header -->