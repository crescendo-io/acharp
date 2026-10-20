<?php
$theme_uri = get_stylesheet_directory_uri();

$arrow = '<span class="site-footer__arrow" aria-hidden="true">
    <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M1 6h15M11.5 1.5 16.5 6l-5 4.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</span>';

$raccourcis = array(
    array(
        'title' => 'Candidater',
        'text'  => 'Rejoignez-nous dès maintenant',
        'url'   => '#candidature',
    ),
    array(
        'title' => 'Recevoir la brochure',
        'text'  => 'Toutes les infos dans votre boîte mail',
    ),
    array(
        'title' => 'Nous contacter',
        'text'  => 'Une question ? Écrivez-nous.',
        'url'   => home_url('/contact/'),
    ),
);

$formation_links = array();

foreach (acharp_query_catalog_cursus() as $cursus_post) {
    $formation_links[] = array(
        'label' => get_the_title($cursus_post),
        'url'   => get_permalink($cursus_post),
    );
}

if (!$formation_links) {
    $formation_links = array(
        array('label' => 'Bachelor – Bac +3', 'url' => get_post_type_archive_link('cursus') ?: '#'),
        array('label' => 'Formation Bac +5', 'url' => get_post_type_archive_link('cursus') ?: '#'),
    );
}

$colonnes = array(
    array(
        'title' => 'L’école',
        'links' => array(
            array('label' => 'L’Académie', 'url' => home_url('/lacademie/')),
            array('label' => 'Pédagogie', 'url' => home_url('/lacademie/#pedagogie')),
            array('label' => 'Campus', 'url' => home_url('/lacademie/#campus')),
        ),
    ),
    array(
        'title' => 'Formations',
        'links' => $formation_links,
    ),
    array(
        'title' => 'Admissions',
        'links' => array(
            array('label' => 'Candidater', 'url' => '#candidature'),
            array('label' => 'Frais de scolarité', 'url' => home_url('/admissions/#tarifs')),
            array('label' => 'Contact', 'url' => home_url('/contact/')),
        ),
    ),
    array(
        'title' => 'Partenariats',
        'links' => array(
            array('label' => 'Nos partenariats', 'url' => home_url('/partenariats/')),
            array('label' => 'International', 'url' => home_url('/partenariats/#international')),
        ),
    ),
    array(
        'title' => 'Vie de l’école',
        'links' => array(
            array('label' => 'Vie de l’école', 'url' => home_url('/vie-de-lecole/')),
            array('label' => 'Alumni', 'url' => home_url('/realisations-diplomes/')),
        ),
    ),
    array(
        'title' => 'Actualités<br>&amp; évènements',
        'links' => array(
            array('label' => 'Actualités', 'url' => get_post_type_archive_link('actualite') ?: '#'),
        ),
    ),
);

$social_urls = acharp_social_links();
$reseaux = array(
    array(
        'label'       => 'Facebook',
        'aria_label'  => 'Facebook',
        'viewBox'     => '0 0 24 24',
        'path'        => '<path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>',
    ),
    array(
        'label'       => 'X',
        'aria_label'  => 'X',
        'viewBox'     => '0 0 24 24',
        'path'        => '<path fill="currentColor" d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z"/>',
    ),
    array(
        'label'       => 'Instagram',
        'aria_label'  => 'Instagram',
        'viewBox'     => '0 0 24 24',
        'path'        => '<path fill="currentColor" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>',
    ),
);

$legales = array('Mentions légales', 'Politique de confidentialité', 'Gestion des cookies', 'Plan du site');
?>

<footer class="site-footer">
    <div class="site-footer__cta">
        <span class="site-footer__shape site-footer__shape--orange" aria-hidden="true"></span>
        <span class="site-footer__shape site-footer__shape--pink" aria-hidden="true"></span>
        <span class="site-footer__shape site-footer__shape--green" aria-hidden="true"></span>

        <div class="site-footer__inner site-footer__cta-inner">
            <p class="site-footer__baseline">
                Prêt à construire<br>
                votre avenir <strong>créatif</strong> ?
            </p>

            <ul class="site-footer__shortcuts">
                <?php foreach ($raccourcis as $raccourci) : ?>
                    <li class="site-footer__shortcut">
                        <a href="<?= esc_url($raccourci['url'] ?? '#'); ?>" class="site-footer__shortcut-link"<?= !empty($raccourci['url']) && $raccourci['url'] === '#candidature' ? ' data-open-candidature' : ''; ?>>
                            <?= $raccourci['title']; ?>
                            <?= $arrow; ?>
                        </a>
                        <p class="site-footer__shortcut-text"><?= $raccourci['text']; ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="site-footer__main">
        <div class="site-footer__inner site-footer__main-inner">
            <div class="site-footer__identity">
                <a href="<?= esc_url(home_url('/')); ?>" class="site-footer__brand" aria-label="Académie Charpentier, retour à l’accueil">
                    <img
                        class="site-footer__mark"
                        src="<?= esc_url($theme_uri . '/images/logo-acharp-mark-white.png'); ?>"
                        alt=""
                        width="240"
                        height="73"
                    >
                    <span class="site-footer__wordmark">
                        Académie<br>
                        Charpentier
                    </span>
                </a>

                <address class="site-footer__address">
                    50 Rue Sébastien Mercier,<br>
                    75015 Paris
                </address>

                <a href="tel:+33143543112" class="site-footer__phone">01 43 54 31 12</a>

                <ul class="site-footer__socials">
                    <?php foreach ($reseaux as $reseau) : ?>
                        <?php $social_url = $social_urls[$reseau['label']] ?? '#'; ?>
                        <li>
                            <a href="<?= esc_url($social_url); ?>" class="site-footer__social" aria-label="<?= esc_attr($reseau['aria_label'] ?? $reseau['label']); ?>" target="_blank" rel="noopener">
                                <svg width="20" height="20" viewBox="<?= esc_attr($reseau['viewBox'] ?? '0 0 20 20'); ?>" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <?= $reseau['path']; ?>
                                </svg>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <nav class="site-footer__nav" aria-label="Plan du site">
                <?php foreach ($colonnes as $colonne) : ?>
                    <div class="site-footer__col">
                        <p class="site-footer__col-title"><?= $colonne['title']; ?></p>
                        <ul class="site-footer__list">
                            <?php foreach ($colonne['links'] as $link) : ?>
                                <?php
                                $label = is_array($link) ? ($link['label'] ?? '') : $link;
                                $url   = is_array($link) ? ($link['url'] ?? '#') : '#';
                                ?>
                                <li>
                                    <a
                                        href="<?= esc_url($url); ?>"
                                        class="site-footer__link"
                                        <?= $url === '#candidature' ? ' data-open-candidature' : ''; ?>
                                    ><?= esc_html($label); ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </nav>
        </div>

        <div class="site-footer__inner site-footer__legal">
            <ul class="site-footer__legal-list">
                <?php foreach ($legales as $legale) : ?>
                    <li><a href="#" class="site-footer__legal-link"><?= $legale; ?></a></li>
                <?php endforeach; ?>
            </ul>

            <a href="#" class="site-footer__top" aria-label="Revenir en haut de page">
                <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M1 6h15M11.5 1.5 16.5 6l-5 4.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
    </div>
</footer>
