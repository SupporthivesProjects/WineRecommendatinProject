<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="horizontal" data-nav-style="menu-click" data-menu-position="fixed"
    data-theme-mode="light">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>About – TechSomm</title>
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/wine_store_favicon.ico') }}" type="image/x-icon">
    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Style Css -->
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">
    <!-- Headline font and TechSomm brand colours -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/brand.css') }}?v={{ filemtime(public_path('assets/css/brand.css')) }}">
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
      
        /* Header: same as the Services page (markup in partials/public-site-header) */
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

        .about-section {
            background: linear-gradient(to bottom right, #faf8f6, #ffffff);
            border-top: 2px solid #b58969;
            border-bottom: 2px solid #b58969;
            padding: 80px 0;
            }

            .about-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            color: #5c2c06;
            position: relative;
            }

            .about-title::after {
            content: '';
            width: 80px;
            height: 3px;
            background: #b58969;
            display: block;
            margin: 12px auto 0;
            border-radius: 2px;
            }

            .about-content {
            font-family: 'Lora', serif;
            color: #444;
            font-size: 1.15rem;
            line-height: 1.9;
            letter-spacing: 0.2px;
            text-align: justify;
            animation: fadeIn 1.2s ease-in-out;
            }

            .about-content p {
            margin-bottom: 1.6rem;
            }

            .about-content p:last-child {
            font-style: italic;
            color: #5c2c06;
            border-left: 3px solid #b58969;
            padding-left: 15px;
            }

            @keyframes fadeIn {
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
        @include('partials.public-site-header')
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
                        <h1 class="about-title mb-4 text-center">Our Story</h1>
                        <div class="about-content">
                        <p>TechSomm is a first-of-its-kind digital wine discovery platform, 
                            built to help Indian wine lovers find the perfect bottle, every single time.</p>

                        <p>We believe choosing wine should feel as good as drinking it. 
                            At TechSomm, we've blended technology, taste and a deep love for wine into a platform 
                            that’s elegant, intuitive and made just for you...</p>

                        <p>Our growing wine library features every wine imported and produced in India...</p>

                        <p>But this isn’t just about browsing labels. It’s about building 
                            a relationship with wine, exploring what excites you...</p>

                        <p>And we’re just getting started. Coming soon: Regional Wine Guides...</p>

                        <p><em>So whether you're a casual drinker, a curious enthusiast, 
                            or a seasoned connoisseur — TechSomm is your partner in pleasure, 
                            discovery and all things wines.</em></p>
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


    <!-- Shrink the header logo on scroll (same as the Services page) -->
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
