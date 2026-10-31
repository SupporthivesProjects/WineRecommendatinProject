/**
 * Phone filter drawer for the product listing pages.
 * On phones the left filter panel (.listing-filter-panel) slides in from a "Filters"
 * button instead of being hidden; on tablets and desktops nothing changes (the extra
 * button, header and footer are hidden by product-listing.css from 768px up).
 */
(function () {
    var panels = document.querySelectorAll('.listing-filter-panel');
    if (!panels.length) {
        return;
    }

    panels.forEach(function (panel, index) {
        if (!panel.id) {
            panel.id = 'listing-filters-' + index;
        }

        var row = panel.parentElement;
        var toggle = document.createElement('button');
        toggle.type = 'button';
        toggle.className = 'listing-filters-toggle';
        toggle.setAttribute('aria-controls', panel.id);
        toggle.setAttribute('aria-expanded', 'false');
        toggle.innerHTML = '<i class="fas fa-sliders-h" aria-hidden="true"></i> Filters';
        row.parentElement.insertBefore(toggle, row);

        var head = document.createElement('div');
        head.className = 'listing-filters-head';
        head.innerHTML = '<span>Filters</span><button type="button" class="listing-filters-close" aria-label="Close filters">&times;</button>';
        panel.insertBefore(head, panel.firstChild);

        var foot = document.createElement('div');
        foot.className = 'listing-filters-foot';
        foot.innerHTML = '<button type="button" class="listing-filters-apply">Show wines</button>';
        panel.appendChild(foot);

        var backdrop = document.createElement('div');
        backdrop.className = 'listing-filters-backdrop';
        backdrop.hidden = true;
        document.body.appendChild(backdrop);

        function open() {
            panel.classList.add('is-open');
            backdrop.hidden = false;
            toggle.setAttribute('aria-expanded', 'true');
            document.documentElement.classList.add('listing-filters-locked');
        }

        function close() {
            panel.classList.remove('is-open');
            backdrop.hidden = true;
            toggle.setAttribute('aria-expanded', 'false');
            document.documentElement.classList.remove('listing-filters-locked');
        }

        toggle.addEventListener('click', open);
        head.querySelector('.listing-filters-close').addEventListener('click', close);
        foot.querySelector('.listing-filters-apply').addEventListener('click', close);
        backdrop.addEventListener('click', close);
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && panel.classList.contains('is-open')) {
                close();
            }
        });
    });
})();
