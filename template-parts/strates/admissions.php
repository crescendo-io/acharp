<?php
$theme_uri = get_stylesheet_directory_uri();

$documents = array(
    array(
        'class' => 'admissions__document--pink',
        'icon'  => '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7 3h7l4 4v14H7V3Z" stroke="currentColor" stroke-width="1.5"/><path d="M14 3v5h4M10 12h5M10 16h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
        'title' => 'CV',
        'text'  => 'Présentant votre parcours scolaire et, le cas échéant, vos expériences (stages, jobs, projets, activités), ainsi que vos compétences et centres d’intérêt.',
    ),
    array(
        'class' => 'admissions__document--green',
        'icon'  => '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="1" stroke="currentColor" stroke-width="1.5"/><path d="m4 7 8 6 8-6" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>',
        'title' => 'Lettre de motivation',
        'text'  => 'Exposant votre intérêt pour le design et/ou l’architecture intérieure, les éléments de votre parcours ayant nourri votre démarche, ainsi que vos motivations à rejoindre l’Académie Charpentier.',
    ),
    array(
        'class' => 'admissions__document--blue',
        'icon'  => '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="1.5" stroke="currentColor" stroke-width="1.5"/><circle cx="8.5" cy="9" r="1.5" stroke="currentColor" stroke-width="1.5"/><path d="m5 18 5-5 3 3 2-2 4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        'title' => 'Portfolio',
        'text'  => '<strong>1re année / Prépa :</strong> Facultatif.<br>Si vous en possédez un, il nous permettra de mieux appréhender votre sensibilité artistique, votre créativité et votre univers personnel.<br><br><strong>Années 2 / 3 / 4 :</strong><br>Un portfolio est requis afin de vérifier les acquis fondamentaux en architecture intérieure (projets, dessin, compréhension de l’espace et démarche de projet).',
    ),
    array(
        'class' => 'admissions__document--orange',
        'icon'  => '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M7 3h7l4 4v14H7V3Z" stroke="currentColor" stroke-width="1.5"/><path d="M14 3v5h4M10 12h5M10 15h5M10 18h3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>',
        'title' => 'Relevés de notes et diplôme(s)',
        'text'  => '<strong>Années 2 / 3 / 4 :</strong><br>Les relevés de notes et, le cas échéant, les diplômes des formations antérieures en lien avec l’architecture intérieure ou des disciplines connexes sont demandés.',
    ),
);
?>

<section class="admissions">
    <div class="container-fluid">
        <div class="admissions__grid">
            <div class="admissions__main">
                <p class="admissions__kicker">Admissions</p>

                <h2 class="admissions__title">Modalités de candidatures</h2>

                <p class="admissions__intro">
                    Les admissions à l’Académie Charpentier se font hors Parcoursup, sur dossier de
                    candidature, il n’y a pas de frais de candidature.
                </p>

                <div class="admissions__prerequisites">
                    <h3>Prérequis pour la 1ère année :</h3>
                    <p>
                        – avoir le baccalauréat ou un niveau équivalent.<br>
                        – démontrer une appétence pour la pratique et l’expression artistique, à partir
                        de votre CV, d’une lettre de motivation ; à cette occasion, vous pouvez nous
                        transmettre votre portfolio et solliciter un entretien.
                    </p>

                    <h3>Prérequis à partir de la 2ème année :</h3>
                    <p>
                        Une fois votre dossier de candidature complet déposé, un entretien vous sera
                        proposé afin de déterminer votre niveau (année d’entrée dans notre école,
                        année 2, 3 ou 4). Pour entrer en 4ème année le Bachelor doit être acquis.
                    </p>
                </div>

                <p class="admissions__documents-intro">
                    Dans le cadre de votre demande d’admission, nous vous remercions de bien vouloir
                    nous transmettre par retour de mail les éléments suivants :
                </p>

                <div class="admissions__documents">
                    <?php foreach ($documents as $document) : ?>
                        <article class="admissions__document <?= esc_attr($document['class']); ?>">
                            <span class="admissions__document-icon"><?= $document['icon']; ?></span>
                            <div>
                                <h3 class="admissions__document-title"><?= esc_html($document['title']); ?></h3>
                                <p class="admissions__document-text"><?= wp_kses_post($document['text']); ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>

            <aside class="admissions__aside">
                <figure class="admissions__media">
                    <img
                        src="<?= esc_url($theme_uri . '/images/histoire-salon.jpg'); ?>"
                        alt="Espace de travail de l’Académie Charpentier"
                        loading="lazy"
                    >
                    <figcaption>Des talents<br>qui imaginent<br>les espaces<br>de demain</figcaption>
                </figure>

                <div class="admissions__process">
                    <h3 class="admissions__process-title">
                        Après étude de votre dossier et<br>s’il est jugé éligible
                    </h3>

                    <article class="admissions__process-card">
                        <h4>Pour les candidats à une entrée en 1re année.</h4>
                        <p>Une décision d’admission pourra être prise directement ou un entretien individuel pourra vous être proposé.</p>
                    </article>

                    <article class="admissions__process-card">
                        <h4>Pour les candidats à une entrée en 2e, 3e ou 4e année.</h4>
                        <p>Les candidats devront se présenter devant une commission d’équivalence, de préférence en présentiel (ou à distance si nécessaire).</p>
                    </article>
                </div>

                <div class="admissions__deadline">
                    <div class="admissions__deadline-item">
                        <span class="admissions__deadline-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M7 3v4M17 3v4M3 10h18M8 14h2M14 14h2M8 18h2M14 18h2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </span>
                        <div>
                            <p class="admissions__deadline-label">Date limite de candidature</p>
                            <p class="admissions__deadline-value">11 septembre 2026</p>
                        </div>
                    </div>

                    <div class="admissions__deadline-item">
                        <span class="admissions__deadline-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none"><path d="M7 3h7l4 4v14H7V3Z" stroke="currentColor" stroke-width="1.5"/><path d="M14 3v5h4M10 12h5M10 16h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </span>
                        <div>
                            <p class="admissions__deadline-label">Résultat d’admission</p>
                            <p class="admissions__deadline-text">Communiqué dans un délai d’une semaine, à l’issue de l’étude du dossier ou, le cas échéant, après un entretien individuel.</p>
                        </div>
                    </div>

                    <a href="#" class="btn btn--primary admissions__cta">
                        Candidater
                        <span class="btn__icon" aria-hidden="true">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M3 8h10M9.5 4.5 13 8l-3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </a>
                </div>
            </aside>
        </div>
    </div>
</section>
