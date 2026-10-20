<?php
$kicker = acharp_field('equipe_kicker') ?: 'Équipe pédagogique';
$title  = acharp_inline_html(acharp_field('equipe_title'));
$intro  = acharp_field('equipe_intro') ?: 'Tous nos enseignants sont des professionnels en activité : c’est l’un des points forts de l’Académie Charpentier.';
$posts  = acharp_get_enseignants();
$members = array();

foreach ($posts as $post) {
    $members[] = array(
        'name'          => get_the_title($post),
        'teachings'     => get_field('enseignant_enseignements', $post->ID) ?: '',
        'bio'           => get_field('enseignant_parcours', $post->ID) ?: get_the_excerpt($post),
        'image'         => get_post_thumbnail_id($post->ID),
    );
}

if (!$title) {
    $title = 'Des professionnels<br> <strong>en activité</strong>';
}

if (!$members) {
    $members = array(
        array('name' => 'Sylvie Cedrin-Felix', 'teachings' => 'Direction générale et pédagogique ; jurys, préparation au diplôme, mémoires, suivi VAE, portes ouvertes', 'bio' => 'Architecte DPLG (ENSA Paris-La Villette) et architecte d’intérieur. À l’Académie depuis 1997.'),
        array('name' => 'Ana Zatezalo Schenk', 'teachings' => 'Scénographie (2e, 3e année) ; Posture et signature (4e, 5e année). Directrice des relations internationales, des partenariats et de l’orientation', 'bio' => 'Architecte et designer (DPLG, MSc Columbia, HEC), doctorat en cours.'),
        array('name' => 'Morgane Claoué', 'teachings' => 'Architecture intérieure (prépa, 1re année)', 'bio' => 'Architecte d’intérieur (École Camondo), co-gérante de Cocottes Studio depuis 2012.'),
        array('name' => 'Joachim Lubet', 'teachings' => 'Dessin analytique, chromatologie (prépa, 1re année)', 'bio' => 'Peintre et concept artist, Barcelona Academy of Art.'),
        array('name' => 'Fabory Mara', 'teachings' => 'Croquis, dessin et perspective (prépa à 2e année)', 'bio' => 'Designer et illustrateur (Strate), ancien de BETC Design.'),
        array('name' => 'Quentin Petit dit Duhal', 'teachings' => 'Histoire de l’art (prépa à 2e année) ; suivi des mémoires (5e année)', 'bio' => 'Docteur en histoire de l’art (Paris Nanterre).'),
        array('name' => 'Henri Texier', 'teachings' => 'Histoire de l’art et design (prépa à 3e année) ; représentation volumétrique (3e année)', 'bio' => 'Architecte d’intérieur, diplômé de l’Académie Charpentier.'),
        array('name' => 'Anna-Maria Sienicka', 'teachings' => 'Découvertes culturelles (prépa, 1re année) ; méthodologie (2e, 4e année) ; expression Odéon (3e année)', 'bio' => 'Chercheuse en philosophie de l’art, enseignante à Paris-Sorbonne et Paris-Nanterre.'),
        array('name' => 'Zahava Brown', 'teachings' => 'Anglais et Suite Adobe (prépa à 2e année) ; ateliers stage (2e à 4e année)', 'bio' => 'Directrice artistique (Penninghen), ancienne de Young & Rubicam, Pentagram, Carré Noir.'),
        array('name' => 'Fitriani Ratmaja', 'teachings' => 'AutoCAD (2e année) ; Rhino (3e année)', 'bio' => 'Architecte et BIM manager chez CALQ.'),
        array('name' => 'Delphine Gaillard', 'teachings' => 'Harmonies et revêtements (2e, 3e année) ; représentation graphique du projet (3e année)', 'bio' => 'Architecte d’intérieur et décoratrice (École Boulle), agence depuis 2009.'),
        array('name' => 'Stéphanie Le Tiec', 'teachings' => 'Lumière et espace (2e, 4e année)', 'bio' => 'Conceptrice lumière (DNSEP Rennes), formatrice à l’École Boulle.'),
        array('name' => 'Jean-Christophe Plat', 'teachings' => 'Écoresponsabilité (prépa, 1re, 3e année) ; technique et mise en œuvre des matériaux (3e année)', 'bio' => 'Architecte d’intérieur et ébéniste (École Boulle), agence depuis 2003.'),
        array('name' => 'Apolline Morel', 'teachings' => 'Design d’objet et de mobilier (3e, 4e année)', 'bio' => 'Designer verre, mobilier et luminaires (HEAR, ECAL), œuvre acquise par le Mobilier national.'),
        array('name' => 'Mélissa Thomas', 'teachings' => 'Retail (3e année)', 'bio' => 'Designer d’espace et scénographe (DSAA Lyon), enseigne aussi à l’École Boulle.'),
        array('name' => 'Marie Casasola', 'teachings' => 'Design global (3e, 4e année) ; projets partenaires SNCF et ICADE (4e année)', 'bio' => 'Architecte d’intérieur et designer d’espace (ENSBA Lyon), agence depuis 2014.'),
        array('name' => 'Nikola Meyer', 'teachings' => 'Expérimentation, émotion, création (4e année)', 'bio' => 'Architecte (DPLG / Dipl.-Ing.), 13 ans au Renzo Piano Building Workshop.'),
        array('name' => 'Sylvain Marceau', 'teachings' => 'Architecture intérieure, projet de fin d’études ; projet SNCF (4e année) ; dessin technique détaillé (5e année)', 'bio' => 'Architecte d’intérieur, dirige Studio M à Paris.'),
        array('name' => 'Céline Pinto', 'teachings' => 'Méthodologie (prépa à 3e année) ; projet architecture intérieure et IA (3e année) ; rapport de stage (4e année) ; mémoire (5e année)', 'bio' => 'Architecte DE-HMONP (ENSA Paris-Belleville), fondatrice d’Architopies.'),
        array('name' => 'Anne Ambaud', 'teachings' => 'Matériaux et applications (4e année) ; projet de fin d’études et préparation au jury (5e année)', 'bio' => 'Architecte d’intérieur indépendante et journaliste (Le Moniteur, Houzz).'),
        array('name' => 'Olga Nousse', 'teachings' => 'Projet de fin d’études et suivi du diplôme (5e année)', 'bio' => 'Architecte DE-HMONP (ENSA Paris-Malaquais), fondatrice d’Eona Studio.'),
    );
}
?>

<section id="equipe-pedagogique" class="equipe-pedagogique">
    <div class="container-fluid">
        <header class="equipe-pedagogique__header">
            <p class="equipe-pedagogique__kicker"><?= esc_html($kicker); ?></p>
            <h2 class="equipe-pedagogique__title"><?= $title; ?></h2>
            <?php if ($intro) : ?>
                <p class="equipe-pedagogique__intro"><?= esc_html($intro); ?></p>
            <?php endif; ?>
        </header>

        <ul class="equipe-pedagogique__list">
            <?php foreach ($members as $member) : ?>
                <li class="equipe-pedagogique__item">
                    <?php if (!empty($member['image'])) : ?>
                        <figure class="equipe-pedagogique__photo">
                            <?= acharp_image_html($member['image'], 'medium'); ?>
                        </figure>
                    <?php endif; ?>
                    <div class="equipe-pedagogique__body">
                        <h3 class="equipe-pedagogique__name"><?= esc_html($member['name']); ?></h3>
                        <?php if (!empty($member['teachings'])) : ?>
                            <p class="equipe-pedagogique__teachings"><?= esc_html($member['teachings']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($member['bio'])) : ?>
                            <p class="equipe-pedagogique__bio"><?= esc_html($member['bio']); ?></p>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
