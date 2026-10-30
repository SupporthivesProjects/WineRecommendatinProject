@extends('layouts.user')
@section('title', 'Browse Cheeses')
@section('admindashboardcontent')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/product-listing.css') }}?v={{ filemtime(public_path('assets/css/product-listing.css')) }}">
    <style>
        html, body {
            overscroll-behavior: auto;       
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
            background-image: url('{{ asset('images/cheese-banner.jpg') }}');
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

        .cheese-card {
            border-radius: 0 !important; 
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            box-shadow: none;
            height: 100%;
        }

        .cheese-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transform: translateY(-4px);
        }

        .parallax-container {
            position: relative;
            height: 80vh;
            overflow: hidden;
        }
        .parallax-container::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.45); 
            z-index: 0;
        }

        .parallax-bg {
            background-image: url('{{ asset('images/cheese-banner.jpg') }}');
            background-size: cover;
            background-position: center;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 150%;
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

    </style>
@endpush


<!-- Hero Section -->
<section class="parallax-container">
    <div class="parallax-bg"></div>
    <div class="hero-text my-3">
        <h1  id="mystyle" style="color:#2f0100;">Discover Artisanal Cheeses</h1>
        <p style="color:#2f0100;">Perfect pairings for your favorite wines</p>
        <a type="button" class="btn btn-dark" href="#products">
            Explore Cheeses
        </a>
    </div>
</section>

<!-- Cheese Products Section -->
<section class="filters-and-cards" id="products">
    <div class="container my-5">
        <!-- search box -->
        <!-- Search Bar -->
        <div class="row mb-4 justify-content-center">
            <div class="col-md-6">
                <form method="GET" action="{{ route('user.cheeses') }}">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fe fe-search"></i>
                        </span>
                        <input
                            type="text"
                            class="form-control"
                            id="cheeseSearch"
                            name="search"
                            placeholder="Search cheeses..."
                            value="{{ request('search') }}"
                        >
                        <button class="btn btn-dark" type="submit">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>



        <div class="row">
            <!-- Cheese Products Grid -->
            <div class="col-12">
                <div class="row product-card-grid">
                    @forelse($cheeses as $cheese)
                        @php
                            $inStock = $cheese->stores->sum('pivot.quantity') > 0;
                        @endphp
                        @php
                            $storeInfo = $cheese->stores->first();
                            $quantity = $storeInfo ? $storeInfo->pivot->quantity : 0;
                            $isInStock = $quantity > 0 && $storeInfo && $storeInfo->pivot->is_available;
                        @endphp
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-4" data-name="{{ strtolower($cheese->name) }}"
                        data-description="{{ strtolower($cheese->description ?? '') }}">
                            <div class="card cheese-card h-100">
                                <div class="position-relative product-card-media">
                                    <img loading="lazy" src="{{ $cheese->image ? asset('storage/' . $cheese->image) : asset('images/default-cheese.jpg') }}" 
                                         class="card-img-top" 
                                         alt="{{ $cheese->name }}">
                                    @if(!$isInStock)
                                        <div class="position-absolute top-0 start-0 w-100 bg-danger text-white text-center py-1">
                                            Out of Stock
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h4 class="card-title fw-semibold">{{ $cheese->name }}</h4>
                                    <p class="card-text text-muted flex-grow-1">
                                        {{ $cheese->description ? \Illuminate\Support\Str::limit($cheese->description, 100) : 'Artisanal cheese selection' }}
                                    </p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <!-- <span class="h5 mb-0">₹&nbsp;{{ number_format($cheese->price, 2) }}</span> -->
                                            <!-- @if($isInStock)
                                                <span class="badge bg-success">In Stock ({{ $quantity }})</span>
                                            @else
                                                <span class="badge bg-secondary">Out of Stock</span>
                                            @endif -->
                                        </div>
                                        <div class="d-grid">
                                            <a href="{{ route('user.cheese.show', $cheese->id) }}" class="btn btn-dark w-100 py-2 d-flex align-items-center justify-content-center">
                                            View Details
                                            </a>
                                        </div>
                                    </div>
                                    <!-- @if($storeInfo)
                                        <div class="store-info bg-light p-2 rounded mt-3 small">
                                            <div class="d-flex align-items-center">
                                                <i class="fe fe-map-pin me-2"></i>
                                                <div>
                                                    <div class="fw-semibold">{{ $storeInfo->store_name }}</div>
                                                    <div class="text-muted">{{ $storeInfo->address }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif -->
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <h4>No cheeses available at the moment.</h4>
                            <p class="text-muted">Please check back later for our artisanal cheese selection.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if ($cheeses->hasPages())
                    @php
                        $lastPage = $cheeses->lastPage();
                        $currentPage = $cheeses->currentPage();

                        // Show current page with one page before and after
                        $start = max(1, $currentPage - 1);
                        $end = min($lastPage, $currentPage + 1);
                    @endphp

                    <div class="d-flex justify-content-center my-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0">

                                {{-- First Page --}}
                                <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $cheeses->url(1) }}">
                                        <i class="bi bi-chevron-double-left"></i>
                                    </a>
                                </li>

                                {{-- Previous Page --}}
                                <li class="page-item {{ $cheeses->onFirstPage() ? 'disabled' : '' }}">
                                    @if ($cheeses->onFirstPage())
                                        <span class="page-link">
                                            <i class="bi bi-caret-left"></i>
                                        </span>
                                    @else
                                        <a class="page-link" href="{{ $cheeses->previousPageUrl() }}" rel="prev">
                                            <i class="bi bi-caret-left"></i>
                                        </a>
                                    @endif
                                </li>

                                {{-- First Page + Ellipsis --}}
                                @if ($start > 1)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $cheeses->url(1) }}">1</a>
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
                                        <a class="page-link" href="{{ $cheeses->url($page) }}">
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
                                        <a class="page-link" href="{{ $cheeses->url($lastPage) }}">
                                            {{ $lastPage }}
                                        </a>
                                    </li>
                                @endif

                                {{-- Next Page --}}
                                <li class="page-item {{ !$cheeses->hasMorePages() ? 'disabled' : '' }}">
                                    @if ($cheeses->hasMorePages())
                                        <a class="page-link" href="{{ $cheeses->nextPageUrl() }}" rel="next">
                                            <i class="bi bi-caret-right"></i>
                                        </a>
                                    @else
                                        <span class="page-link">
                                            <i class="bi bi-caret-right"></i>
                                        </span>
                                    @endif
                                </li>

                                {{-- Last Page --}}
                                <li class="page-item {{ $currentPage == $lastPage ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $cheeses->url($lastPage) }}">
                                        <i class="bi bi-chevron-double-right"></i>
                                    </a>
                                </li>

                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Navbar scroll effect
    window.addEventListener("scroll", function () {
        const navbar = document.getElementById("mainNavbar");
        if (window.scrollY > 50) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }
    });

    // Parallax effect
    document.addEventListener("scroll", function () {
        const scrolled = window.scrollY;
        const parallax = document.querySelector(".parallax-bg");
        if (parallax) {
            parallax.style.transform = `translateY(${scrolled * 0.4}px)`;
        }
    });
</script>
@endpush

@endsection
