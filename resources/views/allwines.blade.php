<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="horizontal" data-nav-style="menu-click" data-menu-position="fixed"
    data-theme-mode="light">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Wine Recommender</title>
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

    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <!-- jquery -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <!-- OLD LINKS START -->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Styles -->
    <style>
        html, body { overflow-x: hidden; }
        #mystyle { font-family: 'Cinzel Decorative', serif; }
        .featured-badge {
            background-color: rgba(165, 9, 8, 0.7);
            color: white;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
        }
        .hero-section {
            height: 100vh;
            background-image: url('{{ asset('images/Browsewines3.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            z-index: 1;
        }

        .hero-text h1 { font-size: 3rem; margin-bottom: 1rem; }

        .wine-card {
            border-radius: 0 !important;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            box-shadow: none;
        }

        .wine-card:hover { box-shadow: 0 10px 30px rgba(0,0,0,0.15); transform: translateY(-4px); }

        .filter-group { margin-bottom: 2rem; }

        .form-check { margin-bottom: 0.75rem; }

        .form-check-input:checked { background-color: #8b0000; border-color: #8b0000; }

        .form-check-label { font-size: 0.95rem; color: #444; }

        .form-check-input:focus { box-shadow: 0 0 0 0.1rem rgba(139, 0, 0, 0.25); }

        .filter-checkbox {
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-radius: 20px;
            user-select: none;
            transition: background-color 0.3s, border-color 0.3s;
            margin-right: 8px;
        }

        input[type="checkbox"].form-check-input:checked + .filter-checkbox {
            background-color: rgba(165, 9, 8, 0.7);
            color: white;
            border-color: white;
        }

        .emoji { font-size: 1.4em; line-height: 1; }

        .wine-type-scroll { overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch; }

        .wine-type-scroll .form-check {
            display: inline-block;
            margin-right: 1rem;
            white-space: nowrap;
            overflow: visible !important;
            max-height: none !important;
        }
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
        .filters-and-cards {
            background: #fff;
            padding: 100px 20px;
            min-height: 100vh;
        }
        .parallax-container {
            position: relative;
            height: 80vh;
            overflow: hidden;
            isolation: isolate;
        }
        .parallax-bg {
            background-image: url('{{ asset('images/BrowseWines3.jpg') }}');
            background-size: cover;
            background-position: center;
            position: absolute;
            top: -25%;
            left: 0;
            width: 100%;
            height: 150%;
            z-index: -1;
            will-change: transform;
        }
        /* Transparent dark overlay */
        .parallax-bg::after {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            pointer-events: none;
        }
        .wine-type-scroll { overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch; }
        .wine-card {
            position: relative;
            overflow: hidden;
        }
        .hover-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.65);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            z-index: 10;
        }
        .wine-card:hover .hover-overlay {
            opacity: 1;
        }
        .overlay-btn {
            padding: 12px 20px;
            font-size: 1rem;
        }
        #header_logo_desktop {
                height: 70px; /* default */
                transition: height 0.6s ease; /* smooth animation */
            }
        .wine-bg {
                background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1506377247377-2a5b3b417ebb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
                background-size: cover;
                background-position: center;
                transition: background-image 1s ease-in-out, opacity 1s ease-in-out;
                position: relative;
                z-index: 1;
                opacity: 1;
        }

        .wine-card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .wine-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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

    </style>

    

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
                                    <!-- <a href="{{ route('register') }}" class="btn btn-wave btn-secondary">
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
                <!-- Hero Section -->
                <section class="parallax-container">
                    <div class="parallax-bg"></div>
                    <div class="hero-text my-3" style="text-align: right;max-width: 390px;color: white;position: absolute;
                    right: 95px;top: 50%;transform: translateY(-50%);">
                        <h1 class="text-white" id="mystyle">Explore Our Finest Wines</h1>
                        <p>Curated selections for every occasion</p>
                        <a type="button" class="btn btn-dark" href="#products">Explore</a>
                    </div>
                </section>



                <!-- Filters & Cards Section -->
                <section class="filters-and-cards" id="products">
                    <div class="container my-5">
                        <div class="row g-2">
                            <!-- Filter Sidebar -->
                            <div class="col-12 col-md-3 d-none d-md-block bg-light rounded rounded-2 p-4 align-self-start">
                                <!-- Vintage Year Filter -->
                                <div class="filter-group">
                                    <h4 class="fw-bold mb-4">Vintage Year</h4>
                                    <div class="vintage-year-filter-container">
                                        @foreach ($vintageYears->take(6) as $year)
                                            @if ($year)
                                                <div class="form-check">
                                                    <input class="form-check-input wine-vintage-year-filter" type="checkbox" value="{{ $year }}" id="vintage-year-{{ $year }}">
                                                    <label class="form-check-label" for="vintage-year-{{ $year }}">{{ $year }}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    @if ($vintageYears->count() > 6)
                                        <div class="vintage-year-filter-more d-none">
                                            @foreach ($vintageYears->skip(6) as $year)
                                                @if ($year)
                                                    <div class="form-check">
                                                        <input class="form-check-input wine-vintage-year-filter" type="checkbox" value="{{ $year }}" id="vintage-year-{{ $year }}">
                                                        <label class="form-check-label" for="vintage-year-{{ $year }}">{{ $year }}</label>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn btn-sm btn-link p-0 mt-2 toggle-vintage-year-filter" data-more-text="Show More" data-less-text="Show Less">
                                            Show More
                                        </button>
                                    @endif
                                </div>

                                <!-- Country Filter -->
                                <div class="filter-group">
                                    <h4 class="fw-bold mb-4">Country</h4>
                                    @php
                                        $countries = $allProducts->pluck('country')->filter()->unique()->sort();
                                    @endphp
                                    <div class="country-filter-container">
                                        @foreach ($countries->take(6) as $country)
                                            @php
                                                $lowerCountry = strtolower($country);
                                                $emoji = match ($lowerCountry) {
                                                    'france' => '🇫🇷', 'italy' => '🇮🇹', 'spain' => '🇪🇸', 'australia' => '🇦🇺',
                                                    'united states' => '🇺🇸', 'germany' => '🇩🇪', 'new zealand' => '🇳🇿', 'bulgaria' => '🇧🇬',
                                                    default => '🌍',
                                                };
                                            @endphp
                                            <div class="form-check">
                                                <input class="form-check-input wine-country-filter" type="checkbox" value="{{ $lowerCountry }}" id="country-{{ Str::slug($country) }}">
                                                <label class="form-check-label" for="country-{{ Str::slug($country) }}">
                                                    <span class="emoji">{{ $emoji }}</span> {{ ucfirst($country) }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if ($countries->count() > 6)
                                        <div class="country-filter-more d-none">
                                            @foreach ($countries->skip(6) as $country)
                                                @php
                                                    $lowerCountry = strtolower($country);
                                                    $emoji = match ($lowerCountry) {
                                                        'france' => '🇫🇷', 'italy' => '🇮🇹', 'spain' => '🇪🇸', 'australia' => '🇦🇺',
                                                        'united states' => '🇺🇸', 'germany' => '🇩🇪', 'new zealand' => '🇳🇿', 'bulgaria' => '🇧🇬',
                                                        default => '🌍',
                                                    };
                                                @endphp
                                                <div class="form-check">
                                                    <input class="form-check-input wine-country-filter" type="checkbox" value="{{ $lowerCountry }}" id="country-{{ Str::slug($country) }}">
                                                    <label class="form-check-label" for="country-{{ Str::slug($country) }}">
                                                        <span class="emoji">{{ $emoji }}</span> {{ ucfirst($country) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn btn-sm btn-link p-0 mt-2 toggle-country-filter" data-more-text="Show More" data-less-text="Show Less">
                                            Show More
                                        </button>
                                    @endif
                                </div>

                                <!-- Retail Price Slider -->
                                <div class="filter-group">
                                    <h4 class="fw-bold mb-4">Retail Price</h4>
                                    <p>
                                        <span id="price-range-label">₹ &nbsp;<span id="price-min"></span> - ₹ &nbsp;<span id="max-price"></span></span>
                                    </p>
                                    <div id="price-slider" style="margin-top: 10px;"></div>
                                </div>
                            </div>

                            <!-- Products Grid -->
                            <div class="col-12 col-md-9 rounded rounded-2 p-3">
                                <div class="row mb-4">
                                    <div class="col-12 mb-3">
                                        <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
                                            <div class="d-flex flex-wrap gap-2">
                                                <button class="btn btn-outline-dark filter-btn active" data-filter="all">All Wines</button>
                                                <button class="btn btn-outline-dark filter-btn" data-filter="featured"><i class="fas fa-star"></i> Featured Wines</button>
                                            </div>
                                            <div class="ms-auto">
                                                <div class="input-group">
                                                    <input type="text" id="search-input" class="form-control" placeholder="Search wines..." style="border: black 1px solid;border-radius: 4px 0 0 4px;">
                                                    <button class="btn btn-outline-secondary" type="button" id="search-button"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Type & Method Filters -->
                                    <div class="col-12 col-lg-6 mb-3 filter-group wine-type-scroll">
                                        <h4 class="fw-bold mb-3">Types</h4>
                                        @php
                                        $types = $allProducts
                                        ->pluck('type')
                                        ->map(fn($type) => ucfirst(strtolower(trim($type))))
                                        ->unique()
                                        ->sort()
                                        ->values();
                                        @endphp
                                        @foreach ($types as $type)
                                            @if ($type)
                                                @php
                                                    $lowerType = strtolower($type);
                                                    $emoji = match ($lowerType) {
                                                        'red' => '🍷', 
                                                        'white' => '<i class="fas fa-wine-glass text-warning" title="White Wine"></i>', 
                                                        'sparkling' => '✨', 
                                                        'rosé' => '🌸', 
                                                        'dessert' => '🍯', 
                                                        'bordeaux' => '🏰',
                                                        default => '🍾',
                                                    };
                                                @endphp
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input wine-type-filter" type="checkbox" value="{{ $lowerType }}" id="type-inline-{{ $lowerType }}" style="display:none;">
                                                    <label class="form-check-label fs-15 filter-checkbox" for="type-inline-{{ $lowerType }}">
                                                        <span class="emoji">{!! $emoji !!}
                                                        </span> {{ ucfirst($type) }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <div class="col-12 col-lg-6 mb-3 filter-group wine-type-scroll">
                                        <h4 class="fw-bold mb-3">Method</h4>
                                        <!-- @php
                                            $allowedMethods = ['still', 'semi sparkling', 'sparkling'];
                                            $methods = $allProducts->pluck('Method')->unique()->sort()
                                                ->map(fn($m) => strtolower(trim($m)))
                                                ->filter(fn($m) => in_array($m, $allowedMethods))
                                                ->values();
                                        @endphp -->
                                        @php
                                            $allowedMethods = ['still', 'semi sparkling', 'sparkling'];

                                            $methods = $allProducts->pluck('Method')
                                                ->map(fn($m) => strtolower(trim($m)))   // normalize first
                                                ->filter(fn($m) => in_array($m, $allowedMethods))
                                                ->unique()                              // then remove duplicates
                                                ->sort()
                                                ->values();
                                        @endphp
                                        @foreach ($methods as $method)
                                            @php
                                                $emoji = match ($method) {
                                                    'still' => '🍷', 'semi sparkling' => '🥂', 'sparkling' => '🍾',
                                                    default => '🌍',
                                                };
                                            @endphp
                                            <input type="checkbox" class="form-check-input wine-method-filter" value="{{ $method }}" id="method-inline-{{ $method }}" style="display:none;">
                                            <button type="button" class="form-check-label fs-15 filter-checkbox" data-method="{{ $method }}">
                                                <span class="emoji">{{ $emoji }}</span> {{ ucfirst($method) }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Products Container -->
                                <div class="row row-sm" id="products-container">
                                    @if (isset($products) && $products->count() > 0)
                                        @include('partials.product_cards', ['products' => $products])
                                    @else
                                        <div class="col-12 text-center py-5">
                                            <p class="text-muted">No products found.</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Pagination -->
                                @if (isset($products) && $products->hasPages())
                                    <div class="pagination-container">
                                        @if (!request()->ajax())
                                            {{ $products->links() }}
                                        @endif
                                    </div>
                                @endif
                            </div>
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
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

        <!-- jQuery UI CSS and JS (provides the slider) -->
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

            @include("partials/commonjs")

        <!-- JSVector Maps JS -->
        <script src="{{ asset('assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>    

        <!-- JSVector Maps MapsJS -->
        <script src="{{ asset('assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

        <!-- Apex Charts JS -->
        <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>


        <!-- Custom JS -->
        <script src="{{ asset('assets/js/custom.js') }}"></script>


        <!-- Toastr JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <script>
            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @endif
            @if (session('error'))
                toastr.error("{{ session('error') }}");
            @endif
        </script>
        <script>
            // Add loading overlay HTML
            const loadingOverlay = `
                <style>
                    @keyframes spin {
                        0% { transform: translate(-50%, -50%) rotate(0deg); }
                        100% { transform: translate(-50%, -50%) rotate(360deg); }
                    }
                    #loading-overlay {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(255, 255, 255, 0.8);
                        z-index: 9999;
                        display: none;
                        justify-content: center;
                        align-items: center;
                        margin: 0;
                        padding: 0;
                    }
                    .spinner-border {
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        width: 3rem;
                        height: 3rem;
                        border: 0.25em solid currentColor;
                        border-right-color: transparent;
                        border-radius: 50%;
                        animation: 0.75s linear infinite spin;
                        color: #8b0000; /* Wine red color to match your theme */
                    }
                </style>
                <div id="loading-overlay">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `;
            $('body').append(loadingOverlay);

            $(document).ready(function() {
                // Initialize price slider if it exists
                if ($("#price-slider").length) {
                    const prices = @json($allProducts->pluck('retail_price')->filter()->sort()->values());
                    const min = Math.floor(Math.min(...prices)) || 0;
                    const max = Math.ceil(Math.max(...prices)) || 1000;

                    $("#price-slider").slider({
                        range: true,
                        min: min,
                        max: max,
                        step: 1,
                        values: [min, max],
                        slide: function(event, ui) {
                            $("#price-min").text(ui.values[0]);
                            $("#max-price").text(ui.values[1]);
                            // Only load products when user stops sliding for 300ms
                            clearTimeout(window.sliderTimeout);
                            window.sliderTimeout = setTimeout(loadProducts, 300);
                        }
                    });

                    // Initialize labels
                    $("#price-min").text(min);
                    $("#max-price").text(max);
                }

                // Debounce function to prevent rapid AJAX calls
                function debounce(func, wait) {
                    let timeout;
                    return function executedFunction(...args) {
                        const later = () => {
                            clearTimeout(timeout);
                            func(...args);
                        };
                        clearTimeout(timeout);
                        timeout = setTimeout(later, wait);
                    };
                }

                // Handle all filter changes with debouncing
                $('input[type="checkbox"], select').on('change', debounce(loadProducts, 300));

                // Function to update pagination
                function updatePagination(paginationData) {
                    if (!paginationData || !paginationData.links) {
                        $('.pagination-container').html('');
                        return;
                    }

                    // Create new pagination with the same structure as PHP
                    let paginationHtml = `
                        <div class="d-flex justify-content-center my-4">
                            <nav aria-label="Page navigation">
                                <ul class="pagination mb-0">
                    `;

                    // Add previous button
                    if (paginationData.prev_page_url) {
                        paginationHtml += `
                            <li class="page-item">
                                <a class="page-link" href="#" data-page="${paginationData.current_page - 1}" rel="prev">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>
                        `;
                    } else {
                        paginationHtml += `
                            <li class="page-item disabled">
                                <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                            </li>
                        `;
                    }

                    // Add page numbers
                    if (paginationData.last_page > 1) {
                        const maxPagesToShow = 5; // Maximum number of page numbers to show
                        let startPage, endPage;

                        if (paginationData.last_page <= maxPagesToShow) {
                            // Less than max pages so show all
                            startPage = 1;
                            endPage = paginationData.last_page;
                        } else {
                            // More than max pages so calculate start and end pages
                            const maxPagesBeforeCurrent = Math.floor(maxPagesToShow / 2);
                            const maxPagesAfterCurrent = Math.ceil(maxPagesToShow / 2) - 1;

                            if (paginationData.current_page <= maxPagesBeforeCurrent) {
                                // Near the start
                                startPage = 1;
                                endPage = maxPagesToShow;
                            } else if (paginationData.current_page + maxPagesAfterCurrent >= paginationData.last_page) {
                                // Near the end
                                startPage = paginationData.last_page - maxPagesToShow + 1;
                                endPage = paginationData.last_page;
                            } else {
                                // Somewhere in the middle
                                startPage = paginationData.current_page - maxPagesBeforeCurrent;
                                endPage = paginationData.current_page + maxPagesAfterCurrent;
                            }
                        }

                        // Add first page and ellipsis if needed
                        if (startPage > 1) {
                            paginationHtml += `
                                <li class="page-item">
                                    <a class="page-link" href="#" data-page="1">1</a>
                                </li>
                            `;
                            if (startPage > 2) {
                                paginationHtml += `
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                `;
                            }
                        }

                        // Add page numbers
                        for (let i = startPage; i <= endPage; i++) {
                            if (i === paginationData.current_page) {
                                paginationHtml += `
                                    <li class="page-item active">
                                        <span class="page-link">${i}</span>
                                    </li>
                                `;
                            } else {
                                paginationHtml += `
                                    <li class="page-item">
                                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                                    </li>
                                `;
                            }
                        }

                        // Add last page and ellipsis if needed
                        if (endPage < paginationData.last_page) {
                            if (endPage < paginationData.last_page - 1) {
                                paginationHtml += `
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                `;
                            }
                            paginationHtml += `
                                <li class="page-item">
                                    <a class="page-link" href="#" data-page="${paginationData.last_page}">${paginationData.last_page}</a>
                                </li>
                            `;
                        }
                    }

                    // Add next button
                    if (paginationData.next_page_url) {
                        paginationHtml += `
                            <li class="page-item">
                                <a class="page-link" href="#" data-page="${paginationData.current_page + 1}" rel="next">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        `;
                    } else {
                        paginationHtml += `
                            <li class="page-item disabled">
                                <span class="page-link"><i class="bi bi-chevron-right"></i></span>
                            </li>
                        `;
                    }

                    paginationHtml += `
                                </ul>
                            </nav>
                        </div>
                    `;

                    // Update the pagination container
                    $('.pagination-container').html(paginationHtml);

                    // Add click handlers for pagination links
                    $('.pagination').on('click', 'a[data-page]', function(e) {
                        e.preventDefault();
                        const page = $(this).data('page');
                        loadProducts(page);
                        // Scroll to top of products container
                        $('html, body').animate({
                            scrollTop: $('#products-container').offset().top - 100
                        }, 500);
                    });
                }

                // Function to show loading state
                function showLoading() {
                    $('#loading-overlay').fadeIn(200);
                }

                // Function to hide loading state
                function hideLoading() {
                    $('#loading-overlay').fadeOut(200);
                }

                // Function to load products via AJAX
                function loadProducts(page = 1) {
                    // Show loading state
                    showLoading();

                    // Create a plain object to store form data
                    const formData = {};

                    // Check if featured filter is active
                    if ($('.filter-btn[data-filter="featured"]').hasClass('active')) {
                        formData['featured'] = 'true';
                    }

                    // Get all checked vintage year checkboxes
                    const vintageYears = [];
                    $('.wine-vintage-year-filter:checked').each(function() {
                        vintageYears.push($(this).val());
                    });
                    if (vintageYears.length > 0) {
                        formData['vintage_year'] = vintageYears;
                    }

                    // Get all checked winery checkboxes
                    const wineries = [];
                    $('.wine-winery-filter:checked').each(function() {
                        wineries.push($(this).val());
                    });
                    if (wineries.length > 0) {
                        formData['winery'] = wineries;
                    }

                    // Get all checked type checkboxes
                    const types = [];
                    $('.wine-type-filter:checked').each(function() {
                        types.push($(this).val());
                    });
                    if (types.length > 0) {
                        formData['type'] = types;
                    }

                    // Get all checked country checkboxes
                    const countries = [];
                    $('.wine-country-filter:checked').each(function() {
                        countries.push($(this).val());
                    });
                    if (countries.length > 0) {
                        formData['country'] = countries;
                    }
                
                    // Get all checked method checkboxes
                    const methods = [];
                    $('.wine-method-filter:checked').each(function() {
                        methods.push($(this).val());
                    });
                    if (methods.length > 0) {
                        formData['Method'] = methods; // Matches your DB column name exactly
                    }


                    // Get price range from slider if it exists
                    if ($("#price-slider").length) {
                        const priceRange = $("#price-slider").slider("values");
                        formData['min_price'] = priceRange[0];
                        formData['max_price'] = priceRange[1];
                    }

                    // Add search term if exists
                    const searchTerm = $('#search-input').val().trim();
                    if (searchTerm) {
                        formData['search'] = searchTerm;
                    }

                    // Add page number
                    formData['page'] = page;

                    // Make AJAX request
                    $.ajax({
                        url: '{{ route('homeBrowseWines') }}',
                        type: 'GET',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response && response.success) {
                                // Update products
                                if (response.html) {
                                    $('#products-container').html(response.html);
                                }

                                // Update pagination
                                if (response.pagination) {
                                    updatePagination(response.pagination);
                                } else if (response.links) {
                                    // Fallback to simple pagination update if full pagination data isn't available
                                    $('.pagination-container').html(
                                        `<div class="d-flex justify-content-center my-4">${response.links}</div>`
                                    );
                                }

                                // Update URL without page reload
                                if (history.pushState) {
                                    const newUrl = window.location.protocol + '//' +
                                        window.location.host +
                                        window.location.pathname +
                                        '?' + $.param(formData);
                                    window.history.pushState({
                                        path: newUrl
                                    }, '', newUrl);
                                }

                                // Update product count if it exists in the response
                                if (response.count !== undefined) {
                                    $('#product-count').text(response.count);
                                }
                            } else {
                                console.error('Invalid response format:', response);
                                alert('Invalid response from server. Please try again.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', {
                                status: status,
                                error: error,
                                response: xhr.responseText
                            });

                            let errorMessage =
                                'An error occurred while loading products. Please try again.';
                            try {
                                const response = JSON.parse(xhr.responseText);
                                errorMessage = response.message || errorMessage;
                            } catch (e) {
                                console.error('Error parsing error response:', e);
                            }
                            alert(errorMessage);
                        },
                        complete: function() {
                            hideLoading();
                        }
                    });
                }

                // Handle search input and button
                let searchTimeout;
                
                // Function to handle search
                function performSearch() {
                    const searchTerm = $('#search-input').val().trim();
                    loadProducts(1); // Reset to first page when searching
                }

                // Search button click handler
                $('#search-button').on('click', function() {
                    performSearch();
                });

                // Search on Enter key press
                $('#search-input').on('keyup', function(e) {
                    if (e.key === 'Enter') {
                        performSearch();
                    } else {
                        // Debounce the search to avoid too many requests
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(performSearch, 500);
                    }
                });

                // Handle filter button clicks
                $('.filter-btn').on('click', function() {
                    $('.filter-btn').removeClass('active');
                    $(this).addClass('active');
                    loadProducts(1); // Reset to first page when changing filters
                });

                // Initial load with any URL parameters
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.toString()) {
                    // Check if we have any filter parameters
                    const hasFilters = Array.from(urlParams.keys()).some(key =>
                        key === 'type[]' ||
                        key === 'vintage_year[]' ||
                        key === 'winery[]' ||
                        key === 'country[]' ||
                        key === 'method[]' ||
                        key === 'min_price' ||
                        key === 'max_price'
                    );

                    // Set search input from URL if exists
                    // Set search input if present in URL
            if (urlParams.has('search')) {
                $('#search-input').val(urlParams.get('search'));
            }

            if (hasFilters) {
                // Set checkboxes based on URL parameters
                urlParams.forEach((value, key) => {
                    if (key.endsWith('[]')) {
                        const name = key.replace('[]', '');
                        let checkboxes = [];

                        switch (name.toLowerCase()) {
                            case 'type':
                                checkboxes = document.querySelectorAll(`input.wine-type-filter[value="${value}"]`);
                                break;
                            case 'vintage_year':
                                checkboxes = document.querySelectorAll(`input.wine-vintage-year-filter[value="${value}"]`);
                                break;
                            case 'winery':
                                checkboxes = document.querySelectorAll(`input.wine-winery-filter[value="${value}"]`);
                                break;
                            case 'country':
                                checkboxes = document.querySelectorAll(`input.wine-country-filter[value="${value}"]`);
                                break;
                            case 'method': // Method filter
                                checkboxes = document.querySelectorAll(`input.wine-method-filter[value="${value}"]`);
                                break;
                        }

                        checkboxes.forEach(cb => cb.checked = true);
                    } else if (key === 'min_price' || key === 'max_price') {
                        // Handle price range
                        if ($("#price-slider").length) {
                            const currentValues = $("#price-slider").slider("values");
                            if (key === 'min_price') {
                                currentValues[0] = parseInt(value) || 0;
                                $("#price-min").text(currentValues[0]);
                            } else {
                                currentValues[1] = parseInt(value) || 1000;
                                $("#max-price").text(currentValues[1]);
                            }
                            $("#price-slider").slider("values", currentValues);
                        }
                    }
                });

                // Load products with filters
                loadProducts();
            } }


                // Initialize pagination on page load if there are products
                @if (isset($products) && $products->total() > 0)
                    updatePagination({!! $products->toJson() !!});
                @endif
            });

            // Toggle vintage year filter visibility
            $(document).on('click', '.toggle-vintage-year-filter', function() {
                const $button = $(this);
                const $moreContent = $button.siblings('.vintage-year-filter-more');
                const moreText = $button.data('more-text');
                const lessText = $button.data('less-text');

                $moreContent.toggleClass('d-none');
                $button.text($moreContent.hasClass('d-none') ? moreText : lessText);
            });

            // Toggle winery filter visibility
            $(document).on('click', '.toggle-winery-filter', function() {
                const $button = $(this);
                const $moreContent = $button.siblings('.winery-filter-more');
                const moreText = $button.data('more-text');
                const lessText = $button.data('less-text');

                $moreContent.toggleClass('d-none');
                $button.text($moreContent.hasClass('d-none') ? moreText : lessText);
            });

            // Toggle country filter visibility (newly added)

            $(document).on('click', '.toggle-country-filter', function() {
                const $button = $(this);
                const $moreContent = $button.siblings('.country-filter-more');
                const moreText = $button.data('more-text');
                const lessText = $button.data('less-text');

                $moreContent.toggleClass('d-none');
                $button.text($moreContent.hasClass('d-none') ? moreText : lessText);
            });
            //Toggle checkbox manually if you want to keep them hidden
            $(document).on('click', '.filter-checkbox', function() {
                const input = $(this).prev('input.wine-method-filter');
                if (input.length) {
                    input.prop('checked', !input.prop('checked')).trigger('change');
                }
            });
        // When user clicks the button instead of checkbox
            $(document).on('click', '.method-filter-btn', function () {
                const method = $(this).data('method');
                const checkbox = $(`.wine-method-filter[value="${method}"]`);

                // Toggle checked state
                const isChecked = !checkbox.prop('checked');
                checkbox.prop('checked', isChecked).trigger('change');

                // Toggle button active state visually
                $(this).toggleClass('active', isChecked);
            });

        </script>
        <script>
            document.addEventListener("scroll", () => {
                const logo = document.getElementById("header_logo_desktop");
                const logotwo = document.getElementById("header_logo_white");
                const section2 = document.querySelector("#products"); // change to your section 2 id
                const section2Top = section2.offsetTop;
                if (window.scrollY >= 100) 
                {
                    logo.style.height = "45px"; // shrink
                    logotwo.style.height="45px";
                } else {
                    logo.style.height = "70px"; // expand back
                    logotwo.style.height="70px";
                }


            });
        </script>
    <!-- parallax script -->
     <script>
        document.addEventListener('DOMContentLoaded', function () {
            const containers = document.querySelectorAll('.parallax-container');

            
        function updateParallax() {
            containers.forEach(container => {
                const bg = container.querySelector('.parallax-bg');

                if (!bg) return;

                const rect = container.getBoundingClientRect();

                if (rect.bottom < 0 || rect.top > window.innerHeight) return;

                const isMobile = window.innerWidth <= 767;
                const speed = isMobile ? 0.1 : 0.3;

                const offset = (window.innerHeight - rect.top) * speed;

                bg.style.transform = `translateY(${offset}px)`;
            });
        }


            window.addEventListener('scroll', updateParallax, { passive: true });
            window.addEventListener('resize', updateParallax);

            updateParallax();
        });

     </script>
    
    </body>
</html>
