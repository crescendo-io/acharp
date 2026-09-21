<?php
$theme_uri = get_stylesheet_directory_uri();
?>

<section class="prepa">
    <div class="container-fluid">
        <div class="prepa__grid">
            <figure class="prepa__media">
                <img
                    src="<?= esc_url($theme_uri . '/images/formation-prepa.jpg'); ?>"
                    alt="Étudiante regardant des planches de projets en année préparatoire"
                    loading="lazy"
                >
            </figure>

            <div class="prepa__content">
                <p class="prepa__kicker">Une année pour se préparer</p>

                <h2 class="prepa__title">
                    Vous souhaitez développer votre
                    créativité <strong>avant de vous lancer ?</strong>
                </h2>

                <p class="prepa__text">
                    L’année préparatoire permet de découvrir les fondamentaux des arts appliqués,
                    d’expérimenter différentes pratiques créatives et de construire progressivement
                    son univers personnel.
                </p>

                <p class="prepa__text">
                    Une année pour explorer, pratiquer et confirmer son orientation avant d’intégrer
                    une formation en architecture intérieure et design.
                </p>

                <a href="#" class="btn btn--primary prepa__cta">
                    Découvrir l’année prépa
                    <span class="btn__icon" aria-hidden="true">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 8h10M9.5 4.5 13 8l-3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>
