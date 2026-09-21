<?php
$theme_uri = get_stylesheet_directory_uri();
$kicker    = get_field('histoire_kicker') ?: 'L’Académie Charpentier';
$title     = acharp_inline_html(get_field('histoire_title'));
$text      = acharp_inline_html(get_field('histoire_text'));
$cta       = acharp_link(get_field('histoire_cta'), '#', 'Découvrir l’académie');

if (!$title) {
    $title = 'Une histoire, une école,<br> une <strong>vision</strong>';
}

if (!$text) {
    $text = 'Fondée il y a plus de 60 ans, l’Académie Charpentier est installée au cœur du 15<sup>e</sup> arrondissement de Paris. Notre école à taille humaine place l’étudiant au centre de son projet pédagogique, avec une approche concrète, créative et professionnalisante.';
}

?>

<section class="histoire">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-7 histoire__mosaic-col">
                <div class="histoire__mosaic">
                    <figure class="histoire__mosaic-item histoire__mosaic-item--main">
                        <?= acharp_image_html(get_field('histoire_image_main'), 'large', array(
                            'src'    => $theme_uri . '/images/histoire-facade.jpg',
                            'alt'    => 'Façade de l’Académie Charpentier',
                            'width'  => 1600,
                            'height' => 2845,
                        )); ?>
                    </figure>
                    <figure class="histoire__mosaic-item histoire__mosaic-item--salon">
                        <?= acharp_image_html(get_field('histoire_image_salon'), 'large', array(
                            'src'    => $theme_uri . '/images/histoire-salon.jpg',
                            'alt'    => 'Espace de vie de l’école',
                            'width'  => 1600,
                            'height' => 2400,
                        )); ?>
                    </figure>
                    <figure class="histoire__mosaic-item histoire__mosaic-item--escalier">
                        <?= acharp_image_html(get_field('histoire_image_escalier'), 'large', array(
                            'src'    => $theme_uri . '/images/histoire-escalier.jpg',
                            'alt'    => 'Escalier intérieur de l’école',
                            'width'  => 1600,
                            'height' => 1067,
                        )); ?>
                    </figure>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="histoire__content">
                    <?php if ($kicker) : ?>
                        <p class="histoire__kicker"><?= esc_html($kicker); ?></p>
                    <?php endif; ?>
                    <h2 class="histoire__title"><?= $title; ?></h2>
                    <p class="histoire__text"><?= $text; ?></p>
                    <a <?= acharp_link_attrs($cta); ?> class="btn btn--primary">
                        <?= esc_html($cta['title']); ?>
                        <?= acharp_arrow(); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
