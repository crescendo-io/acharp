<?php
$theme_uri = get_stylesheet_directory_uri();
$kicker    = get_field('admissions_kicker') ?: 'Admissions';
$title     = get_field('admissions_title') ?: 'Modalités de candidatures';
$intro     = acharp_inline_html(get_field('admissions_intro'));
$prereq    = acharp_rows(get_field('admissions_prereq'));
$docs_intro = get_field('admissions_docs_intro');
$docs      = acharp_rows(get_field('admissions_docs'));
$caption   = acharp_inline_html(get_field('admissions_caption'));
$process_title = acharp_inline_html(get_field('admissions_process_title'));
$process   = acharp_rows(get_field('admissions_process'));
$deadline  = get_field('admissions_deadline') ?: '11 septembre 2026';
$result    = get_field('admissions_result') ?: 'Communiqué dans un délai d’une semaine, à l’issue de l’étude du dossier ou, le cas échéant, après un entretien individuel.';
$cta       = acharp_link(get_field('admissions_cta'), '#', 'Candidater');

if (!$intro) {
    $intro = 'Les admissions à l’Académie Charpentier se font hors Parcoursup, sur dossier de candidature, il n’y a pas de frais de candidature.';
}

if (!$prereq) {
    $prereq = array(
        array(
            'title' => 'Prérequis pour la 1ère année :',
            'text'  => '– avoir le baccalauréat ou un niveau équivalent.<br>– démontrer une appétence pour la pratique et l’expression artistique, à partir de votre CV, d’une lettre de motivation ; à cette occasion, vous pouvez nous transmettre votre portfolio et solliciter un entretien.',
        ),
        array(
            'title' => 'Prérequis à partir de la 2ème année :',
            'text'  => 'Une fois votre dossier de candidature complet déposé, un entretien vous sera proposé afin de déterminer votre niveau (année d’entrée dans notre école, année 2, 3 ou 4). Pour entrer en 4ème année le Bachelor doit être acquis.',
        ),
    );
}

if (!$docs_intro) {
    $docs_intro = 'Dans le cadre de votre demande d’admission, nous vous remercions de bien vouloir nous transmettre par retour de mail les éléments suivants :';
}

if (!$docs) {
    $docs = array(
        array('icon' => 'file', 'color' => 'pink', 'title' => 'CV', 'text' => 'Présentant votre parcours scolaire et, le cas échéant, vos expériences (stages, jobs, projets, activités), ainsi que vos compétences et centres d’intérêt.'),
        array('icon' => 'mail', 'color' => 'green', 'title' => 'Lettre de motivation', 'text' => 'Exposant votre intérêt pour le design et/ou l’architecture intérieure, les éléments de votre parcours ayant nourri votre démarche, ainsi que vos motivations à rejoindre l’Académie Charpentier.'),
        array('icon' => 'image', 'color' => 'blue', 'title' => 'Portfolio', 'text' => '<strong>1re année / Prépa :</strong> Facultatif.<br>Si vous en possédez un, il nous permettra de mieux appréhender votre sensibilité artistique, votre créativité et votre univers personnel.<br><br><strong>Années 2 / 3 / 4 :</strong><br>Un portfolio est requis afin de vérifier les acquis fondamentaux en architecture intérieure (projets, dessin, compréhension de l’espace et démarche de projet).'),
        array('icon' => 'diploma', 'color' => 'orange', 'title' => 'Relevés de notes et diplôme(s)', 'text' => '<strong>Années 2 / 3 / 4 :</strong><br>Les relevés de notes et, le cas échéant, les diplômes des formations antérieures en lien avec l’architecture intérieure ou des disciplines connexes sont demandés.'),
    );
}

if (!$caption) {
    $caption = 'Des talents<br>qui imaginent<br>les espaces<br>de demain';
}

if (!$process_title) {
    $process_title = 'Après étude de votre dossier et<br>s’il est jugé éligible';
}

