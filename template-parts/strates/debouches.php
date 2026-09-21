<?php
$debouches = array(
    array(
        'shape' => 'debouches__shape--triangle debouches__shape--pink',
        'title' => 'Concevoir et aménager',
        'text'  => 'Des espaces intérieurs ou extérieurs, publics ou privés, alliant esthétique, ergonomie et fonctionnalité.',
    ),
    array(
        'shape' => 'debouches__shape--half debouches__shape--green',
        'title' => 'Créer des scénographies',
        'text'  => 'Des espaces intérieurs ou extérieurs, publics ou privés, alliant esthétique, ergonomie et fonctionnalité.',
    ),
    array(
        'shape' => 'debouches__shape--triangle debouches__shape--blue',
        'title' => 'Mener des projets de recherche et d’étude',
        'text'  => 'À partir de situations réelles, en intégrant des contraintes techniques, sociales et environnementales.',
    ),
    array(
        'shape' => 'debouches__shape--three-quarter debouches__shape--orange',
        'title' => 'Réfléchir à la transformation',
        'text'  => 'Des espaces urbains ou ruraux, dans le respect des principes du développement durable et des 17 Objectifs de Développement Durable (ODD) de l’ONU.',
    ),
);
?>

<section class="debouches">
    <div class="container-fluid">
        <header class="debouches__header">
            <p class="debouches__kicker">Débouchés et poursuite d’études</p>

            <h2 class="debouches__title">
                Une formation <strong>créative</strong> et<br>
                <strong>opérationnelle</strong>
            </h2>
        </header>

        <div class="row">
            <?php foreach ($debouches as $debouche) : ?>
                <div class="col-12 col-md-6 col-lg-3">
                    <article class="debouches__item">
                        <span class="debouches__shape <?= $debouche['shape']; ?>" aria-hidden="true"></span>

                        <div class="debouches__body">
                            <h3 class="debouches__name"><?= $debouche['title']; ?></h3>
                            <p class="debouches__text"><?= $debouche['text']; ?></p>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
