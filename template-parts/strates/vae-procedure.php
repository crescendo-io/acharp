<?php
$vae_text = static function ($name, $default) {
    $value = function_exists('acharp_field') ? acharp_field($name) : '';

    if (is_string($value)) {
        $value = trim($value);
    }

    return ($value !== null && $value !== '' && $value !== false) ? $value : $default;
};

$vae_rows = static function ($name, array $defaults) {
    $rows = function_exists('acharp_rows') ? acharp_rows(function_exists('acharp_field') ? acharp_field($name) : array()) : array();

    return $rows ?: $defaults;
};

$vae_file_url = static function ($field, $option) {
    $file = function_exists('acharp_field') ? acharp_field($field) : null;

    if (is_numeric($file)) {
        $url = wp_get_attachment_url((int) $file);

        return $url ? $url : '';
    }

    if (is_array($file) && !empty($file['url'])) {
        return (string) $file['url'];
    }

    return function_exists('acharp_vae_document_url') ? acharp_vae_document_url($option) : '';
};

$vae_tel = static function ($display) {
    $digits = preg_replace('/\D+/', '', (string) $display);

    if ($digits === '') {
        return '';
    }

    if (strpos($digits, '33') === 0) {
        return 'tel:+' . $digits;
    }

    if (strpos($digits, '0') === 0) {
        return 'tel:+33' . substr($digits, 1);
    }

    return 'tel:+' . $digits;
};

$vae_tone = static function ($tone, $index) {
    $tones = array('pink', 'green', 'blue', 'orange');

    return in_array($tone, $tones, true) ? $tone : $tones[$index % 4];
};

$phone_display = $vae_text('vae_proc_project_phone', '01 43 54 31 12');
$phone_href    = $vae_tel($phone_display);
$contact_phone = $vae_text('vae_proc_contact_phone', $phone_display);
$contact_email = $vae_text('vae_proc_contact_email', 'admissions@academiecharpentier.com');
$livret_1      = $vae_file_url('vae_proc_livret_1_file', 'vae_livret_1');
$livret_2      = $vae_file_url('vae_proc_livret_2_file', 'vae_livret_2');

$download_attrs = static function ($url) use ($contact_email) {
    $href  = $url ?: 'mailto:' . $contact_email;
    $attrs = 'href="' . esc_url($href) . '"';

    if ($url) {
        $attrs .= ' target="_blank" rel="noopener"';
    }

    return $attrs;
};

