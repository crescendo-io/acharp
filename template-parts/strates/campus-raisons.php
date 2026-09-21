<?php
$arrow = '<span class="campus-raisons__arrow" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 8h10M9.5 4.5 13 8l-3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>';

$raisons = array(
    array(
        'title' => 'Un espace pensé pour<br>l’enseignement créatif',
        'text'  => 'Entièrement repensé, le nouveau campus offre des ateliers, studios, et espaces de travail rénovés pour favoriser la créativité, l’immersion et l’inspiration.',
    ),
    array(
        'title' => 'Un cadre central et accessible',
        'text'  => 'Situé en bords de Seine, le campus bénéficie d’un emplacement idéal pour les étudiants : accès facile en métro ou RER, proximité immédiate de la vie parisienne et du centre commercial Beaugrenelle, offrant de nombreuses commodités : boutiques, restaurants et supermarchés.',
    ),
    array(
        'title' => 'Un renouveau symbolique et pédagogique',
        'text'  => 'Ce déménagement marque une nouvelle étape dans l’histoire de l’école : modernisation des infrastructures, meilleure visibilité, et ambition renouvelée pour offrir une formation de haut niveau, en phase avec les enjeux contemporains du design et de l’architecture intérieure.',
    ),
);
?>

<section class="campus-raisons">
    <div class="container-fluid">
        <header class="campus-raisons__header">
            <p class="campus-raisons__kicker">Le campus</p>
            <h2 class="campus-raisons__title">
                Pourquoi ce nouveau <strong>campus</strong> ?
            </h2>
        </header>

        <div class="row">
            <?php foreach ($raisons as $raison) : ?>
                <div class="col-12 col-lg-4">
                    <article class="campus-raisons__item">
                        <h3 class="campus-raisons__name"><?= $raison['title']; ?></h3>
                        <p class="campus-raisons__text"><?= $raison['text']; ?></p>
                        <a href="#" class="campus-raisons__link">
                            Découvrir nos formations
                            <?= $arrow; ?>
                        </a>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
