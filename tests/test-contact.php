<?php
/**
 * Tests du parcours contact.
 *
 * Usage : php tests/test-contact.php
 */

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
    $mails[] = $atts;
    return true;
}, 10, 2);

function acharp_contact_test_assert($ok, $label) {
    global $failures;

    if ($ok) {
        echo "OK  {$label}\n";
        return;
    }

    $failures++;
    echo "KO  {$label}\n";
}

$page_id = wp_insert_post(array(
    'post_type'    => 'page',
    'post_status'  => 'publish',
    'post_title'   => 'Contact test',
    'post_content' => '',
    'meta_input'   => array(
        '_wp_page_template' => 'page-contact.php',
    ),
), true);

acharp_contact_test_assert(!is_wp_error($page_id) && $page_id, 'Page Contact de test créée');
acharp_contact_test_assert(acharp_contact_is_contact_page((int) $page_id), 'Modèle Contact reconnu');
acharp_contact_test_assert(!acharp_contact_is_contact_page(0), 'Page invalide refusée');

$motifs = acharp_contact_normalize_motifs(array(
    array('label' => 'Découvrir l’école', 'recipient_email' => 'visite@example.com', 'show_calendly' => 1),
    array('label' => 'Admissions', 'recipient_email' => 'admissions-secret@example.com', 'show_calendly' => 0),
), (int) $page_id);

add_filter('acharp_contact_motifs', static function () use ($motifs) {
    return $motifs;
});

$public = acharp_contact_public_motifs((int) $page_id);
$json   = wp_json_encode($public);

acharp_contact_test_assert(count($public) === 2, 'Motifs publics exposés sans e-mails');
acharp_contact_test_assert(strpos($json, '@') === false, 'Aucune adresse destinataire dans le payload public');
acharp_contact_test_assert(strpos($json, 'admissions-secret') === false, 'Adresse interne absente du JSON public');
acharp_contact_test_assert(acharp_contact_find_motif((int) $page_id, $motifs[0]['id'])['email'] === 'visite@example.com', 'Destinataire résolu côté serveur');
acharp_contact_test_assert(!empty($motifs[0]['show_calendly']), 'Calendly associé au motif Découvrir l’école');
acharp_contact_test_assert(empty($motifs[1]['show_calendly']), 'Pas de Calendly sur Admissions');
acharp_contact_test_assert(acharp_contact_is_calendly_url('https://calendly.com/admissions-academiecharpentier/30min'), 'URL Calendly acceptée');
acharp_contact_test_assert(!acharp_contact_is_calendly_url('https://evil.example/calendly.com'), 'URL Calendly étrangère refusée');

$invalid = acharp_contact_validate(array(), (int) $page_id);
acharp_contact_test_assert(is_wp_error($invalid), 'Formulaire vide refusé');

$payload = array(
    'first_name' => 'Ada',
    'last_name'  => 'Lovelace',
    'email'      => 'ada.contact@example.com',
    'phone'      => '',
    'motif'      => $motifs[0]['id'],
    'message'    => 'Bonjour, je souhaite visiter l’école la semaine prochaine.',
    'consent'    => 1,
);

$valid = acharp_contact_validate($payload, (int) $page_id);
acharp_contact_test_assert(!is_wp_error($valid), 'Demande valide avec téléphone facultatif');
acharp_contact_test_assert(!is_wp_error($valid) && $valid['phone'] === '', 'Téléphone vide accepté');

$bad_phone = acharp_contact_validate(array_merge($payload, array('phone' => '12')), (int) $page_id);
acharp_contact_test_assert(is_wp_error($bad_phone) && !empty($bad_phone->get_error_data()['phone']), 'Téléphone trop court refusé');

$post_id = acharp_contact_store($valid, (int) $page_id);
acharp_contact_test_assert(!is_wp_error($post_id) && $post_id, 'Demande enregistrée hors candidatures');
acharp_contact_test_assert(get_post_type($post_id) === ACHARP_CONTACT_CPT, 'CPT Demandes de contact utilisé');
acharp_contact_test_assert(get_post_meta($post_id, '_contact_recipient', true) === 'visite@example.com', 'Destinataire stocké en privé');
acharp_contact_test_assert((int) get_post_meta($post_id, '_contact_show_calendly', true) === 1, 'Flag Calendly enregistré');
acharp_contact_test_assert(get_post_meta($post_id, '_newsletter', true) === '', 'Aucune inscription newsletter');

$success = acharp_contact_success_payload((int) $post_id);
acharp_contact_test_assert(!empty($success['calendly']), 'Calendly renvoyé après envoi du motif visite');

acharp_contact_notify_recipient((int) $post_id);
acharp_contact_notify_visitor((int) $post_id);

$tos = array_map(static function ($mail) {
    return $mail['to'] ?? '';
}, $mails);

acharp_contact_test_assert(in_array('visite@example.com', $tos, true), 'E-mail envoyé au destinataire du motif');
acharp_contact_test_assert(in_array('ada.contact@example.com', $tos, true), 'E-mail de confirmation envoyé au visiteur');

$found_ids = acharp_contact_posts_by_email('ada.contact@example.com');
acharp_contact_test_assert(in_array((int) $post_id, $found_ids, true), 'Recherche RGPD par requête préparée');

wp_delete_post((int) $post_id, true);
wp_delete_post((int) $page_id, true);

if ($failures) {
    echo "\n{$failures} test(s) en échec.\n";
    exit(1);
}

echo "\nParcours contact validé.\n";
exit(0);
