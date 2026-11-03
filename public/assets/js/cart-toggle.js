/**
 * Add to cart / Remove from cart buttons on every logged-in page
 * (Browse Wines, Featured Products, Wine Matches and its product modal,
 * Wine Details, Cheese Details paired wines). Loaded once by layouts/user.blade.php.
 *
 * Buttons: <button class="buy-now-btn btn-light|btn-dark" data-product-id data-product-name data-product-price>
 * btn-dark means the wine is already in the cart, so the click removes it.
 * Optional data-qty-input="<input id>" sends that input's quantity when adding.
 * The cart URLs come from this script tag's data attributes.
 *
 * Every button for the same wine changes together, and every cart count on the page
 * is updated from the server's answer. When the browser shows a page again from its
 * history (Back / Forward), the cart is reloaded so buttons and counts are never stale.
 *
 * Adding shows no success pop-up: the flying bottle, the cart ring and the
 * updated count confirm it. Removing shows a warning toast, failures an error toast.
 */
(function (window, document) {
    'use strict';

    if (window.WineCartToggle) {
        return;
    }

    var script = document.currentScript;
    var urls = {
        add: script && script.dataset.addUrl,
        remove: script && script.dataset.removeUrl,
        cart: script && script.dataset.cartUrl
    };

    var ADD_LABEL = '<i class="fas fa-shopping-cart me-1" aria-hidden="true"></i>Add to cart';
    var REMOVE_LABEL = '<i class="fas fa-shopping-cart me-1" aria-hidden="true"></i>Remove from cart';

    // Wines with a cart request on the way; their buttons ignore clicks until it finishes
    var busy = {};

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

    function buttonsFor(productId) {
        return Array.prototype.filter.call(document.querySelectorAll('.buy-now-btn'), function (button) {
            return button.dataset.productId === String(productId);
        });
    }

    // Header "View Cart (n)", the round cart button and the Wine Matches cart button
    function updateCount(count) {
        ['sidebar-cart-count', 'cart-count', 'floating-cart-count'].forEach(function (id) {
            var element = document.getElementById(id);
            if (element) {
                element.textContent = count;
            }
        });

        var hasItems = Number(count) > 0;
        var sidebarIcon = document.getElementById('sidebar-cart-icon');
        if (sidebarIcon) {
            sidebarIcon.classList.toggle('cart-has-items', hasItems);
        }
        var floatingCart = document.getElementById('floating-cart');
        if (floatingCart) {
            floatingCart.classList.toggle('has-items', hasItems);
        }
    }

    function setInCart(button, inCart) {
        button.classList.toggle('btn-dark', inCart);
        button.classList.toggle('btn-light', !inCart);
        button.innerHTML = inCart ? REMOVE_LABEL : ADD_LABEL;
    }

    function setBusy(productId, isBusy) {
        if (isBusy) {
            busy[productId] = true;
        } else {
            delete busy[productId];
        }
        buttonsFor(productId).forEach(function (button) {
            button.disabled = isBusy;
        });
    }

    function quantityFor(button) {
        var input = button.dataset.qtyInput && document.getElementById(button.dataset.qtyInput);
        var quantity = input ? parseInt(input.value, 10) : 1;
        return quantity > 0 ? quantity : 1;
    }

    function cartIconTarget() {
        return {
            icon: document.getElementById('sidebar-cart-icon') || document.getElementById('floating-cart'),
            count: document.getElementById('sidebar-cart-count') || document.getElementById('floating-cart-count')
        };
    }

    function handleClick(button) {
        var productId = button.dataset.productId;
        if (!productId || !urls.add || busy[productId]) {
            return;
        }

        var isInCart = button.classList.contains('btn-dark');
        var body = {
            product_id: productId,
            product_name: button.dataset.productName,
            product_price: button.dataset.productPrice
        };
        if (!isInCart) {
            body.quantity = quantityFor(button);
        }

        // One request at a time per wine, so double clicks do not send twice
        setBusy(productId, true);

        fetch(isInCart ? urls.remove : urls.add, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken()
            },
            body: JSON.stringify(body)
        })
            .then(function (response) {
                return response.json().catch(function () {
                    return {};
                }).then(function (data) {
                    if (response.status === 419) {
                        throw new Error('Your session has expired. Please refresh the page and try again.');
                    }
                    if (!response.ok || !data.success) {
                        throw new Error(data.message || 'Something went wrong!');
                    }
                    return data;
                });
            })
            .then(function (data) {
                buttonsFor(productId).forEach(function (other) {
                    setInCart(other, !isInCart);
                });
                updateCount(data.cart_count || 0);

                if (isInCart) {
                    toast('warning', 'Product removed from cart!', 'Removed');
                } else if (window.WineCartFx) {
                    // Bottle-into-cart animation (visual only, see assets/js/cart-animation.js)
                    var target = cartIconTarget();
                    window.WineCartFx.play(button, target.icon, target.count);
                }
            })
            .catch(function (error) {
                toast('error', error.message || 'Something went wrong!', 'Error');
                // The cart may have changed anyway; show what the server has
                sync();
            })
            .finally(function () {
                setBusy(productId, false);
            });
    }

    // Reload the cart and bring every button and count on the page in line with it
    function sync() {
        if (!urls.cart) {
            return Promise.resolve();
        }

        return fetch(urls.cart, {
            credentials: 'same-origin',
            cache: 'no-store',
            headers: { 'Accept': 'application/json' }
        })
            .then(function (response) {
                return response.ok ? response.json() : null;
            })
            .then(function (data) {
                if (!data || !Array.isArray(data.cart)) {
                    return;
                }
                var inCart = {};
                var count = 0;
                data.cart.forEach(function (item) {
                    inCart[String(item.id)] = true;
                    count += Number(item.quantity) || 1;
                });
                Array.prototype.forEach.call(document.querySelectorAll('.buy-now-btn'), function (button) {
                    var shouldBeIn = !!inCart[button.dataset.productId];
                    if (button.classList.contains('btn-dark') !== shouldBeIn) {
                        setInCart(button, shouldBeIn);
                    }
                });
                updateCount(count);
                document.dispatchEvent(new CustomEvent('wine-cart:synced', { detail: { cart: data.cart } }));
            })
            .catch(function () {
                // Leave the page as it is; the next click reports any real problem
            });
    }

    document.addEventListener('click', function (event) {
        var button = event.target.closest ? event.target.closest('.buy-now-btn') : null;
        if (button) {
            event.preventDefault();
            handleClick(button);
        }
    });

    // Back / Forward shows the page as it was when the user left it; refresh the cart state
    window.addEventListener('pageshow', function (event) {
        var navigation = window.performance && performance.getEntriesByType
            ? performance.getEntriesByType('navigation')[0]
            : null;
        if (event.persisted || (navigation && navigation.type === 'back_forward')) {
            sync();
        }
    });

    window.WineCartToggle = { updateCount: updateCount, sync: sync };
})(window, document);
