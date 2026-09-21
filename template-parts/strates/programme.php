<?php
$theme_uri = get_stylesheet_directory_uri();

$annees = array(
    array(
        'id'          => 'annee-1',
        'onglet'      => '1ère année',
        'titre'       => '1ère année',
        'sous_titre'  => 'Découverte et acquisitions des fondamentaux',
        'resume'      => 'Découverte et acquisitions des fondamentaux',
        'image'       => '/images/histoire-salon.jpg',
        'alt'         => 'Étudiants en cours de première année',
        'description' => 'La première année permet d’acquérir les bases essentielles en architecture intérieure et design. Les enseignements combinent culture, représentation, techniques et ateliers de projet pour développer un regard créatif et méthodique sur l’espace.',
        'blocs'       => array(
            array(
                'nom'   => 'Culture et références',
                'cours' => array(
                    array('Histoire de l’art et de l’architecture', '2', '2'),
                    array('Culture du design', '2', '2'),
                    array('Analyse d’espaces', '2', '2'),
                ),
            ),
            array(
                'nom'   => 'Représentation et outils',
                'cours' => array(
                    array('Dessin d’observation', '3', '2'),
                    array('Représentation technique', '3', '3'),
                    array('Infographie / Logiciels', '2', '3'),
                ),
            ),
            array(
                'nom'   => 'Techniques et matières',
                'cours' => array(
                    array('Matériaux et mise en œuvre', '2', '2'),
                    array('Volume et maquette', '3', '3'),
                    array('Atelier de construction', '2', '2'),
                ),
            ),
            array(
                'nom'   => 'Atelier de projet',
                'cours' => array(
                    array('Projet 1 — Espace intérieur', '4', '4'),
                    array('Projet 2 — Objet / Mobilier', '3', '3'),
                ),
            ),
            array(
                'nom'   => 'Méthodologie et développement personnel',
                'cours' => array(
                    array('Méthodologie', '2', '2'),
                    array('Expression et communication', '2', '2'),
                ),
            ),
        ),
        'total'       => array('30', '30'),
    ),
    array(
        'id'          => 'annee-2',
        'onglet'      => '2ème année',
        'titre'       => '2ème année',
        'sous_titre'  => 'Expérimentation et approfondissement',
        'resume'      => 'Expérimentation et approfondissement',
        'image'       => '/images/vie-ateliers.jpg',
        'alt'         => 'Étudiants en atelier de deuxième année',
        'description' => 'La deuxième année approfondit la pratique du projet et l’expérimentation. Les étudiants confrontent leurs intentions à des contraintes techniques et développent progressivement leur méthode de travail.',
        'blocs'       => array(
            array(
                'nom'   => 'Culture et références',
                'cours' => array(
                    array('Histoire du design contemporain', '2', '2'),
                    array('Analyse de références', '2', '2'),
                ),
            ),
            array(
                'nom'   => 'Représentation et outils',
                'cours' => array(
                    array('Représentation avancée', '3', '3'),
                    array('Modélisation 3D', '3', '3'),
                ),
            ),
            array(
                'nom'   => 'Techniques et matières',
                'cours' => array(
                    array('Matériaux et éco-conception', '3', '3'),
                    array('Détails techniques', '2', '2'),
                ),
            ),
            array(
                'nom'   => 'Atelier de projet',
                'cours' => array(
                    array('Projet interdisciplinaire', '5', '5'),
                    array('Projet 3 — Espace public', '4', '4'),
                ),
            ),
            array(
                'nom'   => 'Professionnalisation',
                'cours' => array(
                    array('Stage en agence', '3', '3'),
                    array('Expression et communication', '2', '2'),
                ),
            ),
        ),
        'total'       => array('30', '30'),
    ),
    array(
        'id'          => 'annee-3',
        'onglet'      => '3ème année',
        'titre'       => '3ème année',
        'sous_titre'  => 'Perfectionnement et professionnalisation',
        'resume'      => 'Perfectionnement et professionnalisation',
        'image'       => '/images/vie-realisations.jpg',
        'alt'         => 'Présentation de projets de troisième année',
        'description' => 'La troisième année conduit à l’autonomie sur un projet complet. Les enseignements préparent à l’insertion professionnelle et à la poursuite d’études en architecture intérieure.',
        'blocs'       => array(
            array(
                'nom'   => 'Culture et références',
                'cours' => array(
                    array('Séminaire de recherche', '2', '2'),
                    array('Culture professionnelle', '2', '2'),
                ),
            ),
            array(
                'nom'   => 'Représentation et outils',
                'cours' => array(
                    array('Représentation de projet', '3', '3'),
                    array('Outils numériques avancés', '2', '2'),
                ),
            ),
            array(
                'nom'   => 'Techniques et matières',
                'cours' => array(
                    array('Économie du projet', '2', '2'),
                    array('Réglementation et accessibilité', '2', '2'),
                ),
            ),
            array(
                'nom'   => 'Atelier de projet',
                'cours' => array(
                    array('Projet de fin d’études', '6', '8'),
                    array('Atelier scénographie', '4', '3'),
                ),
            ),
            array(
                'nom'   => 'Professionnalisation',
                'cours' => array(
                    array('Stage long', '4', '4'),
                    array('Portfolio et présentation orale', '3', '2'),
                ),
            ),
        ),
        'total'       => array('30', '30'),
    ),
);

