<?php
/*
Template Name: Accueil
*/
get_header();
get_template_part('template-parts/strates/header');
?>

<main class="page-accueil">
    <?php
    get_template_part('template-parts/strates/hero');
    get_template_part('template-parts/strates/chiffres-cles');
    get_template_part('template-parts/strates/histoire');
    get_template_part('template-parts/strates/formations');
    get_template_part('template-parts/strates/reconnaissances');
    get_template_part('template-parts/strates/vie-ecole');
    get_template_part('template-parts/strates/international');
    get_template_part('template-parts/strates/actualites');
    ?>
</main>

<?php
get_template_part('template-parts/strates/footer');
get_footer();
