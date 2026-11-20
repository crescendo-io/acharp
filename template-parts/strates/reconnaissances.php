<?php
$theme_uri = get_stylesheet_directory_uri();
$title     = acharp_field('reconnaissances_title') ?: 'Reconnaissances & accréditations';
$logos     = acharp_rows(acharp_field('reconnaissances_logos'));

$defaults = array(
    array('file' => '/images/logo-qualiopi.png', 'alt' => 'Qualiopi, processus certifié', 'width' => 92, 'height' => 40),
    array('file' => '/images/logo-france-competences.png', 'alt' => 'France compétences', 'width' => 119, 'height' => 36),
    array('file' => '/images/logo-ministere-culture.png', 'alt' => 'Ministère de la Culture', 'width' => 85, 'height' => 62),
    array('file' => '/images/logo-diplomes-reconnus.png', 'alt' => 'Diplômes reconnus par l’État', 'width' => 58, 'height' => 67),
    array('file' => '/images/logo-campus-france.png', 'alt' => 'Campus France, établissement membre', 'width' => 109, 'height' => 41),
    array('file' => '/images/logo-cfai.svg', 'alt' => 'CFAI — Conseil français des architectes d’intérieur', 'width' => 120, 'height' => 40),
);

$items = array();

foreach ($logos as $logo) {
    if (empty($logo['image'])) {
        continue;
    }

    $file    = is_array($logo['file'] ?? null) ? $logo['file'] : array();
    $caption = acharp_inline_html($logo['caption'] ?? '');

    if (trim(wp_strip_all_tags($caption)) === '' && !empty($file['url'])) {
        $caption = 'Télécharger';
    }

    $items[] = array(
        'html'     => wp_get_attachment_image((int) $logo['image'], 'medium'),
        'link'     => acharp_link($logo['link'] ?? array()),
        'caption'  => $caption,
        'download' => !empty($file['url']) && !str_contains($caption, '<a') ? $file['url'] : '',
        'filename' => $file['filename'] ?? '',
    );
}

if (!$items) {
    foreach ($defaults as $logo) {
        $items[] = array(
            'html' => acharp_image_html(0, 'medium', array(
                'src'    => $theme_uri . $logo['file'],
                'alt'    => $logo['alt'],
                'width'  => $logo['width'],
                'height' => $logo['height'],
            )),
            'link'     => acharp_link(array()),
            'caption'  => '',
            'download' => '',
            'filename' => '',
        );
    }
}
?>

<section id="reconnaissances" class="reconnaissances" aria-labelledby="reconnaissances-title">
    <div class="reconnaissances__line" aria-hidden="true"></div>
    <h2 id="reconnaissances-title" class="reconnaissances__title">
        <?= esc_html($title); ?>
    </h2>

    <ul class="reconnaissances__logos">
        <?php foreach ($items as $item) : ?>
            <li class="reconnaissances__logo">
                <?php if ($item['link']['url']) : ?>
                    <a class="reconnaissances__logo-mark" <?= acharp_link_attrs($item['link']); ?>>
                        <?= $item['html']; ?>
                    </a>
                <?php else : ?>
                    <span class="reconnaissances__logo-mark">
                        <?= $item['html']; ?>
                    </span>
                <?php endif; ?>

                <?php if ($item['caption']) : ?>
                    <p class="reconnaissances__caption">
                        <?php if ($item['download']) : ?>
                            <a href="<?= esc_url($item['download']); ?>" download<?= $item['filename'] ? '="' . esc_attr($item['filename']) . '"' : ''; ?>>
                                <?= $item['caption']; ?>
                            </a>
                        <?php else : ?>
                            <?= $item['caption']; ?>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <span class="reconnaissances__accent reconnaissances__accent--orange" aria-hidden="true"></span>
    <span class="reconnaissances__accent reconnaissances__accent--green" aria-hidden="true"></span>
</section>
