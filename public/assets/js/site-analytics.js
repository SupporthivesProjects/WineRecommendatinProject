/**
 * Click analytics for logged-in kiosk pages (admin "Website Health" page).
 *
 * Reports which link or button was clicked (its visible text, or aria-label / title
 * for icon buttons), where it leads and on which page. Text typed into fields is never
 * read. Questionnaire answers are not sent here; they are counted from saved answers.
 * Uses navigator.sendBeacon so following a link is never delayed. Failures are ignored.
 */
(function (window, document) {
    'use strict';

    if (window.SiteAnalytics) {
        return;
    }

    var script = document.currentScript;
    var endpoint = script && script.dataset.endpoint;
    var routeName = (script && script.dataset.route) || '';
    if (!endpoint || !navigator.sendBeacon) {
        return;
    }

    function csrfToken() {
        var meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    function labelOf(element) {
        var text = element.getAttribute('data-track')
            || (element.innerText || '').trim()
            || element.getAttribute('aria-label')
            || element.getAttribute('title')
            || '';
        return text.replace(/\s+/g, ' ').trim().slice(0, 150);
    }

    function targetOf(element) {
        var href = element.getAttribute('href');
        if (!href || href.charAt(0) === '#' || /^javascript:/i.test(href)) {
            return '';
        }
        try {
            var url = new URL(href, window.location.href);
            return (url.origin === window.location.origin ? url.pathname : url.origin + url.pathname).slice(0, 255);
        } catch (error) {
            return '';
        }
    }

    document.addEventListener('click', function (event) {
        var element = event.target.closest && event.target.closest('a[href], button, [role="button"]');
        // Questionnaire answers are counted from the saved responses instead
        if (!element || element.closest('#question-container')) {
            return;
        }

        var label = labelOf(element);
        if (!label) {
            return;
        }

        var product = element.closest('[data-product-id]');
        var data = new FormData();
        data.append('_token', csrfToken());
        data.append('label', label);
        data.append('target', targetOf(element));
        data.append('route', routeName);
        data.append('path', window.location.pathname.slice(0, 255));
        if (product && /^\d+$/.test(product.getAttribute('data-product-id'))) {
            data.append('product_id', product.getAttribute('data-product-id'));
        }

        try {
            navigator.sendBeacon(endpoint, data);
        } catch (error) {
            // Analytics must never interrupt the page
        }
    }, true);

    window.SiteAnalytics = {};
})(window, document);