if (!$process) {
    $process = array(
        array('title' => 'Pour les candidats à une entrée en 1re année.', 'text' => 'Une décision d’admission pourra être prise directement ou un entretien individuel pourra vous être proposé.'),
        array('title' => 'Pour les candidats à une entrée en 2e, 3e ou 4e année.', 'text' => 'Les candidats devront se présenter devant une commission d’équivalence, de préférence en présentiel (ou à distance si nécessaire).'),
    );
}
?>

<section class="admissions">
    <div class="container-fluid">
        <div class="admissions__grid">
            <div class="admissions__main">
                <?php if ($kicker) : ?>
                    <p class="admissions__kicker"><?= esc_html($kicker); ?></p>
                <?php endif; ?>

                <h2 class="admissions__title"><?= esc_html($title); ?></h2>

                <?php if ($intro) : ?>
                    <p class="admissions__intro"><?= $intro; ?></p>
                <?php endif; ?>

                <div class="admissions__prerequisites">
                    <?php foreach ($prereq as $item) : ?>
                        <?php if (!empty($item['title'])) : ?>
                            <h3><?= esc_html($item['title']); ?></h3>
                        <?php endif; ?>
                        <?php $prereq_text = acharp_inline_html($item['text'] ?? ''); ?>
                        <?php if ($prereq_text) : ?>
                            <p><?= $prereq_text; ?></p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <?php if ($docs_intro) : ?>
                    <p class="admissions__documents-intro"><?= esc_html($docs_intro); ?></p>
                <?php endif; ?>

                <div class="admissions__documents">
                    <?php foreach ($docs as $document) : ?>
                        <article class="admissions__document admissions__document--<?= esc_attr($document['color'] ?? 'pink'); ?>">
                            <span class="admissions__document-icon"><?= acharp_icon($document['icon'] ?? 'file', 'admissions'); ?></span>
                            <div>
                                <h3 class="admissions__document-title"><?= esc_html($document['title'] ?? ''); ?></h3>
                                <p class="admissions__document-text"><?= acharp_inline_html($document['text'] ?? ''); ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>

            <aside class="admissions__aside">
                <figure class="admissions__media">
                    <?= acharp_image_html(get_field('admissions_image'), 'large', array(
                        'src' => $theme_uri . '/images/histoire-salon.jpg',
                        'alt' => 'Espace de travail de l’Académie Charpentier',
                    )); ?>
                    <?php if ($caption) : ?>
                        <figcaption><?= $caption; ?></figcaption>
                    <?php endif; ?>
                </figure>

                <div class="admissions__process">
                    <h3 class="admissions__process-title"><?= $process_title; ?></h3>

                    <?php foreach ($process as $item) : ?>
                        <article class="admissions__process-card">
                            <?php if (!empty($item['title'])) : ?>
                                <h4><?= esc_html($item['title']); ?></h4>
                            <?php endif; ?>
                            <?php if (!empty($item['text'])) : ?>
                                <p><?= esc_html($item['text']); ?></p>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div class="admissions__deadline">
                    <div class="admissions__deadline-item">
                        <span class="admissions__deadline-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M7 3v4M17 3v4M3 10h18M8 14h2M14 14h2M8 18h2M14 18h2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </span>
                        <div>
                            <p class="admissions__deadline-label">Date limite de candidature</p>
                            <p class="admissions__deadline-value"><?= esc_html($deadline); ?></p>
                        </div>
                    </div>

                    <div class="admissions__deadline-item">
                        <span class="admissions__deadline-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none"><path d="M7 3h7l4 4v14H7V3Z" stroke="currentColor" stroke-width="1.5"/><path d="M14 3v5h4M10 12h5M10 16h5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </span>
                        <div>
                            <p class="admissions__deadline-label">Résultat d’admission</p>
                            <p class="admissions__deadline-text"><?= esc_html($result); ?></p>
                        </div>
                    </div>

                    <a <?= acharp_link_attrs($cta); ?> class="btn btn--primary admissions__cta">
                        <?= esc_html($cta['title']); ?>
                        <?= acharp_arrow(); ?>
                    </a>
                </div>
            </aside>
        </div>
    </div>
</section>
