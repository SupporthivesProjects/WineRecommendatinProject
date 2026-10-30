<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="horizontal" data-nav-style="menu-click" data-menu-position="fixed"
    data-theme-mode="light">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Services - TechSomm Wine Recommender</title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/wine_store_favicon.ico') }}" type="image/x-icon">
    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Style Css -->
    <link href="{{ asset('assets/css/allwinesstyles.css') }}" rel="stylesheet">
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <!-- Node Waves Css -->
    <link href="{{ asset('assets/libs/node-waves/waves.min.css') }}" rel="stylesheet">
    <!-- SwiperJS Css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}">
    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/@simonwep/pickr/themes/nano.min.css') }}">
    <!-- Choices Css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/choices.js/public/assets/styles/choices.min.css') }}">

    <script src="https://unpkg.com/@lottiefiles/lottie-player@2.0.12/dist/lottie-player.js"></script>


    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.css">


    <!-- OLD LINKS START -->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Owl Carousel links -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />


    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Styles -->
    <style>
        .scrollable-filter { max-height: 200px; overflow-y: auto; padding-right: 6px; }
        .scrollable-filter::-webkit-scrollbar { width: 6px; }
        .scrollable-filter::-webkit-scrollbar-thumb { background: #ccc; border-radius: 3px; }
        .app-header .nav-link { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; transition: color 0.3s ease; color: black; font-size: 14px; font-weight: 500!important; }
        .app-header .nav-link:hover { color: #0b5ed7; }
        .app-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            background-color: white;
            
        }
        .app-sidebar {
            position:fixed;
        }
        #header_logo_desktop {
                height: 70px; /* default */
                transition: height 0.6s ease; /* smooth animation */
        }
        /* Ensure text truncation works */
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .mobile_none {
            display: block;
        }
        .desktop_none {
            display: none;
        }
        .fonthover {
            white-space: nowrap;
            color: black;
            position: relative;
            font-size: 0.875rem;
            line-height: 1;
            vertical-align: middle;
        }

        .fonthover:hover {
            white-space: nowrap;
            color: #7f2c2d;
            position: relative;
            font-size: 0.875rem;
            line-height: 1;
            vertical-align: middle;
        }
        @media only screen and (max-width: 768px) {
            .mobile_none {
                display: none;
            }
            .desktop_none {
                display: block;
            }

            .mobo-content-end {
                justify-content: end;
            }

        }        
        .hero-section {
            position: relative;
            height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: white;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.6);
        }

        /* Moving background layer */
        .hero-section .parallax-bg {
            position: absolute;
            top: -20%;
            left: 0;
            width: 100%;
            height: 140%;
            background:
                linear-gradient(
                    rgba(128, 128, 128, 0.4),
                    rgba(128, 128, 128, 0.4)
                ),
                url('/images/services.jpg') center center / cover no-repeat;
            will-change: transform;
            z-index: 0;
        }

        /* Keep the heading above the moving background */
        .hero-section .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-section h1 {
            font-size: 3rem;
        }

        @media (max-width: 768px) {
            .hero-section {
                height: 40vh;
            }

            .hero-section h1 {
                font-size: 2rem;
            }
        }
        @media (max-width: 768px) {
            .sectionone {
                margin-top: 20px;
            }
        }

    </style>

    <!-- Scripts -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- OLD LINKS END -->
    <script>
        if (localStorage.spruhalandingdarktheme) {
            document.querySelector("html").setAttribute("data-theme-mode", "dark")
        }
        if (localStorage.spruhalandingrtl) {
            document.querySelector("html").setAttribute("dir", "rtl")
            document.querySelector("#style")?.setAttribute("href",
                "{{ asset('assets/libs/bootstrap/css/bootstrap.rtl.min.css') }}");
        }
    </script>
