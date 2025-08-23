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
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">
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


    <!-- OLD LINKS START -->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Owl Carousel links -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.6.0/dist/css/glide.core.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.6.0/dist/css/glide.theme.min.css">


    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Styles -->
    <style>
        footer {
            margin-left: 150px;
            /* same as your sidebar width */
            width: calc(100% - 250px);
            /* to prevent horizontal scroll */
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
    </style>
    <style>
        /* Add these styles to your existing style tag */
        .wine-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .wine-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
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

        /* Ensure images maintain aspect ratio */
        .card-img-container {
            height: 250px;
            overflow: hidden;
        }

        .card-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .card-img-container:hover img {
            transform: scale(1.05);
        }

        /* Ensure consistent card height in the carousel */
        .glide__slide {
            height: auto;
            padding: 0 10px;
        }

        /* Featured badge styling */
        .featured-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background-color: #dc2626;
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            z-index: 10;
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
                            <a href="#" class="header-logo">
                                <img src="{{ asset('images/logoredwhite.jpg') }}" alt="logo"
                                    class="toggle-logo">
                                <!-- <img src="{{ asset('assets/images/brand-logos/toggle-white.png') }}" alt="logo" class="toggle-logo"> -->
                                <img src="{{ asset('images/logoredwhite.jpg') }}" alt="logo"
                                    class="toggle-dark">
                            </a>
                        </div>
                    </div>
                    <!-- End::header-element -->

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
                <!-- End::header-content-left -->

                <!-- Start::header-content-right -->
                <div class="header-content-right">
                    <!-- Start::header-element -->
                    <div class="header-element align-items-center">
                        <!-- Start::header-link|switcher-icon -->
                        <div class="btn-list d-lg-none d-block">
                            <a href="signup.html" class="btn btn-primary-light">
                                New User
                            </a>
                            <a href="signin.html" class="btn btn-primary-light">
                                Login
                            </a>
                        </div>
                        <!-- End::header-link|switcher-icon -->
                    </div>
                    <!-- End::header-element -->

                </div>
                <!-- End::header-content-right -->

            </div>
            <!-- End::main-header-container -->
        </header>
        <!-- /app-header -->

        <!-- Start::app-sidebar -->
        <aside class="app-sidebar sticky" id="sidebar" style="background-color:white;">
            <div class="container p-0">
                <!-- Start::main-sidebar -->
                <div class="main-sidebar">
                    <!-- Start::nav -->
                    <nav class="main-menu-container nav nav-pills sub-open">
                        <div class="landing-logo-container">
                            <div class="horizontal-logo">
                                <!-- <lottie-player src="{{ asset('Lottie/Animation - 1745878648192.json') }}"
                                    background="transparent" speed="1" style="width: 40px; height: 40px;" loop
                                    autoplay>
                                </lottie-player> -->
                                <a href="#" class="header-logo">
                                    <img src="{{ asset('images/logoredwhite.jpg') }}" alt="logo"
                                        class="desktop-logo">
                                    <img src="{{ asset('images/logoredwhite.jpg') }}" alt="logo"
                                        class="desktop-white">
                                </a>
                            </div>
                        </div>
                        <div class="slide-left" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg"
                                fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                            </svg></div>
                        <ul class="main-menu">
                            <!-- Start::slide -->
                            <li class="slide">
                                <a class="side-menu__item" href="#home">
                                    <span class="fonthover">Home</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#HIW" class="side-menu__item">
                                    <span class="fonthover">How It Works</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#featuredwines" class="side-menu__item">
                                    <span class="fonthover">Browse Wines</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#pairing" class="side-menu__item">
                                    <span class="fonthover">Pairing Wines</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#testimonials" class="side-menu__item">
                                    <span class="fonthover">What our users say</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#Moments" class="side-menu__item">
                                    <span class="fonthover">Moments</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="{{ route('contact') }}" class="">
                                    <span class="">Contact Us</span>
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
                                <a href="{{ route('register') }}" class="btn btn-wave btn-secondary">
                                    New User
                                </a>
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
            <!-- Start:: Section-1 Hero Section STARTS -->
            <div class="wine-bg min-h-screen flex flex-col" id="landing-bg">
                <!-- Hero Content -->
                <div class="flex-grow flex items-center justify-center">
                    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                        <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">Discover Your Perfect Wine</h1>
                        <p class="text-xl text-gray-200 mb-10 max-w-3xl mx-auto">
                            Our intelligent recommendation system helps you find the perfect wine for any occasion,
                            based on
                            your taste preferences and food pairings...
                        </p>
                        <div class="flex flex-col sm:flex-row justify-center gap-4">
                            <a href="#featuredwines"
                                class="bg-red-700 hover:bg-red-800 text-white px-8 py-3 rounded-md text-lg font-medium transition">
                                Explore Wines
                            </a>
                            <a href="#HIW"
                                class="bg-white/10 hover:bg-white/20 text-white border border-white/20 px-8 py-3 rounded-md text-lg font-medium transition backdrop-blur-sm">
                                How It Works
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- HERO SECTION ENDS -->
            <!-- End:: Section-1 -->

            <!-- Start:: Section-2 -->
            <section class="section hor-content main_features" id="HIW" style="padding:0px">
                <!-- How It Works Section -->
                <div class="py-16 bg-gray-50">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2 text-center">How TechSomm Works</h2>
                        <p class="text-gray-600 mb-12 text-center max-w-3xl mx-auto">
                            Advanced algorithms guided by sommelier insight curate wines that reflect your palate, your
                            mood, and the magic of every occasion.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Step 1 -->
                            <div class="text-center">
                                <div
                                    class="bg-red-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-700"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Create Your Profile</h3>
                                <p class="text-gray-600">
                                    Create your Profile, Get personal recommendations and Discover N Enjoy stay the
                                    same.
                                </p>
                            </div>

                            <!-- Step 2 -->
                            <div class="text-center">
                                <div
                                    class="bg-red-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-700"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Get Personalized Recommendations</h3>
                                <p class="text-gray-600">
                                    Our algorithm analyzes your preferences and suggests wines that match your unique
                                    taste profile.
                                </p>
                            </div>

                            <!-- Step 3 -->
                            <div class="text-center">
                                <div
                                    class="bg-red-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-700"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Discover & Enjoy</h3>
                                <p class="text-gray-600">
                                    Explore your recommendations, rate wines you try, add your personal tasting notes
                                    for all the wines and refine your profile for even better suggestion and matches.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-2 -->

            <!-- Start:: Section-3 Featured Wines Section-->
            <div class="py-16" id="featuredwines">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2 text-center">Featured Wines</h2>
                    <p class="text-gray-600 mb-12 text-center max-w-3xl mx-auto">
                        Handpicked selections from our sommeliers. Discover exceptional wines from around the world.
                    </p>

                    @if (isset($featuredProducts) && count($featuredProducts) > 0)
                        <div class="glide featured-wines-carousel">
                            <div class="glide__track" data-glide-el="track">
                                <ul class="glide__slides">
                                    @foreach ($featuredProducts as $product)
                                        <li class="glide__slide">
                                            <div
                                                class="wine-card bg-white rounded-lg overflow-hidden shadow-md flex flex-col h-[500px] relative">
                                                {{-- @if ($product->image1)
                                                    <img src="{{ asset('storage/' . $product->image1) }}"
                                                        alt="{{ $product->wine_name }}"
                                                        class="w-full h-60 object-cover">
                                                @else
                                                    <img src="https://images.unsplash.com/photo-1551024601-bec78aea704c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                                        alt="{{ $product->wine_name }}"
                                                        class="w-full h-60 object-cover">
                                                @endif --}}
                                               
                                                <div class="h-[250px] overflow-hidden">
                                                    <img src="{{ asset('storage/' . $product->image1) }}"
                                                        class="w-full h-full object-contain transition-transform duration-300 hover:scale-105"
                                                        alt="{{ $product->wine_name }}">
                                                </div>

                                                <!-- Featured badge on the image -->
                                                @if ($product->is_featured == 1)
                                                    <span
                                                        class="absolute top-4 right-4 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                                        Featured
                                                    </span>
                                                @endif
                                                <div class="p-6 flex flex-col flex-grow">
                                                    <div class="flex justify-between items-start mb-2">
                                                        <h3 class="text-xl font-bold text-gray-900 line-clamp-2"
                                                            title="{{ $product->wine_name }}">
                                                            {{ $product->wine_name }}
                                                        </h3>
                                                        @if ($product->type)
                                                            <span
                                                                class="{{ strtolower($product->type) === 'red'
                                                                    ? 'bg-red-100 text-red-800'
                                                                    : (strtolower($product->type) === 'white'
                                                                        ? 'bg-yellow-100 text-yellow-800'
                                                                        : 'bg-blue-100 text-blue-800') }} text-xs font-medium px-2.5 py-0.5 rounded whitespace-nowrap ml-2">
                                                                {{ $product->type }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    @if ($product->winery)
                                                        <p class="text-gray-600 font-medium mb-2 line-clamp-1"
                                                            title="{{ $product->winery }}">
                                                            {{ $product->winery }}
                                                        </p>
                                                    @endif
                                                    @if ($product->tasting_notes)
                                                        <p class="text-gray-600 mb-4 line-clamp-3 flex-grow"
                                                            title="{{ $product->tasting_notes }}">
                                                            {{ $product->tasting_notes }}
                                                        </p>
                                                    @endif
                                                    <div class="mt-auto pt-4">
                                                        <a href="{{ route('user.productdetails', $product->id) }}"
                                                            class="block w-full text-center bg-red-700 hover:bg-red-800 text-white px-4 py-2 rounded-md text-sm transition">
                                                            View Details
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="glide__arrows flex justify-center mt-6 space-x-4" data-glide-el="controls">
                                <button
                                    class="glide__arrow glide__arrow--left bg-gray-200 hover:bg-gray-300 rounded-full w-10 h-10 flex items-center justify-center"
                                    data-glide-dir="<">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button
                                    class="glide__arrow glide__arrow--right bg-gray-200 hover:bg-gray-300 rounded-full w-10 h-10 flex items-center justify-center"
                                    data-glide-dir=">">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="text-center mt-12">
                            <a href="{{ route('homeBrowseWines') }}"
                                class="inline-block bg-red-700 hover:bg-red-800 text-white px-6 py-3 rounded-md text-lg font-medium transition">
                                View All Wines
                            </a>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500">No featured wines available at the moment. Check back soon!</p>
                        </div>
                    @endif
                </div>
            </div>
            <!-- End:: Section-3 -->


            <!-- Start:: Section-4 -->
            <section class="section landing-Features" style="padding:0px;" id="pairing">
                <div class="py-16 bg-gray-50">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2 text-center">Perfect Wine Pairings</h2>
                        <p class="text-gray-600 mb-12 text-center max-w-3xl mx-auto">
                            From elegant meals to indulgent cheese boards, explore pairings that bring out the best in
                            every wine.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Pairing 1 -->
                            <div class="bg-white rounded-lg overflow-hidden shadow-md flex flex-col md:flex-row">
                                <div class="md:w-1/2">
                                    <!-- <img src="https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                                        alt="Steak" class="w-full h-full object-cover"> -->
                                    <img src="{{ asset('images/WineandFood.jpg') }}" alt="Steak"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="md:w-1/2 p-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Wine and food</h3>
                                    <p class="text-gray-600 mb-4">
                                        Explore how wine transforms food into an experience from comforting classics to
                                        gourmet cuisine, discover pairings that bring harmony, depth, and pleasure to
                                        the table.
                                    </p>
                                    <a href="#"
                                        class="text-red-700 hover:text-red-800 font-medium inline-flex items-center">
                                        Coming Soon
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <!-- Pairing 2 -->
                            <div class="bg-white rounded-lg overflow-hidden shadow-md flex flex-col md:flex-row">
                                <div class="md:w-1/2">
                                    <img src="{{ asset('images/WineandCheese.jpg') }}" alt="Seafood"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="md:w-1/2 p-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Wine and Cheese</h3>
                                    <p class="text-gray-600 mb-4">
                                        Explore how wine transforms food into an experience — from comforting
                                        classics to gourmet cuisine, discover pairings that bring harmony, depth, and
                                        pleasure to the table.
                                    </p>
                                    <a href="{{ route('user.cheeses') }}"
                                        class="text-red-700 hover:text-red-800 font-medium inline-flex items-center">
                                        Explore this pairing
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-12">
                            <a href="{{ route('user.cheeses') }}"
                                class="inline-block bg-red-700 hover:bg-red-800 text-white px-6 py-3 rounded-md text-lg font-medium transition">
                                View All Pairings
                            </a>
                        </div>
                    </div>
            </section>
            <!-- End:: Section-4 -->

            <!-- Start:: Section-5  Testimonials Section -->
            @php
                // Fetch active testimonials ordered by sort_order
                $testimonials = \App\Models\Testimonial::where('is_active', true)->orderBy('sort_order')->get();
            @endphp

            <x-testimonials :testimonials="$testimonials" />
            <!-- End:: Section-5 -->

            <!-- Start:: Section-4 -->
            <section class="section landing-Features-two landing-Features border border-danger">
                <div class="container text-center">
                    <h2 class="text-3xl font-bold mb-8 text-center text-white">Our Clients</h2>
                    <h4 class="fw-semibold mb-2 text-white">Client Reviews</h4>
                    <div class="text-start">
                        <div class="justify-content-center">
                            <div class="feature-logos mt-5">
                                <div class="swiper mySwiper9">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <img src="{{ asset('images/grapes.jpg') }}" alt="image">
                                            <h5 class="text-center mt-2 text-fixed-white">One</h5>
                                        </div>
                                        <div class="swiper-slide">
                                            <img src="{{ asset('images/grapes.jpg') }}" alt="image">
                                            <h5 class="text-center mt-2 text-fixed-white">Two</h5>
                                        </div>
                                        <div class="swiper-slide">
                                            <img src="{{ asset('images/grapes.jpg') }}" alt="image">
                                            <h5 class="text-center mt-2 text-fixed-white">Three</h5>
                                        </div>
                                        <div class="swiper-slide">
                                            <img src="{{ asset('images/grapes.jpg') }}" alt="image">
                                            <h5 class="text-center mt-2 text-fixed-white">Four</h5>
                                        </div>
                                        <div class="swiper-slide">
                                            <img src="{{ asset('images/grapes.jpg') }}" alt="image">
                                            <h5 class="text-center mt-2 text-fixed-white">Five</h5>
                                        </div>
                                        <div class="swiper-slide">
                                            <img src="{{ asset('images/grapes.jpg') }}" alt="image">
                                            <h5 class="text-center mt-2 text-fixed-white">Six</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-4 -->



            <!-- Start:: Section-6 -->
            <section class="section section-bg" id="Moments">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold mb-8 text-center">Wine Moments</h2>

                    <div class="owl-carousel owl-theme">
                        @foreach (['https://media.istockphoto.com/id/1182488944/photo/just-one-more-chapter.webp?a=1&b=1&s=612x612&w=0&k=20&c=Bda3jU5w-qMIuGX9ZFpymDsaDj9kRMhVSrZMB7Nf1mg=', 'https://media.istockphoto.com/id/526246287/photo/meat-wine-restaurant.webp?a=1&b=1&s=612x612&w=0&k=20&c=65c7kZ0paj831ILgFNjnIDMCvRwQszn3qzVjpaYAORo=', 'https://media.istockphoto.com/id/626154424/photo/pouring-red-wine.webp?a=1&b=1&s=612x612&w=0&k=20&c=4QA15zbQxUHbGKMT67hl_VZcIrfpIZ4t5RaYE77Jja8=', 'https://media.istockphoto.com/id/626154424/photo/pouring-red-wine.webp?a=1&b=1&s=612x612&w=0&k=20&c=4QA15zbQxUHbGKMT67hl_VZcIrfpIZ4t5RaYE77Jja8=', 'https://media.istockphoto.com/id/476976729/photo/wine-tasting-at-restaurant.webp?a=1&b=1&s=612x612&w=0&k=20&c=jpLOBX57Z9r91cb2yFOUkl27pa3kn4d6K9yvPctrLug='] as $image)
                            <div class="bg-white rounded-lg overflow-hidden shadow-md">
                                <img src="{{ $image }}" alt="Wine image" class="w-full h-64 object-cover">
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            <!-- End:: Section-6 -->

            <!-- Start:: Section-7 -->
            <section class="section highlights" id="share-review" style="padding:0px;">
                <!-- Share Review Section -->
                <div class="py-16 bg-red-700">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="lg:flex lg:items-center lg:justify-between">
                            <div class="lg:w-1/2">
                                <h2 class="text-3xl font-bold text-white mb-2">Share Your Experience</h2>
                                <p class="text-red-100 mb-6 lg:mb-0">
                                    We value your feedback! Share your wine experience with our community. 
                                    <br>Your review helps others discover great wines.
                                </p>
                            </div>
                            <div class="lg:w-1/2">
                                <form id="testimonial-form" class="space-y-4">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="name" class="sr-only">Your Name</label>
                                            <input id="name" name="name" type="text"
                                                class="w-full px-5 py-3 placeholder-gray-500 focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-700 focus:ring-white focus:outline-none rounded-md"
                                                placeholder="Your name (optional)">
                                        </div>
                                        <div>
                                            <label for="email" class="sr-only">Email address</label>
                                            <input id="email" name="email" type="email"
                                                class="w-full px-5 py-3 placeholder-gray-500 focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-700 focus:ring-white focus:outline-none rounded-md"
                                                placeholder="Your email (optional)">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="review" class="sr-only">Your Review</label>
                                        <textarea id="review" name="testimonial" rows="3" required
                                            class="w-full px-5 py-3 placeholder-gray-500 focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-700 focus:ring-white focus:outline-none rounded-md"
                                            placeholder="Share your thoughts about our wines..."></textarea>
                                        <div id="review-error" class="text-red-200 text-sm mt-1 hidden">Please enter
                                            your review (at least 10 characters)</div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="text-yellow-400 text-xl">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <button type="button" class="rating-star"
                                                        data-rating="{{ $i }}">
                                                        <i class="far fa-star"></i>
                                                    </button>
                                                @endfor
                                            </div>
                                            <input type="hidden" name="rating" id="rating" value="5">
                                        </div>
                                        <button type="submit" id="submit-review"
                                            class="px-6 py-3 border border-transparent text-base font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-700 focus:ring-white">
                                            <span class="inline-flex items-center">
                                                <span id="submit-text">Submit Review</span>
                                                <svg id="submit-spinner"
                                                    class="hidden ml-2 h-5 w-5 animate-spin text-red-700"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                        stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                            </span>
                                        </button>
                                    </div>
                                    <div id="form-message" class="mt-2 text-sm text-red-200 hidden"></div>
                                </form>
                                <p class="mt-3 text-sm text-red-200">
                                    Your email will not be published. Read our
                                    <a href="#" class="text-white underline">Privacy Policy</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-7 -->
        </div>
        <!-- End::app-content -->


        <!-- Start:: Section-11 -->
        @include('layouts.footer')
        <!-- End:: Section-11 -->

    </div>

    <!-- Back to Top Button -->
    <a href="#home"
        class="fixed bottom-6 right-6 bg-red-700 hover:bg-red-800 text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg transition-all duration-300" style="z-index:10">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </a>
    <div id="responsive-overlay"></div>


    <!-- Glide.js JS -->
    <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide@3.6.0/dist/glide.min.js"></script>

    <script>
        // Initialize Glide carousel if the element exists
        document.addEventListener('DOMContentLoaded', function() {
            const featuredCarousel = document.querySelector('.featured-wines-carousel');
            if (featuredCarousel) {
                new Glide(featuredCarousel, {
                    type: 'carousel',
                    perView: 3,
                    gap: 24,
                    autoplay: 5000,
                    hoverpause: true,
                    breakpoints: {
                        1024: {
                            perView: 2
                        },
                        768: {
                            perView: 1
                        }
                    }
                }).mount();
            }
        });
    </script>

    <!-- jQuery (required for other functionality) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
    <!-- <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script> -->
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

    <!-- Glide JS -->
    <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>
    <script>
        const glide = new Glide('.featured-wines-carousel', {
            type: 'carousel',
            perView: 3,
            breakpoints: {
                1024: {
                    perView: 2
                },
                600: {
                    perView: 1
                }
            }
        });
        glide.mount();
    </script>

    <!-- jQuery (required for Owl Carousel) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                loop: true,
                margin: 20,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5000,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    1024: {
                        items: 3
                    }
                }
            });
        });
    </script>

    <!-- change Landing background image -->
    <script>
        const images = [
            'https://images.unsplash.com/photo-1506377247377-2a5b3b417ebb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80',
            'https://plus.unsplash.com/premium_photo-1682097091093-dd18b37764a5?q=80&w=2940&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'https://images.unsplash.com/photo-1700893417238-ce7c7f427996?q=80&w=2940&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
        ];

        let index = 0;
        const bg = document.getElementById('landing-bg');

        function changeBackground() {
            bg.style.opacity = 0;

            setTimeout(() => {
                const nextImage =
                    `linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)), url('${images[index]}')`;
                bg.style.backgroundImage = nextImage;
                bg.style.opacity = 1;
                index = (index + 1) % images.length;
            }, 1000); // match this delay to your CSS transition time
        }

        // Set initial image
        bg.style.backgroundImage = `linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)), url('${images[0]}')`;

        setInterval(changeBackground, 5000);
    </script>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Rating stars functionality
                const stars = document.querySelectorAll('.rating-star');
                const ratingInput = document.getElementById('rating');

                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const rating = this.getAttribute('data-rating');
                        ratingInput.value = rating;

                        // Update star display
                        stars.forEach((s, index) => {
                            if (index < rating) {
                                s.innerHTML = '<i class="fas fa-star"></i>';
                                s.classList.add('text-yellow-400');
                                s.classList.remove('text-gray-300');
                            } else {
                                s.innerHTML = '<i class="far fa-star"></i>';
                                s.classList.add('text-gray-300');
                                s.classList.remove('text-yellow-400');
                            }
                        });
                    });
                });

                // Initialize with 5 stars
                if (stars.length > 0) {
                    stars[4].click();
                }
            });
        </script>
    @endpush

    <script>
        const form = document.getElementById('testimonial-form');
        const reviewInput = document.getElementById('review');
        const reviewError = document.getElementById('review-error');
        const submitButton = document.getElementById('submit-review');
        const submitText = document.getElementById('submit-text');
        const submitSpinner = document.getElementById('submit-spinner');
        const formMessage = document.getElementById('form-message');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Validate review input
            if (reviewInput.value.trim().length < 10) {
                reviewError.classList.remove('hidden');
                return;
            } else {
                reviewError.classList.add('hidden');
            }

            // Show loading state
            submitText.classList.add('hidden');
            submitSpinner.classList.remove('hidden');
            submitButton.disabled = true;

            try {
                const response = await fetch('{{ route('testimonials.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: form.name.value,
                        email: form.email.value,
                        testimonial: form.testimonial.value,
                        rating: form.rating.value
                    })
                });

                const data = await response.json();

                if (data.success) {
                    formMessage.classList.remove('hidden');
                    formMessage.innerText = 'Thank you for sharing your review!';
                    form.reset();
                } else {
                    formMessage.classList.remove('hidden');
                    formMessage.innerText = 'Error submitting review. Please try again.';
                }
            } catch (error) {
                console.error(error);
                formMessage.classList.remove('hidden');
                formMessage.innerText = 'Error submitting review. Please try again.';
            } finally {
                // Hide loading state
                submitText.classList.remove('hidden');
                submitSpinner.classList.add('hidden');
                submitButton.disabled = false;
            }
        });
    </script>

</body>

</html>


