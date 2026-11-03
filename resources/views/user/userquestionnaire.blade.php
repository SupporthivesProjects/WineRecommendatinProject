@extends('layouts.user')
@section('title', 'Questionnaires')
@section('admindashboardcontent')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/wine-loader.css') }}?v={{ filemtime(public_path('assets/css/wine-loader.css')) }}">

    <style>
        html, body {
            overscroll-behavior: auto;       
            overflow-x: hidden;             
        }
        #mystyle
        {
            font-family: 'Cinzel Decorative', serif;
        }
        .hero-section 
        {
            height: 100vh;
            background-image: url('{{ asset('images/wineshelf.jpg') }}');
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
        .hero-text 
        {
            text-align: right;          /* Right-align text */
            width: 100%;
            padding-right: 5%; 
        }
        .hero-text h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .transparent-navbar {
            background: transparent;
            position: fixed;
            top:20px;
            width: 102%;
            z-index: 10;
            padding: 20px 0;
        }
        .navbar-dark .nav-link {
            /* color: #a50908!important; */
            font-size:15px!important;
        }
        .scrolled
        {
            background-color: rgba(0, 0, 0,0.7) !important;
            border-radius:0px;
        }
        .image-card {
            position: relative;
            overflow: hidden;
            height: 100%;
        }
        .image-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.5s ease;
        }
        .overlay-text {
            color: white;
            text-align: center;
            transition: all 0.5s ease;
        }
        .overlay-text .hover-text {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease;
        }
        .image-card.hover img {
            transform: scale(1.05);
        }
        .image-card.hover .overlay {
            background-color: rgba(0,0,0,0.9);
        }
        .image-card.hover .overlay-text .default-text {
            display: none;
        }
        .image-card.hover .overlay-text .hover-text {
            display: block;
            opacity: 1;
        }
        .move-arrow {
            animation: arrowBounce 1s infinite ease-in-out;
            margin-left: 5px;
        }
        @keyframes arrowBounce {
            0% { transform: translateX(0); }
            50% { transform: translateX(5px); }
            100% { transform: translateX(0); }
        }

        input[type="range"]::-webkit-slider-thumb {
            background: #007bff;
            border: none;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            cursor: pointer;
        }




       






        .btn {
            transition: all 0.2s ease-in-out;
            font-weight: 500;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .questionnaire-label {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(0, 0, 0, 0.7) !important; 
            color: #fff;
            font-size: 1.0rem;
            padding: 5px 10px;
            /* border-radius: 5px;  */
            font-weight: 600;
            z-index: 2;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        
        .parallax-container 
        {
            position: relative;
            height: 70vh;
            overflow: hidden;
        }

        .parallax-bg 
        {
            background-image:  url('{{ asset('images/wineshelf.jpg') }}');
            background-size: cover;
            background-position: center;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 150%; /* Make it larger so we can scroll it */
            z-index: -1;
            transform: translateY(0);
            transition: transform 0.1s linear;
        }

        .hero-text 
        {
            position: relative;
            z-index: 1;
            color: white;
            text-align: center;
            padding-top: 30vh;
            text-align: right;          /* Right-align text */
            width: 100%;
            padding-right: 5%; 
            
        }

        .filters-and-cards 
        {
            background: #fff;
            padding: 100px 20px;
            min-height: 100vh;
        }










        /* =====================================
        SPLIT HERO SECTION
        ===================================== */

        .split-hero-section {
            display: grid;
            grid-template-columns: 40% 60%;
            min-height: 720px;
            background: #f8f7f4;
            overflow: hidden;
        }

        /* LEFT: PARALLAX IMAGE */

        .split-hero-image {
            position: relative;
            min-height: 720px;
            overflow: hidden;
        }

        .split-hero-image .parallax-bg {
            position: absolute;
            inset: -10% 0;
            height: 120%;
            background-image: url('{{ asset('images/wineshelf.jpg') }}');
            background-size: cover;
            background-position: center;
            z-index: 0;
        }

        /* RIGHT: CONTENT */

        .split-hero-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 55px 55px;
        }

        .split-hero-heading {
            margin-bottom: 30px;
        }

        .split-hero-heading h1 {
            font-family: 'Cinzel Decorative', serif;
            font-size: 2.4rem;
            color: #292522;
            margin-bottom: 12px;
        }

        .split-hero-heading p {
            font-size: 1rem;
            color: #777;
            margin: 0;
        }

        /* QUESTIONNAIRE GRID */

        .questionnaire-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .questionnaire-grid .image-card {
            height: 210px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            border-radius: 5px;
        }

        .questionnaire-grid .image-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .questionnaire-grid .overlay {
            background-color: rgba(0, 0, 0, 0.42);
        }

        .questionnaire-grid .image-card:hover .overlay {
            background-color: rgba(0, 0, 0, 0.78);
        }

        .questionnaire-grid .overlay-text h4 {
            font-size: 1.15rem;
            padding: 0 12px;
        }

        .questionnaire-grid .hover-text {
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* TABLETS */

        @media (max-width: 991px) {
            .split-hero-section {
                grid-template-columns: 38% 62%;
            }

            .split-hero-content {
                padding: 35px 25px;
            }

            .split-hero-heading h1 {
                font-size: 1.8rem;
            }

            .questionnaire-grid .image-card {
                height: 180px;
            }
        }

        /* MOBILE */

        @media (max-width: 767px) {
            .split-hero-section {
                grid-template-columns: 1fr;
            }

            .split-hero-image {
                min-height: 350px;
            }

            .split-hero-content {
                padding: 40px 20px;
            }

            .split-hero-heading {
                text-align: center;
            }

            .split-hero-heading h1 {
                font-size: 1.8rem;
            }

            .questionnaire-grid {
                gap: 12px;
            }

            .questionnaire-grid .image-card {
                height: 160px;
            }

            .questionnaire-grid .overlay-text h4 {
                font-size: 0.95rem;
            }
        }

        @media (max-width: 400px) {
            .questionnaire-grid {
                grid-template-columns: 1fr;
            }

            .questionnaire-grid .image-card {
                height: 190px;
            }
        }

        /* =====================================
        SPLIT HERO RIGHT BACKGROUND
        ===================================== */

        body:has(.split-hero-section) .split-hero-content {
            background: linear-gradient(
                135deg,
                #F5EFE5 0%,
                #EDE1D0 100%
            ) !important;
        }

        /* Optional subtle warm border between image and content */
        body:has(.split-hero-section) .split-hero-content {
            border-left: 1px solid rgba(117, 75, 49, 0.12);
        }

        /* Heading */
        body:has(.split-hero-section) .split-hero-heading h1 {
            color: #542D2D;
        }

        body:has(.split-hero-section) .split-hero-heading p {
            color: #78675A;
        }


        /* =====================================
        QUESTIONNAIRE PAGE NAVBAR ONLY
        ===================================== */

        body:has(.split-hero-section) .transparent-navbar {
            background: rgba(48, 28, 27, 0.88) !important;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 0;
        }

        /* Navbar links */
        body:has(.split-hero-section) .transparent-navbar .nav-link,
        body:has(.split-hero-section) .transparent-navbar a {
            color: #E8C982 !important;
            transition: color 0.3s ease;
        }

        /* Hover */
        body:has(.split-hero-section) .transparent-navbar .nav-link:hover,
        body:has(.split-hero-section) .transparent-navbar a:hover {
            color: #FFFFFF !important;
        }

        /* Scrolled navbar */
        body:has(.split-hero-section) .transparent-navbar.scrolled {
            background: rgba(48, 28, 27, 0.95) !important;
        }

        /* Navbar icons */
        body:has(.split-hero-section) .transparent-navbar i {
            color: #E8C982 !important;
        }

        #mainNavbar .nav-link {
            color: #987b6b !important;
            position: relative;
            white-space: nowrap;
        }

    </style>

@endpush

    <!-- SPLIT HERO SECTION -->
    <section class="split-hero-section" id="questionnaires">

        <!-- LEFT: PARALLAX WINE IMAGE -->
        <div class="split-hero-image">
            <div class="parallax-bg"></div>
        </div>

        <!-- RIGHT: HEADING + FOUR QUESTIONNAIRE CARDS -->
        <div class="split-hero-content">

            <div class="split-hero-heading">
                <h1 id="mystyle">Explore Our Finest Wines</h1>
                <p>Discover your taste. Find your perfect wine.</p>
            </div>

            <div class="questionnaire-grid">

                <!-- FIRST SIP -->
                <div class="image-card open-questionnaire-modal"
                    data-questionnaire-id="1">

                    <img decoding="async" src="{{ asset('images/FirstSipTwo.jpg') }}"
                        class="img-fluid" alt="First Sip">

                    <div class="overlay">
                        <div class="overlay-text">
                            <h4 class="default-text">First Sip</h4>
                            <h4 class="hover-text">
                                New to wine? Start with your First Sip.
                                We'll keep it simple and fun.
                            </h4>
                        </div>
                    </div>
                </div>

                <!-- SAVVY SIP -->
                <div class="image-card open-questionnaire-modal"
                    data-questionnaire-id="2">

                    <img decoding="async" src="{{ asset('images/Wineglasses.jpg') }}"
                        class="img-fluid" alt="Savvy Sip">

                    <div class="overlay">
                        <div class="overlay-text">
                            <h4 class="default-text">Savvy Sip</h4>
                            <h4 class="hover-text">
                                Let's fine-tune your sips with Savvy Sipper.
                            </h4>
                        </div>
                    </div>
                </div>

                <!-- CORK MASTER -->
                <div class="image-card open-questionnaire-modal"
                    data-questionnaire-id="3">

                    <img decoding="async" src="{{ asset('images/questionnaire2.jpg') }}"
                        class="img-fluid" alt="Cork Master">

                    <div class="overlay">
                        <div class="overlay-text">
                            <h4 class="default-text">Cork Master</h4>
                            <h4 class="hover-text">
                                Crafted for connoisseurs.
                                Unlock your palate with Cork Master.
                            </h4>
                        </div>
                    </div>
                </div>

                <!-- QUICK POUR -->
                <div class="image-card open-questionnaire-modal"
                    data-questionnaire-id="4">

                    <img decoding="async" src="{{ asset('images/questionnaire3.jpg') }}"
                        class="img-fluid" alt="Quick Pour">

                    <div class="overlay">
                        <div class="overlay-text">
                            <h4 class="default-text">Quick Pour</h4>
                            <h4 class="hover-text">
                                For when you need a wine — quick and right!
                            </h4>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>



  <!-- modal code -->
        {{-- Questionnaire pop-up: shared with the dashboard --}}
        @include('user.partials.questionnaire-modal', ['modalImages' => $modalImages])

@endsection
@push('scripts')

<script>
    $('.open-questionnaire-modal').on('click', function() {
        const id = $(this).data('questionnaire-id');
        // your modal logic here
    });
</script>

    <script>
        document.addEventListener("scroll", function () {
            const scrolled = window.scrollY;
            const parallax = document.querySelector(".parallax-bg");
            if (parallax) {
                parallax.style.transform = `translateY(${scrolled * 0.4}px)`; // adjust 0.4 for speed
            }
        });
    </script>
    


    


@endpush
