<?php
$theme_uri = get_stylesheet_directory_uri();
$kicker    = get_field('programme_kicker') ?: 'Détail du programme';
$title     = acharp_inline_html(get_field('programme_title'));
$text      = acharp_inline_html(get_field('programme_text'));
$years     = acharp_rows(get_field('programme_years'));
$push_kicker = get_field('programme_push_kicker') ?: 'Les moments clés';
$push_title  = get_field('programme_push_title') ?: 'Projet interdisciplinaire';
$push_text   = acharp_inline_html(get_field('programme_push_text'));
$push_cta    = acharp_file_or_link(
    get_field('programme_push_file'),
    get_field('programme_push_cta'),
    '#',
    'Télécharger la brochure'
);
$chevron = '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m6 4 4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';

if (!$title) {
    $title = 'Un parcours progressif<br> <strong>de 3 ans</strong>';
}

if (!$text) {
    $text = 'Un enseignement complet et professionnalisant, alliant théorie, technique et pratique, pour développer votre créativité et acquérir toutes les compétences nécessaires aux métiers de l’architecture intérieure et du design.';
}

if (!$push_text) {
    $push_text = 'Un exercice phare de six semaines en 2e année, qui permet à chaque étudiant de travailler sur un thème et un lieu définis, et de réaliser un projet individuel, complet et cohérent.';
}

