<?php

defined('ABSPATH') || exit;

const ACHARP_CONTACT_CPT = 'contact_demande';
const ACHARP_CONTACT_CAP = 'manage_contact_demandes';

function acharp_contact_settings() {
    $days = (int) get_option('acharp_contact_retention_days', 365);
    $mail = sanitize_email((string) get_option('acharp_contact_notify_email', get_option('admin_email')));
    $url  = esc_url_raw((string) get_option(
        'acharp_contact_calendly',
        'https://calendly.com/admissions-academiecharpentier/30min'
    ));

    if ($days < 30) {
        $days = 30;
    }

    if ($days > 2555) {
        $days = 2555;
    }

    if (!$mail) {
        $mail = sanitize_email((string) get_option('admin_email'));
    }

    if (!acharp_contact_is_calendly_url($url)) {
        $url = 'https://calendly.com/admissions-academiecharpentier/30min';
    }

    return array(
        'retention_days' => $days,
        'notify_email'   => $mail,
        'calendly'       => $url,
    );
}

function acharp_contact_is_calendly_url($url) {
    if (function_exists('acharp_candidature_is_calendly_url')) {
        return acharp_candidature_is_calendly_url($url);
    }

    if (!$url) {
        return false;
    }

    $parts = wp_parse_url($url);

    return !empty($parts['scheme']) && $parts['scheme'] === 'https'
        && !empty($parts['host']) && preg_match('/(^|\.)calendly\.com$/i', $parts['host']);
}

function acharp_contact_register_cpt() {
    register_post_type(ACHARP_CONTACT_CPT, array(
        'labels' => array(
            'name'               => 'Demandes de contact',
            'singular_name'      => 'Demande de contact',
            'menu_name'          => 'Demandes de contact',
            'all_items'          => 'Toutes les demandes',
            'view_item'          => 'Voir la demande',
            'search_items'       => 'Rechercher une demande',
            'not_found'          => 'Aucune demande',
            'not_found_in_trash' => 'Aucune demande dans la corbeille',
        ),
        'public'              => false,
        'publicly_queryable'  => false,
        'exclude_from_search' => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => false,
        'has_archive'         => false,
        'rewrite'             => false,
        'query_var'           => false,
        'menu_icon'           => 'dashicons-email-alt',
        'supports'            => array('title'),
        'capability_type'     => 'contact_demande',
        'map_meta_cap'        => false,
        'capabilities'        => array(
            'edit_post'              => ACHARP_CONTACT_CAP,
            'read_post'              => ACHARP_CONTACT_CAP,
            'delete_post'            => ACHARP_CONTACT_CAP,
            'edit_posts'             => ACHARP_CONTACT_CAP,
            'edit_others_posts'      => ACHARP_CONTACT_CAP,
            'edit_private_posts'     => ACHARP_CONTACT_CAP,
            'delete_posts'           => ACHARP_CONTACT_CAP,
            'delete_others_posts'    => ACHARP_CONTACT_CAP,
            'delete_private_posts'   => ACHARP_CONTACT_CAP,
            'publish_posts'          => ACHARP_CONTACT_CAP,
            'read_private_posts'     => ACHARP_CONTACT_CAP,
            'create_posts'           => 'do_not_allow',
        ),
    ));
}
add_action('init', 'acharp_contact_register_cpt');

function acharp_contact_grant_caps() {
    $role = get_role('administrator');

    if ($role && !$role->has_cap(ACHARP_CONTACT_CAP)) {
        $role->add_cap(ACHARP_CONTACT_CAP);
    }
}
add_action('init', 'acharp_contact_grant_caps', 20);
add_action('after_switch_theme', 'acharp_contact_grant_caps');

function acharp_contact_user_can_manage() {
    return current_user_can(ACHARP_CONTACT_CAP);
}

function acharp_contact_schedule_cron() {
    if (!wp_next_scheduled('acharp_contact_purge')) {
        wp_schedule_event(time() + HOUR_IN_SECONDS, 'daily', 'acharp_contact_purge');
    }
}
add_action('init', 'acharp_contact_schedule_cron');

