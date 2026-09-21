<?php
get_header();
get_template_part('template-parts/strates/header');
?>

<main class="cursus-single">
    <?php
    get_template_part('template-parts/strates/hero');
    get_template_part('template-parts/strates/formation-intro');
    get_template_part('template-parts/strates/debouches');
    get_template_part('template-parts/strates/diplome');
    get_template_part('template-parts/strates/prepa');
    get_template_part('template-parts/strates/programme');
    get_template_part('template-parts/strates/admissions');
    get_template_part('template-parts/strates/tarifs');
    ?>
</main>

<?php
get_template_part('template-parts/strates/footer');
get_footer();