if ($years) {
    foreach ($years as $index => &$year) {
        $year['id']     = 'annee-' . ($index + 1);
        $year['tab']    = $year['tab'] ?: ($year['title'] ?: 'Année ' . ($index + 1));
        $year['title']  = $year['title'] ?: $year['tab'];
        $year['blocks'] = acharp_rows($year['blocks'] ?? array());
        foreach ($year['blocks'] as &$block) {
            $block['courses'] = acharp_rows($block['courses'] ?? array());
        }
        unset($block);
    }
    unset($year);
} else {
    $years = array(
        array(
            'id' => 'annee-1', 'tab' => '1ère année', 'title' => '1ère année',
            'subtitle' => 'Découverte et acquisitions des fondamentaux',
            'resume' => 'Découverte et acquisitions des fondamentaux',
            'image' => 0, 'fallback' => array('src' => $theme_uri . '/images/histoire-salon.jpg', 'alt' => 'Étudiants en cours de première année'),
            'description' => 'La première année permet d’acquérir les bases essentielles en architecture intérieure et design. Les enseignements combinent culture, représentation, techniques et ateliers de projet pour développer un regard créatif et méthodique sur l’espace.',
            'blocks' => array(
                array('name' => 'Culture et références', 'courses' => array(
                    array('name' => 'Histoire de l’art et de l’architecture', 's1' => '2', 's2' => '2'),
                    array('name' => 'Culture du design', 's1' => '2', 's2' => '2'),
                    array('name' => 'Analyse d’espaces', 's1' => '2', 's2' => '2'),
                )),
                array('name' => 'Représentation et outils', 'courses' => array(
                    array('name' => 'Dessin d’observation', 's1' => '3', 's2' => '2'),
                    array('name' => 'Représentation technique', 's1' => '3', 's2' => '3'),
                    array('name' => 'Infographie / Logiciels', 's1' => '2', 's2' => '3'),
                )),
                array('name' => 'Techniques et matières', 'courses' => array(
                    array('name' => 'Matériaux et mise en œuvre', 's1' => '2', 's2' => '2'),
                    array('name' => 'Volume et maquette', 's1' => '3', 's2' => '3'),
                    array('name' => 'Atelier de construction', 's1' => '2', 's2' => '2'),
                )),
                array('name' => 'Atelier de projet', 'courses' => array(
                    array('name' => 'Projet 1 — Espace intérieur', 's1' => '4', 's2' => '4'),
                    array('name' => 'Projet 2 — Objet / Mobilier', 's1' => '3', 's2' => '3'),
                )),
                array('name' => 'Méthodologie et développement personnel', 'courses' => array(
                    array('name' => 'Méthodologie', 's1' => '2', 's2' => '2'),
                    array('name' => 'Expression et communication', 's1' => '2', 's2' => '2'),
                )),
            ),
            'total_s1' => '30', 'total_s2' => '30',
        ),
        array(
            'id' => 'annee-2', 'tab' => '2ème année', 'title' => '2ème année',
            'subtitle' => 'Expérimentation et approfondissement',
            'resume' => 'Expérimentation et approfondissement',
            'image' => 0, 'fallback' => array('src' => $theme_uri . '/images/vie-ateliers.jpg', 'alt' => 'Étudiants en atelier de deuxième année'),
            'description' => 'La deuxième année approfondit la pratique du projet et l’expérimentation. Les étudiants confrontent leurs intentions à des contraintes techniques et développent progressivement leur méthode de travail.',
            'blocks' => array(
                array('name' => 'Culture et références', 'courses' => array(
                    array('name' => 'Histoire du design contemporain', 's1' => '2', 's2' => '2'),
                    array('name' => 'Analyse de références', 's1' => '2', 's2' => '2'),
                )),
                array('name' => 'Représentation et outils', 'courses' => array(
                    array('name' => 'Représentation avancée', 's1' => '3', 's2' => '3'),
                    array('name' => 'Modélisation 3D', 's1' => '3', 's2' => '3'),
                )),
                array('name' => 'Techniques et matières', 'courses' => array(
                    array('name' => 'Matériaux et éco-conception', 's1' => '3', 's2' => '3'),
                    array('name' => 'Détails techniques', 's1' => '2', 's2' => '2'),
                )),
                array('name' => 'Atelier de projet', 'courses' => array(
                    array('name' => 'Projet interdisciplinaire', 's1' => '5', 's2' => '5'),
                    array('name' => 'Projet 3 — Espace public', 's1' => '4', 's2' => '4'),
                )),
                array('name' => 'Professionnalisation', 'courses' => array(
                    array('name' => 'Stage en agence', 's1' => '3', 's2' => '3'),
                    array('name' => 'Expression et communication', 's1' => '2', 's2' => '2'),
                )),
            ),
            'total_s1' => '30', 'total_s2' => '30',
        ),
        array(
            'id' => 'annee-3', 'tab' => '3ème année', 'title' => '3ème année',
            'subtitle' => 'Perfectionnement et professionnalisation',
            'resume' => 'Perfectionnement et professionnalisation',
            'image' => 0, 'fallback' => array('src' => $theme_uri . '/images/vie-realisations.jpg', 'alt' => 'Présentation de projets de troisième année'),
            'description' => 'La troisième année conduit à l’autonomie sur un projet complet. Les enseignements préparent à l’insertion professionnelle et à la poursuite d’études en architecture intérieure.',
            'blocks' => array(
                array('name' => 'Culture et références', 'courses' => array(
                    array('name' => 'Séminaire de recherche', 's1' => '2', 's2' => '2'),
                    array('name' => 'Culture professionnelle', 's1' => '2', 's2' => '2'),
                )),
                array('name' => 'Représentation et outils', 'courses' => array(
                    array('name' => 'Représentation de projet', 's1' => '3', 's2' => '3'),
                    array('name' => 'Outils numériques avancés', 's1' => '2', 's2' => '2'),
                )),
                array('name' => 'Techniques et matières', 'courses' => array(
                    array('name' => 'Économie du projet', 's1' => '2', 's2' => '2'),
                    array('name' => 'Réglementation et accessibilité', 's1' => '2', 's2' => '2'),
                )),
                array('name' => 'Atelier de projet', 'courses' => array(
                    array('name' => 'Projet de fin d’études', 's1' => '6', 's2' => '8'),
                    array('name' => 'Atelier scénographie', 's1' => '4', 's2' => '3'),
                )),
                array('name' => 'Professionnalisation', 'courses' => array(
                    array('name' => 'Stage long', 's1' => '4', 's2' => '4'),
                    array('name' => 'Portfolio et présentation orale', 's1' => '3', 's2' => '2'),
                )),
            ),
            'total_s1' => '30', 'total_s2' => '30',
        ),
    );
}
?>

