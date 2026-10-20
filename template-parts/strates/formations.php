<?php
$kicker = acharp_field('formations_kicker') ?: 'Nos formations';
$title  = acharp_inline_html(acharp_field('formations_title'));
$all    = acharp_link(acharp_field('formations_all'), get_post_type_archive_link('cursus') ?: '#', 'Voir toutes les formations');
$cards  = acharp_get_formation_cards();
$arrow  = acharp_arrow('formations__arrow');

if (!$title) {
    $title = 'Trouvez le parcours<br> qui <strong>vous ressemble</strong>';
}

$card_count = count($cards);
$col_lg     = 3 === $card_count ? 'col-lg-4' : 'col-lg-6';
?>

<section id="formations" class="formations">
    <div class="container-fluid">
        <div class="formations__header">
            <div class="formations__intro">
                <?php if ($kicker) : ?>
                    <p class="formations__kicker"><?= esc_html($kicker); ?></p>
                <?php endif; ?>
                <h2 class="formations__title"><?= $title; ?></h2>
            </div>
            <a <?= acharp_link_attrs($all); ?> class="formations__all">
                <?= esc_html($all['title']); ?>
                <?= $arrow; ?>
            </a>
        </div>

        <div class="row">
            <?php foreach ($cards as $card) : ?>
                <div class="col-12 <?= esc_attr($col_lg); ?>">
                    <?php get_template_part('template-parts/general/card-cursus', null, array(
                        'card' => $card,
                    )); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
