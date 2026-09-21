<?php
$theme_uri = get_stylesheet_directory_uri();
$kicker    = get_field('vie_kicker') ?: 'Vie à l’école';
$title     = acharp_inline_html(get_field('vie_title'));
$cta       = acharp_link(get_field('vie_cta'), '#', 'Découvrir l’académie');
$tiles     = acharp_rows(get_field('vie_tiles'));

if (!$title) {
    $title = 'Découvrez l’univers<br> <strong>Charpentier</strong>';
}

if (!$tiles) {
    $tiles = array(
        array('image' => 0, 'label' => 'Ateliers & projets', 'link' => array('url' => '#'), 'fallback' => array(
            'src' => $theme_uri . '/images/vie-ateliers.jpg', 'alt' => 'Étudiants en atelier de maquette', 'width' => 1600, 'height' => 1224,
        )),
        array('image' => 0, 'label' => 'Évènements', 'link' => array('url' => '#'), 'fallback' => array(
            'src' => $theme_uri . '/images/vie-evenements.jpg', 'alt' => 'Étudiants réunis lors d’un évènement de l’école', 'width' => 1600, 'height' => 1067,
        )),
        array('image' => 0, 'label' => 'Témoignages', 'link' => array('url' => '#'), 'fallback' => array(
            'src' => $theme_uri . '/images/vie-temoignages.jpg', 'alt' => 'Étudiante présentant ses planches de projet', 'width' => 1600, 'height' => 2400,
        )),
        array('image' => 0, 'label' => 'Réalisations', 'link' => array('url' => '#'), 'fallback' => array(
            'src' => $theme_uri . '/images/vie-realisations.jpg', 'alt' => 'Maquette d’architecture réalisée par les étudiants', 'width' => 1600, 'height' => 2400,
        )),
    );
}
?>

<section class="vie-ecole">
    <div class="vie-ecole__grid">
        <div class="vie-ecole__intro">
            <div class="vie-ecole__content">
                <?php if ($kicker) : ?>
                    <p class="vie-ecole__kicker"><?= esc_html($kicker); ?></p>
                <?php endif; ?>
                <h2 class="vie-ecole__title"><?= $title; ?></h2>
                <a <?= acharp_link_attrs($cta); ?> class="btn btn--light">
                    <?= esc_html($cta['title']); ?>
                    <?= acharp_arrow(); ?>
                </a>
            </div>
        </div>

        <?php foreach ($tiles as $tile) : ?>
            <?php $tile_link = acharp_link($tile['link'] ?? array(), '#'); ?>
            <a <?= acharp_link_attrs($tile_link); ?> class="vie-ecole__tile">
                <?= acharp_image_html($tile['image'] ?? 0, 'large', $tile['fallback'] ?? array()); ?>
                <?php if (!empty($tile['label'])) : ?>
                    <span class="vie-ecole__tile-label"><?= esc_html($tile['label']); ?></span>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </div>
</section>
