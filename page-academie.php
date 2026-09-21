<?php
/*
Template Name: L’académie
*/
get_header();
get_template_part('template-parts/strates/header');
?>

<main class="page-academie">
    <?php
    get_template_part('template-parts/strates/hero');
    get_template_part('template-parts/strates/heritage');

    get_template_part('template-parts/strates/pedagogie');
    get_template_part('template-parts/strates/formations');
    get_template_part('template-parts/strates/reconnaissances');


    get_template_part('template-parts/strates/campus');
    get_template_part('template-parts/strates/campus-raisons');
    get_template_part('template-parts/strates/eco-transition');
    get_template_part('template-parts/strates/guide-handicap');
    ?>
</main>

<?php
get_template_part('template-parts/strates/footer');
get_footer();
