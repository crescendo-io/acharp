<?php
$page_id   = get_the_ID();
$settings  = acharp_contact_settings();
$days      = (int) $settings['retention_days'];
$motifs    = acharp_contact_public_motifs($page_id);
$kicker    = acharp_field('contact_kicker') ?: 'Contact';
$title     = acharp_inline_html(acharp_field('contact_title'));
$intro     = acharp_inline_html(acharp_field('contact_intro'));
$phone     = acharp_field('contact_phone') ?: '01 43 54 31 12';
$email     = acharp_field('contact_email') ?: 'contact@academiecharpentier.fr';
$address   = acharp_inline_html(acharp_field('contact_address'));
$hours     = acharp_rows(acharp_field('contact_hours'));
$access    = acharp_rows(acharp_field('contact_access'));
$form_title = acharp_field('contact_form_title') ?: 'Écrire à l’école';
$form_text  = acharp_inline_html(acharp_field('contact_form_text'));
$lat        = acharp_field('contact_map_lat');
$lng        = acharp_field('contact_map_lng');
$map_src    = acharp_contact_map_src($lat, $lng);
$phone_href = preg_replace('/[^\d+]/', '', (string) $phone);

if (!$title) {
    $title = 'Venir, écrire,<br> <strong>échanger</strong>';
}

if (!$intro) {
    $intro = 'L’équipe de l’Académie Charpentier vous accueille sur le campus du 15<sup>e</sup> arrondissement et répond à vos questions.';
}

if (!$address) {
    $address = '50 Rue Sébastien Mercier,<br> 75015 Paris';
}

if (!$hours) {
    $hours = array(
        array('label' => 'Lundi — vendredi', 'value' => '9h00 – 18h00'),
        array('label' => 'Samedi & dimanche', 'value' => 'Fermé'),
    );
}

if (!$access) {
    $access = array(
        array('label' => 'Métro ligne 10 — Javel–André Citroën'),
        array('label' => 'RER C — Javel'),
        array('label' => 'Bus 42, 88'),
    );
}

if (!$form_text) {
    $form_text = 'Choisissez un motif : votre message est transmis à l’interlocuteur concerné. Aucune inscription à la newsletter n’est effectuée.';
}

$phone_link = $phone_href ? 'tel:+' . ltrim($phone_href, '+') : '';
if ($phone_href && strpos($phone_href, '0') === 0) {
    $phone_link = 'tel:+33' . substr($phone_href, 1);
}
?>

