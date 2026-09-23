<?php
/**
 * Rendu des résultats seuls, pour être régénéré à l’identique en AJAX.
 * $args : query (WP_Query), base_url (string), paged (int)
 */
$args     = isset($args) && is_array($args) ? $args : array();
$query    = $args['query'] ?? $GLOBALS['wp_query'];
$base_url = $args['base_url'] ?? (get_post_type_archive_link('actualite') ?: home_url('/'));
$paged    = (int) ($args['paged'] ?? max(1, (int) get_query_var('paged')));
?>

<?php if ($query->have_posts()) : ?>
    <div class="row">
        <?php while ($query->have_posts()) : $query->the_post(); ?>
            <div class="col-12 col-md-6 col-lg-4">
                <?php get_template_part('template-parts/general/card-actualite'); ?>
            </div>
        <?php endwhile; ?>
    </div>

    <?= acharp_actualite_pagination($query, $base_url, $paged ?: 1); ?>
    <?php wp_reset_postdata(); ?>
<?php else : ?>
    <p class="actu-list__empty">Aucune actualité à afficher pour le moment.</p>
<?php endif; ?>
