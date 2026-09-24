<?php
$theme_uri = get_stylesheet_directory_uri();
$kicker    = get_field('campus_kicker') ?: 'Le campus';
$title     = acharp_inline_html(get_field('campus_title'));
$text      = acharp_inline_html(get_field('campus_text'));
$atouts    = acharp_rows(get_field('campus_atouts'));
$slides    = acharp_rows(get_field('campus_slides'));

if (!$title) {
    $title = 'Un nouveau campus<br> <strong>au cœur de Paris</strong>';
}

if (!$text) {
    $text = 'Depuis la rentrée 2025, l’Académie Charpentier accueille ses étudiants dans un nouveau campus moderne installé sur la Rive Gauche, au cœur du 15<sup>e</sup> arrondissement de Paris – un quartier vivant, entre la Seine et la Tour Eiffel, offrant un cadre inspirant et connecté à la vie urbaine.';
}

if (!$atouts) {
    $atouts = array(
        array('icon' => 'pin', 'label' => 'Un emplacement<br>idéal'),
        array('icon' => 'metro', 'label' => 'Accessible en<br>métro ou RER'),
        array('icon' => 'city', 'label' => 'Au cœur d’un quartier<br>vivant et dynamique'),
    );
}

if (!$slides) {
    $slides = array(
        array('image' => 0, 'fallback' => array('src' => $theme_uri . '/images/vie-realisations.jpg', 'alt' => 'Exposition de maquettes réalisées par les étudiants', 'width' => 1200, 'height' => 800)),
        array('image' => 0, 'fallback' => array('src' => $theme_uri . '/images/hero-atelier.jpg', 'alt' => 'Étudiants en atelier dans le nouveau campus', 'width' => 1200, 'height' => 800)),
        array('image' => 0, 'fallback' => array('src' => $theme_uri . '/images/histoire-salon.jpg', 'alt' => 'Espace de travail lumineux du campus', 'width' => 1200, 'height' => 800)),
        array('image' => 0, 'fallback' => array('src' => $theme_uri . '/images/vie-ateliers.jpg', 'alt' => 'Atelier de dessin et de projet', 'width' => 1200, 'height' => 800)),
    );
}
?>

<section id="campus" class="campus">
    <div class="campus__grid">
        <div class="campus__content">
            <div class="campus__inner">
                <?php if ($kicker) : ?>
                    <p class="campus__kicker"><?= esc_html($kicker); ?></p>
                <?php endif; ?>

                <h2 class="campus__title"><?= $title; ?></h2>

                <?php if ($text) : ?>
                    <p class="campus__text"><?= $text; ?></p>
                <?php endif; ?>

                <ul class="campus__atouts">
                    <?php foreach ($atouts as $atout) : ?>
                        <li class="campus__atout">
                            <span class="campus__atout-icon" aria-hidden="true">
                                <?= acharp_icon($atout['icon'] ?? 'pin', 'campus'); ?>
                            </span>
                            <span class="campus__atout-label"><?= acharp_inline_html($atout['label'] ?? ''); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="campus__slider" data-autoplay="5000" aria-roledescription="carrousel" aria-label="Photos du campus">
            <div class="campus__track">
                <?php foreach ($slides as $index => $slide) : ?>
                    <figure class="campus__slide" aria-roledescription="diapositive" aria-label="<?= ($index + 1); ?> sur <?= count($slides); ?>">
                        <?= acharp_image_html($slide['image'] ?? 0, 'large', $slide['fallback'] ?? array()); ?>
                    </figure>
                <?php endforeach; ?>
            </div>

            <div class="campus__nav">
                <button type="button" class="campus__arrow campus__arrow--prev" aria-label="Photo précédente">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M9.5 3.5 5 8l4.5 4.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <button type="button" class="campus__arrow campus__arrow--next" aria-label="Photo suivante">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M6.5 3.5 11 8l-4.5 4.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>
