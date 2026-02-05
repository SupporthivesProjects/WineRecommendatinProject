@extends('layouts.bootdashboard')
@section('admindashboardcontent')
@push('styles')

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
            font-size: 3.0rem;
            line-height: 1;
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
            color: #000000;
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

        .emoji-img {
            width: 60px;
            height:60px;
            transition: transform 0.2s ease;
        }

        .option-box {
            border-radius: 12px;
            /* height: 120px; */
            background-color: #fbfbfb;
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
        }

        .option-box:hover {
            /* background-color: transparent !important; */
            background-color: #FFDF00 !important;
            /* border-color: rgb(98,89,202) !important; or any static color */
            border-color: #FFDF00;
            color: inherit !important;
        }


    </style>

@endpush

    <!-- Transparent Navbar -->
    <nav id="mainNavbar" class="navbar navbar-expand-lg navbar-dark fixed-top transparent-navbar">
        <div class="container d-flex align-items-center">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between w-100" id="navbarNav">
                <!-- Nav links (left aligned) -->
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="{{ route('user.dashboard') }}" class="nav-link">Dashboard</a></li>
                    <li class="nav-item"><a href="{{ route('user.showQuestionnaire') }}" class="nav-link">Questionnaires</a></li>
                    <li class="nav-item"><a href="{{ route('user.products') }}" class="nav-link">Browse Wines</a></li>
                    <li class="nav-item"><a href="{{ route('user.cheeses') }}" class="nav-link">Browse Cheeses</a></li>
                    <li class="nav-item"><a href="{{ route('user.featuredproducts') }}" class="nav-link">Featured Products</a></li>
                </ul>
                <!-- Logout (right aligned) -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                            <a class="nav-link d-flex align-items-center" href="{{ route('logout') }}" 
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fe fe-power fs-16 align-middle me-2"></i> {{ __('Log Out') }}
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <!-- header section -->
    <section class="parallax-container">
        <div class="parallax-bg"></div>
        <div class="hero-text">
            <h1 class="text-white" id="mystyle">Explore Our Finest Wines</h1>
            <p>Curated selections for every occasion</p>
            <a href="#questionnaires" type="button" class="btn btn-dark">
                Explore
            </a>
        </div>
    </section>
    
    <section class="filters-and-cards bg-white" id="questionnaires">
        <div class="container my-5">
            <div class="row gx-3 gy-3">
                <div class="col-md-6">
                    <div class="image-card open-questionnaire-modal" data-questionnaire-id="1" >
                        <img src="{{ asset('images/QuestionnaireImage.jpg') }}" class="img-fluid" alt="Image 1">
                        <div class="overlay">
                            <div class="overlay-text">
                                <h4 class="default-text">First Sip</h4>
                                <h4 class="hover-text">New to wine? Start with your First Sip <br> we'll keep it simple and fun.</h4>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="image-card open-questionnaire-modal" data-questionnaire-id="2">
                        <img src="{{ asset('images/Wineglasses.jpg') }}" class="img-fluid" alt="Image 2">
                        <div class="overlay">
                            <div class="overlay-text">
                                <h4 class="default-text">Savy Sip</h4>
                                <h4 class="hover-text">Let’s fine-tune your sips with Savy Sipper.</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="image-card open-questionnaire-modal" data-questionnaire-id="3">
                        <img src="{{ asset('images/questionnaire2.jpg') }}" class="img-fluid" alt="Image 3">
                        <div class="overlay">
                            <div class="overlay-text">
                                <h4 class="default-text">Cork Master</h4>
                                <h4 class="hover-text">Crafted for connoisseurs <br> Unlock your palate with Cork Master.</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="image-card open-questionnaire-modal" data-questionnaire-id="4">
                        <img src="{{ asset('images/questionnaire3.jpg') }}" class="img-fluid" alt="Image 4">
                        <div class="overlay">
                            <div class="overlay-text">
                                <h4 class="default-text">Quick Pour</h4>
                                <h4 class="hover-text">For when you need a wine—quick and right.!!</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


  <!-- modal code -->
        <div class="modal fade" id="questionnaireModal" tabindex="-1" aria-labelledby="questionnaireModalLabel" aria-hidden="true" style="background:rgba(0,0,0,0.7)!important;">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-2" style="min-height: 500px;">
                    <div class="modal-body p-0 position-relative d-flex flex-wrap">
                        <!-- Close Button -->
                        <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>

                        <!-- Left Side: same design as login box -->
                        <div class="col-lg-6 col-xl-5 d-none d-lg-block text-center details" id="leftModalImageContainer">
                            <div class="mt-5 pt-4 p-2 position-absolute text-center" >
                                
                            </div>
                        </div>

                        <!-- Right Side: your original questionnaire content -->
                        <div class="col-lg-6 col-xl-7 col-xs-12 col-sm-12 p-4 d-flex flex-column justify-content-between">
                            <!-- Lottie Animation -->
                            <!-- <div class="lottie-container w-100 mb-3" id="lottieAnimation" style="height: 250px; width: auto;"></div> -->

                            <!-- Question Side -->
                            <div class="flex-grow-1" id="question-container">
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
    $('.open-questionnaire-modal').on('click', function() {
        const id = $(this).data('questionnaire-id');
        // your modal logic here
    });
</script>

