
@extends('layouts.bootdashboard')
@section('admindashboardcontent')
@push('styles')

    <style>
        html, body {
            overscroll-behavior: auto;       
            overflow-x: hidden !important;             
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
                /* background: url('{{ asset('images/Redlabel.jpg') }}') no-repeat center center/cover;
                background-attachment: fixed; 
                z-index: 1; */
                
        }

        #mainNavbar {
            z-index: 999!important;
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


        .emoji-img {
            width: 60px;
            height:60px;
            transition: transform 0.2s ease;
            filter: invert(1) brightness(2);

        }

        .option-box {
            border-radius: 12px;
            /* height: 120px; */
            background-color: transparent !important;
            border: 1px solid #ddd;
            /* height: 120px; */
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

            #mainNavbar{
                padding:15px 0;
            }

            .navbar-toggler{
                margin-left:auto !important;
                margin-right:0 !important;
                z-index:9999;
                border:1px solid rgba(255,255,255,0.7);
                border-radius:10px;
                padding:8px 10px;
                background:rgba(0,0,0,0.25);
                backdrop-filter:blur(8px);
            }

            .navbar-toggler:focus{
                box-shadow:none !important;
            }

            .navbar .navbar-toggler .navbar-toggler-icon:before{
                content:"\f479";
                font-family:bootstrap-icons !important;
                position:absolute;
                right:10px;
                font-size:1rem;
                color:#ffffff !important;
                inset-inline-start:0;
            }

            .navbar-collapse{
                position:absolute;
                top:70px;
                right:15px;
                width:260px;
                background:rgba(0,0,0,0.82);
                backdrop-filter:blur(12px);
                padding:18px 20px;
                border-radius:18px;
                text-align:right;
                z-index:9998;
                border:1px solid rgba(255,255,255,0.08);
                box-shadow:0 10px 35px rgba(0,0,0,0.35);
            }

            .navbar-nav{
                width:100%;
                align-items:flex-end;
                gap:2px;
            }

            .navbar-nav .nav-item{
                width:100%;
            }

            .navbar-nav .nav-link{
                display:flex;
                justify-content:flex-end;
                align-items:center;
                gap:8px;
                text-align:right;
                padding:10px 0;
                font-size:15px;
                font-weight:500;
                color:#fff !important;
                transition:0.25s ease;
            }

            .navbar-nav .nav-link:hover{
                color:#e57351 !important;
                transform:translateX(-3px);
            }

            .navbar-nav .nav-link i{
                margin-right:0 !important;
                font-size:14px;
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

        
        @media screen and (min-width: 700px) and (max-width: 900px){
            .navbar-brand .mobile-logo{
                height:400px !important;
                width:auto !important;
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

    

    </style>

@endpush
        <!-- Start::app-content -->
        <!-- Landing Section -->
            <section id="landing-section">
                <!-- Navbar (stays on top of landing image) -->
                <nav id="mainNavbar" class="navbar navbar-expand-lg ">
                    <div class="container ">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                            <!-- Left-aligned nav items -->
                            <ul class="navbar-nav">
                                <li class="nav-item"><a href="{{ route('user.dashboard') }}" class="nav-link text-white">Dashboard</a></li>
                                <li class="nav-item"><a href="{{ route('user.showQuestionnaire') }}" class="nav-link text-white">Questionnaires</a></li>
                                <li class="nav-item"><a href="{{ route('user.products') }}" class="nav-link text-white">Browse Wines</a></li>
                                <li class="nav-item"><a href="{{ route('user.cheeses') }}" class="nav-link text-white">Browse Cheeses</a></li>
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
                <!-- <div class="d-flex justify-content-end align-items-center text-end text-white videotext" style="height: 100vh; padding-right: 50px;">
                    <div>
                        <h1 class="display-3 fw-bold" style="color: #dacea1;">
                            Discover the Wine That <br>
                            <span style="color: #754638;">Speaks to You</span>
                            <br>
                            <a href="#questionnairesdashboard" type="button" class="btn" id="explorebtn">Explore</a>
                        </h1>
                    </div>
                </div>
                <video class="bg-video" autoplay muted loop playsinline>
                    <source src="{{ asset('images/WineVideo.mov') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video> -->
                <section class="video-section">
                        <div class="video-overlay">
                            <div class="content text-center text-white">
                                <h2 class="display-4">Discover the wine that</h2>
                                <p class="lead" style="color: #e57351;">Speaks to you.</p>
                                <a class="navbar-brand d-flex align-items-center justify-content-center w-100" href="#">
                                    <img src="{{ asset('images/logofullwhite.png') }}" alt="Logo" class="mobile-logo">
                                </a>
                            </div>
                        </div>
                        <video class="bg-video" autoplay muted loop playsinline>
                            <source src="{{ asset('images/WineVideo.mov') }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
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
                                                <div class="card custom-card    ">
                                                    <div class="questionnaire-label">First Sip</div>
                                                    <img src="{{ asset(($cardImages[0] ?? 'images/FirstPour.jpeg')) }}"  class="card-img-top questionnaire-image" alt="First Sip" >
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-0">New to wine? Start with your First Sip — we'll keep it simple and fun.</h5>                                                 
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
                                                    <img  src="{{ asset(($cardImages[1] ?? 'images/SavySipper.png')) }}" class="card-img-top questionnaire-image" alt="Savy Sip" >
                                                    <div class="card-body">
                                                        <h5 class="card-title  mb-0">Let’s fine-tune your sips with Savy Sipper.</h5>
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
                                                    <img  src="{{ asset(($cardImages[2] ?? 'images/CorkMaster.jpeg')) }}"  class="card-img-top questionnaire-image" alt="Cork Master">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-0">Crafted for connoisseurs — unlock your palate with Cork Master.</h5>
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
                                                    <img src="{{ asset(($cardImages[3] ?? 'images/QuickPour1.png')) }}"   class="card-img-top questionnaire-image" alt="Quick Pur">
                                                    <div class="card-body">
                                                        <h5 class="card-title  mb-0">For when you need a wine—quick and right.!!</h5>
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
                                <img src="{{ asset('images/Blacklabel.jpg') }}" class="img-fluid w-100" alt="Image Left">
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

<script>
            let questions = [];
            let currentStep = 0;
            let responses = {};
            let ruleResponses = {};  
            let questionnaireRules = {};
            let selectedQuestionnaireId = null;
            let questionnaireValidation = {};
            const questionLayouts = {
                country: 2,
                sub_region:2,
                region:2,
                taste:2,
            };
            const emojiMap = 
            {
                "Red": "Red",
                "White": "White",
                "Rosé": "Rosé",
                "Fruit": "Fruit",
                "Sparkling / Champagne": "Sparkling_champagne",
                "Yes": "Yes",
                "No": "No",
                "SKIP": "SKIP",
                "Fruit Wine": "Fruit",
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
                "Germany": "Germany",
                "Spain": "Spain",
                "Australia": "Australia",
                "USA": "USA",
                "Austria": "Austria",
                "Crotia": "Croatia",
                "Greece": "Greece",
                "Rest of the World": "RestofTheWorld",
                "Budget": "Budget",
                "Everyday sipping": "Everydaysipping",
                "Celebration": "Celebration",
                "Gifting": "Gifting",
                "Dinner with Friends": "DinnerwithFriends",
                "Wine and Cheese": "WineandCheese",
                "Pairing with food (Coming Soon)": "Pairingwithfood(ComingSoon)",
                "Semi-Sweet": "SemiSweet",
                "Off-Dry (Lightly Sweet)": "Off-Dry",
                "Dry (Not Sweet)": "Dry",
                "No Preference": "NoPreference",
                "Bordeaux (France)": "BordeauxFrance",
                "Burgundy (France)": "BurgundyFrance",
                "Champagne (France)": "ChampagneFrance",
                "Rhône Valley (France)": "RhôneValleyFrance",
                "Tuscany (Italy)": "TuscanyItaly",
                "Piedmont (Italy)": "PiedmontItaly",
                "Veneto (Italy)": "VenetoItaly",
                "Rioja (Spain)": "RiojaSpain",
                "Ribera del Duero (Spain)": "RiberadelDueroSpain",
                "Napa Valley (USA)": "NapaValleyUSA",
                "Sonoma (USA)": "SonomaUSA",
                "Barossa Valley (Australia)": "BarossaValleyAustralia",
                "Margaret River (Australia)": "MargaretRiverAustralia",
                "Marlborough (New Zealand)": "Marlborough",
                "Chardonnay": "Chardonnay",
                "Riesling": "Riesling",
                "Sauvignon Blanc": "SauvignonBlanc",
                "Chenin Blanc": "CheninBlanc",
                "Pinot Noir": "PinotNoir",
                "Cabernet Sauvignon": "CabernetSauvignon",
                "Merlot": "Merlot",
                "Syrah/Shiraz": "SyrahShiraz",
                "Refreshingly Young (1-3 years)": "RefreshinglyYoung",
                "Refreshingly Young (1-2 years)": "RefreshinglyYoung",
                "Fairly Young (3-5 years)": "FairlyYoung",
                "Slightly Aged (5-7 years)": "SlightlyAged",
                "Aged (>7 years)": "Aged",
                "Nuts, Dried, Cooked, Fresh, Caramel, Jammy": "NutsDriedCookedFreshCaramelJammy",
                "Earthy, Moldy, Petroleum, Sulfur, Minerality": "EarthyMoldyPetroleumSulfurMinerality",
                "Yeasty, Lactic, Floral, Spicy, Citrus, Berry, Fruity, Tropical": "Yeasty",
                "Herbaceous, Vegetative": "HerbaceousVegetative",
                "SurpriseMe": "SurpriseMe",
                "Fortified": "Fortified",
                "Varietal": "Varietal",
                "Blends": "Blends",
                "Noble Grapes": "NobleGrapes",
                "Regional Hero Grapes": "RegionalHeroGrapes",
                "Domestic Indian": "DomesticIndian",
                "Old World": "OldWorld",
                "New World": "NewWorld",
                "Brut": "Brut",
                "Dry": "Dry",
                "Off-Dry": "OffDry",
                "Semi Sweet": "SemiSweet",
                "Sweet-Dessert": "Sweet-Dessert",
                "Young (1-2 years)": "Young",
                "Fairly Young (2-5 years)": "FairlyYoung",
                "Slightly Aged (5-7 years)": "SlightlyAged",
                "Well-Aged (8-10 years)": "WellAged",
                "Fully Matured (10 years and above)": "FullyMatured",
                "Acidity: Low, Light to medium, Medium to high, High": "ActidityLowLight",
                "Tannins: Low, Light to medium, Medium to high, High":"TanninsLowLight",
                "Body: Light bodied/ Medium bodied/ Full bodied": "BodyLight",
                "Acidity: Light to medium": "AcitidyLight",
                "Acidity: Medium to high": "AcidityMedium",
                "Acidity: High": "AcidityHigh",
                "Tannins: Low": "TanninsLow",
                "Tannins: Light to medium": "TanninsLight",
                "Tannins: Medium to high": "TanninsMedium",
                "Body: Light bodied": "BodyLight",
                "Body: Medium bodied": "BodyMedium",
                "Body: Full bodied": "BodyFull",
                "Bold": "Bold",
                "Crisp": "Crisp",
                "Rich": "Rich",
                "Light": "Light",
                "Medium-bodied": "MediumBodied",
                "Aromatic": "Aromatic",
                "Fruit-driven": "FruitDriven",
                "Dry": "Dry",
                "Mineral-Driven": "Mineral-Driven",
                "Earthy": "Earthy",
                "Juicy / Fruit-Forward": "JuicyFruit",
                "Elegant / Refined": "Elegant",
                "Chile" : "Chile",
                "Portugal" : "Portugal",
                "Argentina" : "Argentina",
                "England": "England",
                "South Africa" : "SouthAfrica",
                "New Zealand" : "NewZealand",
                "low":"low",
                "light to medium":"lighttomedium",
                "medium to high":"mediumtohigh",
                "high":"high",
                "light bodied":"lightbodied",
                "medium bodied":"MediumBodied",
                "full bodied":"fullbodied",
                "medium":"medium",

            };

            const QuestionnaireEngine = {
                state: {
                    selectedCountries: [],
                    selectedRegionGroup: null,
                    skipSubRegion: false
                },
                rules: {},
                getSelectedValues(sourceKey) {
                    const value = ruleResponses[sourceKey];

                    if (!value) {
                        return [];
                    }

                    return Array.isArray(value) ? value : [value];
                },
                process(question){
                    let processed = JSON.parse(JSON.stringify(question));
                    processed.options = this.filterOptions(processed);
                    console.log("Processing:", processed.key, processed.options);
                    return processed;
                },

                filterOptions(question) {
                    let options = [...question.options];
                    const rules = this.rules.filter(rule => rule.target === question.key);
                    console.log("Global questionnaireRules:", questionnaireRules);
                    console.log("Question:", question.key);
                    console.log("Rules:", rules);
                    rules.forEach(rule => {
                        switch (rule.action) {
                            case "filter":
                                const currentValue = ruleResponses[rule.source];
                                console.log("Source:", rule.source);
                                console.log("Current Value:", currentValue);
                                if (!currentValue) return;
                                let allowed = [];
                                if (Array.isArray(currentValue)) {
                                    currentValue.forEach(value => {
                                        const mapped = rule.mapping[value];
                                        if (mapped === "ALL") {
                                            allowed = "ALL";
                                            return;
                                        }
                                        if (mapped) {
                                            allowed = allowed.concat(mapped);
                                        }
                                    });
                                    } else {
                                    allowed = rule.mapping[currentValue] || [];
                                    }
                                if (allowed !== "ALL" && allowed.length) {
                                    console.log("Current Value:", currentValue);
                                    console.log("Allowed:", allowed);
                                    console.log("Options Before Filter:", options);
                                    options = options.filter(option => allowed.includes(option));
                                }
                            break;
                            case "hide_option":
                                options = this.applyHideOptionRule(rule, options);
                                break;
                        }
                    });
                    console.log("Final Options:", options);
                    return options;
                    },

                
                    applyHideOptionRule(rule, options) {
                        const selectedValues = this.getSelectedValues(rule.source);
                        if (!selectedValues.length) {
                            return options;
                        }
                        if (selectedValues.includes(rule.when)) {
                            options = options.filter(option =>
                                !rule.options.includes(option)
                            );
                        }
                        return options;
                    },

                    shouldSkipQuestion(questionKey) {
                        this.rules = questionnaireRules;
                        const rules = this.rules.filter(rule =>
                            rule.target === questionKey &&
                            rule.action === "skip_question"
                        );
                        for (const rule of rules) {
                            const selectedValues = this.getSelectedValues(rule.source);

                            if (selectedValues.includes(rule.when)) {
                                return true;
                            }
                        }

                        return false;
                    }


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
                    $(this).addClass("hover");

                    if ($(this).hasClass("hover")) {
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

                                if (!data.questions || data.questions.length === 0) { 
                                    console.warn('No questions returned or data format is incorrect:', data);
                                    alert('No questions available for this questionnaire.');
                                    return;
                                }

                                // Store and use the data
                                questions = data.questions;
                                questionnaireRules = data.rules || {};
                                questionnaireValidation = data.validation || {};
                                console.log("Loaded Rules:", questionnaireRules);
                                console.log("Loaded Validation", questionnaireValidation)
                                QuestionnaireEngine.rules = questionnaireRules;
                                currentStep = 0;
                                console.log("Questions :", questions);
                                console.log("Rules :", questionnaireRules);
                                console.log(`Loaded ${questions.length} questions.`);

                                renderQuestion();
                                new bootstrap.Modal(document.getElementById('questionnaireModal')).show();


                            })
                            .catch(error => {
                                console.error('An error occurred while loading questions:', error);
                                alert('Something went wrong while loading the questionnaire. Please try again.');
                            });
                    } 
                    else {
                        $(this).addClass("hover");

                        setTimeout(() => {
                            $(this).removeClass("hover");
                        }, 30000);
                    }



                });
            });

            document.getElementById('questionnaireModal')
            .addEventListener('hidden.bs.modal', function () {
                resetQuestionnaireState();
            });


            function validateCurrentQuestion() 
            {
                const question = questions[currentStep];
                if (!question) {
                    return true;
                }
                const validation = questionnaireValidation[question.key];

                if (!validation) {
                    return true;
                }
                const answer = ruleResponses[question.key];
                const selected = Array.isArray(answer)
                    ? answer
                    : (answer ? [answer] : []);

                if (validation.min_selection && selected.length < validation.min_selection) 
                {
                    //alert(validation.message);
                    toastr.warning(validation.message, 'Selection Required');
                    return false;
                }
                return true;
            }



            function resetQuestionnaireState() 
            {
                questions = [];
                currentStep = 0;
                responses = {};
                ruleResponses = {};
                selectedQuestionnaireId = null;
                QuestionnaireEngine.state.selectedCountries=[];
                QuestionnaireEngine.state.selectedRegionGroup=null;
                QuestionnaireEngine.state.skipSubRegion=false;

                localStorage.removeItem('userResponses');

                document.getElementById('question-container').innerHTML = '';
                document.getElementById('backBtn').style.display = 'none';

                const nextBtn = document.getElementById('nextBtn');
                nextBtn.textContent = 'Next';
            }


            function forLog(min, max) {
                let sliderValue = max - min;
                let bars;
                if (sliderValue < 5001) {
                    bars = sliderValue / 1000;
                } else if (sliderValue > 49999) {
                    bars = sliderValue / 10000;
                } else {
                    bars = sliderValue / 5000;
                }
                let step = sliderValue / bars;
                console.log("number of bars:-", bars);
                console.log("bars breakpoints:-", step);

                let barValues = []
                for (let i = 0; i <= bars; i++) {
                    barValues.push(min + (step * i));
                }

                console.log("bar values:-", barValues);


                return {barCount: bars + 1, barValues: barValues};
            }

            function renderBars(container, barsInfo) {
                container.innerHTML = ""; 

                for (let i = 0; i < barsInfo.barCount; i++) {

                    const barDiv = document.createElement("div");
                    barDiv.className = "barDiv";

                    const singleBar = document.createElement("div");
                    singleBar.className = "single-bar";

                    const priceText = document.createElement("p");
                    priceText.className = "barValuesPrice";
                    priceText.textContent = `₹${barsInfo.barValues[i]}`;

                    barDiv.appendChild(priceText);
                    barDiv.appendChild(singleBar);

                    container.appendChild(barDiv);
                }
            }

            function renderQuestion() 
            {
                const container = document.getElementById('question-container');
                const backBtn = document.getElementById('backBtn');

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

                    backBtn.style.display = 'none';
                    return;
                }

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
                backBtn.style.display = 'inline-block';
            }

            function renderQuestionHTML(q, qIndex) 
            {
                q = QuestionnaireEngine.process(q);
                
                if (q.type === 'slider') {
                    const bands = q.bands ?? [
                        { min: 0, max: 5000, label: "₹ 0 – ₹ 5,000" },
                        { min: 5000, max: 25000, label: "₹ 5,000 – ₹ 25,000" },
                        { min: 25000, max: 50000, label: "₹ 25,000 – ₹ 50,000" },
                        { min: 50000, max: 100000, label: "₹ 50,000 – ₹ 1,00,000" }
                    ];

                    const defaultValue = bands[0].min;

                    let optionsHtml = '';
                    bands.forEach(b => {
                        optionsHtml += `<option value="${b.max}" data-min="${b.min}" data-max="${b.max}">${b.label}</option>`;
                    });

                    return `
                        <select class="form-select mb-3" id="budgetDropdown${qIndex}">
                            ${optionsHtml}
                        </select>

                        <div class="sliderInputWrapper">

                        <div class="barsDiv">

                        </div>

                        <input 
                            type="range" 
                            class="form-range"
                            id="budgetSlider${qIndex}"
                            min="${bands[0].min}"
                            max="${bands[0].max}"
                            step="100"
                            value="${defaultValue}"
                        >

                        </div>

                        <div class="mt-2 fw-bold">
                            Selected: ₹<span id="sliderValue${qIndex}">${defaultValue}</span>
                        </div>
                    `;
                }


                if (q.type === 'input') {
                    return `<input type="text" class="form-control" id="textInputAnswer${qIndex}" placeholder="Enter your answer">`;
                }


                if ((q.type === 'single' || q.type === 'multiple') && Array.isArray(q.options)) 
                {
                    let options = q.options;
                    console.log ("on line 989", options);
                    const inputType = q.type === 'single' ? 'radio' : 'checkbox';
                    let rowHtml = '';
                    let optionsHtml = '';
                    const columns = questionLayouts[q.key] || 0;
                    let bootstrapCol = "col-md-6";

                    if (columns === 2) {
                        bootstrapCol = "col-6";
                    }
                    

                    options.forEach((opt, idx) => {
                        const basePath = '/questionnaire';
                        const emoji = emojiMap[opt]
                            ? `<div class="emoji-icon mb-1">
                                    <img 
                                        src="${basePath}/${emojiMap[opt]}-mono.svg"
                                        data-mono="${basePath}/${emojiMap[opt]}-mono.svg"
                                        data-color="${basePath}/${emojiMap[opt]}-colo.svg"
                                        alt="${opt}"
                                        class="emoji-img switchable-img"
                                    />
                            </div>`
                            : '';

                        rowHtml += `
                            <div class="${bootstrapCol} mb-3">
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

                        if ((idx + 1) % 2 === 0 || idx === options.length - 1) {
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
                        const dropdown = document.getElementById(`budgetDropdown${index}`);
                        const output = document.getElementById(`sliderValue${index}`);
                        const barsDiv = slider.closest(".sliderInputWrapper").querySelector(".barsDiv");

                        // ⭐ INITIAL RENDER
                        const firstOption = dropdown.options[dropdown.selectedIndex];
                        const initMin = Number(firstOption.dataset.min);
                        const initMax = Number(firstOption.dataset.max);

                        const initBars = forLog(initMin, initMax);
                        renderBars(barsDiv, initBars);

                        // SLIDER INPUT
                        slider.addEventListener('input', () => {
                            output.textContent = slider.value;
                        });

                        // DROPDOWN CHANGE
                        dropdown.addEventListener('change', () => {
                            const selectedOption = dropdown.options[dropdown.selectedIndex];

                            const min = Number(selectedOption.dataset.min);
                            const max = Number(selectedOption.dataset.max);

                            slider.min = min;
                            slider.max = max;
                            slider.value = min;

                            output.textContent = min;

                            const barsInfo = forLog(min, max);
                            renderBars(barsDiv, barsInfo);
                        });
                    }

                    if (q.type === 'single' || q.type === 'multiple') {

                    const inputs = document.querySelectorAll(`input[name="answer${index}"]`);

                    inputs.forEach(input => {

                        input.addEventListener('change', () => {

                            /* ===============================
                            ⭐ SURPRISE ME LOGIC (MULTIPLE)
                            =============================== */

                            if (q.type === 'multiple') {

                                if (input.value === "SurpriseMe" && input.checked) {

                                    // If SurpriseMe selected → uncheck all others
                                    inputs.forEach(i => {
                                        if (i !== input) {
                                            i.checked = false;

                                            const lbl = document.querySelector(`label[for="${i.id}"]`);
                                            if (lbl) lbl.classList.remove('active');
                                        }
                                    });

                                } else if (input.value !== "SurpriseMe" && input.checked) {

                                    // If any other selected → uncheck SurpriseMe
                                    inputs.forEach(i => {
                                        if (i.value === "SurpriseMe") {
                                            i.checked = false;

                                            const lbl = document.querySelector(`label[for="${i.id}"]`);
                                            if (lbl) lbl.classList.remove('active');
                                        }
                                    });
                                }
                            }

                            /* ===============================
                            SINGLE SELECTION ACTIVE RESET
                            =============================== */

                            if (q.type === 'single') {
                                inputs.forEach(i => {
                                    const label = document.querySelector(`label[for="${i.id}"]`);
                                    if (label) label.classList.remove('active');
                                });
                            }

                            /* ===============================
                            APPLY ACTIVE CLASS
                            =============================== */

                            const selectedLabel = document.querySelector(`label[for="${input.id}"]`);
                            if (selectedLabel) {
                                if (q.type === 'multiple') {
                                    selectedLabel.classList.toggle('active', input.checked);
                                } else {
                                    selectedLabel.classList.add('active');
                                }
                            }

                            /* ===============================
                            COUNTRY LOGIC
                            =============================== */

                            if (q.question.toLowerCase().includes("preferred wine country")) {

                                QuestionnaireEngine.state.selectedCountries = Array.from(
                                    document.querySelectorAll(`input[name="answer${index}"]:checked`)
                                ).map(i => i.value);

                                QuestionnaireEngine.state.skipSubRegion = QuestionnaireEngine.state.selectedCountries.includes("No Preference");

                                // renderQuestion();
                            }

                            /* ===============================
                            REGION GROUP LOGIC
                            =============================== */

                            if (q.question.toLowerCase().includes("wine region group")) {

                                const selected = document.querySelector(`input[name="answer${index}"]:checked`);
                                QuestionnaireEngine.state.selectedRegionGroup = selected ? selected.value : null;

                                // renderQuestion();
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

                    let answer = 'no response';

                    if (q.type === 'slider') {

                        const slider = document.getElementById(`budgetSlider${index}`);
                        answer = slider ? slider.value : 'no response';

                    }
                    else if (q.type === 'single') {

                        const selected = document.querySelector(`input[name="answer${index}"]:checked`);
                        answer = selected ? selected.value : 'no response';

                    }
                    else if (q.type === 'multiple') {

                        const selected = document.querySelectorAll(`input[name="answer${index}"]:checked`);
                        answer = selected.length
                            ? Array.from(selected).map(el => el.value)
                            : 'no response';

                    }
                    else if (q.type === 'input') {

                        const input = document.getElementById(`textInputAnswer${index}`);
                        answer = input ? (input.value.trim() || 'no response') : 'no response';

                    }

                    // ===== OLD FORMAT (DO NOT CHANGE) =====
                    responses[`question${index + 1}`] = answer;

                    // ===== NEW RULE ENGINE FORMAT =====
                    if (q.key) {
                        console.log("Saving:", q.key, answer);
                        ruleResponses[q.key] = answer;
                    }

                });

                localStorage.setItem('userResponses', JSON.stringify(responses));
            }
            
            // Navigation buttons
            document.getElementById('nextBtn').addEventListener('click', function () {
                captureResponse();

                if (!validateCurrentQuestion()) 
                {
                    return;
                }

                // Refresh rule state from latest answers
                QuestionnaireEngine.state.selectedCountries =
                    ruleResponses.preferred_country || [];

                QuestionnaireEngine.state.selectedRegionGroup =
                    ruleResponses.wine_region_group || null;

                // find index of "country selection" question
                const countryIndex = questions.findIndex(q =>
                    q.question.toLowerCase().includes("country selection")
                );

                // Jump directly to step 3 after batch questions
                if (currentStep === 0) 
                {
                    currentStep = 3;
                } else {
                    // ⭐ SKIP country question if "No Preference" selected
                    if (
                            QuestionnaireEngine.state.skipSubRegion &&
                            currentStep + 1 === countryIndex
                        ) {
                        currentStep = countryIndex + 1; // skip country question
                    } else {
                        // currentStep++;
                        const subRegionIndex = questions.findIndex(q =>
                                q.question.toLowerCase().includes("sub-region")
                            );

                            if (QuestionnaireEngine.state.skipSubRegion && currentStep + 1 === subRegionIndex) {
                                currentStep = subRegionIndex + 2; // skip sub-region
                            } else {
                                currentStep++;
                                while (
                                    currentStep < questions.length &&
                                    QuestionnaireEngine.shouldSkipQuestion(
                                        questions[currentStep].key
                                    )
                                ) {
                                    currentStep++;
                                }
                            }

                    }
                }

                if (currentStep < questions.length) {
                    renderQuestion();
                    nextBtn.textContent =
                        (currentStep === questions.length - 1) ? 'Finish' : 'Next';
                } else {
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
                console.log("check api:- ",selectedQuestionnaireId, responses);
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

                    const countryIndex = questions.findIndex(q =>
                        q.question.toLowerCase().includes("country selection")
                    );

                    if (QuestionnaireEngine.state.skipSubRegion === "No Preference" &&
                        currentStep - 1 === countryIndex) {
                        currentStep = countryIndex - 1;
                    } else {
                        currentStep--;
                    }

                    renderQuestion();
                }
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
        document.addEventListener("scroll", function () {
            const scrolled = window.scrollY;
            const parallax = document.querySelector(".parallax-bg");
            if (parallax) {
                parallax.style.transform = `translateY(${scrolled * 0.4}px)`; // adjust 0.4 for speed
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
