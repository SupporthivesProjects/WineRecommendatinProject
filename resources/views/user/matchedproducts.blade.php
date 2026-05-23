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
            height: 70vh;
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
        .input_range_wrapper {
            position: relative;
            width: 100%;
            height: 10px;
        }
        .input_range_wrapper input[type="range"] {
            position: absolute;
            width: 100%;
            height: 3px;
            background: transparent;
            pointer-events: none; /* allows overlap */
            -webkit-appearance: none;
        }
        .input_range_wrapper input[type="range"]::-webkit-slider-runnable-track {
            height: 3px;
            background: #E90C04;
        }

        .input_range_wrapper input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            pointer-events: auto;
            width: 20px;
            height: 20px;
            background: #E90C04;
            border-radius: 50%;
            margin-top: -7.5px;
        }

    </style>

    <style>

        .card.custom-card.wine-card .image-wrapper img.card-img-top {
            object-fit: contain;
            width: 308px;
            height: 287px;
            display: flex;
            margin-left: auto;
            margin-right: auto;
        }
        .image-wrapper {
            padding: 10px;
        }
    </style>
@endpush

    <!-- Transparent Navbar -->
    <nav id="mainNavbar" class="navbar navbar-expand-lg navbar-dark fixed-top transparent-navbar scrolled">
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
                    <li class="nav-item"><a href="{{ route('user.cheeses') }}" class="nav-link">Browse Cheeses</a></li>
                    <li class="nav-item"><a href="{{ route('user.featuredproducts') }}" class="nav-link">Featured Products</a></li>
                    <li class="nav-item"><a href="{{ route('user.cart') }}" class="nav-link">View CartView Cart (<span id="cart-count">{{ count($cart ?? []) }}</span>)</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- <section class="hero-section">
        <div class="hero-text">
        <h1 class="text-white" id="mystyle">Explore Our Finest Wines</h1>
        <p class="text-white">Curated selections for every occasion</p>
        </div>
    </section> -->

    
<div class="pt-5" id="matchedproducts">
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
                    <!-- <div class="filter-group">
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
                    </div> -->

                    <!-- Retail Price Filter -->
                    @php
                        $minPrice = $products->min('retail_price');
                        $maxPrice = $products->max('retail_price');
                    @endphp

                    <div class="price-slider mt-2">
                        <div class="input_range_wrapper">
                            <input type="range" id="price-min" min="{{ $minPrice }}" max="{{ $maxPrice }}" value="{{ $minPrice }}">
                            <input type="range" id="price-max" min="{{ $minPrice }}" max="{{ $maxPrice }}" value="{{ $maxPrice }}">
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span>₹<span id="min-val">{{ number_format($minPrice) }}</span></span>
                            <span>₹<span id="max-val">{{ number_format($maxPrice) }}</span></span>
                        </div>
                    </div>

                    <!-- <div class="filter-group">
                        <h4 class="fw-bold mb-4">Retail Price</h4>
                        @php
                            $prices = $products->pluck('retail_price')->unique()->sort();
                        @endphp
                        @foreach ($prices as $price)
                            <div class="form-check">
                                <input class="form-check-input wine-retail-price-filter" type="checkbox" value="{{ $price }}" id="retail-price-{{ $price }}">
                                <label class="form-check-label" for="retail-price-{{ $price }}">
                                ₹{{ number_format($price, 2) }}
                                </label>
                            </div>
                        @endforeach
                    </div> -->


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
                                        <img src="{{ asset('storage/' . $product->image1) }}" class="card-img-top rounded-0" alt="{{ $product->wine_name }}">
                                        

                                        <!-- Featured badge on the image -->
                                        @if ($product->admin_featured_product == 1)
                                            <span class="featured-badge">
                                                <i class="fas fa-crown"></i>
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
                                                'Rosé' => '✨',
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
                                        <a href="{{ route('user.productdetails', $product->id) }}" class="btn btn-dark mt-2 rounded-0" target="_blank">
                                            View !!
                                        </a>
                                        <button class="btn mt-2 rounded-0 buy-now-btn {{ in_array($product->id, $cart) ? 'btn-dark' : 'btn-light' }}"
                                                data-product-id="{{ $product->id }}"
                                                data-product-name="{{ $product->wine_name }}"
                                                data-product-price="{{ $product->retail_price }}">
                                            {{ in_array($product->id, $cart) ? 'Remove from Cart' : 'Buy Now' }}
                                        </button>
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
    for (let i = 0; i < localStorage.length; i++) {
    const key = localStorage.key(i);
    const value = localStorage.getItem(key);
    console.log(`${key}: ${value}`);
}

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
//   window.addEventListener("scroll", function () {
//     const navbar = document.getElementById("mainNavbar");
//     if (window.scrollY > 50) 
//     {
//         navbar.classList.add("scrolled"); 
//     } else {
//         navbar.classList.remove("scrolled");
//     }
//   });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.buy-now-btn');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');
                const productPrice = this.getAttribute('data-product-price');
                const isInCart = this.classList.contains('btn-dark');
                const url = isInCart ? '{{ route("user.cart.remove") }}' : '{{ route("user.cart.add") }}';

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ 
                        product_id: productId, 
                        product_name: productName,
                        product_price: productPrice
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (isInCart) {
                            this.classList.remove('btn-dark');
                            this.classList.add('btn-light');
                            this.textContent = 'Buy Now';

                            toastr.warning('Product removed from cart!', 'Removed', {
                                closeButton: true,
                                progressBar: true,
                                positionClass: 'toast-top-right',
                                timeOut: 3000
                            });
                        } else {
                            this.classList.remove('btn-light');
                            this.classList.add('btn-dark');
                            this.textContent = 'Remove from Cart';

                            toastr.success('Product added to cart!', 'Added', {
                                closeButton: true,
                                progressBar: true,
                                positionClass: 'toast-top-right',
                                timeOut: 3000
                            });
                        }
                    }

                    // ✅ Update the cart count dynamically
                    const cartCountElement = document.getElementById('cart-count');
                    if (cartCountElement) {
                        let currentCount = parseInt(cartCountElement.textContent) || 0;

                        if (isInCart) {
                            // Product removed
                            currentCount = Math.max(0, currentCount - 1);
                        } else {
                            // Product added
                            currentCount += 1;
                        }

                        cartCountElement.textContent = currentCount;
                    }





                })
                .catch(() => {
                    toastr.error('Something went wrong!', 'Error', {
                        closeButton: true,
                        progressBar: true,
                        positionClass: 'toast-top-right',
                        timeOut: 3000
                    });
                });
            });
        });

        // Updated View Cart button - now redirects to cart page
        document.getElementById('view-cart-btn').addEventListener('click', function () {
            window.location.href = '{{ route("user.cart") }}';
        });
    });
