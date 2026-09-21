<?php
$theme_uri = get_stylesheet_directory_uri();

$etapes = array(
    array(
        'num'   => '01',
        'title' => 'Acompte à l’inscription',
        'text'  => 'Un acompte de 2 000 € + 490 € pour toute inscription avant le 1er juillet.',
    ),
    array(
        'num'   => '02',
        'title' => 'Conditions de remboursement',
        'text'  => 'L’acompte est remboursable uniquement en cas d’échec au baccalauréat ou de refus de visa (sur présentation d’un justificatif), avec déduction des frais d’inscription.',
    ),
    array(
        'num'   => '03',
        'title' => 'Solde de la scolarité',
        'text'  => 'Le solde pour moitié au 1er juillet et pour moitié au plus tard le 1er novembre de l’année en cours.',
    ),
    array(
        'num'   => '04',
        'title' => 'Inscriptions ultérieures',
        'text'  => 'Pour toute inscription ultérieure au 1er juillet, les frais de scolarité doivent être réglés selon le calendrier suivant : 50 % à la date d’inscription, 50 % au plus tard le 1er novembre de l’année en cours.',
    ),
);
?>

<section class="tarifs">
    <div class="container-fluid">
        <header class="tarifs__header">
            <p class="tarifs__kicker">Tarifs</p>
            <h2 class="tarifs__title">Tarifs 2026 / 2027</h2>
            <p class="tarifs__intro">
                Une formation d’excellence, un accompagnement personnalisé et<br>
                des conditions d’admission claires.
            </p>
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
                            <p class="tarifs__card-label">Frais de scolarité</p>
                            <p class="tarifs__card-value">9 800€ <span>/ an</span></p>
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
                            <p class="tarifs__card-label">Frais d’inscription</p>
                            <p class="tarifs__card-value">490€</p>
                        </div>
                    </article>
                </div>

                <p class="tarifs__notice">
                    <span class="tarifs__notice-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/>
                            <path d="M12 11v5M12 8v.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                    </span>
                    Les frais sont indiqués pour l’année N et peuvent être révisés chaque année.
                </p>

                <h3 class="tarifs__subtitle">Plan de paiement</h3>
                <p class="tarifs__text">Les frais de scolarité sont réglés selon l’échéancier suivant :</p>

                <ol class="tarifs__steps">
                    <?php foreach ($etapes as $etape) : ?>
                        <li class="tarifs__step">
                            <span class="tarifs__step-num"><?= esc_html($etape['num']); ?></span>
                            <div>
                                <p class="tarifs__step-title"><?= esc_html($etape['title']); ?></p>
                                <p class="tarifs__step-text"><?= esc_html($etape['text']); ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ol>

                <a href="#" class="btn btn--primary tarifs__cta">
                    Candidater
                    <span class="btn__icon" aria-hidden="true">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M3 8h10M9.5 4.5 13 8l-3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </a>
            </div>

            <figure class="tarifs__media">
                <img
                    src="<?= esc_url($theme_uri . '/images/vie-ateliers.jpg'); ?>"
                    alt="Maquette d’un phare présentée lors d’un atelier de l’Académie Charpentier"
                    loading="lazy"
                >
            </figure>
        </div>
    </div>
</section>