<script>
            let questions = [];
            let currentStep = 0;
            let responses = {};  
            let selectedQuestionnaireId = null;
            const subRegionMap = {
                "France": ["Burgundy (France)", "Champagne (France)", "Rhône Valley (France)"],
                "Germany": [],
                "Italy": ["Tuscany (Italy)", "Piedmont (Italy)", "Veneto (Italy)"],
                "Spain": ["Rioja (Spain)", "Ribera del Duero (Spain)"],
                "Australia": ["Barossa Valley (Australia)", "Margaret River (Australia)"],
                "USA": ["Napa Valley (USA)", "Sonoma (USA)"],
                "Rest of the World": ["Marlborough (New Zealand)"]
            };
            window.selectedCountries = [];

            const wineRegionMap = 
            {
                "Domestic Indian": [],
                "Old World (France, Germany, Italy, Spain, Portugal, Austria)": [
                    "France", "Germany", "Italy", "Spain", "Portugal", "Austria"
                ],
                "New World (USA, Chile, Australia, Argentina,)": [
                    "USA", "Chile", "Australia", "Argentina", "South Africa", "New Zealand"
                ],
                "No Preference": "ALL"
            };
            window.selectedRegionGroup = null;


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
                "Spain": "Spain",
                "Australia": "Australia",
                "USA": "USA",
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
                "Old World (France, Germany, Italy, Spain, Portugal, Austria)": "OldWorld",
                "New World (USA, Chile, Australia, Argentina,)": "NewWorld",
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
                "medium bodied":"mediumbodied",
                "full bodied":"fullbodied",

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
                    } else {
                        $(this).addClass("hover");

                        setTimeout(() => {
                            $(this).removeClass("hover");
                        }, 30000);
                    }



                });
            });

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
                if (q.type === 'slider') {
                    const bands = q.bands ?? [
                        { min: 0, max: 5000, label: "₹0 – ₹5,000" },
                        { min: 5000, max: 25000, label: "₹5,000 – ₹25,000" },
                        { min: 25000, max: 50000, label: "₹25,000 – ₹50,000" },
                        { min: 50000, max: 100000, label: "₹50,000 – ₹1,00,000" }
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

                        <input 
                            type="range" 
                            class="form-range"
                            id="budgetSlider${qIndex}"
                            min="${bands[0].min}"
                            max="${bands[0].max}"
                            step="100"
                            value="${defaultValue}"
                        >

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
                    let options = [...q.options];

                    // ⭐ FILTER SUB-REGION OPTIONS
                    if (q.question.toLowerCase().includes("sub-region")) {
                        let allowed = [];

                        window.selectedCountries.forEach(country => {
                            if (subRegionMap[country]) {
                                allowed = allowed.concat(subRegionMap[country]);
                            }
                        });

                        options = options.filter(opt => allowed.includes(opt));
                    }
                    // FILTER COUNTRY SELECTION
                    if (q.question.toLowerCase().includes("country selection")) {
                        let allowed = [];

                        if (window.selectedRegionGroup && wineRegionMap[window.selectedRegionGroup]) {
                            const selected = wineRegionMap[window.selectedRegionGroup];

                            if (selected === "ALL") {
                                allowed = q.options; // show all
                            } else {
                                allowed = selected;  // mapped list
                            }
                        }

                        options = options.filter(opt => allowed.includes(opt));
                    }


                    const inputType = q.type === 'single' ? 'radio' : 'checkbox';
                    let rowHtml = '';
                    let optionsHtml = '';

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

                        slider.addEventListener('input', () => {
                            output.textContent = slider.value;
                        });

                        dropdown.addEventListener('change', () => {
                            const selectedOption = dropdown.options[dropdown.selectedIndex];

                            const min = Number(selectedOption.dataset.min);
                            const max = Number(selectedOption.dataset.max);

                            slider.min = min;
                            slider.max = max;
                            slider.value = min;

                            output.textContent = min;
                        });
                    }


                    if (q.type === 'single' || q.type === 'multiple') {
                        const inputs = document.querySelectorAll(`input[name="answer${index}"]`);
                        inputs.forEach(input => {
                            input.addEventListener('change', () => {

                                if (q.type === 'single') 
                                {
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

                                if (q.question.toLowerCase().includes("preferred wine country")) {
                                    window.selectedCountries = Array.from(
                                        document.querySelectorAll(`input[name="answer${index}"]:checked`)
                                    ).map(i => i.value);

                                    updateSubRegionOptions();
                                }

                                if (q.question.toLowerCase().includes("wine region group")) 
                                {
                                        const selected = document.querySelector(`input[name="answer${index}"]:checked`);
                                        window.selectedRegionGroup = selected ? selected.value : null;

                                        updateCountryOptions();
                                    }


                            });
                        });
                    }
                });
            }


            function updateSubRegionOptions() {
                const index = questions.findIndex(q =>
                    q.question.toLowerCase().includes("sub-region")
                );

                if (index === -1) return;

                if (currentStep === index || currentStep === 0) {
                    renderQuestion();
                }
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
        document.addEventListener('DOMContentLoaded', function () {
            const images = [
                "{{ asset('images/QuestModal1.jpg') }}",
                "{{ asset('images/QuestModal2.jpg') }}",
                "{{ asset('images/QuestModal3.jpg') }}",
            ];

            const modal = document.getElementById('questionnaireModal');
            const container = document.getElementById('leftModalImageContainer');

            modal.addEventListener('shown.bs.modal', function () {
                const randomIndex = Math.floor(Math.random() * images.length);
                container.style.backgroundImage = `url('${images[randomIndex]}')`;
                container.style.backgroundSize = 'cover';
                container.style.backgroundPosition = 'center';
                container.style.backgroundRepeat = 'no-repeat';
            });
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
    <script>
        function updateCountryOptions() 
        {
            const index = questions.findIndex(q =>
                q.question.toLowerCase().includes("country selection")
            );

            if (index === -1) return;

            if (currentStep === index || currentStep === 0) {
                renderQuestion();
            }
        }

    </script>


@endpush
