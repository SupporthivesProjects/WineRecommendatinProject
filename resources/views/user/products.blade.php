@extends('layouts.user')
@section('title', 'Browse Wines')
@section('admindashboardcontent')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/product-listing.css') }}?v={{ filemtime(public_path('assets/css/product-listing.css')) }}">
    <link rel="stylesheet" href="{{ asset('assets/css/cart-animation.css') }}?v={{ filemtime(public_path('assets/css/cart-animation.css')) }}">
    <link rel="stylesheet" href="{{ asset('assets/css/price-filter.css') }}?v={{ filemtime(public_path('assets/css/price-filter.css')) }}">
    <link rel="stylesheet" href="{{ asset('assets/css/floating-cart.css') }}?v={{ filemtime(public_path('assets/css/floating-cart.css')) }}">

    <style>
        html, body {
            overscroll-behavior: auto;       
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
        }

        .wine-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15)!important; 
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
        

        .parallax-container 
        {
            position: relative;
            height: 80vh;
            overflow: hidden;
        }

        .parallax-bg 
        {
            background-image:  url('{{ asset('images/trytwo.jpg') }}');
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

        /* Retail Price slider: assets/css/price-filter.css */

        /* While the filters fetch new results */
        #products-grid {
            transition: opacity 0.2s ease;
        }
        #products-grid.is-loading {
            opacity: 0.45;
            pointer-events: none;
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

        

        @media (max-width: 768px) {
            .filters-and-cards {
                padding: 50px 20px;
            }
        }
    </style>

    

