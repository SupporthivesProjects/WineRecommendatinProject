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
    </style>
@endpush

<div class="container py-5">
    <a href="{{ route('user.cheeses') }}" class="back-link">
        <i class="fe fe-arrow-left me-2"></i> Back to Cheeses
    </a>
    
    <div class="row g-4">
        <!-- Cheese Image -->
        <div class="col-lg-6">
            <img src="{{ $cheese->image ? asset('storage/cheeses/' . $cheese->image) : asset('images/default-cheese.jpg') }}" 
                 alt="{{ $cheese->name }}" 
                 class="cheese-image">
        </div>
        
        <!-- Cheese Details -->
        <div class="col-lg-6">
            <div class="cheese-details">
                <h1 class="mb-3">{{ $cheese->name }}</h1>
                
                <div class="d-flex align-items-center mb-3">
                    <h3 class="mb-0 me-3">${{ number_format($cheese->price, 2) }}</h3>
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
                
                @if($inStock)
                    <div class="mb-4">
                        <h5>Available At</h5>
                        <ul class="store-list">
                            @foreach($cheese->stores as $store)
                                @if($store->pivot->quantity > 0 && $store->pivot->is_active)
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
    @if(isset($relatedCheeses) && $relatedCheeses->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">You Might Also Like</h3>
                <div class="row">
                    @foreach($relatedCheeses as $related)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <img src="{{ $related->image ? asset('storage/cheeses/' . $related->image) : asset('images/default-cheese.jpg') }}" 
                                     class="card-img-top" 
                                     alt="{{ $related->name }}"
                                     style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $related->name }}</h5>
                                    <p class="card-text text-muted">
                                        {{ $related->description ? \Illuminate\Support\Str::limit($related->description, 60) : '' }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 mb-0">${{ number_format($related->price, 2) }}</span>
                                        <a href="{{ route('user.cheese.show', $related->id) }}" class="btn btn-sm btn-outline-dark">
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add to cart functionality
        const addToCartButtons = document.querySelectorAll('.add-to-cart');
        
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function() {
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
                            this.innerHTML = '<i class="fe fe-shopping-cart me-2"></i>Add to Cart';

                            toastr.warning('Cheese removed from cart!', 'Removed', {
                                closeButton: true,
                                progressBar: true,
                                positionClass: 'toast-top-right',
                                timeOut: 3000
                            });
                        } else {
                            this.classList.remove('btn-light');
                            this.classList.add('btn-dark');
                            this.innerHTML = '<i class="fe fe-shopping-cart me-2"></i>Remove from Cart';

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
                            cartCount.textContent = isInCart ? currentCount - 1 : currentCount + 1;
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
