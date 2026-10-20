<?php
$theme_uri = get_stylesheet_directory_uri();
$kicker    = acharp_field('international_kicker') ?: 'International';
$title     = acharp_inline_html(acharp_field('international_title'));
$text      = acharp_field('international_text');
$cta       = acharp_link(acharp_field('international_cta'), home_url('/partenariats/'), 'Étudier à l’Académie');

if (!$title) {
    $title = 'Étudier à&nbsp;<strong>Paris</strong>';
}

if (!$text) {
    $text = "Chaque année, l'Académie Charpentier accueille des étudiants du monde entier, dans les mêmes formations que les étudiants français. Les cours sont dispensés en français, avec un niveau B2 requis.\n\nVotre français n'est pas encore à ce niveau ? Notre programme préparatoire, en partenariat avec Quantum Pathway Academy, vous permet de progresser en français et de préparer votre entrée à l'Académie. Deux rentrées par an : septembre et janvier.\n\nNous concevons aussi des programmes sur mesure avec nos universités partenaires à l'étranger.";
}

?>

<section id="international" class="international">
    <div class="international__grid">
        <figure class="international__media">
            <?= acharp_image_html(acharp_field('international_image'), 'large', array(
                'src'    => $theme_uri . '/images/international-paris.jpg',
                'alt'    => 'Vue sur les toits de Paris et la tour Eiffel',
                'width'  => 1900,
                'height' => 1267,
            )); ?>
        </figure>

        <div class="international__content">
            <?php if ($kicker) : ?>
                <p class="international__kicker"><?= esc_html($kicker); ?></p>
            <?php endif; ?>
            <h2 class="international__title"><?= $title; ?></h2>
            <div class="international__text">
                <?php foreach (preg_split("/\n\s*\n/", trim($text)) as $paragraph) : ?>
                    <?php if ($paragraph !== '') : ?>
                        <p><?= esc_html($paragraph); ?></p>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <a <?= acharp_link_attrs($cta); ?> class="btn btn--primary">
                <?= esc_html($cta['title']); ?>
                <?= acharp_arrow(); ?>
            </a>
        </div>
    </div>
</section>
