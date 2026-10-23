<?php
get_header();
get_template_part('template-parts/strates/header');

$archive_url = get_post_type_archive_link('actualite') ?: home_url('/');
?>

<main class="actu-single">
    <?php
    $related_posts = get_posts(array(
        'post_type'           => 'actualite',
        'posts_per_page'      => 3,
        'post__not_in'        => array(get_queried_object_id()),
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
    ));
    ?>
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
            <div class="container-fluid">
                <div class="actu-single__layout<?= $related_posts ? '' : ' actu-single__layout--full'; ?>">
                    <div class="actu-single__main">
            <header class="actu-single__header">
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
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <figure class="actu-single__cover">
                    <?php the_post_thumbnail('full'); ?>
                </figure>
            <?php endif; ?>

            <div class="actu-single__content">
                    <div class="actu-single__strates">
                        <?php if (function_exists('have_rows') && have_rows('actualite_strates')) : ?>
                            <?php while (have_rows('actualite_strates')) : the_row(); ?>
                                <?php $layout = get_row_layout(); ?>

                                <?php if ($layout === 'image_centree') : ?>
                                    <?php $image_id = get_sub_field('image'); ?>
                                    <?php if ($image_id) : ?>
                                        <figure class="actu-strate actu-strate--image">
                                            <?= acharp_image_html($image_id, 'full'); ?>
                                        </figure>
                                    <?php endif; ?>
                                <?php elseif ($layout === 'image_texte') : ?>
                                    <?php
                                    $image_id = get_sub_field('image');
                                    $texte    = get_sub_field('texte');
                                    ?>
                                    <?php if ($image_id || $texte) : ?>
                                        <div class="actu-strate actu-strate--split">
                                            <?php if ($image_id) : ?>
                                                <figure class="actu-strate__media">
                                                    <?= acharp_image_html($image_id, 'large'); ?>
                                                </figure>
                                            <?php endif; ?>
                                            <?php if ($texte) : ?>
                                                <div class="actu-strate__text"><?= wp_kses_post($texte); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                <?php elseif ($layout === 'texte_centre') : ?>
                                    <?php $texte = get_sub_field('texte'); ?>
                                    <?php if ($texte) : ?>
                                        <div class="actu-strate actu-strate--text">
                                            <?= wp_kses_post($texte); ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>

                    <?php if ($has_infos) : ?>
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
                    <?php endif; ?>
            </div>
                    </div>

                    <?php if ($related_posts) : ?>
                        <aside class="actu-single__aside">
                            <h2 class="actu-single__aside-title">Autres actualités</h2>

                            <div class="actu-single__aside-list">
                                <?php foreach ($related_posts as $related_post) : ?>
                                    <?php
                                    $post = $related_post;
                                    setup_postdata($post);
                                    ?>
                                    <?php get_template_part('template-parts/general/card-actualite'); ?>
                                <?php endforeach; ?>
                                <?php wp_reset_postdata(); ?>
                            </div>
                        </aside>
                    <?php endif; ?>
                </div>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php
get_template_part('template-parts/strates/footer');
get_footer();
