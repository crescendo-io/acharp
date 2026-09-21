<?php
$theme_uri = get_stylesheet_directory_uri();
$arrow = '<span class="actualites__arrow" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 8h10M9.5 4.5 13 8l-3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>';

$actualites = array(
    array(
        'image'  => 'push-portes-ouvertes.jpg',
        'alt'    => 'Étudiants réunis lors d’une journée porte ouverte',
        'date'   => '2024-05-24',
        'label'  => '24 mai 2024',
        'title'  => 'Journée porte ouverte',
        'text'   => 'Rencontrez nos équipes et découvrez nos formations et nos ateliers.',
    ),
    array(
        'image'  => 'vie-temoignages.jpg',
        'alt'    => 'Intervenante présentant ses planches lors d’une conférence',
        'date'   => '2024-05-24',
        'label'  => '24 mai 2024',
        'title'  => 'Conférence',
        'text'   => 'Une conférence ouverte au public avec des architectes invités.',
    ),
    array(
        'image'  => 'formation-master.jpg',
        'alt'    => 'Maquettes exposées dans des vitrines éclairées',
        'date'   => '2024-05-24',
        'label'  => '24 mai 2024',
        'title'  => 'Exposition',
        'text'   => 'Découvrez les projets de fin d’année de nos étudiants.',
    ),
);
?>

<section class="actualites">
    <div class="container-fluid">
        <div class="actualites__header">
            <div class="actualites__intro">
                <p class="actualites__kicker">Actualités &amp; évènements</p>
                <h2 class="actualites__title">
                    Restez <strong>informé</strong>
                </h2>
            </div>
            <a href="#" class="actualites__all">
                Voir toutes nos actualités
                <?= $arrow; ?>
            </a>
        </div>

        <div class="row">
            <?php foreach ($actualites as $actualite) : ?>
                <div class="col-12 col-lg-4">
                    <article class="actualites__card">
                        <a href="#" class="actualites__link">
                            <figure class="actualites__media">
                                <img
                                    src="<?= esc_url($theme_uri . '/images/' . $actualite['image']); ?>"
                                    alt="<?= esc_attr($actualite['alt']); ?>"
                                    width="800"
                                    height="800"
                                >
                            </figure>
                            <div class="actualites__body">
                                <time class="actualites__date" datetime="<?= esc_attr($actualite['date']); ?>"><?= $actualite['label']; ?></time>
                                <h3 class="actualites__name"><?= $actualite['title']; ?></h3>
                                <p class="actualites__text"><?= $actualite['text']; ?></p>
                            </div>
                        </a>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