@endpush
    <!-- header section -->
        <section class="parallax-container">
            <div class="parallax-bg"></div>
            <div class="hero-text my-3">
                <h1 class="text-black " id="mystyle">Explore Our Finest Wines</h1>
                <p>Curated selections for every occasion</p>
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
                            <div class="col-12 col-md-3 d-none d-md-block bg-light rounded rounded-2 p-4 align-self-start listing-filter-panel">
                            {{-- Vintage Year Filter --}}
                            <div class="filter-group">
                                <h4 class="fw-bold mb-4">Vintage Year</h4>

                                @foreach ($allVintageYears as $year)
                                    <div class="form-check">
                                        <input
                                            class="form-check-input wine-vintage-year-filter"
                                            type="checkbox"
                                            value="{{ $year }}"
                                            id="vintage-year-{{ $year }}"
                                            {{ in_array($year, (array) request('vintage_years', [])) ? 'checked' : '' }}
                                        >
                                        <label
                                            class="form-check-label"
                                            for="vintage-year-{{ $year }}"
                                        >
                                            {{ $year }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Grape Variety Filter --}}
                            <div class="filter-group">
                                <h4 class="fw-bold mb-4">Grape Variety</h4>

                                @foreach ($allGrapeVarieties as $variety)
                                    <div class="form-check grape-variety-option {{ $loop->index >= 10 ? 'd-none' : '' }}">
                                        <input
                                            class="form-check-input wine-grape-variety-filter"
                                            type="checkbox"
                                            value="{{ $variety }}"
                                            id="grape-variety-{{ $loop->index }}"
                                            {{ in_array($variety, (array) request('grape_varieties', [])) ? 'checked' : '' }}
                                        >

                                        <label
                                            class="form-check-label"
                                            for="grape-variety-{{ $loop->index }}"
                                        >
                                        {{ ucfirst(strtolower($variety)) }}
                                        </label>
                                    </div>
                                @endforeach

                                @if ($allGrapeVarieties->count() > 10)
                                    <button
                                        type="button"
                                        id="grape-variety-toggle"
                                        class="btn btn-link p-0 mt-2 text-decoration-none"
                                    >
                                        Read More
                                    </button>
                                @endif
                            </div>

                        
                                <!-- Retail Price Filter -->
                                <!-- Retail Price Slider -->
                                <div class="filter-group ts-price-filter">
                                    <h4 class="fw-bold mb-4">Retail Price</h4>
                                    <div class="ts-price-values" id="price-range-label">
                                        <div class="ts-price-box">
                                            <span class="ts-price-caption">Min</span>
                                            <span class="ts-price-amount">₹<span id="price-min"></span></span>
                                        </div>
                                        <span class="ts-price-dash" aria-hidden="true">–</span>
                                        <div class="ts-price-box">
                                            <span class="ts-price-caption">Max</span>
                                            <span class="ts-price-amount">₹<span id="price-max"></span></span>
                                        </div>
                                    </div>
                                    <div id="price-slider"></div>
                                </div>
                            </div>
                            <!-- Products grid -->
                            <div class="col-12 col-md-9  rounded rounded-2 p-3">
                                <!-- Type and Country filters at top -->
                                <div class="row mb-4">
                                    <div class="col-12 col-lg-6 mb-3 filter-group wine-type-scroll">
                                        <h4 class="fw-bold mb-3">Types</h4>
                                        @foreach ($allTypes as $type)
                                            @php
                                                $lowerType = strtolower($type);
                                                $emoji = match($lowerType) {
                                                    'red' => '🍷', 
                                                    'white' => '<i class="fas fa-wine-glass text-warning" title="White Wine"></i>', 
                                                    'sparkling' => '✨', 
                                                    'rosé' => '🌸', 
                                                    'dessert' => '🍯', 
                                                    'bordeaux' => '🏰',
                                                    default => '🍾',
                                                };
                                            @endphp

                                            <div class="form-check form-check-inline">
                                            <input
                                                class="form-check-input wine-type-filter"
                                                type="checkbox"
                                                value="{{ $lowerType }}"
                                                id="type-inline-{{ $lowerType }}"
                                                style="display:none;"
                                                {{ in_array($lowerType, request()->input('types', [])) ? 'checked' : '' }}
                                            >
                                                
                                                <label class="form-check-label fs-15 filter-checkbox" for="type-inline-{{ $lowerType }}">
                                                    <span class="emoji">{!! $emoji !!}</span> {{ ucfirst($type) }}
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                    <div class="col-12 col-lg-6 mb-3 filter-group">
                                        <h4 class="fw-bold mb-3">Country</h4>
                                        <div class="wine-type-scroll">
                                            @foreach ($allCountries as $country)
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
                                                        style="display:none;"
                                                        {{ in_array($lowerCountry, request()->input('countries', [])) ? 'checked' : '' }}
                                                    >
                                                    
                                                    <label class="form-check-label fs-15 filter-checkbox" for="country-inline-{{ $lowerCountry }}">
                                                        <span class="emoji">{{ $emoji }}</span> {{ ucfirst($country) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-10">
                                        <form method="GET" action="{{ route('user.products') }}">
                                            <div class="input-group">
                                                <input type="text"
                                                    name="search"
                                                    class="form-control"
                                                    placeholder="Search wines..."
                                                    value="{{ request('search') }}">

                                                <button class="btn btn-dark" type="submit">
                                                    Search
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-2">
                                    <a href="{{ route('user.products') }}" class="btn btn-outline-secondary">
                                        Clear Filters
                                    </a>
                                    </div>
                                </div>
                                <div class="row row-sm product-card-grid" id="products-grid">
                                    @if ($products->isEmpty())
                                        <div class="col-12 text-center text-muted py-5 products-empty">
                                            No wines match these filters.
                                        </div>
                                    @endif
                                    @foreach ($products as $product)
                                        <div class="col-md-6 col-xl-4 wine-card-container" data-type="{{ strtolower($product->type) }}"
                                        data-vintage-year="{{ $product->vintage_year }}"
                                        data-winery="{{ $product->winery }}"
                                        data-retail-price="{{ $product->display_price }}"
                                        data-country="{{ $product->country }}">
                                            <div class="card custom-card wine-card">
                                                <!-- Image at the top -->
                                                <div class="image-wrapper product-card-media">
                                                    <img decoding="async" loading="lazy" src="{{ asset('storage/' . $product->image1) }}" class="card-img-top rounded-0" alt="{{ $product->wine_name }}">

                                                    <!-- Featured badge on the image -->
                                                    @if ($product->is_featured == 1)
                                                        <span class="featured-badge">
                                                            <i class="fas fa-crown"></i> Featured
                                                        </span>
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

                                                    <p><strong>Vintage:</strong> {{ $product->vintage_year ?: '—' }}</p>

                                                    <p><strong>MRP:</strong> {{ $product->display_price }}</p>
                                                    <a href="{{ route('user.productdetails', $product->id) }}" class="btn btn-dark mt-2 rounded-0">
                                                        View details
                                                    </a>
                                                    @include('partials.cart-button')
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div> 
                    <!-- End::row-6 -->
                     <!-- Fixed Cart Icon -->
                     @include('partials.floating-cart')

                
                    <!-- Pagination Code (swapped in place by the filters, see below) -->
                    <div id="products-pagination">
                    @if ($products->hasPages())
                        @php
                            $lastPage = $products->lastPage();
                            $currentPage = $products->currentPage();

                            // Show current page with one page before and after
                            $start = max(1, $currentPage - 1);
                            $end = min($lastPage, $currentPage + 1);
                        @endphp

                        <div class="d-flex justify-content-center my-4">
                            <nav aria-label="Page navigation">
                                <ul class="pagination mb-0">

                                    {{-- First Page --}}
                                    <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $products->url(1) }}" aria-label="First">
                                            &laquo;&laquo;
                                        </a>
                                    </li>

                                    {{-- Previous Page --}}
                                    <li class="page-item {{ $products->onFirstPage() ? 'disabled' : '' }}">
                                        @if ($products->onFirstPage())
                                            <span class="page-link">&laquo;</span>
                                        @else
                                            <a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev">
                                                &laquo;
                                            </a>
                                        @endif
                                    </li>

                                    {{-- First Page + Ellipsis --}}
                                    @if ($start > 1)
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $products->url(1) }}">1</a>
                                        </li>

                                        @if ($start > 2)
                                            <li class="page-item disabled">
                                                <span class="page-link">...</span>
                                            </li>
                                        @endif
                                    @endif

                                    {{-- Middle Pages --}}
                                    @foreach (range($start, $end) as $page)
                                        <li class="page-item {{ $currentPage == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $products->url($page) }}">
                                                {{ $page }}
                                            </a>
                                        </li>
                                    @endforeach

                                    {{-- Last Page + Ellipsis --}}
                                    @if ($end < $lastPage)
                                        @if ($end < $lastPage - 1)
                                            <li class="page-item disabled">
                                                <span class="page-link">...</span>
                                            </li>
                                        @endif

                                        <li class="page-item">
                                            <a class="page-link" href="{{ $products->url($lastPage) }}">
                                                {{ $lastPage }}
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Next Page --}}
                                    <li class="page-item {{ !$products->hasMorePages() ? 'disabled' : '' }}">
                                        @if ($products->hasMorePages())
                                            <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next">
                                                &raquo;
                                            </a>
                                        @else
                                            <span class="page-link">&raquo;</span>
                                        @endif
                                    </li>

                                    {{-- Last Page --}}
                                    <li class="page-item {{ $currentPage == $lastPage ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $products->url($lastPage) }}" aria-label="Last">
                                            &raquo;&raquo;
                                        </a>
                                    </li>

                                </ul>
                            </nav>
                        </div>
                    @endif
                    </div>
                     <!--new  code  -->
                </div>
            </div>
        </section>

