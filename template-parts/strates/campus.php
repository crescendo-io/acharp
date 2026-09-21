<?php
$theme_uri = get_stylesheet_directory_uri();

$slides = array(
    array(
        'image' => 'vie-realisations.jpg',
        'alt'   => 'Exposition de maquettes réalisées par les étudiants',
    ),
    array(
        'image' => 'hero-atelier.jpg',
        'alt'   => 'Étudiants en atelier dans le nouveau campus',
    ),
    array(
        'image' => 'histoire-salon.jpg',
        'alt'   => 'Espace de travail lumineux du campus',
    ),
    array(
        'image' => 'vie-ateliers.jpg',
        'alt'   => 'Atelier de dessin et de projet',
    ),
);

$atouts = array(
    array(
        'label' => 'Un emplacement<br>idéal',
        'icon'  => '<path d="M14 12.4c0 4.6-6 10.1-6 10.1s-6-5.5-6-10.1a6 6 0 1 1 12 0Z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/><circle cx="8" cy="12.2" r="2.2" stroke="currentColor" stroke-width="1.3"/>',
    ),
    array(
        'label' => 'Accessible en<br>métro ou RER',
        'icon'  => '<rect x="2.6" y="2.6" width="10.8" height="13.4" rx="3.2" stroke="currentColor" stroke-width="1.3"/><path d="M2.6 11.4h10.8M5.6 19.4l2.4-3.4M10.4 19.4 8 16" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/><circle cx="5.6" cy="13.6" r="0.9" fill="currentColor"/><circle cx="10.4" cy="13.6" r="0.9" fill="currentColor"/>',
    ),
    array(
        'label' => 'Au cœur d’un quartier<br>vivant et dynamique',
        'icon'  => '<path d="M2.6 19.4V7.2l5.2-2.6v14.8M7.8 19.4h5.6V10L7.8 7.6" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/><path d="M4.8 9.6v1.2M4.8 13v1.2M10.4 12.4v1.2M10.4 15.6v1.2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/>',
    ),
);
?>

<section class="campus">
    <div class="campus__grid">
        <div class="campus__content">
            <div class="campus__inner">
                <p class="campus__kicker">Le campus</p>

                <h2 class="campus__title">
                    Un nouveau campus<br>
                    <strong>au cœur de Paris</strong>
                </h2>

                <p class="campus__text">
                    Depuis la rentrée 2025, l’Académie Charpentier accueille ses étudiants dans un
                    nouveau campus moderne installé sur la Rive Gauche, au cœur du 15<sup>e</sup>
                    arrondissement de Paris – un quartier vivant, entre la Seine et la Tour Eiffel, offrant
                    un cadre inspirant et connecté à la vie urbaine.
                </p>

                <ul class="campus__atouts">
                    <?php foreach ($atouts as $atout) : ?>
                        <li class="campus__atout">
                            <span class="campus__atout-icon" aria-hidden="true">
                                <svg width="16" height="22" viewBox="0 0 16 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <?= $atout['icon']; ?>
                                </svg>
                            </span>
                            <span class="campus__atout-label"><?= $atout['label']; ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="campus__slider" data-autoplay="5000" aria-roledescription="carrousel" aria-label="Photos du campus">
            <div class="campus__track">
                <?php foreach ($slides as $index => $slide) : ?>
                    <figure class="campus__slide" aria-roledescription="diapositive" aria-label="<?= ($index + 1); ?> sur <?= count($slides); ?>">
                        <img
                            src="<?= esc_url($theme_uri . '/images/' . $slide['image']); ?>"
                            alt="<?= esc_attr($slide['alt']); ?>"
                            width="1200"
                            height="800"
                            loading="lazy"
                        >
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