<section class="programme" data-programme>
    <div class="container-fluid">
        <div class="programme__grid">
            <div class="programme__side">
                <?php if ($kicker) : ?>
                    <p class="programme__kicker"><?= esc_html($kicker); ?></p>
                <?php endif; ?>

                <h2 class="programme__title"><?= $title; ?></h2>

                <?php if ($text) : ?>
                    <p class="programme__text"><?= $text; ?></p>
                <?php endif; ?>

                <div class="programme__years">
                    <?php foreach ($years as $index => $annee) : ?>
                        <button
                            type="button"
                            class="programme__year<?= 0 === $index ? ' is-active' : ''; ?>"
                            data-programme-target="<?= esc_attr($annee['id']); ?>"
                        >
                            <span class="programme__year-thumb">
                                <?= acharp_image_html($annee['image'] ?? 0, 'medium', $annee['fallback'] ?? array()); ?>
                            </span>
                            <span class="programme__year-body">
                                <span class="programme__year-name"><?= esc_html($annee['title']); ?></span>
                                <?php if (!empty($annee['resume'])) : ?>
                                    <span class="programme__year-resume"><?= esc_html($annee['resume']); ?></span>
                                <?php endif; ?>
                            </span>
                            <span class="programme__year-arrow" aria-hidden="true"><?= $chevron; ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <article class="programme__push">
                    <?= acharp_image_html(get_field('programme_push_image'), 'large', array(
                        'src'   => $theme_uri . '/images/histoire-escalier.jpg',
                        'alt'   => '',
                        'class' => 'programme__push-media',
                    )); ?>

                    <div class="programme__push-body">
                        <?php if ($push_kicker) : ?>
                            <p class="programme__push-kicker"><?= esc_html($push_kicker); ?></p>
                        <?php endif; ?>
                        <h3 class="programme__push-title"><?= esc_html($push_title); ?></h3>
                        <?php if ($push_text) : ?>
                            <p class="programme__push-text"><?= $push_text; ?></p>
                        <?php endif; ?>
                        <a <?= acharp_link_attrs($push_cta); ?> class="btn btn--primary programme__push-cta">
                            <?= esc_html($push_cta['title']); ?>
                            <?= acharp_arrow(); ?>
                        </a>
                    </div>
                </article>
            </div>

            <div class="programme__detail">
                <div class="programme__tabs" role="tablist" aria-label="Années du programme">
                    <?php foreach ($years as $index => $annee) : ?>
                        <button
                            type="button"
                            role="tab"
                            id="tab-<?= esc_attr($annee['id']); ?>"
                            class="programme__tab<?= 0 === $index ? ' is-active' : ''; ?>"
                            aria-selected="<?= 0 === $index ? 'true' : 'false'; ?>"
                            aria-controls="<?= esc_attr($annee['id']); ?>"
                            data-programme-target="<?= esc_attr($annee['id']); ?>"
                        >
                            <?= esc_html($annee['tab']); ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <?php foreach ($years as $index => $annee) : ?>
                    <div
                        class="programme__panel<?= 0 === $index ? ' is-active' : ''; ?>"
                        id="<?= esc_attr($annee['id']); ?>"
                        role="tabpanel"
                        aria-labelledby="tab-<?= esc_attr($annee['id']); ?>"
                        data-programme-panel="<?= esc_attr($annee['id']); ?>"
                        <?= 0 === $index ? '' : 'hidden'; ?>
                    >
                        <h3 class="programme__panel-title"><?= esc_html($annee['title']); ?></h3>
                        <?php if (!empty($annee['subtitle'])) : ?>
                            <p class="programme__panel-subtitle"><?= esc_html($annee['subtitle']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($annee['description'])) : ?>
                            <p class="programme__panel-text"><?= esc_html(wp_strip_all_tags(acharp_inline_html($annee['description']))); ?></p>
                        <?php endif; ?>

                        <div class="programme__table-wrap">
                            <table class="programme__table">
                                <thead>
                                    <tr>
                                        <th class="programme__th-bloc" rowspan="2"><span class="programme__sr">Bloc d’enseignement</span></th>
                                        <th rowspan="2">Intitulé du cours</th>
                                        <th class="programme__th-credits" colspan="2">Crédits</th>
                                    </tr>
                                    <tr>
                                        <th class="programme__th-sem">Semestre 1</th>
                                        <th class="programme__th-sem">Semestre 2</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($annee['blocks'] as $bloc) : ?>
                                        <?php $courses = $bloc['courses'] ?? array(); ?>
                                        <?php foreach ($courses as $position => $cours) : ?>
                                            <tr>
                                                <?php if (0 === $position) : ?>
                                                    <th class="programme__bloc" scope="rowgroup" rowspan="<?= count($courses); ?>">
                                                        <?= esc_html($bloc['name'] ?? ''); ?>
                                                    </th>
                                                <?php endif; ?>
                                                <td class="programme__cours"><?= esc_html($cours['name'] ?? ''); ?></td>
                                                <td class="programme__credit"><?= esc_html($cours['s1'] ?? ''); ?></td>
                                                <td class="programme__credit"><?= esc_html($cours['s2'] ?? ''); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="programme__total-label" colspan="2">Total</th>
                                        <td class="programme__total"><?= esc_html($annee['total_s1'] ?? ''); ?></td>
                                        <td class="programme__total"><?= esc_html($annee['total_s2'] ?? ''); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