$guide_title = $vae_text('vae_proc_guide_title', 'Le mode d’emploi');
$principles_title = $vae_text('vae_proc_principles_title', 'Qu’est-ce qu’une VAE ?');
$presentation_label = $vae_text('vae_proc_rate_presentation_label', 'Présentation');
$obtention_label = $vae_text('vae_proc_rate_obtention_label', 'Obtention');
$project_title = $vae_text('vae_proc_project_title', 'Définir un projet');
$project_text = $vae_text('vae_proc_project_text', 'La prestation s’étend sur une année. De la recevabilité à l’épreuve finale, la durée est de 5 à 7 mois.');
$project_phone_label = $vae_text('vae_proc_project_phone_label', 'Se renseigner auprès de la Direction');
$fact_1_value = $vae_text('vae_proc_fact_1_value', '1 an');
$fact_1_label = $vae_text('vae_proc_fact_1_label', 'Durée de la prestation');
$fact_2_value = $vae_text('vae_proc_fact_2_value', '5 à 7 mois');
$fact_2_label = $vae_text('vae_proc_fact_2_label', 'De la recevabilité à l’épreuve');
$livret_1_kicker = $vae_text('vae_proc_livret_1_kicker', 'Livret 1');
$livret_1_title = $vae_text('vae_proc_livret_1_title', 'Recevabilité');
$livret_1_text = $vae_text('vae_proc_livret_1_text', 'Cette étape vérifie la durée de l’expérience en rapport direct avec la certification visée, sans préjuger du résultat, et nomme le titre visé par la demande, totale ou partielle. Le livret 1 est le document officiel pour la prise en charge financière auprès des organismes financeurs. Il comprend 4 rubriques :');
$livret_1_button = $vae_text('vae_proc_livret_1_button', 'Télécharger le livret 1');
$livret_2_kicker = $vae_text('vae_proc_livret_2_kicker', 'Livret 2');
$livret_2_title = $vae_text('vae_proc_livret_2_title', 'Validation');
$livret_2_text = $vae_text('vae_proc_livret_2_text', 'Une fois l’avis de recevabilité obtenu, vous préparez la validation par le jury, à partir du livret 2 que vous rédigez. Il permet au jury d’évaluer si vous avez acquis les compétences requises. Il comprend :');
$livret_2_note = $vae_text('vae_proc_livret_2_note', 'L’entretien avec le jury a lieu après l’examen du livret 2. Il permet au jury de compléter ou de confirmer les éléments du dossier ; il dure en général moins d’une heure. Nous contacter pour disposer de la dernière version du livret 2.');
$livret_2_button = $vae_text('vae_proc_livret_2_button', 'Télécharger le livret 2');
$eval_title = $vae_text('vae_proc_eval_title', 'L’évaluation finale');
$decisions_title = $vae_text('vae_proc_decisions_title', 'Quelles décisions ?');
$skills = $vae_text('vae_proc_skills', 'Exemples de compétences : définition d’un projet d’architecture intérieure en réponse à la demande d’un client ou d’un maître d’ouvrage ; création de l’architecture d’un espace intérieur et de ses éléments (concept) ; maîtrise d’œuvre et supervision d’un chantier d’architecture intérieure.');
$planning_title = $vae_text('vae_proc_planning_title', 'Le planning 2026/2027');
$planning_note = $vae_text('vae_proc_planning_note', 'L’accompagnateur VAE est votre interlocuteur privilégié : il vous aide à décrire vos activités, à les relier aux compétences du référentiel et à les formuler pour faciliter la validation.');
$cost_title = $vae_text('vae_proc_cost_title', 'Le coût');
$contact_title = $vae_text('vae_proc_contact_title', 'Contact');
$contact_address_label = $vae_text('vae_proc_contact_address_label', 'Adresse');
$contact_address = $vae_text('vae_proc_contact_address', "Académie Charpentier\n50 rue Sébastien Mercier\n75015 Paris");
$contact_phone_label = $vae_text('vae_proc_contact_phone_label', 'Téléphone');
$contact_email_label = $vae_text('vae_proc_contact_email_label', 'E-mail');

$principles = $vae_rows('vae_proc_principles', array(
    array(
        'tone'  => 'pink',
        'title' => 'Ouverte à tous',
        'text'  => 'Toute personne, quels que soient son âge, sa nationalité, son statut et son niveau de formation, qui justifie d’au moins 1 année d’expérience en rapport direct avec la certification visée, peut prétendre à la VAE.',
    ),
    array(
        'tone'  => 'green',
        'title' => 'Quel que soit le statut',
        'text'  => 'Toute personne peut engager une demande, quel que soit son statut au moment de la demande (salarié, travailleur indépendant, agent public, demandeur d’emploi, bénévole…).',
    ),
    array(
        'tone'  => 'blue',
        'title' => 'La même valeur que le diplôme',
        'text'  => 'La certification obtenue par la VAE a la même valeur que celle obtenue par la formation (diplôme d’architecte d’intérieur, années 4 et 5). C’est une vraie démarche, qui demande implication et motivation.',
    ),
    array(
        'tone'  => 'orange',
        'title' => 'L’accompagnement choisi',
        'text'  => 'Tous les candidats engagés pour le titre ont choisi l’accompagnement.',
    ),
));

$rates = $vae_rows('vae_proc_rates', array(
    array('year' => '2019/2020', 'presentation' => '100 %', 'obtention' => '100 %'),
    array('year' => '2020/2021', 'presentation' => '100 %', 'obtention' => '100 %'),
    array('year' => '2023/2024', 'presentation' => '100 %', 'obtention' => '100 %'),
));

$project_steps = $vae_rows('vae_proc_steps', array(
    array('text' => 'Confirmer votre choix de certification après étude de faisabilité de votre demande.'),
    array('text' => 'Comprendre la procédure spécifique mise en place pour la certification choisie.'),
    array('text' => 'Connaître les modalités de constitution du livret 1 de demande de recevabilité, premier dossier qui formalise votre entrée dans la démarche.'),
    array('text' => 'À l’issue de l’entretien, vous pourrez télécharger le livret 1.'),
));

