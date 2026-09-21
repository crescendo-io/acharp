<?php
$theme_uri = get_stylesheet_directory_uri();
$kicker    = get_field('international_kicker') ?: 'International';
$title     = acharp_inline_html(get_field('international_title'));
$text      = get_field('international_text');
$cta       = acharp_link(get_field('international_cta'), '#', 'En savoir plus');

if (!$title) {
    $title = 'Étudier à&nbsp;<strong>Paris</strong>';
}

if (!$text) {
    $text = 'Nous accueillons des étudiants internationaux dans les mêmes formations que les étudiants français. Niveau de français B2 requis.';
}

?>

<section class="international">
    <div class="international__grid">
        <figure class="international__media">
            <?= acharp_image_html(get_field('international_image'), 'large', array(
                'src'    => $theme_uri . '/images/international-paris.jpg',
                'alt'    => 'Vue sur les toits de Paris et la tour Eiffel',
                'width'  => 1900,
                'height' => 1267,
            )); ?>
        </figure>

        <div class="international__content">
            <?php if ($kicker) : ?>
                <p class="international__kicker"><?= esc_html($kicker); ?></p>
            <?php endif; ?>
            <h2 class="international__title"><?= $title; ?></h2>
            <p class="international__text"><?= esc_html($text); ?></p>
            <a <?= acharp_link_attrs($cta); ?> class="btn btn--primary">
                <?= esc_html($cta['title']); ?>
                <?= acharp_arrow(); ?>
            </a>
        </div>
    </div>
</section>
