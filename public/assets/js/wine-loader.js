/**
 * Full-screen "Cork Master" loading scene shown while questionnaire answers
 * are matched to wines. Purely visual: it never delays or controls the request.
 *
 *   WineLoader.show()  - appears immediately (call right before the request)
 *   WineLoader.hide()  - fades out
 */
(function (window, document) {
    'use strict';

    if (window.WineLoader) {
        return;
    }

    var MESSAGES = [
        'Exploring the cellar, row by row…',
        'Checking the finest vintages…',
        'Matching your palate with exceptional bottles…',
        'Good wine takes time — your perfect match is almost here.'
    ];
    var MESSAGE_INTERVAL_MS = 2400;

    var SCENE_SVG =
        '<svg class="wine-loader-scene" viewBox="0 0 240 210" aria-hidden="true" focusable="false">' +
            '<defs>' +
                '<linearGradient id="wine-loader-glass" x1="0" x2="1">' +
                    '<stop offset="0" stop-color="#3a0610"/><stop offset=".45" stop-color="#7a0f22"/><stop offset="1" stop-color="#2a040b"/>' +
                '</linearGradient>' +
                '<linearGradient id="wine-loader-wine" x1="0" y1="0" x2="0" y2="1">' +
                    '<stop offset="0" stop-color="#a3162f"/><stop offset="1" stop-color="#5c0a1c"/>' +
                '</linearGradient>' +
                '<clipPath id="wine-loader-bowl"><path d="M128 92 C128 92 124 136 154 140 C184 136 180 92 180 92 Z"/></clipPath>' +
            '</defs>' +

            // Bottle, tilted and gently rocking while it pours
            '<g class="wine-loader-bottle">' +
                '<rect x="20" y="0" width="8" height="12" rx="1.5" fill="#c9a24a"/>' +
                '<path d="M20.5 11H27.5V22C27.5 26 36 29 36 37V84A4 4 0 0 1 32 88H16A4 4 0 0 1 12 84V37C12 29 20.5 26 20.5 22Z" fill="url(#wine-loader-glass)"/>' +
                '<path d="M16 38V80" stroke="#fff" stroke-opacity=".25" stroke-width="2" stroke-linecap="round"/>' +
                '<rect x="14" y="50" width="20" height="20" rx="2" fill="#f4ead5"/>' +
                '<rect x="14" y="53.5" width="20" height="1.6" fill="#c9a24a"/>' +
                '<rect x="18" y="59" width="12" height="1.8" rx=".9" fill="#7a0f22" opacity=".7"/>' +
                '<rect x="20" y="63.5" width="8" height="1.4" rx=".7" fill="#7a0f22" opacity=".5"/>' +
            '</g>' +

            // Wine stream from the bottle neck into the glass
            '<path class="wine-loader-stream" d="M113 52 C134 56 151 70 154 104" fill="none" stroke="#8b0f26" stroke-width="3.2" stroke-linecap="round"/>' +

            // Wine in the glass: rises, then swirls
            '<g clip-path="url(#wine-loader-bowl)">' +
                '<g class="wine-loader-fill">' +
                    '<path class="wine-loader-wave" d="M100 118 Q114 112 128 118 T156 118 T184 118 T212 118 V160 H100 Z" fill="url(#wine-loader-wine)"/>' +
                '</g>' +
            '</g>' +

            // Glass outline (drawn over the wine)
            '<path d="M128 92 C128 92 124 136 154 140 C184 136 180 92 180 92" fill="none" stroke="#f4ead5" stroke-opacity=".85" stroke-width="2"/>' +
            '<path d="M154 140 V172 M138 176 Q154 170 170 176" fill="none" stroke="#f4ead5" stroke-opacity=".85" stroke-width="2" stroke-linecap="round"/>' +
            '<path d="M134 100 Q133 118 140 128" fill="none" stroke="#fff" stroke-opacity=".35" stroke-width="1.6" stroke-linecap="round"/>' +

            // Cellar shelf: bottles light up one after another
            '<g class="wine-loader-shelf">' +
                '<rect x="20" y="198" width="200" height="3" rx="1.5" fill="#c9a24a" opacity=".55"/>' +
                [32, 62, 92, 122, 152, 182].map(function (x, i) {
                    return '<g class="wine-loader-shelf-bottle" style="animation-delay:' + (i * 0.28).toFixed(2) + 's">' +
                        '<rect x="' + (x + 4) + '" y="174" width="4" height="6" rx="1" fill="#c9a24a"/>' +
                        '<path d="M' + (x + 4) + ' 179H' + (x + 8) + 'V183C' + (x + 8) + ' 185 ' + (x + 12) + ' 186 ' + (x + 12) + ' 189V196A1.5 1.5 0 0 1 ' + (x + 10.5) + ' 197.5H' + (x + 1.5) + 'A1.5 1.5 0 0 1 ' + x + ' 196V189C' + x + ' 186 ' + (x + 4) + ' 185 ' + (x + 4) + ' 183Z" fill="#5e0b1e"/>' +
                    '</g>';
                }).join('') +
            '</g>' +
        '</svg>';

    var overlay = null;
    var messageElement = null;
    var messageTimer = null;
    var hideTimer = null;
    var messageIndex = 0;

    function build() {
        overlay = document.createElement('div');
        overlay.className = 'wine-loader';
        overlay.setAttribute('role', 'status');
        overlay.setAttribute('aria-live', 'polite');
        overlay.setAttribute('aria-busy', 'true');
        overlay.setAttribute('tabindex', '-1');
        overlay.innerHTML =
            '<div class="wine-loader-card">' +
                SCENE_SVG +
                '<p class="wine-loader-title">Our Cork Master is searching for the perfect wines for you!</p>' +
                '<p class="wine-loader-message"></p>' +
            '</div>';
        messageElement = overlay.querySelector('.wine-loader-message');
        document.body.appendChild(overlay);
    }

    function showMessage(index) {
        messageElement.classList.remove('is-visible');
        window.setTimeout(function () {
            messageElement.textContent = MESSAGES[index % MESSAGES.length];
            messageElement.classList.add('is-visible');
        }, 180);
    }

    function show() {
        if (!overlay) {
            build();
        }
        window.clearTimeout(hideTimer);
        window.clearInterval(messageTimer);

        messageIndex = 0;
        messageElement.textContent = MESSAGES[0];
        messageElement.classList.add('is-visible');
        messageTimer = window.setInterval(function () {
            messageIndex += 1;
            showMessage(messageIndex);
        }, MESSAGE_INTERVAL_MS);

        overlay.classList.remove('is-leaving');
        overlay.classList.add('is-visible');
        try {
            overlay.focus({ preventScroll: true });
        } catch (error) {
            // Focus is a convenience for screen readers only
        }
    }

    function hide() {
        if (!overlay || !overlay.classList.contains('is-visible')) {
            return;
        }
        window.clearInterval(messageTimer);
        overlay.classList.add('is-leaving');
        hideTimer = window.setTimeout(function () {
            overlay.classList.remove('is-visible', 'is-leaving');
        }, 300);
    }

    // Coming back with the browser's Back button can restore this page from cache with the loader still showing
    window.addEventListener('pageshow', function (event) {
        if (event.persisted) {
            hide();
        }
    });

    window.WineLoader = {
        show: show,
        hide: hide,
        isVisible: function () {
            return !!(overlay && overlay.classList.contains('is-visible'));
        }
    };
})(window, document);
