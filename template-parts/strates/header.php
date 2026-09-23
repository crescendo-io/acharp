<?php
$theme_uri = get_stylesheet_directory_uri();
$cursus_archive = get_post_type_archive_link('cursus') ?: '#';

$fallback_image = array(
    'src'    => $theme_uri . '/images/formation-bachelor.jpg',
    'alt'    => '',
    'width'  => 1600,
    'height' => 1067,
);

$get_cursus_items = static function () use ($fallback_image) {
    $query = new WP_Query(array(
        'post_type'      => 'cursus',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
        'no_found_rows'  => true,
    ));

    $items = array();

    foreach ($query->posts as $cursus_post) {
        $card = acharp_cursus_card($cursus_post->ID);

        if (!$card['image']) {
            $card['image'] = acharp_image_html(0, 'large', $fallback_image);
        }

        $items[] = $card;
    }

    return $items;
};

$menu_rows = acharp_rows(get_field('header_menu', 'header_options'));
$menu      = array();

foreach ($menu_rows as $row) {
    $mode = $row['submenu_mode'] ?? 'none';
    $link = acharp_link($row['link'] ?? array());

    if ($mode === 'cursus' && !$link['url']) {
        $link = acharp_link($link, $cursus_archive);
    }

    $submenu = array();

    if ($mode === 'cursus') {
        $submenu = $get_cursus_items();
    } elseif ($mode === 'manual') {
        foreach (acharp_rows($row['submenu_items'] ?? array()) as $subrow) {
            $sublink = acharp_link($subrow['link'] ?? array());

            if (!$sublink['url'] || empty($subrow['label'])) {
                continue;
            }

            $submenu[] = array(
                'title'  => $subrow['label'],
                'meta'   => $subrow['meta'] ?? '',
                'url'    => $sublink['url'],
                'target' => $sublink['target'],
                'image'  => acharp_image_html($subrow['image'] ?? 0, 'large', $fallback_image),
            );
        }
    }

    $all = acharp_link($row['submenu_all'] ?? array());

    if ($mode === 'cursus' && !$all['url']) {
        $all = acharp_link(array(), $cursus_archive, 'Voir toutes les formations');
    }

    $menu[] = array(
        'label'       => $row['label'] ?? '',
        'url'         => $link['url'] ?: '#',
        'target'      => $link['target'],
        'submenu'     => $submenu,
        'submenu_all' => $all,
    );
}

if (!$menu) {
    $menu = array(
        array('label' => 'L’école', 'url' => '#'),
        array(
            'label'       => 'Formations',
            'url'         => $cursus_archive,
            'submenu'     => $get_cursus_items(),
            'submenu_all' => acharp_link(array(), $cursus_archive, 'Voir toutes les formations'),
        ),
        array('label' => 'Admissions', 'url' => '#'),
        array('label' => 'International', 'url' => '#'),
        array('label' => 'Vie de l’école', 'url' => '#'),
        array('label' => 'Actualités & évènements', 'url' => get_post_type_archive_link('actualite') ?: '#'),
        array('label' => 'Contact', 'url' => '#'),
    );
}

$header_cta = acharp_link(
    get_field('header_cta', 'header_options'),
    '#',
    'Candidater'
);
?>

