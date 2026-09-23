<?php
get_header();
get_template_part('template-parts/strates/header');

get_template_part('template-parts/strates/hero', null, array(
    'post_id'       => 'actualite_archive',
    'kicker'        => 'Actualités & évènements',
    'title'         => 'La vie de <strong>l’Académie</strong>',
    'text'          => 'Portes ouvertes, conférences, expositions, remises de diplômes : suivez tout ce qui anime l’école.',
    'push_fallback' => false,
));
?>

<main class="actu-archive">
    <?php get_template_part('template-parts/general/liste-actualites'); ?>
</main>

<?php
get_template_part('template-parts/strates/footer');
get_footer();
