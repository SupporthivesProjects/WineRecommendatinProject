/**
 * "Preparing your questions…" overlay shown while a questionnaire loads
 * (the questions request can take a few seconds on the kiosk).
 * Usage: QuestionLoader.show() before the request, QuestionLoader.hide() when the
 * modal opens or the request fails.
 */
(function () {
    if (window.QuestionLoader) {
        return;
    }

    var overlay = null;

    function build() {
        var style = document.createElement('style');
        style.textContent =
            '.question-loader{position:fixed;inset:0;z-index:2000;display:flex;flex-direction:column;' +
            'align-items:center;justify-content:center;gap:16px;background:rgba(20,4,8,0.72);color:#fff;' +
            'font-size:1.05rem;letter-spacing:0.02em}' +
            '.question-loader[hidden]{display:none}' +
            '.question-loader-spinner{width:48px;height:48px;border-radius:50%;border:3px solid rgba(224,197,139,0.3);' +
            'border-top-color:#e0c58b;animation:question-loader-spin 0.9s linear infinite}' +
            '@keyframes question-loader-spin{to{transform:rotate(360deg)}}' +
            '@media (prefers-reduced-motion:reduce){.question-loader-spinner{animation-duration:2.5s}}';
        document.head.appendChild(style);

        overlay = document.createElement('div');
        overlay.className = 'question-loader';
        overlay.setAttribute('role', 'status');
        overlay.setAttribute('aria-live', 'polite');
        overlay.hidden = true;
        overlay.innerHTML = '<div class="question-loader-spinner" aria-hidden="true"></div><div>Preparing your questions…</div>';
        document.body.appendChild(overlay);
    }

    window.QuestionLoader = {
        show: function () {
            if (!overlay) {
                build();
            }
            overlay.hidden = false;
        },
        hide: function () {
            if (overlay) {
                overlay.hidden = true;
            }
        }
    };
})();
