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


    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Styles -->
    <style>
      
      .hero-section 
      {
            background: 
                linear-gradient(rgba(128, 128, 0, 0.4), rgba(128, 128, 0, 0.4)), 
                url('/images/Corksabout.jpg') center/cover no-repeat;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.6);
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

        .about-section 
        {
            background: linear-gradient(to bottom right, #faf8f6, #ffffff);
            border-top: 2px solid #b58969;
            border-bottom: 2px solid #b58969;
            padding: 80px 0;
        }

        .about-title 
        {
            /* font-family: 'Playfair Display', serif; */
            font-size: 2.8rem;
            color: #5c2c06;
            position: relative;
        }

        .about-title::after 
        {
            content: '';
            width: 80px;
            height: 3px;
            background: #b58969;
            display: block;
            margin: 12px auto 0;
            border-radius: 2px;
            margin-left: 0px;
        
        }

        .about-content 
        {
            /* font-family: 'Lora', serif; */
            color: #444;
            font-size: 1.15rem;
            line-height: 1.9;
            letter-spacing: 0.2px;
            text-align: justify;
            animation: fadeIn 1.2s ease-in-out;
        }

        .about-content p 
        {
            margin-bottom: 1.6rem;
        }

        .about-content p:last-child 
        {
            font-style: italic;
            color: #5c2c06;
            border-left: 3px solid #b58969;
            padding-left: 15px;
        }

        @keyframes fadeIn 
        {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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
                            <!-- <a href="signup.html" class="btn btn-primary-light">
                                New User
                            </a> -->
                            <!-- <a href="signin.html" class="btn btn-primary-light">
                                Login
                            </a> -->
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
                                <a href="{{ route('home') }}" class="header-logo">
                                    <img src="{{ asset('images/logoredwhite.jpg') }}" alt="logo" class="desktop-logo">
                                    <img src="{{ asset('images/logoredwhite.jpg') }}" alt="logo" class="desktop-white">
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
                                <a class="side-menu__item" href="{{ route('home') }}">
                                    <span class="fonthover">Home</span>
                                </a>
                            </li>
                            
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="{{ route('home') }}#HIW" class="side-menu__item">
                                    <span class="fonthover">How It Works</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="{{ route('home') }}#featuredwines" class="side-menu__item">
                                    <span class="fonthover">Browse Wines</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="{{ route('home') }}#pairing" class="side-menu__item">
                                    <span class="fonthover">Pairing Wines</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="{{ route('home') }}#testimonials" class="side-menu__item">
                                    <span class="fonthover">What our users say</span>
                                </a>
                            </li>
                            <!-- End::slide -->
                            <!-- Start::slide -->
                            <li class="slide">
                                <a href="{{ route('home') }}#Moments" class="side-menu__item">
                                    <span class="fonthover">Moments</span>
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

           <!-- Section 1: Hero Image -->
            <section class="hero-section text-center">
                <div>
                    <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">About TechSomm</h1>
                    <p class="text-xl text-gray-200 mb-10 max-w-3xl mx-auto">
                        Your digital wine discovery platform
                    </p>
                    
                </div>
            </section>

            <!-- Section 2: About Text -->
            <section class="about-section py-5">
                <div class="container">
                    <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <h1 class="about-title mb-4">Our Story 🍷</h1>
                        <div class="about-content">
                        <p>🍇 TechSomm is a first-of-its-kind digital wine discovery platform, 
                            built to help Indian wine lovers find the perfect bottle, every single time. 🍾
                        </p>

                        <p>We believe choosing wine should feel as good as drinking it. At TechSomm, we've blended technology, 
                            taste and a deep love for wine into a platform that’s elegant, intuitive and made just for you. 
                            Whether you’re looking for something bold and expressive or light and refined, 
                            TechSomm learns your preferences, captures your tasting notes, and curates recommendations 
                            based on your personal profile. 🍷
                        </p>

                        <p>Our growing wine library features every wine imported and produced in India, not just a curated few. 
                            So you always have access to what’s available with rich sommelier-style tasting notes, 
                            food and cheese pairings 🧀🍇, and real-time insights into flavor, style, origin, and occasion.
                        </p>

                        <p>But this isn’t just about browsing labels. It’s about building a relationship with wine, 
                            exploring what excites you, saving what you love and discovering new favorites with every visit. 
                            Whether you’re sipping at home, dining out or choosing a bottle to gift 🎁, 
                            TechSomm helps you make confident, delicious choices.
                        </p>

                        <p>
                            And we’re just getting started. 🚀 Coming soon: Regional Wine Guides, the SMS (Save Me Sommelier) hotline 📞, 
                            and Wine Concierge Services to support every moment of your wine life from quiet evenings to 
                            grand celebrations. 🥂
                        </p>

                        <p><em>So whether you're a casual drinker, a curious enthusiast, or a seasoned connoisseur 
                            TechSomm is your partner in pleasure, discovery and all things wines. Let your wine 
                            journey begin, beautifully. 
                        </em></p>
                        </div>
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

    

    




</body>

</html>
