<?php
$theme_uri = get_stylesheet_directory_uri();
$type      = acharp_actualite_type();
$excerpt   = get_field('actualite_chapo') ?: (has_excerpt() ? get_the_excerpt() : '');
?>

<article class="actu-card">
    <a href="<?php the_permalink(); ?>" class="actu-card__link">
        <figure class="actu-card__media">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large'); ?>
            <?php else : ?>
                <?= acharp_image_html(0, 'large', array(
                    'src'    => $theme_uri . '/images/push-portes-ouvertes.jpg',
                    'alt'    => '',
                    'width'  => 800,
                    'height' => 800,
                )); ?>
            <?php endif; ?>

            <?php if ($type) : ?>
                <span class="actu-card__tag"><?= esc_html($type->name); ?></span>
            <?php endif; ?>
        </figure>

        <div class="actu-card__body">
            <time class="actu-card__date" datetime="<?= esc_attr(get_the_date('Y-m-d')); ?>">
                <?= esc_html(get_the_date('j F Y')); ?>
            </time>

            <h2 class="actu-card__title"><?php the_title(); ?></h2>

            <?php if ($excerpt) : ?>
                <p class="actu-card__text"><?= esc_html(wp_trim_words($excerpt, 24)); ?></p>
            <?php endif; ?>

            <span class="actu-card__more">
                Lire la suite
                <?= acharp_arrow('actu-card__arrow'); ?>
            </span>
        </div>
    </a>
</article>
