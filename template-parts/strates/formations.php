<?php
$kicker = get_field('formations_kicker') ?: 'Nos formations';
$title  = acharp_inline_html(get_field('formations_title'));
$all    = acharp_link(get_field('formations_all'), get_post_type_archive_link('cursus') ?: '#', 'Voir toutes les formations');
$cards  = acharp_get_formation_cards();
$arrow  = acharp_arrow('formations__arrow');

if (!$title) {
    $title = 'Trouvez le parcours<br> qui <strong>vous ressemble</strong>';
}
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
                <div class="col-12 col-lg-4">
                    <?php get_template_part('template-parts/general/card-cursus', null, array(
                        'card' => $card,
                    )); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
