@extends('layouts.bootdashboard')
@section('admindashboardcontent')
@push('styles')

    <style>
        #mystyle
        {
            font-family: 'Cinzel Decorative', serif;

        }
       .featured-badge {
            /*background-color: rgba(0,0,0,0.4);*/
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
            background-image: url('{{ asset('images/matchedProducts.jpg') }}');
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
            width: 100%;
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
        
    </style>

@endpush

    <!-- Transparent Navbar -->
    <nav id="mainNavbar" class="navbar navbar-expand-lg navbar-dark fixed-top transparent-navbar">
        <div class="container">
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

    <section class="hero-section">
        <div class="hero-text">
        <h1 class="text-white" id="mystyle">Explore Our Finest Wines</h1>
        <p class="text-white">Curated selections for every occasion</p>
        </div>
    </section>

<div class="" id="matchedproducts">
    <div class="container my-5">
         <!-- Start::row-6 -->
            <div class="row">
                <!-- Filter sidebar -->
                <div class="col-3">
                    <div class="filter-group">
                    <!-- Types Filter -->
                        <h4 class="fw-bold mb-4">Types</h4>
                        @php
                            $types = $products->pluck('type')->unique()->sort();
                        @endphp
                        @foreach ($types as $type)
                            <div class="form-check">
                                <input class="form-check-input wine-type-filter" type="checkbox" value="{{ strtolower($type) }}" id="type-{{ strtolower($type) }}">
                                <label class="form-check-label fs-15" for="type-{{ strtolower($type) }}">
                                    {{ ucfirst($type) }}
                                </label>
                            </div>
                        @endforeach
                    </div>

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
                                    {{ ucfirst($winery) }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <!-- Retail Price Filter -->
                    <div class="filter-group">
                        <h4 class="fw-bold mb-4">Retail Price</h4>
                        @php
                            $prices = $products->pluck('retail_price')->unique()->sort();
                        @endphp
                        @foreach ($prices as $price)
                            <div class="form-check">
                                <input class="form-check-input wine-retail-price-filter" type="checkbox" value="{{ $price }}" id="retail-price-{{ $price }}">
                                <label class="form-check-label" for="retail-price-{{ $price }}">
                                    ${{ number_format($price, 2) }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <!-- Country Filter -->
                    <div class="filter-group">
                        <h4 class="fw-bold mb-4">Country</h4>
                        @php
                            $countries = $products->pluck('country')->unique()->sort();
                        @endphp
                        @foreach ($countries as $country)
                            <div class="form-check">
                                <input class="form-check-input wine-country-filter" type="checkbox" value="{{ $country }}" id="country-{{ strtolower($country) }}">
                                <label class="form-check-label" for="country-{{ strtolower($country) }}">
                                    {{ ucfirst($country) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>


                <!-- Products grid -->
                <div class="col-9">
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
    </div>
</div>

@endsection
@push('scripts')
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



@endpush
