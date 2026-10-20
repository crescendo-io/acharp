<?php
/*
Template Name: Vie de l’école
*/
get_header();
get_template_part('template-parts/strates/header');
?>

<main class="page-vie-ecole">
    <?php
    get_template_part('template-parts/strates/hero');
    get_template_part('template-parts/strates/vie-ecole');
    get_template_part('template-parts/strates/equipe-pedagogique');
    get_template_part('template-parts/strates/insertion-professionnelle');
    ?>
</main>

<?php
get_template_part('template-parts/strates/footer');
get_footer();
