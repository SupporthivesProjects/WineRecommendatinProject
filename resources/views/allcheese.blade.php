@extends('layouts.bootdashboard')
@section('admindashboardcontent')
@push('styles')
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

        .transparent-navbar {
            background: transparent;
            position: fixed;
            top: 20px;
            width: 101%;
            z-index: 10;
            padding: 20px 0;
        }
        
        .navbar-dark .nav-link {
            font-size: 15px !important;
        }
        
        .scrolled {
            background-color: rgba(0, 0, 0, 0.7) !important;
            border-radius: 0;
        }

        .parallax-container {
            position: relative;
            height: 70vh;
            overflow: hidden;
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

    <!-- Header -->
    <header class="app-header p-0" style="background-color: white;border-bottom: 1px solid #ddd;height: 80px;">
        <div class="container d-flex align-items-center justify-content-between" style="height: 100%;">
            
            <!-- Left: Logo -->
            <div class="d-flex align-items-center" style="flex: 0 0 auto;">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logoredwhite.jpg') }}" alt="logo" style="height: 60px;width: 60px;">
            </a>
            </div>

            <!-- Center: Navigation -->
            <nav class="flex-grow-1 d-flex justify-content-center">
            <ul class="nav mb-0">
                <li class="nav-item"><a href="{{ route('home') }}" class="nav-link  fw-semibold px-3">Home</a></li>
                <li class="nav-item"><a href="{{ route('home') }}#HIW" class="nav-link  fw-semibold px-3">How It Works</a></li>
                <li class="nav-item"><a href="{{ route('home') }}#featuredwines" class="nav-link  fw-semibold px-3">Browse Wines</a></li>
                <li class="nav-item"><a href="{{ route('home') }}#pairing" class="nav-link  fw-semibold px-3">Pairing Wines</a></li>
                <li class="nav-item"><a href="{{ route('home') }}#testimonials" class="nav-link  fw-semibold px-3">What Our Users Say</a></li>
                <li class="nav-item"><a href="{{ route('home') }}#Moments" class="nav-link  fw-semibold px-3">Moments in Between</a></li>
            </ul>
            </nav>

            <!-- Right: Login Button -->
            <div class="d-flex align-items-center" style="flex: 0 0 auto;">
            <a href="{{ route('login') }}" class="btn btn-info text-white fw-semibold px-4 py-2" 
                style="border-radius: 6px;">Login</a>
            </div>

        </div>
    </header>


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
        <div class="row">
            <!-- Cheese Products Grid -->
            <div class="col-12">
                <div class="row">
                    @forelse($cheeses as $cheese)
                        @php
                            $inStock = $cheese->stores->sum('pivot.quantity') > 0;
                        @endphp
                        @php
                            $storeInfo = $cheese->stores->first();
                            $quantity = $storeInfo ? $storeInfo->pivot->quantity : 0;
                            $isInStock = $quantity > 0 && $storeInfo && $storeInfo->pivot->is_available;
                        @endphp
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                            <div class="card cheese-card h-100">
                                <div class="position-relative">
                                    <img src="{{ $cheese->image ? asset('storage/' . $cheese->image) : asset('images/default-cheese.jpg') }}" 
                                         class="card-img-top" 
                                         alt="{{ $cheese->name }}"
                                         style="height: 300px; object-fit: cover;">
                                    <!-- @if(!$isInStock)
                                        <div class="position-absolute top-0 start-0 w-100 bg-danger text-white text-center py-1">
                                            Out of Stock
                                        </div>
                                    @endif -->
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-semibold">{{ $cheese->name }}</h5>
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
                                        <!-- <div class="d-grid">
                                            <a href="{{ route('user.cheese.show', $cheese->id) }}" class="btn btn-dark btn-sm w-100">
                                                View Details
                                            </a>
                                        </div> -->
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
                    <div class="d-flex justify-content-center my-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0">
                                {{-- Previous Page Link --}}
                                @if ($cheeses->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link"><i class="bi bi-caret-left"></i></span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $cheeses->previousPageUrl() }}" rel="prev">
                                            <i class="bi bi-caret-left"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($cheeses->getUrlRange(1, $cheeses->lastPage()) as $page => $url)
                                    <li class="page-item {{ $cheeses->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($cheeses->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $cheeses->nextPageUrl() }}" rel="next">
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
