<?php
$theme_uri = get_stylesheet_directory_uri();

$menu = array(
    array('label' => 'L’école', 'url' => '#'),
    array('label' => 'Formations', 'url' => '#'),
    array('label' => 'Admissions', 'url' => '#'),
    array('label' => 'International', 'url' => '#'),
    array('label' => 'Vie de l’école', 'url' => '#'),
    array('label' => 'Actualités &amp; évènements', 'url' => '#'),
    array('label' => 'Contact', 'url' => '#'),
);
?>

<header class="site-header">
    <div class="site-header__inner">
        <a href="<?= esc_url(home_url('/')); ?>" class="site-header__brand" aria-label="Académie Charpentier, retour à l’accueil">
            <img
                class="site-header__mark"
                src="<?= esc_url($theme_uri . '/images/logo-acharp-mark.png'); ?>"
                alt=""
                width="240"
                height="73"
            >
            <span class="site-header__wordmark">
                Académie<br>
                Charpentier
            </span>
        </a>

        <button type="button" class="site-header__burger" aria-expanded="false" aria-controls="site-nav" aria-label="Ouvrir le menu">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </button>

        <nav class="site-header__nav" id="site-nav" aria-label="Navigation principale">
            <ul class="site-header__menu">
                <?php foreach ($menu as $item) : ?>
                    <li class="site-header__item">
                        <a href="<?= esc_url($item['url']); ?>" class="site-header__link"><?= $item['label']; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <div class="site-header__actions">
            <button type="button" class="site-header__lang" aria-expanded="false">
                <span class="site-header__flag" aria-hidden="true">
                    <svg width="18" height="12" viewBox="0 0 18 12" xmlns="http://www.w3.org/2000/svg">
                        <rect width="6" height="12" fill="#0055a4"/>
                        <rect x="6" width="6" height="12" fill="#ffffff"/>
                        <rect x="12" width="6" height="12" fill="#ef4135"/>
                    </svg>
                </span>
                FR
                <svg class="site-header__chevron" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="m2.5 4 2.5 2.5L7.5 4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <a href="#" class="btn btn--primary site-header__cta">
                Candidater
                <span class="btn__icon" aria-hidden="true">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 8h10M9.5 4.5 13 8l-3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </a>
        </div>
    </div>
</header>
