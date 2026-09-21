<?php
$theme_uri = get_stylesheet_directory_uri();

$leaf = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 19c0-7 4.6-11.5 14-12 .5 6.6-2.6 13-10 13a5.4 5.4 0 0 1-4-1Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/><path d="M5 19c1.4-3.8 4.2-7 8.4-9.2" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>';

$piliers = array(
    array(
        'icon'  => $leaf,
        'title' => 'Apprendre à<br>concevoir autrement',
        'text'  => 'Tout au long du cursus, la pédagogie encourage les projets durables, les approches éthiques et la conception raisonnée. L’analyse du contexte, l’impact environnemental et social font partie intégrante du processus créatif.',
    ),
    array(
        'icon'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="8.4" r="2.8" stroke="currentColor" stroke-width="1.4"/><path d="M7.2 18c0-2.6 2.1-4.4 4.8-4.4s4.8 1.8 4.8 4.4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/><circle cx="4.9" cy="10" r="2" stroke="currentColor" stroke-width="1.4"/><circle cx="19.1" cy="10" r="2" stroke="currentColor" stroke-width="1.4"/><path d="M2 17c0-2 1.3-3.4 3.2-3.4M22 17c0-2-1.3-3.4-3.2-3.4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>',
        'title' => 'Être accompagné par<br>des professionnels engagés',
        'text'  => 'Les enseignants et professionnels transmettent, au-delà des compétences techniques, une vision contemporaine et responsable du métier afin de préparer les étudiants à concevoir des espaces fonctionnels, esthétiques et durables.',
    ),
    array(
        'icon'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="8.4" stroke="currentColor" stroke-width="1.4"/><path d="M3.6 12h16.8M12 3.6c2.2 2.3 3.4 5.2 3.4 8.4 0 3.2-1.2 6.1-3.4 8.4-2.2-2.3-3.4-5.2-3.4-8.4 0-3.2 1.2-6.1 3.4-8.4Z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/></svg>',
        'title' => 'Une compétence pour<br>votre avenir professionnel',
        'text'  => 'Cette approche permet aux futurs designers d’intégrer espace, environnement et usages dans leur réflexion et de concevoir des projets répondant aux enjeux sociaux, écologiques et économiques actuels.',
    ),
);
?>

<section class="eco">
    <div class="container-fluid">
        <div class="eco__content">
            <p class="eco__kicker">Éco-transition</p>

            <h2 class="eco__title">
                Former des designers<br>
                <strong>conscients des enjeux de demain</strong>
            </h2>

            <p class="eco__text">
                À l’Académie Charpentier, la conscience écologique fait partie intégrante de
                l’apprentissage. Dès la première année, les étudiants abordent l’éco-responsabilité
                appliquée à l’architecture intérieure et au design d’espace : choix des matériaux,
                économie des ressources, usages et impact environnemental.
            </p>

            <div class="row eco__piliers">
                <?php foreach ($piliers as $pilier) : ?>
                    <div class="col-12 col-lg-4">
                        <article class="eco__pilier">
                            <span class="eco__pilier-icon" aria-hidden="true"><?= $pilier['icon']; ?></span>
                            <h3 class="eco__pilier-title"><?= $pilier['title']; ?></h3>
                            <p class="eco__pilier-text"><?= $pilier['text']; ?></p>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="eco__banner">
                <span class="eco__banner-icon" aria-hidden="true"><?= $leaf; ?></span>

                <p class="eco__banner-text">
                    <strong>Des projets plus durables.</strong>
                    Des espaces meilleurs pour demain.
                </p>

                <a href="#" class="btn btn--primary eco__banner-cta">
                    Candidater
                    <span class="btn__icon" aria-hidden="true">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 8h10M9.5 4.5 13 8l-3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </div>

    <figure class="eco__media">
        <img
            src="<?= esc_url($theme_uri . '/images/vie-ateliers.jpg'); ?>"
            alt="Étudiante travaillant sur une planche de matériaux en atelier"
            width="1024"
            height="768"
            loading="lazy"
        >
    </figure>
</section>
