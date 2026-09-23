(function () {
    'use strict';

    var config = window.acharpActualites;

    if (!config || !config.ajaxUrl) {
        return;
    }

    var list = document.querySelector('[data-actu-list]');

    if (!list) {
        return;
    }

    var results = list.querySelector('[data-actu-results]');
    var filters = list.querySelectorAll('[data-actu-filter]');
    var request = null;

    function setActiveFilter(slug) {
        Array.prototype.forEach.call(filters, function (link) {
            var isActive = link.getAttribute('data-actu-filter') === slug;

            link.classList.toggle('is-active', isActive);

            if (isActive) {
                link.setAttribute('aria-current', 'page');
            } else {
                link.removeAttribute('aria-current');
            }
        });
    }

    function pagedFromHref(href) {
        var match = /\/page\/(\d+)\/?/.exec(href || '');

        return match ? parseInt(match[1], 10) : 1;
    }

    function load(slug, paged, pushUrl) {
        if (request) {
            request.abort();
        }

        var body = new URLSearchParams({
            action: 'acharp_filter_actualites',
            nonce: config.nonce,
            term: slug || '',
            paged: paged || 1
        });

        results.setAttribute('aria-busy', 'true');
        results.classList.add('is-loading');

        var controller = typeof AbortController === 'function' ? new AbortController() : null;
        request = controller;

        fetch(config.ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
            body: body.toString(),
            signal: controller ? controller.signal : undefined
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (payload) {
                if (!payload || !payload.success) {
                    throw new Error('Réponse invalide');
                }

                results.innerHTML = payload.data.html;
                results.setAttribute('data-actu-term', slug || '');
                setActiveFilter(slug || '');

                if (pushUrl && payload.data.url) {
                    window.history.pushState({ term: slug || '', paged: paged || 1 }, '', payload.data.url);
                }
            })
            .catch(function (error) {
                if (error && error.name === 'AbortError') {
                    return;
                }

                // Sans JS fonctionnel on retombe sur la navigation classique.
                window.location.href = pushUrl || window.location.href;
            })
            .finally(function () {
                request = null;
                results.setAttribute('aria-busy', 'false');
                results.classList.remove('is-loading');
            });
    }

    function scrollToList() {
        var offset = list.getBoundingClientRect().top + window.pageYOffset - 24;

        window.scrollTo({ top: offset, behavior: 'smooth' });
    }

    list.addEventListener('click', function (event) {
        var filter = event.target.closest('[data-actu-filter]');

        if (filter) {
            event.preventDefault();
            load(filter.getAttribute('data-actu-filter'), 1, filter.getAttribute('href'));

            return;
        }

        var page = event.target.closest('.actu-pagination a');

        if (page) {
            event.preventDefault();
            load(results.getAttribute('data-actu-term'), pagedFromHref(page.getAttribute('href')), page.getAttribute('href'));
            scrollToList();
        }
    });

    window.addEventListener('popstate', function (event) {
        var state = event.state;

        if (!state) {
            window.location.reload();

            return;
        }

        load(state.term, state.paged, null);
    });
})();
