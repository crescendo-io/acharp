<?php

defined('ABSPATH') || exit;

function acharp_site_option($selector, $default = '') {
    if (!function_exists('get_field')) {
        return $default;
    }

    $value = get_field($selector, 'site_options');

    return ($value !== null && $value !== '' && $value !== false) ? $value : $default;
}

function acharp_social_links() {
    $defaults = array(
        'Facebook'  => 'https://www.facebook.com/academie.charpentier.paris/',
        'X'         => 'https://x.com/Acadcharp',
        'Instagram' => 'https://www.instagram.com/academiecharpentier_paris/',
    );

    $rows = function_exists('get_field') ? acharp_rows(get_field('site_social_links', 'site_options')) : array();
    $links = array();

    foreach ($rows as $row) {
        $label = trim((string) ($row['label'] ?? ''));
        $url   = esc_url($row['url'] ?? '');

        if ($label && $url) {
            $links[$label] = $url;
        }
    }

    return $links ?: $defaults;
}

function acharp_portes_ouvertes_settings() {
    $image = acharp_site_option('po_popup_image', null);

    return array(
        'enabled'      => (bool) acharp_site_option('po_enabled', true),
        'banner_text'  => (string) acharp_site_option('po_banner_text', 'Prochaines portes ouvertes — réservez votre place'),
        'date_label'   => (string) acharp_site_option('po_date_label', ''),
        'popup_title'  => (string) acharp_site_option('po_popup_title', 'Portes ouvertes'),
        'popup_text'   => (string) acharp_site_option('po_popup_text', 'Venez découvrir l’Académie Charpentier, nos ateliers et rencontrer nos équipes.'),
        'popup_image'  => is_numeric($image) ? (int) $image : (is_array($image) ? (int) ($image['ID'] ?? 0) : 0),
        'cta'          => acharp_link(acharp_site_option('po_cta', array()), '#', 'Réserver'),
    );
}

function acharp_early_bird_active() {
    if (!acharp_site_option('early_bird_enabled', true)) {
        return false;
    }

    $deadline = (string) acharp_site_option('early_bird_deadline', '2027-01-15');

    if (!$deadline) {
        return false;
    }

    $ts = strtotime($deadline . ' 23:59:59');

    return $ts && time() <= $ts;
}

function acharp_early_bird_message() {
    return (string) acharp_site_option(
        'early_bird_message',
        'Offre early bird : frais de dossier offerts pour toute candidature déposée avant le 15 janvier.'
    );
}

function acharp_hidden_menu_paths() {
    $paths = array(
        'decouvrir-larchitecture-interieure',
        'decouvrir-architecture-interieure',
        'stages-architecture-interieure',
        'stage-architecture-interieure',
        'journee-immersion',
        'immersion',
    );

    $rows = function_exists('get_field') ? acharp_rows(get_field('site_hidden_menu_paths', 'site_options')) : array();

    foreach ($rows as $row) {
        $path = sanitize_title((string) ($row['path'] ?? ''));

        if ($path) {
            $paths[] = $path;
        }
    }

    return array_values(array_unique($paths));
}

function acharp_is_hidden_menu_url($url) {
    if (!$url || $url === '#') {
        return false;
    }

    $path = wp_parse_url($url, PHP_URL_PATH);
    $path = trim((string) $path, '/');
    $slug = basename($path);

    foreach (acharp_hidden_menu_paths() as $hidden) {
        if ($slug === $hidden || str_contains($path, $hidden)) {
            return true;
        }
    }

    return false;
}

function acharp_filter_menu_link($link) {
    if (!is_array($link)) {
        return $link;
    }

    if (acharp_is_hidden_menu_url($link['url'] ?? '')) {
        return null;
    }

    return $link;
}

function acharp_is_catalog_cursus($post_id) {
    $post_id = (int) $post_id;

    if (!$post_id || get_post_type($post_id) !== 'cursus') {
        return false;
    }

    if (get_field('cursus_hide_catalog', $post_id)) {
        return false;
    }

    $slug = get_post_field('post_name', $post_id);

    return !preg_match('/prepa|pre-pa|preparatoire|classe-preparatoire/i', (string) $slug);
}

function acharp_query_catalog_cursus($args = array()) {
    $query_args = wp_parse_args($args, array(
        'post_type'      => 'cursus',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
        'no_found_rows'  => true,
    ));

    $query = new WP_Query($query_args);
    $posts = array();

    foreach ($query->posts as $post) {
        if (acharp_is_catalog_cursus($post->ID)) {
            $posts[] = $post;
        }
    }

    return $posts;
}

function acharp_cursus_volume_horaire($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $custom  = get_field('cursus_volume_horaire', $post_id);

    if ($custom) {
        return $custom;
    }

    $slug = get_post_field('post_name', $post_id);
    $map  = array(
        'bachelor'                    => '656,5 h',
        'bachelor-bac-3'              => '656,5 h',
        'formation-bac-5'             => '335 h',
        'bac-5'                       => '335 h',
        'master'                      => '335 h',
        '4e-annee'                    => '335 h',
        '5e-annee'                    => '499 h',
    );

    foreach ($map as $needle => $hours) {
        if ($slug && str_contains($slug, $needle)) {
            return $hours;
        }
    }

    return '';
}

function acharp_register_site_options_page() {
    if (!function_exists('acf_add_options_sub_page')) {
        return;
    }

    acf_add_options_sub_page(array(
        'page_title'      => __('Réglages du site', 'lsd_lang'),
        'menu_title'      => __('Réglages du site', 'lsd_lang'),
        'menu_slug'       => 'acharp-site-settings',
        'parent_slug'     => 'themes.php',
        'post_id'         => 'site_options',
        'capability'      => 'edit_theme_options',
        'update_button'   => __('Enregistrer', 'lsd_lang'),
        'updated_message' => __('Réglages enregistrés.', 'lsd_lang'),
    ));
}
add_action('acf/init', 'acharp_register_site_options_page');

function acharp_enqueue_portes_ouvertes_assets() {
    $settings = acharp_portes_ouvertes_settings();

    if (!$settings['enabled']) {
        return;
    }

    wp_enqueue_script(
        'acharp-portes-ouvertes',
        get_stylesheet_directory_uri() . '/js/portes-ouvertes.js',
        array(),
        filemtime(get_stylesheet_directory() . '/js/portes-ouvertes.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'acharp_enqueue_portes_ouvertes_assets');

function acharp_render_portes_ouvertes_popup() {
    get_template_part('template-parts/general/portes-ouvertes', 'popup');
}
add_action('wp_footer', 'acharp_render_portes_ouvertes_popup', 5);
