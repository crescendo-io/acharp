<?php
get_header();
get_template_part('template-parts/strates/header');

$term        = get_queried_object();
$description = ($term && !empty($term->description)) ? $term->description : '';

get_template_part('template-parts/strates/hero', null, array(
    'post_id'       => 'actualite_archive',
    'push_fallback' => false,
    'overrides'     => array(
        'kicker' => 'Actualités & évènements',
        'title'  => $term ? sprintf('<strong>%s</strong>', esc_html($term->name)) : 'La vie de <strong>l’Académie</strong>',
        'text'   => $description ?: 'Retrouvez toutes les actualités de l’école portant cette étiquette.',
    ),
));
?>

<main class="actu-archive">
    <?php get_template_part('template-parts/general/liste-actualites'); ?>
</main>

<?php
get_template_part('template-parts/strates/footer');
get_footer();
