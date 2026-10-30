/**
 * Add-to-cart animation shared by the products and matched-products pages.
 *
 * A miniature wine bottle flies from the clicked button into the cart icon,
 * then the cart gets a red ring, a short particle burst and the count pops.
 * It is purely visual: call WineCartFx.play() only after the cart request
 * has succeeded. It never touches cart data or the count's value.
 */
(function (window, document) {
    'use strict';

    var FLIGHT_MS = 850;
    var PARTICLE_COUNT = 14;
    var MAX_PARTICLES_ON_SCREEN = 42;
    var PARTICLE_COLOURS = ['#8b0000', '#b3122e', '#5e0b1e', '#d4af37', '#e8c872'];

    var BOTTLE_SVG =
        '<svg viewBox="0 0 24 64" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">' +
            '<defs><linearGradient id="wine-cart-fx-glass" x1="0" x2="1">' +
                '<stop offset="0" stop-color="#3a0610"/><stop offset=".45" stop-color="#7a0f22"/><stop offset="1" stop-color="#2a040b"/>' +
            '</linearGradient></defs>' +
            '<rect x="9" y="1" width="6" height="10" rx="1.2" fill="#c9a24a"/>' +
            '<path d="M9.2 10H14.8V18C14.8 21 21 23 21 29V60A3 3 0 0 1 18 63H6A3 3 0 0 1 3 60V29C3 23 9.2 21 9.2 18Z" fill="url(#wine-cart-fx-glass)"/>' +
            '<path d="M6.3 29V56" stroke="#fff" stroke-opacity=".28" stroke-width="1.4" stroke-linecap="round"/>' +
            '<rect x="5" y="36" width="14" height="14" rx="1.5" fill="#f4ead5"/>' +
            '<rect x="5" y="38.4" width="14" height="1.2" fill="#c9a24a"/>' +
            '<rect x="8" y="42" width="8" height="1.3" rx=".6" fill="#7a0f22" opacity=".75"/>' +
            '<rect x="9.5" y="45" width="5" height="1" rx=".5" fill="#7a0f22" opacity=".5"/>' +
        '</svg>';

    function prefersReducedMotion() {
        return !!(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);
    }

    function isOnScreen(rect) {
        return rect.width > 0 && rect.height > 0 &&
            rect.bottom > 0 && rect.right > 0 &&
            rect.top < window.innerHeight && rect.left < window.innerWidth;
    }

    function centreOf(rect) {
        return { x: rect.left + rect.width / 2, y: rect.top + rect.height / 2 };
    }

    // Remove an animation element when it finishes, with a timer as a safety net
    function removeWhenDone(element, animation, fallbackMs, done) {
        var finished = false;
        function finish() {
            if (finished) {
                return;
            }
            finished = true;
            if (element.parentNode) {
                element.parentNode.removeChild(element);
            }
            if (done) {
                done();
            }
        }
        if (animation) {
            animation.onfinish = finish;
            animation.oncancel = finish;
        }
        window.setTimeout(finish, fallbackMs);
    }

    /**
     * Fly a small bottle from sourceElement to cartElement.
     * Resolves when the bottle reaches the cart (or straight away if it cannot fly).
     */
    function animateBottleToCart(sourceElement, cartElement) {
        return new Promise(function (resolve) {
            if (!sourceElement || !cartElement || !document.body.animate) {
                resolve();
                return;
            }

            var sourceRect = sourceElement.getBoundingClientRect();
            var cartRect = cartElement.getBoundingClientRect();

            // Cart hidden or scrolled away: skip the flight, the celebration still runs
            if (!isOnScreen(cartRect) || !isOnScreen(sourceRect)) {
                resolve();
                return;
            }

            var start = centreOf(sourceRect);
            var end = centreOf(cartRect);

            var bottle = document.createElement('div');
            bottle.className = 'wine-cart-bottle';
            bottle.innerHTML = BOTTLE_SVG;
            bottle.style.left = (start.x - 11) + 'px';
            bottle.style.top = (start.y - 30) + 'px';
            document.body.appendChild(bottle);

            // Gentle arc: lift above the higher of the two points, then drop into the cart
            var dx = end.x - start.x;
            var dy = end.y - start.y;
            var lift = Math.max(70, Math.min(200, Math.hypot(dx, dy) * 0.3));
            var controlX = dx * 0.45;
            var controlY = Math.max(Math.min(0, dy) - lift, 20 - start.y);

            var keyframes = [];
            var steps = 14;
            for (var i = 0; i <= steps; i++) {
                var t = i / steps;
                var inverse = 1 - t;
                var x = 2 * inverse * t * controlX + t * t * dx;
                var y = 2 * inverse * t * controlY + t * t * dy;
                var scale = 1 - 0.72 * t;
                var rotate = -18 * Math.sin(Math.PI * t) + 12 * t;
                keyframes.push({
                    offset: t,
                    transform: 'translate(' + x.toFixed(1) + 'px, ' + y.toFixed(1) + 'px) rotate(' + rotate.toFixed(1) + 'deg) scale(' + scale.toFixed(3) + ')',
                    opacity: t < 0.08 ? t / 0.08 : (t > 0.86 ? (1 - t) / 0.14 : 1)
                });
            }

            var flight = bottle.animate(keyframes, {
                duration: FLIGHT_MS,
                easing: 'cubic-bezier(0.45, 0.05, 0.25, 1)',
                fill: 'forwards'
            });

            removeWhenDone(bottle, flight, FLIGHT_MS + 400, resolve);
        });
    }

    function burstParticles(cartElement) {
        if (!document.body.animate || document.querySelectorAll('.wine-cart-particle').length > MAX_PARTICLES_ON_SCREEN) {
            return;
        }

        var rect = cartElement.getBoundingClientRect();
        if (!isOnScreen(rect)) {
            return;
        }

        var centre = centreOf(rect);
        var radius = Math.min(rect.width, rect.height) / 2;

        for (var i = 0; i < PARTICLE_COUNT; i++) {
            var particle = document.createElement('span');
            particle.className = 'wine-cart-particle' + (i % 3 === 0 ? ' is-round' : '');
            particle.style.background = PARTICLE_COLOURS[i % PARTICLE_COLOURS.length];
            particle.style.left = (centre.x - 3) + 'px';
            particle.style.top = (centre.y - 3) + 'px';
            document.body.appendChild(particle);

            var angle = (i / PARTICLE_COUNT) * Math.PI * 2 + (Math.random() - 0.5) * 0.5;
            var distance = radius + 18 + Math.random() * 26;
            var tx = Math.cos(angle) * distance;
            var ty = Math.sin(angle) * distance;
            var spin = (Math.random() - 0.5) * 360;
            var duration = 650 + Math.random() * 250;

            var burst = particle.animate([
                { transform: 'translate(0, 0) rotate(0deg) scale(0.6)', opacity: 0 },
                { transform: 'translate(' + (tx * 0.35).toFixed(1) + 'px, ' + (ty * 0.35).toFixed(1) + 'px) rotate(' + (spin * 0.3).toFixed(0) + 'deg) scale(1)', opacity: 1, offset: 0.2 },
                { transform: 'translate(' + tx.toFixed(1) + 'px, ' + (ty + 8).toFixed(1) + 'px) rotate(' + spin.toFixed(0) + 'deg) scale(0.4)', opacity: 0 }
            ], {
                duration: duration,
                easing: 'cubic-bezier(0.2, 0.7, 0.3, 1)',
                fill: 'forwards'
            });

            removeWhenDone(particle, burst, duration + 300);
        }
    }

    function restartClassAnimation(element, className, fallbackMs) {
        element.classList.remove(className);
        void element.offsetWidth; // restart the CSS animation if it is already running
        element.classList.add(className);
        window.clearTimeout(element._wineCartFxTimer);
        element._wineCartFxTimer = window.setTimeout(function () {
            element.classList.remove(className);
        }, fallbackMs);
    }

    /**
     * Red ring + particle burst on the cart, and a pop on the count.
     */
    function animateCartCelebration(cartElement, countElement) {
        if (!cartElement) {
            return;
        }

        // Only one ring at a time, so rapid clicks restart it instead of stacking
        var oldRing = cartElement.querySelector('.wine-cart-ring');
        if (oldRing) {
            oldRing.parentNode.removeChild(oldRing);
        }
        var ring = document.createElement('span');
        ring.className = 'wine-cart-ring';
        ring.setAttribute('aria-hidden', 'true');
        cartElement.appendChild(ring);
        removeWhenDone(ring, null, 1500);

        if (!prefersReducedMotion()) {
            burstParticles(cartElement);
        }

        if (countElement) {
            restartClassAnimation(countElement, 'wine-cart-count-pop', 700);
        }
    }

    /**
     * Run the whole sequence. Safe to call repeatedly; never throws.
     */
    function play(sourceElement, cartElement, countElement) {
        try {
            if (!cartElement) {
                return;
            }
            if (prefersReducedMotion()) {
                animateCartCelebration(cartElement, countElement);
                return;
            }
            animateBottleToCart(sourceElement, cartElement).then(function () {
                animateCartCelebration(cartElement, countElement);
            });
        } catch (error) {
            // The animation is decorative; never let it affect the cart
            if (window.console) {
                window.console.warn('Cart animation skipped:', error);
            }
        }
    }

    window.WineCartFx = {
        play: play,
        animateBottleToCart: animateBottleToCart,
        animateCartCelebration: animateCartCelebration
    };
})(window, document);
