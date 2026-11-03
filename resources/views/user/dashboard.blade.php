@extends('layouts.user')
@section('title', 'Dashboard')
@section('admindashboardcontent')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/wine-loader.css') }}?v={{ filemtime(public_path('assets/css/wine-loader.css')) }}">
    <style>
        html, body {
            overscroll-behavior: auto;       
            overflow-x: hidden !important;             
        }
        .card-title 
        {
            font-family: inherit;
        }
        #mystyle
        {
            font-family: 'Cinzel Decorative', serif;
        }
        #loader {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
        .spinner {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
        .card.custom-card {
            position: relative; 
            background-color:white;
        }
        #userdashboard
        {
            background-color:white;
        }
        .custom-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); 
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            background-color: #fff; 
        }
        .custom-card:hover {
            transform: translateY(-5px); 
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }
        #questionnaire_btn
        {
            background-color: #de9313 !important;
            border: 0px;
        }
        #landing-section 
        {
                position: relative;
                height: 100vh; 
        }
        .enlarged-icon {
            width: 60px;
            height: auto;
        }
        .grayscale-img 
        {
            filter: grayscale(100%);
        }
        .video-section 
        {
            position: relative;
            height: 100vh;
            overflow: hidden;
        }
        .bg-video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1;
            transform: translate(-50%, -50%);
            object-fit: cover;
            filter: brightness(0.5);
        }
        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 2rem;
            z-index: 2;
        }
        .video-overlay .content h2 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .video-overlay .content p {
            font-size: 1.25rem;
        }
        .btn-close 
        {
            z-index: 1056 !important; /* Higher than modal backdrop */
        }
        .background-section 
        {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;   
        }
        .background-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('images/Winebottle3.jpg') }}');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            filter: grayscale(100%);
            z-index: -1;
        }
        .overlay 
        {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.4); 
                z-index: 0; 
        }
        .questionnaire-image{
            width:100%;
            height:280px;
            object-fit:contain;
            object-position:center;
            padding:20px;
            background:#fff;
            transition:0.3s ease;
        }
        #explorebtn
        {
            background-color : #dacea1;
            color: #754638;
        }
        #explorebtn:hover 
        {
            background-color: #754638;
            color:#dacea1;
        }
        @media (max-width: 768px) 
        {
            .background-section 
            {
                z-index: 1;
            }
            .background-section::before {
                display: none !important;   
            }
            #myheading 
            {
                color:black!important;
            }
            #mysubheading
            {
                color:black;
            }
            .custom-card {
                width: 100% !important;
                max-width: 100% !important;
                margin-left: auto;
                margin-right: auto;
            }
            .navbar .navbar-toggler .navbar-toggler-icon:before 
            {
                content: "\f479";
                font-family: bootstrap-icons !important;
                position: absolute;
                right:10px;
                font-size: 1rem;
                color: #ffffff!important;
                inset-inline-start: 0;
            }
            .row.g-4 {
                margin: 0 !important;
            }
            .container, .container-fluid {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            .card-img-top {
                width: 100%;
                height: auto;
            }
            .open-questionnaire-modal {
                font-size: 1rem;
                padding: 0.5rem 1rem;
            }
            .scrolled
            {
                background-color: rgba(0, 0, 0,0.7) !important;
                color: black!important;
                font-size : 1.0rem !important;
                z-index: 1000;;
            }
            .video-section {
                position: relative;
                min-height: 300px; 
                overflow: hidden;
                padding: 2rem 1rem;
                background-color: #000; 
            }            
            .bg-video {
                position: absolute;
                width: 100%;
                height: 100%;
                object-fit: cover;
                z-index: 1;
            }
            .video-overlay {
                position: relative;
                z-index: 2;
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1rem;
            }
            .video-overlay .content 
            {
                    position: relative;
                z-index: 3;
            }
            #mainNavbar .container{
                display:flex !important;
                justify-content:flex-end !important;
                align-items:center;
                position:relative;
                padding-right:15px !important;
            }
            .video-overlay .content h2{
                /* font-size:2.6rem;
                line-height:1.2; */
                display: none;
            }
            .video-overlay .content p{
                /* font-size:1.2rem; */
                display: none;
            }
            .mobile-logo{
                height:auto;
                margin-top:10px;
            }
            .questionnaire-image{
                height:220px;
                padding:15px;
            }
        }
        /* Desktop */
        @media (min-width: 992px){
            .questionnaire-image{
                height:320px;
                padding:25px;
            }
        }
        /* Tablet */
        @media (max-width: 991px){
            .questionnaire-image{
                height:260px;
                padding:20px;
            }

        }

        /* hero section slider */
        /* ============================
        WINE HERO IMAGE CAROUSEL
        ============================ */
        #landing-section {
            position: relative;
            min-height: 100vh;
        }
        .hero-carousel {
            position: relative;
            height: 100vh;
            min-height: 600px;
            overflow: hidden;
            background: #160d0b;
        }
        .hero-carousel .carousel-inner,
        .hero-carousel .carousel-item {
            height: 100%;
        }
        .hero-slide-image {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
        /* Dark overlay makes the text readable */
        .hero-slide-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                rgba(12, 7, 6, 0.82) 0%,
                rgba(12, 7, 6, 0.55) 45%,
                rgba(12, 7, 6, 0.12) 100%
            );
        }
        .hero-slide-content {
            position: absolute;
            top: 50%;
            left: 10%;
            right: 10%;
            transform: translateY(-42%);
            max-width: 760px;
            color: #fff;
            z-index: 2;
        }
        .hero-eyebrow {
            display: inline-block;
            margin-bottom: 22px;
            color: #e0c58b;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 3px;
        }
        .hero-slide-content h1 {
            margin-bottom: 22px;
            color: #fff;
            font-family: 'Cinzel Decorative', serif;
            font-size: clamp(2.5rem, 5vw, 5rem);
            font-weight: 600;
            line-height: 1.2;
        }
        .hero-slide-content p {
            max-width: 560px;
            margin-bottom: 32px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.15rem;
            line-height: 1.8;
        }
        .hero-cta {
            display: inline-flex;
            align-items: center;
            gap: 18px;
            padding: 15px 26px;
            border: 1px solid #dacea1;
            border-radius: 0;
            background: #dacea1;
            color: #40251d;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .hero-cta:hover {
            border-color: #fff;
            background: transparent;
            color: #fff;
            transform: translateY(-3px);
        }
        .hero-cta span {
            font-size: 21px;
            transition: transform 0.3s ease;
        }
        .hero-cta:hover span {
            transform: translateX(5px);
        }
        /* Smooth image transition */
        .hero-carousel .carousel-item {
            transition: transform 0.8s ease-in-out,
                        opacity 0.8s ease-in-out;
        }
        /* Indicators */
        .hero-carousel .carousel-indicators {
            z-index: 5;
            margin-bottom: 30px;
        }
        .hero-carousel .carousel-indicators button {
            width: 32px;
            height: 4px;
            margin: 0 5px;
            border: 0;
            background-color: #fff;
            opacity: 0.5;
        }
        .hero-carousel .carousel-indicators button.active {
            background-color: #dacea1;
            opacity: 1;
        }
        /* Arrows */
        .hero-carousel .carousel-control-prev,
        .hero-carousel .carousel-control-next {
            z-index: 4;
            width: 7%;
        }
        /* Mobile layout */
        @media (max-width: 767px) {
            .hero-carousel {
                height: 75vh;
                min-height: 560px;
                max-height: 720px;
            }

            .hero-slide-image {
                object-position: center;
            }
            .hero-slide-overlay {
                background: rgba(12, 7, 6, 0.55);
            }
            .hero-slide-content {
                left: 8%;
                right: 8%;
                transform: translateY(-35%);
                text-align: center;
            }
            .hero-eyebrow {
                font-size: 10px;
                letter-spacing: 2px;
                line-height: 1.8;
            }
            .hero-slide-content h1 {
                font-size: clamp(2rem, 8vw, 3rem);
                line-height: 1.3;
            }
            .hero-slide-content p {
                font-size: 1rem;
                line-height: 1.7;
            }
            .hero-cta {
                justify-content: center;
                padding: 13px 18px;
                font-size: 13px;
            }
            .hero-carousel .carousel-control-prev,
            .hero-carousel .carousel-control-next {
                width: 9%;
            }
        }
        @media (prefers-reduced-motion: reduce) {
            .hero-carousel .carousel-item {
                transition: none;
            }
        }

        /* Questionnaire cards: ivory and gold, equal heights, button on the same line in every card */
        #questionnairesdashboard .qcard {
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: #fbf8f3;
            border: 1px solid #e0c58b;
            border-radius: 0;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        }
        #questionnairesdashboard .qcard:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 34px rgba(0, 0, 0, 0.35);
        }
        #questionnairesdashboard .qcard-media {
            position: relative;
            background: #fff;
            border-bottom: 1px solid #eadfd5;
        }
        #questionnairesdashboard .qcard-tag {
            position: absolute;
            top: 12px;
            left: 12px;
            z-index: 2;
            padding: 5px 9px;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid #7b1e3a;
            color: #7b1e3a;
            font-size: 0.7rem;
            font-weight: 500;
            line-height: 1;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }
        #questionnairesdashboard .qcard-body {
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 20px 20px 16px;
        }
        #questionnairesdashboard .qcard-title {
            margin: 0;
            font-family: 'Cinzel Decorative', serif;
            font-size: 1.35rem;
            font-weight: 700;
            color: #3b0f1a;
        }
        #questionnairesdashboard .qcard-rule {
            width: 40px;
            height: 2px;
            background: #de9313;
        }
        #questionnairesdashboard .qcard-text {
            margin: 0;
            font-size: 0.95rem;
            line-height: 1.55;
            color: #5b4a4e;
        }
        #questionnairesdashboard .qcard-cta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0 20px 20px;
            padding: 12px 16px;
            background: transparent;
            border: 1px solid #7b1e3a;
            border-radius: 0;
            color: #7b1e3a;
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        #questionnairesdashboard .qcard-cta:hover,
        #questionnairesdashboard .qcard-cta:focus-visible {
            background: #7b1e3a;
            color: #fff;
        }
        /* Explore buttons of the Products, Featured Products and Questionnaires rows: one style */
        .section-explore-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            min-width: 180px;
            padding: 13px 28px;
            border: 1px solid #7b1e3a;
            border-radius: 0;
            background: #7b1e3a;
            color: #fff;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            transition: background-color 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease, transform 0.25s ease;
        }
        .section-explore-btn:hover,
        .section-explore-btn:focus-visible {
            border-color: #3b0f1a;
            background: #3b0f1a;
            color: #fff;
            box-shadow: 0 8px 18px rgba(59, 15, 26, 0.25);
            transform: translateY(-2px);
        }
        .section-explore-btn svg {
            transition: transform 0.25s ease;
        }
        .section-explore-btn:hover svg,
        .section-explore-btn:focus-visible svg {
            transform: translateX(4px);
        }

        #questionnairesdashboard .qcard-cta svg {
            transition: transform 0.2s ease;
        }
        #questionnairesdashboard .qcard-cta:hover svg {
            transform: translateX(4px);
        }

    </style>

