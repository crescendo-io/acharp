<?php
$theme_uri = get_stylesheet_directory_uri();
$kicker    = acharp_field('directrice_kicker') ?: 'Mot de la directrice';
$name      = acharp_field('directrice_name') ?: 'Sylvie Cedrin-Felix';
$role      = acharp_field('directrice_role') ?: 'Directrice de l’Académie Charpentier';
$text      = acharp_field('directrice_text');
$image_id  = acharp_field('directrice_photo');

if (!$text) {
    $text = "Sylvie, c'est 29 ans de présence à l'Académie Charpentier et autant d'années à transmettre sa passion avec exigence et générosité. Après en avoir été la coordinatrice pédagogique, accompagnant les admissions ainsi que les étudiants de 2e, 3e et 4e année, elle dirige aujourd'hui l'école.\n\nArchitecte d'intérieur de formation, elle a exercé en parallèle pendant plus de 25 ans. Cet ancrage dans la pratique donne toute sa profondeur à sa vision de l'école : elle transmet un métier qu'elle connaît de l'intérieur.\n\nExigeante, généreuse et fidèle à l'Académie, Sylvie fait partie de celles qui construisent, année après année, l'identité de l'école.";
}
?>

<section id="mot-directrice" class="mot-directrice" data-mot-directrice>
    <div class="container-fluid">
        <div class="mot-directrice__grid">
            <figure class="mot-directrice__media">
                <span class="mot-directrice__mark mot-directrice__mark--triangle" data-mot-parallax data-parallax-speed="0.12" aria-hidden="true"></span>
                <span class="mot-directrice__mark mot-directrice__mark--half-left" data-mot-parallax data-parallax-speed="0.18" aria-hidden="true"></span>
                <span class="mot-directrice__mark mot-directrice__mark--half-right" data-mot-parallax data-parallax-speed="0.1" aria-hidden="true"></span>
                <span class="mot-directrice__mark mot-directrice__mark--triangle-blue" data-mot-parallax data-parallax-speed="0.16" aria-hidden="true"></span>
                <?= acharp_image_html($image_id, 'large', array(
                    'src' => $theme_uri . '/images/directrice-sylvie.jpg',
                    'alt' => 'Sylvie Cedrin-Felix, directrice de l’Académie Charpentier',
                )); ?>
            </figure>
            <div class="mot-directrice__content">
                <p class="mot-directrice__kicker">
                    <span class="mot-directrice__kicker-mark" aria-hidden="true"></span>
                    <?= esc_html($kicker); ?>
                </p>
                <h2 class="mot-directrice__title"><?= esc_html($name); ?></h2>
                <p class="mot-directrice__role"><?= esc_html($role); ?></p>
                <div class="mot-directrice__text">
                    <?php foreach (preg_split("/\n\s*\n/", trim($text)) as $index => $paragraph) : ?>
                        <?php if ($paragraph !== '') : ?>
                            <p<?= 0 === (int) $index ? ' class="mot-directrice__lead"' : ''; ?>><?= esc_html($paragraph); ?></p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
