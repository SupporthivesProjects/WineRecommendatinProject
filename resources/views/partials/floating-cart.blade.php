{{-- Fixed cart button (styles: assets/css/floating-cart.css, clicks: assets/js/cart-toggle.js) --}}
@php
    $floatingCartCount = collect($cart ?? session('cart', []))->sum('quantity');
@endphp
<div class="sidebar-cart"
     id="floating-cart-config"
     data-add-url="{{ route('user.cart.add') }}"
     data-remove-url="{{ route('user.cart.remove') }}">
    <a href="{{ route('user.cart') }}"
       class="sidebar-cart-link {{ $floatingCartCount > 0 ? 'cart-has-items' : '' }}"
       id="sidebar-cart-icon"
       aria-label="View shopping cart">

        <i class="fas fa-shopping-cart"></i>

        <span class="sidebar-cart-count" id="sidebar-cart-count">
            {{ $floatingCartCount }}
        </span>
    </a>
</div>
