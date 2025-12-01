@extends('layouts.bootdashboard')
@php
    use Illuminate\Support\Str;
@endphp

@section('admindashboardcontent')
@push('styles')
<style>
    html, body { overflow-x: hidden; }

    /* Add padding to body so content doesn't hide under fixed header */
    body { padding-top: 80px; }

    #mystyle { font-family: 'Cinzel Decorative', serif; }

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

    .hero-text h1 { font-size: 3rem; margin-bottom: 1rem; }

    .wine-card {
        border-radius: 0 !important;
        transition: box-shadow 0.3s ease, transform 0.3s ease;
        box-shadow: none;
    }

    .wine-card:hover { box-shadow: 0 10px 30px rgba(0,0,0,0.15); transform: translateY(-4px); }

    .filter-group { margin-bottom: 2rem; }

    .form-check { margin-bottom: 0.75rem; }

    .form-check-input:checked { background-color: #8b0000; border-color: #8b0000; }

    .form-check-label { font-size: 0.95rem; color: #444; }

    .form-check-input:focus { box-shadow: 0 0 0 0.1rem rgba(139, 0, 0, 0.25); }

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

    input[type="checkbox"].form-check-input:checked + .filter-checkbox {
        background-color: rgba(165, 9, 8, 0.7);
        color: white;
        border-color: white;
    }

    .emoji { font-size: 1.4em; line-height: 1; }

    .wine-type-scroll { overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch; }

    .wine-type-scroll .form-check {
        display: inline-block;
        margin-right: 1rem;
        white-space: nowrap;
        overflow: visible !important;
        max-height: none !important;
    }

    .scrollable-filter { max-height: 200px; overflow-y: auto; padding-right: 6px; }

    .scrollable-filter::-webkit-scrollbar { width: 6px; }
    .scrollable-filter::-webkit-scrollbar-thumb { background: #ccc; border-radius: 3px; }

    .app-header .nav-link { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; transition: color 0.3s ease; color: black; font-size: 14px; font-weight: 500!important; }
    .app-header .nav-link:hover { color: #0b5ed7; }

    .app-header { 
        box-shadow: 0 2px 10px rgba(0,0,0,0.05); 
    }

    .filters-and-cards {
        background: #fff;
        padding: 100px 20px;
        min-height: 100vh;
    }

    .parallax-container { position: relative; height: 70vh; overflow: hidden; }
    .parallax-bg {
        background-image: url('{{ asset('images/BrowseWines3.jpg') }}');
        background-size: cover;
        background-position: center;
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 150%; z-index: -1;
        transform: translateY(0);
        transition: transform 0.1s linear;
    }


    .wine-card {
    position: relative;
    overflow: hidden;
}

    .hover-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.65);
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
        z-index: 10;
    }

    .wine-card:hover .hover-overlay {
        opacity: 1;
    }

    .overlay-btn {
        padding: 12px 20px;
        font-size: 1rem;
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
    <div class="hero-text my-3" style="
    text-align: right;
    max-width: 390px;
    color: white;
    position: absolute;
    right: 95px;
    top: 50%;
    transform: translateY(-50%);">
        <h1 class="text-white" id="mystyle">Explore Our Finest Wines</h1>
        <p>Curated selections for every occasion</p>
        <a type="button" class="btn btn-dark" href="#products">Explore</a>
    </div>
</section>

<!-- Filters & Cards Section -->
<section class="filters-and-cards" id="products">
    <div class="container my-5">
        <div class="row g-2">
            <!-- Products Grid -->
            <div class="col-12 col-md-9 rounded rounded-2 p-3">
                <div class="row mb-4">
                    <div class="col-12 mb-3">
                        <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
                            <div class="d-flex flex-wrap gap-2">
                                <button class="btn btn-outline-dark filter-btn active" data-filter="all">All Cheese</button>
                                <button class="btn btn-outline-dark filter-btn" data-filter="featured"><i class="fas fa-star"></i> Featured Wines</button>
                            </div>
                            <div class="ms-auto">
                                <div class="input-group">
                                    <input type="text" id="search-input" class="form-control" placeholder="Search wines..." style="border: black 1px solid;border-radius: 4px 0 0 4px;">
                                    <button class="btn btn-outline-secondary" type="button" id="search-button"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Container -->
                <div class="row row-sm" id="products-container">
                    @if (isset($allCheese) && $allCheese->count() > 0)
                        @include('partials.product_cards', ['products' => $allCheese])
                    @else
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">No products found.</p>
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                @if (isset($allCheese) && $allCheese->hasPages())
                    <div class="pagination-container">
                        @if (!request()->ajax())
                            {{ $allCheese->links() }}
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection


@push('scripts')
    <script></script>

    
@endpush