$livret_1_items = $vae_rows('vae_proc_livret_1_items', array(
    array('text' => 'Informations générales : état civil, situation professionnelle, niveau de formation.'),
    array('text' => 'Expérience en lien avec le titre visé (activités professionnelles, associatives, bénévoles…).'),
    array('text' => 'Pièces justificatives obligatoires.'),
    array('text' => 'Attestation sur l’honneur qu’une seule demande de VAE a été déposée pour cette certification sur l’année civile.'),
));

$livret_2_items = $vae_rows('vae_proc_livret_2_items', array(
    array('text' => 'Une description de votre expérience professionnelle et personnelle.'),
    array('text' => 'Des preuves de la réalité de votre pratique professionnelle.'),
));

$faq = $vae_rows('vae_proc_faq', array(
    array(
        'question' => 'Qui organise les jurys ?',
        'answer'   => 'L’organisme certificateur constitue ses jurys, fixe les dates des sessions et vous les transmet.',
    ),
    array(
        'question' => 'Comment procède le jury ?',
        'answer'   => 'À partir du livret 2, il évalue les compétences acquises par l’expérience et vérifie qu’elles correspondent à celles exigées. L’entretien lui apporte des compléments : à vous de défendre votre dossier.',
    ),
));

$decisions = $vae_rows('vae_proc_decisions', array(
    array('tone' => 'green', 'title' => 'Validation totale', 'text' => 'Vous obtenez intégralement la certification.'),
    array('tone' => 'blue', 'title' => 'Validation partielle', 'text' => 'Vous obtenez un ou plusieurs blocs de compétences.'),
    array('tone' => 'orange', 'title' => 'Refus de validation', 'text' => 'Vos acquis ne correspondent pas au niveau exigé.'),
));

$phases = $vae_rows('vae_proc_phases', array(
    array(
        'index' => '0',
        'name'  => 'Rendez-vous',
        'items' => array(
            array('date' => 'Toute l’année', 'text' => 'Rendez-vous d’information ou contact téléphonique'),
        ),
    ),
    array(
        'index' => '1',
        'name'  => 'Candidature',
        'items' => array(
            array('date' => 'Lundi 12 octobre 2026', 'text' => 'Retrait du dossier 1 de recevabilité'),
            array('date' => 'Lundi 23 novembre 2026', 'text' => 'Dépôt du dossier en PDF, droits d’inscription (490 €), analyse de la recevabilité'),
        ),
    ),
    array(
        'index' => '2',
        'name'  => 'Accompagnement',
        'items' => array(
            array('date' => '17 décembre 2026', 'text' => 'Réponse de recevabilité et proposition de contrat'),
            array('date' => 'Lundi 18 janvier 2027', 'text' => 'Début de l’accompagnement (6 h en face à face, 10 h à distance)'),
            array('date' => 'Mardi 1er juin 2027', 'text' => 'Dépôt du livret 2 et droits d’inscription au jury (1 200 €)'),
        ),
    ),
    array(
        'index' => '3',
        'name'  => 'Soutenance',
        'items' => array(
            array('date' => 'Juin 2027', 'text' => 'Soutenance orale devant un jury de 3 professionnels, tous extérieurs à l’école'),
        ),
    ),
));

$formulas = $vae_rows('vae_proc_formulas', array(
    array(
        'featured' => true,
        'name'     => 'Formule A',
        'detail'   => 'Avec accompagnement',
        'total'    => '5 580 € TTC',
        'lines'    => array(
            array('label' => 'Candidature, droits non remboursables', 'value' => '490 €'),
            array('label' => 'Accompagnement et analyse du dossier', 'value' => '3 900 €'),
            array('label' => 'Soutenance, droits d’inscription au jury', 'value' => '1 200 €'),
        ),
    ),
    array(
        'featured' => false,
        'name'     => 'Formule B',
        'detail'   => 'Sans accompagnement',
        'total'    => '3 180 € TTC',
        'lines'    => array(
            array('label' => 'Candidature, droits non remboursables', 'value' => '490 €'),
            array('label' => 'Analyse du dossier seule', 'value' => '1 500 €'),
            array('label' => 'Soutenance, droits d’inscription au jury', 'value' => '1 200 €'),
        ),
    ),
));

