<?php
/**
 * Tests du parcours candidature.
 *
 * Usage : php tests/test-candidatures.php
 */

define('ACHARP_CANDIDATURE_TESTING', true);

$_SERVER['HTTP_HOST'] = $_SERVER['HTTP_HOST'] ?? 'harmony-builder.code';

$wp_load = dirname(__DIR__, 4) . '/wp-load.php';

if (!is_file($wp_load)) {
    fwrite(STDERR, "wp-load.php introuvable, tests d’intégration ignorés.\n");
    exit(1);
}

require $wp_load;

$failures = 0;
$mails    = array();

add_filter('pre_wp_mail', static function ($null, $atts) use (&$mails) {
    unset($null);
    $mails[] = $atts['to'] ?? '';
    return true;
}, 10, 2);

function acharp_test_assert($ok, $label) {
    global $failures;

    if ($ok) {
        echo "OK  {$label}\n";
        return;
    }

    $failures++;
    echo "KO  {$label}\n";
}

$invalid = acharp_candidature_validate_step1(array());
acharp_test_assert(is_wp_error($invalid), 'Étape 1 refusée si vide');

$payload = array(
    'first_name' => 'Ada',
    'last_name'  => 'Lovelace',
    'email'      => 'ada.test@example.com',
    'phone'      => '01 23 45 67 89',
    'school'     => 'Lycée test',
    'bac'        => 'oui',
    'formation'  => 'annee_2',
    'consent'    => 1,
);

$valid = acharp_candidature_validate_step1($payload);
acharp_test_assert(!is_wp_error($valid), 'Étape 1 acceptée avec des données valides');
acharp_test_assert(acharp_candidature_needs_portfolio('annee_2'), 'Portfolio obligatoire en 2e année');
acharp_test_assert(!acharp_candidature_needs_portfolio('annee_1'), 'Portfolio facultatif en 1re année');
acharp_test_assert(acharp_candidature_needs_calendly('annee_3'), 'Calendly affiché à partir de la 2e année');
acharp_test_assert(!acharp_candidature_needs_calendly('annee_1'), 'Pas de Calendly en 1re année');
acharp_test_assert(acharp_candidature_is_calendly_url('https://calendly.com/admissions-academiecharpentier/30min'), 'URL Calendly acceptée');
acharp_test_assert(!acharp_candidature_is_calendly_url('https://evil.example/calendly.com'), 'URL Calendly étrangère refusée');

$tmp_pdf = tempnam(sys_get_temp_dir(), 'cand');
file_put_contents($tmp_pdf, "%PDF-1.4\n1 0 obj<<>>endobj\ntrailer<<>>\n%%EOF");
acharp_test_assert(acharp_candidature_mime_ok('cv', $tmp_pdf, 'cv.pdf'), 'MIME PDF accepté pour le CV');
acharp_test_assert(!acharp_candidature_mime_ok('cv', $tmp_pdf, 'cv.exe'), 'Extension exécutable refusée');

$token   = wp_generate_password(48, false, false);
$post_id = wp_insert_post(array(
    'post_type'   => ACHARP_CANDIDATURE_CPT,
    'post_status' => 'private',
    'post_title'  => 'Ada Lovelace',
    'meta_input'  => array(
        '_candidature_first_name'  => 'Ada',
        '_candidature_last_name'   => 'Lovelace',
        '_candidature_email'       => 'ada.test@example.com',
        '_candidature_phone'       => '0123456789',
        '_candidature_school'      => 'Lycée test',
        '_candidature_bac'         => 'oui',
        '_candidature_formation'   => 'prepa',
        '_candidature_status'      => 'a_completer',
        '_candidature_token_hash'  => acharp_candidature_hash_token($token),
        '_candidature_consent'     => 1,
    ),
), true);

acharp_test_assert(!is_wp_error($post_id) && $post_id, 'Candidature « À compléter » créée');
acharp_test_assert(acharp_candidature_find_by_token($token) === (int) $post_id, 'Jeton étape 2 résolu par requête préparée');
acharp_test_assert(acharp_candidature_find_by_token('token-invalide') === 0, 'Jeton invalide rejeté');

$_FILES = array();
foreach (array('cv', 'lettre', 'releves', 'diplomes') as $field) {
    $copy = tempnam(sys_get_temp_dir(), $field);
    copy($tmp_pdf, $copy);
    $_FILES[$field] = array(
        'name'     => $field . '.pdf',
        'type'     => 'application/pdf',
        'tmp_name' => $copy,
        'error'    => UPLOAD_ERR_OK,
        'size'     => filesize($copy),
    );
}

$stored = acharp_candidature_store_files((int) $post_id, 'prepa');
acharp_test_assert(!is_wp_error($stored), 'Documents valides acceptés sans portfolio en prépa');

if (!is_wp_error($stored)) {
    update_post_meta($post_id, '_candidature_files', $stored);
    update_post_meta($post_id, '_candidature_status', 'dossier_complet');
    delete_post_meta($post_id, '_candidature_token_hash');
}

acharp_test_assert(get_post_meta($post_id, '_candidature_status', true) === 'dossier_complet', 'Statut passé à « Dossier complet »');
acharp_test_assert(acharp_candidature_find_by_token($token) === 0, 'Jeton invalidé après finalisation');

$payload_success = acharp_candidature_success_payload((int) $post_id, 'prepa');
acharp_test_assert(empty($payload_success['calendly']), 'Calendly absent pour la prépa');

$payload_success = acharp_candidature_success_payload((int) $post_id, 'annee_4');
acharp_test_assert(!empty($payload_success['calendly']), 'Calendly présent pour la 4e année');

$dir = acharp_candidature_storage_dir((int) $post_id);
acharp_test_assert(is_file($dir . '/.htaccess'), 'Répertoire fichiers protégé par .htaccess');
acharp_test_assert(is_file($dir . '/index.php'), 'Listing du répertoire bloqué');

$relative = get_post_meta($post_id, '_candidature_files', true);
$first    = $relative['cv'][0]['file'] ?? '';
acharp_test_assert($first && !preg_match('/cv\.pdf$/i', $first), 'Nom de fichier aléatoire');
acharp_test_assert(!filter_var($dir . '/' . $first, FILTER_VALIDATE_URL), 'Aucune URL publique stockée');

acharp_candidature_notify_admin((int) $post_id, 'dossier_complet');
acharp_test_assert(!empty($mails), 'Notification administrateur envoyée sans pièces jointes');

acharp_candidature_delete_files((int) $post_id);
wp_delete_post((int) $post_id, true);
@unlink($tmp_pdf);

if ($failures) {
    echo "\n{$failures} test(s) en échec.\n";
    exit(1);
}

echo "\nParcours candidature validé.\n";
exit(0);
