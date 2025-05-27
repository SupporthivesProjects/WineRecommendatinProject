

@extends('layouts.bootdashboard')
@section('admindashboardcontent')

@push('styles')

    <style>

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
            border: 2px solid #6c757d; /* Bootstrap's secondary color or use your own */
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
            font-size: 4.0rem;
            line-height: 1;
        }

        .option-box {
            height: 120px;
            text-align: center;
        }

        .option-text {
            font-size: 1rem;
            line-height: 1.2;
        }


        .modal-content {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            background: linear-gradient(to bottom, #ffffff, #f9f9f9);
            overflow: hidden;
            transition: all 0.3s ease-in-out;
        }

        .lottie-container {
            background-color: #f0f4f8;
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

        .option-box {
            border-radius: 12px;
            height: 120px;
            background-color: #fff;
            border: 1px solid #ddd;
        }

        .option-box.active {
            border-color: #0d6efd;
            background-color: #e6f0ff;
        }

        .questionnaire-label {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(253, 96, 116, 0.7) !important; 
            color: #fff;
            font-size: 1.0rem;
            padding: 5px 10px;
            /* border-radius: 5px;  */
            font-weight: 600;
            z-index: 2;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .card.custom-card {
            position: relative; /* So the label can be positioned absolutely inside */
        }

        #mainNavbar {
            transition: background-color 0.3s ease;
            background-color: transparent;
            }

            #mainNavbar.scrolled {
            background-color: red !important;
            }

            .nav-link, .nav-icon {
            color: black !important;
            transition: color 0.3s ease;
            }

            #mainNavbar.scrolled .nav-link,
            #mainNavbar.scrolled .nav-icon {
            color: black !important;
            }
    </style>

