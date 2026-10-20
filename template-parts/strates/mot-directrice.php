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

<section id="mot-directrice" class="mot-directrice">
    <div class="container-fluid">
        <div class="mot-directrice__grid">
            <figure class="mot-directrice__media">
                <?= acharp_image_html($image_id, 'large', array(
                    'src' => $theme_uri . '/images/directrice-sylvie.jpg',
                    'alt' => 'Sylvie Cedrin-Felix, directrice de l’Académie Charpentier',
                )); ?>
            </figure>
            <div class="mot-directrice__content">
                <p class="mot-directrice__kicker"><?= esc_html($kicker); ?></p>
                <h2 class="mot-directrice__title"><?= esc_html($name); ?></h2>
                <p class="mot-directrice__role"><?= esc_html($role); ?></p>
                <div class="mot-directrice__text">
                    <?php foreach (preg_split("/\n\s*\n/", trim($text)) as $paragraph) : ?>
                        <?php if ($paragraph !== '') : ?>
                            <p><?= esc_html($paragraph); ?></p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
