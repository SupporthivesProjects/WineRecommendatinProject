/**
 * Smooth page scrolling (mouse wheel / trackpad glide) with Lenis.
 * Loaded after the Lenis library (https://github.com/darkroomengineering/lenis, MIT).
 * Used by: layouts/boothome.blade.php (homepage). Add the same two script tags and the
 * lenis.css link to another layout to use it there too.
 *
 * - The page still scrolls natively underneath, so scroll listeners (header colour,
 *   back-to-top button, section highlighting) keep working unchanged.
 * - Touch screens keep their own native scrolling (already smooth).
 * - Links to a section on the same page (#id) glide there, stopping just below the
 *   fixed header.
 * - Pop-ups (Bootstrap modals) and anything marked data-lenis-prevent scroll normally,
 *   and the page behind an open pop-up does not move.
 * - Visitors who ask their system for reduced motion get normal scrolling.
 */
(function (window, document) {
    'use strict';

    if (window.siteSmoothScroll || typeof window.Lenis !== 'function') {
        return;
    }
    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    var lenis = new window.Lenis({
        lerp: 0.07,              // lower = longer, softer glide
        wheelMultiplier: 0.9,
        smoothWheel: true,
        syncTouch: false,
        // Pop-ups and marked areas keep their own scrolling
        prevent: function (node) {
            return !!(node.closest && node.closest('.modal, [data-lenis-prevent]'));
        }
    });

    function raf(time) {
        lenis.raf(time);
        window.requestAnimationFrame(raf);
    }
    window.requestAnimationFrame(raf);

    // Height of the fixed header at the top of the screen, so section links stop below it
    function headerOffset() {
        var bottom = 0;
        document.querySelectorAll('.app-header, #sidebar, header').forEach(function (element) {
            var style = window.getComputedStyle(element);
            if (style.display === 'none' || (style.position !== 'fixed' && style.position !== 'sticky')) {
                return;
            }
            var rect = element.getBoundingClientRect();
            // Only full-width bars at the top (not the phone slide-out menu)
            if (rect.top <= 0 && rect.width >= window.innerWidth * 0.9) {
                bottom = Math.max(bottom, rect.bottom);
            }
        });
        return bottom;
    }

    // Section links (#id on this page) glide to the section. Runs before the theme's own
    // link handler (landing.js), so the page is not scrolled twice.
    document.addEventListener('click', function (event) {
        if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey) {
            return;
        }
        var link = event.target.closest && event.target.closest('a[href^="#"]');
        var hash = link && link.getAttribute('href');
        if (!hash || hash === '#' || !/^#[\w-]+$/.test(hash) || link.hasAttribute('data-bs-toggle')) {
            return;
        }
        var target = document.getElementById(hash.slice(1));
        if (!target) {
            return;
        }
        event.preventDefault();
        event.stopPropagation();
        lenis.scrollTo(target, { offset: -headerOffset(), duration: 1.4 });
    }, true);

    // Keep the page still while a Bootstrap pop-up is open
    document.addEventListener('show.bs.modal', function () {
        lenis.stop();
    });
    document.addEventListener('hidden.bs.modal', function () {
        if (!document.querySelector('.modal.show')) {
            lenis.start();
        }
    });

    window.siteSmoothScroll = lenis;
})(window, document);
