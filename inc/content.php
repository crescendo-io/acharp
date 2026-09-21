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

    if ($image_id) {
        return wp_get_attachment_image($image_id, $size);
    }

    if (empty($fallback['src'])) {
        return '';
    }

    return sprintf(
        '<img src="%s" alt="%s" width="%s" height="%s">',
        esc_url($fallback['src']),
        esc_attr($fallback['alt'] ?? ''),
        esc_attr($fallback['width'] ?? ''),
        esc_attr($fallback['height'] ?? '')
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
            $related = $row['article'] ?? null;
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
        'post_type'      => 'articles',
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
