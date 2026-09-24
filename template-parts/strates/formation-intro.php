<?php
$theme_uri = get_stylesheet_directory_uri();
$kicker    = get_field('intro_kicker') ?: 'La formation';
$title     = acharp_inline_html(get_field('intro_title'));
$texts     = acharp_rows(get_field('intro_texts'));
$cta       = acharp_file_or_link(get_field('intro_file'), get_field('intro_cta'), '#', 'Télécharger la brochure');

if (!$title) {
    $title = 'Une formation <strong>créative</strong> et<br> <strong>opérationnelle</strong>';
}

if (!$texts) {
    $texts = array(
        array('text' => 'Axé sur l’architecture intérieure et le design, le Bachelor forme des professionnels créatifs et opérationnels, prêts à exercer la fonction de collaborateur ou d’assistant en architecture intérieure et design.'),
        array('text' => 'À travers une approche concrète et responsable, cette formation développe les compétences nécessaires pour concevoir, transformer et valoriser les environnements intérieurs avec sens, méthode et responsabilité.'),
    );
}
?>

<section id="formation-intro" class="formation-intro">
    <div class="container-fluid">
        <div class="formation-intro__grid">
            <figure class="formation-intro__media">
                <?= acharp_image_html(get_field('intro_image'), 'large', array(
                    'src' => $theme_uri . '/images/vie-evenements.jpg',
                    'alt' => 'Visite d’atelier commentée par une étudiante de l’Académie Charpentier',
                )); ?>
            </figure>

            <div class="formation-intro__content">
                <?php if ($kicker) : ?>
                    <p class="formation-intro__kicker"><?= esc_html($kicker); ?></p>
                <?php endif; ?>

                <h2 class="formation-intro__title"><?= $title; ?></h2>

                <?php foreach ($texts as $paragraph) : ?>
                    <?php $text = acharp_inline_html($paragraph['text'] ?? ''); ?>
                    <?php if ($text) : ?>
                        <p class="formation-intro__text"><?= $text; ?></p>
                    <?php endif; ?>
                <?php endforeach; ?>

                <a <?= acharp_link_attrs($cta); ?> class="btn btn--outline formation-intro__cta">
                    <?= esc_html($cta['title']); ?>
                    <?= acharp_arrow(); ?>
                </a>
            </div>
        </div>
    </div>
</section>
