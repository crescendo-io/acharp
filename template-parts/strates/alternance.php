<?php
$theme_uri = get_stylesheet_directory_uri();

$alt_text = static function ($name, $fallback) {
    $value = acharp_field($name);

    if (!is_string($value) || trim($value) === '') {
        return $fallback;
    }

    return trim($value);
};

$alt_lines = static function ($name, array $fallback) {
    $lines = array();

    foreach (acharp_rows(acharp_field($name)) as $row) {
        $text = trim((string) ($row['text'] ?? ''));

        if ($text !== '') {
            $lines[] = $text;
        }
    }

    return $lines ? $lines : $fallback;
};

$advantages = $alt_lines('alt_advantages', array(
    'Préparer un diplôme reconnu : Titre RNCP 38011, niveau 7.',
    'Mettre en pratique les enseignements au sein d’une entreprise.',
    'Bénéficier de la gratuité des frais de formation, financés par l’employeur.',
    'Percevoir une rémunération pendant toute la durée du contrat.',
    'Accéder plus facilement à l’emploi grâce à l’expérience acquise.',
));

$facts = array();

foreach (acharp_rows(acharp_field('alt_facts')) as $row) {
    $value = trim((string) ($row['value'] ?? ''));
    $label = trim((string) ($row['label'] ?? ''));

    if ($value !== '' || $label !== '') {
        $facts[] = array('value' => $value, 'label' => $label);
    }
}

if (!$facts) {
    $facts = array(
        array('value' => '1 an', 'label' => 'Possible uniquement en 5ᵉ année'),
        array('value' => '16 à 25 ans', 'label' => 'Jeunes concernés par le dispositif'),
        array('value' => 'Variable', 'label' => 'Rémunération selon l’âge et le niveau'),
    );
}

$stages = array();

foreach (acharp_rows(acharp_field('alt_stages')) as $row) {
    $accent = trim((string) ($row['accent'] ?? ''));
    $text   = trim((string) ($row['text'] ?? ''));

    if ($accent !== '' || $text !== '') {
        $stages[] = array('accent' => $accent, 'text' => $text);
    }
}

if (!$stages) {
    $stages = array(
        array('accent' => '2 mois', 'text' => 'de stage en 2ᵉ année.'),
        array('accent' => '6 mois', 'text' => 'de stage en 4ᵉ année, avec un rapport professionnel.'),
    );
}

$conferences = $alt_lines('alt_conferences', array(
    'Mathieu Lehanneur',
    'Stéphane de Pondt, directeur de collections pour de grandes marques du luxe',
    'William Pesson, ARCAS Architecture',
    'Inès Imbert-Mathieu, Lustreries Mathieu',
));

$workshops = $alt_lines('alt_workshops', array(
    'Loumi Lefloc’h, Precious Peels',
    'Clémence Sayer, Verallia Design Awards',
));

$career = $alt_lines('alt_career', array(
    'Conseil et accompagnement pour les stages, l’alternance et l’emploi.',
    'Un réseau actif de plus de 15 000 anciens élèves, en France et à l’international.',
));

$outcomes = $alt_lines('alt_outcomes', array(
    'Architecte d’intérieur, en agence ou en indépendant',
    'Designer d’espace ou scénographe',
    'Aménagement d’hôtels, de commerces et de restaurants',
    'Designer de mobilier et d’objets',
    'Chef de projet en architecture durable',
    'Enseignant ou formateur',
));

$portal = acharp_link(
    acharp_field('alt_portal'),
    'https://www.alternance.emploi.gouv.fr/',
    'Conditions détaillées sur le portail de l’alternance'
);

if (!$portal['target'] && preg_match('#^https?://#', $portal['url'])) {
    $portal['target'] = '_blank';
}

$cta = acharp_link(acharp_field('alt_cta'), '#candidature', 'Candidater');
?>