@endpush
        <!-- Start::app-content -->
       

    <div class="main-content app-content">
        <div class="container-fluid">
            <nav id="mainNavbar" class="navbar navbar-expand-lg fixed-top my-3">
                <div class="container">
                    <a class="navbar-brand text-white" href="#">Your Brand</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                        <a href="{{ route('user.dashboard') }}" class="nav-link">
                            <i class="fe fe-home nav-icon"></i> Dashboard
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fe fe-box nav-icon"></i> Questionnaires
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="{{ route('user.products') }}" class="nav-link">
                            <i class="fe fe-star nav-icon"></i> Browse Wines
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="{{ route('user.featuredproducts') }}" class="nav-link">
                            <i class="fe fe-star nav-icon"></i> Featured Products
                        </a>
                        </li>
                    </ul>
                    </div>
                </div>
            </nav>
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Tell us what you like — your perfect wine is just a few answers away.</h2>
                </div>
            </div>

            <!-- End::page-header -->

            <!-- Start row 0 -->
            <div class="row row-sm ">
                <div class="col-xxl-3 col-xl-12">
                    <div class="card custom-card">
                        <!-- Badge Label -->
                        <div class="questionnaire-label">First Sip</div>
                        <img src="{{ asset('images/wineglasses.jpg') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h6 class="card-title fw-semibold mb-0">Find Your Perfect Pour</h6>
                        </div>
                        <button class="btn btn-danger mt-2 open-questionnaire-modal" data-questionnaire-id="1">
                            I want to try Now !!
                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon move-arrow" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-12">
                    <div class="card custom-card">
                        <!-- Badge Label -->
                        <div class="questionnaire-label">Savy Sip</div>
                        <img src="{{ asset('images/questionnaire2.jpg') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h6 class="card-title fw-semibold mb-0">Discover Your Wine Personality</h6>
                        </div>
                        <button class="btn btn-danger mt-2 open-questionnaire-modal" data-questionnaire-id="2">
                            I want to try Now !!
                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon move-arrow" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-12">
                    <div class="card custom-card">
                        <!-- Badge Label -->
                        <div class="questionnaire-label">Cork Master</div>
                        <img src="{{ asset('images/questionnaire3.jpg') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h6 class="card-title fw-semibold mb-0">Sip Smarter, Choose Better</h6>
                        </div>
                        <button class="btn btn-danger mt-2 open-questionnaire-modal" data-questionnaire-id="3">
                            I want to try Now !!
                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon move-arrow" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-12">
                    <div class="card custom-card">
                        <!-- Badge Label -->
                        <div class="questionnaire-label">Quick Pour</div>
                        <img src="{{ asset('images/questinnaire4.jpg') }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h6 class="card-title fw-semibold mb-0">Wine, Tailored to You</h6>
                        </div>
                        <button class="btn btn-danger mt-2 open-questionnaire-modal" data-questionnaire-id="4">
                            I want to try Now !!
                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon move-arrow" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- End Row 0 -->

           

            <!-- Start::row-1 -->
                <!-- <div class="row row-sm">
                    <div class="col-xl-4">
                        <div class="card custom-card">
                            <img src="{{ asset('images/questinnaire4.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="card-title fw-semibold">First Sip (Basic Level)</h6>
                                <h3 class="card-title">"Every expert was once a beginner."</h3>
                                <p class="card-text mb-3 text-muted">Just getting started? Discover your taste preferences with simple, 
                                    fun questions that guide you to wines you’ll love. No pressure—just your first step into the 
                                    world of wine.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card custom-card">
                            <div class="card-body">
                            <h6 class="card-title fw-semibold">Savvy Sipper (Semi-Pro Level)</h6>
                            <h3 class="card-title">"You've got the swirl, now master the sip."</h3>
                                <p class="card-text mb-3 text-muted">Already know a Cabernet from a Pinot? Dive deeper into regions, aromas, 
                                    and notes. This questionnaire refines your palate and helps you explore the wines that suit your 
                                    evolving taste.
                                </p>
                            </div>
                            <img src="{{ asset('images/questionnaire2.jpg') }}" class="card-img-bottom" alt="...">
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card custom-card">
                            <div class="card-body">
                                <h6 class="card-title fw-semibold mb-1">Pro (Advanced Level)</h6>
                                <h3 class="card-title">"Challenge your palate. Define your style."</h3>
                                <p class="card-text mb-1 text-muted">You speak the language of tannins and terroir. This expert-level quiz 
                                    delves into nuanced wine traits, helping you pinpoint exactly what excites 
                                    your refined wine-loving senses.
                                </p>
                            </div>
                            <img src="{{ asset('images/questionnaire3.jpg') }}" class="card-img rounded-0" alt="...">
                            
                        </div>
                    </div>
                </div> -->
            <!-- Row 1 ends -->
             
            <!-- Start::row-2 -->
                <div class="row row-sm">
                    <div class="col-sm-12 col-lg-12 col-xl-8">
                        <!-- Purple box row starts -->
                        <div class="row row-sm banner-img">
                            <div class="col-sm-12 col-lg-12 col-xl-12">
                                <div class="card bg-primary custom-card card-box">
                                    <div class="card-body p-4">
                                        <div class="row">
                                            <div class="offset-xl-3 offset-sm-6 col-xl-8 col-sm-6 col-12 text-end">
                                                <h4 class="d-flex mb-3 justify-content-end">
                                                    <span class="fw-bold text-fixed-white ">Welcome !</span>
                                                </h4>
                                                <p class="tx-white-7 mb-1 fs-3  ">Welcome to a world where, <br> every bottle tells a story.</p>
                                            </div>
                                        </div>
                                        <img src="{{ asset('images/3312991-photoroom.png') }}" alt="user-img" style="width:300px;height:200px">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Purple Box row ends -->
                         <!-- Start::row -->
                            <div class="row row-sm">
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="card-item">
                                                <div class="card-item-icon card-icon">
                                                    <img src="{{ asset('images/wine-bottle.png') }}">
                                                </div>
                                                <div class="card-item-title mb-2">
                                                    <label class="main-content-label fs-15fw-bold mb-1">Products</label>
                                                    <span class="d-block fs-15 mb-0 text-muted">Welcome to the<br>Cellar</span>
                                                </div>
                                                <div class="card-item-body">
                                                    <div class="card-item-stat">
                                                        <h4 class="fw-bold"></h4>
                                                        <a href="{{ route('user.products') }}" class="btn btn-sm btn-outline-primary mt-2">View
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="card-item">
                                                <div class="card-item-icon card-icon">
                                                <img src="{{ asset('images/form.png') }}">
                                                </div>
                                                <div class="card-item-title mb-2">
                                                    <label class="main-content-label fs-13 fw-bold mb-1">Questionnaires</label>
                                                    <span class="d-block fs-15 mb-0 text-muted">Find Your<br> Perfect Pour</span>
                                                </div>
                                                <div class="card-item-body">
                                                    <div class="card-item-stat">
                                                        <h4 class="fw-bold"></h4>
                                                        <a href="" class="btn btn-sm btn-outline-primary mt-2">View
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-4">
                                    <div class="card custom-card">
                                        <div class="card-body">
                                            <div class="card-item">
                                                <div class="card-item-icon card-icon">
                                                    <img src="{{ asset('images/red-wine.png') }}">
                                                </div>
                                                <div class="card-item-title  mb-2">
                                                    <label class="main-content-label fs-13 fw-bold mb-1">Featured Products</label>
                                                    <span class="d-block fs-15 mb-0 text-muted">Handpicked Elegance. Uncork the Best.</span>
                                                </div>
                                                <div class="card-item-body">
                                                    <div class="card-item-stat">
                                                        <h4 class="fw-bold"></h4>
                                                        <a href="{{ route('user.featuredproducts') }}" class="btn btn-sm btn-outline-primary mt-2">View
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- End::row -->
                    </div><!-- End of first col -->
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                        <div class="card custom-card">
                            <div class="card-header justify-content-between">
                                <div class="card-title">Top Picks</div>
                            </div>
                            <div class="card-body">
                                <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="{{ asset('storage/products/19 Crimes Hard Chardonnay.jpg') }}" class="d-block w-100" alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('storage/products/19 Crimes Hard Chardonnay.jpg') }}" class="d-block w-100" alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('storage/products/19 Crimes Hard Chardonnay.jpg') }}" class="d-block w-100" alt="...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- end of row 2 -->
        </div>
    </div>


    <!-- modal code -->
    <div class="modal fade" id="questionnaireModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body d-flex flex-column p-0">
                    <!-- Lottie Animation (instead of the image) -->
                    <div class="lottie-container w-100" id="lottieAnimation" style="height: 250px;width:auto"></div>

                    <!-- Question Side -->
                    <div class="w-100 p-4 d-flex flex-column justify-content-between">
                        <div id="question-container">
                            <!-- Question and options will load here -->
                        </div>
                        <div class="d-flex justify-content-between mt-4 gap-2">
                            <button class="btn btn-secondary btn-lg flex-fill" id="backBtn">Back</button>
                            <button class="btn btn-danger btn-lg flex-fill" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary btn-lg flex-fill" id="nextBtn">Next</button>
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

            const emojiMap = {
                // Q1 - Wine Type
                "Red": "🍷",
                "White": "🥂",
                "Rosé": "🌹",
                "Fruit": "🍇",
                
                // Q2 - Still or Sparkling
                "Still": "🧊",
                "Sparkling": "🍾",
                "Sparkling/Champagne": "🍾",

                // Q3 - Sweetness
                "Sweet": "🍬",
                "Medium Sweet": "🍯",
                "Lightly Sweet": "🧁",
                "Dry": "🍂",

                // Q4 - Flavor Profile
                "Fruit-Driven": "🍓",
                "Juicy/Fruit-Forward": "🍒",
                "Aromatic": "🌸",
                "Earthy": "🌱",
                "Mineral-Driven": "🪨",
                "SKIP": "⏭️",

                // Q5 - Boldness
                "Light-bodied (Soft & Refreshing)": "☁️",
                "Medium-bodied (Balanced & Smooth)": "🥃",
                "Full-bodied (Rich & Intense)": "💪",

                // Q6 - Fruity Level
                "Very Fruity": "🍉",
                "Slightly Fruity": "🍑",
                "Not Fruity": "🥖",

                // Q7 - Age Preference
                "Young and Refreshing": "🧃",
                "Bold and Old": "🧓",

                // Q8 - Regions
                "Any": "🌍",
                "India": "🇮🇳",
                "France": "🇫🇷",
                "Italy": "🇮🇹",
                "Spain": "🇪🇸",
                "Australia": "🇦🇺",
                "USA": "🇺🇸",
                "Rest of the World": "🌎",

                // Q9 - Budget (slider — not clickable)
                // (No emojis needed for slider, but adding for consistency)
                "Budget": "💰",

                // Q10 - Occasion
                "Everyday sipping": "🛋️",
                "Celebration": "🎉",
                "Gifting": "🎁",
                "Pairing with food (Coming Soon)": "🍽️"
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

            // function renderQuestion() {
            //     if (questions.length === 0 || currentStep >= questions.length) return;

            //     if (!questions[currentStep].id) {
            //         questions[currentStep].id = `question${currentStep + 1}`;
            //     }

            //     const q = questions[currentStep];
            //     const container = document.getElementById('question-container');

            //     console.log("Rendering question: ", q);

            //     let optionsHtml = '';

            //     if (q.type === 'slider') {
            //         const min = q.min_value ?? 0;
            //         const max = q.max_value ?? 10000;
            //         const step = q.step ?? 100;
            //         const defaultValue = q.default ?? min;

            //         // Create tick marks
            //         let tickMarks = '';
            //         for (let i = min; i <= max; i += step) {
            //             tickMarks += `<option value="${i}"></option>`;
            //         }

            //         optionsHtml = `
            //             <div class="mb-4">
            //                 <input 
            //                     type="range" 
            //                     class="form-range" 
            //                     id="budgetSlider" 
            //                     min="${min}" 
            //                     max="${max}" 
            //                     step="${step}" 
            //                     value="${defaultValue}" 
            //                     list="tickmarks"
            //                 >
            //                 <datalist id="tickmarks">
            //                     ${tickMarks}
            //                 </datalist>
            //                 <div class="d-flex justify-content-between text-muted mt-2">
            //                     <small>₹${min}</small>
            //                     <small>Selected: ₹<span id="sliderValue">${defaultValue}</span></small>
            //                     <small>₹${max}</small>
            //                 </div>
            //             </div>
            //         `;
            //     } else if ((q.type === 'single' || q.type === 'multiple') && Array.isArray(q.options)) {
            //         let rowHtml = '';
            //         q.options.forEach((opt, idx) => {
            //             const emoji = (selectedQuestionnaireId === '1' || selectedQuestionnaireId === 1) && emojiMap[opt] ? `<span class="emoji-icon">${emojiMap[opt]}</span> ` : '';
            //             const inputType = q.type === 'single' ? 'radio' : 'checkbox';

            //             rowHtml += `
            //                 <div class="col-md-3 mb-3">
            //                     <input class="d-none" type="${inputType}" name="answer" id="option${idx}" value="${opt}">
            //                     <label 
            //                         for="option${idx}" 
            //                         class="btn btn-outline-primary w-100"
            //                         style="cursor: pointer;"
            //                     >
            //                         ${emoji}${opt}
            //                     </label>
            //                 </div>
            //             `;

            //             if ((idx + 1) % 4 === 0 || idx === q.options.length - 1) {
            //                 optionsHtml += `<div class="row">${rowHtml}</div>`;
            //                 rowHtml = '';
            //             }
            //         });
            //     }

            //     // ✅ Now render the final HTML after all conditions are processed
            //     container.innerHTML = `
            //         <h5>${q.question}</h5>
            //         ${optionsHtml}
            //     `;

            //     // Attach the slider event listener AFTER rendering
            //     if (q.type === 'slider') {
            //         const slider = document.getElementById('budgetSlider');
            //         const output = document.getElementById('sliderValue');
            //         if (slider && output) {
            //             slider.addEventListener('input', (e) => {
            //                 output.textContent = e.target.value;
            //             });
            //         }
            //     }

            //     // ✅ Attach active label highlight logic AFTER rendering options
            //     if (q.type === 'single' || q.type === 'multiple') {
            //         const inputs = document.querySelectorAll('input[name="answer"]');

            //         inputs.forEach(input => {
            //             input.addEventListener('change', () => {
            //                 if (q.type === 'single') {
            //                     inputs.forEach(i => {
            //                         const label = document.querySelector(`label[for="${i.id}"]`);
            //                         if (label) label.classList.remove('active');
            //                     });
            //                 }

            //                 const selectedLabel = document.querySelector(`label[for="${input.id}"]`);
            //                 if (selectedLabel) {
            //                     if (q.type === 'multiple') {
            //                         selectedLabel.classList.toggle('active', input.checked);
            //                     } else {
            //                         selectedLabel.classList.add('active');
            //                     }
            //                 }
            //             });
            //         });
            //     }

            //     document.getElementById('backBtn').disabled = currentStep === 0;
            // }

            function renderQuestion() {
                if (questions.length === 0 || currentStep >= questions.length) return;

                if (!questions[currentStep].id) {
                    questions[currentStep].id = `question${currentStep + 1}`;
                }

                const q = questions[currentStep];
                const container = document.getElementById('question-container');

                console.log("Rendering question: ", q);

                let optionsHtml = '';

                if (q.type === 'slider') {
                    const min = q.min_value ?? 0;
                    const max = q.max_value ?? 10000;
                    const step = q.step ?? 100;
                    const defaultValue = q.default ?? min;

                    let tickMarks = '';
                    for (let i = min; i <= max; i += step) {
                        tickMarks += `<option value="${i}"></option>`;
                    }

                    optionsHtml = `
                        <div class="mb-4">
                            <input 
                                type="range" 
                                class="form-range" 
                                id="budgetSlider" 
                                min="${min}" 
                                max="${max}" 
                                step="${step}" 
                                value="${defaultValue}" 
                                list="tickmarks"
                            >
                            <datalist id="tickmarks">
                                ${tickMarks}
                            </datalist>
                            <div class="d-flex justify-content-between text-muted mt-2">
                                <small>₹${min}</small>
                                <small>Selected: ₹<span id="sliderValue">${defaultValue}</span></small>
                                <small>₹${max}</small>
                            </div>
                        </div>
                    `;
                } else if ((q.type === 'single' || q.type === 'multiple') && Array.isArray(q.options)) {
                    let rowHtml = '';
                    const inputType = q.type === 'single' ? 'radio' : 'checkbox';

                    q.options.forEach((opt, idx) => {
                        const emoji = (selectedQuestionnaireId === '1' || selectedQuestionnaireId === 1) && emojiMap[opt] ? `<div class="emoji-icon mb-1">${emojiMap[opt]}</div>` : '';

                        rowHtml += `
                            <div class="col-md-6 mb-3">
                                <input class="d-none" type="${inputType}" name="answer" id="option${idx}" value="${opt}">
                                <label 
                                    for="option${idx}" 
                                    class="btn btn-outline-primary w-100 d-flex flex-column align-items-center justify-content-center p-3 option-box"
                                    style="cursor: pointer;"
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
                }

                container.innerHTML = `
                    <h5>${q.question}</h5>
                    ${optionsHtml}
                `;

                // Slider event
                if (q.type === 'slider') {
                    const slider = document.getElementById('budgetSlider');
                    const output = document.getElementById('sliderValue');
                    if (slider && output) {
                        slider.addEventListener('input', (e) => {
                            output.textContent = e.target.value;
                        });
                    }
                }

                // Highlight selected labels
                if (q.type === 'single' || q.type === 'multiple') {
                    const inputs = document.querySelectorAll('input[name="answer"]');

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

                document.getElementById('backBtn').disabled = currentStep === 0;
            }



            // Capture the user's response and store it locally
            function captureResponse() 
            {
                const q = questions[currentStep];

                // Ensure question has an ID
                if (!q.id) {
                    q.id = `question${currentStep + 1}`;
                }

                console.log("Capturing response for question:", q);

                if (q.type === 'slider') {
                    const slider = document.getElementById('budgetSlider');
                    if (slider) {
                        responses[q.id] = slider.value;
                        console.log(`Slider value stored for ${q.id}:`, slider.value);
                    } else {
                        console.warn(`Slider input not found for ${q.id}`);
                    }
                } 
                else if (q.type === 'single') {
                    const selected = document.querySelector('input[name="answer"]:checked');
                    if (selected) {
                        responses[q.id] = selected.value;
                        console.log(`Radio button selected for ${q.id}:`, selected.value);
                    } else {
                        console.warn(`No radio button selected for ${q.id}`);
                    }
                } 
                else if (q.type === 'multiple') {
                    const selected = document.querySelectorAll('input[name="answer"]:checked');
                    if (selected.length > 0) {
                        const values = Array.from(selected).map(el => el.value);
                        responses[q.id] = values;
                        console.log(`Checkboxes selected for ${q.id}:`, values);
                    } else {
                        console.warn(`No checkboxes selected for ${q.id}`);
                    }
                }

                // Store to localStorage (optional but helpful for debugging or persistence)
                localStorage.setItem('userResponses', JSON.stringify(responses));
                console.log("Responses so far:", JSON.stringify(responses, null, 2));
            }



            // Navigation buttons
            document.getElementById('nextBtn').addEventListener('click', function () {
                captureResponse(); // Save the current response before moving to next question
                if (currentStep < questions.length - 1) {
                    currentStep++;
                    renderQuestion();
                } else {
                    // On Finish button, store responses and send to backend
                    nextBtn.textContent = 'Finish';
                    // Store responses in localStorage
                    localStorage.setItem('userResponses', JSON.stringify(responses));
                    //alert(localStorage.getItem('userResponses'));  
                    //alert(selectedQuestionnaireId);

                    // Call the function to submit responses
                    //alert("calling function");
                    submitResponses();

                    // Close modal
                    const modal = document.getElementById('questionnaireModal');
                    if (modal) {
                        const modalInstance = bootstrap.Modal.getInstance(modal);
                        if (modalInstance) modalInstance.hide();
                    }

                    //alert('You’ve completed the questionnaire!');
                }
            });

            // Send responses to backend
            // function submitResponses() 
            // {
            //     // Show loader before making the request
            //     document.getElementById('loader').style.display = 'block'; // Assuming you have a loader element with id 'loader'

            //     fetch('/submit-response', {
            //         method: 'POST',
            //         headers: {
            //             'Content-Type': 'application/json',
            //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Use meta tag CSRF
            //         },
            //         body: JSON.stringify({
            //             template_id: selectedQuestionnaireId,
            //             answers: responses
            //         })
            //     })
            //     .then(response => {
            //         if (!response.ok) {
            //             toastr.error('There was an issue with your submission. Please try again.');
            //             document.getElementById('loader').style.display = 'none'; // Hide loader if error
            //             throw new Error('Network response was not ok');
            //         }
            //         return response.json();
            //     })
            //     .then(data => {
            //         if (data.status === 'success') {
            //             toastr.success('Your responses have been successfully submitted.');
            //         } else if (data.status === 'no_results') {
            //             toastr.warning('No matching products were found.');
            //         } else {
            //             console.error('Unexpected status:', data);
            //             toastr.error('An unexpected error occurred.');
            //         }

            //         // Wait for 2 seconds before redirecting
            //         setTimeout(function() {
            //             document.getElementById('loader').style.display = 'none'; // Hide loader
            //             window.location.href = data.redirect;  // Perform redirect
            //         }, 2000);  // 2 seconds delay
            //     })
            //     .catch(error => {
            //         console.error('Error saving response:', error);
            //         toastr.error('There was an error processing your response.');
            //         document.getElementById('loader').style.display = 'none'; // Hide loader if error
            //     });
            // }
            // Send responses to backend
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
                        toastr.warning('No matching products were found.');
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
    if (window.scrollY > 50) {
      navbar.classList.add("scrolled");
    } else {
      navbar.classList.remove("scrolled");
    }
  });
</script>

   
@endpush


<div class="main-content app-content bg bg-primary">
            <div class="container-fluid">
            
                <!-- Start::page-header -->
                <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                    <div>
                        <h2 class="main-content-title fs-24 mb-1">Tell us what you like — your perfect wine is just a few answers away.</h2>
                    </div>
                </div>

                <!-- End::page-header -->

                <!-- Start row 0 -->
                <div class="row row-sm ">
                    <div class="col-xxl-3 col-xl-12">
                        <div class="card custom-card">
                            <!-- Badge Label -->
                            <div class="questionnaire-label">First Sip</div>
                            <img src="{{ asset('images/wineglasses.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="card-title fw-semibold mb-0">Find Your Perfect Pour</h6>
                            </div>
                            <button class="btn btn-danger mt-2 open-questionnaire-modal" data-questionnaire-id="1">
                                I want to try Now !!
                                <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon move-arrow" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-12">
                        <div class="card custom-card">
                            <!-- Badge Label -->
                            <div class="questionnaire-label">Savy Sip</div>
                            <img src="{{ asset('images/questionnaire2.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="card-title fw-semibold mb-0">Discover Your Wine Personality</h6>
                            </div>
                            <button class="btn btn-danger mt-2 open-questionnaire-modal" data-questionnaire-id="2">
                                I want to try Now !!
                                <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon move-arrow" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-12">
                        <div class="card custom-card">
                            <!-- Badge Label -->
                            <div class="questionnaire-label">Cork Master</div>
                            <img src="{{ asset('images/questionnaire3.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="card-title fw-semibold mb-0">Sip Smarter, Choose Better</h6>
                            </div>
                            <button class="btn btn-danger mt-2 open-questionnaire-modal" data-questionnaire-id="3">
                                I want to try Now !!
                                <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon move-arrow" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-12">
                        <div class="card custom-card">
                            <!-- Badge Label -->
                            <div class="questionnaire-label">Quick Pour</div>
                            <img src="{{ asset('images/questinnaire4.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h6 class="card-title fw-semibold mb-0">Wine, Tailored to You</h6>
                            </div>
                            <button class="btn btn-danger mt-2 open-questionnaire-modal" data-questionnaire-id="4">
                                I want to try Now !!
                                <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon move-arrow" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- End Row 0 -->

            

                <!-- Start::row-1 -->
                    <!-- <div class="row row-sm">
                        <div class="col-xl-4">
                            <div class="card custom-card">
                                <img src="{{ asset('images/questinnaire4.jpg') }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h6 class="card-title fw-semibold">First Sip (Basic Level)</h6>
                                    <h3 class="card-title">"Every expert was once a beginner."</h3>
                                    <p class="card-text mb-3 text-muted">Just getting started? Discover your taste preferences with simple, 
                                        fun questions that guide you to wines you’ll love. No pressure—just your first step into the 
                                        world of wine.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card custom-card">
                                <div class="card-body">
                                <h6 class="card-title fw-semibold">Savvy Sipper (Semi-Pro Level)</h6>
                                <h3 class="card-title">"You've got the swirl, now master the sip."</h3>
                                    <p class="card-text mb-3 text-muted">Already know a Cabernet from a Pinot? Dive deeper into regions, aromas, 
                                        and notes. This questionnaire refines your palate and helps you explore the wines that suit your 
                                        evolving taste.
                                    </p>
                                </div>
                                <img src="{{ asset('images/questionnaire2.jpg') }}" class="card-img-bottom" alt="...">
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <h6 class="card-title fw-semibold mb-1">Pro (Advanced Level)</h6>
                                    <h3 class="card-title">"Challenge your palate. Define your style."</h3>
                                    <p class="card-text mb-1 text-muted">You speak the language of tannins and terroir. This expert-level quiz 
                                        delves into nuanced wine traits, helping you pinpoint exactly what excites 
                                        your refined wine-loving senses.
                                    </p>
                                </div>
                                <img src="{{ asset('images/questionnaire3.jpg') }}" class="card-img rounded-0" alt="...">
                                
                            </div>
                        </div>
                    </div> -->
                <!-- Row 1 ends -->
                
                <!-- Start::row-2 -->
                    <div class="row row-sm">
                        <div class="col-sm-12 col-lg-12 col-xl-8">
                            <!-- Purple box row starts -->
                            <div class="row row-sm banner-img">
                                <div class="col-sm-12 col-lg-12 col-xl-12">
                                    <div class="card bg-primary custom-card card-box">
                                        <div class="card-body p-4">
                                            <div class="row">
                                                <div class="offset-xl-3 offset-sm-6 col-xl-8 col-sm-6 col-12 text-end">
                                                    <h4 class="d-flex mb-3 justify-content-end">
                                                        <span class="fw-bold text-fixed-white ">Welcome !</span>
                                                    </h4>
                                                    <p class="tx-white-7 mb-1 fs-3  ">Welcome to a world where, <br> every bottle tells a story.</p>
                                                </div>
                                            </div>
                                            <img src="{{ asset('images/3312991-photoroom.png') }}" alt="user-img" style="width:300px;height:200px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Purple Box row ends -->
                            <!-- Start::row -->
                                <div class="row row-sm">
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                        <div class="card custom-card">
                                            <div class="card-body">
                                                <div class="card-item">
                                                    <div class="card-item-icon card-icon">
                                                        <img src="{{ asset('images/wine-bottle.png') }}">
                                                    </div>
                                                    <div class="card-item-title mb-2">
                                                        <label class="main-content-label fs-15fw-bold mb-1">Products</label>
                                                        <span class="d-block fs-15 mb-0 text-muted">Welcome to the<br>Cellar</span>
                                                    </div>
                                                    <div class="card-item-body">
                                                        <div class="card-item-stat">
                                                            <h4 class="fw-bold"></h4>
                                                            <a href="{{ route('user.products') }}" class="btn btn-sm btn-outline-primary mt-2">View
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                                        <div class="card custom-card">
                                            <div class="card-body">
                                                <div class="card-item">
                                                    <div class="card-item-icon card-icon">
                                                    <img src="{{ asset('images/form.png') }}">
                                                    </div>
                                                    <div class="card-item-title mb-2">
                                                        <label class="main-content-label fs-13 fw-bold mb-1">Questionnaires</label>
                                                        <span class="d-block fs-15 mb-0 text-muted">Find Your<br> Perfect Pour</span>
                                                    </div>
                                                    <div class="card-item-body">
                                                        <div class="card-item-stat">
                                                            <h4 class="fw-bold"></h4>
                                                            <a href="" class="btn btn-sm btn-outline-primary mt-2">View
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-4">
                                        <div class="card custom-card">
                                            <div class="card-body">
                                                <div class="card-item">
                                                    <div class="card-item-icon card-icon">
                                                        <img src="{{ asset('images/red-wine.png') }}">
                                                    </div>
                                                    <div class="card-item-title  mb-2">
                                                        <label class="main-content-label fs-13 fw-bold mb-1">Featured Products</label>
                                                        <span class="d-block fs-15 mb-0 text-muted">Handpicked Elegance. Uncork the Best.</span>
                                                    </div>
                                                    <div class="card-item-body">
                                                        <div class="card-item-stat">
                                                            <h4 class="fw-bold"></h4>
                                                            <a href="{{ route('user.featuredproducts') }}" class="btn btn-sm btn-outline-primary mt-2">View
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="arrow-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 1 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- End::row -->
                        </div><!-- End of first col -->
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                            <div class="card custom-card">
                                <div class="card-header justify-content-between">
                                    <div class="card-title">Top Picks</div>
                                </div>
                                <div class="card-body">
                                    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <img src="{{ asset('storage/products/19 Crimes Hard Chardonnay.jpg') }}" class="d-block w-100" alt="...">
                                            </div>
                                            <div class="carousel-item">
                                                <img src="{{ asset('storage/products/19 Crimes Hard Chardonnay.jpg') }}" class="d-block w-100" alt="...">
                                            </div>
                                            <div class="carousel-item">
                                                <img src="{{ asset('storage/products/19 Crimes Hard Chardonnay.jpg') }}" class="d-block w-100" alt="...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- end of row 2 -->
            </div>
        </div>