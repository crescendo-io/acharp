<?php
get_header();
get_template_part('template-parts/strates/header');

$archive_url = get_post_type_archive_link('actualite') ?: home_url('/');
?>

<main class="actu-single">
    <?php while (have_posts()) : the_post(); ?>
        <?php
        $type      = acharp_actualite_type();
        $type_link = $type ? get_term_link($type) : null;
        $chapo     = get_field('actualite_chapo') ?: (has_excerpt() ? get_the_excerpt() : '');
        $infos = get_field('actualite_infos');
        $infos = is_array($infos) ? $infos : array();

        $date_start = $infos['date_start'] ?? '';
        $date_end   = $infos['date_end'] ?? '';
        $schedule   = $infos['schedule'] ?? '';
        $place      = $infos['place'] ?? '';
        $cta        = acharp_link($infos['cta'] ?? array());
        $has_infos  = $date_start || $schedule || $place || $cta['url'];
        ?>

        <article <?php post_class('actu-single__article'); ?>>
            <header class="actu-single__header">
                <div class="container-fluid">
                    <a href="<?= esc_url($archive_url); ?>" class="actu-single__back">Toutes les actualités</a>

                    <p class="actu-single__meta">
                        <?php if ($type && !is_wp_error($type_link)) : ?>
                            <a href="<?= esc_url($type_link); ?>" class="actu-single__type"><?= esc_html($type->name); ?></a>
                        <?php elseif ($type) : ?>
                            <span class="actu-single__type"><?= esc_html($type->name); ?></span>
                        <?php endif; ?>
                        <time datetime="<?= esc_attr(get_the_date('Y-m-d')); ?>"><?= esc_html(get_the_date('j F Y')); ?></time>
                    </p>

                    <h1 class="actu-single__title"><?php the_title(); ?></h1>

                    <?php if ($chapo) : ?>
                        <p class="actu-single__chapo"><?= esc_html($chapo); ?></p>
                    <?php endif; ?>
                </div>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <figure class="actu-single__cover">
                    <div class="container-fluid">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                </figure>
            <?php endif; ?>

            <div class="actu-single__content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-lg-8">
                            <div class="actu-single__prose">
                                <?php the_content(); ?>
                            </div>
                        </div>

                        <?php if ($has_infos) : ?>
                            <div class="col-12 col-lg-4">
                                <aside class="actu-infos">
                                    <h2 class="actu-infos__title">Informations pratiques</h2>

                                    <dl class="actu-infos__list">
                                        <?php if ($date_start) : ?>
                                            <div class="actu-infos__row">
                                                <dt>Date</dt>
                                                <dd>
                                                    <?= esc_html(date_i18n('j F Y', strtotime($date_start))); ?>
                                                    <?php if ($date_end && $date_end !== $date_start) : ?>
                                                        → <?= esc_html(date_i18n('j F Y', strtotime($date_end))); ?>
                                                    <?php endif; ?>
                                                </dd>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($schedule) : ?>
                                            <div class="actu-infos__row">
                                                <dt>Horaires</dt>
                                                <dd><?= esc_html($schedule); ?></dd>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($place) : ?>
                                            <div class="actu-infos__row">
                                                <dt>Lieu</dt>
                                                <dd><?= esc_html($place); ?></dd>
                                            </div>
                                        <?php endif; ?>
                                    </dl>

                                    <?php if ($cta['url']) : ?>
                                        <a <?= acharp_link_attrs($cta); ?> class="btn btn--primary">
                                            <?= esc_html($cta['title'] ?: 'S’inscrire'); ?>
                                            <?= acharp_arrow(); ?>
                                        </a>
                                    <?php endif; ?>
                                </aside>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </article>
    <?php endwhile; ?>

    <?php
    $related = new WP_Query(array(
        'post_type'           => 'actualite',
        'posts_per_page'      => 3,
        'post__not_in'        => array(get_queried_object_id()),
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
    ));
    ?>

    <?php if ($related->have_posts()) : ?>
        <section class="actu-list actu-list--related">
            <div class="container-fluid">
                <div class="actu-list__header">
                    <h2 class="actu-list__heading">Autres actualités</h2>
                    <a href="<?= esc_url($archive_url); ?>" class="actu-list__all">
                        Voir toutes nos actualités
                        <?= acharp_arrow('actu-list__arrow'); ?>
                    </a>
                </div>

                <div class="row">
                    <?php while ($related->have_posts()) : $related->the_post(); ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <?php get_template_part('template-parts/general/card-actualite'); ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
</main>

<?php
get_template_part('template-parts/strates/footer');
get_footer();