@endpush
        <!-- Start::app-content -->
        <!-- Landing Section -->
            <section id="landing-section">
               <!-- Slider -->
                <!-- Hero Image Carousel -->
                <section id="wineHeroCarousel"
                        class="carousel slide carousel-fade hero-carousel"
                        data-bs-ride="carousel"
                        data-bs-interval="5000"
                        data-bs-pause="false">

                    <!-- Slide indicators -->
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#wineHeroCarousel"
                                data-bs-slide-to="0" class="active"
                                aria-current="true" aria-label="Slide 1"></button>

                        <button type="button" data-bs-target="#wineHeroCarousel"
                                data-bs-slide-to="1" aria-label="Slide 2"></button>

                        <button type="button" data-bs-target="#wineHeroCarousel"
                                data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>

                    <div class="carousel-inner">

                        <!-- Slide 1 -->
                        <div class="carousel-item active">
                            <img fetchpriority="high" decoding="async"
                                src="{{ asset('images/redonenew.jpg') }}"
                                class="hero-slide-image"
                                alt="Wine glass and bottle">

                            <div class="hero-slide-overlay"></div>

                            <div class="hero-slide-content">
                                <span class="hero-eyebrow">YOUR WINE JOURNEY STARTS HERE</span>

                                <h1>Discover the Wine<br>That Speaks to You</h1>

                                <p>
                                    Every great wine has a story.
                                    Find the one that speaks to you.
                                </p>

                                <a href="#questionnairesdashboard"
                                class="btn hero-cta">
                                    Discover Your Wine <span>&rarr;</span>
                                </a>
                            </div>
                        </div>

                        <!-- Slide 2 -->
                        <div class="carousel-item">
                            <img fetchpriority="low" decoding="async"
                                src="{{ asset('images/wineyarddashboard.jpg') }}"
                                class="hero-slide-image"
                                alt="Wine country and vineyards">

                            <div class="hero-slide-overlay"></div>

                            <div class="hero-slide-content">
                                <span class="hero-eyebrow">EXPLORE. TASTE. ENJOY.</span>

                                <h1>From the Vineyard<br>to Your Glass</h1>

                                <p>
                                    Explore exceptional wines and discover
                                    new favourites from our curated collection.
                                </p>

                                <a href="{{ route('user.products') }}"
                                class="btn hero-cta">
                                    Explore Our Collection <span>&rarr;</span>
                                </a>
                            </div>
                        </div>

                        <!-- Slide 3 -->
                        <div class="carousel-item">
                            <img fetchpriority="low" decoding="async"
                                src="{{ asset('images/perfectpour.jpg') }}"
                                class="hero-slide-image"
                                alt="Elegant wine tasting">

                            <div class="hero-slide-overlay"></div>

                            <div class="hero-slide-content">
                                <span class="hero-eyebrow">MADE FOR YOUR PALATE</span>

                                <h1>Find Your<br>Perfect Pour</h1>

                                <p>
                                    Tell us what you love, and let us help
                                    you find a wine for every occasion.
                                </p>

                                <a href="{{ route('user.showQuestionnaire') }}"
                                class="btn hero-cta">
                                    Find Your Perfect Pour <span>&rarr;</span>
                                </a>
                            </div>
                        </div>

                    </div>

                    <!-- Previous and next arrows -->
                    <button class="carousel-control-prev"
                            type="button"
                            data-bs-target="#wineHeroCarousel"
                            data-bs-slide="prev"
                            aria-label="Previous slide">
                        <span class="carousel-control-prev-icon"
                            aria-hidden="true"></span>
                    </button>

                    <button class="carousel-control-next"
                            type="button"
                            data-bs-target="#wineHeroCarousel"
                            data-bs-slide="next"
                            aria-label="Next slide">
                        <span class="carousel-control-next-icon"
                            aria-hidden="true"></span>
                    </button>

                </section>


            </section>

            <!-- Scrollable Content Section Starts-->
                <!-- Second Sectin starts -->
                    <div class="container-fluid p-0">
                        <!-- card container row starts -->
                        <section class="background-section">
                            <div class="container py-5 text-white px-0">
                                <div class="row">
                                    <!-- Title and Description -->
                                    <div class="col-12 text-center mb-4">
                                        <div class="overlay"></div>
                                        <h2 class="fw-bold display-6" id="myheading">Help us choose your perfect wine</h2>
                                        <p class="fs-5" id="mysubheading">Answer a few simple questions to get the best recommendations tailored just for you.</p>
                                        
                                    </div>
                                    <!-- Cards -->
                                    <div class="col-12" id="questionnairesdashboard">
                                        <div class="row g-4">
                                            <!-- Card 1 -->
                                            <div class="col-12 col-md-6 col-lg-3">
                                                <div class="card custom-card qcard">
                                                    <div class="qcard-media">
                                                        <span class="qcard-tag">Beginner</span>
                                                        <img loading="lazy" decoding="async" src="{{ asset(($cardImages[0] ?? 'images/FirstPour.jpeg')) }}" class="card-img-top questionnaire-image" alt="First Sip">
                                                    </div>
                                                    <div class="qcard-body">
                                                        <h4 class="qcard-title">First Sip</h4>
                                                        <span class="qcard-rule" aria-hidden="true"></span>
                                                        <p class="qcard-text">New to wine? Start with your First Sip — we'll keep it simple and fun.</p>
                                                    </div>
                                                    <button class="btn qcard-cta open-questionnaire-modal" data-questionnaire-id="1">
                                                        Start First Sip
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Card 2 -->
                                            <div class="col-12 col-md-6 col-lg-3">
                                                <div class="card custom-card qcard">
                                                    <div class="qcard-media">
                                                        <span class="qcard-tag">Intermediate</span>
                                                        <img loading="lazy" decoding="async" src="{{ asset(($cardImages[1] ?? 'images/SavySipper.png')) }}" class="card-img-top questionnaire-image" alt="Savy Sip">
                                                    </div>
                                                    <div class="qcard-body">
                                                        <h4 class="qcard-title">Savy Sip</h4>
                                                        <span class="qcard-rule" aria-hidden="true"></span>
                                                        <p class="qcard-text">Let’s fine-tune your sips with Savy Sipper.</p>
                                                    </div>
                                                    <button class="btn qcard-cta open-questionnaire-modal" data-questionnaire-id="2">
                                                        Start Savy Sip
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Card 3 -->
                                            <div class="col-12 col-md-6 col-lg-3">
                                                <div class="card custom-card qcard">
                                                    <div class="qcard-media">
                                                        <span class="qcard-tag">Connoisseur</span>
                                                        <img loading="lazy" decoding="async" src="{{ asset(($cardImages[2] ?? 'images/CorkMaster.jpeg')) }}" class="card-img-top questionnaire-image" alt="Cork Master">
                                                    </div>
                                                    <div class="qcard-body">
                                                        <h4 class="qcard-title">Cork Master</h4>
                                                        <span class="qcard-rule" aria-hidden="true"></span>
                                                        <p class="qcard-text">Crafted for connoisseurs — unlock your palate with Cork Master.</p>
                                                    </div>
                                                    <button class="btn qcard-cta open-questionnaire-modal" data-questionnaire-id="3">
                                                        Start Cork Master
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- Card 4 -->
                                            <div class="col-12 col-md-6 col-lg-3">
                                                <div class="card custom-card qcard">
                                                    <div class="qcard-media">
                                                        <span class="qcard-tag">Quick</span>
                                                        <img loading="lazy" decoding="async" src="{{ asset(($cardImages[3] ?? 'images/QuickPour1.png')) }}" class="card-img-top questionnaire-image" alt="Quick Pour">
                                                    </div>
                                                    <div class="qcard-body">
                                                        <h4 class="qcard-title">Quick Pour</h4>
                                                        <span class="qcard-rule" aria-hidden="true"></span>
                                                        <p class="qcard-text">For when you need a wine — quick and right.</p>
                                                    </div>
                                                    <button class="btn qcard-cta open-questionnaire-modal" data-questionnaire-id="4">
                                                        Start Quick Pour
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                <!-- Second Section ends -->
                
                <!-- Third Section starts-->
                <div class="container-fluid py-5 bg-white ">
                    <!-- Section with alternating image and text -->
                    <section>
                        <!-- Row 1: Image Left, Text Right -->
                        <div class="row g-0 align-items-center">
                            <div class="col-md-6">
                                <img loading="lazy" decoding="async" width="1920" height="1280" src="{{ asset('images/Blacklabel.jpg') }}" class="img-fluid w-100" alt="Image Left">
                            </div>
                            <div class="col-md-6 text-center p-3">
                                <h1 id="mystyle">Products</h1>
                                <h4 class="mb-5">Welcome to the Cellar !!</h4>
                                <p class="fs-20">Discover our curated collection of fine spirits and exceptional beverages, handpicked from 
                                    around the world. Whether you're a connoisseur or a casual enthusiast, our cellar offers 
                                    something special for every palate. Explore and indulge in quality like never before.</p>
                                    <a class="btn section-explore-btn" href="{{ route('user.products') }}">
                                        Explore <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="M13 6l6 6-6 6"/></svg>
                                    </a>
                            </div>
                            
                        </div>

                        <!-- Row 2: Text Left, Image Right -->
                        <div class="row g-0 align-items-center flex-md-row-reverse">
                            <div class="col-md-6">
                                <img loading="lazy" decoding="async" width="1920" height="1280" src="{{ asset('images/Redlabel.jpg') }}" class="img-fluid w-100" alt="Image Right">
                            </div>
                            <div class="col-md-6 text-center p-5">
                                <h1 id="mystyle">Featured Products</h1>
                                <h4 class="mb-5">Handpicked Elegance. Uncork the Best.</h4>
                                <p class="fs-20">Our featured selection showcases the finest bottles from our collection—chosen for their 
                                    exceptional quality, taste, and craftsmanship. From bold reds to smooth whiskeys, these 
                                    standout products represent the very best of what we offer. Perfect for gifting or savoring 
                                    yourself.</p>
                                    <a class="btn section-explore-btn" href="{{ route('user.featuredproducts') }}">
                                        Explore <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="M13 6l6 6-6 6"/></svg>
                                    </a>
                            </div>
                        </div>

                        <!-- Row 3: Image Left, Text Right -->
                        <div class="row g-0 align-items-center">
                            <div class="col-md-6">
                                <img loading="lazy" decoding="async" width="2016" height="1512" src="{{ asset('images/QuestionnaireImage.jpg') }}" class="img-fluid w-100" alt="Image Left">
                            </div>
                            <div class="col-md-6 text-center p-5">
                                <h1 id="mystyle">Questionnaires</h1>
                                <h4 class="mb-5">Find Your perfect pour</h4>
                                <p class="fs-20">Explore our curated questionnaire to uncover your ideal wine match. 
                                    Whether you're a seasoned connoisseur or just beginning your journey, our tailored questions 
                                    will guide you to the perfect bottle for your taste and occasion.</p>
                                    <a class="btn section-explore-btn" href="{{ route('user.showQuestionnaire') }}">
                                        Explore <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="M13 6l6 6-6 6"/></svg>
                                    </a>
                                
                            </div>
                        </div>
                    </section>
                </div>
                <!-- Third section ends -->

                <!-- Video Parallax section -->

                <!-- Video Parallax Section -->
                    <section class="video-section">
                        <div class="video-overlay">
                            <div class="content text-center text-white">
                                <h2 class="display-4">Experience the Essence</h2>
                                <p class="lead">Dive into the story behind every bottle.</p>
                                <a class="btn btn-light" type="button" href="{{ route('user.products') }}">
                                    Explore 
                                </a>
                            </div>
                        </div>
                        <video class="bg-video" autoplay muted loop playsinline>
                            <source src="{{ asset('images/WineVideo.mov') }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </section>
                <!-- Video Parallax section -->
            <!-- Scrollable Content Section Ends-->



        <!-- modal code -->
        {{-- Questionnaire pop-up: shared with the Questionnaires page; cards open it on the first click --}}
        @include('user.partials.questionnaire-modal', ['modalImages' => $modalImages, 'openOnFirstClick' => true])