function acharp_contact_unschedule_cron() {
    $timestamp = wp_next_scheduled('acharp_contact_purge');

    if ($timestamp) {
        wp_unschedule_event($timestamp, 'acharp_contact_purge');
    }
}
add_action('switch_theme', 'acharp_contact_unschedule_cron');

function acharp_contact_is_contact_page($post_id) {
    $post_id = (int) $post_id;

    if (!$post_id || get_post_type($post_id) !== 'page' || get_post_status($post_id) !== 'publish') {
        return false;
    }

    return get_page_template_slug($post_id) === 'page-contact.php';
}

function acharp_contact_default_motifs() {
    $mail = acharp_contact_settings()['notify_email'];

    return array(
        array(
            'label'         => 'Découvrir l’école',
            'email'         => $mail,
            'show_calendly' => 1,
        ),
        array(
            'label'         => 'Admissions',
            'email'         => $mail,
            'show_calendly' => 0,
        ),
        array(
            'label'         => 'Question générale',
            'email'         => $mail,
            'show_calendly' => 0,
        ),
        array(
            'label'         => 'Presse & partenariats',
            'email'         => $mail,
            'show_calendly' => 0,
        ),
    );
}

function acharp_contact_motif_id($page_id, $index, $label, $email) {
    return substr(hash_hmac('sha256', (int) $page_id . '|' . (int) $index . '|' . $label . '|' . $email, wp_salt('nonce')), 0, 20);
}

function acharp_contact_normalize_motifs($rows, $page_id = 0) {
    $fallback = acharp_contact_settings()['notify_email'];
    $motifs   = array();

    foreach (array_values($rows) as $index => $row) {
        if (!is_array($row)) {
            continue;
        }

        $label = sanitize_text_field($row['label'] ?? '');
        $email = sanitize_email((string) ($row['recipient_email'] ?? ($row['email'] ?? '')));

        if ($label === '') {
            continue;
        }

        if (!is_email($email)) {
            $email = $fallback;
        }

        $motifs[] = array(
            'id'            => acharp_contact_motif_id($page_id, $index, $label, $email),
            'label'         => $label,
            'email'         => $email,
            'show_calendly' => !empty($row['show_calendly']),
        );
    }

    return $motifs;
}

function acharp_contact_motifs($page_id) {
    $page_id = (int) $page_id;
    $rows    = array();

    if ($page_id && function_exists('get_field')) {
        $rows = acharp_rows(get_field('contact_motifs', $page_id));
    }

    if (!$rows) {
        $rows = acharp_contact_default_motifs();
    }

    $motifs = acharp_contact_normalize_motifs($rows, $page_id);

    if (!$motifs) {
        $motifs = acharp_contact_normalize_motifs(acharp_contact_default_motifs(), $page_id);
    }

    return apply_filters('acharp_contact_motifs', $motifs, $page_id);
}

function acharp_contact_public_motifs($page_id) {
    $public = array();

    foreach (acharp_contact_motifs($page_id) as $motif) {
        $public[] = array(
            'id'    => $motif['id'],
            'label' => $motif['label'],
        );
    }

    return $public;
}

function acharp_contact_find_motif($page_id, $id) {
    $id = sanitize_text_field((string) $id);

    if ($id === '') {
        return null;
    }

    foreach (acharp_contact_motifs($page_id) as $motif) {
        if (hash_equals($motif['id'], $id)) {
            return $motif;
        }
    }

    return null;
}

function acharp_contact_map_src($lat, $lng, $zoom = 16) {
    unset($zoom);
    $lat = (float) $lat;
    $lng = (float) $lng;

    if (!$lat || !$lng) {
        $lat = 48.8446;
        $lng = 2.2789;
    }

    $delta = 0.005;

    return sprintf(
        'https://www.openstreetmap.org/export/embed.html?bbox=%s&layer=mapnik&marker=%s',
        rawurlencode(implode(',', array($lng - $delta, $lat - $delta, $lng + $delta, $lat + $delta))),
        rawurlencode($lat . ',' . $lng)
    );
}

