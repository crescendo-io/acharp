<?php
$theme_uri = get_stylesheet_directory_uri();
$kicker    = get_field('diplome_kicker') ?: 'Un diplôme reconnu';
$title     = acharp_inline_html(get_field('diplome_title'));
$text      = acharp_inline_html(get_field('diplome_text'));
$stats     = acharp_rows(get_field('diplome_stats'));

if (!$title) {
    $title = 'Un tremplin vers <strong>votre avenir</strong>';
}

if (!$text) {
    $text = 'À l’issue de ce programme, les étudiants obtiennent le Bachelor d’architecture intérieure délivré par l’Académie Charpentier, et selon le niveau atteint, peuvent poursuivre le cursus <strong>d’architecture intérieure</strong> afin de préparer le <strong>diplôme d’Architecte d’intérieur, Titre RNCP 38011 niveau 7 certifié par l’État.</strong>';
}

if (!$stats) {
    $stats = array(
        array('value' => '100/100', 'text' => 'Taux de présentation et réussite au <strong>Bachelor</strong><br>Année 2023 – 2024'),
        array('value' => '100/100', 'text' => 'Taux de présentation et réussite au <strong>Bachelor</strong><br>Année 2024 – 2025'),
        array('value' => '100/100', 'text' => 'Taux de présentation et réussite en 5ème année<br>Année 2025 – 2026'),
    );
}
?>

<section id="diplome" class="diplome">
    <div class="container-fluid">
        <div class="diplome__grid">
            <div class="diplome__content">
                <?php if ($kicker) : ?>
                    <p class="diplome__kicker"><?= esc_html($kicker); ?></p>
                <?php endif; ?>

                <h2 class="diplome__title"><?= $title; ?></h2>

                <?php if ($text) : ?>
                    <p class="diplome__text"><?= $text; ?></p>
                <?php endif; ?>

                <div class="diplome__stats">
                    <?php foreach ($stats as $stat) : ?>
                        <article class="diplome__stat">
                            <p class="diplome__stat-value"><?= esc_html($stat['value'] ?? ''); ?></p>
                            <p class="diplome__stat-text"><?= acharp_inline_html($stat['text'] ?? ''); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>

            <figure class="diplome__media">
                <?= acharp_image_html(get_field('diplome_image'), 'large', array(
                    'src' => $theme_uri . '/images/vie-realisations.jpg',
                    'alt' => 'Visite d’une exposition de projets étudiants à l’Académie Charpentier',
                )); ?>
            </figure>
        </div>
    </div>
</section>
