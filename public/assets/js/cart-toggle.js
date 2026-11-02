/**
 * Add to cart / Remove from cart buttons on the wine listing pages
 * (Browse Wines, Featured Products, Cheese Details paired wines).
 *
 * Buttons: <button class="buy-now-btn btn-light|btn-dark" data-product-id data-product-name data-product-price>
 * btn-dark means the wine is already in the cart, so the click removes it.
 * The cart URLs come from the floating cart (partials/floating-cart.blade.php).
 *
 * Adding shows no success pop-up: the flying bottle, the cart ring and the
 * updated count confirm it. Removing shows a warning toast, failures an error toast.
 */
(function (window, document) {
    'use strict';

    if (window.WineCartToggle) {
        return;
    }

    var ADD_LABEL = '<i class="fas fa-shopping-cart me-1" aria-hidden="true"></i>Add to cart';
    var REMOVE_LABEL = '<i class="fas fa-shopping-cart me-1" aria-hidden="true"></i>Remove from cart';

    function toast(type, message, title) {
        if (window.toastr && window.toastr[type]) {
            window.toastr[type](message, title, {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 3000
            });
        }
    }

    function csrfToken() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    function updateCount(count) {
        ['sidebar-cart-count', 'cart-count'].forEach(function (id) {
            var element = document.getElementById(id);
            if (element) {
                element.textContent = count;
            }
        });

        var cartIcon = document.getElementById('sidebar-cart-icon');
        if (cartIcon) {
            cartIcon.classList.toggle('cart-has-items', Number(count) > 0);
        }
    }

    function setInCart(button, inCart) {
        button.classList.toggle('btn-dark', inCart);
        button.classList.toggle('btn-light', !inCart);
        button.innerHTML = inCart ? REMOVE_LABEL : ADD_LABEL;
    }

    function handleClick(button) {
        var config = document.getElementById('floating-cart-config');
        if (!config || button.dataset.cartBusy === '1') {
            return;
        }

        var isInCart = button.classList.contains('btn-dark');
        var url = isInCart ? config.dataset.removeUrl : config.dataset.addUrl;

        // One request at a time per button, so double clicks do not add twice
        button.dataset.cartBusy = '1';
        button.disabled = true;

        fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken()
            },
            body: JSON.stringify({
                product_id: button.dataset.productId,
                product_name: button.dataset.productName,
                product_price: button.dataset.productPrice
            })
        })
            .then(function (response) {
                return response.json().catch(function () {
                    return {};
                }).then(function (data) {
                    if (!response.ok || !data.success) {
                        throw new Error(data.message || 'Cart request failed');
                    }
                    return data;
                });
            })
            .then(function (data) {
                setInCart(button, !isInCart);
                updateCount(data.cart_count || 0);

                if (isInCart) {
                    toast('warning', 'Product removed from cart!', 'Removed');
                } else if (window.WineCartFx) {
                    // Bottle-into-cart animation (visual only, see assets/js/cart-animation.js)
                    window.WineCartFx.play(button, document.getElementById('sidebar-cart-icon'), document.getElementById('sidebar-cart-count'));
                }
            })
            .catch(function () {
                toast('error', 'Something went wrong!', 'Error');
            })
            .finally(function () {
                button.dataset.cartBusy = '';
                button.disabled = false;
            });
    }

    document.addEventListener('click', function (event) {
        var button = event.target.closest ? event.target.closest('.buy-now-btn') : null;
        if (button) {
            event.preventDefault();
            handleClick(button);
        }
    });

    window.WineCartToggle = { updateCount: updateCount };
})(window, document);