function acharp_contact_assets() {
    if (!is_page_template('page-contact.php')) {
        return;
    }

    wp_enqueue_script(
        'acharp-contact',
        get_stylesheet_directory_uri() . '/js/contact.js',
        array(),
        filemtime(get_stylesheet_directory() . '/js/contact.js'),
        true
    );

    wp_localize_script('acharp-contact', 'acharpContact', array(
        'ajaxUrl'   => admin_url('admin-ajax.php'),
        'nonce'     => wp_create_nonce('acharp_contact'),
        'issuedAt'  => (string) time(),
        'issuedSig' => acharp_contact_sign_timestamp(time()),
        'pageId'    => (int) get_queried_object_id(),
    ));
}
add_action('wp_enqueue_scripts', 'acharp_contact_assets');

function acharp_contact_sign_timestamp($time) {
    return hash_hmac('sha256', (string) (int) $time, wp_salt('nonce'));
}

function acharp_contact_verify_timestamp($time, $sig) {
    $time = (int) $time;

    if ($time < 1 || !hash_equals(acharp_contact_sign_timestamp($time), (string) $sig)) {
        return new WP_Error('timing', 'Session de formulaire invalide. Rechargez la page.');
    }

    $age = time() - $time;

    if ($age < 2) {
        return new WP_Error('timing', 'Veuillez patienter avant d’envoyer le formulaire.');
    }

    if ($age > 2 * HOUR_IN_SECONDS) {
        return new WP_Error('timing', 'La session a expiré. Rechargez la page.');
    }

    return true;
}

function acharp_contact_client_ip() {
    $ip = isset($_SERVER['REMOTE_ADDR']) ? wp_unslash($_SERVER['REMOTE_ADDR']) : '';

    return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
}

function acharp_contact_ip_key() {
    return 'acharp_contact_rl_' . hash_hmac('sha256', acharp_contact_client_ip(), wp_salt('nonce'));
}

function acharp_contact_rate_limited() {
    $key   = acharp_contact_ip_key();
    $hits  = (int) get_transient($key);
    $limit = 8;

    if ($hits >= $limit) {
        return true;
    }

    set_transient($key, $hits + 1, HOUR_IN_SECONDS);

    return false;
}

function acharp_contact_log($code, $post_id = 0) {
    if (!defined('WP_DEBUG') || !WP_DEBUG) {
        return;
    }

    error_log('acharp_contact code=' . sanitize_key($code) . ($post_id ? ' id=' . (int) $post_id : ''));
}

function acharp_contact_sanitize_phone($phone) {
    $phone = sanitize_text_field($phone);
    $phone = preg_replace('/[^\d+\s().-]/', '', $phone);

    return trim((string) $phone);
}

function acharp_contact_validate($input, $page_id) {
    $errors = array();
    $data   = array(
        'first_name' => sanitize_text_field($input['first_name'] ?? ''),
        'last_name'  => sanitize_text_field($input['last_name'] ?? ''),
        'email'      => sanitize_email($input['email'] ?? ''),
        'phone'      => acharp_contact_sanitize_phone($input['phone'] ?? ''),
        'motif_id'   => sanitize_text_field($input['motif'] ?? ''),
        'message'    => sanitize_textarea_field($input['message'] ?? ''),
        'consent'    => !empty($input['consent']),
    );

    if ($data['first_name'] === '' || mb_strlen($data['first_name']) > 80) {
        $errors['first_name'] = 'Indiquez votre prénom.';
    }

    if ($data['last_name'] === '' || mb_strlen($data['last_name']) > 80) {
        $errors['last_name'] = 'Indiquez votre nom.';
    }

    if (!is_email($data['email'])) {
        $errors['email'] = 'Indiquez une adresse e-mail valide.';
    }

    if ($data['phone'] !== '') {
        $digits = preg_replace('/\D+/', '', $data['phone']);

        if (strlen($digits) < 8 || strlen($digits) > 15) {
            $errors['phone'] = 'Indiquez un numéro de téléphone valide.';
        }
    }

    $motif = acharp_contact_find_motif($page_id, $data['motif_id']);

    if (!$motif) {
        $errors['motif'] = 'Choisissez un motif.';
    }

    $length = mb_strlen($data['message']);

    if ($length < 10 || $length > 4000) {
        $errors['message'] = 'Indiquez votre message (10 à 4000 caractères).';
    }

    if (!$data['consent']) {
        $errors['consent'] = 'Le consentement est obligatoire pour envoyer ce message.';
    }

    if ($errors) {
        return new WP_Error('invalid', 'Veuillez corriger les champs indiqués.', $errors);
    }

    $data['motif'] = $motif;

    return $data;
}

