<?php
$theme_uri = get_stylesheet_directory_uri();

$stats = array(
    array(
        'value' => '100/100',
        'text'  => 'Taux de présentation et réussite au <strong>Bachelor</strong><br>Année 2023 – 2024',
    ),
    array(
        'value' => '100/100',
        'text'  => 'Taux de présentation et réussite au <strong>Bachelor</strong><br>Année 2024 – 2025',
    ),
    array(
        'value' => '100/100',
        'text'  => 'Taux de présentation et réussite en 5ème année<br>Année 2025 – 2026',
    ),
);
?>

<section class="diplome">
    <div class="container-fluid">
        <div class="diplome__grid">
            <div class="diplome__content">
                <p class="diplome__kicker">Un diplôme reconnu</p>

                <h2 class="diplome__title">
                    Un tremplin vers <strong>votre avenir</strong>
                </h2>

                <p class="diplome__text">
                    À l’issue de ce programme, les étudiants obtiennent le Bachelor d’architecture
                    intérieure délivré par l’Académie Charpentier, et selon le niveau atteint, peuvent
                    poursuivre le cursus <strong>d’architecture intérieure</strong> afin de préparer le
                    <strong>diplôme d’Architecte d’intérieur, Titre RNCP 38011 niveau 7 certifié par l’État.</strong>
                </p>

                <div class="diplome__stats">
                    <?php foreach ($stats as $stat) : ?>
                        <article class="diplome__stat">
                            <p class="diplome__stat-value"><?= $stat['value']; ?></p>
                            <p class="diplome__stat-text"><?= $stat['text']; ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>

            <figure class="diplome__media">
                <img
                    src="<?= esc_url($theme_uri . '/images/vie-realisations.jpg'); ?>"
                    alt="Visite d’une exposition de projets étudiants à l’Académie Charpentier"
                    loading="lazy"
                >
            </figure>
        </div>
    </div>
</section>
