<?php
$formations = acharp_candidature_formations();
$settings   = acharp_candidature_settings();
$max_mo     = max(1, (int) round($settings['max_bytes'] / MB_IN_BYTES));
$days       = (int) $settings['retention_days'];
$fields     = acharp_candidature_file_fields();
$arrow      = acharp_arrow();
$icons      = array(
    'cv'        => acharp_icon('file', 'admissions'),
    'lettre'    => acharp_icon('mail', 'admissions'),
    'releves'   => acharp_icon('file', 'admissions'),
    'diplomes'  => acharp_icon('diploma', 'admissions'),
    'portfolio' => acharp_icon('image', 'admissions'),
);
$hints = array(
    'cv'        => 'Un seul fichier',
    'lettre'    => 'Un seul fichier',
    'releves'   => 'Un ou plusieurs fichiers',
    'diplomes'  => 'Un ou plusieurs fichiers',
    'portfolio' => 'Un ou plusieurs fichiers, ZIP accepté',
);
?>
<div class="candidature-modal" id="candidature-modal" hidden>
    <div class="candidature-modal__backdrop" data-candidature-close tabindex="-1"></div>
    <div
        class="candidature-modal__dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="candidature-title"
        aria-describedby="candidature-step-label"
    >
        <form class="candidature-modal__form" data-candidature-form novalidate>
            <header class="candidature-modal__header">
                <button type="button" class="candidature-modal__close" data-candidature-close aria-label="Fermer la candidature">
                    <span aria-hidden="true">&times;</span>
                </button>

                <p class="candidature-modal__kicker">Admissions</p>
                <h2 class="candidature-modal__title" id="candidature-title">Candidater</h2>

                <ol class="candidature-progress" data-candidature-progress>
                    <li class="is-current" data-progress-step="1"><span>1</span> Informations</li>
                    <li data-progress-step="2"><span>2</span> Documents</li>
                </ol>

                <p class="candidature-modal__step" id="candidature-step-label">Étape 1 sur 2 — Vos informations</p>
            </header>

            <div class="candidature-modal__body">
                <div class="candidature-modal__alert" data-candidature-alert hidden></div>

                <?php wp_nonce_field('acharp_candidature', 'nonce'); ?>
                <input type="hidden" name="issued_at" value="">
                <input type="hidden" name="issued_sig" value="">
                <input type="hidden" name="token" value="">

                <p class="candidature-modal__honeypot">
                    <label for="candidature-fax">Fax</label>
                    <input type="text" id="candidature-fax" name="fax_number" tabindex="-1" autocomplete="off">
                </p>

                <div data-candidature-panel="1">
                    <div class="candidature-modal__grid">
                        <p class="candidature-modal__field">
                            <label for="candidature-first-name">Prénom</label>
                            <input id="candidature-first-name" name="first_name" type="text" autocomplete="given-name" maxlength="80" required>
                        </p>
                        <p class="candidature-modal__field">
                            <label for="candidature-last-name">Nom</label>
                            <input id="candidature-last-name" name="last_name" type="text" autocomplete="family-name" maxlength="80" required>
                        </p>
                        <p class="candidature-modal__field">
                            <label for="candidature-email">E-mail</label>
                            <input id="candidature-email" name="email" type="email" autocomplete="email" required>
                        </p>
                        <p class="candidature-modal__field">
                            <label for="candidature-phone">Téléphone</label>
                            <input id="candidature-phone" name="phone" type="tel" autocomplete="tel" required>
                        </p>
                        <p class="candidature-modal__field candidature-modal__field--full">
                            <label for="candidature-school">Établissement actuel</label>
                            <input id="candidature-school" name="school" type="text" maxlength="160" required>
                        </p>
                    </div>

                    <fieldset class="candidature-modal__fieldset">
                        <legend>Bac obtenu</legend>
                        <div class="candidature-choices">
                            <label class="candidature-choice">
                                <input type="radio" name="bac" value="oui" required>
                                <span>Oui</span>
                            </label>
                            <label class="candidature-choice">
                                <input type="radio" name="bac" value="non">
                                <span>Non</span>
                            </label>
                        </div>
                    </fieldset>

                    <fieldset class="candidature-modal__fieldset">
                        <legend>Formation choisie</legend>
                        <div class="candidature-choices candidature-choices--wrap">
                            <?php foreach ($formations as $value => $label) : ?>
                                <label class="candidature-choice">
                                    <input type="radio" name="formation" value="<?= esc_attr($value); ?>" required>
                                    <span><?= esc_html($label); ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </fieldset>

                    <p class="candidature-modal__consent">
                        <label class="candidature-check">
                            <input type="checkbox" name="consent" value="1" required>
                            <span>J’accepte que mes données soient utilisées pour traiter ma candidature, et conservées <?= esc_html((string) $days); ?> jours, conformément au RGPD.</span>
                        </label>
                    </p>
                </div>

                <div data-candidature-panel="2" hidden>
                    <p class="candidature-modal__help">
                        Glissez vos fichiers dans les zones ou cliquez pour parcourir.
                        Formats : PDF, JPG, PNG, DOC, DOCX<?= ' (ZIP pour le portfolio)'; ?>
                        — <?= esc_html((string) $max_mo); ?> Mo maximum par fichier.
                    </p>

                    <div class="candidature-drops">
                        <?php foreach ($fields as $name => $field) : ?>
                            <div
                                class="candidature-drop<?= $field['required'] ? ' is-required' : ''; ?>"
                                data-file-field="<?= esc_attr($name); ?>"
                                <?= $field['multiple'] ? 'data-multiple' : ''; ?>
                            >
                                <input
                                    class="candidature-drop__input"
                                    id="candidature-<?= esc_attr($name); ?>"
                                    name="<?= esc_attr($name . ($field['multiple'] ? '[]' : '')); ?>"
                                    type="file"
                                    <?= $field['multiple'] ? 'multiple' : ''; ?>
                                    accept=".pdf,.jpg,.jpeg,.png,.doc,.docx<?= $name === 'portfolio' ? ',.zip' : ''; ?>"
                                >
                                <label class="candidature-drop__zone" for="candidature-<?= esc_attr($name); ?>" tabindex="0">
                                    <span class="candidature-drop__icon" aria-hidden="true"><?= $icons[$name] ?? acharp_icon('file', 'admissions'); ?></span>
                                    <span class="candidature-drop__copy">
                                        <span class="candidature-drop__title">
                                            <?= esc_html($field['label']); ?>
                                            <span class="candidature-drop__badge" data-required-label>
                                                <?= $field['required'] ? 'Obligatoire' : 'Si demandé'; ?>
                                            </span>
                                        </span>
                                        <span class="candidature-drop__hint">
                                            <?= esc_html($hints[$name] ?? 'Glissez-déposez ou cliquez'); ?>
                                        </span>
                                    </span>
                                </label>
                                <ul class="candidature-drop__files" data-file-list hidden></ul>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="candidature-modal__done" data-candidature-success hidden>
                    <p data-candidature-success-message></p>
                    <div class="candidature-modal__calendly" data-candidature-calendly hidden></div>
                </div>
            </div>

            <div class="candidature-modal__actions" data-candidature-actions>
                <button type="button" class="btn btn--outline" data-candidature-close>Annuler</button>
                <button type="submit" class="btn btn--primary" data-candidature-submit>
                    Continuer
                    <?= $arrow; ?>
                </button>
            </div>
        </form>
    </div>
</div>
