<?php
$theme_uri = get_stylesheet_directory_uri();
$kicker    = acharp_field('realisations_kicker') ?: 'Projets étudiants';
$title     = acharp_inline_html(acharp_field('realisations_title'));
$text      = acharp_inline_html(acharp_field('realisations_text'));
$items     = acharp_rows(acharp_field('realisations_items'));

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

<section id="realisations" class="realisations">
    <div class="container-fluid">
    
        <div class="realisations__students">
            <?php foreach ($items as $index => $item) : ?>
                <?php
                $prenom   = trim((string) ($item['prenom'] ?? ''));
                $nom      = trim((string) ($item['nom'] ?? ''));
                $person   = trim($prenom . ' ' . $nom);
                $linkedin = trim((string) ($item['linkedin'] ?? ''));
                $graduate = trim((string) ($item['graduate'] ?? ''));
                $slides     = array();
                $raw_images = $item['images'] ?? array();

                if (!is_array($raw_images)) {
                    $raw_images = $raw_images ? array($raw_images) : array();
                }

                if (!$raw_images && empty($item['fallback']['src'])) {
                    $legacy_id = (int) get_post_meta(get_queried_object_id(), 'realisations_items_' . $index . '_image', true);
                    if ($legacy_id) {
                        $raw_images = array($legacy_id);
                    }
                }

                if (!$raw_images && !empty($item['fallback']['src'])) {
                    $slides[] = array(
                        'id'  => 0,
                        'src' => $item['fallback']['src'],
                        'alt' => (string) ($item['fallback']['alt'] ?? $person),
                    );
                }

                foreach ($raw_images as $image) {
                    $image_id = is_array($image) ? (int) ($image['ID'] ?? $image['id'] ?? 0) : (int) $image;
                    $src      = $image_id ? (string) wp_get_attachment_image_url($image_id, 'full') : '';

                    if ($src === '') {
                        continue;
                    }

                    $alt = (string) get_post_meta($image_id, '_wp_attachment_image_alt', true);
                    if ($alt === '') {
                        $alt = $person;
                    }

                    $slides[] = array(
                        'id'  => $image_id,
                        'src' => $src,
                        'alt' => $alt,
                    );
                }

                if (!$slides) {
                    continue;
                }

                $zoom_label = $person !== '' ? 'Agrandir la réalisation de ' . $person : 'Agrandir la réalisation';
                $payload = array_map(static function ($slide) {
                    return array(
                        'src' => $slide['src'],
                        'alt' => $slide['alt'],
                    );
                }, $slides);
                $linkedin_icon = '<svg width="22" height="22" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path fill="currentColor" d="M20.45 20.45h-3.55v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.41v1.56h.05c.47-.9 1.63-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12zM7.12 20.45H3.56V9h3.56v11.45zM22.23 0H1.77C.79 0 0 .77 0 1.73v20.54C0 23.23.79 24 1.77 24h20.46c.98 0 1.77-.77 1.77-1.73V1.73C24 .77 23.21 0 22.23 0z"/></svg>';
                ?>
                <article
                    class="realisations__student"
                    data-images="<?= esc_attr(wp_json_encode($payload)); ?>"
                    data-person="<?= esc_attr($person); ?>"
                    data-graduate="<?= esc_attr($graduate); ?>"
                    data-linkedin="<?= esc_url($linkedin); ?>"
                >
                    <?php if ($person !== '' || $linkedin !== '' || $graduate !== '') : ?>
                        <header class="realisations__student-header">
                            <div class="realisations__identity">
                                <?php if ($person !== '') : ?>
                                    <h2 class="realisations__student-name"><?= esc_html($person); ?></h2>
                                <?php endif; ?>
                                <?php if ($linkedin !== '') : ?>
                                    <a class="realisations__linkedin" href="<?= esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= esc_attr($person !== '' ? 'Profil LinkedIn de ' . $person : 'Profil LinkedIn'); ?>">
                                        <?= $linkedin_icon; ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <?php if ($graduate !== '') : ?>
                                <p class="realisations__graduate"><?= esc_html($graduate); ?></p>
                            <?php endif; ?>
                        </header>
                    <?php endif; ?>

                    <div class="realisations__grid">
                        <?php foreach ($slides as $slide_index => $slide) : ?>
                            <figure class="realisations__item">
                                <button type="button" class="realisations__zoom" data-realisation-open data-index="<?= (int) $slide_index; ?>" aria-label="<?= esc_attr($zoom_label); ?>">
                                    <?php if ($slide['id']) : ?>
                                        <?= acharp_image_html($slide['id'], 'large'); ?>
                                    <?php else : ?>
                                        <?= acharp_image_html(0, 'large', array('src' => $slide['src'], 'alt' => $slide['alt'])); ?>
                                    <?php endif; ?>
                                </button>
                            </figure>
                        <?php endforeach; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="realisation-popin" id="realisation-popin" hidden>
        <div class="realisation-popin__backdrop" data-realisation-close tabindex="-1"></div>
        <div class="realisation-popin__dialog" role="dialog" aria-modal="true" aria-labelledby="realisation-popin-title">
            <button type="button" class="realisation-popin__close" data-realisation-close aria-label="Fermer">
                <span aria-hidden="true">&times;</span>
            </button>
            <button type="button" class="realisation-popin__nav realisation-popin__nav--prev" data-realisation-prev aria-label="Réalisation précédente">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="m10 4-4 4 4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <button type="button" class="realisation-popin__nav realisation-popin__nav--next" data-realisation-next aria-label="Réalisation suivante">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="m6 4 4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <figure class="realisation-popin__figure">
                <img class="realisation-popin__img" alt="">
                <figcaption class="realisation-popin__caption">
                    <span class="realisation-popin__title" id="realisation-popin-title"></span>
                    <span class="realisation-popin__author">
                        <span class="realisation-popin__person"></span>
                        <a class="realisation-popin__linkedin" href="#" target="_blank" rel="noopener noreferrer">
                            <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path fill="currentColor" d="M20.45 20.45h-3.55v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.41v1.56h.05c.47-.9 1.63-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12zM7.12 20.45H3.56V9h3.56v11.45zM22.23 0H1.77C.79 0 0 .77 0 1.73v20.54C0 23.23.79 24 1.77 24h20.46c.98 0 1.77-.77 1.77-1.73V1.73C24 .77 23.21 0 22.23 0z"/>
                            </svg>
                        </a>
                    </span>
                    <span class="realisation-popin__graduate"></span>
                </figcaption>
            </figure>
        </div>
    </div>
</section>
