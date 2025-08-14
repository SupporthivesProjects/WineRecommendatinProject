@extends('layouts.bootdashboard')
@section('admindashboardcontent')
    @push('styles')
        <style>
            .cheese-image {
                height: 400px;
                object-fit: cover;
                width: 100%;
                border-radius: 8px;
            }

            .cheese-details {
                background: #f8f9fa;
                padding: 2rem;
                border-radius: 8px;
                height: 100%;
            }

            .availability-badge {
                font-size: 0.9rem;
                padding: 0.35rem 0.8rem;
            }

            .back-link {
                display: inline-flex;
                align-items: center;
                margin-bottom: 1.5rem;
                color: #6c757d;
                text-decoration: none;
            }

            .back-link:hover {
                color: #0d6efd;
            }

            .store-list {
                list-style: none;
                padding: 0;
            }

            .store-item {
                padding: 0.75rem 0;
                border-bottom: 1px solid #dee2e6;
            }

            .store-item:last-child {
                border-bottom: none;
            }

            /* Slick Carousel Styles */
            .wine-carousel .slick-slide {
                padding: 0 10px;
            }
            .wine-carousel .slick-prev:before,
            .wine-carousel .slick-next:before {
                color: #000;
            }
            .wine-carousel .slick-prev {
                left: -25px;
            }
            .wine-carousel .slick-next {
                right: -15px;
            }
        </style>
        <!-- Slick Carousel CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    @endpush

    <div class="container py-5">
        <a href="{{ route('user.cheeses') }}" class="back-link">
            <i class="fe fe-arrow-left me-2"></i> Back to Cheeses
        </a>

        <div class="row g-4">
            <!-- Cheese Image -->
            <div class="col-lg-6">
                <img src="{{ $cheese->image ? asset('storage/' . $cheese->image) : asset('images/default-cheese.jpg') }}"
                    alt="{{ $cheese->name }}" class="cheese-image">
            </div>

            <!-- Cheese Details -->
            <div class="col-lg-6">
                <div class="cheese-details">
                    <h1 class="mb-3">{{ $cheese->name }}</h1>

                    <div class="d-flex align-items-center mb-3">
                        <h3 class="mb-0 me-3">₹&nbsp;{{ number_format($cheese->price, 2) }}</h3>
                        @php
                            $totalQuantity = $cheese->stores->sum('pivot.quantity');
                            $inStock = $totalQuantity > 0;
                        @endphp
                        <span class="badge {{ $inStock ? 'bg-success' : 'bg-danger' }} availability-badge">
                            {{ $inStock ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>

                    <p class="lead">{{ $cheese->description ?? 'A delicious artisanal cheese selection.' }}</p>

                    <div class="mb-4">
                        <h5>Pairing Suggestion</h5>
                        <p>{{ $cheese->pairing_notes ?? 'Perfect with a variety of wines and accompaniments.' }}</p>
                    </div>

                    @if ($inStock)
                        <div class="mb-4">
                            <h5>Available At</h5>
                            <ul class="store-list">
                                @foreach ($cheese->stores as $store)
                                    @if ($store->pivot->quantity > 0 && $store->pivot->is_active)
                                        <li class="store-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $store->store_name }}</strong>
                                                    <div class="text-muted small">{{ $store->address }}</div>
                                                </div>
                                                <span class="badge bg-primary">Qty: {{ $store->pivot->quantity }}</span>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- <div class="d-flex gap-2">
                        <button class="btn {{ in_array($cheese->id, $cart) ? 'btn-dark' : 'btn-light' }} add-to-cart"
                                data-product-id="{{ $cheese->id }}"
                                data-product-name="{{ $cheese->name }}"
                                data-product-price="{{ $cheese->price }}"
                                {{ !$inStock ? 'disabled' : '' }}>
                            <i class="fe fe-shopping-cart me-2"></i>
                            {{ in_array($cheese->id, $cart) ? 'Remove from Cart' : 'Add to Cart' }}
                        </button>
                        <button class="btn btn-outline-secondary">
                            <i class="fe fe-heart me-2"></i>Add to Wishlist
                        </button>
                    </div> -->
                </div>
            </div>
        </div>

        <!-- Related Cheeses -->
        @if (isset($pairedWines) && $pairedWines->count() > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="mb-4">Wines That Pair Well With {{ $cheese->name }}</h3>
                    <div class="row wine-carousel">
                        @foreach ($pairedWines as $wine)
                            <div class="col-md-3 mb-4">
                                <div class="card h-100">
                                        <img src="{{ asset('storage/' . $wine->image1) }}"
                                            class="card-img-top" alt="{{ $wine->wine_name }}"
                                            style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $wine->wine_name }}</h5>
                                        <p class="card-text text-muted small">
                                            {{ $wine->winery }}<br>
                                            {{ $wine->vintage_year }} • {{ $wine->wine_sub_region }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="h6 mb-0">${{ number_format($wine->retail_price, 2) }}</span>
                                            <a href="{{ route('products.show', $wine->id) }}"
                                                class="btn btn-sm btn-outline-dark">
                                                View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <!-- Slick Carousel JS -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize Slick Carousel if there are more than 4 wines
            if ($('.wine-carousel').length > 0) {
                $('.wine-carousel').slick({
                    dots: true,
                    infinite: true,
                    speed: 300,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 1,
                                infinite: true,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 576,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            }

            // Add to cart functionality
            const addToCartButtons = document.querySelectorAll('.add-to-cart');

            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const productName = this.getAttribute('data-product-name');
                    const productPrice = this.getAttribute('data-product-price');
                    const isInCart = this.classList.contains('btn-dark');
                    const url = isInCart ? '{{ route('user.cart.remove') }}' :
                        '{{ route('user.cart.add') }}';

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                product_name: productName,
                                product_price: productPrice,
                                product_type: 'cheese' // Add product type to distinguish between wine and cheese
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                if (isInCart) {
                                    this.classList.remove('btn-dark');
                                    this.classList.add('btn-light');
                                    this.innerHTML =
                                        '<i class="fe fe-shopping-cart me-2"></i>Add to Cart';

                                    toastr.warning('Cheese removed from cart!', 'Removed', {
                                        closeButton: true,
                                        progressBar: true,
                                        positionClass: 'toast-top-right',
                                        timeOut: 3000
                                    });
                                } else {
                                    this.classList.remove('btn-light');
                                    this.classList.add('btn-dark');
                                    this.innerHTML =
                                        '<i class="fe fe-shopping-cart me-2"></i>Remove from Cart';

                                    toastr.success('Cheese added to cart!', 'Added', {
                                        closeButton: true,
                                        progressBar: true,
                                        positionClass: 'toast-top-right',
                                        timeOut: 3000
                                    });
                                }

                                // Update cart count if the element exists
                                const cartCount = document.getElementById('cart-count');
                                if (cartCount) {
                                    const currentCount = parseInt(cartCount.textContent) || 0;
                                    cartCount.textContent = isInCart ? currentCount - 1 :
                                        currentCount + 1;
                                }
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
        });
    </script>
@endpush
