<?php
/**
 * Carte cursus partagée par la strate formations et l’archive.
 * $args : card (tableau issu de acharp_cursus_card ou acharp_get_formation_cards)
 */
$args  = isset($args) && is_array($args) ? $args : array();
$card  = isset($args['card']) && is_array($args['card']) ? $args['card'] : array();
$tag   = $args['heading'] ?? 'h3';
$arrow = acharp_arrow('formations__arrow');

if (empty($card['title'])) {
    return;
}
?>

<article class="formations__card">
    <?php if (!empty($card['image'])) : ?>
        <figure class="formations__media">
            <?= $card['image']; ?>
        </figure>
    <?php endif; ?>

    <div class="formations__body">
        <<?= esc_attr($tag); ?> class="formations__name"><?= esc_html($card['title']); ?></<?= esc_attr($tag); ?>>

        <?php if (!empty($card['meta'])) : ?>
            <p class="formations__meta"><?= esc_html($card['meta']); ?></p>
        <?php endif; ?>

        <?php if (!empty($card['text'])) : ?>
            <p class="formations__text"><?= esc_html($card['text']); ?></p>
        <?php endif; ?>

        <a href="<?= esc_url($card['url'] ?: '#'); ?>" class="formations__link">
            <?= esc_html($card['link_label'] ?? 'Découvrir nos formations'); ?>
            <?= $arrow; ?>
        </a>
    </div>
</article>