</head>
<body class="landing-body">
    <!-- Start Switcher -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="switcher-canvas" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title" id="offcanvasRightLabel">Switcher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="">
                    <p class="switcher-style-head">Theme Color Mode:</p>
                    <div class="row switcher-style">
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-light-theme">
                                    Light
                                </label>
                                <input class="form-check-input" type="radio" name="theme-style" id="switcher-light-theme"
                                    checked>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-dark-theme">
                                    Dark
                                </label>
                                <input class="form-check-input" type="radio" name="theme-style" id="switcher-dark-theme">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <p class="switcher-style-head">Directions:</p>
                    <div class="row switcher-style">
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-ltr">
                                    LTR
                                </label>
                                <input class="form-check-input" type="radio" name="direction" id="switcher-ltr" checked>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check switch-select">
                                <label class="form-check-label" for="switcher-rtl">
                                    RTL
                                </label>
                                <input class="form-check-input" type="radio" name="direction" id="switcher-rtl">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="theme-colors">
                    <p class="switcher-style-head">Theme Primary:</p>
                    <div class="d-flex align-items-center switcher-style">
                        <div class="form-check switch-select me-3">
                            <input class="form-check-input color-input color-primary-1" type="radio"
                                name="theme-primary" id="switcher-primary">
                        </div>
                        <div class="form-check switch-select me-3">
                            <input class="form-check-input color-input color-primary-2" type="radio"
                                name="theme-primary" id="switcher-primary1">
                        </div>
                        <div class="form-check switch-select me-3">
                            <input class="form-check-input color-input color-primary-3" type="radio"
                                name="theme-primary" id="switcher-primary2">
                        </div>
                        <div class="form-check switch-select me-3">
                            <input class="form-check-input color-input color-primary-4" type="radio"
                                name="theme-primary" id="switcher-primary3">
                        </div>
                        <div class="form-check switch-select me-3">
                            <input class="form-check-input color-input color-primary-5" type="radio"
                                name="theme-primary" id="switcher-primary4">
                        </div>
                        <div class="form-check switch-select me-3 ps-0 mt-1 color-primary-light">
                            <div class="theme-container-primary"></div>
                            <div class="pickr-container-primary"></div>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="switcher-style-head">reset:</p>
                    <div class="text-center">
                        <button id="reset-all" class="btn btn-danger mt-3">Reset</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- End Switcher -->

    <div class="landing-page-wrapper">
       <!-- app-header -->
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
        <!-- End::app-sidebar -->
        <!-- Start::app-content -->
        <div class="main-content landing-main" id="home">
            <!-- Section 1: Hero Image -->            
            <section class="hero-section text-center parallax-container">
                <div class="parallax-bg"></div>
                <div class="hero-content">
                    <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">
                        Services
                    </h1>
                </div>
            </section>

            <!-- Section 2: About Text -->
            <section class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <h1 class="mb-4">Our Services</h1>
                        <section class="container py-5">
                            <!-- Section 1 -->
                            <div class="row  mb-5">
                                <div class="col-md-6 order-1 order-md-1">
                                    <h1 class="mb-3 text-primary sectionone">🍷 For Wine Lovers & Consumers</h1>
                                    <ul class="fs-6 fs-md-5">
                                        <li><strong>Personalized Wine Recommendations:</strong> Let your palate lead the way. Our intelligent recommendation system matches you with wines tailored to your taste, mood, and dining preferences.</li>
                                        <li><strong>Browse Wines Across India:</strong>Access the most comprehensive collection of wines available in the Indian market — from globally renowned labels to exciting domestic finds, all in one place.</li>
                                        <li><strong>Wine & Food Pairings:</strong>Unlock harmony in every bite and sip with pairing suggestions that complement your cuisine — from comforting meals to indulgent occasions.</li>
                                        <li><strong>Wine & Cheese Pairings:</strong>Discover the delicate art of matching wines with fine cheeses, creating pairings that celebrate balance, contrast, and indulgence.</li>
                                    </ul>
                                </div>
                                <div class="col-md-6 order-0 order-md-2">
                                    <img src="/images/7662.jpg" class="img-fluid rounded shadow" alt="Wine Lovers">
                                </div>
                            </div>

                            <!-- Section 2 -->
                            <div class="row  mb-5">
                                <div class="col-md-6 order-1 order-md-2">
                                    <h1 class="mb-3 text-success sectionone">🏨 For Hospitality</h1>
                                    <ul class="fs-6 fs-md-5">
                                        <li><strong>Wine List Structuring:</strong>Design profitable, expressive wine menus aligned with your cuisine and guest profile.</li>
                                        <li><strong>On-Demand Wine Support:</strong>Tap into TechSomm’s wine database and future Sommelier Support Hotline SMS service (Save Me Sommelier) for real-time assistance with selections, service, or pairings.</li>
                                        <li><strong>Upcoming:</strong>Regional Wine Guides tailored to local palates and regional cuisine influences.</li>
                                        <li><strong>Wine Concierge Services:</strong> Assist during events or peak service hours.</li>
                                    </ul>
                                </div>
                                <div class="col-md-6 order-0 order-md-1">
                                    <img src="/images/hospitality.jpg" class="img-fluid rounded shadow" alt="Hospitality">
                                </div>
                            </div>

                            <!-- Section 3 -->
                            <div class="row  mb-5">
                                <div class="col-md-6 order-1 order-md-1">
                                    <h1 class="mb-3 text-warning sectionone">🏬 For Retail</h1>
                                    <ul class="fs-6 fs-md-5">
                                        <li><strong>Digital Wine Catalogue:</strong>Access a clean, importer-verified wine database to simplify inventory, staff training, and customer communication.</li>
                                        <li><strong>Wine Discovery Tools for Staff & Shoppers:</strong>Let your customers explore wines through tasting notes, food pairing suggestions, and personal profile-building features.</li>
                                        <li><strong>Upcoming:</strong> Regional style preference mapping for customer-centric curation.</li>
                                        <li><strong>Wine Concierge:</strong>for premium clients and loyalty programs.</li>
                                    </ul>
                                </div>
                                <div class="col-md-6 order-0 order-md-2">
                                    <img src="/images/retail.jpg" class="img-fluid rounded shadow" alt="Retail">
                                </div>
                            </div>

                            <!-- Section 4 -->
                            <div class="row  mb-5">
                                <div class="col-md-6 order-1 order-md-2">
                                <h1 class="mb-3 text-danger sectionone">🍾 For Beverage Industry Professionals</h1>
                                    <ul class="fs-6 fs-md-5"    >
                                        <li><strong>Importer & Distributor Portfolio Integration:</strong>Display your wine portfolio across TechSomm’s platform, directly to retail and hospitality buyers.</li>
                                        <li><strong>Visibility & Reach:</strong>Make your wines searchable, comparable, and accessible to on-trade and off-trade professionals through our discovery tools.</li>
                                        <li><strong>Promotion & Events Support:</strong>Collaborate on thematic tasting events, product launches, and educational experiences and services.</li>
                                    </ul>
                                </div>
                                <div class="col-md-6 order-0 order-md-1">
                                    <img src="/images/professional.jpg" class="img-fluid rounded shadow" alt="Industry Professionals">
                                </div>
                            </div>
                        </section>



                    </div>
                </div>
            </section>
        </div>
        <!-- End::app-content -->
        <!-- Start:: Section-11 -->
        @include('layouts.footer')
        <!-- End:: Section-11 -->
    </div>

    <!-- Back to Top Button -->
    <a href="#home"
        class="fixed bottom-6 right-6 bg-red-700 hover:bg-red-800 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition-all duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </a>
    <div id="responsive-overlay"></div>
    <!-- Popper JS -->
    <script src="{{ asset('assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Color Picker JS -->
    <script src="{{ asset('assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>
    <!-- Choices JS -->
    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <!-- Swiper JS -->
    <script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>
    <!-- Defaultmenu JS -->
    <script src="{{ asset('assets/js/defaultmenu.min.js') }}"></script>
    <!-- Counter JS -->
    <script src="{{ asset('assets/js/counter.js') }}"></script>
    <!-- Internal Landing JS -->
    <script src="{{ asset('assets/js/landing.js') }}"></script>
    <!-- Node Waves JS-->
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <!-- Sticky JS -->
    <script src="{{ asset('assets/js/sticky.js') }}"></script>
    <!-- Optional JavaScript for enhanced functionality -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const yOffset = -50; // Negative value for 50px space from top
                    const y = target.getBoundingClientRect().top + window.pageYOffset + yOffset;

                    window.scrollTo({
                        top: y,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
    <!-- jQuery (required for Owl Carousel) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.3/toastr.min.js"></script>

    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const containers = document.querySelectorAll('.parallax-container');

            function updateParallax() {
                containers.forEach(container => {
                    const bg = container.querySelector('.parallax-bg');
                    if (!bg) return;

                    const rect = container.getBoundingClientRect();

                    if (rect.bottom < 0 || rect.top > window.innerHeight) return;

                    const isMobile = window.innerWidth <= 768;
                    const speed = isMobile ? 0.25 : 0.2;

                    const offset = -rect.top * speed;

                    bg.style.transform = `translate3d(0, ${offset}px, 0)`;
                });
            }

            window.addEventListener('scroll', updateParallax, { passive: true });
            window.addEventListener('resize', updateParallax);

            // Also update when mobile browsers finish loading
            window.addEventListener('load', updateParallax);

            updateParallax();
        });
    </script>    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const logo = document.getElementById("header_logo_desktop");
            const logoTwo = document.getElementById("header_logo_white");

            if (!logo) {
                console.error("Desktop logo element not found.");
                return;
            }

            function updateLogoSize() {
                const height = window.scrollY >= 100 ? "45px" : "70px";

                logo.style.height = height;

                if (logoTwo) {
                    logoTwo.style.height = height;
                }
            }

            window.addEventListener("scroll", updateLogoSize, { passive: true });

            updateLogoSize();
        });
    </script>
</body>
</html>
