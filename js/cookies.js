(function () {
    var COOKIE = 'acharp_consent';
    var MAX_AGE = 60 * 60 * 24 * 183;
    var VERSION = 1;
    var GTM_ID = 'GTM-KSV3J52N';
    var GA_COOKIE_SECONDS = 60 * 60 * 24 * 395;
    var loaded = false;
    var banner = document.querySelector('[data-cookie-banner]');
    var listeners = [];

    if (!banner) {
        return;
    }

    var viewChoice = banner.querySelector('[data-cookie-view="choice"]');
    var viewDetails = banner.querySelector('[data-cookie-view="details"]');
    var analyticsInput = banner.querySelector('[data-cookie-analytics]');
    var mediaInput = banner.querySelector('[data-cookie-media]');
    var dialog = banner.querySelector('[role="dialog"]');

    function readRaw() {
        var match = document.cookie.match(new RegExp('(?:^|; )' + COOKIE + '=([^;]*)'));
        return match ? decodeURIComponent(match[1]) : '';
    }

    function parse(raw) {
        if (!raw) {
            return null;
        }

        if (raw === 'analytics=yes' || raw === 'analytics=no') {
            return {
                v: 0,
                necessary: 1,
                analytics: raw === 'analytics=yes' ? 1 : 0,
                media: 0,
                ts: 0
            };
        }

        if (raw.indexOf('v=') !== 0) {
            return null;
        }

        var data = { v: 0, necessary: 1, analytics: 0, media: 0, ts: 0 };
        raw.split('&').forEach(function (part) {
            var bits = part.split('=');
            var key = bits[0];
            var value = bits[1] || '';

            if (key === 'v' || key === 'ts') {
                data[key] = parseInt(value, 10) || 0;
            }

            if (key === 'analytics' || key === 'media' || key === 'necessary') {
                data[key] = value === '1' ? 1 : 0;
            }
        });

        data.necessary = 1;
        return data;
    }

    function current() {
        return parse(readRaw());
    }

    function write(state) {
        var value = 'v=' + VERSION
            + '&necessary=1'
            + '&analytics=' + (state.analytics ? 1 : 0)
            + '&media=' + (state.media ? 1 : 0)
            + '&ts=' + Date.now();
        var secure = window.location.protocol === 'https:' ? '; Secure' : '';
        document.cookie = COOKIE + '=' + encodeURIComponent(value) + '; Path=/; Max-Age=' + MAX_AGE + '; SameSite=Lax' + secure;
    }

    function isAnalyticsCookie(name) {
        return name === '_gid'
            || name === '_gat'
            || name.indexOf('_ga') === 0
            || name.indexOf('_gcl_') === 0
            || name.indexOf('_gac_') === 0;
    }

    function clearAnalyticsCookies() {
        var host = window.location.hostname;
        var domains = ['', host];
        var parts = host.split('.');

        if (parts.length > 1) {
            domains.push('.' + parts.slice(-2).join('.'));
        }

        document.cookie.split(';').forEach(function (item) {
            var name = item.split('=')[0].replace(/^\s+/, '');

            if (!isAnalyticsCookie(name)) {
                return;
            }

            domains.forEach(function (domain) {
                document.cookie = name + '=; Path=/; Max-Age=0' + (domain ? '; Domain=' + domain : '');
            });
        });
    }

    function loadAnalytics() {
        if (loaded) {
            return;
        }

        loaded = true;
        window.dataLayer = window.dataLayer || [];
        window.gtag = window.gtag || function () {
            window.dataLayer.push(arguments);
        };
        window.gtag('js', new Date());
        window.gtag('set', 'cookie_expires', GA_COOKIE_SECONDS);

        var script = document.createElement('script');
        script.async = true;
        script.src = 'https://www.googletagmanager.com/gtm.js?id=' + GTM_ID;
        document.head.appendChild(script);
    }

    function buildPlaceholder(node) {
        var title = node.getAttribute('data-cookie-title') || 'ce contenu';
        var box = document.createElement('div');
        var text = document.createElement('p');
        var button = document.createElement('button');

        box.className = 'cookie-embed';
        box.setAttribute('data-cookie-placeholder', '');
        text.textContent = title + ' est fourni par un autre site et peut déposer des cookies. Il reste masqué sans votre accord.';
        button.type = 'button';
        button.className = 'btn btn--primary';
        button.setAttribute('data-cookie-embed-accept', '');
        button.textContent = 'Autoriser et afficher';
        box.appendChild(text);
        box.appendChild(button);
        node.appendChild(box);
        return box;
    }

    function renderEmbeds() {
        var allowed = !!(current() && current().media);

        document.querySelectorAll('[data-cookie-embed]').forEach(function (node) {
            var src = node.getAttribute('data-cookie-src');
            var placeholder = node.querySelector('[data-cookie-placeholder]');
            var frame = node.querySelector('iframe');

            if (allowed && src) {
                if (!frame) {
                    frame = document.createElement('iframe');
                    frame.src = src;
                    frame.title = node.getAttribute('data-cookie-title') || 'Contenu externe';
                    frame.loading = 'lazy';
                    frame.referrerPolicy = 'strict-origin-when-cross-origin';
                    node.appendChild(frame);
                }

                if (placeholder) {
                    placeholder.hidden = true;
                }
                return;
            }

            if (frame) {
                frame.remove();
            }

            if (!placeholder) {
                placeholder = buildPlaceholder(node);
            }

            placeholder.hidden = false;
        });
    }

    function notify(state) {
        listeners.forEach(function (fn) {
            fn(state);
        });
    }

    function setInert(on) {
        Array.prototype.forEach.call(document.body.children, function (node) {
            if (node === banner || node.nodeType !== 1) {
                return;
            }

            if (node.tagName === 'SCRIPT' || node.tagName === 'STYLE' || node.tagName === 'LINK') {
                return;
            }

            if (on) {
                node.setAttribute('inert', '');
            } else {
                node.removeAttribute('inert');
            }
        });
    }

    function showView(name) {
        if (viewChoice) {
            viewChoice.hidden = name !== 'choice';
        }

        if (viewDetails) {
            viewDetails.hidden = name !== 'details';
        }

        var view = banner.querySelector('[data-cookie-view="' + name + '"]');
        var title = view ? view.querySelector('h2') : null;
        var text = view ? view.querySelector('.cookie-banner__text') : null;

        banner.querySelectorAll('[id="cookie-banner-title"], [id="cookie-banner-text"]').forEach(function (node) {
            node.removeAttribute('id');
        });

        if (dialog && title) {
            title.id = 'cookie-banner-title';
            dialog.setAttribute('aria-labelledby', title.id);
        }

        if (dialog && text) {
            text.id = 'cookie-banner-text';
            dialog.setAttribute('aria-describedby', text.id);
        }
    }

    function syncInputs() {
        var state = current();

        if (analyticsInput) {
            analyticsInput.checked = !!(state && state.analytics);
        }

        if (mediaInput) {
            mediaInput.checked = !!(state && state.media);
        }
    }

    function openBanner(view, dismissible) {
        syncInputs();
        showView(view || 'choice');

        if (dismissible) {
            banner.setAttribute('data-cookie-dismissible', '');
        } else {
            banner.removeAttribute('data-cookie-dismissible');
        }

        banner.hidden = false;
        document.documentElement.classList.add('has-cookie-banner');
        setInert(true);

        if (dialog) {
            dialog.focus();
        }
    }

    function closeBanner() {
        banner.hidden = true;
        banner.removeAttribute('data-cookie-dismissible');
        document.documentElement.classList.remove('has-cookie-banner');
        setInert(false);
    }

    function save(next) {
        var previous = current();
        var state = {
            analytics: next.analytics ? 1 : 0,
            media: next.media ? 1 : 0
        };
        var withdraw = previous && (
            (previous.analytics && !state.analytics) ||
            (previous.media && !state.media)
        );

        write(state);

        if (!state.analytics) {
            clearAnalyticsCookies();
        }

        if (withdraw) {
            if (!state.analytics) {
                clearAnalyticsCookies();
            }
            window.location.reload();
            return;
        }

        closeBanner();

        if (state.analytics) {
            loadAnalytics();
        }

        renderEmbeds();
        notify(state);
    }

    function acceptAll() {
        save({ analytics: 1, media: 1 });
    }

    function refuseAll() {
        save({ analytics: 0, media: 0 });
    }

    function saveDetails() {
        save({
            analytics: analyticsInput && analyticsInput.checked,
            media: mediaInput && mediaInput.checked
        });
    }

    banner.querySelectorAll('[data-cookie-accept-all]').forEach(function (button) {
        button.addEventListener('click', acceptAll);
    });

    banner.querySelectorAll('[data-cookie-refuse-all]').forEach(function (button) {
        button.addEventListener('click', refuseAll);
    });

    var customize = banner.querySelector('[data-cookie-customize]');
    if (customize) {
        customize.addEventListener('click', function () {
            syncInputs();
            showView('details');
        });
    }

    var back = banner.querySelector('[data-cookie-back]');
    if (back) {
        back.addEventListener('click', function () {
            showView('choice');
            if (dialog) {
                dialog.focus();
            }
        });
    }

    var saveButton = banner.querySelector('[data-cookie-save]');
    if (saveButton) {
        saveButton.addEventListener('click', saveDetails);
    }

    document.addEventListener('click', function (event) {
        var embedAccept = event.target.closest('[data-cookie-embed-accept]');
        if (embedAccept) {
            event.preventDefault();
            var state = current() || { analytics: 0, media: 0 };
            save({ analytics: state.analytics, media: 1 });
            return;
        }

        var trigger = event.target.closest('[data-open-cookies]');
        if (!trigger) {
            return;
        }

        event.preventDefault();
        openBanner('details', !!current() || banner.hasAttribute('data-cookie-info'));
    });

    document.addEventListener('keydown', function (event) {
        if (banner.hidden) {
            return;
        }

        if (event.key === 'Escape') {
            if (banner.hasAttribute('data-cookie-dismissible')) {
                event.preventDefault();
                closeBanner();
            }
            return;
        }

        if (event.key !== 'Tab' || !dialog) {
            return;
        }

        var items = dialog.querySelectorAll('a[href], button:not([disabled]), input:not([disabled]), [tabindex]:not([tabindex="-1"])');
        var visible = [];

        Array.prototype.forEach.call(items, function (item) {
            if (item.closest('[hidden]')) {
                return;
            }
            visible.push(item);
        });

        if (!visible.length) {
            return;
        }

        var first = visible[0];
        var last = visible[visible.length - 1];

        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    });

    document.addEventListener('focusin', function (event) {
        if (banner.hidden || banner.contains(event.target)) {
            return;
        }

        if (dialog) {
            dialog.focus();
        }
    });

    window.acharpCookies = {
        allows: function (key) {
            var state = current();
            if (!state) {
                return false;
            }
            if (key === 'necessary') {
                return true;
            }
            return !!state[key];
        },
        frame: function (container, url, title) {
            if (!container || !url) {
                return;
            }

            container.setAttribute('data-cookie-embed', 'media');
            container.setAttribute('data-cookie-src', url);
            if (title) {
                container.setAttribute('data-cookie-title', title);
            }
            renderEmbeds();
        },
        open: function () {
            openBanner('details', !!current() || banner.hasAttribute('data-cookie-info'));
        },
        onChange: function (fn) {
            listeners.push(fn);
        }
    };

    var state = current();

    if (state && state.analytics) {
        loadAnalytics();
    } else {
        clearAnalyticsCookies();
    }

    renderEmbeds();

    if (!state && !banner.hasAttribute('data-cookie-info')) {
        openBanner('choice', false);
    }
})();
