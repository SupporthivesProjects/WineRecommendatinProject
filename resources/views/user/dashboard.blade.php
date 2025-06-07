
@extends('layouts.bootdashboard')
@section('admindashboardcontent')
@push('styles')

    <style>
        html, body {
            overscroll-behavior: none;       
            overflow-x: hidden;             
        }

        .card-title 
        {
            font-family: 'Cinzel Decorative', serif;
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

        #question-container h5 {
            font-size: 1.6rem;
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        #question-container .form-check-input {
            width: 20px;
            height: 20px;
            border: 2px solid #6c757d;
            border-radius: 50%;
            margin-right: 10px;
            cursor: pointer;
        }
    
        #question-container .form-check {
            margin-bottom: 1rem; 
        }

        #question-container .form-check-label {
            font-size: 1.1rem;
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

        .slider-container {
            position: relative;
            padding: 10px 0;
        }


        .emoji-icon {
            font-size: 3.0rem;
            line-height: 1;
        }

       

        .option-text {
            font-size: 1rem;
            line-height: 1.2;
        }

        .modal.fade .modal-dialog {
            transition: transform 0.5s ease-out, opacity 0.5s ease-out;
            transform: translateY(-20px);
            opacity: 0;
        }

        .modal.fade.show .modal-dialog {
            transform: translateY(0);
            opacity: 1;
        }

        .btn-close.white-close {
            filter: invert(1) brightness(2);
        }



        .modal-content {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            /* background: linear-gradient(to bottom, #ffffff, #f9f9f9); */
            background: radial-gradient(
            ellipse at right top,
            #00458f8f 0%,
            #151419 45%,
            #151419 100%
            );
            opacity: 0.95;
            overflow: hidden;
            transition: all 0.3s ease-in-out;
        }

        .lottie-container {
            /* background-color: #f0f4f8; */
            background-color: #acfbff;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        #question-container h5 {
            font-weight: 600;
            font-size: 1.25rem;
            margin-bottom: 1rem;
            color: #333;
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
                background: url('{{ asset('images/redlabel.jpg') }}') no-repeat center center/cover;
                background-attachment: fixed; 
                z-index: 1;
                
        }

        #mainNavbar {
            z-index: 999;
            background-color: transparent;
            position:fixed; 
            padding: 20px 0;
            width: 100%;
            right: 0px;
            color:white;
            font-size : 1.0rem;
            transition: background-color 0.3s ease;
            border-radius: 0px;
        }
        

        .scrolled
        {
            background-color: rgba(0, 0, 0, 0.5) !important;
            color: black!important;
            font-size : 1.0rem !important;
            z-index:2000!important;
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
            background-image: url('{{ asset('images/winebottle3.jpg') }}');
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

        html, body {
            overflow-x: hidden;
        }


        @media (max-width: 768px) {
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
        }

        @media (max-width: 768px) {
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
        }

        @media (max-width: 768px) 
        {
            .video-section {
                position: relative;
                min-height: 300px; /* adjust as needed */
                overflow: hidden;
                padding: 2rem 1rem;
                background-color: #000; /* fallback in case video doesn't load */
            }

            .bg-video {
                position: absolute;
                top: 0;
                left: 0;
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


        .emoji-img {
            width: 60px;
            height:60px;
            transition: transform 0.2s ease;
            filter: invert(1) brightness(2);

        }

        .option-box {
            border-radius: 12px;
            height: 120px;
            background-color: transparent !important;
            border: 1px solid #ddd;
            height: 120px;
            text-align: center;
        }

        .option-box.active {
            border-color: #0d6efd;
            background-color: #e6f0ff;
        }

        .option-box:hover .emoji-img {
            transform: scale(1.1);
            filter: brightness(1.1); /* Example effect */
            color:white;
        }

        .option-box:hover {
            background-color: transparent !important;
            border-color: rgb(98,89,202) !important; /* or any static color */
            color: white !important;
        }

    </style>

@endpush
        <!-- Start::app-content -->
        <!-- Landing Section -->
            <section id="landing-section">
                <!-- Navbar (stays on top of landing image) -->
                <nav id="mainNavbar" class="navbar navbar-expand-lg ">
                    <div class="container ">
                        <a class="navbar-brand text-white" href="#">
                            <lottie-player 
                                src="{{ asset('Lottie/Animation - 1745878648192.json') }}"
                                background="transparent" 
                                speed="1"  
                                style="width: 40px; height: 40px;" 
                                loop 
                                autoplay>
                            </lottie-player>
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                            <!-- Left-aligned nav items -->
                            <ul class="navbar-nav">
                                <li class="nav-item"><a href="{{ route('user.dashboard') }}" class="nav-link text-white">Dashboard</a></li>
                                <li class="nav-item"><a href="{{ route('user.showQuestionnaire') }}" class="nav-link text-white">Questionnaires</a></li>
                                <li class="nav-item"><a href="{{ route('user.products') }}" class="nav-link text-white">Browse Wines</a></li>
                                <li class="nav-item"><a href="{{ route('user.featuredproducts') }}" class="nav-link text-white">Featured Products</a></li>
                            </ul>

                            <!-- Right-aligned logout button -->
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                        @csrf
                                        <a class="nav-link text-white d-flex align-items-center"  href="{{ route('logout') }}" 
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fe fe-power fs-16 align-middle me-2"></i> {{ __('Log Out') }}
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <!-- Centered Text on Landing Image -->
                <div class="d-flex justify-content-end align-items-center text-end text-white" style="height: 100vh; padding-right: 50px;">
                    <div>
                        <h1 class="display-3 fw-bold" style="color: #dacea1;">
                            Discover the Wine That <br>
                            <span style="color: #754638;">Speaks to You</span>
                            <br>
                            <a href="#questionnairesdashboard" type="button" class="btn" id="explorebtn">Explore</a>
                        </h1>
                    </div>
                </div>

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
                                                <div class="card custom-card    ">
                                                    <div class="questionnaire-label">First Sip</div>
                                                    <img src="{{ asset('images/wineglasses.jpg') }}" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fw-semibold mb-0">New to wine? Start with your First Sip — we'll keep it simple and fun.</h5>                                                       </h5>
                                                    </div>
                                                    <div class="text-center">
                                                        <button class="btn btn-danger open-questionnaire-modal w-100" data-questionnaire-id="1" id="questionnaire_btn">
                                                            I want to try now !!
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon move-arrow" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card 2 -->
                                            <div class="col-12 col-md-6 col-lg-3">
                                                <div class="card custom-card">
                                                    <div class="questionnaire-label">Savy Sip</div>
                                                    <img src="{{ asset('images/questionnaire2.jpg') }}" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fw-semibold mb-0">Let’s fine-tune your sips with Savy Sipper.</h5>
                                                    </div>
                                                    <div class="text-center">
                                                        <button class="btn btn-danger open-questionnaire-modal w-100" data-questionnaire-id="2" id="questionnaire_btn">
                                                            I want to try now !!
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon move-arrow" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card 3 -->
                                            <div class="col-12 col-md-6 col-lg-3">
                                                <div class="card custom-card">
                                                    <div class="questionnaire-label">Cork Master</div>
                                                    <img src="{{ asset('images/questionnaire3.jpg') }}" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fw-semibold mb-0">Crafted for connoisseurs — unlock your palate with Cork Master.</h5>
                                                    </div>
                                                    <div class="text-center">
                                                        <button class="btn btn-danger open-questionnaire-modal w-100" data-questionnaire-id="3" id="questionnaire_btn">
                                                            I want to try now !!
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon move-arrow" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Card 4 -->
                                            <div class="col-12 col-md-6 col-lg-3">
                                                <div class="card custom-card">
                                                    <div class="questionnaire-label">Quick Pour</div>
                                                    <img src="{{ asset('images/wineglasses.jpg') }}" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title fw-semibold mb-0">For when you need a wine—quick and right.!!</h5>
                                                    </div>
                                                    <div class="text-center">
                                                        <button class="btn btn-danger open-questionnaire-modal w-100" data-questionnaire-id="4" id="questionnaire_btn">
                                                            I want to try now !!
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon move-arrow" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
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
                                <img src="{{ asset('images/blacklabel.jpg') }}" class="img-fluid w-100" alt="Image Left">
                            </div>
                            <div class="col-md-6 text-center p-3">
                                <h1 id="mystyle">Products</h1>
                                <h4 class="mb-5">Welcome to the Cellar !!</h4>
                                <p class="fs-20">Discover our curated collection of fine spirits and exceptional beverages, handpicked from 
                                    around the world. Whether you're a connoisseur or a casual enthusiast, our cellar offers 
                                    something special for every palate. Explore and indulge in quality like never before.</p>
                                    <a class="btn btn-dark" type="button" href="{{ route('user.products') }}">
                                        Explore 
                                    </a>
                            </div>
                            
                        </div>

                        <!-- Row 2: Text Left, Image Right -->
                        <div class="row g-0 align-items-center flex-md-row-reverse">
                            <div class="col-md-6">
                                <img src="{{ asset('images/Redlabel.jpg') }}" class="img-fluid w-100" alt="Image Right">
                            </div>
                            <div class="col-md-6 text-center p-5">
                                <h1 id="mystyle">Featured Products</h1>
                                <h4 class="mb-5">Handpicked Elegance. Uncork the Best.</h4>
                                <p class="fs-20">Our featured selection showcases the finest bottles from our collection—chosen for their 
                                    exceptional quality, taste, and craftsmanship. From bold reds to smooth whiskeys, these 
                                    standout products represent the very best of what we offer. Perfect for gifting or savoring 
                                    yourself.</p>
                                    <a class="btn btn-light" type="button" href="{{ route('user.featuredproducts') }}">
                                        Explore 
                                    </a>
                            </div>
                        </div>

                        <!-- Row 3: Image Left, Text Right -->
                        <div class="row g-0 align-items-center">
                            <div class="col-md-6">
                                <img src="{{ asset('images/QuestionnaireImage.jpg') }}" class="img-fluid w-100" alt="Image Left">
                            </div>
                            <div class="col-md-6 text-center p-5">
                                <h1 id="mystyle">Questionnaires</h1>
                                <h4 class="mb-5">Find Your perfect pour</h4>
                                <p class="fs-20">Explore our curated questionnaire to uncover your ideal wine match. 
                                    Whether you're a seasoned connoisseur or just beginning your journey, our tailored questions 
                                    will guide you to the perfect bottle for your taste and occasion.</p>
                                    <a class="btn btn-light" type="button" href="{{ route('user.showQuestionnaire') }}">
                                        Explore 
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
                                <button class="btn btn-light">
                                    Explore 
                                </button>
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
        <div class="modal fade" id="questionnaireModal" tabindex="-1" aria-hidden="true" style="background:rgba(0,0,0,0.7)!important;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body d-flex flex-column p-0 position-relative">

                        <!-- Close button (top-right) -->
                        <!-- <button type="button" class="btn-close position-absolute top-0 end-0 m-3 text-white" data-bs-dismiss="modal" aria-label="Close"></button> -->
                        <button type="button" class="btn-close white-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>


                        <!-- Lottie Animation -->
                        <!-- <div class="lottie-container w-100" id="lottieAnimation" style="height: 250px; width: auto;"></div> -->

                        <!-- Question Side -->
                        <div class="w-100 p-4 d-flex flex-column justify-content-between">
                            <div id="question-container">
                                <!-- Question and options will load here -->
                            </div>

                            <!-- Buttons Row -->
                            <div class="d-flex mt-4 gap-2">
                                <button class="btn btn-danger btn-lg w-50" id="backBtn">Back</button>
                                <button class="btn btn-success btn-lg w-50" id="nextBtn">Next</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


@endsection
@push('scripts')
    @if(session('success') || session('error'))
        <script>
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showDuration": "300",
                "hideDuration": "1000",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            @if(session('success'))
                toastr.success(@json(session('success')));
            @endif

            @if(session('error'))
                toastr.error(@json(session('error')));
            @endif
        </script>
    @endif

    <script>
            let questions = [];
            let currentStep = 0;
            let responses = {};  
            let selectedQuestionnaireId = null;

            const emojiMap = 
            {
                "Red": "red",
                "White": "white",
                "Rosé": "Rosé",
                "Fruit": "fruit",
                "Sparkling / Champagne": "sparkling_champagne",
                "Yes": "Yes",
                "No": "No",
                "SKIP": "Skip",
                "Fruit Wine": "fruit",
                "Still": "Still",
                "Sparkling": "Sparkling_champagne",
                "Sparkling/Champagne": "Sparkling_champagne",
                "Sweet": "Sweet",
                "Medium Sweet": "Medium_Sweet",
                "Lightly Sweet": "Lightly_sweet",
                "Dry": "Dry",
                "Skip": "Skip",
                "Fruit-Driven": "Fruit-Driven",
                "Juicy/Fruit-Forward": "JuicyFruit-Forward",
                "Aromatic": "Aromatic",
                "Earthy": "Earthy",
                "Mineral-Driven": "Mineral-Driven",
                "Light-bodied (Soft & Refreshing)": "Light-bodied-Soft-Refreshing",
                "Medium-bodied (Balanced & Smooth)": "Medium-bodied-(Rich & Intense)",
                "Full-bodied (Rich & Intense)": "Full-bodied-(Rich & Intense)",
                "Very Fruity": "VeryFruity",
                "Slightly Fruity": "SlightlyFruity",
                "Not Fruity": "NotFruity",
                "Young and Refreshing": "YoungandRefreshing",
                "Bold and Old": "BoldandOld",
                "Any": "Any",
                "India": "India",
                "France": "France",
                "Italy": "Italy",
                "Spain": "Spain",
                "Australia": "Australia",
                "USA": "Usa",
                "Rest of the World": "RestofTheWorld",
                "Budget": "💰",
                "Everyday sipping": "Everydaysipping",
                "Celebration": "Celebration",
                "Gifting": "Gifting",
                "Dinner with Friends": "🍽️",
                "Wine and Cheese": "🧀🍷",
                "Pairing with food (Coming Soon)": "Pairingwithfood(ComingSoon)",
                "Semi-Sweet": "🍇🍯",
                "Off-Dry (Lightly Sweet)": "🍷🍃",
                "Dry (Not Sweet)": "🍇🍋",
                "No Preference": "🤷",
                "Bordeaux (France)": "🍷🇫🇷",
                "Burgundy (France)": "🍇🇫🇷",
                "Champagne (France)": "🥂🇫🇷",
                "Rhône Valley (France)": "🌱🇫🇷",
                "Tuscany (Italy)": "🍇🇮🇹",
                "Piedmont (Italy)": "🍇🍷🇮🇹",
                "Veneto (Italy)": "🍇🍷🇮🇹",
                "Rioja (Spain)": "🍇🇪🇸",
                "Ribera del Duero (Spain)": "🍷🇪🇸",
                "Napa Valley (USA)": "🍇🇺🇸",
                "Sonoma (USA)": "🍷🇺🇸",
                "Barossa Valley (Australia)": "🍇🇦🇺",
                "Margaret River (Australia)": "🍷🇦🇺",
                "Marlborough (New Zealand)": "🍇🇳🇿",
                "Chardonnay": "🍇🥂",
                "Riesling": "🍇🍯",
                "Sauvignon Blanc": "🍇🌿",
                "Chenin Blanc": "🍇🍯",
                "Pinot Noir": "🍇🍷",
                "Cabernet Sauvignon": "🍇🍷",
                "Merlot": "🍇🍷",
                "Syrah/Shiraz": "🍇🍷",
                "Refreshingly Young (1-3 years)": "🍃🍷",
                "Fairly Young (3-5 years)": "🍇🌱",
                "Slightly Aged (5-7 years)": "🍂🍷",
                "Aged (>7 years)": "🍷🕰️",
                "Nuts, Dried, Cooked, Fresh, Caramel, Jammy": "🍑🍲",
                "Earthy, Moldy, Petroleum, Sulfur, Minerality": "💨🪨",
                "Yeasty, Lactic, Floral, Spicy, Citrus, Berry, Fruity, Tropical": "🍞🥛",
                "Herbaceous, Vegetative": "🌿🍃",
                "Surprise Me": "🎉",
                "Fortified": "🍷🍾",
                "Varietal": "🍇",
                "Blends": "🍷🔄🍇",
                "Noble Grapes": "🍇👑",
                "Regional Hero Grapes": "🍇🏆",
                "Domestic Indian": "🇮🇳🍷",
                "Old World (France, Germany, Italy, Spain, Portugal, Austria)": "🌍🍷",
                "New World (USA, Chile, Australia, Argentina)": "🌍🍷",
                "Brut": "🥂🍾",
                "Dry": "Dry",
                "Off-Dry": "🍷🍃",
                "Semi Sweet": "🍇🍯",
                "Sweet-Dessert": "🍬🍰",
                "Young (1-2 years)": "🌱🍇",
                "Fairly Young (2-5 years)": "🌿🍷",
                "Slightly Aged (5-7 years)": "🍂🍷",
                "Well-Aged (8-10 years)": "🍷🕰️",
                "Fully Matured (10 years and above)": "🍷🍇",
                "Acidity: Low, Light to medium, Medium to high, High": "🥴🍷",
                "Tannins: Low, Light to medium, Medium to high, High":"🍃🍷",
                "Body: Light bodied/ Medium bodied/ Full bodied": "🥃🍷",
                "Acidity: Light to medium": "🍋🍷",
                "Acidity: Medium to high": "🍋🔥",
                "Acidity: High": "🍋🔥",
                "Tannins: Low": "🌿🍷",
                "Tannins: Light to medium": "🍃🍷",
                "Tannins: Medium to high": "🍂🍷",
                "Body: Light bodied": "☁️🍷",
                "Body: Medium bodied": "🥃🍷",
                "Body: Full bodied": "💪🍷",
                "Bold": "🔥🍷",
                "Crisp": "❄️🍷",
                "Rich": "💰🍷",
                "Light": "🌞🍷",
                "Medium-bodied": "🥃🍷",
                "Aromatic": "Aromatic",
                "Fruit-driven": "🍇🍷",
                "Dry": "Dry",
                "Mineral-Driven": "Mineral-Driven",
                "Earthy": "Earthy",
                "Juicy / Fruit-Forward": "🍉🍷",
                "Elegant / Refined": "💎🍷",
                "Chile" : "🇨🇱",
                "Portugal" : "🇵🇹",
                "Argentina" : "🇦🇷",
                "England": "🇬🇧",
                "South Africa" : "🇿🇦",
                "New Zealand" : "🇳🇿"
            };



            document.querySelectorAll('.open-questionnaire-modal').forEach(button => {
                button.addEventListener('click', function () {
                    selectedQuestionnaireId = this.getAttribute('data-questionnaire-id');
                    console.log("Selected questionnaire ID:", selectedQuestionnaireId);

                    // Optional: reset previous responses and local storage
                    responses = {};
                    localStorage.removeItem('userResponses');
                });
            });


            document.querySelectorAll('.open-questionnaire-modal').forEach(button => {
                button.addEventListener('click', function () {
                    const questionnaireId = this.getAttribute('data-questionnaire-id');

                    fetch(`/get-questions/${questionnaireId}`)
                        .then(response => {
                            console.log(`Fetching questions for questionnaire ID: ${questionnaireId}`);
                            console.log('Response status:', response.status);

                            if (!response.ok) {
                                console.error(`Error fetching questions: ${response.status} ${response.statusText}`);
                                throw new Error('Failed to fetch questions.');
                            }

                            return response.json();
                        })
                        .then(data => {
                            console.log('Raw question data received:', data);

                            if (!Array.isArray(data) || data.length === 0) {
                                console.warn('No questions returned or data format is incorrect:', data);
                                alert('No questions available for this questionnaire.');
                                return;
                            }

                            // Store and use the data
                            questions = data;
                            currentStep = 0;
                            console.log(`Loaded ${questions.length} questions. Initializing questionnaire modal...`);

                            renderQuestion();
                            new bootstrap.Modal(document.getElementById('questionnaireModal')).show();
                        })
                        .catch(error => {
                            console.error('An error occurred while loading questions:', error);
                            alert('Something went wrong while loading the questionnaire. Please try again.');
                        });

                });
            });

    
            function renderQuestion() 
            {
                const container = document.getElementById('question-container');

                // First screen: render 3 questions together
                if (currentStep === 0) {
                    let combinedHtml = '';
                    for (let i = 0; i < 3 && i < questions.length; i++) {
                        if (!questions[i].id) {
                            questions[i].id = `question${i + 1}`;
                        }

                        combinedHtml += `<div class="mb-4">
                            <h5 class="text-dark">${questions[i].question}</h5>
                            ${renderQuestionHTML(questions[i], i)}
                        </div>`;
                    }

                    container.innerHTML = combinedHtml;
                    setupEventsForBatch([0, 1, 2]);
                    document.getElementById('backBtn').disabled = true;
                    return;
                }

                // For questions beyond the first 3
                if (currentStep >= questions.length) return;

                const q = questions[currentStep];
                if (!q.id) {
                    q.id = `question${currentStep + 1}`;
                }

                container.innerHTML = `
                    <h5 class='text-dark'>${q.question}</h5>
                    ${renderQuestionHTML(q, currentStep)}
                `;

                setupEventsForBatch([currentStep]);
                document.getElementById('backBtn').disabled = currentStep === 3;
            }

            function renderQuestionHTML(q, qIndex) 
            {
                if (q.type === 'slider') {
                    const min = q.min_value ?? 0;
                    const max = q.max_value ?? 10000;
                    const step = q.step ?? 100;
                    const defaultValue = q.default ?? min;

                    let tickMarks = '';
                    for (let i = min; i <= max; i += step) {
                        tickMarks += `<option value="${i}"></option>`;
                    }

                    return `
                        <input 
                            type="range" 
                            class="form-range" 
                            id="budgetSlider${qIndex}" 
                            min="${min}" 
                            max="${max}" 
                            step="${step}" 
                            value="${defaultValue}" 
                            list="tickmarks${qIndex}"
                        >
                        <datalist id="tickmarks${qIndex}">${tickMarks}</datalist>
                        <div class="d-flex justify-content-between text-muted mt-2">
                            <small>₹${min}</small>
                            <small>Selected: ₹<span id="sliderValue${qIndex}">${defaultValue}</span></small>
                            <small>₹${max}</small>
                        </div>
                    `;
                }

                if (q.type === 'input') {
                    return `<input type="text" class="form-control" id="textInputAnswer${qIndex}" placeholder="Enter your answer">`;
                }

                if ((q.type === 'single' || q.type === 'multiple') && Array.isArray(q.options)) {
                    const inputType = q.type === 'single' ? 'radio' : 'checkbox';
                    let rowHtml = '';
                    let optionsHtml = '';

                    q.options.forEach((opt, idx) => {
                        const basePath = '/questionnaire';
                        const emoji = emojiMap[opt]
                            ? `<div class="emoji-icon mb-1">
                                    <img 
                                        src="${basePath}/${emojiMap[opt]}-mono.svg"
                                        data-mono="${basePath}/${emojiMap[opt]}-mono.svg"
                                        data-color="${basePath}/${emojiMap[opt]}-colo.svg"
                                        alt="${opt}"
                                        class="emoji-img switchable-img"
                                        onclick="selectOption(this)"
                                    />
                            </div>`
                            : '';

                        rowHtml += `
                            <div class="col-md-6 mb-3">
                                <input class="d-none" type="${inputType}" name="answer${qIndex}" id="option${qIndex}_${idx}" value="${opt}">
                                <label 
                                    for="option${qIndex}_${idx}" 
                                    class="btn btn-outline-primary w-100 d-flex flex-column align-items-center justify-content-center p-3 option-box"
                                    style="cursor: pointer;"
                                    onmouseenter="handleLabelEnter(this)"
                                    onmouseleave="handleLabelLeave(this)"
                                >
                                    ${emoji}
                                    <div class="option-text text-center">${opt}</div>
                                </label>
                            </div>
                        `;

                        if ((idx + 1) % 2 === 0 || idx === q.options.length - 1) {
                            optionsHtml += `<div class="row">${rowHtml}</div>`;
                            rowHtml = '';
                        }
                    });

                    return optionsHtml;
                }

                return '';
            }

            function setupEventsForBatch(indexes) 
            {
                indexes.forEach(index => {
                    const q = questions[index];

                    if (q.type === 'slider') {
                        const slider = document.getElementById(`budgetSlider${index}`);
                        const output = document.getElementById(`sliderValue${index}`);
                        if (slider && output) {
                            slider.addEventListener('input', (e) => {
                                output.textContent = e.target.value;
                            });
                        }
                    }

                    if (q.type === 'single' || q.type === 'multiple') {
                        const inputs = document.querySelectorAll(`input[name="answer${index}"]`);
                        inputs.forEach(input => {
                            input.addEventListener('change', () => {
                                if (q.type === 'single') {
                                    inputs.forEach(i => {
                                        const label = document.querySelector(`label[for="${i.id}"]`);
                                        if (label) label.classList.remove('active');
                                    });
                                }

                                const selectedLabel = document.querySelector(`label[for="${input.id}"]`);
                                if (selectedLabel) {
                                    if (q.type === 'multiple') {
                                        selectedLabel.classList.toggle('active', input.checked);
                                    } else {
                                        selectedLabel.classList.add('active');
                                    }
                                }
                            });
                        });
                    }
                });
            }

            function captureResponse() 
            {
                const isBatch = currentStep === 0;
                const indexes = isBatch ? [0, 1, 2] : [currentStep];

                indexes.forEach(index => {
                    const q = questions[index];
                    if (!q.id) {
                        q.id = `question${index + 1}`;
                    }

                    if (q.type === 'slider') {
                        const slider = document.getElementById(`budgetSlider${index}`);
                        responses[q.id] = slider ? slider.value : 'no response';
                    } 
                    else if (q.type === 'single') {
                        const selected = document.querySelector(`input[name="answer${index}"]:checked`);
                        responses[q.id] = selected ? selected.value : 'no response';
                    } 
                    else if (q.type === 'multiple') {
                        const selected = document.querySelectorAll(`input[name="answer${index}"]:checked`);
                        responses[q.id] = selected.length ? Array.from(selected).map(el => el.value) : 'no response';
                    } 
                    else if (q.type === 'input') {
                        const input = document.getElementById(`textInputAnswer${index}`);
                        responses[q.id] = input ? input.value.trim() || 'no response' : 'no response';
                    }
                });

                localStorage.setItem('userResponses', JSON.stringify(responses));
            }

            // Navigation buttons
            document.getElementById('nextBtn').addEventListener('click', function () {
                captureResponse(); // Save current step response(s)

                // Jump directly to step 3 after batch questions
                if (currentStep === 0) {
                    currentStep = 3;
                } else {
                    currentStep++;
                }

                if (currentStep < questions.length) {
                    renderQuestion();
                    nextBtn.textContent = (currentStep === questions.length - 1) ? 'Finish' : 'Next';
                } else {
                    nextBtn.textContent = 'Finish';
                    localStorage.setItem('userResponses', JSON.stringify(responses));
                    submitResponses();

                    const modal = document.getElementById('questionnaireModal');
                    if (modal) {
                        const modalInstance = bootstrap.Modal.getInstance(modal);
                        if (modalInstance) modalInstance.hide();
                    }
                }
            });
            
            function submitResponses() {
    
                fetch('/submit-response', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Use meta tag CSRF
                    },
                    body: JSON.stringify({
                        template_id: selectedQuestionnaireId,
                        answers: responses
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        toastr.error('There was an issue with your submission. Please try again.');
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        toastr.success('Your responses have been successfully submitted.');
                    } else if (data.status === 'no_results') {
                        toastr.warning('No matching products were found. But we have a few recommendations.');
                    } else {
                        console.error('Unexpected status:', data);
                        toastr.error('An unexpected error occurred.');
                    }

                    // Wait for 2 seconds before redirecting
                    setTimeout(function() {
                        window.location.href = data.redirect;  // Perform redirect
                    },2000);  // 2 seconds delay
                })
                .catch(error => {
                    console.error('Error saving response:', error);
                    toastr.error('There was an error processing your response.');
    
                });
            }

            document.getElementById('backBtn').addEventListener('click', function () {
                if (currentStep > 0) {
                    currentStep--;
                    renderQuestion();
                }
            });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var lottieAnimation;

            // Array of Lottie animation paths (replace these with your actual paths)
            var animationPaths = [
                '{{ asset('Lottie/Lottie2.json') }}',
                '{{ asset('Lottie/Lottie3.json') }}',
                '{{ asset('Lottie/Lottie5.json') }}',
              
            ];

            // Function to get a random animation path
            function getRandomAnimationPath() {
                var randomIndex = Math.floor(Math.random() * animationPaths.length); // Get a random index
                return animationPaths[randomIndex]; // Return the random animation path
            }

            // Set up the Lottie player on modal open
            document.querySelectorAll('.open-questionnaire-modal').forEach(button => {
                button.addEventListener('click', function () {
                    // Destroy previous animation if any
                    if (lottieAnimation) {
                        lottieAnimation.destroy();
                    }

                    // Get a random animation path
                    var animationPath = getRandomAnimationPath();

                    // Initialize Lottie animation inside the modal
                    lottieAnimation = lottie.loadAnimation({
                        container: document.getElementById('lottieAnimation'), // Container for the Lottie animation
                        renderer: 'svg', // Use SVG renderer for better scalability
                        loop: true, // Set to true if you want the animation to loop
                        autoplay: true, // Set to true to autoplay the animation
                        path: animationPath // Path to the Lottie animation JSON file
                    });
                });
            });
        });   
    </script>

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
        function switchToColor(img) {
            img.src = img.dataset.color;
        }

        function switchToMono(img) {
            const inputId = img.closest('label').getAttribute('for');
            const input = document.getElementById(inputId);
            if (!input.checked) {
                img.src = img.dataset.mono;
            }
        }

        function selectOption(clickedImg) {
            // Reset all images to mono except the selected one
            document.querySelectorAll('.switchable-img').forEach(img => {
                const inputId = img.closest('label').getAttribute('for');
                const input = document.getElementById(inputId);
                if (!input.checked) {
                    img.src = img.dataset.mono;
                }
            });

            clickedImg.src = clickedImg.dataset.color;
        }

        // NEW — handle hover over the whole label
        function handleLabelEnter(label) {
            const img = label.querySelector('.switchable-img');
            if (img) {
                switchToColor(img);
            }
        }

        function handleLabelLeave(label) {
            const inputId = label.getAttribute('for');
            const input = document.getElementById(inputId);
            if (!input.checked) {
                const img = label.querySelector('.switchable-img');
                if (img) {
                    switchToMono(img);
                }
            }
        }
    </script>
   
@endpush