@endsection
@push('scripts')


    <script>
        window.addEventListener("scroll", function () {
            const navbar = document.getElementById("mainNavbar");
            if (window.scrollY > 50) 
            {
                navbar.classList.add("scrolled"); 
            } else {
                navbar.classList.remove("scrolled");
            }
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
    

    
    <!-- auto scroll dashboard -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let inactivityTimer;
            let scrollTimer;
            let isAutoScrolling = false;

            const INACTIVITY_LIMIT = 1 * 60 * 1000; // 1 minutes
            const SCROLL_SPEED = 2;
            const SCROLL_INTERVAL = 50;

            function stopAutoScroll() {
                isAutoScrolling = false;

                if (scrollTimer) {
                    clearInterval(scrollTimer);
                    scrollTimer = null;
                }
            }

            function startAutoScroll() {
                if (isAutoScrolling) return;

                const maxScroll =
                    document.documentElement.scrollHeight - window.innerHeight;

                if (maxScroll <= 0) return;

                isAutoScrolling = true;
                let direction = 1;

                scrollTimer = setInterval(function () {
                    const currentMax =
                        document.documentElement.scrollHeight - window.innerHeight;

                    if (currentMax <= 0) {
                        stopAutoScroll();
                        return;
                    }

                    if (direction === 1) {
                        window.scrollBy(0, SCROLL_SPEED);

                        if (window.scrollY >= currentMax - 2) {
                            direction = -1;
                        }
                    } else {
                        window.scrollBy(0, -SCROLL_SPEED);

                        if (window.scrollY <= 2) {
                            direction = 1;
                        }
                    }
                }, SCROLL_INTERVAL);
            }

            function resetInactivityTimer() {
                stopAutoScroll();

                clearTimeout(inactivityTimer);

                inactivityTimer = setTimeout(function () {
                    startAutoScroll();
                }, INACTIVITY_LIMIT);
            }

            const userEvents = [
                'mousemove',
                'mousedown',
                'wheel',
                'touchstart',
                'keydown',
                'click',
                'pointerdown'
            ];

            userEvents.forEach(function (eventName) {
                document.addEventListener(eventName, resetInactivityTimer, {
                    passive: true
                });
            });

            // Start the five-minute inactivity countdown on page load.
            resetInactivityTimer();
        });
    </script>
    


        

   
@endpush
