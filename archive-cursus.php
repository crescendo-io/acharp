<?php
get_header();
get_template_part('template-parts/strates/header');

$arrow = '<span class="formations__arrow" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 8h10M9.5 4.5 13 8l-3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>';
?>

<main class="cursus-archive">
    <section class="formations">
        <div class="container-fluid">
            <div class="formations__header">
                <div class="formations__intro">
                    <p class="formations__kicker">Nos formations</p>
                    <h1 class="formations__title">
                        Trouvez le parcours<br>
                        qui <strong>vous ressemble</strong>
                    </h1>
                </div>
            </div>

            <?php if (have_posts()) : ?>
                <div class="row">
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="col-12 col-lg-4">
                            <article class="formations__card">
                                <?php if (has_post_thumbnail()) : ?>
                                    <figure class="formations__media">
                                        <?php the_post_thumbnail('large'); ?>
                                    </figure>
                                <?php endif; ?>

                                <div class="formations__body">
                                    <h2 class="formations__name"><?php the_title(); ?></h2>

                                    <?php if (has_excerpt()) : ?>
                                        <p class="formations__text"><?php echo esc_html(get_the_excerpt()); ?></p>
                                    <?php endif; ?>

                                    <a href="<?php the_permalink(); ?>" class="formations__link">
                                        Découvrir le cursus
                                        <?= $arrow; ?>
                                    </a>
                                </div>
                            </article>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <p>Aucun cursus n’est publié pour le moment.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
get_template_part('template-parts/strates/footer');
get_footer();
