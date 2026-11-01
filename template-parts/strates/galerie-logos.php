<?php
$title = acharp_field('galerie_logos_title');
$logos = acharp_rows(acharp_field('galerie_logos'));
$logos = array_values(array_filter($logos, static function ($logo) {
    return !empty($logo['image']);
}));

if (!$logos) {
    return;
}
?>

<section id="galerie-logos" class="logo-gallery">
    <div class="container-fluid">
        <?php if ($title) : ?>
            <h2 class="logo-gallery__title"><?= esc_html($title); ?></h2>
        <?php endif; ?>

        <ul class="logo-gallery__grid">
            <?php foreach ($logos as $logo) : ?>
                <?php
                $name = trim((string) ($logo['name'] ?? ''));
                $url  = trim((string) ($logo['link'] ?? ''));
                $img  = wp_get_attachment_image((int) $logo['image'], 'medium', false, $name ? array('alt' => $name) : array());
                ?>
                <li class="logo-gallery__item">
                    <?php if ($url) : ?>
                        <a class="logo-gallery__link" href="<?= esc_url($url); ?>" target="_blank" rel="noopener">
                            <?= $img; ?>
                        </a>
                    <?php else : ?>
                        <?= $img; ?>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