<section class="alternance" id="alternance">
    <div class="container-fluid">
        <header class="alternance__chapter">
            <h2 class="alternance__title"><?= esc_html($alt_text('alt_title', 'L’alternance à l’Académie Charpentier')); ?></h2>
        </header>

        <div class="alternance__lead">
            <div class="alternance__lead-copy">
                <h3><?= esc_html($alt_text('alt_advantages_title', 'Les avantages de l’alternance')); ?></h3>
                <p><?= esc_html($alt_text('alt_advantages_text', 'L’alternance permet aux étudiants de combiner formation diplômante et expérience professionnelle, tout en bénéficiant d’un statut salarié. C’est une voie d’excellence pour construire un projet professionnel complet, gagner en autonomie et faciliter l’accès à l’emploi.')); ?></p>
            </div>
            <ul class="alternance__advantages">
                <?php foreach ($advantages as $advantage) : ?>
                    <li><?= esc_html($advantage); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <article class="alternance__contract">
            <div class="alternance__contract-copy">
                <h3><?= esc_html($alt_text('alt_contract_title', 'Le contrat de professionnalisation')); ?></h3>
                <p><?= esc_html($alt_text('alt_contract_text', 'Le dispositif repose sur le contrat de professionnalisation, conclu en CDD ou dans le cadre d’un CDI.')); ?></p>
                <?php if ($portal['url']) : ?>
                    <a class="alternance__portal" href="<?= esc_url($portal['url']); ?>"<?= $portal['target'] ? ' target="' . esc_attr($portal['target']) . '" rel="noopener"' : ''; ?>>
                        <?= esc_html($portal['title']); ?>
                        <?= acharp_arrow(); ?>
                    </a>
                <?php endif; ?>
            </div>
            <ul class="alternance__facts">
                <?php foreach ($facts as $fact) : ?>
                    <li>
                        <strong><?= esc_html($fact['value']); ?></strong>
                        <span><?= esc_html($fact['label']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </article>

        <article class="alternance__employer">
            <h3><?= esc_html($alt_text('alt_employer_title', 'L’employeur')); ?></h3>
            <p><?= esc_html($alt_text('alt_employer_text', 'Tout employeur assujetti au financement de la formation professionnelle continue peut accueillir un(e) étudiant(e) en alternance. Il finance la scolarité et rémunère l’étudiant(e) pendant la durée du contrat. L’étudiant choisit son entreprise d’accueil ; l’Académie met à sa disposition une liste d’entreprises partenaires intéressées par le dispositif.')); ?></p>
        </article>

        <div class="alternance__studies">
            <article>
                <h3><?= esc_html($alt_text('alt_studies_title', 'Les études en alternance')); ?></h3>
                <p><?= esc_html($alt_text('alt_studies_text', 'L’alternance est ouverte aux étudiants de 5ᵉ année du cursus d’architecture intérieure. Le contenu de la formation, le planning des cours et le diplôme délivré sont les mêmes pour tous les étudiants.')); ?></p>
            </article>
            <article class="alternance__diploma">
                <p class="alternance__kicker"><?= esc_html($alt_text('alt_diploma_kicker', 'Le diplôme délivré')); ?></p>
                <h3><?= esc_html($alt_text('alt_diploma_title', 'Titre RNCP 38011, niveau 7')); ?></h3>
                <p><?= esc_html($alt_text('alt_diploma_text', 'À l’issue de la 5ᵉ année, les étudiants obtiennent le Titre RNCP 38011 niveau 7 (UE) d’Architecte d’intérieur, identique à celui de la formation initiale et soumis aux mêmes critères d’évaluation.')); ?></p>
                <?php if ($cta['url']) : ?>
                    <a href="<?= esc_url($cta['url']); ?>" class="btn btn--light"<?= $cta['url'] === '#candidature' ? ' data-open-candidature' : ''; ?><?= $cta['target'] ? ' target="' . esc_attr($cta['target']) . '" rel="noopener"' : ''; ?>>
                        <?= esc_html($cta['title']); ?>
                        <?= acharp_arrow(); ?>
                    </a>
                <?php endif; ?>
            </article>
        </div>
    </div>
</section>

<section class="alternance-pro" id="insertion">
    <div class="container-fluid">
        <header class="alternance__chapter">
            <h2 class="alternance__title"><?= esc_html($alt_text('alt_pro_title', 'Vie professionnelle et insertion')); ?></h2>
            <p><?= esc_html($alt_text('alt_pro_text', 'Grâce à une approche innovante, responsable et durable, l’Académie Charpentier forme des étudiants prêts à relever les défis contemporains de l’architecture intérieure. Le lien constant avec le monde professionnel (stages, conférences, concours, workshops et partenariats) est au cœur de notre pédagogie.')); ?></p>
        </header>

        <div class="alternance-pro__practice">
            <article class="alternance-pro__hours">
                <p class="alternance__kicker"><?= esc_html($alt_text('alt_hours_kicker', 'Une pédagogie ancrée dans la réalité du métier')); ?></p>
                <p class="alternance-pro__stat"><?= esc_html($alt_text('alt_hours_stat', '25 h')); ?></p>
                <p><?= esc_html($alt_text('alt_hours_text', 'Les étudiants suivent en moyenne 25 heures de cours en atelier par semaine, encadrés par une équipe pédagogique composée de professionnels en activité.')); ?></p>
            </article>
            <article class="alternance-pro__stages">
                <div>
                    <h3><?= esc_html($alt_text('alt_stages_title', 'Stages et immersion professionnelle')); ?></h3>
                    <ul>
                        <?php foreach ($stages as $stage) : ?>
                            <li><?php if ($stage['accent'] !== '') : ?><strong><?= esc_html($stage['accent']); ?></strong> <?php endif; ?><?= esc_html($stage['text']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <p><?= esc_html($alt_text('alt_stages_text', 'Encadrés par des architectes d’intérieur et designers en activité, ces stages se déroulent en France ou à l’international.')); ?></p>
                </div>
                <figure>
                    <?= acharp_image_html(acharp_field('alt_stages_image'), 'large', array(
                        'src' => $theme_uri . '/images/vie-ateliers.jpg',
                        'alt' => 'Étudiants au travail dans un atelier de l’Académie Charpentier',
                    )); ?>
                </figure>
            </article>
        </div>

        <div class="alternance-pro__events">
            <article>
                <h3><?= esc_html($alt_text('alt_events_title', 'Conférences d’insertion professionnelle et workshops')); ?></h3>
                <p><?= esc_html($alt_text('alt_events_text', 'Tout au long de l’année, l’Académie invite des professionnels reconnus de l’architecture, du design, du luxe et de la création, avec des conférences ouvertes à toutes les années.')); ?></p>
            </article>
            <article>
                <h4>Conférences</h4>
                <ul>
                    <?php foreach ($conferences as $name) : ?>
                        <li><?= esc_html($name); ?></li>
                    <?php endforeach; ?>
                </ul>
            </article>
            <article>
                <h4>Workshops</h4>
                <ul>
                    <?php foreach ($workshops as $name) : ?>
                        <li><?= esc_html($name); ?></li>
                    <?php endforeach; ?>
                </ul>
            </article>
        </div>

        <article class="alternance-pro__career">
            <h3><?= esc_html($alt_text('alt_career_title', 'Career service et réseau des alumni')); ?></h3>
            <ul>
                <?php foreach ($career as $line) : ?>
                    <li><?= esc_html($line); ?></li>
                <?php endforeach; ?>
            </ul>
        </article>

        <div class="alternance-pro__outcomes">
            <h3><?= esc_html($alt_text('alt_outcomes_title', 'Les débouchés')); ?></h3>
            <ul>
                <?php foreach ($outcomes as $outcome) : ?>
                    <li><?= esc_html($outcome); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>
