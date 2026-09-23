<?php

function acharp_inline_html($html) {
    if (!$html) {
        return '';
    }

    $html = wp_kses($html, array(
        'strong' => array(),
        'b'      => array(),
        'em'     => array(),
        'i'      => array(),
        'br'     => array(),
        'sup'    => array(),
        'span'   => array(),
        'a'      => array(
            'href'   => array(),
            'title'  => array(),
            'target' => array(),
            'rel'    => array(),
        ),
    ));

    return trim(preg_replace('#</?p[^>]*>#i', '', $html));
}

function acharp_arrow($class = 'btn__icon') {
    return '<span class="' . esc_attr($class) . '" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 8h10M9.5 4.5 13 8l-3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>';
}

/**
 * Un champ lien ACF peut remonter sous forme de tableau, d’URL brute
 * ou vide selon l’état de synchronisation du groupe.
 */
function acharp_link($link, $fallback_url = '', $fallback_title = '') {
    if (is_string($link)) {
        $link = $link ? array('url' => $link) : array();
    }

    if (!is_array($link)) {
        $link = array();
    }

    $link = wp_parse_args($link, array(
        'url'    => '',
        'title'  => '',
        'target' => '',
    ));

    if (!$link['url']) {
        $link['url'] = $fallback_url;
    }

    if (!$link['title']) {
        $link['title'] = $fallback_title;
    }

    return $link;
}

function acharp_link_attrs($link) {
    $link = acharp_link($link);

    if (!$link['url']) {
        return '';
    }

    $attrs = 'href="' . esc_url($link['url']) . '"';

    if (!empty($link['target'])) {
        $attrs .= ' target="' . esc_attr($link['target']) . '" rel="noopener"';
    }

    return $attrs;
}

function acharp_image_html($image_id, $size = 'large', $fallback = array()) {
    if (is_array($image_id)) {
        $image_id = $image_id['ID'] ?? 0;
    }

    $image_id = (int) $image_id;
    $class    = $fallback['class'] ?? '';

    if ($image_id) {
        return wp_get_attachment_image($image_id, $size, false, $class ? array('class' => $class) : array());
    }

    if (empty($fallback['src'])) {
        return '';
    }

    return sprintf(
        '<img src="%s" alt="%s"%s%s%s>',
        esc_url($fallback['src']),
        esc_attr($fallback['alt'] ?? ''),
        !empty($fallback['width']) ? ' width="' . esc_attr($fallback['width']) . '"' : '',
        !empty($fallback['height']) ? ' height="' . esc_attr($fallback['height']) . '"' : '',
        $class ? ' class="' . esc_attr($class) . '"' : ''
    );
}

/**
 * Lignes d’un répéteur : renvoie toujours un tableau de tableaux.
 */
function acharp_rows($value) {
    if (!is_array($value)) {
        return array();
    }

    return array_values(array_filter($value, 'is_array'));
}

/**
 * Cartes formations : liste auto des cursus, ou ligne par ligne
 * (relation vers un cursus + champs de surcharge optionnels).
 */
