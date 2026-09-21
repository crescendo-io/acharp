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

<section class="formations">
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
                    <article class="formations__card">
                        <?php if (!empty($card['image'])) : ?>
                            <figure class="formations__media">
                                <?= $card['image']; ?>
                            </figure>
                        <?php endif; ?>
                        <div class="formations__body">
                            <h3 class="formations__name"><?= esc_html($card['title']); ?></h3>
                            <?php if (!empty($card['meta'])) : ?>
                                <p class="formations__meta"><?= esc_html($card['meta']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($card['text'])) : ?>
                                <p class="formations__text"><?= esc_html($card['text']); ?></p>
                            <?php endif; ?>
                            <a href="<?= esc_url($card['url'] ?: '#'); ?>" class="formations__link">
                                Découvrir nos formations
                                <?= $arrow; ?>
                            </a>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
