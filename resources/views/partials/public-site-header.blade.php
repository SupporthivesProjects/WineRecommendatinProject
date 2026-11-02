{{-- Header and navigation of the public Services and About pages (logo shrink on scroll: script in each page) --}}
        <header class="app-header">
            <!-- Start::main-header-container -->
            <div class="main-header-container container-fluid">
                <!-- Start::header-content-left -->
                <div class="header-content-left">
                    <!-- Start::header-element -->
                    <div class="header-element">
                        <div class="horizontal-logo">
                            <a href="/" class="header-logo">
                                <img src="{{ asset('images/logoredwhite.jpg') }}" alt="logo"
                                    class="toggle-logo header_desktop_logo" >
                                <!-- <img src="{{ asset('assets/images/brand-logos/toggle-white.png') }}" alt="logo" class="toggle-logo"> -->
                                <img src="{{ asset('images/logoredwhite.jpg') }}" alt="logo"
                                    class="toggle-dark header_desktop_logo">
                            </a>
                        </div>
                    </div>
                    <!-- End::header-element -->


                </div>
                <!-- End::header-content-left -->

                <!-- Start::header-content-right -->
                <div class="header-content-right">
                
                    <!-- Start::header-element -->
                    <div class="header-element">
                        <!-- Start::header-link -->
                        <a href="javascript:void(0);" class="sidemenu-toggle header-link" data-bs-toggle="sidebar">
                            <span class="open-toggle">
                                <i class="ri-menu-3-line fs-20"></i>
                            </span>
                        </a>
                        <!-- End::header-link -->
                    </div>
                    <!-- End::header-element -->
                </div>
                <!-- End::header-content-right -->

            </div>
            <!-- End::main-header-container -->
        </header>
        <!-- /app-header -->

        <!-- Start::app-sidebar -->
        <aside class="app-sidebar" id="sidebar" style="background-color:white;">
            <div class="container p-0">
                <!-- Start::main-sidebar -->
                <div class="main-sidebar pt-0">
                    <div class="desktop_none">
                        <div class="header-element p-3 d-flex justify-content-end">
                            <!-- Start::header-link -->
                            <a href="javascript:void(0);" class="sidemenu-toggle-close header-link" data-bs-toggle="sidebar">
                                <span class="open-toggle">
                                    <i class="ri-menu-3-line fs-20"></i>
                                </span>
                            </a>
                            <!-- End::header-link -->
                        </div>
                    </div>
                    <!-- Start::nav -->
                    <nav class="main-menu-container nav nav-pills sub-open mobo-content-end">
                        <div class="landing-logo-container">
                            <div class="horizontal-logo">
                                <!-- <lottie-player src="{{ asset('Lottie/Animation - 1745878648192.json') }}"
                                    background="transparent" speed="1" style="width: 40px; height: 40px;" loop
                                    autoplay>
                                </lottie-player> -->
                                <a href="/" class="header-logo">
                                    <img src="{{ asset('images/logoredwhite.jpg') }}" alt="logo"
                                        class="desktop-logo" id="header_logo_desktop">
                                    <img src="{{ asset('images/logoredwhite.jpg') }}" alt="logo"
                                        class="desktop-white" id="header_logo_white">
                                </a>
                            </div>
                        </div>
                        <div class="slide-left" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg"
                                fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                            </svg></div>
                        <ul class="main-menu justify-content-end" style="margin-left:auto!important;">
                            <!-- Start::slide -->
                            <li class="slide">
                                <a class="side-menu__item p-3 justify-content-end" href="{{ route('home') }}">
                                    <span class="fonthover">Home</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="{{ route('home') }}#HIW" class="side-menu__item p-3 justify-content-end">
                                    <span class="fonthover">How It Works</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="{{ route('home') }}#featuredwines" class="side-menu__item p-3 justify-content-end">
                                    <span class="fonthover">Browse Wines</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="{{ route('home') }}#pairing" class="side-menu__item p-3 justify-content-end">
                                    <span class="fonthover">Pairing Wines</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="{{ route('home') }}#testimonials" class="side-menu__item p-3 justify-content-end">
                                    <span class="fonthover">What our users say</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="{{ route('home') }}#Moments" class="side-menu__item p-3 justify-content-end">
                                    <span class="fonthover">Moments</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="{{ route('contact') }}" class="side-menu__item p-3 justify-content-end">
                                    <span class="fonthover">Contact Us</span>
                                </a>
                            </li>
                            <li class="slide desktop_none">
                                <a href="{{ route('login') }}" class="side-menu__item p-3 justify-content-end">
                                    <span class="fonthover">Login</span>
                                </a>
                            </li>
                            <!-- End::slide -->

                        </ul>
                        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg"
                                fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z">
                                </path>
                            </svg></div>
                        <div class="d-lg-flex d-none">
                            <div class="btn-list d-lg-flex d-none mt-lg-2 mt-xl-0 mt-0">
                                <!-- <a href="#" class="btn btn-wave btn-secondary">
                                    New User
                                </a> -->
                                <a href="{{ route('login') }}" class="btn btn-wave btn-info">
                                    Login
                                </a>
                            </div>
                        </div>
                    </nav>
                    <!-- End::nav -->
                </div>
                <!-- End::main-sidebar -->
            </div>
        </aside>