function acharp_contact_ajax_guard() {
    if (!check_ajax_referer('acharp_contact', 'nonce', false)) {
        wp_send_json_error(array('message' => 'Session expirée. Rechargez la page.'), 403);
    }

    if (acharp_contact_rate_limited()) {
        acharp_contact_log('rate_limited');
        wp_send_json_error(array('message' => 'Trop de tentatives. Réessayez plus tard.'), 429);
    }

    $honeypot = sanitize_text_field(wp_unslash($_POST['fax_number'] ?? ''));

    if ($honeypot !== '') {
        wp_send_json_success(array(
            'message'  => 'Votre message a bien été envoyé.',
            'calendly' => null,
        ));
    }

    $timing = acharp_contact_verify_timestamp(
        wp_unslash($_POST['issued_at'] ?? ''),
        wp_unslash($_POST['issued_sig'] ?? '')
    );

    if (is_wp_error($timing)) {
        wp_send_json_error(array('message' => $timing->get_error_message()), 400);
    }
}

function acharp_contact_ajax_send() {
    acharp_contact_ajax_guard();

    $page_id = isset($_POST['page_id']) ? (int) wp_unslash($_POST['page_id']) : 0;

    if (!acharp_contact_is_contact_page($page_id)) {
        wp_send_json_error(array('message' => 'Formulaire introuvable.'), 400);
    }

    $validated = acharp_contact_validate(wp_unslash($_POST), $page_id);

    if (is_wp_error($validated)) {
        wp_send_json_error(array(
            'message' => $validated->get_error_message(),
            'fields'  => $validated->get_error_data(),
        ), 400);
    }

    $post_id = acharp_contact_store($validated, $page_id);

    if (is_wp_error($post_id)) {
        wp_send_json_error(array('message' => $post_id->get_error_message()), 500);
    }

    acharp_contact_notify_recipient($post_id);
    acharp_contact_notify_visitor($post_id);

    wp_send_json_success(acharp_contact_success_payload($post_id));
}
add_action('wp_ajax_acharp_contact_send', 'acharp_contact_ajax_send');
add_action('wp_ajax_nopriv_acharp_contact_send', 'acharp_contact_ajax_send');

function acharp_contact_store($data, $page_id) {
    $title   = trim($data['first_name'] . ' ' . $data['last_name']);
    $post_id = wp_insert_post(array(
        'post_type'   => ACHARP_CONTACT_CPT,
        'post_status' => 'private',
        'post_title'  => $title,
        'post_author' => 0,
    ), true);

    if (is_wp_error($post_id) || !$post_id) {
        acharp_contact_log('insert_failed');
        return new WP_Error('insert', 'Impossible d’enregistrer la demande.');
    }

    $motif = $data['motif'];

    update_post_meta($post_id, '_contact_first_name', $data['first_name']);
    update_post_meta($post_id, '_contact_last_name', $data['last_name']);
    update_post_meta($post_id, '_contact_email', $data['email']);
    update_post_meta($post_id, '_contact_phone', $data['phone']);
    update_post_meta($post_id, '_contact_message', $data['message']);
    update_post_meta($post_id, '_contact_motif_id', $motif['id']);
    update_post_meta($post_id, '_contact_motif_label', $motif['label']);
    update_post_meta($post_id, '_contact_recipient', $motif['email']);
    update_post_meta($post_id, '_contact_show_calendly', $motif['show_calendly'] ? 1 : 0);
    update_post_meta($post_id, '_contact_consent', 1);
    update_post_meta($post_id, '_contact_consent_at', time());
    update_post_meta($post_id, '_contact_page_id', (int) $page_id);
    update_post_meta($post_id, '_contact_ip_hash', hash_hmac('sha256', acharp_contact_client_ip(), wp_salt('auth')));
    update_post_meta($post_id, '_contact_retention_until', time() + (acharp_contact_settings()['retention_days'] * DAY_IN_SECONDS));

    return (int) $post_id;
}