@endsection
@push('scripts')
    <!-- Phone filter drawer -->
    <script src="{{ asset('assets/js/listing-filters.js') }}?v={{ filemtime(public_path('assets/js/listing-filters.js')) }}"></script>
    <script src="{{ asset('assets/js/cart-animation.js') }}?v={{ filemtime(public_path('assets/js/cart-animation.js')) }}"></script>
    <script>
        /*
         * Filters and page links update the wine grid in place: fetch the filtered page,
         * swap only the cards and the page numbers, keep the scroll position and update the
         * address (so reload and sharing keep the filters). Falls back to a normal page load.
         */
        let listingRequest = null;

        function loadListing(url, scrollToGrid) {
            const grid = document.getElementById('products-grid');
            const pagination = document.getElementById('products-pagination');
            if (!grid || !pagination || !window.fetch || !window.DOMParser) {
                window.location.href = url;
                return;
            }

            if (listingRequest) {
                listingRequest.abort();
            }
            listingRequest = new AbortController();

            history.replaceState(null, '', url);
            grid.classList.add('is-loading');

            fetch(url, {
                credentials: 'same-origin',
                // Marked as a background request, so it is not counted as a page view
                headers: { 'Accept': 'text/html', 'X-Requested-With': 'XMLHttpRequest' },
                signal: listingRequest.signal
            })
                .then(response => response.ok ? response.text() : Promise.reject(new Error('HTTP ' + response.status)))
                .then(html => {
                    const page = new DOMParser().parseFromString(html, 'text/html');
                    const newGrid = page.getElementById('products-grid');
                    const newPagination = page.getElementById('products-pagination');
                    if (!newGrid || !newPagination) {
                        throw new Error('Unexpected response');
                    }
                    grid.innerHTML = newGrid.innerHTML;
                    pagination.innerHTML = newPagination.innerHTML;
                    grid.classList.remove('is-loading');

                    if (scrollToGrid) {
                        const top = grid.getBoundingClientRect().top + window.scrollY - (parseInt(getComputedStyle(document.documentElement).getPropertyValue('--site-navbar-height'), 10) || 80) - 20;
                        window.scrollTo({ top: top, behavior: 'smooth' });
                    }
                })
                .catch(error => {
                    if (error.name === 'AbortError') {
                        return;
                    }
                    window.location.href = url;
                });
        }

        // Page numbers: load the page in place and bring the first cards into view
        document.addEventListener('click', function (event) {
            const link = event.target.closest('#products-pagination a[href]');
            if (!link || event.ctrlKey || event.metaKey || event.shiftKey) {
                return;
            }
            event.preventDefault();
            loadListing(link.href, true);
        });
    </script>
    <script>
        $(function () {
            const prices = @json($allPrices); // every wine of the store, not only this page
            const min = Math.floor(Math.min(...prices));
            const max = Math.ceil(Math.max(...prices));

            // Start from the range already applied (min_price / max_price in the address)
            const clamp = value => Math.min(max, Math.max(min, value));
            const params = new URLSearchParams(window.location.search);
            const chosenMin = params.has('min_price') ? clamp(parseFloat(params.get('min_price')) || min) : min;
            const chosenMax = params.has('max_price') ? clamp(parseFloat(params.get('max_price')) || max) : max;

            $("#price-slider").slider({
                range: true,
                min: min,
                max: max,
                step: 1,
                values: [chosenMin, chosenMax],
                slide: function (event, ui) {
                    $("#price-min").text(Number(ui.values[0]).toLocaleString('en-IN'));
                    $("#price-max").text(Number(ui.values[1]).toLocaleString('en-IN'));
                },
                // On release, show the wines in this range from all pages (filtered on the server,
                // like the Type / Country / Vintage boxes); keeps search and the other filters
                stop: function (event, ui) {
                    const next = new URLSearchParams(window.location.search);
                    if (ui.values[0] > min) { next.set('min_price', ui.values[0]); } else { next.delete('min_price'); }
                    if (ui.values[1] < max) { next.set('max_price', ui.values[1]); } else { next.delete('max_price'); }
                    next.delete('page');
                    const query = next.toString();
                    loadListing(window.location.pathname + (query ? '?' + query : ''));
                }
            });

            // Initialize labels
            $("#price-min").text(Number(chosenMin).toLocaleString('en-IN'));
            $("#price-max").text(Number(chosenMax).toLocaleString('en-IN'));

            // Tick marks and price labels under the slider
            const slider = $("#price-slider");
            const steps = 5;
            for (let i = 0; i <= steps; i++) {
                const percent = (i / steps) * 100;
                const tick = $("<span class='ui-slider-tick-mark'></span>").css("left", percent + "%");
                const label = $("<span class='tick-label'></span>").text(Math.round(min + i * ((max - min) / steps))).css("left", percent + "%");
                slider.append(tick).append(label);
            }
        });




    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const filters = document.querySelectorAll(
                '.wine-type-filter, .wine-country-filter, ' +
                '.wine-vintage-year-filter, .wine-grape-variety-filter'
            );

            filters.forEach(filter => {
                filter.addEventListener('change', function () {

                    const params = new URLSearchParams(window.location.search);

                    // Clear old filter selections (both types[] and the types[0] form page links use)
                    [...params.keys()]
                        .filter(key => /^(types|countries|vintage_years|grape_varieties)\[\d*\]$/.test(key))
                        .forEach(key => params.delete(key));

                    // Add selected types
                    document.querySelectorAll('.wine-type-filter:checked')
                        .forEach(item => params.append('types[]', item.value));

                    // Add selected countries
                    document.querySelectorAll('.wine-country-filter:checked')
                        .forEach(item => params.append('countries[]', item.value));

                    // Add selected vintage years
                    document.querySelectorAll('.wine-vintage-year-filter:checked')
                        .forEach(item => params.append('vintage_years[]', item.value));

                    // Add selected grape varieties
                    document.querySelectorAll('.wine-grape-variety-filter:checked')
                        .forEach(item => params.append('grape_varieties[]', item.value));

                    // Preserve search text
                    const searchInput = document.querySelector('input[name="search"]');

                    if (searchInput && searchInput.value.trim() !== '') {
                        params.set('search', searchInput.value.trim());
                    }

                    // Start from page 1 after changing filters
                    params.delete('page');

                    loadListing(window.location.pathname + '?' + params.toString());
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleButton = document.getElementById('grape-variety-toggle');

            if (!toggleButton) return;

            toggleButton.addEventListener('click', function () {
                const hiddenOptions = document.querySelectorAll(
                    '.grape-variety-option.d-none'
                );

                if (hiddenOptions.length > 0) {
                    document.querySelectorAll('.grape-variety-option.d-none')
                        .forEach(option => option.classList.remove('d-none'));

                    this.textContent = 'Read Less';
                } else {
                    document.querySelectorAll('.grape-variety-option')
                        .forEach((option, index) => {
                            if (index >= 10) {
                                option.classList.add('d-none');
                            }
                        });

                    this.textContent = 'Read More';
                }
            });
        });
    </script>

@endpush
