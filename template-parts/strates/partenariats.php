<?php
$kicker   = acharp_field('partenariats_kicker') ?: 'Partenariats';
$title    = acharp_inline_html(acharp_field('partenariats_title'));
$intro    = acharp_field('partenariats_intro');
$partners = acharp_rows(acharp_field('partenariats_items'));
$cta      = acharp_link(acharp_field('partenariats_cta'), home_url('/contact/'), 'Devenir partenaire');

if (!$title) {
    $title = 'Des partenariats qui<br> <strong>structurent l’enseignement</strong>';
}

if (!$intro) {
    $intro = 'Entreprises, institutions culturelles et universités : nos partenariats nourrissent la pédagogie, les projets étudiants et l’insertion professionnelle.';
}

if (!$partners) {
    $partners = array(
        array('name' => 'Théâtre de l’Odéon', 'text' => 'Atelier d’expression Odéon (3e année) et projet de scénographie.'),
        array('name' => 'SNCF', 'text' => 'Projets partenaires avec l’entreprise (4e année).'),
        array('name' => 'ICADE', 'text' => 'Entreprise partenaire, projets partenaires (4e année).'),
        array('name' => 'Matériaux Archi', 'text' => 'Partenaire des conférences du vendredi, avec un cycle sur les matériaux biosourcés.'),
    );
}
?>

<section id="partenariats" class="partenariats-hub">
    <div class="container-fluid">
        <header class="partenariats-hub__header">
            <p class="partenariats-hub__kicker"><?= esc_html($kicker); ?></p>
            <h2 class="partenariats-hub__title"><?= $title; ?></h2>
            <?php if ($intro) : ?>
                <p class="partenariats-hub__intro"><?= esc_html($intro); ?></p>
            <?php endif; ?>
        </header>

        <div class="partenariats-hub__grid">
            <?php foreach ($partners as $partner) : ?>
                <article class="partenariats-hub__card">
                    <?php if (!empty($partner['image'])) : ?>
                        <figure class="partenariats-hub__logo">
                            <?= acharp_image_html($partner['image'], 'medium'); ?>
                        </figure>
                    <?php endif; ?>
                    <h3 class="partenariats-hub__name"><?= esc_html($partner['name'] ?? ''); ?></h3>
                    <?php if (!empty($partner['text'])) : ?>
                        <p class="partenariats-hub__text"><?= esc_html($partner['text']); ?></p>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="partenariats-hub__blocks">
            <article class="partenariats-hub__block">
                <h3>Les conférences du vendredi</h3>
                <p>Des professionnels reconnus de l’architecture et du luxe viennent présenter leur pratique aux étudiants, toutes années confondues. Prochains invités : Museum Studio, Studio KO, matériO’ et le Jardin des Métiers d’Art et du Design.</p>
            </article>
            <article class="partenariats-hub__block">
                <h3>Partenariats internationaux</h3>
                <p>Programme préparatoire avec Quantum Pathway Academy et programmes sur mesure montés avec des universités partenaires à l’étranger.</p>
            </article>
        </div>

        <a <?= acharp_link_attrs($cta); ?> class="btn btn--primary partenariats-hub__cta">
            <?= esc_html($cta['title']); ?>
            <?= acharp_arrow(); ?>
        </a>
    </div>
</section>
