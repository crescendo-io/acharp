<?php
$kicker = get_field('debouches_kicker') ?: 'Débouchés et poursuite d’études';
$title  = acharp_inline_html(get_field('debouches_title'));
$items  = acharp_rows(get_field('debouches_items'));

if (!$title) {
    $title = 'Une formation <strong>créative</strong> et<br> <strong>opérationnelle</strong>';
}

if (!$items) {
    $items = array(
        array('shape' => 'triangle', 'color' => 'pink', 'title' => 'Concevoir et aménager', 'text' => 'Des espaces intérieurs ou extérieurs, publics ou privés, alliant esthétique, ergonomie et fonctionnalité.'),
        array('shape' => 'half', 'color' => 'green', 'title' => 'Créer des scénographies', 'text' => 'Des espaces intérieurs ou extérieurs, publics ou privés, alliant esthétique, ergonomie et fonctionnalité.'),
        array('shape' => 'triangle', 'color' => 'blue', 'title' => 'Mener des projets de recherche et d’étude', 'text' => 'À partir de situations réelles, en intégrant des contraintes techniques, sociales et environnementales.'),
        array('shape' => 'three-quarter', 'color' => 'orange', 'title' => 'Réfléchir à la transformation', 'text' => 'Des espaces urbains ou ruraux, dans le respect des principes du développement durable et des 17 Objectifs de Développement Durable (ODD) de l’ONU.'),
    );
}
?>

<section class="debouches">
    <div class="container-fluid">
        <header class="debouches__header">
            <?php if ($kicker) : ?>
                <p class="debouches__kicker"><?= esc_html($kicker); ?></p>
            <?php endif; ?>
            <h2 class="debouches__title"><?= $title; ?></h2>
        </header>

        <div class="row">
            <?php foreach ($items as $item) : ?>
                <?php
                $shape = $item['shape'] ?? 'triangle';
                $color = $item['color'] ?? 'pink';
                ?>
                <div class="col-12 col-md-6 col-lg-3">
                    <article class="debouches__item">
                        <span class="debouches__shape debouches__shape--<?= esc_attr($shape); ?> debouches__shape--<?= esc_attr($color); ?>" aria-hidden="true"></span>
                        <div class="debouches__body">
                            <h3 class="debouches__name"><?= esc_html($item['title'] ?? ''); ?></h3>
                            <?php if (!empty($item['text'])) : ?>
                                <p class="debouches__text"><?= esc_html($item['text']); ?></p>
                            <?php endif; ?>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
