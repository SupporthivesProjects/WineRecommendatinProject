@extends('layouts.bootdashboard')
@section('admindashboardcontent')

@push('styles')

    <style>
        html, body {
            overscroll-behavior: none;       
            overflow-x: hidden;             
        }
         #mystyle
        {
            font-family: 'Cinzel Decorative', serif;

        }
       .featured-badge {
            background-color: rgba(165, 9, 8, 0.7);
            color: white; 
            padding: 5px 10px; 
            font-size: 12px; 
            font-weight: bold; 
            text-transform: uppercase; 
            position: absolute; 
            top: 10px; 
            right: 10px; 
            z-index: 10; 

        }

        .hero-section 
        {
            height: 100vh;
            background-image: url('{{ asset('images/productsredwine.jpg') }}');
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
        .hero-text h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .wine-card {
            border-radius: 0 !important; 
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            box-shadow: none;
        }

        .wine-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); /* Floating effect */
            transform: translateY(-4px);
        }

        .filter-group {
            margin-bottom: 2rem;
        }

        .filter-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            border-bottom: 1px solid #ddd;
            padding-bottom: 0.5rem;
        }

        .form-check {
            margin-bottom: 0.75rem;
        }

        .form-check-input:checked {
            background-color: #8b0000; /* Deep wine red */
            border-color: #8b0000;
        }

        .form-check-label {
            font-size: 0.95rem;
            color: #444;
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 0.1rem rgba(139, 0, 0, 0.25);
        }
        

        .transparent-navbar {
            background: transparent;
            position: fixed;
            top:20px;
            width: 101%;
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

        .parallax-container 
        {
            position: relative;
            height: 70vh;
            overflow: hidden;
        }

        .parallax-bg 
        {
            background-image:  url('{{ asset('images/blacklanding.jpg') }}');
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
            text-align: right;          
            width: 100%;
            padding-right: 5%; 
            
        }

        .filters-and-cards 
        {
            background: #fff;
            padding: 100px 20px;
            min-height: 100vh;
        }

        #price-slider .ui-slider-tick-mark {
            position: absolute;
            height: 10px;
            width: 1px;
            background: #000;
            top: 50%;
            transform: translateY(-50%);
        }

        #price-slider {
            position: relative;
        }

        #price-slider .tick-label {
            position: absolute;
            top: 20px;
            font-size: 12px;
            transform: translateX(-50%);
        }

        
        .ui-slider-range {
            background-color: red!important; 
        }

        /* Slider handles */
        .ui-slider-horizontal .ui-slider-handle {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: none;
            background-color: #dc3545!important; 
            top: -0.4em; 
            cursor: pointer;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
            transition: background-color 0.2s ease;
        }

        .ui-slider-horizontal .ui-slider-handle:hover {
            background-color: #0b5ed7!important; 
        }


        /* Style the label like a button/tag */
        .filter-checkbox {
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-radius: 20px;
            user-select: none;
            transition: background-color 0.3s, border-color 0.3s;
            margin-right: 8px;
        }

        /* Highlight selected (checked) checkbox label */
        input[type="checkbox"].form-check-input:checked + .filter-checkbox {
            background-color: rgba(165, 9, 8, 0.7);
            color: white;
            border-color: white;
        }

        /* Emoji styling */
        .emoji {
            font-size: 1.4em;
            line-height: 1;
        }

        .wine-type-scroll {
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch; /* Smooth scroll on mobile */
        }

        .wine-type-scroll .form-check {
            display: inline-block;
            margin-right: 1rem; /* spacing between options */
            white-space: nowrap;
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
            <div class="hero-text my-3">
                <h1 class="text-white" id="mystyle">Explore Our Finest Wines</h1>
                <p class="text-muted">Curated selections for every occasion</p>
                <a type="button" class="btn btn-dark" href="#products">
                    Explore
                </a>
            </div>
        </section>
    <!-- section 2 of scrolling cards -->
        <section class="filters-and-cards" id="products">
            <div class="">
                <div class="container my-5">
                    <!-- Start::row-6 -->
                        <div class="row g-2">
                            <!-- Filter sidebar -->
                            <div class="col-12 col-md-3 d-none d-md-block bg-light rounded rounded-2 p-4 align-self-start">
                                <!-- Vintage Year Filter -->
                                <div class="filter-group">
                                    <h4 class="fw-bold mb-4">Vintage Year</h4>
                                    @php
                                        $vintageYears = $products->pluck('vintage_year')->unique()->sort();
                                    @endphp
                                    @foreach ($vintageYears as $year)
                                        <div class="form-check">
                                            <input class="form-check-input wine-vintage-year-filter" type="checkbox" value="{{ $year }}" id="vintage-year-{{ $year }}">
                                            <label class="form-check-label" for="vintage-year-{{ $year }}">
                                                {{ $year }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Winery Filter -->
                                <div class="filter-group">
                                    <h4 class="fw-bold mb-4">Winery</h4>
                                    @php
                                        $wineries = $products->pluck('winery')->unique()->sort();
                                    @endphp
                                    @foreach ($wineries as $winery)
                                        <div class="form-check">
                                            <input class="form-check-input wine-winery-filter" type="checkbox" value="{{ $winery }}" id="winery-{{ strtolower($winery) }}">
                                            <label class="form-check-label" for="winery-{{ strtolower($winery) }}">
                                                {{ ucfirst($winery) }} 🍷
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Retail Price Filter -->
                                <!-- Retail Price Slider -->
                                <div class="filter-group">
                                    <h4 class="fw-bold mb-4">Retail Price</h4>
                                    <p>
                                        <span id="price-range-label">$<span id="price-min"></span> - $<span id="price-max"></span></span>
                                    </p>
                                    <div id="price-slider" style="margin-top: 10px;"></div>
                                </div>
                            </div>
                            <!-- Products grid -->
                            <div class="col-12 col-md-9  rounded rounded-2 p-3">
                                <!-- Type and Country filters at top -->
                                <div class="row mb-4">
                                    <div class="col-12 col-lg-6 mb-3 filter-group wine-type-scroll">
                                        <h4 class="fw-bold mb-3">Types</h4>
                                        @php
                                            $types = $products->pluck('type')->unique()->sort();
                                        @endphp

                                        @foreach ($types as $type)
                                            @php
                                                $lowerType = strtolower($type);
                                                $emoji = match($lowerType) {
                                                    'red' => '🍷',
                                                    'white' => '🥂',
                                                    'sparkling' => '✨',
                                                    default => ''
                                                };
                                            @endphp

                                            <div class="form-check form-check-inline">
                                                <input
                                                    class="form-check-input wine-type-filter"
                                                    type="checkbox"
                                                    value="{{ $lowerType }}"
                                                    id="type-inline-{{ $lowerType }}"
                                                    style="display: none;">
                                                
                                                <label class="form-check-label fs-15 filter-checkbox" for="type-inline-{{ $lowerType }}">
                                                    <span class="emoji">{{ $emoji }}</span> {{ ucfirst($type) }}
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                    <div class="col-12 col-lg-6 mb-3 filter-group wine-type-scroll">
                                        <h4 class="fw-bold mb-3">Country</h4>
                                        @php
                                            $countries = $products->pluck('country')->unique()->sort();
                                        @endphp

                                        @foreach ($countries as $country)
                                            @php
                                                $lowerCountry = strtolower($country);
                                                $emoji = match($lowerCountry) {
                                                    'france' => '🇫🇷',
                                                    'italy' => '🇮🇹',
                                                    'spain' => '🇪🇸',
                                                    'australia' => '🇦🇺',
                                                    'united states' => '🇺🇸',
                                                    'germany' => '🇩🇪',
                                                    'new zealand' => '🇳🇿',
                                                    'bulgaria' => '🇧🇬',
                                                    default => '🌍'
                                                };

                                            @endphp

                                            <div class="form-check form-check-inline">
                                                <input
                                                    class="form-check-input wine-country-filter"
                                                    type="checkbox"
                                                    value="{{ $lowerCountry }}"
                                                    id="country-inline-{{ $lowerCountry }}"
                                                    style="display: none;">
                                                
                                                <label class="form-check-label fs-15 filter-checkbox" for="country-inline-{{ $lowerCountry }}">
                                                    <span class="emoji">{{ $emoji }}</span> {{ ucfirst($country) }}
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                                <div class="row row-sm">
                                    @foreach ($products as $product)
                                        <div class="col-xl-4 wine-card-container" data-type="{{ strtolower($product->type) }}"
                                        data-vintage-year="{{ $product->vintage_year }}"
                                        data-winery="{{ $product->winery }}"
                                        data-retail-price="{{ $product->retail_price }}"
                                        data-country="{{ $product->country }}">
                                            <div class="card custom-card wine-card">
                                                <!-- Image at the top -->
                                                <div class="image-wrapper" style="position: relative;">
                                                    @php
                                                        $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
                                                    @endphp
                                                    <img src="{{ $primaryImage ? asset('storage/products/' . $primaryImage->image_path) : asset('images/default.jpg') }}" class="card-img-top rounded-0" alt="{{ $product->wine_name }}">

                                                    <!-- Featured badge on the image -->
                                                    @if ($product->is_featured == 1)
                                                        <span class="featured-badge">Featured</span>
                                                    @endif
                                                </div>

                                                <!-- Card body with product information -->
                                                <div class="card-body">
                                                    <h5 class="card-title fw-semibold"> {{ $product->wine_name }}</h5>
                                                    @php
                                                        $type = strtolower($product->type);
                                                        $emoji = match($type) {
                                                            'red' => '🍷',
                                                            'white' => '🥂',
                                                            'sparkling' => '✨',
                                                            default => ''
                                                        };
                                                    @endphp
                                                    <p>
                                                        <strong>Type:</strong> {{ ucfirst($type) }}
                                                        @if ($emoji)
                                                            <span style="font-size: 1.5em;">{{ $emoji }}</span>
                                                        @endif
                                                    </p>

                                                    <p><strong>Vintage Year:</strong> {{ $product->vintage_year }}</p>
                                                    <a href="{{ route('user.productdetails', $product->id) }}" class="btn btn-dark mt-2 rounded-0">
                                                        I want to try Now !!
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div> 
                    <!-- End::row-6 -->

                
                    <!-- Pagination Code -->
                    @if ($products->hasPages())
                        <div class="d-flex justify-content-center my-4">
                            <nav aria-label="Page navigation">
                                <ul class="pagination mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($products->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="bi bi-caret-left"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">
                                                <i class="bi bi-caret-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                        <li class="page-item {{ $products->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($products->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">
                                                <i class="bi bi-caret-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="bi bi-caret-right"></i></span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </section>

@endsection
@push('scripts')
    <script>
        $(function () {
            const prices = @json($products->pluck('retail_price')->unique()->sort()->values());
            const min = Math.floor(Math.min(...prices));
            const max = Math.ceil(Math.max(...prices));

            $("#price-slider").slider({
                range: true,
                min: min,
                max: max,
                step: 1,
                values: [min, max],
                slide: function (event, ui) {
                    $("#price-min").text(ui.values[0]);
                    $("#price-max").text(ui.values[1]);

                    // Optional: trigger filter function here
                    filterProductsByPrice(ui.values[0], ui.values[1]);
                }
            });

            // Initialize labels
            $("#price-min").text(min);
            $("#price-max").text(max);
        });

        function filterProductsByPrice(min, max) {
            $(".wine-card-container").each(function () {
                const price = parseFloat($(this).data("retail-price"));
                if (price >= min && price <= max) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        $(function () {
            const slider = $("#price-slider");
            const steps = 5;
            for (let i = 0; i <= steps; i++) {
                const percent = (i / steps) * 100;
                const tick = $("<span class='ui-slider-tick-mark'></span>").css("left", percent + "%");
                const label = $("<span class='tick-label'></span>").text(min + i * ((max - min) / steps)).css("left", percent + "%");
                slider.append(tick).append(label);
            }
        });


    </script>

    <script>
        // Wait for the DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', () => {

            function filterCards() {
                const selectedTypes = Array.from(document.querySelectorAll('.wine-type-filter:checked')).map(cb => cb.value.trim().toLowerCase());
                const selectedVintageYears = Array.from(document.querySelectorAll('.wine-vintage-year-filter:checked')).map(cb => cb.value.trim().toLowerCase());
                const selectedWineries = Array.from(document.querySelectorAll('.wine-winery-filter:checked')).map(cb => cb.value.trim().toLowerCase());
                const selectedPrices = Array.from(document.querySelectorAll('.wine-retail-price-filter:checked')).map(cb => cb.value.trim().toLowerCase());
                const selectedCountries = Array.from(document.querySelectorAll('.wine-country-filter:checked')).map(cb => cb.value.trim().toLowerCase());

                document.querySelectorAll('.wine-card-container').forEach(card => {
                    const cardType = (card.getAttribute('data-type') || '').trim().toLowerCase();
                    const cardVintageYear = (card.getAttribute('data-vintage-year') || '').trim().toLowerCase();
                    const cardWinery = (card.getAttribute('data-winery') || '').trim().toLowerCase();
                    const cardRetailPrice = (card.getAttribute('data-retail-price') || '').trim().toLowerCase();
                    const cardCountry = (card.getAttribute('data-country') || '').trim().toLowerCase();

                    const matchesType = selectedTypes.length === 0 || selectedTypes.includes(cardType);
                    const matchesVintageYear = selectedVintageYears.length === 0 || selectedVintageYears.includes(cardVintageYear);
                    const matchesWinery = selectedWineries.length === 0 || selectedWineries.includes(cardWinery);
                    const matchesPrice = selectedPrices.length === 0 || selectedPrices.includes(cardRetailPrice);
                    const matchesCountry = selectedCountries.length === 0 || selectedCountries.includes(cardCountry);

                    if (matchesType && matchesVintageYear && matchesWinery && matchesPrice && matchesCountry) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            // Attach the event listener to all filter checkboxes
            document.querySelectorAll(
                '.wine-type-filter, .wine-vintage-year-filter, .wine-winery-filter, .wine-retail-price-filter, .wine-country-filter'
            ).forEach(checkbox => {
                checkbox.addEventListener('change', filterCards);
            });

            // Run filter once on load (optional)
            filterCards();

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
