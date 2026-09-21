<?php
$theme_uri = get_stylesheet_directory_uri();
$kicker    = get_field('eco_kicker') ?: 'Éco-transition';
$title     = acharp_inline_html(get_field('eco_title'));
$text      = acharp_inline_html(get_field('eco_text'));
$piliers   = acharp_rows(get_field('eco_piliers'));
$banner    = acharp_inline_html(get_field('eco_banner_text'));
$cta       = acharp_link(get_field('eco_banner_cta'), '#', 'Candidater');
$leaf      = acharp_icon('leaf', 'eco');

if (!$title) {
    $title = 'Former des designers<br> <strong>conscients des enjeux de demain</strong>';
}

if (!$text) {
    $text = 'À l’Académie Charpentier, la conscience écologique fait partie intégrante de l’apprentissage. Dès la première année, les étudiants abordent l’éco-responsabilité appliquée à l’architecture intérieure et au design d’espace : choix des matériaux, économie des ressources, usages et impact environnemental.';
}

if (!$piliers) {
    $piliers = array(
        array(
            'icon'  => 'leaf',
            'title' => 'Apprendre à<br>concevoir autrement',
            'text'  => 'Tout au long du cursus, la pédagogie encourage les projets durables, les approches éthiques et la conception raisonnée. L’analyse du contexte, l’impact environnemental et social font partie intégrante du processus créatif.',
        ),
        array(
            'icon'  => 'people',
            'title' => 'Être accompagné par<br>des professionnels engagés',
            'text'  => 'Les enseignants et professionnels transmettent, au-delà des compétences techniques, une vision contemporaine et responsable du métier afin de préparer les étudiants à concevoir des espaces fonctionnels, esthétiques et durables.',
        ),
        array(
            'icon'  => 'globe',
            'title' => 'Une compétence pour<br>votre avenir professionnel',
            'text'  => 'Cette approche permet aux futurs designers d’intégrer espace, environnement et usages dans leur réflexion et de concevoir des projets répondant aux enjeux sociaux, écologiques et économiques actuels.',
        ),
    );
}

if (!$banner) {
    $banner = '<strong>Des projets plus durables.</strong> Des espaces meilleurs pour demain.';
}
?>

<section class="eco">
    <div class="container-fluid">
        <div class="eco__content">
            <?php if ($kicker) : ?>
                <p class="eco__kicker"><?= esc_html($kicker); ?></p>
            <?php endif; ?>

            <h2 class="eco__title"><?= $title; ?></h2>

            <?php if ($text) : ?>
                <p class="eco__text"><?= $text; ?></p>
            <?php endif; ?>

            <div class="row eco__piliers">
                <?php foreach ($piliers as $pilier) : ?>
                    <div class="col-12 col-lg-4">
                        <article class="eco__pilier">
                            <span class="eco__pilier-icon" aria-hidden="true"><?= acharp_icon($pilier['icon'] ?? 'leaf', 'eco'); ?></span>
                            <h3 class="eco__pilier-title"><?= acharp_inline_html($pilier['title'] ?? ''); ?></h3>
                            <?php if (!empty($pilier['text'])) : ?>
                                <p class="eco__pilier-text"><?= esc_html($pilier['text']); ?></p>
                            <?php endif; ?>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="eco__banner">
                <span class="eco__banner-icon" aria-hidden="true"><?= $leaf; ?></span>

                <p class="eco__banner-text"><?= $banner; ?></p>

                <a <?= acharp_link_attrs($cta); ?> class="btn btn--primary eco__banner-cta">
                    <?= esc_html($cta['title']); ?>
                    <?= acharp_arrow(); ?>
                </a>
            </div>
        </div>
    </div>

    <figure class="eco__media">
        <?= acharp_image_html(get_field('eco_image'), 'large', array(
            'src'    => $theme_uri . '/images/vie-ateliers.jpg',
            'alt'    => 'Étudiante travaillant sur une planche de matériaux en atelier',
            'width'  => 1024,
            'height' => 768,
        )); ?>
    </figure>
</section>
