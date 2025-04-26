<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="horizontal" data-nav-style="menu-click" data-menu-position="fixed" data-theme-mode="light">
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
    <link id="style" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" >
    <!-- Style Css -->
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" >
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" >
    <!-- Node Waves Css -->
    <link href="{{ asset('assets/libs/node-waves/waves.min.css') }}" rel="stylesheet" >
    <!-- SwiperJS Css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}">
    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/@simonwep/pickr/themes/nano.min.css') }}">
    <!-- Choices Css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/choices.js/public/assets/styles/choices.min.css') }}">

    <!-- OLD LINKS START -->
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Owl Carousel links -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />


        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Custom Styles -->
            <style>
                footer 
                {
                    margin-left: 150px; /* same as your sidebar width */
                    width: calc(100% - 250px); /* to prevent horizontal scroll */
                }

                .wine-bg {
                    background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1506377247377-2a5b3b417ebb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80');
                    background-size: cover;
                    background-position: center;
                }

                .wine-card {
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                }

                .wine-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                }
            </style>

            <!-- Scripts -->
            @vite(['resources/css/app.css', 'resources/js/app.js'])


    <!-- OLD LINKS END -->
    <script>
        if(localStorage.spruhalandingdarktheme){
            document.querySelector("html").setAttribute("data-theme-mode","dark")
        }
        if(localStorage.spruhalandingrtl){
            document.querySelector("html").setAttribute("dir","rtl")
            document.querySelector("#style")?.setAttribute("href", "{{ asset('assets/libs/bootstrap/css/bootstrap.rtl.min.css') }}");
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
                        <input class="form-check-input color-input color-primary-3" type="radio" name="theme-primary"
                            id="switcher-primary2">
                    </div>
                    <div class="form-check switch-select me-3">
                        <input class="form-check-input color-input color-primary-4" type="radio" name="theme-primary"
                            id="switcher-primary3">
                    </div>
                    <div class="form-check switch-select me-3">
                        <input class="form-check-input color-input color-primary-5" type="radio" name="theme-primary"
                            id="switcher-primary4">
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
                                <img src="{{ asset('assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
                                <!-- <img src="{{ asset('assets/images/brand-logos/toggle-white.png') }}" alt="logo" class="toggle-logo"> -->
                                <img src="{{ asset('assets/images/brand-logos/toggle-dark.png') }}" alt="logo" class="toggle-dark">
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
        <aside class="app-sidebar sticky" id="sidebar">
            <div class="container p-0">
                <!-- Start::main-sidebar -->
                <div class="main-sidebar">
                    <!-- Start::nav -->
                    <nav class="main-menu-container nav nav-pills sub-open">
                        <div class="landing-logo-container">
                            <div class="horizontal-logo">
                                <a href="#" class="header-logo">
                                    <img src="{{ asset('images/winelogo.png') }}" alt="logo" class="desktop-logo">
                                    <img src="{{ asset('images/winelogo.png') }}" alt="logo" class="desktop-white">
                                </a>
                            </div>
                        </div>
                        <div class="slide-left" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path> </svg></div>
                        <ul class="main-menu">
                            <!-- Start::slide -->
                            <li class="slide">
                                <a class="side-menu__item" href="#home">
                                    <span class="side-menu__label" style="color:black">Home</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#HIW" class="side-menu__item">
                                    <span class="side-menu__label" style="color:black">How It Works</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#featuredwines" class="side-menu__item">
                                    <span class="side-menu__label" style="color:black">Featured Wines</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#pairing" class="side-menu__item">
                                    <span class="side-menu__label" style="color:black">Food Pairings</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#testimonials" class="side-menu__item">
                                    <span class="side-menu__label" style="color:black">Testimonials</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="#Moments" class="side-menu__item">
                                    <span class="side-menu__label" style="color:black">Moments</span>
                                </a>
                            </li>
                            <!-- End::slide -->

                        </ul>
                        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"> <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path> </svg></div>
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
                <div class="wine-bg min-h-screen flex flex-col">
                    <!-- Hero Content -->
                    <div class="flex-grow flex items-center justify-center">
                        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">Discover Your Perfect Wine</h1>
                            <p class="text-xl text-gray-200 mb-10 max-w-3xl mx-auto">
                                Our intelligent recommendation system helps you find the perfect wine for any occasion, based on
                                your taste preferences and food pairings...
                            </p>
                            <div class="flex flex-col sm:flex-row justify-center gap-4">
                                <a href="#explore"
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
                            <h2 class="text-3xl font-bold text-gray-900 mb-2 text-center">How It Works</h2>
                            <p class="text-gray-600 mb-12 text-center max-w-3xl mx-auto">
                                Our recommendation system uses advanced algorithms to match you with wines you'll love.
                            </p>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                <!-- Step 1 -->
                                <div class="text-center">
                                    <div class="bg-red-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-700" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Create Your Profile</h3>
                                    <p class="text-gray-600">
                                        Sign up and tell us about your taste preferences, favorite wines, and dining habits.
                                    </p>
                                </div>

                                <!-- Step 2 -->
                                <div class="text-center">
                                    <div class="bg-red-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-700" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Get Personalized Recommendations</h3>
                                    <p class="text-gray-600">
                                        Our algorithm analyzes your preferences and suggests wines that match your unique taste profile.
                                    </p>
                                </div>

                                <!-- Step 3 -->
                                <div class="text-center">
                                    <div class="bg-red-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-700" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Discover & Enjoy</h3>
                                    <p class="text-gray-600">
                                        Explore your recommendations, rate wines you try, and refine your profile for even better
                                        matches.
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
                            Explore our curated selection of exceptional wines from around the world, each with its own unique
                            character and story.
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <!-- Wine Card 1 -->
                            <div class="wine-card bg-white rounded-lg overflow-hidden shadow-md">
                                <img src="https://images.unsplash.com/photo-1586370434639-0fe43b2d32e6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                                    alt="Red Wine" class="w-full h-60 object-cover">
                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-xl font-bold text-gray-900">Château Margaux 2015</h3>
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Red</span>
                                    </div>
                                    <p class="text-gray-600 mb-4">A magnificent Bordeaux with notes of black currant, violets, and
                                        cedar. Elegant and powerful.</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-900 font-bold">$189.99</span>
                                        <button
                                            class="bg-red-700 hover:bg-red-800 text-white px-4 py-2 rounded-md text-sm transition">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Wine Card 2 -->
                            <div class="wine-card bg-white rounded-lg overflow-hidden shadow-md">
                                <img src="https://images.unsplash.com/photo-1724949629465-fa0d083ad09c?q=80&w=2880&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                    alt="White Wine" class="w-full h-60 object-cover">
                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-xl font-bold text-gray-900">Cloudy Bay Sauvignon Blanc</h3>
                                        <span
                                            class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">White</span>
                                    </div>
                                    <p class="text-gray-600 mb-4">Vibrant and crisp with intense flavors of passion fruit, lime, and
                                        fresh herbs from New Zealand.</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-900 font-bold">$34.99</span>
                                        <button
                                            class="bg-red-700 hover:bg-red-800 text-white px-4 py-2 rounded-md text-sm transition">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Wine Card 3 -->
                            <div class="wine-card bg-white rounded-lg overflow-hidden shadow-md">
                                <img src="https://images.unsplash.com/photo-1700893417209-18dc88c989a0?q=80&w=2940&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                    alt="Sparkling Wine" class="w-full h-60 object-cover">
                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-xl font-bold text-gray-900">Dom Pérignon Vintage</h3>
                                        <span
                                            class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Sparkling</span>
                                    </div>
                                    <p class="text-gray-600 mb-4">Luxurious champagne with complex notes of almond, powdered cocoa,
                                        white fruit, and dried flowers.</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-900 font-bold">$219.99</span>
                                        <button
                                            class="bg-red-700 hover:bg-red-800 text-white px-4 py-2 rounded-md text-sm transition">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-12">
                            <a href="#"
                                class="inline-block bg-red-700 hover:bg-red-800 text-white px-6 py-3 rounded-md text-lg font-medium transition">
                                View All Wines
                            </a>
                        </div>
                    </div>
                </div>
            <!-- End:: Section-3 -->

            
            <!-- Start:: Section-4 -->
            <section class="section landing-Features" style="padding:0px;" id="pairing">
                <div class="py-16 bg-gray-50">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2 text-center">Perfect Food Pairings</h2>
                        <p class="text-gray-600 mb-12 text-center max-w-3xl mx-auto">
                            Enhance your dining experience with our expert food and wine pairing suggestions.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Pairing 1 -->
                            <div class="bg-white rounded-lg overflow-hidden shadow-md flex flex-col md:flex-row">
                                <div class="md:w-1/2">
                                    <img src="https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                                        alt="Steak" class="w-full h-full object-cover">
                                </div>
                                <div class="md:w-1/2 p-6">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Steak & Cabernet Sauvignon</h3>
                                    <p class="text-gray-600 mb-4">
                                        The rich tannins in Cabernet Sauvignon perfectly complement the proteins in a juicy steak,
                                        creating a harmonious balance of flavors.
                                    </p>
                                    <a href="#"
                                        class="text-red-700 hover:text-red-800 font-medium inline-flex items-center">
                                        Explore this pairing
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                                            fill="currentColor">
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
                                <img src="https://images.unsplash.com/photo-1559737558-2f5a35f4523b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80"
                                    alt="Seafood" class="w-full h-full object-cover">
                            </div>
                            <div class="md:w-1/2 p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Seafood & Chardonnay</h3>
                                <p class="text-gray-600 mb-4">
                                    The buttery notes and subtle oak in Chardonnay enhance the delicate flavors of seafood,
                                    especially when prepared with creamy sauces.
                                </p>
                                <a href="#"
                                    class="text-red-700 hover:text-red-800 font-medium inline-flex items-center">
                                    Explore this pairing
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-12">
                        <a href="#"
                            class="inline-block bg-red-700 hover:bg-red-800 text-white px-6 py-3 rounded-md text-lg font-medium transition">
                            View All Pairings
                        </a>
                    </div>
                </div>
            </section>
            <!-- End:: Section-4 -->

            <!-- Start:: Section-5  Testimonials Section -->
            <section class="section highlights" id="testimonials">
                <div class="py-16 bg-white">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2 text-center">What Our Users Say</h2>
                        <p class="text-gray-600 mb-12 text-center max-w-3xl mx-auto">
                            Discover how Wine Recommender has transformed the wine experience for our community.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Testimonial 1 -->
                            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                                <div class="flex items-center mb-4">
                                    <div
                                        class="h-12 w-12 rounded-full bg-red-200 flex items-center justify-center text-red-700 font-bold text-xl">
                                        JD
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold text-gray-900">James Davis</h4>
                                        <div class="flex text-yellow-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <!-- Repeat star SVGs 4 more times -->
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-600 italic">
                                    "I used to spend hours researching wines before dinner parties. Wine Recommender has saved me so
                                    much time and introduced me to amazing wines I never would have discovered on my own."
                                </p>
                            </div>

                            <!-- Testimonial 2 -->
                            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                                <div class="flex items-center mb-4">
                                    <div
                                        class="h-12 w-12 rounded-full bg-red-200 flex items-center justify-center text-red-700 font-bold text-xl">
                                        SL
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold text-gray-900">Sarah Lee</h4>
                                        <div class="flex text-yellow-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <!-- Repeat star SVGs 4 more times -->
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-600 italic">
                                    "As a beginner in the world of wine, I was overwhelmed by all the choices. This app has been my
                                    personal sommelier, guiding me to wines that match my taste perfectly."
                                </p>
                            </div>

                            <!-- Testimonial 3 -->
                            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                                <div class="flex items-center mb-4">
                                    <div
                                        class="h-12 w-12 rounded-full bg-red-200 flex items-center justify-center text-red-700 font-bold text-xl">
                                        MR
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold text-gray-900">Michael Rodriguez</h4>
                                        <div class="flex text-yellow-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <!-- Repeat star SVGs 4 more times -->
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-600 italic">
                                    "The food pairing suggestions are spot on! I've impressed my friends at dinner parties with
                                    perfect wine selections that complement every dish."
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End:: Section-5 -->

            <!-- Start:: Section-6 -->
            <section class="section section-bg" id="Moments">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold mb-8 text-center">Wine Moments</h2>

                    <div class="owl-carousel owl-theme">
                        @foreach ([
                            'https://media.istockphoto.com/id/1182488944/photo/just-one-more-chapter.webp?a=1&b=1&s=612x612&w=0&k=20&c=Bda3jU5w-qMIuGX9ZFpymDsaDj9kRMhVSrZMB7Nf1mg=',
                            'https://media.istockphoto.com/id/526246287/photo/meat-wine-restaurant.webp?a=1&b=1&s=612x612&w=0&k=20&c=65c7kZ0paj831ILgFNjnIDMCvRwQszn3qzVjpaYAORo=',
                            'https://media.istockphoto.com/id/626154424/photo/pouring-red-wine.webp?a=1&b=1&s=612x612&w=0&k=20&c=4QA15zbQxUHbGKMT67hl_VZcIrfpIZ4t5RaYE77Jja8=',
                            'https://media.istockphoto.com/id/626154424/photo/pouring-red-wine.webp?a=1&b=1&s=612x612&w=0&k=20&c=4QA15zbQxUHbGKMT67hl_VZcIrfpIZ4t5RaYE77Jja8=',
                            'https://media.istockphoto.com/id/476976729/photo/wine-tasting-at-restaurant.webp?a=1&b=1&s=612x612&w=0&k=20&c=jpLOBX57Z9r91cb2yFOUkl27pa3kn4d6K9yvPctrLug='
                        ] as $image)
                            <div class="bg-white rounded-lg overflow-hidden shadow-md">
                                <img src="{{ $image }}" alt="Wine image" class="w-full h-64 object-cover">
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            <!-- End:: Section-6 -->

            <!-- Start:: Section-7 -->
            <section class="section highlights" id="faq" style="padding:0px;">
                <!-- Newsletter Section -->
                <div class="py-16 bg-red-700">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="lg:flex lg:items-center lg:justify-between">
                            <div class="lg:w-1/2">
                                <h2 class="text-3xl font-bold text-white mb-2">Join Our Wine Community</h2>
                                <p class="text-red-100 mb-6 lg:mb-0">
                                    Subscribe to our newsletter for exclusive wine recommendations, special offers, and expert tips
                                    on wine appreciation.
                                </p>
                            </div>
                            <div class="lg:w-1/2">
                                <form class="sm:flex">
                                    <label for="email-address" class="sr-only">Email address</label>
                                    <input id="email-address" name="email" type="email" autocomplete="email" required
                                        class="w-full px-5 py-3 placeholder-gray-500 focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-700 focus:ring-white focus:outline-none rounded-md"
                                        placeholder="Enter your email">
                                    <div class="mt-3 sm:mt-0 sm:ml-3">
                                        <button type="submit"
                                            class="w-full flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-700 focus:ring-white">
                                            Subscribe
                                        </button>
                                    </div>
                                </form>
                                <p class="mt-3 text-sm text-red-200">
                                    We care about your data. Read our <a href="#" class="text-white underline">Privacy Policy</a>.
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
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>

     <!-- jQuery (required for Owl Carousel) -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".owl-carousel").owlCarousel({
                loop: true,
                margin: 20,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 5000,
                responsive: {
                    0: { items: 1 },
                    768: { items: 2 },
                    1024: { items: 3 }
                }
            });
        });
    </script>


</body>

</html>