function acharp_get_formation_cards() {
    $theme_uri = get_stylesheet_directory_uri();
    $mode      = get_field('formations_mode') ?: 'auto';
    $defaults  = array(
        array(
            'title' => 'Classe préparatoire',
            'meta'  => 'post-bac — 1 ou 2 ans',
            'text'  => 'Se préparer aux études supérieures en architecture intérieure, design et métiers de l’espace.',
            'url'   => '#',
            'image' => acharp_image_html(0, 'large', array(
                'src'    => $theme_uri . '/images/formation-prepa.jpg',
                'alt'    => 'Travail de maquette en classe préparatoire',
                'width'  => 1600,
                'height' => 1067,
            )),
        ),
        array(
            'title' => 'Bachelor',
            'meta'  => 'post-bac — 3 ans',
            'text'  => 'Acquérir les fondamentaux du design et de l’architecture intérieure par la pratique et les projets.',
            'url'   => '#',
            'image' => acharp_image_html(0, 'large', array(
                'src'    => $theme_uri . '/images/formation-bachelor.jpg',
                'alt'    => 'Étudiants autour d’une maquette d’architecture',
                'width'  => 1600,
                'height' => 1067,
            )),
        ),
        array(
            'title' => 'Master',
            'meta'  => 'bac+3 — 2 ans',
            'text'  => 'Se spécialiser et développer une expertise pour concevoir des projets complexes.',
            'url'   => '#',
            'image' => acharp_image_html(0, 'large', array(
                'src'    => $theme_uri . '/images/formation-master.jpg',
                'alt'    => 'Maquette architecturale éclairée',
                'width'  => 1600,
                'height' => 1067,
            )),
        ),
    );

    if ($mode === 'custom') {
        $rows  = acharp_rows(get_field('formations_cards'));
        $cards = array();

        foreach ($rows as $row) {
            $related = $row['cursus'] ?? null;
            $id      = $related ? (is_object($related) ? $related->ID : (int) $related) : 0;
            $link    = acharp_link($row['link'] ?? array(), $id ? get_permalink($id) : '#');

            $cards[] = array(
                'title' => $row['title'] ?: ($id ? get_the_title($id) : ''),
                'meta'  => $row['meta'] ?: ($id ? (get_field('cursus_meta', $id) ?: '') : ''),
                'text'  => $row['text'] ?: ($id && has_excerpt($id) ? get_the_excerpt($id) : ''),
                'url'   => $link['url'],
                'image' => !empty($row['image'])
                    ? acharp_image_html($row['image'], 'large')
                    : ($id ? get_the_post_thumbnail($id, 'large') : ''),
            );
        }

        return $cards ?: $defaults;
    }

    $query = new WP_Query(array(
        'post_type'      => 'cursus',
        'posts_per_page' => 3,
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
        'post_status'    => 'publish',
    ));

    $cards = array();

    foreach ($query->posts as $post) {
        $id = $post->ID;
        $cards[] = array(
            'title' => get_the_title($id),
            'meta'  => get_field('cursus_meta', $id) ?: '',
            'text'  => has_excerpt($id) ? get_the_excerpt($id) : '',
            'url'   => get_permalink($id),
            'image' => get_the_post_thumbnail($id, 'large'),
        );
    }

    return $cards ?: $defaults;
}

/**
 * Cartes actualités : derniers articles, ou ligne par ligne (relation + surcharge).
 */
