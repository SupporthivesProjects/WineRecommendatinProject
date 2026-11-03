/**
 * Homepage Menu (layouts/boothome.blade.php): the gold wine-bottle trigger in the top
 * right opens a navigation panel that slides in from the right (styles: assets/css/home-wine-nav.css).
 *
 * - The trigger label reads MENU when closed and CLOSE when open; the turning
 *   "CLICK ME" ring stops while the panel is open.
 * - Closes with the trigger, a click outside the panel, Escape, or choosing a link.
 * - While open the page behind does not scroll, and Tab stays inside the menu.
 * - The links keep the theme's side-menu__item class, so landing.js still smooth-scrolls
 *   to the homepage sections and marks the section on screen.
 */
(function (window, document) {
    'use strict';

    var trigger = document.getElementById('wine-menu-trigger');
    var panel = document.getElementById('wine-menu-panel');
    var backdrop = document.getElementById('wine-menu-backdrop');
    if (!trigger || !panel || !backdrop) {
        return;
    }

    var label = trigger.querySelector('.wine-menu-label');
    var root = document.documentElement;
    var isOpen = false;

    function focusables() {
        return [trigger].concat(Array.prototype.slice.call(panel.querySelectorAll('a[href], button:not([disabled])')));
    }

    function lockPage(lock) {
        if (lock) {
            // Keep the page from shifting when its scrollbar disappears
            var scrollbar = window.innerWidth - root.clientWidth;
            document.body.style.paddingRight = scrollbar > 0 ? scrollbar + 'px' : '';
            root.classList.add('wine-menu-locked');
        } else {
            root.classList.remove('wine-menu-locked');
            document.body.style.paddingRight = '';
        }
    }

    function setOpen(open, restoreFocus) {
        if (open === isOpen) {
            return;
        }
        isOpen = open;

        trigger.classList.toggle('is-open', open);
        panel.classList.toggle('is-open', open);
        backdrop.classList.toggle('is-open', open);
        trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
        trigger.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
        if (label) {
            label.textContent = open ? 'CLOSE' : 'MENU';
        }
        panel.setAttribute('aria-hidden', open ? 'false' : 'true');
        if (open) {
            panel.removeAttribute('inert');
        } else {
            panel.setAttribute('inert', '');
        }
        lockPage(open);

        if (open) {
            // Focus the first link once the panel has started moving in
            var first = panel.querySelector('a[href]');
            if (first) {
                window.setTimeout(function () {
                    if (isOpen) {
                        first.focus({ preventScroll: true });
                    }
                }, 120);
            }
        } else if (restoreFocus) {
            trigger.focus({ preventScroll: true });
        }
    }

    trigger.addEventListener('click', function () {
        setOpen(!isOpen, true);
    });

    backdrop.addEventListener('click', function () {
        setOpen(false, true);
    });

    // Choosing a link closes the menu; landing.js (section links) or the browser does the rest
    panel.addEventListener('click', function (event) {
        if (event.target.closest('a[href]')) {
            setOpen(false, false);
        }
    });

    document.addEventListener('keydown', function (event) {
        if (!isOpen) {
            return;
        }

        if (event.key === 'Escape') {
            event.preventDefault();
            setOpen(false, true);
            return;
        }

        // Keep Tab within the trigger and the panel links
        if (event.key === 'Tab') {
            var items = focusables();
            var index = items.indexOf(document.activeElement);
            var next = event.shiftKey ? index - 1 : index + 1;
            if (index === -1 || next < 0 || next >= items.length) {
                event.preventDefault();
                items[event.shiftKey ? items.length - 1 : 0].focus();
            }
        }
    });
})(window, document);
