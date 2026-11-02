{{-- Add to cart / Remove from cart toggle for a wine card (clicks: assets/js/cart-toggle.js) --}}
@php
    $inCart = collect($cart ?? [])->pluck('id')->contains($product->id);
@endphp
<button type="button"
    class="btn mt-2 rounded-0 buy-now-btn {{ $inCart ? 'btn-dark' : 'btn-light' }}"
    data-product-id="{{ $product->id }}"
    data-product-name="{{ $product->wine_name }}"
    data-product-price="{{ $product->display_price ?? $product->getDisplayPrice() }}">
    <i class="fas fa-shopping-cart me-1" aria-hidden="true"></i>{{ $inCart ? 'Remove from cart' : 'Add to cart' }}
</button>
