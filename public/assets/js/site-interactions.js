/**
 * Site-wide interactions, included once by every layout and standalone page:
 *
 * 1. Click sound: one short "tak" per real click on a button, link or other
 *    clickable element. One listener for the whole document and one shared
 *    audio engine, so nested clickable elements never play it twice.
 * 2. Image protection: no browser context menu, dragging or iOS long-press
 *    menu on images. This only discourages casual saving; images can still be
 *    retrieved through developer tools or screenshots.
 * 3. Navbar height: exposes the fixed navbar's height as the CSS variable
 *    --site-navbar-height, so floating elements can sit just below it.
 * 4. Broken images: any image that fails to load shows images/default.jpg instead
 *    (once per image, so a missing fallback can never loop). Add data-no-fallback
 *    to an image or its container to opt out.
 *
 * Needs no other library. Safe to include twice (the second copy does nothing).
 */
(function (window, document) {
    'use strict';

    if (window.SiteInteractions) {
        return;
    }

    // Same elements the previous per-layout click sound responded to
    var CLICKABLE = 'button, a, .btn, input, select, textarea, label, td, th, .nav-link, .dropdown-item, ' +
        '.form-check-input, .form-select, .card, .list-group-item, .badge, .close, .alert, ' +
        '[data-bs-toggle], [role="button"], [tabindex]';

    // ---- 1. Click sound ----------------------------------------------------

    var audioContext = null;
    var noiseBuffer = null;

    function getAudio() {
        if (!audioContext) {
            var AudioContextClass = window.AudioContext || window.webkitAudioContext;
            if (!AudioContextClass) {
                return null;
            }
            audioContext = new AudioContextClass();

            // A 40 ms burst of fading noise: the existing "tak" sound, built once
            var length = Math.floor(audioContext.sampleRate * 0.04);
            noiseBuffer = audioContext.createBuffer(1, length, audioContext.sampleRate);
            var data = noiseBuffer.getChannelData(0);
            for (var i = 0; i < length; i++) {
                data[i] = (Math.random() * 2 - 1) * Math.pow(1 - i / length, 8);
            }
        }
        if (audioContext.state === 'suspended') {
            audioContext.resume();
        }
        return audioContext;
    }

    function playClickSound() {
        try {
            var ctx = getAudio();
            if (!ctx) {
                return;
            }
            var source = ctx.createBufferSource();
            source.buffer = noiseBuffer;
            var gain = ctx.createGain();
            gain.gain.setValueAtTime(0.10, ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.04);
            source.connect(gain);
            gain.connect(ctx.destination);
            source.start();
        } catch (error) {
            // Sound is decorative; never let it affect the click
        }
    }

    // Clicking a <label> makes the browser fire a second click on its checkbox/radio; that one is skipped
    var forwardedLabelTarget = null;

    // Capture phase: runs once per click before any page handler, even ones that stop propagation
    document.addEventListener('click', function (event) {
        // Only real user clicks; scripts calling element.click() (e.g. on page load) stay silent
        if (!event.isTrusted || !event.target || !event.target.closest) {
            return;
        }
        if (forwardedLabelTarget && event.target === forwardedLabelTarget) {
            forwardedLabelTarget = null;
            return;
        }
        if (!event.target.closest(CLICKABLE)) {
            return;
        }

        playClickSound();

        var label = event.target.closest('label');
        if (label && label.control && label.control !== event.target) {
            forwardedLabelTarget = label.control;
            window.setTimeout(function () {
                forwardedLabelTarget = null;
            }, 0);
        }
    }, true);

    // ---- 2. Image protection -----------------------------------------------

    function isImage(target) {
        return !!(target && target.closest && target.closest('img, picture'));
    }

    document.addEventListener('contextmenu', function (event) {
        if (isImage(event.target)) {
            event.preventDefault();
        }
    }, true);

    document.addEventListener('dragstart', function (event) {
        if (isImage(event.target)) {
            event.preventDefault();
        }
    }, true);

    var style = document.createElement('style');
    style.textContent = 'img{-webkit-user-drag:none;user-drag:none;-webkit-touch-callout:none;-webkit-user-select:none;user-select:none;}';
    (document.head || document.documentElement).appendChild(style);

    // ---- 3. Navbar height --------------------------------------------------

    function updateNavbarHeight() {
        var navbar = document.getElementById('mainNavbar');
        var height = 0;
        if (navbar) {
            var position = window.getComputedStyle(navbar).position;
            if (position === 'fixed' || position === 'sticky') {
                height = navbar.getBoundingClientRect().bottom;
            }
        }
        document.documentElement.style.setProperty('--site-navbar-height', Math.max(0, Math.round(height)) + 'px');
    }

    function watchNavbar() {
        updateNavbarHeight();
        var navbar = document.getElementById('mainNavbar');
        if (navbar && window.ResizeObserver) {
            new window.ResizeObserver(updateNavbarHeight).observe(navbar);
        }
        if (navbar) {
            // The mobile menu opens with an animated collapse; re-measure once it settles
            ['shown.bs.collapse', 'hidden.bs.collapse', 'transitionend'].forEach(function (name) {
                navbar.addEventListener(name, updateNavbarHeight);
            });
        }
        window.addEventListener('resize', updateNavbarHeight);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', watchNavbar);
    } else {
        watchNavbar();
    }

    // ---- 4. Broken images ---------------------------------------------------

    // Same folder layout as this script: /assets/js/site-interactions.js -> /images/default.jpg
    var currentScript = document.currentScript;
    var FALLBACK_IMAGE = currentScript && currentScript.src
        ? currentScript.src.replace(/\/assets\/js\/site-interactions\.js.*$/, '/images/default.jpg')
        : '/images/default.jpg';

    function useFallbackImage(img) {
        if (!img || img.getAttribute('data-fallback-applied') || img.closest('[data-no-fallback]')) {
            return;
        }
        img.setAttribute('data-fallback-applied', '1');
        img.removeAttribute('srcset');
        img.src = FALLBACK_IMAGE;
    }

    // Image errors do not bubble, so listen in the capture phase (covers images added later too)
    document.addEventListener('error', function (event) {
        var target = event.target;
        if (target && target.tagName === 'IMG') {
            useFallbackImage(target);
        }
    }, true);

    // Images that already failed before this script ran. SVGs are skipped here because
    // some report a natural width of 0 even when they display fine; their errors are caught above.
    function replaceAlreadyBrokenImages() {
        var images = document.querySelectorAll('img');
        for (var i = 0; i < images.length; i++) {
            var img = images[i];
            var src = img.getAttribute('src') || '';
            if (src && img.complete && img.naturalWidth === 0 && !/\.svg(\?|#|$)/i.test(src)) {
                useFallbackImage(img);
            }
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', replaceAlreadyBrokenImages);
    } else {
        replaceAlreadyBrokenImages();
    }
    window.addEventListener('load', replaceAlreadyBrokenImages);

    window.SiteInteractions = {
        playClickSound: playClickSound
    };
})(window, document);
