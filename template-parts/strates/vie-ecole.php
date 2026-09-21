<?php
$theme_uri = get_stylesheet_directory_uri();

$vignettes = array(
    array(
        'image' => 'vie-ateliers.jpg',
        'label' => 'Ateliers &amp; projets',
        'alt'   => 'Étudiants en atelier de maquette',
        'width' => 1600,
        'height' => 1224,
    ),
    array(
        'image' => 'vie-evenements.jpg',
        'label' => 'Évènements',
        'alt'   => 'Étudiants réunis lors d’un évènement de l’école',
        'width' => 1600,
        'height' => 1067,
    ),
    array(
        'image' => 'vie-temoignages.jpg',
        'label' => 'Témoignages',
        'alt'   => 'Étudiante présentant ses planches de projet',
        'width' => 1600,
        'height' => 2400,
    ),
    array(
        'image' => 'vie-realisations.jpg',
        'label' => 'Réalisations',
        'alt'   => 'Maquette d’architecture réalisée par les étudiants',
        'width' => 1600,
        'height' => 2400,
    ),
);
?>

<section class="vie-ecole">
    <div class="vie-ecole__grid">
        <div class="vie-ecole__intro">
            <div class="vie-ecole__content">
                <p class="vie-ecole__kicker">Vie à l’école</p>
                <h2 class="vie-ecole__title">
                    Découvrez l’univers<br>
                    <strong>Charpentier</strong>
                </h2>
                <a href="#" class="btn btn--light">
                    Découvrir l’académie
                    <span class="btn__icon" aria-hidden="true">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 8h10M9.5 4.5 13 8l-3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </a>
            </div>
        </div>

        <?php foreach ($vignettes as $vignette) : ?>
            <a href="#" class="vie-ecole__tile">
                <img
                    src="<?= esc_url($theme_uri . '/images/' . $vignette['image']); ?>"
                    alt="<?= esc_attr($vignette['alt']); ?>"
                    width="<?= esc_attr($vignette['width']); ?>"
                    height="<?= esc_attr($vignette['height']); ?>"
                >
                <span class="vie-ecole__tile-label"><?= $vignette['label']; ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</section>
