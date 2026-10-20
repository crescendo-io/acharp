<?php
$settings = acharp_portes_ouvertes_settings();

if (!$settings['enabled']) {
    return;
}

$cta   = $settings['cta'];
$image = !empty($settings['popup_image'])
    ? acharp_image_html($settings['popup_image'], 'large', array('class' => 'po-popup__img-el'))
    : '';
?>

<div class="po-popup" id="po-popup" hidden>
    <div class="po-popup__backdrop" data-po-popup-close tabindex="-1"></div>
    <div class="po-popup__dialog<?= $image ? ' po-popup__dialog--has-media' : ''; ?>" role="dialog" aria-modal="true" aria-labelledby="po-popup-title">
        <button type="button" class="po-popup__close" data-po-popup-close aria-label="Fermer">
            <span aria-hidden="true">&times;</span>
        </button>

        <?php if ($image) : ?>
            <figure class="po-popup__media">
                <?= $image; ?>
            </figure>
        <?php endif; ?>

        <div class="po-popup__body">
            <p class="po-popup__kicker">Évènement</p>
            <h2 class="po-popup__title" id="po-popup-title"><?= esc_html($settings['popup_title']); ?></h2>
            <?php if ($settings['date_label']) : ?>
                <p class="po-popup__date"><?= esc_html($settings['date_label']); ?></p>
            <?php endif; ?>
            <?php if ($settings['popup_text']) : ?>
                <p class="po-popup__text"><?= esc_html($settings['popup_text']); ?></p>
            <?php endif; ?>
            <?php if (!empty($cta['url'])) : ?>
                <a <?= acharp_link_attrs($cta); ?> class="btn btn--primary po-popup__cta">
                    <?= esc_html($cta['title']); ?>
                    <?= acharp_arrow(); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
