@extends('layouts.bootdashboard')
@php
    use Illuminate\Support\Str;
@endphp

@section('admindashboardcontent')
    @push('styles')
        <style>
            html,
            body {

                overflow-x: hidden;
            }

            #mystyle {
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

            .hero-section {
                height: 100vh;
                background-image: url('{{ asset('images/Browsewines3.jpg') }}');
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
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
                /* Floating effect */
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
                background-color: #8b0000;
                /* Deep wine red */
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
                top: 20px;
                width: 101%;
                z-index: 10;
                padding: 20px 0;
            }

            .navbar-dark .nav-link {
                /* color: #a50908!important; */
                font-size: 15px !important;
            }

            .scrolled {
                background-color: rgba(0, 0, 0, 0.7) !important;
                border-radius: 0px;
            }

            .parallax-container {
                position: relative;
                height: 70vh;
                overflow: hidden;
            }

            .parallax-bg {
                background-image: url('{{ asset('images/BrowseWines3.jpg') }}');
                background-size: cover;
                background-position: center;
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 150%;
                /* Make it larger so we can scroll it */
                z-index: -1;
                transform: translateY(0);
                transition: transform 0.1s linear;
            }

            .hero-text {
                position: relative;
                z-index: 1;
                color: white;
                text-align: center;
                padding-top: 30vh;
                text-align: right;
                width: 100%;
                padding-right: 5%;

            }

            .filters-and-cards {
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
                background-color: red !important;
            }

            /* Slider handles */
            .ui-slider-horizontal .ui-slider-handle {
                width: 20px;
                height: 20px;
                border-radius: 50%;
                border: none;
                background-color: #dc3545 !important;
                top: -0.4em;
                cursor: pointer;
                box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
                transition: background-color 0.2s ease;
            }

            .ui-slider-horizontal .ui-slider-handle:hover {
                background-color: #0b5ed7 !important;
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
            input[type="checkbox"].form-check-input:checked+.filter-checkbox {
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
                -webkit-overflow-scrolling: touch;
                /* Smooth scroll on mobile */
            }

            .wine-type-scroll .form-check {
                display: inline-block;
                margin-right: 1rem;
                /* spacing between options */
                white-space: nowrap;
            }

            .scrollable-filter {
                max-height: 200px; /* adjust as you like */
                overflow-y: auto;
                padding-right: 6px; /* to prevent scrollbar overlap */
            }

            /* optional: make scrollbar nicer */
            .scrollable-filter::-webkit-scrollbar {
                width: 6px;
            }
            .scrollable-filter::-webkit-scrollbar-thumb {
                background: #ccc;
                border-radius: 3px;
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
                    <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                </ul>

            </div>
        </div>
    </nav>
    <!-- header section -->
    <section class="parallax-container">
        <div class="parallax-bg"></div>
        <div class="hero-text my-3">
            <h1 class="text-white" id="mystyle">Explore Our Finest Wines</h1>
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
                    <div class="col-12 col-md-3 d-none d-md-block bg-light rounded rounded-2 p-4 align-self-start">
                        <!-- Vintage Year Filter -->
                        <div class="filter-group">
                            <h4 class="fw-bold mb-4">Vintage Year</h4>
                            <div class="vintage-year-filter-container ">
                                @foreach ($vintageYears->take(6) as $year)
                                    @if ($year)
                                        <div class="form-check">
                                            <input class="form-check-input wine-vintage-year-filter" type="checkbox"
                                                value="{{ $year }}" id="vintage-year-{{ $year }}">
                                            <label class="form-check-label" for="vintage-year-{{ $year }}">
                                                {{ $year }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            @if ($vintageYears->count() > 6)
                                <div class="vintage-year-filter-more d-none">
                                    @foreach ($vintageYears->skip(6) as $year)
                                        @if ($year)
                                            <div class="form-check">
                                                <input class="form-check-input wine-vintage-year-filter" type="checkbox"
                                                    value="{{ $year }}" id="vintage-year-{{ $year }}">
                                                <label class="form-check-label" for="vintage-year-{{ $year }}">
                                                    {{ $year }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-sm btn-link p-0 mt-2 toggle-vintage-year-filter"
                                    data-more-text="Show More" data-less-text="Show Less">
                                    Show More
                                </button>
                            @endif
                        </div>

                        <!-- Winery Filter -->
                        {{--<div class="filter-group">
                            <h4 class="fw-bold mb-4">Country</h4>
                            <div class="winery-filter-container">
                                @foreach ($wineries->take(6) as $winery)
                                    @if ($winery)
                                        <div class="form-check">
                                            <input class="form-check-input wine-winery-filter" type="checkbox"
                                                value="{{ $winery }}" id="winery-{{ Str::slug($winery) }}">
                                            <label class="form-check-label" for="winery-{{ Str::slug($winery) }}">
                                                {{ ucfirst($winery) }} 🍷
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            @if ($wineries->count() > 6)
                                <div class="winery-filter-more d-none">
                                    @foreach ($wineries->skip(6) as $winery)
                                        @if ($winery)
                                            <div class="form-check">
                                                <input class="form-check-input wine-winery-filter" type="checkbox"
                                                    value="{{ $winery }}" id="winery-{{ Str::slug($winery) }}">
                                                <label class="form-check-label" for="winery-{{ Str::slug($winery) }}">
                                                    {{ ucfirst($winery) }} 🍷
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <button type="button" class="btn btn-sm btn-link p-0 mt-2 toggle-winery-filter"
                                    data-more-text="Show More" data-less-text="Show Less">
                                    Show More
                                </button>
                            @endif
                        </div>--}}
                        <div class="filter-group">
                            <h4 class="fw-bold mb-4">Country</h4>

                            @php
                                $countries = $allProducts->pluck('country')->filter()->unique()->sort();
                            @endphp

                            <div class="country-filter-container">
                                @foreach ($countries->take(6) as $country)
                                    @php
                                        $lowerCountry = strtolower($country);
                                        $emoji = match ($lowerCountry) {
                                            'france' => '🇫🇷',
                                            'italy' => '🇮🇹',
                                            'spain' => '🇪🇸',
                                            'australia' => '🇦🇺',
                                            'united states' => '🇺🇸',
                                            'germany' => '🇩🇪',
                                            'new zealand' => '🇳🇿',
                                            'bulgaria' => '🇧🇬',
                                            default => '🌍',
                                        };
                                    @endphp

                                    <div class="form-check">
                                        <input class="form-check-input wine-country-filter" type="checkbox"
                                            value="{{ $lowerCountry }}" id="country-{{ Str::slug($country) }}">
                                        <label class="form-check-label" for="country-{{ Str::slug($country) }}">
                                            <span class="emoji">{{ $emoji }}</span> {{ ucfirst($country) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            @if ($countries->count() > 6)
                                <div class="country-filter-more d-none">
                                    @foreach ($countries->skip(6) as $country)
                                        @php
                                            $lowerCountry = strtolower($country);
                                            $emoji = match ($lowerCountry) {
                                                'france' => '🇫🇷',
                                                'italy' => '🇮🇹',
                                                'spain' => '🇪🇸',
                                                'australia' => '🇦🇺',
                                                'united states' => '🇺🇸',
                                                'germany' => '🇩🇪',
                                                'new zealand' => '🇳🇿',
                                                'bulgaria' => '🇧🇬',
                                                default => '🌍',
                                            };
                                        @endphp

                                        <div class="form-check">
                                            <input class="form-check-input wine-country-filter" type="checkbox"
                                                value="{{ $lowerCountry }}" id="country-{{ Str::slug($country) }}">
                                            <label class="form-check-label" for="country-{{ Str::slug($country) }}">
                                                <span class="emoji">{{ $emoji }}</span> {{ ucfirst($country) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="button" class="btn btn-sm btn-link p-0 mt-2 toggle-country-filter"
                                    data-more-text="Show More" data-less-text="Show Less">
                                    Show More
                                </button>
                            @endif
                        </div>


                        <!-- Retail Price Slider -->
                        <div class="filter-group">
                            <h4 class="fw-bold mb-4">Retail Price</h4>
                            <p>
                                <span id="price-range-label">₹&nbsp;<span id="price-min"></span> - ₹&nbsp;<span
                                        id="max-price"></span></span>
                            </p>
                            <div id="price-slider" style="margin-top: 10px;"></div>
                        </div>
                    </div>
                    <!-- Products grid -->
                    <div class="col-12 col-md-9  rounded rounded-2 p-3">
                        <!-- Type and Country filters at top -->
                        <div class="row mb-4">
                            <div class="col-12 mb-3">
                                <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
                                    <div class="d-flex flex-wrap gap-2">
                                        <button class="btn btn-outline-dark filter-btn active" data-filter="all">All
                                            Wines</button>
                                        <button class="btn btn-outline-dark filter-btn" data-filter="featured">
                                            <i class="fas fa-star"></i> Featured Wines
                                        </button>
                                    </div>
                                    <div class="ms-auto">
                                        <div class="input-group">
                                            <input type="text" id="search-input" class="form-control" placeholder="Search wines..." style="border: black 1px solid;border-radius: 4px 0px 0px 4px;">
                                            <button class="btn btn-outline-secondary" type="button" id="search-button">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 mb-3 filter-group wine-type-scroll">
                                <h4 class="fw-bold mb-3">Types</h4>
                                @php
                                    $types = $allProducts->pluck('type')->unique()->sort();
                                @endphp

                                <!-- Types Filter -->
                                @foreach ($types as $type)
                                    @if ($type)
                                        <!-- Only show if type is not null/empty -->
                                        @php
                                            $lowerType = strtolower($type);
                                            $emoji = match ($lowerType) {
                                                'red' => '🍷',
                                                'white' => '🥂',
                                                'sparkling' => '✨',
                                                'ros' => '🌸',
                                                'dessert' => '🍯',
                                                'bordeaux' => '🏰',
                                                default => '🍾',
                                            };
                                        @endphp

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input wine-type-filter" type="checkbox"
                                                value="{{ $lowerType }}" id="type-inline-{{ $lowerType }}"
                                                style="display: none;">

                                            <label class="form-check-label fs-15 filter-checkbox"
                                                for="type-inline-{{ $lowerType }}">
                                                <span class="emoji">{{ $emoji }}</span> {{ ucfirst($type) }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                            <div class="col-12 col-lg-6 mb-3 filter-group wine-type-scroll">
                                <h4 class="fw-bold mb-3">Country</h4>
                                @php
                                    $countries = $allProducts->pluck('country')->unique()->sort();
                                @endphp

                                @foreach ($countries as $country)
                                    @php
                                        $lowerCountry = strtolower($country);
                                        $emoji = match ($lowerCountry) {
                                            'france' => '🇫🇷',
                                            'italy' => '🇮🇹',
                                            'spain' => '🇪🇸',
                                            'australia' => '🇦🇺',
                                            'united states' => '🇺🇸',
                                            'germany' => '🇩🇪',
                                            'new zealand' => '🇳🇿',
                                            'bulgaria' => '🇧🇬',
                                            default => '🌍',
                                        };

                                    @endphp

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input wine-country-filter" type="checkbox"
                                            value="{{ $lowerCountry }}" id="country-inline-{{ $lowerCountry }}"
                                            style="display: none;">

                                        <label class="form-check-label fs-15 filter-checkbox"
                                            for="country-inline-{{ $lowerCountry }}">
                                            <span class="emoji">{{ $emoji }}</span> {{ ucfirst($country) }}
                                        </label>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="row row-sm" id="products-container">
                            @if (isset($products) && $products->count() > 0)
                                @include('partials.product_cards', ['products' => $products])
                            @else
                                <div class="col-12 text-center py-5">
                                    <p class="text-muted">No products found.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- End::row-6 -->


                @if (isset($products) && $products->hasPages())
                    <div class="pagination-container">
                        @if (!request()->ajax())
                            {{ $products->links() }}
                        @endif
                    </div>
                @endif





            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script>
        // Add loading overlay HTML
        const loadingOverlay = `
            <style>
                @keyframes spin {
                    0% { transform: translate(-50%, -50%) rotate(0deg); }
                    100% { transform: translate(-50%, -50%) rotate(360deg); }
                }
                #loading-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(255, 255, 255, 0.8);
                    z-index: 9999;
                    display: none;
                    justify-content: center;
                    align-items: center;
                    margin: 0;
                    padding: 0;
                }
                .spinner-border {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    width: 3rem;
                    height: 3rem;
                    border: 0.25em solid currentColor;
                    border-right-color: transparent;
                    border-radius: 50%;
                    animation: 0.75s linear infinite spin;
                    color: #8b0000; /* Wine red color to match your theme */
                }
            </style>
            <div id="loading-overlay">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        $('body').append(loadingOverlay);

        $(document).ready(function() {
            // Initialize price slider if it exists
            if ($("#price-slider").length) {
                const prices = @json($allProducts->pluck('retail_price')->filter()->sort()->values());
                const min = Math.floor(Math.min(...prices)) || 0;
                const max = Math.ceil(Math.max(...prices)) || 1000;

                $("#price-slider").slider({
                    range: true,
                    min: min,
                    max: max,
                    step: 1,
                    values: [min, max],
                    slide: function(event, ui) {
                        $("#price-min").text(ui.values[0]);
                        $("#max-price").text(ui.values[1]);
                        // Only load products when user stops sliding for 300ms
                        clearTimeout(window.sliderTimeout);
                        window.sliderTimeout = setTimeout(loadProducts, 300);
                    }
                });

                // Initialize labels
                $("#price-min").text(min);
                $("#max-price").text(max);
            }

            // Debounce function to prevent rapid AJAX calls
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            // Handle all filter changes with debouncing
            $('input[type="checkbox"], select').on('change', debounce(loadProducts, 300));

            // Function to update pagination
            function updatePagination(paginationData) {
                if (!paginationData || !paginationData.links) {
                    $('.pagination-container').html('');
                    return;
                }

                // Create new pagination with the same structure as PHP
                let paginationHtml = `
                    <div class="d-flex justify-content-center my-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0">
                `;

                // Add previous button
                if (paginationData.prev_page_url) {
                    paginationHtml += `
                        <li class="page-item">
                            <a class="page-link" href="#" data-page="${paginationData.current_page - 1}" rel="prev">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>
                    `;
                } else {
                    paginationHtml += `
                        <li class="page-item disabled">
                            <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                        </li>
                    `;
                }

                // Add page numbers
                if (paginationData.last_page > 1) {
                    const maxPagesToShow = 5; // Maximum number of page numbers to show
                    let startPage, endPage;

                    if (paginationData.last_page <= maxPagesToShow) {
                        // Less than max pages so show all
                        startPage = 1;
                        endPage = paginationData.last_page;
                    } else {
                        // More than max pages so calculate start and end pages
                        const maxPagesBeforeCurrent = Math.floor(maxPagesToShow / 2);
                        const maxPagesAfterCurrent = Math.ceil(maxPagesToShow / 2) - 1;

                        if (paginationData.current_page <= maxPagesBeforeCurrent) {
                            // Near the start
                            startPage = 1;
                            endPage = maxPagesToShow;
                        } else if (paginationData.current_page + maxPagesAfterCurrent >= paginationData.last_page) {
                            // Near the end
                            startPage = paginationData.last_page - maxPagesToShow + 1;
                            endPage = paginationData.last_page;
                        } else {
                            // Somewhere in the middle
                            startPage = paginationData.current_page - maxPagesBeforeCurrent;
                            endPage = paginationData.current_page + maxPagesAfterCurrent;
                        }
                    }

                    // Add first page and ellipsis if needed
                    if (startPage > 1) {
                        paginationHtml += `
                            <li class="page-item">
                                <a class="page-link" href="#" data-page="1">1</a>
                            </li>
                        `;
                        if (startPage > 2) {
                            paginationHtml += `
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            `;
                        }
                    }

                    // Add page numbers
                    for (let i = startPage; i <= endPage; i++) {
                        if (i === paginationData.current_page) {
                            paginationHtml += `
                                <li class="page-item active">
                                    <span class="page-link">${i}</span>
                                </li>
                            `;
                        } else {
                            paginationHtml += `
                                <li class="page-item">
                                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                                </li>
                            `;
                        }
                    }

                    // Add last page and ellipsis if needed
                    if (endPage < paginationData.last_page) {
                        if (endPage < paginationData.last_page - 1) {
                            paginationHtml += `
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            `;
                        }
                        paginationHtml += `
                            <li class="page-item">
                                <a class="page-link" href="#" data-page="${paginationData.last_page}">${paginationData.last_page}</a>
                            </li>
                        `;
                    }
                }

                // Add next button
                if (paginationData.next_page_url) {
                    paginationHtml += `
                        <li class="page-item">
                            <a class="page-link" href="#" data-page="${paginationData.current_page + 1}" rel="next">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                    `;
                } else {
                    paginationHtml += `
                        <li class="page-item disabled">
                            <span class="page-link"><i class="bi bi-chevron-right"></i></span>
                        </li>
                    `;
                }

                paginationHtml += `
                            </ul>
                        </nav>
                    </div>
                `;

                // Update the pagination container
                $('.pagination-container').html(paginationHtml);

                // Add click handlers for pagination links
                $('.pagination').on('click', 'a[data-page]', function(e) {
                    e.preventDefault();
                    const page = $(this).data('page');
                    loadProducts(page);
                    // Scroll to top of products container
                    $('html, body').animate({
                        scrollTop: $('#products-container').offset().top - 100
                    }, 500);
                });
            }

            // Function to show loading state
            function showLoading() {
                $('#loading-overlay').fadeIn(200);
            }

            // Function to hide loading state
            function hideLoading() {
                $('#loading-overlay').fadeOut(200);
            }

            // Function to load products via AJAX
            function loadProducts(page = 1) {
                // Show loading state
                showLoading();

                // Create a plain object to store form data
                const formData = {};

                // Check if featured filter is active
                if ($('.filter-btn[data-filter="featured"]').hasClass('active')) {
                    formData['featured'] = 'true';
                }

                // Get all checked vintage year checkboxes
                const vintageYears = [];
                $('.wine-vintage-year-filter:checked').each(function() {
                    vintageYears.push($(this).val());
                });
                if (vintageYears.length > 0) {
                    formData['vintage_year'] = vintageYears;
                }

                // Get all checked winery checkboxes
                const wineries = [];
                $('.wine-winery-filter:checked').each(function() {
                    wineries.push($(this).val());
                });
                if (wineries.length > 0) {
                    formData['winery'] = wineries;
                }

                // Get all checked type checkboxes
                const types = [];
                $('.wine-type-filter:checked').each(function() {
                    types.push($(this).val());
                });
                if (types.length > 0) {
                    formData['type'] = types;
                }

                // Get all checked country checkboxes
                const countries = [];
                $('.wine-country-filter:checked').each(function() {
                    countries.push($(this).val());
                });
                if (countries.length > 0) {
                    formData['country'] = countries;
                }

                // Get price range from slider if it exists
                if ($("#price-slider").length) {
                    const priceRange = $("#price-slider").slider("values");
                    formData['min_price'] = priceRange[0];
                    formData['max_price'] = priceRange[1];
                }

                // Add search term if exists
                const searchTerm = $('#search-input').val().trim();
                if (searchTerm) {
                    formData['search'] = searchTerm;
                }

                // Add page number
                formData['page'] = page;

                // Make AJAX request
                $.ajax({
                    url: '{{ route('homeBrowseWines') }}',
                    type: 'GET',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response && response.success) {
                            // Update products
                            if (response.html) {
                                $('#products-container').html(response.html);
                            }

                            // Update pagination
                            if (response.pagination) {
                                updatePagination(response.pagination);
                            } else if (response.links) {
                                // Fallback to simple pagination update if full pagination data isn't available
                                $('.pagination-container').html(
                                    `<div class="d-flex justify-content-center my-4">${response.links}</div>`
                                );
                            }

                            // Update URL without page reload
                            if (history.pushState) {
                                const newUrl = window.location.protocol + '//' +
                                    window.location.host +
                                    window.location.pathname +
                                    '?' + $.param(formData);
                                window.history.pushState({
                                    path: newUrl
                                }, '', newUrl);
                            }

                            // Update product count if it exists in the response
                            if (response.count !== undefined) {
                                $('#product-count').text(response.count);
                            }
                        } else {
                            console.error('Invalid response format:', response);
                            alert('Invalid response from server. Please try again.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', {
                            status: status,
                            error: error,
                            response: xhr.responseText
                        });

                        let errorMessage =
                            'An error occurred while loading products. Please try again.';
                        try {
                            const response = JSON.parse(xhr.responseText);
                            errorMessage = response.message || errorMessage;
                        } catch (e) {
                            console.error('Error parsing error response:', e);
                        }
                        alert(errorMessage);
                    },
                    complete: function() {
                        hideLoading();
                    }
                });
            }

            // Handle search input and button
            let searchTimeout;
            
            // Function to handle search
            function performSearch() {
                const searchTerm = $('#search-input').val().trim();
                loadProducts(1); // Reset to first page when searching
            }

            // Search button click handler
            $('#search-button').on('click', function() {
                performSearch();
            });

            // Search on Enter key press
            $('#search-input').on('keyup', function(e) {
                if (e.key === 'Enter') {
                    performSearch();
                } else {
                    // Debounce the search to avoid too many requests
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(performSearch, 500);
                }
            });

            // Handle filter button clicks
            $('.filter-btn').on('click', function() {
                $('.filter-btn').removeClass('active');
                $(this).addClass('active');
                loadProducts(1); // Reset to first page when changing filters
            });

            // Initial load with any URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.toString()) {
                // Check if we have any filter parameters
                const hasFilters = Array.from(urlParams.keys()).some(key =>
                    key === 'type[]' ||
                    key === 'vintage_year[]' ||
                    key === 'winery[]' ||
                    key === 'country[]' ||
                    key === 'min_price' ||
                    key === 'max_price'
                );

                // Set search input from URL if exists
                if (urlParams.has('search')) {
                    $('#search-input').val(urlParams.get('search'));
                }

                if (hasFilters) {
                    // Set checkboxes based on URL parameters
                    urlParams.forEach((value, key) => {
                        if (key.endsWith('[]')) {
                            // Handle array parameters (checkboxes)
                            const checkboxes = document.querySelectorAll(
                                `input[name="${key}"][value="${value}"]`);
                            checkboxes.forEach(checkbox => {
                                checkbox.checked = true;
                            });
                        } else if (key === 'min_price' || key === 'max_price') {
                            // Handle price range
                            if ($("#price-slider").length) {
                                const currentValues = $("#price-slider").slider("values");
                                if (key === 'min_price') {
                                    currentValues[0] = parseInt(value) || 0;
                                    $("#price-min").text(currentValues[0]);
                                } else {
                                    currentValues[1] = parseInt(value) || 1000;
                                    $("#max-price").text(currentValues[1]);
                                }
                                $("#price-slider").slider("values", currentValues);
                            }
                        }
                    });

                    // Load products with filters
                    loadProducts();
                }
            }

            // Initialize pagination on page load if there are products
            @if (isset($products) && $products->total() > 0)
                updatePagination({!! $products->toJson() !!});
            @endif
        });


        // Toggle vintage year filter visibility
        $(document).on('click', '.toggle-vintage-year-filter', function() {
            const $button = $(this);
            const $moreContent = $button.siblings('.vintage-year-filter-more');
            const moreText = $button.data('more-text');
            const lessText = $button.data('less-text');

            $moreContent.toggleClass('d-none');
            $button.text($moreContent.hasClass('d-none') ? moreText : lessText);
        });

        // Toggle winery filter visibility
        $(document).on('click', '.toggle-winery-filter', function() {
            const $button = $(this);
            const $moreContent = $button.siblings('.winery-filter-more');
            const moreText = $button.data('more-text');
            const lessText = $button.data('less-text');

            $moreContent.toggleClass('d-none');
            $button.text($moreContent.hasClass('d-none') ? moreText : lessText);
        });
    </script>
@endpush
