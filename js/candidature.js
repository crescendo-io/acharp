(function () {
    'use strict';

    function onReady(fn) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn);
        } else {
            fn();
        }
    }

    onReady(function () {
    var config = window.acharpCandidature;
    var root = document.getElementById('candidature-modal');

    if (!config || !root) {
        return;
    }

    var form = root.querySelector('[data-candidature-form]');
    var alertBox = root.querySelector('[data-candidature-alert]');
    var stepLabel = document.getElementById('candidature-step-label');
    var panel1 = root.querySelector('[data-candidature-panel="1"]');
    var panel2 = root.querySelector('[data-candidature-panel="2"]');
    var success = root.querySelector('[data-candidature-success]');
    var successMessage = root.querySelector('[data-candidature-success-message]');
    var calendlyBox = root.querySelector('[data-candidature-calendly]');
    var actions = root.querySelector('[data-candidature-actions]');
    var submit = root.querySelector('[data-candidature-submit]');
    var lastFocus = null;
    var step = 1;
    var pending = false;
    var closeTimer = null;
    var reducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function qs(name) {
        return form.querySelector('[name="' + name + '"]');
    }

    function setAlert(message, isError) {
        if (!message) {
            alertBox.hidden = true;
            alertBox.textContent = '';
            return;
        }

        alertBox.hidden = false;
        alertBox.textContent = message;
        alertBox.classList.toggle('is-error', !!isError);
    }

    function fieldErrors(fields) {
        Array.prototype.forEach.call(form.querySelectorAll('[data-invalid]'), function (node) {
            node.removeAttribute('data-invalid');
        });

        Object.keys(fields || {}).forEach(function (name) {
            var input = form.querySelector('[name="' + name + '"], [name="' + name + '[]"], [data-file-field="' + name + '"]');

            if (input) {
                input.setAttribute('data-invalid', 'true');
            }
        });
    }

    function selectedFormation() {
        var checked = form.querySelector('[name="formation"]:checked');

        return checked ? checked.value : '';
    }

    function needsPortfolio(formation) {
        return config.needsPortfolio.indexOf(formation) !== -1;
    }

    function syncPortfolioRequired() {
        var required = needsPortfolio(selectedFormation());
        var wrap = root.querySelector('[data-file-field="portfolio"]');
        var input = wrap ? wrap.querySelector('input[type="file"]') : null;
        var label = wrap ? wrap.querySelector('[data-required-label]') : null;

        if (wrap) {
            wrap.classList.toggle('is-required', required);
        }

        if (input) {
            input.required = required;
        }

        if (label) {
            label.textContent = required ? 'Obligatoire' : 'Facultatif';
        }
    }

    function setProgress(current) {
        Array.prototype.forEach.call(root.querySelectorAll('[data-progress-step]'), function (item) {
            var index = parseInt(item.getAttribute('data-progress-step'), 10);
            item.classList.toggle('is-current', index === current);
            item.classList.toggle('is-done', index < current);
        });
    }

    function formatSize(bytes) {
        if (bytes < 1024) {
            return bytes + ' o';
        }

        if (bytes < 1048576) {
            return Math.round(bytes / 102.4) / 10 + ' Ko';
        }

        return Math.round(bytes / 104857.6) / 10 + ' Mo';
    }

    function renderFileField(wrap) {
        var input = wrap.querySelector('input[type="file"]');
        var list = wrap.querySelector('[data-file-list]');
        var files = input && input.files ? Array.prototype.slice.call(input.files) : [];

        wrap.classList.toggle('is-filled', files.length > 0);

        if (!list) {
            return;
        }

        list.innerHTML = '';
        list.hidden = files.length === 0;

        files.forEach(function (file, index) {
            var item = document.createElement('li');
            item.className = 'candidature-drop__file';
            item.innerHTML = '<span class="candidature-drop__file-name"></span><span class="candidature-drop__file-size"></span><button type="button" class="candidature-drop__remove" data-file-remove="' + index + '" aria-label="Retirer le fichier"></button>';
            item.querySelector('.candidature-drop__file-name').textContent = file.name;
            item.querySelector('.candidature-drop__file-size').textContent = formatSize(file.size);
            item.querySelector('[data-file-remove]').textContent = 'Retirer';
            list.appendChild(item);
        });
    }

    function assignFiles(input, files) {
        if (typeof DataTransfer === 'undefined') {
            return;
        }

        var transfer = new DataTransfer();
        var max = input.hasAttribute('multiple') ? 5 : 1;

        Array.prototype.slice.call(files, 0, max).forEach(function (file) {
            transfer.items.add(file);
        });

        input.files = transfer.files;
        renderFileField(input.closest('[data-file-field]'));
    }

    function setStep(next) {
        step = next;
        panel1.hidden = step !== 1;
        panel2.hidden = step !== 2;
        success.hidden = step !== 3;
        actions.hidden = step === 3;
        setProgress(Math.min(next, 2));

        if (step === 1) {
            stepLabel.textContent = 'Étape 1 sur 2 — Vos informations';
            submit.innerHTML = 'Continuer <span class="btn__icon" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 8h10M9.5 4.5 13 8l-3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>';
        } else if (step === 2) {
            stepLabel.textContent = 'Étape 2 sur 2 — Vos documents';
            submit.innerHTML = 'Envoyer le dossier <span class="btn__icon" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 8h10M9.5 4.5 13 8l-3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>';
            syncPortfolioRequired();
        } else {
            stepLabel.textContent = 'Candidature envoyée';
            setProgress(3);
        }
    }

    function trapFocus(event) {
        if (root.hidden || event.key !== 'Tab') {
            return;
        }

        var focusable = root.querySelectorAll('a[href], button:not([disabled]), input:not([disabled]), textarea, select, [tabindex]:not([tabindex="-1"])');
        var list = Array.prototype.filter.call(focusable, function (el) {
            return el.offsetParent !== null || el === document.activeElement;
        });

        if (!list.length) {
            return;
        }

        var first = list[0];
        var last = list[list.length - 1];

        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    }

    function hideModal() {
        root.hidden = true;
        document.body.classList.remove('has-candidature-modal');

        if (lastFocus && typeof lastFocus.focus === 'function') {
            lastFocus.focus();
        }
    }

    function openModal() {
        if (closeTimer) {
            window.clearTimeout(closeTimer);
            closeTimer = null;
        }

        lastFocus = document.activeElement;
        root.hidden = false;
        document.body.classList.add('has-candidature-modal');
        qs('issued_at').value = config.issuedAt;
        qs('issued_sig').value = config.issuedSig;
        setStep(qs('token').value ? 2 : 1);
        setAlert('', false);

        window.requestAnimationFrame(function () {
            window.requestAnimationFrame(function () {
                root.classList.add('is-open');
            });
        });

        var focusTarget = step === 2
            ? root.querySelector('[data-candidature-panel="2"] .candidature-drop__zone')
            : root.querySelector('#candidature-first-name');

        if (focusTarget) {
            focusTarget.focus();
        }
    }

    function closeModal() {
        root.classList.remove('is-open');

        if (reducedMotion) {
            hideModal();
            return;
        }

        closeTimer = window.setTimeout(hideModal, 320);
    }

    function isCandidatureTrigger(link) {
        var href = (link.getAttribute('href') || '').trim();
        var text = (link.textContent || '').replace(/\s+/g, ' ').trim().toLowerCase();

        return href === '#candidature'
            || link.hasAttribute('data-open-candidature')
            || ((href === '#' || href === '') && text.indexOf('candidater') !== -1);
    }

    function post(action, body) {
        return fetch(config.ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            body: body
        }).then(function (response) {
            return response.json().then(function (payload) {
                payload.status = response.status;
                return payload;
            });
        });
    }

    function showCalendly(url) {
        calendlyBox.hidden = false;
        calendlyBox.innerHTML = '';

        var frame = document.createElement('iframe');
        frame.src = url;
        frame.title = 'Prise de rendez-vous Calendly';
        frame.setAttribute('loading', 'lazy');
        calendlyBox.appendChild(frame);
    }

    form.addEventListener('change', function (event) {
        if (event.target.name === 'formation') {
            syncPortfolioRequired();
        }

        if (event.target.type === 'file') {
            renderFileField(event.target.closest('[data-file-field]'));
        }
    });

    form.addEventListener('click', function (event) {
        var remove = event.target.closest('[data-file-remove]');

        if (!remove) {
            return;
        }

        event.preventDefault();
        var wrap = remove.closest('[data-file-field]');
        var input = wrap.querySelector('input[type="file"]');
        var index = parseInt(remove.getAttribute('data-file-remove'), 10);
        var next = Array.prototype.filter.call(input.files, function (_, i) {
            return i !== index;
        });

        assignFiles(input, next);
    });

    Array.prototype.forEach.call(root.querySelectorAll('[data-file-field]'), function (wrap) {
        var input = wrap.querySelector('input[type="file"]');
        var zone = wrap.querySelector('.candidature-drop__zone');

        ['dragenter', 'dragover'].forEach(function (type) {
            wrap.addEventListener(type, function (event) {
                event.preventDefault();
                wrap.classList.add('is-dragover');
            });
        });

        ['dragleave', 'drop'].forEach(function (type) {
            wrap.addEventListener(type, function (event) {
                event.preventDefault();
                wrap.classList.remove('is-dragover');
            });
        });

        wrap.addEventListener('drop', function (event) {
            if (!event.dataTransfer || !event.dataTransfer.files.length) {
                return;
            }

            var incoming = Array.prototype.slice.call(event.dataTransfer.files);

            if (input.hasAttribute('multiple') && input.files.length) {
                incoming = Array.prototype.slice.call(input.files).concat(incoming);
            }

            assignFiles(input, incoming);
        });

        if (zone) {
            zone.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    input.click();
                }
            });
        }
    });

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        if (pending) {
            return;
        }

        pending = true;
        submit.disabled = true;
        setAlert('', false);
        fieldErrors({});

        var body = new FormData(form);
        body.set('action', step === 1 ? 'acharp_candidature_step1' : 'acharp_candidature_step2');
        body.set('nonce', config.nonce);

        post(body.get('action'), body)
            .then(function (payload) {
                if (!payload || !payload.success) {
                    var data = (payload && payload.data) || {};
                    fieldErrors(data.fields || {});
                    throw new Error(data.message || 'Une erreur est survenue.');
                }

                if (step === 1) {
                    qs('token').value = payload.data.token || '';
                    setAlert(payload.data.message || '', false);
                    setStep(2);
                    return;
                }

                setStep(3);
                successMessage.textContent = payload.data.message || 'Votre dossier est complet.';

                if (payload.data.calendly) {
                    showCalendly(payload.data.calendly);
                } else {
                    calendlyBox.hidden = true;
                    calendlyBox.innerHTML = '';
                }
            })
            .catch(function (error) {
                setAlert(error.message, true);
            })
            .then(function () {
                pending = false;
                submit.disabled = false;
            });
    });

    document.addEventListener('click', function (event) {
        var closer = event.target.closest('[data-candidature-close]');
        var link = event.target.closest('a');

        if (closer && root.contains(closer)) {
            event.preventDefault();
            closeModal();
            return;
        }

        if (link && isCandidatureTrigger(link)) {
            event.preventDefault();
            openModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !root.hidden) {
            closeModal();
        }

        trapFocus(event);
    });

    if (window.location.hash === '#candidature') {
        openModal();
    }
    });
})();
