<?php
$kicker  = get_field('campus_raisons_kicker') ?: 'Le campus';
$title   = acharp_inline_html(get_field('campus_raisons_title'));
$items   = acharp_rows(get_field('campus_raisons_items'));
$archive = get_post_type_archive_link('cursus') ?: '#';

if (!$title) {
    $title = 'Pourquoi ce nouveau <strong>campus</strong> ?';
}

if (!$items) {
    $items = array(
        array(
            'title' => 'Un espace pensé pour<br>l’enseignement créatif',
            'text'  => 'Entièrement repensé, le nouveau campus offre des ateliers, studios, et espaces de travail rénovés pour favoriser la créativité, l’immersion et l’inspiration.',
            'link'  => array('url' => $archive, 'title' => 'Découvrir nos formations'),
        ),
        array(
            'title' => 'Un cadre central et accessible',
            'text'  => 'Situé en bords de Seine, le campus bénéficie d’un emplacement idéal pour les étudiants : accès facile en métro ou RER, proximité immédiate de la vie parisienne et du centre commercial Beaugrenelle, offrant de nombreuses commodités : boutiques, restaurants et supermarchés.',
            'link'  => array('url' => $archive, 'title' => 'Découvrir nos formations'),
        ),
        array(
            'title' => 'Un renouveau symbolique et pédagogique',
            'text'  => 'Ce déménagement marque une nouvelle étape dans l’histoire de l’école : modernisation des infrastructures, meilleure visibilité, et ambition renouvelée pour offrir une formation de haut niveau, en phase avec les enjeux contemporains du design et de l’architecture intérieure.',
            'link'  => array('url' => $archive, 'title' => 'Découvrir nos formations'),
        ),
    );
}
?>

<section class="campus-raisons">
    <div class="container-fluid">
        <header class="campus-raisons__header">
            <?php if ($kicker) : ?>
                <p class="campus-raisons__kicker"><?= esc_html($kicker); ?></p>
            <?php endif; ?>
            <h2 class="campus-raisons__title"><?= $title; ?></h2>
        </header>

        <div class="row">
            <?php foreach ($items as $item) : ?>
                <?php
                $related = $item['cursus'] ?? null;
                $id      = $related ? (is_object($related) ? $related->ID : (int) $related) : 0;
                $card    = $id ? acharp_cursus_card($id) : array();
                $link    = acharp_link(
                    $item['link'] ?? array(),
                    $card['url'] ?? $archive,
                    $card['link_label'] ?? 'Découvrir nos formations'
                );
                ?>
                <div class="col-12 col-lg-4">
                    <article class="campus-raisons__item">
                        <h3 class="campus-raisons__name"><?= acharp_inline_html($item['title'] ?? ''); ?></h3>
                        <?php if (!empty($item['text'])) : ?>
                            <p class="campus-raisons__text"><?= esc_html($item['text']); ?></p>
                        <?php endif; ?>
                        <a <?= acharp_link_attrs($link); ?> class="campus-raisons__link">
                            <?= esc_html($link['title']); ?>
                            <?= acharp_arrow('campus-raisons__arrow'); ?>
                        </a>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