function acharp_get_actualite_cards() {
    $theme_uri = get_stylesheet_directory_uri();
    $mode      = get_field('actualites_mode') ?: 'auto';
    $defaults  = array(
        array(
            'url'        => '#',
            'date'       => '2024-05-24',
            'date_label' => '24 mai 2024',
            'title'      => 'Journée porte ouverte',
            'text'       => 'Rencontrez nos équipes et découvrez nos formations et nos ateliers.',
            'image'      => acharp_image_html(0, 'large', array(
                'src'    => $theme_uri . '/images/push-portes-ouvertes.jpg',
                'alt'    => 'Étudiants réunis lors d’une journée porte ouverte',
                'width'  => 800,
                'height' => 800,
            )),
        ),
        array(
            'url'        => '#',
            'date'       => '2024-05-24',
            'date_label' => '24 mai 2024',
            'title'      => 'Conférence',
            'text'       => 'Une conférence ouverte au public avec des architectes invités.',
            'image'      => acharp_image_html(0, 'large', array(
                'src'    => $theme_uri . '/images/vie-temoignages.jpg',
                'alt'    => 'Intervenante présentant ses planches lors d’une conférence',
                'width'  => 800,
                'height' => 800,
            )),
        ),
        array(
            'url'        => '#',
            'date'       => '2024-05-24',
            'date_label' => '24 mai 2024',
            'title'      => 'Exposition',
            'text'       => 'Découvrez les projets de fin d’année de nos étudiants.',
            'image'      => acharp_image_html(0, 'large', array(
                'src'    => $theme_uri . '/images/formation-master.jpg',
                'alt'    => 'Maquettes exposées dans des vitrines éclairées',
                'width'  => 800,
                'height' => 800,
            )),
        ),
    );

    if ($mode === 'custom') {
        $rows  = acharp_rows(get_field('actualites_cards'));
        $cards = array();

        foreach ($rows as $row) {
            $related = $row['actualite'] ?? ($row['article'] ?? null);
            $id      = $related ? (is_object($related) ? $related->ID : (int) $related) : 0;
            $link    = acharp_link($row['link'] ?? array(), $id ? get_permalink($id) : '#');
            $date    = $row['date'] ?: ($id ? get_the_date('Y-m-d', $id) : '');

            $cards[] = array(
                'url'        => $link['url'],
                'date'       => $date,
                'date_label' => $date ? date_i18n('j F Y', strtotime($date)) : '',
                'title'      => $row['title'] ?: ($id ? get_the_title($id) : ''),
                'text'       => $row['text'] ?: ($id && has_excerpt($id) ? get_the_excerpt($id) : ''),
                'image'      => !empty($row['image'])
                    ? acharp_image_html($row['image'], 'large')
                    : ($id ? get_the_post_thumbnail($id, 'large') : ''),
            );
        }

        return $cards ?: $defaults;
    }

    $query = new WP_Query(array(
        'post_type'      => 'actualite',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
    ));

    $cards = array();

    foreach ($query->posts as $post) {
        $id   = $post->ID;
        $date = get_the_date('Y-m-d', $id);
        $cards[] = array(
            'url'        => get_permalink($id),
            'date'       => $date,
            'date_label' => get_the_date('j F Y', $id),
            'title'      => get_the_title($id),
            'text'       => has_excerpt($id) ? get_the_excerpt($id) : '',
            'image'      => get_the_post_thumbnail($id, 'large'),
        );
    }

    return $cards ?: $defaults;
}

/**
 * Étiquette d’une actualité : premier terme de la taxonomie.
 */
function acharp_actualite_type($post_id = null) {
    $terms = get_the_terms($post_id ?: get_the_ID(), 'type_actualite');

    if (is_wp_error($terms) || empty($terms)) {
        return null;
    }

    return reset($terms);
}

/**
 * Filtres de l’archive actualités : « Tout » + les étiquettes utilisées.
 */
function acharp_actualite_filters() {
    $terms = get_terms(array(
        'taxonomy'   => 'type_actualite',
        'hide_empty' => true,
    ));

    if (is_wp_error($terms)) {
        return array();
    }

    $current = is_tax('type_actualite') ? (int) get_queried_object_id() : 0;

    $filters = array(
        array(
            'label'  => 'Tout',
            'slug'   => '',
            'url'    => get_post_type_archive_link('actualite') ?: home_url('/'),
            'active' => !$current,
        ),
    );

    foreach ($terms as $term) {
        $filters[] = array(
            'label'  => $term->name,
            'slug'   => $term->slug,
            'url'    => get_term_link($term),
            'active' => $current === (int) $term->term_id,
            'count'  => (int) $term->count,
        );
    }

    return $filters;
}

/**
 * Terme d’étiquette actuellement filtré, sur l’archive comme en AJAX.
 */
function acharp_actualite_current_term() {
    if (is_tax('type_actualite')) {
        $term = get_queried_object();

        return ($term && !is_wp_error($term)) ? $term : null;
    }

    return null;
}

/**
 * Pagination d’une liste d’actualités, indépendante de la requête principale
 * pour pouvoir être régénérée en AJAX.
 */
function acharp_actualite_pagination($query, $base_url, $current = 1) {
    $total = (int) $query->max_num_pages;

    if ($total < 2) {
        return '';
    }

    $links = paginate_links(array(
        'base'      => trailingslashit($base_url) . 'page/%#%/',
        'format'    => '',
        'total'     => $total,
        'current'   => max(1, (int) $current),
        'mid_size'  => 1,
        'prev_text' => 'Précédent',
        'next_text' => 'Suivant',
        'type'      => 'plain',
    ));

    if (!$links) {
        return '';
    }

    return '<nav class="actu-pagination" aria-label="Pagination des actualités"><div class="nav-links">' . $links . '</div></nav>';
}

