<?php
$settings = acharp_portes_ouvertes_settings();

if (!$settings['enabled']) {
    return;
}

$cta = $settings['cta'];
$label = trim($settings['banner_text'] . ($settings['date_label'] ? ' — ' . $settings['date_label'] : ''));
?>

<aside class="po-banner" data-po-banner>
    <div class="po-banner__inner">
        <div class="po-banner__main">
            <p class="po-banner__text"><?= esc_html($label); ?></p>
            <?php if (!empty($cta['url'])) : ?>
                <a <?= acharp_link_attrs($cta); ?> class="po-banner__cta btn btn--light">
                    <?= esc_html($cta['title']); ?>
                    <?= acharp_arrow(); ?>
                </a>
            <?php endif; ?>
        </div>
        <button type="button" class="po-banner__close" data-po-banner-close aria-label="Fermer le bandeau">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</aside>
