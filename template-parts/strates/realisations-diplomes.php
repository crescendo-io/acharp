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
    
        <div class="realisations__grid">
            <?php foreach ($items as $item) : ?>
                <?php
                $prenom    = trim((string) ($item['prenom'] ?? ''));
                $nom       = trim((string) ($item['nom'] ?? ''));
                $person    = trim($prenom . ' ' . $nom);
                $linkedin  = trim((string) ($item['linkedin'] ?? ''));
                $project   = trim((string) ($item['title'] ?? ''));
                $graduate  = trim((string) ($item['graduate'] ?? ''));
                $caption   = $project !== '' || $graduate !== '' || $person !== '' || $linkedin !== '';
                $image_id  = is_array($item['image'] ?? null) ? (int) ($item['image']['ID'] ?? 0) : (int) ($item['image'] ?? 0);
                $full      = $image_id ? (string) wp_get_attachment_image_url($image_id, 'full') : (string) ($item['fallback']['src'] ?? '');
                $alt       = $image_id ? (string) get_post_meta($image_id, '_wp_attachment_image_alt', true) : (string) ($item['fallback']['alt'] ?? '');
                if ($alt === '') {
                    $alt = $project !== '' ? $project : $person;
                }
                $zoom_label = 'Agrandir la réalisation';
                if ($project !== '') {
                    $zoom_label = 'Agrandir ' . $project;
                } elseif ($person !== '') {
                    $zoom_label = 'Agrandir la réalisation de ' . $person;
                }
                ?>
                <figure
                    class="realisations__item"
                    <?php if ($full !== '') : ?>
                        data-full="<?= esc_url($full); ?>"
                        data-alt="<?= esc_attr($alt); ?>"
                        data-title="<?= esc_attr($project); ?>"
                        data-person="<?= esc_attr($person); ?>"
                        data-graduate="<?= esc_attr($graduate); ?>"
                        data-linkedin="<?= esc_url($linkedin); ?>"
                    <?php endif; ?>
                >
                    <?php if ($full !== '') : ?>
                        <button type="button" class="realisations__zoom" data-realisation-open aria-label="<?= esc_attr($zoom_label); ?>">
                            <?= acharp_image_html($item['image'] ?? 0, 'large', $item['fallback'] ?? array()); ?>
                        </button>
                    <?php else : ?>
                        <?= acharp_image_html($item['image'] ?? 0, 'large', $item['fallback'] ?? array()); ?>
                    <?php endif; ?>

                    <?php if ($caption) : ?>
                        <figcaption class="realisations__caption">
                            <?php if ($project !== '') : ?>
                                <span class="realisations__name"><?= esc_html($project); ?></span>
                            <?php endif; ?>
                            <?php if ($person !== '' || $linkedin !== '') : ?>
                                <span class="realisations__author">
                                    <?php if ($person !== '') : ?>
                                        <span class="realisations__person"><?= esc_html($person); ?></span>
                                    <?php endif; ?>
                                    <?php if ($linkedin !== '') : ?>
                                        <a class="realisations__linkedin" href="<?= esc_url($linkedin); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= esc_attr($person !== '' ? 'Profil LinkedIn de ' . $person : 'Profil LinkedIn'); ?>">
                                            <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                                <path fill="currentColor" d="M20.45 20.45h-3.55v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.41v1.56h.05c.47-.9 1.63-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.06 2.06 0 1 1 0-4.12 2.06 2.06 0 0 1 0 4.12zM7.12 20.45H3.56V9h3.56v11.45zM22.23 0H1.77C.79 0 0 .77 0 1.73v20.54C0 23.23.79 24 1.77 24h20.46c.98 0 1.77-.77 1.77-1.73V1.73C24 .77 23.21 0 22.23 0z"/>
                                            </svg>
                                        </a>
                                    <?php endif; ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($graduate !== '') : ?>
                                <span class="realisations__graduate"><?= esc_html($graduate); ?></span>
                            <?php endif; ?>
                        </figcaption>
                    <?php endif; ?>
                </figure>
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
