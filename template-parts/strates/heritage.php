<?php
$theme_uri = get_stylesheet_directory_uri();

$etapes = array(
    array(
        'image'    => '/images/hero-atelier.jpg',
        'alt'      => 'Atelier de dessin de l’Académie Charpentier dans les années 1950',
        'archive'  => true,
        'title'    => 'L’Académie Charpentier, école d’architecture intérieure et de design depuis <strong>80 ans</strong>, tournée vers un futur durable',
        'contenus' => array(
            'C’est après la seconde guerre mondiale, en 1945, qu’Irène Charpentier crée l’Académie Charpentier. Le succès est très vite au rendez-vous et l’académie devient l’une des principales écoles d’arts appliqués en France.',
            'En 1957, la famille Charpentier avait repris la direction de l’Académie de la Grande Chaumière, installée rue de la Grande-Chaumière à Montparnasse, un haut lieu de l’art, fréquenté par les plus grands noms de la peinture et de la sculpture du XX<sup>e</sup> siècle.',
            'Au fil des décennies, l’Académie Charpentier a connu plusieurs évolutions majeures, toujours guidées par la même exigence artistique et le souci d’accompagner les transformations du monde créatif. D’abord dédiée à un large éventail de disciplines artistiques, dessin, peinture, sculpture, arts appliqués, l’école a progressivement affirmé son expertise dans le design d’espace et l’architecture intérieure, domaines où s’expriment pleinement sa rigueur, sa créativité et son ouverture d’esprit.',
        ),
    ),
    array(
        'image'    => '/images/vie-ateliers.jpg',
        'alt'      => 'Atelier de dessin d’après modèle vivant à l’Académie de la Grande Chaumière',
        'title'    => 'Un lien historique et artistique avec l’Académie de la <strong>Grande Chaumière.</strong>',
        'contenus' => array(
            'Aujourd’hui, la dimension « Beaux-Arts » de cet héritage historique se poursuit à travers l’Académie de la Grande Chaumière, qui incarne toujours la pratique du dessin et de la création artistique libre d’après modèle vivant.',
            'Grâce à ce lien privilégié, les étudiants de l’Académie Charpentier ont accès gratuitement à ses ateliers, prolongeant ainsi la tradition d’échanges, de créativité et d’excellence qui unit les deux institutions depuis près d’un siècle. Cette complémentarité unique offre aux étudiants une formation complète : la Grande Chaumière pour nourrir l’expression artistique et l’Académie Charpentier pour développer la conception, le projet et la pensée du design d’espace.',
        ),
    ),
    array(
        'image'    => '/images/vie-realisations.jpg',
        'alt'      => 'Étudiants au travail dans le nouveau campus du 15e arrondissement',
        'title'    => 'Un nouveau chapitre pour l’<strong>Académie Charpentier</strong>',
        'contenus' => array(
            'En 2025, une nouvelle étape décisive s’inscrit dans cette continuité : le bâtiment historique de Montparnasse a fermé ses portes en juillet.',
            'Dès la rentrée suivante, l’Académie Charpentier s’est installée sur un nouveau campus moderne dans le XV<sup>e</sup> arrondissement. Ce déménagement symbolise une volonté de renouveau et d’adaptation aux enjeux contemporains : ateliers repensés, espaces de création lumineux et modulables, technologies intégrées et environnement propice à l’expérimentation.',
        ),
    ),
);
?>

<section class="heritage" data-heritage>
    <div class="heritage__inner">
        <div class="heritage__steps">
            <?php foreach ($etapes as $index => $etape) : ?>
                <article
                    class="heritage__step<?= 0 === $index ? ' is-active' : ''; ?>"
                    data-heritage-step="<?= (int) $index; ?>"
                >
                    <h2 class="heritage__title"><?= $etape['title']; ?></h2>

                    <?php foreach ($etape['contenus'] as $contenu) : ?>
                        <p class="heritage__text"><?= $contenu; ?></p>
                    <?php endforeach; ?>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="heritage__media">
            <?php foreach ($etapes as $index => $etape) : ?>
                <figure
                    class="heritage__visual<?= 0 === $index ? ' is-active' : ''; ?><?= !empty($etape['archive']) ? ' heritage__visual--archive' : ''; ?>"
                    data-heritage-visual="<?= (int) $index; ?>"
                >
                    <img
                        src="<?= esc_url($theme_uri . $etape['image']); ?>"
                        alt="<?= esc_attr($etape['alt']); ?>"
                        loading="lazy"
                    >
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>
