<?php
/*
Template Name: Galerie
*/
get_header();
get_template_part('template-parts/strates/header');
get_template_part('template-parts/strates/hero');
?>

<main class="page-realisations">
    <?php get_template_part('template-parts/strates/realisations-diplomes'); ?>
</main>

<?php
get_template_part('template-parts/strates/footer');
get_footer();
