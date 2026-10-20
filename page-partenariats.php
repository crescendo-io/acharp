<?php
/*
Template Name: Partenariats
*/
get_header();
get_template_part('template-parts/strates/header');
?>

<main class="page-partenariats">
    <?php
    get_template_part('template-parts/strates/hero', null, array(
        'overrides' => array(
            'kicker' => 'Partenariats',
            'title'  => 'Entreprises, institutions<br> et <strong>universités</strong>',
            'text'   => 'Découvrez nos partenariats pédagogiques, internationaux et professionnels.',
        ),
        'push_fallback' => false,
    ));
    get_template_part('template-parts/strates/partenariats');
    get_template_part('template-parts/strates/international');
    get_template_part('template-parts/strates/insertion-professionnelle');
    ?>
</main>

<?php
get_template_part('template-parts/strates/footer');
get_footer();
