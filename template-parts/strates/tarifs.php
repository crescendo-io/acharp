<?php
$theme_uri = get_stylesheet_directory_uri();
$kicker    = get_field('tarifs_kicker') ?: 'Tarifs';
$title     = get_field('tarifs_title') ?: 'Tarifs 2026 / 2027';
$intro     = acharp_inline_html(get_field('tarifs_intro'));
$tuition_label = get_field('tarifs_tuition_label') ?: 'Frais de scolarité';
$tuition_value = get_field('tarifs_tuition_value') ?: '9 800€ / an';
$fee_label = get_field('tarifs_fee_label') ?: 'Frais d’inscription';
$fee_value = get_field('tarifs_fee_value') ?: '490€';
$notice    = get_field('tarifs_notice') ?: 'Les frais sont indiqués pour l’année N et peuvent être révisés chaque année.';
$subtitle  = get_field('tarifs_subtitle') ?: 'Plan de paiement';
$text      = get_field('tarifs_text') ?: 'Les frais de scolarité sont réglés selon l’échéancier suivant :';
$steps     = acharp_rows(get_field('tarifs_steps'));
$cta       = acharp_link(get_field('tarifs_cta'), '#', 'Candidater');

if (!$intro) {
    $intro = 'Une formation d’excellence, un accompagnement personnalisé et<br> des conditions d’admission claires.';
}

if (!$steps) {
    $steps = array(
        array('num' => '01', 'title' => 'Acompte à l’inscription', 'text' => 'Un acompte de 2 000 € + 490 € pour toute inscription avant le 1er juillet.'),
        array('num' => '02', 'title' => 'Conditions de remboursement', 'text' => 'L’acompte est remboursable uniquement en cas d’échec au baccalauréat ou de refus de visa (sur présentation d’un justificatif), avec déduction des frais d’inscription.'),
        array('num' => '03', 'title' => 'Solde de la scolarité', 'text' => 'Le solde pour moitié au 1er juillet et pour moitié au plus tard le 1er novembre de l’année en cours.'),
        array('num' => '04', 'title' => 'Inscriptions ultérieures', 'text' => 'Pour toute inscription ultérieure au 1er juillet, les frais de scolarité doivent être réglés selon le calendrier suivant : 50 % à la date d’inscription, 50 % au plus tard le 1er novembre de l’année en cours.'),
    );
}

$tuition_parts = explode(' / ', $tuition_value, 2);
?>

<section class="tarifs">
    <div class="container-fluid">
        <header class="tarifs__header">
            <?php if ($kicker) : ?>
                <p class="tarifs__kicker"><?= esc_html($kicker); ?></p>
            <?php endif; ?>
            <h2 class="tarifs__title"><?= esc_html($title); ?></h2>
            <?php if ($intro) : ?>
                <p class="tarifs__intro"><?= $intro; ?></p>
            <?php endif; ?>
        </header>

        <div class="tarifs__grid">
            <div class="tarifs__content">
                <div class="tarifs__cards">
                    <article class="tarifs__card">
                        <span class="tarifs__card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M3 10 12 5l9 5-9 5-9-5Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                                <path d="M7.5 12.2v3.4c0 .8 2 2.4 4.5 2.4s4.5-1.6 4.5-2.4v-3.4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                <path d="M21 10v6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <div>
                            <p class="tarifs__card-label"><?= esc_html($tuition_label); ?></p>
                            <p class="tarifs__card-value">
                                <?= esc_html($tuition_parts[0]); ?>
                                <?php if (!empty($tuition_parts[1])) : ?>
                                    <span>/ <?= esc_html($tuition_parts[1]); ?></span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </article>

                    <article class="tarifs__card">
                        <span class="tarifs__card-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M7 3h7l4 4v14H7V3Z" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M14 3v5h4M10 12h5M10 16h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <div>
                            <p class="tarifs__card-label"><?= esc_html($fee_label); ?></p>
                            <p class="tarifs__card-value"><?= esc_html($fee_value); ?></p>
                        </div>
                    </article>
                </div>

                <?php if ($notice) : ?>
                    <p class="tarifs__notice">
                        <span class="tarifs__notice-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M12 11v5M12 8v.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <?= esc_html($notice); ?>
                    </p>
                <?php endif; ?>

                <?php if ($subtitle) : ?>
                    <h3 class="tarifs__subtitle"><?= esc_html($subtitle); ?></h3>
                <?php endif; ?>
                <?php if ($text) : ?>
                    <p class="tarifs__text"><?= esc_html($text); ?></p>
                <?php endif; ?>

                <ol class="tarifs__steps">
                    <?php foreach ($steps as $index => $step) : ?>
                        <li class="tarifs__step">
                            <span class="tarifs__step-num"><?= esc_html($step['num'] ?: str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                            <div>
                                <p class="tarifs__step-title"><?= esc_html($step['title'] ?? ''); ?></p>
                                <?php if (!empty($step['text'])) : ?>
                                    <p class="tarifs__step-text"><?= esc_html($step['text']); ?></p>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ol>

                <a <?= acharp_link_attrs($cta); ?> class="btn btn--primary tarifs__cta">
                    <?= esc_html($cta['title']); ?>
                    <?= acharp_arrow(); ?>
                </a>
            </div>

            <figure class="tarifs__media">
                <?= acharp_image_html(get_field('tarifs_image'), 'large', array(
                    'src' => $theme_uri . '/images/vie-ateliers.jpg',
                    'alt' => 'Maquette d’un phare présentée lors d’un atelier de l’Académie Charpentier',
                )); ?>
            </figure>
        </div>
    </div>
</section>
