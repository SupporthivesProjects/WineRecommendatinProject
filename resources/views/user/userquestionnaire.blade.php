@extends('layouts.bootdashboard')
@section('admindashboardcontent')
@push('styles')

    <style>
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
            top:80px;
            width: 100%;
            z-index: 10;
            padding: 10px 0;
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

        .image-card:hover img {
            transform: scale(1.05);
        }

        .image-card:hover .overlay {
            background-color: rgba(0,0,0,0.9);
        }

        .image-card:hover .overlay-text .default-text {
            display: none;
        }

        .image-card:hover .overlay-text .hover-text {
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
            height: 100vh;
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

    </style>

@endpush

    <!-- Transparent Navbar -->
    <nav id="mainNavbar" class="navbar navbar-expand-lg navbar-dark fixed-top transparent-navbar">
        <div class="container">
            <a class="navbar-brand text-white" href="#">
                My Brand
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="{{ route('user.dashboard') }}" class="nav-link">Dashboard</a></li>
                    <li class="nav-item"><a href="{{ route('user.showQuestionnaire') }}" class="nav-link">Questionnaires</a></li>
                    <li class="nav-item"><a href="{{ route('user.products') }}" class="nav-link">Browse Wines</a></li>
                    <li class="nav-item"><a href="{{ route('user.featuredproducts') }}" class="nav-link">Featured Products</a></li>
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
        </div>
    </section>
    <section class="filters-and-cards bg-white">
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
                        <img src="{{ asset('images/wineglasses.jpg') }}" class="img-fluid" alt="Image 2">
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
                    <div class="image-card open-questionnaire-modal" data-questionnaire-id="1">
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
 <div class="modal fade" id="questionnaireModal" tabindex="-1" aria-labelledby="questionnaireModalLabel" aria-hidden="true">>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0">
            <div class="modal-body d-flex flex-column p-0 position-relative">

                <!-- Close button (top-right) -->
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>

                <!-- Lottie Animation -->
                <div class="lottie-container w-100" id="lottieAnimation" style="height: 250px; width: auto;"></div>

                <!-- Question Side -->
                <div class="w-100 p-4 d-flex flex-column justify-content-between">
                    <div id="question-container">
                        <!-- Question and options will load here -->
                    </div>

                    <!-- Buttons Row -->
                    <div class="d-flex mt-4 gap-2">
                        <button class="btn btn-secondary btn-lg w-50" id="backBtn">Back</button>
                        <button class="btn btn-primary btn-lg w-50" id="nextBtn">Next</button>
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

            const emojiMap = {
            "Red": "🍷",
            "White": "🥂",
            "Rosé": "🌹",
            "Fruit": "🍇",
            "Sparkling / Champagne": "🥂🍾",
            "Yes": "✅",
            "No": "❌",
            "SKIP": "⏭️",
            "Fruit Wine": "🍇",
            "Still": "🧊",
            "Sparkling": "🍾",
            "Sparkling/Champagne": "🍾",
            "Sweet": "🍬",
            "Medium Sweet": "🍯",
            "Lightly Sweet": "🧁",
            "Dry": "🍂",
            "Skip": "⏭️",
            "Fruit-Driven": "🍓",
            "Juicy/Fruit-Forward": "🍒",
            "Aromatic": "🌸",
            "Earthy": "🌱",
            "Mineral-Driven": "🪨",
            "Light-bodied (Soft & Refreshing)": "☁️",
            "Medium-bodied (Balanced & Smooth)": "🥃",
            "Full-bodied (Rich & Intense)": "💪",
            "Very Fruity": "🍉",
            "Slightly Fruity": "🍑",
            "Not Fruity": "🥖",
            "Young and Refreshing": "🧃",
            "Bold and Old": "🧓",
            "Any": "🌍",
            "India": "🇮🇳",
            "France": "🇫🇷",
            "Italy": "🇮🇹",
            "Spain": "🇪🇸",
            "Australia": "🇦🇺",
            "USA": "🇺🇸",
            "Rest of the World": "🌎",
            "Budget": "💰",
            "Everyday sipping": "🛋️",
            "Celebration": "🎉",
            "Gifting": "🎁",
            "Dinner with Friends": "🍽️",
            "Wine and Cheese": "🧀🍷",
            "Pairing with food (Coming Soon)": "🍽️",
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
            "Dry": "🍂🍷",
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
            "Aromatic": "🌸🍷",
            "Fruit-driven": "🍇🍷",
            "Dry": "🍂🍷",
            "Mineral-Driven": "🪨🍷",
            "Earthy": "🌱🍷",
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
                        //const emoji = (selectedQuestionnaireId === '1' || selectedQuestionnaireId === 1) && emojiMap[opt] ? `<div class="emoji-icon mb-1">${emojiMap[opt]}</div>` : '';
                        const emoji = emojiMap[opt] ? `<div class="emoji-icon mb-1">${emojiMap[opt]}</div>` : '';

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
    document.addEventListener("scroll", function () {
        const scrolled = window.scrollY;
        const parallax = document.querySelector(".parallax-bg");
        if (parallax) {
            parallax.style.transform = `translateY(${scrolled * 0.4}px)`; // adjust 0.4 for speed
        }
    });
</script>

@endpush
