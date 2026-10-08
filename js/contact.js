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
        var config = window.acharpContact;
        var form = document.querySelector('[data-contact-form]');

        if (!config || !form) {
            return;
        }

        var alertBox = form.querySelector('[data-contact-alert]');
        var fields = form.querySelector('[data-contact-fields]');
        var success = form.querySelector('[data-contact-success]');
        var successMessage = form.querySelector('[data-contact-success-message]');
        var calendlyBox = form.querySelector('[data-contact-calendly]');
        var actions = form.querySelector('[data-contact-actions]');
        var submit = form.querySelector('[data-contact-submit]');
        var pending = false;

        function qs(name) {
            return form.querySelector('[name="' + name + '"]');
        }

        qs('issued_at').value = config.issuedAt;
        qs('issued_sig').value = config.issuedSig;
        qs('page_id').value = String(config.pageId);

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

        function fieldErrors(map) {
            Array.prototype.forEach.call(form.querySelectorAll('[data-invalid]'), function (node) {
                node.removeAttribute('data-invalid');
            });

            Object.keys(map || {}).forEach(function (name) {
                var input = form.querySelector('[name="' + name + '"]');

                if (input) {
                    input.setAttribute('data-invalid', 'true');
                }
            });
        }

        function showCalendly(url) {
            if (!calendlyBox || !url || url.indexOf('https://') !== 0) {
                return;
            }

            try {
                var host = new URL(url).hostname;
                if (!/(^|\.)calendly\.com$/i.test(host)) {
                    return;
                }
            } catch (error) {
                return;
            }

            calendlyBox.hidden = false;
            calendlyBox.innerHTML = '';

            var frame = document.createElement('iframe');
            frame.src = url;
            frame.title = 'Planifier une visite';
            frame.setAttribute('loading', 'lazy');
            calendlyBox.appendChild(frame);
        }

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
            body.set('action', 'acharp_contact_send');
            body.set('nonce', config.nonce);

            fetch(config.ajaxUrl, {
                method: 'POST',
                credentials: 'same-origin',
                body: body
            }).then(function (response) {
                return response.json().then(function (payload) {
                    payload.status = response.status;
                    return payload;
                });
            }).then(function (payload) {
                if (!payload || !payload.success) {
                    var data = (payload && payload.data) || {};
                    fieldErrors(data.fields || {});
                    throw new Error(data.message || 'Une erreur est survenue.');
                }

                fields.hidden = true;
                actions.hidden = true;
                success.hidden = false;
                successMessage.textContent = payload.data.message || 'Votre message a bien été envoyé.';
                setAlert('', false);

                if (payload.data.calendly) {
                    showCalendly(payload.data.calendly);
                }
            }).catch(function (error) {
                setAlert(error.message, true);
            }).then(function () {
                pending = false;
                submit.disabled = false;
            });
        });
    });
})();
