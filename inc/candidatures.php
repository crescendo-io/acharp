<?php

defined('ABSPATH') || exit;

const ACHARP_CANDIDATURE_CPT = 'candidature';
const ACHARP_CANDIDATURE_CAP = 'manage_candidatures';

function acharp_candidature_formations() {
    return array(
        'prepa'   => 'Prépa',
        'annee_1' => '1re année',
        'annee_2' => '2e année',
        'annee_3' => '3e année',
        'annee_4' => '4e année',
    );
}

function acharp_candidature_statuses() {
    return array(
        'a_completer'     => 'À compléter',
        'dossier_complet' => 'Dossier complet',
    );
}

function acharp_candidature_file_fields() {
    return array(
        'cv'        => array('label' => 'CV', 'multiple' => false, 'required' => true),
        'lettre'    => array('label' => 'Lettre de motivation', 'multiple' => false, 'required' => true),
        'releves'   => array('label' => 'Relevés de notes', 'multiple' => true, 'required' => true),
        'diplomes'  => array('label' => 'Diplômes', 'multiple' => true, 'required' => true),
        'portfolio' => array('label' => 'Portfolio', 'multiple' => true, 'required' => false),
    );
}

function acharp_candidature_needs_portfolio($formation) {
    return in_array($formation, array('annee_2', 'annee_3', 'annee_4'), true);
}

function acharp_candidature_needs_calendly($formation) {
    return acharp_candidature_needs_portfolio($formation);
}