function acharp_contact_success_payload($post_id) {
    $settings = acharp_contact_settings();
    $first    = get_post_meta($post_id, '_contact_first_name', true);
    $payload  = array(
        'message'  => sprintf('Merci %s, votre message a bien été envoyé.', $first ?: ''),
        'calendly' => null,
    );

    if ((int) get_post_meta($post_id, '_contact_show_calendly', true) === 1) {
        $payload['calendly'] = $settings['calendly'];
        $payload['message'] .= ' Vous pouvez dès à présent planifier une visite de l’école.';
    }

    return $payload;
}

function acharp_contact_notify_recipient($post_id) {
    $to      = sanitize_email((string) get_post_meta($post_id, '_contact_recipient', true));
    $email   = sanitize_email((string) get_post_meta($post_id, '_contact_email', true));
    $motif   = (string) get_post_meta($post_id, '_contact_motif_label', true);
    $first   = (string) get_post_meta($post_id, '_contact_first_name', true);
    $last    = (string) get_post_meta($post_id, '_contact_last_name', true);
    $phone   = (string) get_post_meta($post_id, '_contact_phone', true);
    $message = (string) get_post_meta($post_id, '_contact_message', true);

    if (!is_email($to)) {
        $to = acharp_contact_settings()['notify_email'];
    }

    $subject = sprintf('[Contact] %s — %s', trim($first . ' ' . $last), $motif);
    $body    = sprintf(
        "Nouvelle demande de contact.\n\nMotif : %s\nNom : %s %s\nE-mail : %s\nTéléphone : %s\n\nMessage :\n%s\n\nFiche : %s\n",
        $motif,
        $first,
        $last,
        $email,
        $phone !== '' ? $phone : '—',
        $message,
        admin_url('post.php?post=' . (int) $post_id . '&action=edit')
    );

    $headers = array('Content-Type: text/plain; charset=UTF-8');

    if (is_email($email)) {
        $headers[] = 'Reply-To: ' . $email;
    }

    wp_mail($to, $subject, $body, $headers);
}

function acharp_contact_notify_visitor($post_id) {
    $email = sanitize_email((string) get_post_meta($post_id, '_contact_email', true));
    $first = (string) get_post_meta($post_id, '_contact_first_name', true);

    if (!is_email($email)) {
        return;
    }

    $subject = 'Nous avons bien reçu votre message';
    $body    = sprintf(
        "Bonjour %s,\n\nNous avons bien reçu votre demande. Notre équipe vous répondra dans les meilleurs délais.\n\nCet e-mail ne vous inscrit pas à une newsletter.\n\nAcadémie Charpentier\n",
        $first
    );

    wp_mail($email, $subject, $body, array('Content-Type: text/plain; charset=UTF-8'));
}

function acharp_contact_posts_by_email($email) {
    global $wpdb;

    $email = sanitize_email($email);

    if (!is_email($email)) {
        return array();
    }

    $ids = $wpdb->get_col($wpdb->prepare(
        "SELECT post_id FROM {$wpdb->postmeta} pm
         INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
         WHERE pm.meta_key = %s AND pm.meta_value = %s AND p.post_type = %s",
        '_contact_email',
        $email,
        ACHARP_CONTACT_CPT
    ));

    return array_map('intval', $ids);
}

function acharp_contact_purge() {
    global $wpdb;

    $ids = $wpdb->get_col($wpdb->prepare(
        "SELECT post_id FROM {$wpdb->postmeta} pm
         INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
         WHERE pm.meta_key = %s AND pm.meta_value <= %d AND p.post_type = %s
         LIMIT 50",
        '_contact_retention_until',
        time(),
        ACHARP_CONTACT_CPT
    ));

    foreach ($ids as $post_id) {
        wp_delete_post((int) $post_id, true);
        acharp_contact_log('purged', $post_id);
    }
}
add_action('acharp_contact_purge', 'acharp_contact_purge');

