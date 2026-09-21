<?php
/*
Template Name: styleguide
*/
get_header(); ?>

<?php get_template_part('template-parts/strates/header'); ?>

<main class="styleguide">
    <?php get_template_part('template-parts/strates/hero'); ?>
    <?php get_template_part('template-parts/strates/chiffres-cles'); ?>
    <?php get_template_part('template-parts/strates/histoire'); ?>
    <?php get_template_part('template-parts/strates/formations'); ?>

    <?php get_template_part('template-parts/strates/reconnaissances'); ?>
    <?php get_template_part('template-parts/strates/vie-ecole'); ?>
    <?php get_template_part('template-parts/strates/international'); ?>
    <?php get_template_part('template-parts/strates/actualites'); ?>

</main>

<?php get_template_part('template-parts/strates/footer'); ?>

<?php get_footer(); ?>
