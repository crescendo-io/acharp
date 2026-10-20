(function () {
    'use strict';

    var banner = document.querySelector('[data-po-banner]');
    var popup = document.getElementById('po-popup');
    var storageKey = 'acharp_po_popup_dismissed';

    function hide(el) {
        if (el) {
            el.setAttribute('hidden', '');
        }
    }

    function show(el) {
        if (el) {
            el.removeAttribute('hidden');
        }
    }

    if (banner) {
        var closeBanner = banner.querySelector('[data-po-banner-close]');

        if (closeBanner) {
            closeBanner.addEventListener('click', function () {
                hide(banner);
            });
        }
    }

    if (!popup) {
        return;
    }

    if (window.sessionStorage && sessionStorage.getItem(storageKey) === '1') {
        return;
    }

    window.setTimeout(function () {
        show(popup);
    }, 900);

    popup.querySelectorAll('[data-po-popup-close]').forEach(function (node) {
        node.addEventListener('click', function () {
            hide(popup);

            if (window.sessionStorage) {
                sessionStorage.setItem(storageKey, '1');
            }
        });
    });
})();