function acharp_icon($name, $set = 'campus') {
    $icons = array(
        'campus' => array(
            'pin'   => '<svg width="16" height="22" viewBox="0 0 16 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14 12.4c0 4.6-6 10.1-6 10.1s-6-5.5-6-10.1a6 6 0 1 1 12 0Z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/><circle cx="8" cy="12.2" r="2.2" stroke="currentColor" stroke-width="1.3"/></svg>',
            'metro' => '<svg width="16" height="22" viewBox="0 0 16 22" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2.6" y="2.6" width="10.8" height="13.4" rx="3.2" stroke="currentColor" stroke-width="1.3"/><path d="M2.6 11.4h10.8M5.6 19.4l2.4-3.4M10.4 19.4 8 16" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/><circle cx="5.6" cy="13.6" r="0.9" fill="currentColor"/><circle cx="10.4" cy="13.6" r="0.9" fill="currentColor"/></svg>',
            'city'  => '<svg width="16" height="22" viewBox="0 0 16 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2.6 19.4V7.2l5.2-2.6v14.8M7.8 19.4h5.6V10L7.8 7.6" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/><path d="M4.8 9.6v1.2M4.8 13v1.2M10.4 12.4v1.2M10.4 15.6v1.2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>',
        ),
        'eco' => array(
            'leaf'   => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 19c0-7 4.6-11.5 14-12 .5 6.6-2.6 13-10 13a5.4 5.4 0 0 1-4-1Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/><path d="M5 19c1.4-3.8 4.2-7 8.4-9.2" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>',
            'people' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="8.4" r="2.8" stroke="currentColor" stroke-width="1.4"/><path d="M7.2 18c0-2.6 2.1-4.4 4.8-4.4s4.8 1.8 4.8 4.4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/><circle cx="4.9" cy="10" r="2" stroke="currentColor" stroke-width="1.4"/><circle cx="19.1" cy="10" r="2" stroke="currentColor" stroke-width="1.4"/><path d="M2 17c0-2 1.3-3.4 3.2-3.4M22 17c0-2-1.3-3.4-3.2-3.4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>',
            'globe'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="8.4" stroke="currentColor" stroke-width="1.4"/><path d="M3.6 12h16.8M12 3.6c2.2 2.3 3.4 5.2 3.4 8.4 0 3.2-1.2 6.1-3.4 8.4-2.2-2.3-3.4-5.2-3.4-8.4 0-3.2 1.2-6.1 3.4-8.4Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/></svg>',
        ),
        'admissions' => array(
            'file'    => '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7 3h7l4 4v14H7V3Z" stroke="currentColor" stroke-width="1.5"/><path d="M14 3v5h4M10 12h5M10 16h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
            'mail'    => '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="1" stroke="currentColor" stroke-width="1.5"/><path d="m4 7 8 6 8-6" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>',
            'image'   => '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="1.5" stroke="currentColor" stroke-width="1.5"/><circle cx="8.5" cy="9" r="1.5" stroke="currentColor" stroke-width="1.5"/><path d="m5 18 5-5 3 3 2-2 4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            'diploma' => '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7 3h7l4 4v14H7V3Z" stroke="currentColor" stroke-width="1.5"/><path d="M14 3v5h4M10 12h5M10 15h5M10 18h3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
        ),
    );

    $set_icons = $icons[$set] ?? array();
    $first     = reset($set_icons);

    return $set_icons[$name] ?? $first ?: '';
}

function acharp_file_or_link($file, $link, $fallback_url = '#', $fallback_title = '') {
    $link = acharp_link($link, '', $fallback_title);

    if (is_array($file) && !empty($file['url'])) {
        return acharp_link(array(
            'url'    => $file['url'],
            'title'  => $link['title'] ?: $fallback_title,
            'target' => '_blank',
        ));
    }

    if (!$link['url']) {
        $link['url'] = $fallback_url;
    }

    if (!$link['title']) {
        $link['title'] = $fallback_title;
    }

    return $link;
}
