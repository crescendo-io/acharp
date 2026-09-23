<?php
$theme_uri = get_stylesheet_directory_uri();
$kicker    = get_field('realisations_kicker') ?: 'Projets étudiants';
$title     = acharp_inline_html(get_field('realisations_title'));
$text      = acharp_inline_html(get_field('realisations_text'));
$items     = acharp_rows(get_field('realisations_items'));

if (!$title) {
    $title = 'Les réalisations de nos <strong>diplômés</strong>';
}

if (!$items) {
    $demo = array(
        'formation-prepa.jpg',
        'histoire-facade.jpg',
        'formation-master.jpg',
        'vie-realisations.jpg',
        'histoire-salon.jpg',
        'vie-ateliers.jpg',
        'formation-bachelor.jpg',
        'hero-atelier.jpg',
        'histoire-escalier.jpg',
        'vie-evenements.jpg',
        'international-paris.jpg',
        'vie-temoignages.jpg',
        'formation-prepa.jpg',
        'vie-realisations.jpg',
        'histoire-salon.jpg',
        'formation-master.jpg',
        'hero-atelier.jpg',
        'vie-ateliers.jpg',
        'histoire-facade.jpg',
        'vie-evenements.jpg',
    );

    foreach ($demo as $file) {
        $items[] = array(
            'image'    => 0,
            'title'    => '',
            'graduate' => '',
            'fallback' => array(
                'src' => $theme_uri . '/images/' . $file,
                'alt' => '',
            ),
        );
    }
}
?>

<section class="realisations">
    <div class="container-fluid">
    
        <div class="realisations__grid">
            <?php foreach ($items as $item) : ?>
                <?php $caption = trim(($item['title'] ?? '') . ($item['graduate'] ?? '')); ?>
                <figure class="realisations__item">
                    <?= acharp_image_html($item['image'] ?? 0, 'large', $item['fallback'] ?? array()); ?>

                    <?php if ($caption) : ?>
                        <figcaption class="realisations__caption">
                            <?php if (!empty($item['title'])) : ?>
                                <span class="realisations__name"><?= esc_html($item['title']); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($item['graduate'])) : ?>
                                <span class="realisations__graduate"><?= esc_html($item['graduate']); ?></span>
                            <?php endif; ?>
                        </figcaption>
                    <?php endif; ?>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>
