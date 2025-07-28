@extends('layouts.bootdashboard')
@section('admindashboardcontent')
    @push('styles')
        <style>
            #mystyle {
                font-family: 'Cinzel Decorative', serif;
            }

            .hero-section {
                height: 50vh;
                background-image: url('{{ asset('https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') }}');
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

            .hero-text {
                text-align: center;
                width: 100%;
            }

            .hero-text h1 {
                font-size: 3rem;
                margin-bottom: 1rem;
            }

            .cart-item {
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                padding: 20px;
                margin-bottom: 20px;
                background: white;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .cart-item img {
                width: 120px;
                height: 150px;
                object-fit: cover;
                border-radius: 8px;
            }

            .quantity-controls {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .quantity-btn {
                width: 35px;
                height: 35px;
                border: 1px solid #8b0000;
                background: white;
                color: #8b0000;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .quantity-btn:hover {
                background: #8b0000;
                color: white;
            }

            .quantity-input {
                width: 60px;
                text-align: center;
                border: 1px solid #ddd;
                border-radius: 4px;
                padding: 8px;
            }

            .remove-btn {
                background: #dc3545;
                color: white;
                border: none;
                padding: 8px 15px;
                border-radius: 4px;
                cursor: pointer;
                transition: background 0.3s ease;
            }

            .remove-btn:hover {
                background: #c82333;
            }

            .cart-summary {
                background: #f8f9fa;
                padding: 25px;
                border-radius: 8px;
                border: 1px solid #e0e0e0;
            }

            .checkout-btn {
                background: #8b0000;
                color: white;
                border: none;
                padding: 15px 30px;
                border-radius: 4px;
                font-size: 16px;
                font-weight: bold;
                cursor: pointer;
                width: 100%;
                transition: background 0.3s ease;
            }

            .checkout-btn:hover {
                background: #6d0000;
            }

            .empty-cart {
                text-align: center;
                padding: 50px;
                color: #666;
            }

            .empty-cart i {
                font-size: 4rem;
                margin-bottom: 20px;
                color: #ccc;
            }

            .transparent-navbar {
                background: transparent;
                position: fixed;
                top: 20px;
                width: 100%;
                z-index: 10;
                padding: 20px 0;
            }

            .scrolled {
                background-color: rgba(0, 0, 0, 0.7) !important;
                border-radius: 0px;
            }
        </style>
    @endpush

    <!-- Transparent Navbar -->
    <nav id="mainNavbar" class="navbar navbar-expand-lg navbar-dark fixed-top transparent-navbar">
        <div class="container">
            <a class="navbar-brand text-white" href="#">
                <lottie-player src="{{ asset('Lottie/Animation - 1745878648192.json') }}" background="transparent"
                    speed="1" style="width: 40px; height: 40px;" loop autoplay>
                </lottie-player>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="{{ route('user.dashboard') }}" class="nav-link">Dashboard</a></li>
                    <li class="nav-item"><a href="{{ route('user.showQuestionnaire') }}" class="nav-link">Questionnaires</a>
                    </li>
                    <li class="nav-item"><a href="{{ route('user.products') }}" class="nav-link">Browse Wines</a></li>
                    <li class="nav-item"><a href="{{ route('user.cheeses') }}" class="nav-link">Browse Cheeses</a></li> 
                    <li class="nav-item"><a href="{{ route('user.featuredproducts') }}" class="nav-link">Featured
                            Products</a></li>
                    <!-- Removed the matched products link since the route doesn't exist -->
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="hero-text">
            <h1 class="text-white" id="mystyle">Your Wine Cart</h1>
            <p class="text-white">Review your selected wines</p>
        </div>
    </section>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                <div id="cart-items-container">
                    <!-- Cart items will be loaded here -->
                </div>
            </div>

            <div class="col-lg-4">
                <div class="cart-summary">
                    <h4 class="mb-4">Order Summary</h4>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Total Items:</span>
                        <span id="total-items">0</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal:</span>
                        <span id="subtotal">$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-4 fw-bold">
                        <span>Total:</span>
                        <span id="total-amount">$0.00</span>
                    </div>
                    <button class="checkout-btn" id="checkout-btn">
                        Let's Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadCartItems();

            // Navbar scroll effect
            window.addEventListener("scroll", function() {
                const navbar = document.getElementById("mainNavbar");
                if (window.scrollY > 50) {
                    navbar.classList.add("scrolled");
                } else {
                    navbar.classList.remove("scrolled");
                }
            });
        });

        function loadCartItems() {
            fetch('{{ route('user.cart.get') }}')
                .then(response => response.json())
                .then(data => {
                    displayCartItems(data.cart);
                    updateCartSummary(data.cart);
                })
                .catch(error => {
                    console.error('Error loading cart:', error);
                    showEmptyCart();
                });
        }

        function displayCartItems(cartItems) {
            const container = document.getElementById('cart-items-container');

            if (cartItems.length === 0) {
                showEmptyCart();
                return;
            }

            let html = '';
            cartItems.forEach(item => {
                html += `
                <div class="cart-item" data-product-id="${item.id}">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <img src="${item.image || '{{ asset('images/default.jpg') }}'}" 
                                 alt="${item.name}" class="img-fluid">
                        </div>
                        <div class="col-md-4">
                            <h5 class="mb-1">${item.name || 'Wine Product'}</h5>
                            <p class="text-muted mb-0">Price: $${parseFloat(item.retail_price || 0).toFixed(2)}</p>
                        </div>
                        <div class="col-md-3">
                            <div class="quantity-controls">
                                <button class="quantity-btn" onclick="updateQuantity(${item.id}, ${(item.quantity || 1) - 1})">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" class="quantity-input" value="${item.quantity || 1}" 
                                       min="1" max="10" onchange="updateQuantity(${item.id}, this.value)">
                                <button class="quantity-btn" onclick="updateQuantity(${item.id}, ${(item.quantity || 1) + 1})">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <p class="fw-bold mb-0">$${(parseFloat(item.retail_price || 0) * (item.quantity || 1)).toFixed(2)}</p>
                        </div>
                        <div class="col-md-1">
                            <button class="remove-btn" onclick="removeFromCart(${item.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            });

            container.innerHTML = html;
        }

        function showEmptyCart() {
            const container = document.getElementById('cart-items-container');
            container.innerHTML = `
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h3>Your cart is empty</h3>
                <p>Add some wines to get started!</p>
                <a href="{{ route('user.products') }}" class="btn btn-primary">Browse Wines</a>
            </div>
            <a href="{{ route('user.cheeses') }}" class="btn btn-primary">Browse Cheeses</a>
        `;
            updateCartSummary([]);
        }

        function updateQuantity(productId, newQuantity) {
            newQuantity = parseInt(newQuantity);

            if (newQuantity < 1) {
                removeFromCart(productId);
                return;
            }

            if (newQuantity > 10) {
                toastr.warning('Maximum quantity is 10');
                return;
            }

            fetch('{{ route('user.cart.updateQuantity') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: newQuantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadCartItems(); // Reload cart items
                        toastr.success('Quantity updated successfully');
                    } else {
                        toastr.error('Failed to update quantity');
                    }
                })
                .catch(error => {
                    console.error('Error updating quantity:', error);
                    toastr.error('Something went wrong');
                });
        }

        function removeFromCart(productId) {
            fetch('{{ route('user.cart.remove') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadCartItems(); // Reload cart items
                        toastr.success('Item removed from cart');
                    } else {
                        toastr.error('Failed to remove item');
                    }
                })
                .catch(error => {
                    console.error('Error removing item:', error);
                    toastr.error('Something went wrong');
                });
        }

        function updateCartSummary(cartItems) {
            let totalItems = 0;
            let subtotal = 0;

            cartItems.forEach(item => {
                const quantity = item.quantity || 1;
                const price = parseFloat(item.retail_price || 0);
                totalItems += quantity;
                subtotal += price * quantity;
            });

            document.getElementById('total-items').textContent = totalItems;
            document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
            document.getElementById('total-amount').textContent = '$' + subtotal.toFixed(2);
        }

        // Checkout functionality - same as original
        document.getElementById('checkout-btn').addEventListener('click', function() {
            fetch('{{ route('user.cart.get') }}')
                .then(response => response.json())
                .then(data => {
                    if (data.cart.length === 0) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Cart is Empty',
                            text: "You haven't added any products yet!"
                        });
                        return;
                    }

                    const submissionId = '{{ session('submission_id') }}';

                    fetch('{{ route('user.checkout') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                submission_id: submissionId
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Order Placed Successfully!',
                                    text: 'Thank you for your purchase.',
                                    confirmButtonText: 'Continue Shopping'
                                }).then(() => {
                                    window.location.href = '{{ route('user.products') }}';
                                });
                            } else {
                                toastr.error(data.message || 'Checkout failed.');
                            }
                        })
                        .catch((error) => {
                            console.error('Checkout error:', error);
                            toastr.error('Something went wrong during checkout.');
                        });
                });
        });
    </script>
@endpush
