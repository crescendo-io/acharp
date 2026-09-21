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
    ),
    array(
        'title' => 'Recevoir la brochure',
        'text'  => 'Toutes les infos dans votre boîte mail',
    ),
    array(
        'title' => 'Nous contacter',
        'text'  => 'Une question ? Écrivez-nous.',
    ),
);

$colonnes = array(
    array(
        'title' => 'L’école',
        'links' => array('Histoire', 'Pédagogie', 'Équipe', 'Campus'),
    ),
    array(
        'title' => 'Formations',
        'links' => array('Prépa artistique', 'Bachelor', 'Master'),
    ),
    array(
        'title' => 'Admissions',
        'links' => array('Modalités d’admission', 'Candidater', 'Frais de scolarité', 'Financement', 'FAQ'),
    ),
    array(
        'title' => 'International',
        'links' => array('Admissions internationales', 'Informations pratiques', 'Vivre à Paris'),
    ),
    array(
        'title' => 'Vie de l’école',
        'links' => array('Projets & étudiants', 'Témoignages', 'Alumni'),
    ),
    array(
        'title' => 'Actualités<br>&amp; évènements',
        'links' => array('Actualités', 'Évènements'),
    ),
);

$reseaux = array(
    array(
        'label' => 'Instagram',
        'path'  => '<rect x="3" y="3" width="14" height="14" rx="4" stroke="currentColor" stroke-width="1.4"/><circle cx="10" cy="10" r="3.4" stroke="currentColor" stroke-width="1.4"/><circle cx="14.4" cy="5.6" r="1" fill="currentColor"/>',
    ),
    array(
        'label' => 'LinkedIn',
        'path'  => '<rect x="3" y="3" width="14" height="14" rx="2" stroke="currentColor" stroke-width="1.4"/><path d="M6.6 8.4v5.2M6.6 6.2v.6M9.8 13.6V8.4M9.8 10.6c0-1.2.8-2.2 2-2.2s1.8.9 1.8 2.2v3" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>',
    ),
    array(
        'label' => 'YouTube',
        'path'  => '<rect x="2.5" y="5" width="15" height="10" rx="3" stroke="currentColor" stroke-width="1.4"/><path d="m8.6 7.8 4.2 2.2-4.2 2.2V7.8Z" fill="currentColor"/>',
    ),
    array(
        'label' => 'Facebook',
        'path'  => '<rect x="3" y="3" width="14" height="14" rx="2" stroke="currentColor" stroke-width="1.4"/><path d="M12.6 7.2h-1.2c-.8 0-1.3.5-1.3 1.3V17M8.4 10.6h3.6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>',
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
                        <a href="#" class="site-footer__shortcut-link">
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
                        <li>
                            <a href="#" class="site-footer__social" aria-label="<?= esc_attr($reseau['label']); ?>">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
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
                                <li><a href="#" class="site-footer__link"><?= $link; ?></a></li>
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