function acharp_candidature_allowed_mimes($field) {
    $docs = array(
        'pdf'  => array('application/pdf'),
        'jpg'  => array('image/jpeg'),
        'jpeg' => array('image/jpeg'),
        'png'  => array('image/png'),
        'doc'  => array('application/msword'),
        'docx' => array('application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
    );

    if ($field === 'portfolio') {
        $docs['zip'] = array('application/zip', 'application/x-zip-compressed');
    }

    return $docs;
}

function acharp_candidature_settings() {
    $days = (int) get_option('acharp_candidature_retention_days', 365);
    $max  = (int) get_option('acharp_candidature_max_bytes', 8 * MB_IN_BYTES);
    $mail = sanitize_email((string) get_option('acharp_candidature_notify_email', get_option('admin_email')));
    $url  = esc_url_raw((string) get_option(
        'acharp_candidature_calendly',
        'https://calendly.com/admissions-academiecharpentier/30min'
    ));

    if ($days < 30) {
        $days = 30;
    }

    if ($days > 2555) {
        $days = 2555;
    }

    if ($max < MB_IN_BYTES) {
        $max = MB_IN_BYTES;
    }

    if ($max > 20 * MB_IN_BYTES) {
        $max = 20 * MB_IN_BYTES;
    }

    if (!$mail) {
        $mail = sanitize_email((string) get_option('admin_email'));
    }

    if (!acharp_candidature_is_calendly_url($url)) {
        $url = 'https://calendly.com/admissions-academiecharpentier/30min';
    }

    return array(
        'retention_days' => $days,
        'max_bytes'      => $max,
        'notify_email'   => $mail,
        'calendly'       => $url,
    );
}

function acharp_candidature_is_calendly_url($url) {
    if (!$url) {
        return false;
    }

    $parts = wp_parse_url($url);

    return !empty($parts['scheme']) && $parts['scheme'] === 'https'
        && !empty($parts['host']) && preg_match('/(^|\.)calendly\.com$/i', $parts['host']);
}

function acharp_candidature_register_cpt() {
    register_post_type(ACHARP_CANDIDATURE_CPT, array(
        'labels' => array(
            'name'               => 'Candidatures',
            'singular_name'      => 'Candidature',
            'menu_name'          => 'Candidatures',
            'all_items'          => 'Toutes les candidatures',
            'view_item'          => 'Voir la candidature',
            'search_items'       => 'Rechercher une candidature',
            'not_found'          => 'Aucune candidature',
            'not_found_in_trash' => 'Aucune candidature dans la corbeille',
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
        'menu_icon'           => 'dashicons-id',
        'supports'            => array('title'),
        'capability_type'     => 'candidature',
        'map_meta_cap'        => false,
        'capabilities'        => array(
            'edit_post'              => ACHARP_CANDIDATURE_CAP,
            'read_post'              => ACHARP_CANDIDATURE_CAP,
            'delete_post'            => ACHARP_CANDIDATURE_CAP,
            'edit_posts'             => ACHARP_CANDIDATURE_CAP,
            'edit_others_posts'      => ACHARP_CANDIDATURE_CAP,
            'edit_private_posts'     => ACHARP_CANDIDATURE_CAP,
            'delete_posts'           => ACHARP_CANDIDATURE_CAP,
            'delete_others_posts'    => ACHARP_CANDIDATURE_CAP,
            'delete_private_posts'   => ACHARP_CANDIDATURE_CAP,
            'publish_posts'          => ACHARP_CANDIDATURE_CAP,
            'read_private_posts'     => ACHARP_CANDIDATURE_CAP,
            'create_posts'           => 'do_not_allow',
        ),
    ));
}
add_action('init', 'acharp_candidature_register_cpt');

function acharp_candidature_grant_caps() {
    $role = get_role('administrator');

    if ($role && !$role->has_cap(ACHARP_CANDIDATURE_CAP)) {
        $role->add_cap(ACHARP_CANDIDATURE_CAP);
    }
}
add_action('init', 'acharp_candidature_grant_caps', 20);
add_action('after_switch_theme', 'acharp_candidature_grant_caps');

function acharp_candidature_user_can_manage() {
    return current_user_can(ACHARP_CANDIDATURE_CAP);
}

function acharp_candidature_schedule_cron() {
    if (!wp_next_scheduled('acharp_candidature_purge')) {
        wp_schedule_event(time() + HOUR_IN_SECONDS, 'daily', 'acharp_candidature_purge');
    }
}
add_action('init', 'acharp_candidature_schedule_cron');

function acharp_candidature_unschedule_cron() {
    $timestamp = wp_next_scheduled('acharp_candidature_purge');

    if ($timestamp) {
        wp_unschedule_event($timestamp, 'acharp_candidature_purge');
    }
}
add_action('switch_theme', 'acharp_candidature_unschedule_cron');

function acharp_candidature_assets() {
    wp_enqueue_script(
        'acharp-candidature',
        get_stylesheet_directory_uri() . '/js/candidature.js',
        array(),
        filemtime(get_stylesheet_directory() . '/js/candidature.js'),
        true
    );

    $settings = acharp_candidature_settings();

    wp_localize_script('acharp-candidature', 'acharpCandidature', array(
        'ajaxUrl'      => admin_url('admin-ajax.php'),
        'nonce'        => wp_create_nonce('acharp_candidature'),
        'maxBytes'     => $settings['max_bytes'],
        'issuedAt'     => (string) time(),
        'issuedSig'    => acharp_candidature_sign_timestamp(time()),
        'needsPortfolio' => array('annee_2', 'annee_3', 'annee_4'),
    ));
}
add_action('wp_enqueue_scripts', 'acharp_candidature_assets');

function acharp_candidature_sign_timestamp($time) {
    return hash_hmac('sha256', (string) (int) $time, wp_salt('nonce'));
}

function acharp_candidature_verify_timestamp($time, $sig) {
    $time = (int) $time;

    if ($time < 1 || !hash_equals(acharp_candidature_sign_timestamp($time), (string) $sig)) {
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

function acharp_candidature_render_modal() {
    if (is_admin()) {
        return;
    }

    get_template_part('template-parts/general/modal-candidature');
}
add_action('wp_footer', 'acharp_candidature_render_modal', 5);

function acharp_candidature_storage_root() {
    $uploads = wp_upload_dir(null, false);

    return trailingslashit($uploads['basedir']) . 'acharp-private/candidatures';
}

function acharp_candidature_storage_dir($post_id, $create = false) {
    $dir = acharp_candidature_storage_root() . '/' . (int) $post_id;

    if ($create) {
        wp_mkdir_p($dir);
        acharp_candidature_protect_dir(acharp_candidature_storage_root());
        acharp_candidature_protect_dir($dir);
    }

    return $dir;
}

function acharp_candidature_protect_dir($dir) {
    if (!is_dir($dir)) {
        return;
    }

    $htaccess = $dir . '/.htaccess';
    $index    = $dir . '/index.php';

    if (!file_exists($htaccess)) {
        file_put_contents($htaccess, "Require all denied\n<IfModule !mod_authz_core.c>\nDeny from all\n</IfModule>\n");
    }

    if (!file_exists($index)) {
        file_put_contents($index, "<?php\n// Silence.\n");
    }
}

function acharp_candidature_client_ip() {
    $ip = isset($_SERVER['REMOTE_ADDR']) ? wp_unslash($_SERVER['REMOTE_ADDR']) : '';

    return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
}

function acharp_candidature_ip_key() {
    return 'acharp_cand_rl_' . hash_hmac('sha256', acharp_candidature_client_ip(), wp_salt('nonce'));
}

function acharp_candidature_rate_limited() {
    $key   = acharp_candidature_ip_key();
    $hits  = (int) get_transient($key);
    $limit = 8;

    if ($hits >= $limit) {
        return true;
    }

    set_transient($key, $hits + 1, HOUR_IN_SECONDS);

    return false;
}

function acharp_candidature_log($code, $post_id = 0) {
    if (!defined('WP_DEBUG') || !WP_DEBUG) {
        return;
    }

    error_log('acharp_candidature code=' . sanitize_key($code) . ($post_id ? ' id=' . (int) $post_id : ''));
}

function acharp_candidature_hash_token($token) {
    return hash_hmac('sha256', (string) $token, wp_salt('auth'));
}

function acharp_candidature_find_by_token($token) {
    global $wpdb;

    $token = (string) $token;

    if (strlen($token) < 20) {
        return 0;
    }

    $hash = acharp_candidature_hash_token($token);
    $id   = (int) $wpdb->get_var($wpdb->prepare(
        "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = %s AND meta_value = %s LIMIT 1",
        '_candidature_token_hash',
        $hash
    ));

    if (!$id || get_post_type($id) !== ACHARP_CANDIDATURE_CPT) {
        return 0;
    }

    return $id;
}

function acharp_candidature_sanitize_phone($phone) {
    $phone = sanitize_text_field($phone);
    $phone = preg_replace('/[^\d+\s().-]/', '', $phone);

    return trim((string) $phone);
}

function acharp_candidature_validate_step1($input) {
    $errors = array();
    $data   = array(
        'first_name' => sanitize_text_field($input['first_name'] ?? ''),
        'last_name'  => sanitize_text_field($input['last_name'] ?? ''),
        'email'      => sanitize_email($input['email'] ?? ''),
        'phone'      => acharp_candidature_sanitize_phone($input['phone'] ?? ''),
        'school'     => sanitize_text_field($input['school'] ?? ''),
        'bac'        => sanitize_key($input['bac'] ?? ''),
        'formation'  => sanitize_key($input['formation'] ?? ''),
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

    $digits = preg_replace('/\D+/', '', $data['phone']);

    if (strlen($digits) < 8 || strlen($digits) > 15) {
        $errors['phone'] = 'Indiquez un numéro de téléphone valide.';
    }

    if ($data['school'] === '' || mb_strlen($data['school']) > 160) {
        $errors['school'] = 'Indiquez votre établissement actuel.';
    }

    if (!in_array($data['bac'], array('oui', 'non'), true)) {
        $errors['bac'] = 'Indiquez si vous avez obtenu le bac.';
    }

    if (!isset(acharp_candidature_formations()[$data['formation']])) {
        $errors['formation'] = 'Choisissez une formation.';
    }

    if (!$data['consent']) {
        $errors['consent'] = 'Le consentement est obligatoire pour déposer une candidature.';
    }

    if ($errors) {
        return new WP_Error('invalid', 'Veuillez corriger les champs indiqués.', $errors);
    }

    return $data;
}

function acharp_candidature_extension($filename) {
    return strtolower(pathinfo((string) $filename, PATHINFO_EXTENSION));
}

function acharp_candidature_mime_ok($field, $tmp, $filename) {
    $ext   = acharp_candidature_extension($filename);
    $map   = acharp_candidature_allowed_mimes($field);
    $mimes = $map[$ext] ?? array();

    if (!$mimes || !is_readable($tmp)) {
        return false;
    }

    $detected = '';

    if (class_exists('finfo')) {
        $finfo    = new finfo(FILEINFO_MIME_TYPE);
        $detected = (string) $finfo->file($tmp);
    }

    if (!$detected && function_exists('mime_content_type')) {
        $detected = (string) mime_content_type($tmp);
    }

    return $detected && in_array($detected, $mimes, true);
}

function acharp_candidature_normalize_files($field) {
    if (empty($_FILES[$field]) || !is_array($_FILES[$field])) {
        return array();
    }

    $bucket = $_FILES[$field];
    $items  = array();

    if (is_array($bucket['name'])) {
        foreach ($bucket['name'] as $i => $name) {
            $items[] = array(
                'name'     => $name,
                'type'     => $bucket['type'][$i] ?? '',
                'tmp_name' => $bucket['tmp_name'][$i] ?? '',
                'error'    => $bucket['error'][$i] ?? UPLOAD_ERR_NO_FILE,
                'size'     => $bucket['size'][$i] ?? 0,
            );
        }
    } else {
        $items[] = $bucket;
    }

    return array_values(array_filter($items, static function ($file) {
        return !empty($file['name']) && (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE;
    }));
}

function acharp_candidature_move_uploaded($tmp, $dest) {
    if (defined('ACHARP_CANDIDATURE_TESTING') && ACHARP_CANDIDATURE_TESTING) {
        return copy($tmp, $dest);
    }

    return is_uploaded_file($tmp) && move_uploaded_file($tmp, $dest);
}

function acharp_candidature_store_files($post_id, $formation) {
    $settings = acharp_candidature_settings();
    $dir      = acharp_candidature_storage_dir($post_id, true);
    $stored   = array();
    $errors   = array();

    foreach (acharp_candidature_file_fields() as $field => $config) {
        $files    = acharp_candidature_normalize_files($field);
        $required = $config['required'] || ($field === 'portfolio' && acharp_candidature_needs_portfolio($formation));
        $max      = $config['multiple'] ? 5 : 1;

        if ($required && !$files) {
            $errors[$field] = 'Ce document est obligatoire.';
            continue;
        }

        if (count($files) > $max) {
            $errors[$field] = 'Trop de fichiers pour ce champ.';
            continue;
        }

        foreach ($files as $file) {
            $error = (int) ($file['error'] ?? UPLOAD_ERR_OK);

            if ($error !== UPLOAD_ERR_OK) {
                $errors[$field] = 'Le fichier n’a pas pu être reçu.';
                break;
            }

            if ((int) $file['size'] <= 0 || (int) $file['size'] > $settings['max_bytes']) {
                $errors[$field] = 'Fichier trop volumineux.';
                break;
            }

            $original = sanitize_file_name(wp_basename($file['name']));

            if (!acharp_candidature_mime_ok($field, $file['tmp_name'], $original)) {
                $errors[$field] = 'Format non accepté.';
                break;
            }

            $ext      = acharp_candidature_extension($original);
            $basename = bin2hex(random_bytes(16)) . '.' . $ext;
            $dest     = $dir . '/' . $basename;

            if (!acharp_candidature_move_uploaded($file['tmp_name'], $dest)) {
                $errors[$field] = 'Impossible d’enregistrer le fichier.';
                acharp_candidature_log('move_failed', $post_id);
                break;
            }

            chmod($dest, 0600);

            $mime = '';

            if (class_exists('finfo')) {
                $mime = (string) (new finfo(FILEINFO_MIME_TYPE))->file($dest);
            }

            $stored[$field][] = array(
                'file'     => $basename,
                'original' => $original,
                'mime'     => $mime,
                'size'     => (int) filesize($dest),
            );
        }
    }

    if ($errors) {
        acharp_candidature_delete_files($post_id);
        return new WP_Error('files', 'Certains documents sont invalides.', $errors);
    }

    return $stored;
}

function acharp_candidature_delete_files($post_id) {
    $dir = acharp_candidature_storage_dir($post_id, false);

    if (!is_dir($dir)) {
        return;
    }

    $root = realpath(acharp_candidature_storage_root());
    $real = realpath($dir);

    if (!$root || !$real || strpos($real, $root) !== 0) {
        return;
    }

    foreach ((array) glob($real . '/*') as $path) {
        if (is_file($path) && basename($path) !== '.htaccess' && basename($path) !== 'index.php') {
            wp_delete_file($path);
        }
    }
}

function acharp_candidature_ajax_guard() {
    if (!check_ajax_referer('acharp_candidature', 'nonce', false)) {
        wp_send_json_error(array('message' => 'Session expirée. Rechargez la page.'), 403);
    }

    if (acharp_candidature_rate_limited()) {
        acharp_candidature_log('rate_limited');
        wp_send_json_error(array('message' => 'Trop de tentatives. Réessayez plus tard.'), 429);
    }

    $honeypot = sanitize_text_field(wp_unslash($_POST['fax_number'] ?? ''));

    if ($honeypot !== '') {
        wp_send_json_success(array(
            'token'   => wp_generate_password(32, false, false),
            'message' => 'Votre candidature a bien été enregistrée.',
        ));
    }

    $timing = acharp_candidature_verify_timestamp(
        wp_unslash($_POST['issued_at'] ?? ''),
        wp_unslash($_POST['issued_sig'] ?? '')
    );

    if (is_wp_error($timing)) {
        wp_send_json_error(array('message' => $timing->get_error_message()), 400);
    }
}

function acharp_candidature_ajax_step1() {
    acharp_candidature_ajax_guard();

    $validated = acharp_candidature_validate_step1(wp_unslash($_POST));

    if (is_wp_error($validated)) {
        wp_send_json_error(array(
            'message' => $validated->get_error_message(),
            'fields'  => $validated->get_error_data(),
        ), 400);
    }

    $token = wp_generate_password(48, false, false);
    $title = $validated['first_name'] . ' ' . $validated['last_name'];

    $post_id = wp_insert_post(array(
        'post_type'   => ACHARP_CANDIDATURE_CPT,
        'post_status' => 'private',
        'post_title'  => $title,
        'post_author' => 0,
    ), true);

    if (is_wp_error($post_id) || !$post_id) {
        acharp_candidature_log('insert_failed');
        wp_send_json_error(array('message' => 'Impossible d’enregistrer la candidature.'), 500);
    }

    foreach ($validated as $key => $value) {
        if ($key === 'consent') {
            update_post_meta($post_id, '_candidature_consent', 1);
            update_post_meta($post_id, '_candidature_consent_at', time());
            continue;
        }

        update_post_meta($post_id, '_candidature_' . $key, $value);
    }

    update_post_meta($post_id, '_candidature_status', 'a_completer');
    update_post_meta($post_id, '_candidature_token_hash', acharp_candidature_hash_token($token));
    update_post_meta($post_id, '_candidature_retention_until', time() + (acharp_candidature_settings()['retention_days'] * DAY_IN_SECONDS));

    acharp_candidature_notify_admin($post_id, 'a_completer');
    acharp_candidature_notify_user($post_id, 'a_completer');

    wp_send_json_success(array(
        'token'          => $token,
        'needsPortfolio' => acharp_candidature_needs_portfolio($validated['formation']),
        'message'        => 'Vos informations ont été enregistrées. Déposez maintenant vos documents.',
    ));
}
add_action('wp_ajax_acharp_candidature_step1', 'acharp_candidature_ajax_step1');
add_action('wp_ajax_nopriv_acharp_candidature_step1', 'acharp_candidature_ajax_step1');

function acharp_candidature_ajax_step2() {
    acharp_candidature_ajax_guard();

    $token   = sanitize_text_field(wp_unslash($_POST['token'] ?? ''));
    $post_id = acharp_candidature_find_by_token($token);

    if (!$post_id) {
        wp_send_json_error(array('message' => 'Candidature introuvable ou déjà finalisée.'), 404);
    }

    $status    = get_post_meta($post_id, '_candidature_status', true);
    $formation = get_post_meta($post_id, '_candidature_formation', true);

    if ($status === 'dossier_complet') {
        wp_send_json_success(acharp_candidature_success_payload($post_id, $formation));
    }

    $stored = acharp_candidature_store_files($post_id, $formation);

    if (is_wp_error($stored)) {
        wp_send_json_error(array(
            'message' => $stored->get_error_message(),
            'fields'  => $stored->get_error_data(),
        ), 400);
    }

    update_post_meta($post_id, '_candidature_files', $stored);
    update_post_meta($post_id, '_candidature_status', 'dossier_complet');
    update_post_meta($post_id, '_candidature_completed_at', time());
    delete_post_meta($post_id, '_candidature_token_hash');

    acharp_candidature_notify_admin($post_id, 'dossier_complet');
    acharp_candidature_notify_user($post_id, 'dossier_complet');

    wp_send_json_success(acharp_candidature_success_payload($post_id, $formation));
}
add_action('wp_ajax_acharp_candidature_step2', 'acharp_candidature_ajax_step2');
add_action('wp_ajax_nopriv_acharp_candidature_step2', 'acharp_candidature_ajax_step2');

function acharp_candidature_success_payload($post_id, $formation) {
    $settings = acharp_candidature_settings();
    $first    = get_post_meta($post_id, '_candidature_first_name', true);

    $payload = array(
        'message'  => sprintf('Merci %s, votre dossier est complet.', $first ?: ''),
        'calendly' => null,
    );

    if (acharp_candidature_needs_calendly($formation)) {
        $payload['calendly'] = $settings['calendly'];
        $payload['message'] .= ' Planifiez maintenant votre entretien.';
    }

    return $payload;
}

function acharp_candidature_notify_admin($post_id, $status) {
    $settings = acharp_candidature_settings();
    $labels   = acharp_candidature_statuses();
    $subject  = sprintf(
        '[Candidature] %s — %s',
        get_the_title($post_id),
        $labels[$status] ?? $status
    );
    $body     = sprintf(
        "Une candidature a été mise à jour.\n\nStatut : %s\nFiche : %s\n",
        $labels[$status] ?? $status,
        admin_url('post.php?post=' . (int) $post_id . '&action=edit')
    );

    wp_mail($settings['notify_email'], $subject, $body);
}

function acharp_candidature_notify_user($post_id, $status) {
    $email = get_post_meta($post_id, '_candidature_email', true);
    $first = get_post_meta($post_id, '_candidature_first_name', true);

    if (!is_email($email)) {
        return;
    }

    if ($status === 'a_completer') {
        $subject = 'Votre candidature a été ouverte';
        $body    = sprintf(
            "Bonjour %s,\n\nNous avons bien enregistré vos informations. Poursuivez le dépôt de vos documents pour finaliser votre dossier.\n\nAcadémie Charpentier\n",
            $first
        );
    } else {
        $subject = 'Votre dossier de candidature est complet';
        $body    = sprintf(
            "Bonjour %s,\n\nNous avons bien reçu votre dossier complet. Vous serez informé(e) de la suite du processus d’admission.\n\nAcadémie Charpentier\n",
            $first
        );
    }

    wp_mail($email, $subject, $body);
}

function acharp_candidature_purge() {
    $query = new WP_Query(array(
        'post_type'      => ACHARP_CANDIDATURE_CPT,
        'post_status'    => 'any',
        'posts_per_page' => 50,
        'fields'         => 'ids',
        'meta_query'     => array(
            array(
                'key'     => '_candidature_retention_until',
                'value'   => time(),
                'compare' => '<=',
                'type'    => 'NUMERIC',
            ),
        ),
        'no_found_rows'  => true,
    ));

    foreach ($query->posts as $post_id) {
        acharp_candidature_delete_files($post_id);
        wp_delete_post((int) $post_id, true);
        acharp_candidature_log('purged', $post_id);
    }
}
add_action('acharp_candidature_purge', 'acharp_candidature_purge');

function acharp_candidature_deleted($post_id) {
    if (get_post_type($post_id) === ACHARP_CANDIDATURE_CPT) {
        acharp_candidature_delete_files($post_id);
    }
}
add_action('before_delete_post', 'acharp_candidature_deleted');

function acharp_candidature_admin_menu() {
    add_submenu_page(
        'edit.php?post_type=' . ACHARP_CANDIDATURE_CPT,
        'Réglages RGPD',
        'Réglages RGPD',
        ACHARP_CANDIDATURE_CAP,
        'acharp-candidature-settings',
        'acharp_candidature_render_settings'
    );
}
add_action('admin_menu', 'acharp_candidature_admin_menu');

function acharp_candidature_register_settings() {
    register_setting('acharp_candidature', 'acharp_candidature_notify_email', array(
        'type'              => 'string',
        'sanitize_callback' => 'sanitize_email',
    ));
    register_setting('acharp_candidature', 'acharp_candidature_retention_days', array(
        'type'              => 'integer',
        'sanitize_callback' => 'absint',
    ));
    register_setting('acharp_candidature', 'acharp_candidature_max_bytes', array(
        'type'              => 'integer',
        'sanitize_callback' => 'absint',
    ));
    register_setting('acharp_candidature', 'acharp_candidature_calendly', array(
        'type'              => 'string',
        'sanitize_callback' => static function ($value) {
            $url = esc_url_raw($value);

            return acharp_candidature_is_calendly_url($url) ? $url : 'https://calendly.com/admissions-academiecharpentier/30min';
        },
    ));
}
add_action('admin_init', 'acharp_candidature_register_settings');

function acharp_candidature_render_settings() {
    if (!acharp_candidature_user_can_manage()) {
        wp_die(esc_html__('Vous n’avez pas l’autorisation de modifier ces réglages.', 'lsd_lang'));
    }

    $settings = acharp_candidature_settings();
    ?>
    <div class="wrap">
        <h1>Réglages des candidatures</h1>
        <form method="post" action="options.php">
            <?php settings_fields('acharp_candidature'); ?>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="acharp_candidature_notify_email">E-mail de notification</label></th>
                    <td>
                        <input name="acharp_candidature_notify_email" id="acharp_candidature_notify_email" type="email" class="regular-text" value="<?= esc_attr($settings['notify_email']); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="acharp_candidature_retention_days">Durée de conservation (jours)</label></th>
                    <td>
                        <input name="acharp_candidature_retention_days" id="acharp_candidature_retention_days" type="number" min="30" max="2555" value="<?= esc_attr((string) $settings['retention_days']); ?>">
                        <p class="description">Les dossiers et fichiers sont supprimés automatiquement au-delà de cette durée (minimum 30 jours).</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="acharp_candidature_max_bytes">Taille max. par fichier (octets)</label></th>
                    <td>
                        <input name="acharp_candidature_max_bytes" id="acharp_candidature_max_bytes" type="number" min="1048576" max="20971520" value="<?= esc_attr((string) $settings['max_bytes']); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="acharp_candidature_calendly">URL Calendly</label></th>
                    <td>
                        <input name="acharp_candidature_calendly" id="acharp_candidature_calendly" type="url" class="regular-text" value="<?= esc_attr($settings['calendly']); ?>">
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function acharp_candidature_columns($columns) {
    return array(
        'cb'         => $columns['cb'] ?? '',
        'title'      => 'Candidat',
        'email'      => 'E-mail',
        'phone'      => 'Téléphone',
        'formation'  => 'Formation',
        'status'     => 'Statut',
        'files'      => 'Fichiers',
        'date'       => 'Date de dépôt',
    );
}
add_filter('manage_' . ACHARP_CANDIDATURE_CPT . '_posts_columns', 'acharp_candidature_columns');

function acharp_candidature_column_content($column, $post_id) {
    $formations = acharp_candidature_formations();
    $statuses   = acharp_candidature_statuses();

    if ($column === 'email') {
        echo esc_html((string) get_post_meta($post_id, '_candidature_email', true));
    }

    if ($column === 'phone') {
        echo esc_html((string) get_post_meta($post_id, '_candidature_phone', true));
    }

    if ($column === 'formation') {
        $key = get_post_meta($post_id, '_candidature_formation', true);
        echo esc_html($formations[$key] ?? $key);
    }

    if ($column === 'status') {
        $key = get_post_meta($post_id, '_candidature_status', true);
        echo esc_html($statuses[$key] ?? $key);
    }

    if ($column === 'files') {
        $files = get_post_meta($post_id, '_candidature_files', true);
        echo is_array($files) ? esc_html((string) array_sum(array_map('count', $files))) : '0';
    }
}
add_action('manage_' . ACHARP_CANDIDATURE_CPT . '_posts_custom_column', 'acharp_candidature_column_content', 10, 2);

function acharp_candidature_row_actions($actions, $post) {
    if ($post->post_type !== ACHARP_CANDIDATURE_CPT) {
        return $actions;
    }

    unset($actions['inline hide-if-no-js'], $actions['view']);

    return $actions;
}
add_filter('post_row_actions', 'acharp_candidature_row_actions', 10, 2);

function acharp_candidature_metaboxes() {
    add_meta_box(
        'acharp_candidature_details',
        'Dossier',
        'acharp_candidature_render_metabox',
        ACHARP_CANDIDATURE_CPT,
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'acharp_candidature_metaboxes');

function acharp_candidature_file_download_url($post_id, $field, $index) {
    return wp_nonce_url(
        admin_url('admin-post.php?action=acharp_candidature_file&post=' . (int) $post_id . '&field=' . rawurlencode($field) . '&index=' . (int) $index),
        'acharp_candidature_file_' . $post_id
    );
}

function acharp_candidature_render_metabox($post) {
    if (!acharp_candidature_user_can_manage()) {
        return;
    }

    $formations = acharp_candidature_formations();
    $statuses   = acharp_candidature_statuses();
    $formation  = get_post_meta($post->ID, '_candidature_formation', true);
    $status     = get_post_meta($post->ID, '_candidature_status', true);
    $files      = get_post_meta($post->ID, '_candidature_files', true);
    $until      = (int) get_post_meta($post->ID, '_candidature_retention_until', true);
    ?>
    <table class="widefat striped">
        <tbody>
            <tr><th>Prénom</th><td><?= esc_html((string) get_post_meta($post->ID, '_candidature_first_name', true)); ?></td></tr>
            <tr><th>Nom</th><td><?= esc_html((string) get_post_meta($post->ID, '_candidature_last_name', true)); ?></td></tr>
            <tr><th>E-mail</th><td><?= esc_html((string) get_post_meta($post->ID, '_candidature_email', true)); ?></td></tr>
            <tr><th>Téléphone</th><td><?= esc_html((string) get_post_meta($post->ID, '_candidature_phone', true)); ?></td></tr>
            <tr><th>Établissement actuel</th><td><?= esc_html((string) get_post_meta($post->ID, '_candidature_school', true)); ?></td></tr>
            <tr><th>Bac obtenu</th><td><?= esc_html((string) get_post_meta($post->ID, '_candidature_bac', true)); ?></td></tr>
            <tr><th>Formation</th><td><?= esc_html($formations[$formation] ?? $formation); ?></td></tr>
            <tr><th>Statut</th><td><?= esc_html($statuses[$status] ?? $status); ?></td></tr>
            <tr><th>Date de dépôt</th><td><?= esc_html(get_the_date('d/m/Y H:i', $post)); ?></td></tr>
            <tr><th>Conservation jusqu’au</th><td><?= $until ? esc_html(wp_date('d/m/Y', $until)) : '—'; ?></td></tr>
        </tbody>
    </table>
    <h3>Fichiers reçus</h3>
    <?php if (!is_array($files) || !$files) : ?>
        <p>Aucun fichier pour le moment.</p>
    <?php else : ?>
        <ul>
            <?php foreach ($files as $field => $items) : ?>
                <?php foreach ((array) $items as $index => $item) : ?>
                    <li>
                        <a href="<?= esc_url(acharp_candidature_file_download_url($post->ID, $field, $index)); ?>">
                            <?= esc_html(($item['original'] ?? 'fichier') . ' (' . $field . ')'); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    <?php endif;
}

function acharp_candidature_download_file() {
    if (!acharp_candidature_user_can_manage()) {
        wp_die(esc_html__('Accès refusé.', 'lsd_lang'), '', array('response' => 403));
    }

    $post_id = isset($_GET['post']) ? (int) $_GET['post'] : 0;
    $field   = isset($_GET['field']) ? sanitize_key(wp_unslash($_GET['field'])) : '';
    $index   = isset($_GET['index']) ? (int) $_GET['index'] : 0;

    check_admin_referer('acharp_candidature_file_' . $post_id);

    if (!$post_id || get_post_type($post_id) !== ACHARP_CANDIDATURE_CPT) {
        wp_die(esc_html__('Candidature introuvable.', 'lsd_lang'), '', array('response' => 404));
    }

    $files = get_post_meta($post_id, '_candidature_files', true);
    $item  = is_array($files) ? ($files[$field][$index] ?? null) : null;

    if (!$item || empty($item['file'])) {
        wp_die(esc_html__('Fichier introuvable.', 'lsd_lang'), '', array('response' => 404));
    }

    $root = realpath(acharp_candidature_storage_root());
    $path = realpath(acharp_candidature_storage_dir($post_id) . '/' . basename($item['file']));

    if (!$root || !$path || strpos($path, $root) !== 0 || !is_file($path)) {
        wp_die(esc_html__('Fichier introuvable.', 'lsd_lang'), '', array('response' => 404));
    }

    nocache_headers();
    header('X-Content-Type-Options: nosniff');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . sanitize_file_name($item['original'] ?? 'document') . '"');
    header('Content-Length: ' . (string) filesize($path));
    readfile($path);
    exit;
}
add_action('admin_post_acharp_candidature_file', 'acharp_candidature_download_file');

function acharp_candidature_privacy_exporters($exporters) {
    $exporters['acharp-candidature'] = array(
        'exporter_friendly_name' => 'Candidatures',
        'callback'               => 'acharp_candidature_export_personal_data',
    );

    return $exporters;
}
add_filter('wp_privacy_personal_data_exporters', 'acharp_candidature_privacy_exporters');

function acharp_candidature_privacy_erasers($erasers) {
    $erasers['acharp-candidature'] = array(
        'eraser_friendly_name' => 'Candidatures',
        'callback'             => 'acharp_candidature_erase_personal_data',
    );

    return $erasers;
}
add_filter('wp_privacy_personal_data_erasers', 'acharp_candidature_privacy_erasers');

function acharp_candidature_posts_by_email($email) {
    return get_posts(array(
        'post_type'      => ACHARP_CANDIDATURE_CPT,
        'post_status'    => 'any',
        'posts_per_page' => 50,
        'meta_key'       => '_candidature_email',
        'meta_value'     => $email,
        'fields'         => 'ids',
    ));
}

function acharp_candidature_export_personal_data($email, $page = 1) {
    unset($page);
    $data = array();

    foreach (acharp_candidature_posts_by_email($email) as $post_id) {
        $item = array();

        foreach (array('first_name', 'last_name', 'email', 'phone', 'school', 'bac', 'formation', 'status') as $key) {
            $item[] = array(
                'name'  => $key,
                'value' => (string) get_post_meta($post_id, '_candidature_' . $key, true),
            );
        }

        $data[] = array(
            'group_id'    => 'acharp-candidature',
            'group_label' => 'Candidatures',
            'item_id'     => 'candidature-' . $post_id,
            'data'        => $item,
        );
    }

    return array(
        'data' => $data,
        'done' => true,
    );
}

function acharp_candidature_erase_personal_data($email, $page = 1) {
    unset($page);
    $items = acharp_candidature_posts_by_email($email);
    $count = 0;

    foreach ($items as $post_id) {
        acharp_candidature_delete_files($post_id);
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

function acharp_candidature_admin_css() {
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;

    if (!$screen || $screen->post_type !== ACHARP_CANDIDATURE_CPT) {
        return;
    }

    echo '<style>.page-title-action,.misc-pub-visibility,#preview-action{display:none!important}</style>';
}
add_action('admin_head', 'acharp_candidature_admin_css');