<header class="site-header">
    <div class="site-header__inner">
        <a href="<?= esc_url(home_url('/')); ?>" class="site-header__brand" aria-label="Académie Charpentier, retour à l’accueil">
            <img
                class="site-header__mark"
                src="<?= esc_url($theme_uri . '/images/logo-acharp-mark.png'); ?>"
                alt=""
                width="240"
                height="73"
            >
            <span class="site-header__wordmark">
                Académie<br>
                Charpentier
            </span>
        </a>

        <button type="button" class="site-header__burger" aria-expanded="false" aria-controls="site-nav" aria-label="Ouvrir le menu">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </button>

        <nav class="site-header__nav" id="site-nav" aria-label="Navigation principale">
            <ul class="site-header__menu">
                <?php foreach ($menu as $item) : ?>
                    <?php $submenu = $item['submenu'] ?? array(); ?>

                    <?php if (!$submenu) : ?>
                        <li class="site-header__item">
                            <a
                                href="<?= esc_url($item['url']); ?>"
                                class="site-header__link"
                                <?= !empty($item['target']) ? 'target="' . esc_attr($item['target']) . '" rel="noopener"' : ''; ?>
                            ><?= esc_html($item['label']); ?></a>
                        </li>
                    <?php else : ?>
                        <li class="site-header__item site-header__item--has-sub" data-submenu>
                            <a
                                href="<?= esc_url($item['url']); ?>"
                                class="site-header__link"
                                aria-haspopup="true"
                                aria-expanded="false"
                                <?= !empty($item['target']) ? 'target="' . esc_attr($item['target']) . '" rel="noopener"' : ''; ?>
                            >
                                <?= esc_html($item['label']); ?>
                                <svg class="site-header__chevron" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="m2.5 4 2.5 2.5L7.5 4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>

                            <div class="submenu" data-submenu-panel>
                                <div class="submenu__inner">
                                    <div class="submenu__visual" aria-hidden="true">
                                        <?php foreach ($submenu as $index => $entry) : ?>
                                            <figure class="submenu__image<?= $index === 0 ? ' is-active' : ''; ?>" data-submenu-visual="<?= (int) $index; ?>">
                                                <?= $entry['image']; ?>
                                            </figure>
                                        <?php endforeach; ?>
                                    </div>

                                    <ul class="submenu__list">
                                        <?php foreach ($submenu as $index => $entry) : ?>
                                            <li>
                                                <a
                                                    href="<?= esc_url($entry['url']); ?>"
                                                    class="submenu__link<?= $index === 0 ? ' is-active' : ''; ?>"
                                                    data-submenu-target="<?= (int) $index; ?>"
                                                    <?= !empty($entry['target']) ? 'target="' . esc_attr($entry['target']) . '" rel="noopener"' : ''; ?>
                                                >
                                                    <span class="submenu__body">
                                                        <span class="submenu__name"><?= esc_html($entry['title']); ?></span>
                                                        <?php if (!empty($entry['meta'])) : ?>
                                                            <span class="submenu__meta"><?= esc_html($entry['meta']); ?></span>
                                                        <?php endif; ?>
                                                    </span>
                                                    <?= acharp_arrow('submenu__arrow'); ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>

                                        <?php $all = $item['submenu_all'] ?? array(); ?>
                                        <?php if (!empty($all['url'])) : ?>
                                            <li>
                                                <a
                                                    href="<?= esc_url($all['url']); ?>"
                                                    class="submenu__all"
                                                    <?= !empty($all['target']) ? 'target="' . esc_attr($all['target']) . '" rel="noopener"' : ''; ?>
                                                >
                                                    <?= esc_html($all['title']); ?>
                                                    <?= acharp_arrow('submenu__arrow'); ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </nav>

        <div class="site-header__actions">
            <button type="button" class="site-header__lang" aria-expanded="false">
                <span class="site-header__flag" aria-hidden="true">
                    <svg width="18" height="12" viewBox="0 0 18 12" xmlns="http://www.w3.org/2000/svg">
                        <rect width="6" height="12" fill="#0055a4"/>
                        <rect x="6" width="6" height="12" fill="#ffffff"/>
                        <rect x="12" width="6" height="12" fill="#ef4135"/>
                    </svg>
                </span>
                FR
                <svg class="site-header__chevron" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="m2.5 4 2.5 2.5L7.5 4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <a <?= acharp_link_attrs($header_cta); ?> class="btn btn--primary site-header__cta">
                <?= esc_html($header_cta['title']); ?>
                <span class="btn__icon" aria-hidden="true">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 8h10M9.5 4.5 13 8l-3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </a>
        </div>
    </div>
</header>