<section id="contact" class="contact">
    <div class="container-fluid">
        <div class="contact__grid">
            <div class="contact__infos">
                <?php if ($kicker) : ?>
                    <p class="contact__kicker"><?= esc_html($kicker); ?></p>
                <?php endif; ?>

                <h1 class="contact__title"><?= $title; ?></h1>

                <?php if ($intro) : ?>
                    <p class="contact__intro"><?= $intro; ?></p>
                <?php endif; ?>

                <ul class="contact__cards">
                    <li class="contact__card">
                        <span class="contact__card-icon" aria-hidden="true"><?= acharp_icon('pin', 'campus'); ?></span>
                        <div>
                            <p class="contact__card-label">Adresse</p>
                            <address class="contact__card-value"><?= $address; ?></address>
                        </div>
                    </li>
                    <li class="contact__card">
                        <span class="contact__card-icon" aria-hidden="true"><?= acharp_icon('mail', 'admissions'); ?></span>
                        <div>
                            <p class="contact__card-label">Coordonnées</p>
                            <p class="contact__card-value">
                                <?php if ($phone_link) : ?>
                                    <a href="<?= esc_url($phone_link); ?>"><?= esc_html($phone); ?></a><br>
                                <?php else : ?>
                                    <?= esc_html($phone); ?><br>
                                <?php endif; ?>
                                <a href="mailto:<?= esc_attr($email); ?>"><?= esc_html($email); ?></a>
                            </p>
                        </div>
                    </li>
                    <li class="contact__card">
                        <span class="contact__card-icon" aria-hidden="true"><?= acharp_icon('city', 'campus'); ?></span>
                        <div>
                            <p class="contact__card-label">Horaires</p>
                            <ul class="contact__hours">
                                <?php foreach ($hours as $row) : ?>
                                    <li>
                                        <span><?= esc_html($row['label'] ?? ''); ?></span>
                                        <?php if (!empty($row['value'])) : ?>
                                            <strong><?= esc_html($row['value']); ?></strong>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                    <li class="contact__card">
                        <span class="contact__card-icon" aria-hidden="true"><?= acharp_icon('metro', 'campus'); ?></span>
                        <div>
                            <p class="contact__card-label">Accès</p>
                            <ul class="contact__access">
                                <?php foreach ($access as $row) : ?>
                                    <li><?= esc_html($row['label'] ?? ''); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="contact__form-panel">
                <form class="contact-form" data-contact-form novalidate>
                    <h3 class="contact-form__title"><?= esc_html($form_title); ?></h3>
                    <?php if ($form_text) : ?>
                        <p class="contact-form__text"><?= $form_text; ?></p>
                    <?php endif; ?>

                    <div class="contact-form__alert" data-contact-alert hidden></div>

                    <?php wp_nonce_field('acharp_contact', 'nonce'); ?>
                    <input type="hidden" name="page_id" value="<?= esc_attr((string) $page_id); ?>">
                    <input type="hidden" name="issued_at" value="">
                    <input type="hidden" name="issued_sig" value="">

                    <p class="contact-form__honeypot">
                        <label for="contact-fax">Fax</label>
                        <input type="text" id="contact-fax" name="fax_number" tabindex="-1" autocomplete="off">
                    </p>

                    <div class="contact-form__fields" data-contact-fields>
                        <div class="candidature-modal__grid">
                            <p class="candidature-modal__field">
                                <label for="contact-first-name">Prénom</label>
                                <input id="contact-first-name" name="first_name" type="text" autocomplete="given-name" maxlength="80" required>
                            </p>
                            <p class="candidature-modal__field">
                                <label for="contact-last-name">Nom</label>
                                <input id="contact-last-name" name="last_name" type="text" autocomplete="family-name" maxlength="80" required>
                            </p>
                            <p class="candidature-modal__field">
                                <label for="contact-email">E-mail</label>
                                <input id="contact-email" name="email" type="email" autocomplete="email" required>
                            </p>
                            <p class="candidature-modal__field">
                                <label for="contact-phone">Téléphone <span class="contact-form__optional">(facultatif)</span></label>
                                <input id="contact-phone" name="phone" type="tel" autocomplete="tel">
                            </p>
                        </div>

                        <fieldset class="candidature-modal__fieldset">
                            <legend>Motif</legend>
                            <div class="candidature-choices candidature-choices--wrap">
                                <?php foreach ($motifs as $motif) : ?>
                                    <label class="candidature-choice">
                                        <input type="radio" name="motif" value="<?= esc_attr($motif['id']); ?>" required>
                                        <span><?= esc_html($motif['label']); ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </fieldset>

                        <p class="candidature-modal__field candidature-modal__field--full contact-form__message">
                            <label for="contact-message">Message</label>
                            <textarea id="contact-message" name="message" rows="6" maxlength="4000" required></textarea>
                        </p>

                        <p class="candidature-modal__consent">
                            <label class="candidature-check">
                                <input type="checkbox" name="consent" value="1" required>
                                <span>J’accepte que mes données soient utilisées pour traiter ma demande, et conservées <?= esc_html((string) $days); ?> jours, conformément au RGPD. Je ne serai pas inscrit(e) à une newsletter.</span>
                            </label>
                        </p>
                    </div>

                    <div class="contact-form__done" data-contact-success hidden>
                        <p data-contact-success-message></p>
                        <div class="contact-form__calendly" data-contact-calendly hidden></div>
                    </div>

                    <div class="contact-form__actions" data-contact-actions>
                        <button type="submit" class="btn btn--primary" data-contact-submit>
                            Envoyer
                            <?= acharp_arrow(); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="contact__map">
            <iframe
                title="Carte de l’Académie Charpentier"
                src="<?= esc_url($map_src); ?>"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
        </div>
    </div>
</section>
