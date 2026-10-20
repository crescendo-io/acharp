<?php
/*
Template Name: Contenu flexible
*/
get_header();
get_template_part('template-parts/strates/header');

$layout_parts = array(
    'chiffres_cles'    => 'chiffres-cles',
    'histoire'         => 'histoire',
    'formations'       => 'formations',
    'reconnaissances'  => 'reconnaissances',
    'vie_ecole'        => 'vie-ecole',
    'international'    => 'international',
    'actualites'       => 'actualites',
    'heritage'         => 'heritage',
    'pedagogie'        => 'pedagogie',
    'campus'           => 'campus',
    'campus_raisons'   => 'campus-raisons',
    'eco'              => 'eco-transition',
    'handicap'         => 'guide-handicap',
    'realisations'     => 'realisations-diplomes',
    'formation_intro'  => 'formation-intro',
    'debouches'        => 'debouches',
    'diplome'          => 'diplome',
    'prepa'            => 'prepa',
    'programme'        => 'programme',
    'admissions'       => 'admissions',
    'tarifs'           => 'tarifs',
    'mot_directrice'   => 'mot-directrice',
    'equipe_pedagogique' => 'equipe-pedagogique',
    'insertion_pro'    => 'insertion-professionnelle',
    'partenariats'     => 'partenariats',
    'alumni_showcase'  => 'alumni-showcase',
);
?>

<main class="page-flexible">
    <?php
    get_template_part('template-parts/strates/hero');

    if (function_exists('have_rows') && have_rows('page_flexible')) {
        while (have_rows('page_flexible')) {
            the_row();
            $layout = get_row_layout();
            $part   = $layout_parts[$layout] ?? '';

            if ($part) {
                get_template_part('template-parts/strates/' . $part);
            }
        }
    }
    ?>
</main>

<?php
get_template_part('template-parts/strates/footer');
get_footer();
