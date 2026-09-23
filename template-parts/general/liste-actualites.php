<?php
$filters = acharp_actualite_filters();
$current = acharp_actualite_current_term();
$base    = $current ? get_term_link($current) : (get_post_type_archive_link('actualite') ?: home_url('/'));

if (is_wp_error($base)) {
    $base = get_post_type_archive_link('actualite') ?: home_url('/');
}
?>

<section class="actu-list" data-actu-list>
    <div class="container-fluid">
        <?php if (count($filters) > 1) : ?>
            <nav class="actu-filters" aria-label="Filtrer les actualités">
                <ul class="actu-filters__list">
                    <?php foreach ($filters as $filter) : ?>
                        <?php if (is_wp_error($filter['url'])) { continue; } ?>
                        <li>
                            <a
                                href="<?= esc_url($filter['url']); ?>"
                                class="actu-filters__item<?= $filter['active'] ? ' is-active' : ''; ?>"
                                data-actu-filter="<?= esc_attr($filter['slug']); ?>"
                                <?= $filter['active'] ? 'aria-current="page"' : ''; ?>
                            >
                                <?= esc_html($filter['label']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        <?php endif; ?>

        <div
            class="actu-list__results"
            data-actu-results
            data-actu-term="<?= esc_attr($current ? $current->slug : ''); ?>"
            aria-live="polite"
            aria-busy="false"
        >
            <?php get_template_part('template-parts/general/resultats-actualites', null, array(
                'base_url' => $base,
            )); ?>
        </div>
    </div>
</section>