</script>



<script>
    const productsInfo = @json($products->keyBy('id')->map(function($p) {
        return ['name' => $p->wine_name, 'price' => $p->retail_price];
    }));
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {

const minSlider = document.getElementById("price-min");
const maxSlider = document.getElementById("price-max");

const minVal = document.getElementById("min-val");
const maxVal = document.getElementById("max-val");

// Call main filter function whenever slider moves
minSlider.addEventListener("input", applyFilters);
maxSlider.addEventListener("input", applyFilters);

// Also re-run when checkboxes are clicked (to stack filters)
document.querySelectorAll(".form-check-input").forEach(cb => {
    cb.addEventListener("change", applyFilters);
});

function applyFilters() {

    let minPrice = parseFloat(minSlider.value);
    let maxPrice = parseFloat(maxSlider.value);

    // Display values
    minVal.textContent = minPrice.toLocaleString();
    maxVal.textContent = maxPrice.toLocaleString();

    // Loop all product cards
    document.querySelectorAll(".wine-card-container").forEach(card => {

        let price = parseFloat(card.dataset.retailPrice);
        let type = card.dataset.type;
        let country = card.dataset.country;
        let vintage = card.dataset.vintageYear;

        // --- TYPE FILTER ---
        let selectedTypes = [...document.querySelectorAll('.wine-type-filter:checked')]
            .map(el => el.value);
        let typeMatch = selectedTypes.length ? selectedTypes.includes(type) : true;

        // --- COUNTRY FILTER ---
        let selectedCountries = [...document.querySelectorAll('.wine-country-filter:checked')]
            .map(el => el.value);
        let countryMatch = selectedCountries.length ? selectedCountries.includes(country) : true;

        // --- VINTAGE YEAR FILTER ---
        let selectedYears = [...document.querySelectorAll('.wine-vintage-year-filter:checked')]
            .map(el => el.value);
        let vintageMatch = selectedYears.length ? selectedYears.includes(vintage) : true;

        // --- PRICE FILTER ---
        let priceMatch = price >= minPrice && price <= maxPrice;

        // FINAL CHECK
        if (priceMatch && typeMatch && countryMatch && vintageMatch) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
}
});

</script>


@endpush
