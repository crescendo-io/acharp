<?php
$theme_uri = get_stylesheet_directory_uri();

$kicker        = get_field('hero_kicker');
$title         = get_field('hero_title');
$text          = get_field('hero_text');
$cta_primary   = acharp_link(get_field('hero_cta_primary'), '#', 'Candidater');
$cta_secondary = acharp_link(get_field('hero_cta_secondary'), '#', 'Découvrir nos formations');
$image_id      = get_field('hero_image');
$push          = get_field('hero_push');
$push          = is_array($push) ? $push : array();

if (!$kicker) {
    $kicker = 'École d’architecture intérieure & design à Paris';
}

if (!$title) {
    $title = 'Imaginez les espaces de <strong>demain</strong>';
} else {
    $title = wp_kses($title, array(
        'strong' => array(),
        'b'      => array(),
        'em'     => array(),
        'i'      => array(),
        'br'     => array(),
    ));
    $title = preg_replace('#</?p[^>]*>#i', '', $title);
}

if (!$text) {
    $text = 'Depuis plus de 60 ans, l’Académie Charpentier forme à Paris les futurs professionnels de l’architecture intérieure et du design.';
}

$arrow = '<span class="btn__icon" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 8h10M9.5 4.5 13 8l-3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>';

$show_push = !empty($push['show']);
if (!$show_push && !$image_id) {
    $show_push = true;
    $push = array(
        'link'    => array('url' => '#', 'title' => '', 'target' => ''),
        'image'   => 0,
        'date'    => '2024-05-24',
        'title'   => 'Journée porte ouverte',
        'excerpt' => 'Rencontrez nos équipes et découvrez nos formations et nos ateliers.',
    );
}
?>

<section class="hero">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5">
                <div class="hero__content">
                    <?php if ($kicker) : ?>
                        <p class="hero__kicker"><?= esc_html($kicker); ?></p>
                    <?php endif; ?>

                    <h1 class="hero__title"><?= $title; ?></h1>

                    <?php if ($text) : ?>
                        <p class="hero__text"><?= esc_html($text); ?></p>
                    <?php endif; ?>

                    <?php if ($cta_primary || $cta_secondary) : ?>
                        <div class="hero__actions">
                            <?php if (!empty($cta_primary['url'])) : ?>
                                <a
                                    href="<?= esc_url($cta_primary['url']); ?>"
                                    class="btn btn--primary"
                                    <?= !empty($cta_primary['target']) ? 'target="' . esc_attr($cta_primary['target']) . '" rel="noopener"' : ''; ?>
                                >
                                    <?= esc_html($cta_primary['title']); ?>
                                    <?= $arrow; ?>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($cta_secondary['url'])) : ?>
                                <a
                                    href="<?= esc_url($cta_secondary['url']); ?>"
                                    class="btn btn--outline"
                                    <?= !empty($cta_secondary['target']) ? 'target="' . esc_attr($cta_secondary['target']) . '" rel="noopener"' : ''; ?>
                                >
                                    <?= esc_html($cta_secondary['title']); ?>
                                    <?= $arrow; ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="hero__visual">
                    <div class="hero__media">
                        <?php if ($image_id) : ?>
                            <?= wp_get_attachment_image($image_id, 'full', false, array('class' => 'bg')); ?>
                        <?php else : ?>
                            <img
                                src="<?= esc_url($theme_uri . '/images/hero-atelier.jpg'); ?>"
                                alt="Atelier de l’Académie Charpentier"
                                width="1920"
                                height="1281"
                                class="bg"
                            >
                        <?php endif; ?>

                        <span class="hero__accent" aria-hidden="true"></span>

                        <?php if ($show_push) : ?>
                            <?php
                            $push_link   = acharp_link($push['link'] ?? array(), '#');
                            $push_url    = $push_link['url'];
                            $push_target = $push_link['target'];
                            $push_date   = $push['date'] ?? '';
                            $push_title  = $push['title'] ?? '';
                            $push_excerpt = $push['excerpt'] ?? '';
                            $push_image  = $push['image'] ?? 0;
                            ?>
                            <article class="push-actu">
                                <button type="button" class="push-actu__close" aria-label="Fermer l’actualité">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path d="M1 1l10 10M11 1 1 11" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                                    </svg>
                                </button>
                                <a
                                    href="<?= esc_url($push_url); ?>"
                                    class="push-actu__link"
                                    <?= $push_target ? 'target="' . esc_attr($push_target) . '" rel="noopener"' : ''; ?>
                                >
                                    <span class="push-actu__thumb">
                                        <?php if ($push_image) : ?>
                                            <?= wp_get_attachment_image($push_image, 'thumbnail'); ?>
                                        <?php else : ?>
                                            <img
                                                src="<?= esc_url($theme_uri . '/images/push-portes-ouvertes.jpg'); ?>"
                                                alt=""
                                                width="160"
                                                height="160"
                                            >
                                        <?php endif; ?>
                                    </span>
                                    <span class="push-actu__body">
                                        <?php if ($push_date) : ?>
                                            <time class="push-actu__date" datetime="<?= esc_attr($push_date); ?>">
                                                <?= esc_html(date_i18n('j F Y', strtotime($push_date))); ?>
                                            </time>
                                        <?php endif; ?>
                                        <?php if ($push_title) : ?>
                                            <span class="push-actu__title"><?= esc_html($push_title); ?></span>
                                        <?php endif; ?>
                                        <?php if ($push_excerpt) : ?>
                                            <span class="push-actu__excerpt"><?= esc_html($push_excerpt); ?></span>
                                        <?php endif; ?>
                                    </span>
                                </a>
                            </article>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
