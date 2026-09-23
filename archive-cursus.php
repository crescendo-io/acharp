<?php
get_header();
get_template_part('template-parts/strates/header');
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
                            <?php get_template_part('template-parts/general/card-cursus', null, array(
                                'card'    => acharp_cursus_card(get_the_ID()),
                                'heading' => 'h2',
                            )); ?>
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