function acharp_contact_admin_menu() {
    add_submenu_page(
        'edit.php?post_type=' . ACHARP_CONTACT_CPT,
        'Réglages',
        'Réglages',
        ACHARP_CONTACT_CAP,
        'acharp-contact-settings',
        'acharp_contact_render_settings'
    );
}
add_action('admin_menu', 'acharp_contact_admin_menu');

function acharp_contact_register_settings() {
    register_setting('acharp_contact', 'acharp_contact_notify_email', array(
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_email',
    ));
    register_setting('acharp_contact', 'acharp_contact_retention_days', array(
        'type'              => 'integer',
        'sanitize_callback' => 'absint',
    ));
    register_setting('acharp_contact', 'acharp_contact_calendly', array(
        'type'              => 'string',
        'sanitize_callback' => static function ($value) {
            $url = esc_url_raw($value);

            return acharp_contact_is_calendly_url($url) ? $url : 'https://calendly.com/admissions-academiecharpentier/30min';
        },
    ));
}
add_action('admin_init', 'acharp_contact_register_settings');

function acharp_contact_render_settings() {
    if (!acharp_contact_user_can_manage()) {
        wp_die(esc_html__('Vous n’avez pas l’autorisation de modifier ces réglages.', 'lsd_lang'));
    }

    $settings = acharp_contact_settings();
    ?>
    <div class="wrap">
        <h1>Réglages des demandes de contact</h1>
        <p>Les motifs et leurs destinataires se règlent sur la page utilisant le modèle <strong>Contact</strong>. Les adresses ne sont jamais exposées sur le site.</p>
        <form method="post" action="options.php">
            <?php settings_fields('acharp_contact'); ?>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="acharp_contact_notify_email">E-mail de repli</label></th>
                    <td>
                        <input name="acharp_contact_notify_email" id="acharp_contact_notify_email" type="email" class="regular-text" value="<?= esc_attr($settings['notify_email']); ?>">
                        <p class="description">Utilisé si un motif n’a pas d’adresse valide, et comme valeur par défaut.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="acharp_contact_retention_days">Durée de conservation (jours)</label></th>
                    <td>
                        <input name="acharp_contact_retention_days" id="acharp_contact_retention_days" type="number" min="30" max="2555" value="<?= esc_attr((string) $settings['retention_days']); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="acharp_contact_calendly">URL Calendly</label></th>
                    <td>
                        <input name="acharp_contact_calendly" id="acharp_contact_calendly" type="url" class="regular-text" value="<?= esc_attr($settings['calendly']); ?>">
                        <p class="description">Affichée après envoi uniquement pour les motifs marqués « Découvrir l’école / Calendly ».</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function acharp_contact_columns($columns) {
    return array(
        'cb'     => $columns['cb'] ?? '',
        'title'  => 'Nom',
        'email'  => 'E-mail',
        'phone'  => 'Téléphone',
        'motif'  => 'Motif',
        'date'   => 'Date',
    );
}
add_filter('manage_' . ACHARP_CONTACT_CPT . '_posts_columns', 'acharp_contact_columns');

function acharp_contact_column_content($column, $post_id) {
    if ($column === 'email') {
        echo esc_html((string) get_post_meta($post_id, '_contact_email', true));
    }

    if ($column === 'phone') {
        echo esc_html((string) get_post_meta($post_id, '_contact_phone', true) ?: '—');
    }

    if ($column === 'motif') {
        echo esc_html((string) get_post_meta($post_id, '_contact_motif_label', true));
    }
}
add_action('manage_' . ACHARP_CONTACT_CPT . '_posts_custom_column', 'acharp_contact_column_content', 10, 2);

function acharp_contact_row_actions($actions, $post) {
    if ($post->post_type !== ACHARP_CONTACT_CPT) {
        return $actions;
    }

    unset($actions['inline hide-if-no-js'], $actions['view']);

    return $actions;
}
add_filter('post_row_actions', 'acharp_contact_row_actions', 10, 2);

function acharp_contact_metaboxes() {
    add_meta_box(
        'acharp_contact_details',
        'Demande',
        'acharp_contact_render_metabox',
        ACHARP_CONTACT_CPT,
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'acharp_contact_metaboxes');

function acharp_contact_render_metabox($post) {
    if (!acharp_contact_user_can_manage()) {
        return;
    }

    $until = (int) get_post_meta($post->ID, '_contact_retention_until', true);
    ?>
    <table class="widefat striped">
        <tbody>
            <tr><th>Prénom</th><td><?= esc_html((string) get_post_meta($post->ID, '_contact_first_name', true)); ?></td></tr>
            <tr><th>Nom</th><td><?= esc_html((string) get_post_meta($post->ID, '_contact_last_name', true)); ?></td></tr>
            <tr><th>E-mail</th><td><?= esc_html((string) get_post_meta($post->ID, '_contact_email', true)); ?></td></tr>
            <tr><th>Téléphone</th><td><?= esc_html((string) get_post_meta($post->ID, '_contact_phone', true) ?: '—'); ?></td></tr>
            <tr><th>Motif</th><td><?= esc_html((string) get_post_meta($post->ID, '_contact_motif_label', true)); ?></td></tr>
            <tr><th>Destinataire</th><td><?= esc_html((string) get_post_meta($post->ID, '_contact_recipient', true)); ?></td></tr>
            <tr><th>Calendly</th><td><?= ((int) get_post_meta($post->ID, '_contact_show_calendly', true) === 1) ? 'Oui' : 'Non'; ?></td></tr>
            <tr><th>Date</th><td><?= esc_html(get_the_date('d/m/Y H:i', $post)); ?></td></tr>
            <tr><th>Conservation jusqu’au</th><td><?= $until ? esc_html(wp_date('d/m/Y', $until)) : '—'; ?></td></tr>
            <tr><th>Newsletter</th><td>Non inscrite</td></tr>
        </tbody>
    </table>
    <h3>Message</h3>
    <p><?= nl2br(esc_html((string) get_post_meta($post->ID, '_contact_message', true))); ?></p>
    <?php
}

function acharp_contact_privacy_exporters($exporters) {
    $exporters['acharp-contact'] = array(
        'exporter_friendly_name' => 'Demandes de contact',
        'callback'               => 'acharp_contact_export_personal_data',
    );

    return $exporters;
}
add_filter('wp_privacy_personal_data_exporters', 'acharp_contact_privacy_exporters');

function acharp_contact_privacy_erasers($erasers) {
    $erasers['acharp-contact'] = array(
        'eraser_friendly_name' => 'Demandes de contact',
        'callback'             => 'acharp_contact_erase_personal_data',
    );

    return $erasers;
}
add_filter('wp_privacy_personal_data_erasers', 'acharp_contact_privacy_erasers');

function acharp_contact_export_personal_data($email, $page = 1) {
    unset($page);
    $data = array();

    foreach (acharp_contact_posts_by_email($email) as $post_id) {
        $item = array();

        foreach (array('first_name', 'last_name', 'email', 'phone', 'motif_label', 'message') as $key) {
            $item[] = array(
                'name'  => $key,
                'value' => (string) get_post_meta($post_id, '_contact_' . $key, true),
            );
        }

        $data[] = array(
            'group_id'    => 'acharp-contact',
            'group_label' => 'Demandes de contact',
            'item_id'     => 'contact-' . $post_id,
            'data'        => $item,
        );
    }

    return array(
        'data' => $data,
        'done' => true,
    );
}

function acharp_contact_erase_personal_data($email, $page = 1) {
    unset($page);
    $items = acharp_contact_posts_by_email($email);
    $count = 0;

    foreach ($items as $post_id) {
        wp_delete_post((int) $post_id, true);
        $count++;
    }

    return array(
        'items_removed'  => $count > 0,
        'items_retained' => false,
        'messages'       => array(),
        'done'           => true,
    );
}

function acharp_contact_admin_css() {
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;

    if (!$screen || $screen->post_type !== ACHARP_CONTACT_CPT) {
        return;
    }

    echo '<style>.page-title-action,.misc-pub-visibility,#preview-action{display:none!important}</style>';
}
add_action('admin_head', 'acharp_contact_admin_css');