foreach ($phases as &$phase) {
    $phase['items'] = function_exists('acharp_rows') ? acharp_rows($phase['items'] ?? array()) : array();
    $phase['index'] = isset($phase['index']) ? trim((string) $phase['index']) : '';
}
unset($phase);

foreach ($formulas as &$formula) {
    $formula['lines'] = function_exists('acharp_rows') ? acharp_rows($formula['lines'] ?? array()) : array();
    $formula['featured'] = !empty($formula['featured']);
}
unset($formula);
?>

<section class="vae-guide" id="mode-emploi">
    <span class="vae-guide__shape vae-guide__shape--circle" aria-hidden="true"></span>
    <span class="vae-guide__shape vae-guide__shape--triangle" aria-hidden="true"></span>

    <div class="container-fluid">
        <header class="vae-guide__chapter">
            <h2 class="vae-guide__title"><?= esc_html($guide_title); ?></h2>
        </header>

        <div class="vae-guide__principles">
            <h3 class="vae-guide__subtitle"><?= esc_html($principles_title); ?></h3>
            <div class="vae-guide__principle-grid">
                <?php foreach ($principles as $index => $principle) : ?>
                    <article class="vae-guide__principle vae-guide__principle--<?= esc_attr($vae_tone($principle['tone'] ?? '', $index)); ?>">
                        <h4><?= esc_html($principle['title']); ?></h4>
                        <p><?= esc_html($principle['text']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="vae-guide__rates" aria-label="Taux de présentation et d’obtention">
            <?php foreach ($rates as $rate) : ?>
                <article class="vae-guide__rate">
                    <p class="vae-guide__rate-year"><?= esc_html($rate['year']); ?></p>
                    <div class="vae-guide__rate-figures">
                        <p>
                            <strong><?= esc_html($rate['presentation']); ?></strong>
                            <span><?= esc_html($presentation_label); ?></span>
                        </p>
                        <p>
                            <strong><?= esc_html($rate['obtention']); ?></strong>
                            <span><?= esc_html($obtention_label); ?></span>
                        </p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <article class="vae-guide__project">
            <div class="vae-guide__project-intro">
                <h3 class="vae-guide__subtitle"><?= esc_html($project_title); ?></h3>
                <p><?= esc_html($project_text); ?></p>
                <p class="vae-guide__phone">
                    <?= esc_html($project_phone_label); ?>
                    <a href="<?= esc_url($phone_href); ?>"><?= esc_html($phone_display); ?></a>
                </p>
            </div>
            <div class="vae-guide__facts">
                <p class="vae-guide__fact">
                    <strong><?= esc_html($fact_1_value); ?></strong>
                    <span><?= esc_html($fact_1_label); ?></span>
                </p>
                <p class="vae-guide__fact">
                    <strong><?= esc_html($fact_2_value); ?></strong>
                    <span><?= esc_html($fact_2_label); ?></span>
                </p>
            </div>
            <ol class="vae-guide__steps">
                <?php foreach ($project_steps as $index => $step) : ?>
                    <li>
                        <span><?= esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                        <p><?= esc_html($step['text'] ?? ''); ?></p>
                    </li>
                <?php endforeach; ?>
            </ol>
        </article>

        <div class="vae-guide__livrets">
            <article class="vae-guide__livret" id="livret-1">
                <p class="vae-guide__livret-kicker"><?= esc_html($livret_1_kicker); ?></p>
                <h3><?= esc_html($livret_1_title); ?></h3>
                <p><?= esc_html($livret_1_text); ?></p>
                <ol>
                    <?php foreach ($livret_1_items as $item) : ?>
                        <li><?= esc_html($item['text'] ?? ''); ?></li>
                    <?php endforeach; ?>
                </ol>
                <a <?= $download_attrs($livret_1); ?> class="btn btn--primary vae-guide__download">
                    <?= esc_html($livret_1_button); ?>
                    <?= acharp_arrow(); ?>
                </a>
            </article>

            <article class="vae-guide__livret" id="livret-2">
                <p class="vae-guide__livret-kicker"><?= esc_html($livret_2_kicker); ?></p>
                <h3><?= esc_html($livret_2_title); ?></h3>
                <p><?= esc_html($livret_2_text); ?></p>
                <ol>
                    <?php foreach ($livret_2_items as $item) : ?>
                        <li><?= esc_html($item['text'] ?? ''); ?></li>
                    <?php endforeach; ?>
                </ol>
                <p><?= esc_html($livret_2_note); ?></p>
                <a <?= $download_attrs($livret_2); ?> class="btn btn--primary vae-guide__download">
                    <?= esc_html($livret_2_button); ?>
                    <?= acharp_arrow(); ?>
                </a>
            </article>
        </div>

        <article class="vae-guide__evaluation">
            <h3 class="vae-guide__subtitle"><?= esc_html($eval_title); ?></h3>
            <div class="vae-guide__faq">
                <?php foreach ($faq as $item) : ?>
                    <article>
                        <h4><?= esc_html($item['question'] ?? ''); ?></h4>
                        <p><?= esc_html($item['answer'] ?? ''); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>

            <h4 class="vae-guide__label"><?= esc_html($decisions_title); ?></h4>
            <div class="vae-guide__decisions">
                <?php foreach ($decisions as $index => $decision) : ?>
                    <article class="vae-guide__decision vae-guide__decision--<?= esc_attr($vae_tone($decision['tone'] ?? '', $index)); ?>">
                        <h5><?= esc_html($decision['title']); ?></h5>
                        <p><?= esc_html($decision['text']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
            <p class="vae-guide__skills"><?= esc_html($skills); ?></p>
        </article>

        <header class="vae-guide__chapter" id="planning">
            <h2 class="vae-guide__title"><?= esc_html($planning_title); ?></h2>
        </header>

        <ol class="vae-guide__timeline">
            <?php foreach ($phases as $phase) : ?>
                <li class="vae-guide__phase">
                    <p class="vae-guide__phase-name">
                        <?php if ($phase['index'] !== '') : ?>
                            <span><?= esc_html($phase['index']); ?></span>
                        <?php endif; ?>
                        <?= esc_html($phase['name'] ?? ''); ?>
                    </p>
                    <div class="vae-guide__milestones">
                        <?php foreach ($phase['items'] as $item) : ?>
                            <article>
                                <time><?= esc_html($item['date']); ?></time>
                                <p><?= esc_html($item['text']); ?></p>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ol>
        <p class="vae-guide__note"><?= esc_html($planning_note); ?></p>

        <header class="vae-guide__chapter" id="cout">
            <h2 class="vae-guide__title"><?= esc_html($cost_title); ?></h2>
        </header>

        <div class="vae-guide__formulas">
            <?php foreach ($formulas as $formula) : ?>
                <article class="vae-guide__formula<?= $formula['featured'] ? ' vae-guide__formula--featured' : ''; ?>">
                    <p class="vae-guide__formula-name"><?= esc_html($formula['name']); ?></p>
                    <h3><?= esc_html($formula['detail']); ?></h3>
                    <p class="vae-guide__formula-total"><?= esc_html($formula['total']); ?></p>
                    <ul>
                        <?php foreach ($formula['lines'] as $line) : ?>
                            <li>
                                <span><?= esc_html($line['label']); ?></span>
                                <strong><?= esc_html($line['value']); ?></strong>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </article>
            <?php endforeach; ?>
        </div>

        <footer class="vae-guide__contact">
            <h2><?= esc_html($contact_title); ?></h2>
            <div class="vae-guide__contact-grid">
                <p>
                    <span><?= esc_html($contact_address_label); ?></span>
                    <?= nl2br(esc_html($contact_address)); ?>
                </p>
                <a href="<?= esc_url($vae_tel($contact_phone)); ?>">
                    <span><?= esc_html($contact_phone_label); ?></span>
                    <strong><?= esc_html($contact_phone); ?></strong>
                </a>
                <a href="<?= esc_url('mailto:' . $contact_email); ?>">
                    <span><?= esc_html($contact_email_label); ?></span>
                    <strong><?= esc_html($contact_email); ?></strong>
                </a>
            </div>
        </footer>
    </div>
</section>
