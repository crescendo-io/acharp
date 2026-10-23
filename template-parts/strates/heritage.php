<?php
$theme_uri = get_stylesheet_directory_uri();
$heading   = acharp_field('heritage_heading');
$steps     = acharp_rows(acharp_field('heritage_steps'));

if (!$heading) {
    $heading = 'L’Académie Charpentier, école d’architecture intérieure depuis 80 ans';
}

if (!$steps) {
    $steps = array(
        array(
            'date'     => '1945',
            'text'     => 'Au lendemain de la guerre, Irène Charpentier fonde l’Académie Charpentier au cœur de Montparnasse. L’école s’impose rapidement comme une référence des arts appliqués.',
            'image'    => 0,
            'archive'  => true,
            'fallback' => array(
                'src' => $theme_uri . '/images/hero-atelier.jpg',
                'alt' => 'Plaque commémorative et fondation de l’Académie Charpentier',
            ),
        ),
        array(
            'date'     => '1957',
            'text'     => 'La famille Charpentier reprend l’Académie de la Grande Chaumière, haut lieu de la vie artistique parisienne du XX<sup>e</sup> siècle.',
            'image'    => 0,
            'archive'  => true,
            'fallback' => array(
                'src' => $theme_uri . '/images/histoire-escalier.jpg',
                'alt' => 'L’Académie de la Grande Chaumière, Montparnasse',
            ),
        ),
        array(
            'date'     => 'Au fil des décennies',
            'text'     => 'L’école fait évoluer ses enseignements vers l’architecture intérieure. Le dessin, l’observation et le sens des volumes restent au cœur de la formation.',
            'image'    => 0,
            'archive'  => true,
            'fallback' => array(
                'src' => $theme_uri . '/images/vie-ateliers.jpg',
                'alt' => 'Ateliers de l’Académie Charpentier dans les années 1960',
            ),
        ),
        array(
            'date'     => '2025',
            'text'     => 'L’Académie s’installe dans son nouveau campus du XV<sup>e</sup> arrondissement, fidèle à son histoire et tournée vers un avenir durable.',
            'image'    => 0,
            'archive'  => false,
            'fallback' => array(
                'src' => $theme_uri . '/images/histoire-facade.jpg',
                'alt' => 'Nouveau campus de l’Académie Charpentier, 15e arrondissement',
            ),
        ),
    );
} else {
    foreach ($steps as $index => $step) {
        if (empty($step['text']) && !empty($step['texts'])) {
            $parts = array();

            foreach (acharp_rows($step['texts']) as $paragraph) {
                $chunk = trim(strip_tags($paragraph['text'] ?? ''));
                if ($chunk !== '') {
                    $parts[] = $chunk;
                }
            }

            $steps[$index]['text'] = implode(' ', $parts);
        }

        if (empty($step['date']) && !empty($step['title'])) {
            $steps[$index]['date'] = wp_strip_all_tags($step['title']);
        }
    }
}

$layout_mods = array('a', 'b', 'c', 'd');
$logo_marks  = array(
    array('shape' => 'triangle', 'color' => 'pink'),
    array('shape' => 'half-left', 'color' => 'green'),
    array('shape' => 'triangle', 'color' => 'blue'),
    array('shape' => 'half-right', 'color' => 'orange'),
);
?>

<section id="heritage" class="heritage" data-heritage>
    <div class="container-fluid">
        <header class="heritage__header">
            <h2 class="heritage__heading"><?= esc_html($heading); ?></h2>
        </header>

        <div class="heritage__frieze">
            <div class="heritage__rail" aria-hidden="true">
                <span class="heritage__rail-line"></span>
                <span class="heritage__rail-progress" data-heritage-progress style="--heritage-progress: 0;"></span>
            </div>

            <?php foreach ($steps as $index => $step) : ?>
                <?php
                $date    = trim((string) ($step['date'] ?? ''));
                $text    = acharp_inline_html($step['text'] ?? '');
                $is_year = $date !== '' && preg_match('/^\d{4}$/', $date);
                $mod     = $layout_mods[$index % count($layout_mods)];
                $mark    = $logo_marks[$index % count($logo_marks)];
                $speed   = 0.05 + ($index % 4) * 0.025;
                ?>
                <article
                    class="heritage__beat heritage__beat--<?= esc_attr($mod); ?><?= 0 === $index ? ' is-active' : ''; ?>"
                    data-heritage-step="<?= (int) $index; ?>"
                >
                    <span class="heritage__node" aria-hidden="true"></span>

                    <div class="heritage__copy">
                        <?php if ($date !== '') : ?>
                            <p class="heritage__year<?= $is_year ? '' : ' heritage__year--label'; ?>">
                                <span class="heritage__mark heritage__mark--<?= esc_attr($mark['shape']); ?> heritage__mark--<?= esc_attr($mark['color']); ?>" data-heritage-drift data-parallax-speed="<?= esc_attr((string) (0.14 + ($index % 4) * 0.04)); ?>" aria-hidden="true"></span>
                                <?= esc_html($date); ?>
                            </p>
                        <?php endif; ?>
                        <?php if ($text) : ?>
                            <p class="heritage__text"><?= $text; ?></p>
                        <?php endif; ?>
                    </div>

                    <figure
                        class="heritage__frame<?= !empty($step['archive']) ? ' heritage__frame--archive' : ''; ?>"
                        data-heritage-parallax
                        data-parallax-speed="<?= esc_attr((string) $speed); ?>"
                    >
                        <?= acharp_image_html($step['image'] ?? 0, 'large', $step['fallback'] ?? array()); ?>
                    </figure>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
