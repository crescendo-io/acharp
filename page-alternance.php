<?php
/*
Template Name: Alternance
*/
get_header();
get_template_part('template-parts/strates/header');
?>

<main class="page-alternance">
    <?php
    get_template_part('template-parts/strates/hero', null, array(
        'kicker'          => 'Alternance',
        'title'           => 'Alternance et insertion <strong>professionnelle</strong>',
        'text'            => 'Une formation diplômante en entreprise, et un accompagnement vers les métiers de l’architecture intérieure.',
        'push_fallback'   => false,
    ));
    get_template_part('template-parts/strates/alternance');
    ?>
</main>

<?php
get_template_part('template-parts/strates/footer');
get_footer();
