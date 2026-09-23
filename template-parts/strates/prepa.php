<?php
$show = get_field('prepa_show');
if ($show === false || $show === 0 || $show === '0') {
    return;
}

$theme_uri = get_stylesheet_directory_uri();
$related   = get_field('prepa_cursus');
$related_id = $related ? (is_object($related) ? $related->ID : (int) $related) : 0;

$kicker = get_field('prepa_kicker') ?: 'Une année pour se préparer';
$title  = acharp_inline_html(get_field('prepa_title'));
$texts  = acharp_rows(get_field('prepa_texts'));
$image  = get_field('prepa_image');
$cta    = acharp_link(
    get_field('prepa_cta'),
    $related_id ? get_permalink($related_id) : '#',
    'Découvrir l’année prépa'
);

if (!$title) {
    $title = $related_id
        ? get_the_title($related_id)
        : 'Vous souhaitez développer votre créativité <strong>avant de vous lancer ?</strong>';
    if ($related_id) {
        $title = esc_html($title);
    }
}

if (!$texts) {
    if ($related_id && has_excerpt($related_id)) {
        $texts = array(array('text' => get_the_excerpt($related_id)));
    } else {
        $texts = array(
            array('text' => 'L’année préparatoire permet de découvrir les fondamentaux des arts appliqués, d’expérimenter différentes pratiques créatives et de construire progressivement son univers personnel.'),
            array('text' => 'Une année pour explorer, pratiquer et confirmer son orientation avant d’intégrer une formation en architecture intérieure et design.'),
        );
    }
}

if (!$image && $related_id) {
    $image = get_post_thumbnail_id($related_id);
}
?>

<section class="prepa">
    <div class="container-fluid">
        <div class="prepa__grid">
            <figure class="prepa__media">
                <?= acharp_image_html($image, 'large', array(
                    'src' => $theme_uri . '/images/formation-prepa.jpg',
                    'alt' => 'Étudiante regardant des planches de projets en année préparatoire',
                )); ?>
            </figure>

            <div class="prepa__content">
                <?php if ($kicker) : ?>
                    <p class="prepa__kicker"><?= esc_html($kicker); ?></p>
                <?php endif; ?>

                <h2 class="prepa__title"><?= $title; ?></h2>

                <?php foreach ($texts as $paragraph) : ?>
                    <?php $text = acharp_inline_html($paragraph['text'] ?? ''); ?>
                    <?php if ($text) : ?>
                        <p class="prepa__text"><?= $text; ?></p>
                    <?php endif; ?>
                <?php endforeach; ?>

                <a <?= acharp_link_attrs($cta); ?> class="btn btn--primary prepa__cta">
                    <?= esc_html($cta['title']); ?>
                    <?= acharp_arrow(); ?>
                </a>
            </div>
        </div>
    </div>
</section>