$chevron = '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m6 4 4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
?>

<section class="programme" data-programme>
    <div class="container-fluid">
        <div class="programme__grid">
            <div class="programme__side">
                <p class="programme__kicker">Détail du programme</p>

                <h2 class="programme__title">
                    Un parcours progressif<br>
                    <strong>de 3 ans</strong>
                </h2>

                <p class="programme__text">
                    Un enseignement complet et professionnalisant, alliant théorie, technique et
                    pratique, pour développer votre créativité et acquérir toutes les compétences
                    nécessaires aux métiers de l’architecture intérieure et du design.
                </p>

                <div class="programme__years">
                    <?php foreach ($annees as $index => $annee) : ?>
                        <button
                            type="button"
                            class="programme__year<?= 0 === $index ? ' is-active' : ''; ?>"
                            data-programme-target="<?= esc_attr($annee['id']); ?>"
                        >
                            <span class="programme__year-thumb">
                                <img
                                    src="<?= esc_url($theme_uri . $annee['image']); ?>"
                                    alt="<?= esc_attr($annee['alt']); ?>"
                                    loading="lazy"
                                >
                            </span>

                            <span class="programme__year-body">
                                <span class="programme__year-name"><?= esc_html($annee['titre']); ?></span>
                                <span class="programme__year-resume"><?= esc_html($annee['resume']); ?></span>
                            </span>

                            <span class="programme__year-arrow" aria-hidden="true"><?= $chevron; ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <article class="programme__push">
                    <img
                        class="programme__push-media"
                        src="<?= esc_url($theme_uri . '/images/histoire-escalier.jpg'); ?>"
                        alt=""
                        loading="lazy"
                    >

                    <div class="programme__push-body">
                        <p class="programme__push-kicker">Les moments clés</p>

                        <h3 class="programme__push-title">Projet interdisciplinaire</h3>

                        <p class="programme__push-text">
                            Un exercice phare de six semaines en 2e année, qui permet à chaque étudiant
                            de travailler sur un thème et un lieu définis, et de réaliser un projet
                            individuel, complet et cohérent.
                        </p>

                        <a href="#" class="btn btn--primary programme__push-cta">
                            Télécharger la brochure
                            <span class="btn__icon" aria-hidden="true">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 8h10M9.5 4.5 13 8l-3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                </article>
            </div>

            <div class="programme__detail">
                <div class="programme__tabs" role="tablist" aria-label="Années du programme">
                    <?php foreach ($annees as $index => $annee) : ?>
                        <button
                            type="button"
                            role="tab"
                            id="tab-<?= esc_attr($annee['id']); ?>"
                            class="programme__tab<?= 0 === $index ? ' is-active' : ''; ?>"
                            aria-selected="<?= 0 === $index ? 'true' : 'false'; ?>"
                            aria-controls="<?= esc_attr($annee['id']); ?>"
                            data-programme-target="<?= esc_attr($annee['id']); ?>"
                        >
                            <?= esc_html($annee['onglet']); ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <?php foreach ($annees as $index => $annee) : ?>
                    <div
                        class="programme__panel<?= 0 === $index ? ' is-active' : ''; ?>"
                        id="<?= esc_attr($annee['id']); ?>"
                        role="tabpanel"
                        aria-labelledby="tab-<?= esc_attr($annee['id']); ?>"
                        data-programme-panel="<?= esc_attr($annee['id']); ?>"
                        <?= 0 === $index ? '' : 'hidden'; ?>
                    >
                        <h3 class="programme__panel-title"><?= esc_html($annee['titre']); ?></h3>
                        <p class="programme__panel-subtitle"><?= esc_html($annee['sous_titre']); ?></p>
                        <p class="programme__panel-text"><?= esc_html($annee['description']); ?></p>

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
                                    <?php foreach ($annee['blocs'] as $bloc) : ?>
                                        <?php foreach ($bloc['cours'] as $position => $cours) : ?>
                                            <tr>
                                                <?php if (0 === $position) : ?>
                                                    <th class="programme__bloc" scope="rowgroup" rowspan="<?= count($bloc['cours']); ?>">
                                                        <?= esc_html($bloc['nom']); ?>
                                                    </th>
                                                <?php endif; ?>

                                                <td class="programme__cours"><?= esc_html($cours[0]); ?></td>
                                                <td class="programme__credit"><?= esc_html($cours[1]); ?></td>
                                                <td class="programme__credit"><?= esc_html($cours[2]); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th class="programme__total-label" colspan="2">Total</th>
                                        <td class="programme__total"><?= esc_html($annee['total'][0]); ?></td>
                                        <td class="programme__total"><?= esc_html($annee['total'][1]); ?></td>
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
