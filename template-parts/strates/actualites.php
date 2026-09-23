<?php
$kicker = get_field('actualites_kicker') ?: 'Actualités & évènements';
$title  = acharp_inline_html(get_field('actualites_title'));
$all    = acharp_link(get_field('actualites_all'), get_post_type_archive_link('actualite') ?: '#', 'Voir toutes nos actualités');
$cards  = acharp_get_actualite_cards();
$arrow  = acharp_arrow('actualites__arrow');

if (!$title) {
    $title = 'Restez <strong>informé</strong>';
}
?>

<section class="actualites">
    <div class="container-fluid">
        <div class="actualites__header">
            <div class="actualites__intro">
                <?php if ($kicker) : ?>
                    <p class="actualites__kicker"><?= esc_html($kicker); ?></p>
                <?php endif; ?>
                <h2 class="actualites__title"><?= $title; ?></h2>
            </div>
            <a <?= acharp_link_attrs($all); ?> class="actualites__all">
                <?= esc_html($all['title']); ?>
                <?= $arrow; ?>
            </a>
        </div>

        <div class="row">
            <?php foreach ($cards as $card) : ?>
                <div class="col-12 col-lg-4">
                    <article class="actualites__card">
                        <a href="<?= esc_url($card['url'] ?: '#'); ?>" class="actualites__link">
                            <?php if (!empty($card['image'])) : ?>
                                <figure class="actualites__media">
                                    <?= $card['image']; ?>
                                </figure>
                            <?php endif; ?>
                            <div class="actualites__body">
                                <?php if (!empty($card['date'])) : ?>
                                    <time class="actualites__date" datetime="<?= esc_attr($card['date']); ?>"><?= esc_html($card['date_label']); ?></time>
                                <?php endif; ?>
                                <h3 class="actualites__name"><?= esc_html($card['title']); ?></h3>
                                <?php if (!empty($card['text'])) : ?>
                                    <p class="actualites__text"><?= esc_html($card['text']); ?></p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
