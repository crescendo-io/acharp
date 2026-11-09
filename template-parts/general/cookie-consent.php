<?php
$cookie_policy_url = home_url('/politique-de-cookies/');
$cookie_info_page  = is_page_template('page-politique-cookies.php') || is_page_template('page-politique-confidentialite.php');
?>
<div class="cookie-banner" data-cookie-banner<?= $cookie_info_page ? ' data-cookie-info' : ''; ?> hidden>
    <div class="cookie-banner__dialog" role="dialog" aria-modal="true" aria-labelledby="cookie-banner-title" aria-describedby="cookie-banner-text" tabindex="-1">
        <div data-cookie-view="choice">
            <p class="cookie-banner__kicker">Confidentialité</p>
            <h2 id="cookie-banner-title" class="cookie-banner__title">Choisissez vos cookies</h2>
            <p id="cookie-banner-text" class="cookie-banner__text">
                L’Académie Charpentier, 50 rue Sébastien Mercier, 75015 Paris, dépose des cookies nécessaires au fonctionnement du site.
                Avec votre accord seulement, le site mesure son audience (Google Analytics, via Google Tag Manager) et affiche des contenus externes (carte OpenStreetMap, rendez-vous Calendly).
                Refuser ne change rien à la consultation des pages, ni à une candidature.
            </p>
            <p class="cookie-banner__note">
                Le choix est conservé six mois sur cet appareil. Il se modifie à tout moment avec « Gestion des cookies », en bas de page.
                <a href="<?= esc_url($cookie_policy_url); ?>">Lire la politique de cookies</a>.
                <a href="<?= esc_url(home_url('/politique-de-confidentialite/')); ?>">Politique de confidentialité</a>
            </p>
            <div class="cookie-banner__actions">
                <button type="button" class="btn cookie-banner__btn" data-cookie-refuse-all>Tout refuser</button>
                <button type="button" class="btn cookie-banner__btn cookie-banner__btn--ghost" data-cookie-customize>Personnaliser</button>
                <button type="button" class="btn cookie-banner__btn" data-cookie-accept-all>Tout accepter</button>
            </div>
        </div>

        <div data-cookie-view="details" hidden>
            <p class="cookie-banner__kicker">Confidentialité</p>
            <h2 class="cookie-banner__title">Détail des cookies</h2>
            <p class="cookie-banner__text">Chaque finalité est séparée. Rien n’est coché à l’avance. « Enregistrer » ne dépose que ce que vous avez activé.</p>

            <div class="cookie-banner__option">
                <div>
                    <p class="cookie-banner__option-title">Nécessaires</p>
                    <p class="cookie-banner__option-text">Mémorisent uniquement votre décision. Le site ne peut pas s’en passer, ils ne se désactivent pas.</p>
                    <ul class="cookie-banner__cookies">
                        <li><strong>acharp_consent</strong> — Académie Charpentier — 6 mois</li>
                    </ul>
                </div>
                <input type="checkbox" checked disabled aria-label="Cookies nécessaires, toujours actifs">
            </div>

            <label class="cookie-banner__option">
                <span>
                    <span class="cookie-banner__option-title">Mesure d’audience</span>
                    <span class="cookie-banner__option-text">Comprend combien de personnes consultent le site et quelles pages. Pas de publicité, pas de revente de données. Google peut transférer ces données aux États-Unis.</span>
                    <ul class="cookie-banner__cookies">
                        <li><strong>_ga</strong>, <strong>_ga_…</strong> — Google — 13 mois maximum</li>
                        <li><strong>_gid</strong> — Google — 24 heures</li>
                    </ul>
                </span>
                <input type="checkbox" data-cookie-analytics>
            </label>

            <label class="cookie-banner__option">
                <span>
                    <span class="cookie-banner__option-title">Contenus externes</span>
                    <span class="cookie-banner__option-text">Autorise la carte OpenStreetMap sur la page Contact et le calendrier Calendly après un message ou une candidature. Sans cet accord, ces blocs restent masqués. Le formulaire, lui, part quand même.</span>
                    <ul class="cookie-banner__cookies">
                        <li><strong>Cookies OpenStreetMap</strong> — openstreetmap.org — le temps de l’affichage de la carte</li>
                        <li><strong>Cookies Calendly</strong> — calendly.com — le temps de la prise de rendez-vous</li>
                    </ul>
                </span>
                <input type="checkbox" data-cookie-media>
            </label>

            <p class="cookie-banner__note">
                <a href="<?= esc_url($cookie_policy_url); ?>">Politique de cookies</a>
                — finalités, durées, destinataires et droits.
            </p>
            <button type="button" class="cookie-banner__back" data-cookie-back>Retour</button>
            <div class="cookie-banner__actions">
                <button type="button" class="btn cookie-banner__btn" data-cookie-refuse-all>Tout refuser</button>
                <button type="button" class="btn cookie-banner__btn cookie-banner__btn--ghost" data-cookie-save>Enregistrer</button>
                <button type="button" class="btn cookie-banner__btn" data-cookie-accept-all>Tout accepter</button>
            </div>
        </div>
    </div>
</div>
