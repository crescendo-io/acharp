<?php
$theme_uri = get_stylesheet_directory_uri();
?>

<section class="formation-intro">
    <div class="container-fluid">
        <div class="formation-intro__grid">
            <figure class="formation-intro__media">
                <img
                    src="<?= esc_url($theme_uri . '/images/vie-evenements.jpg'); ?>"
                    alt="Visite d’atelier commentée par une étudiante de l’Académie Charpentier"
                    loading="lazy"
                >
            </figure>

            <div class="formation-intro__content">
                <p class="formation-intro__kicker">La formation</p>

                <h2 class="formation-intro__title">
                    Une formation <strong>créative</strong> et<br>
                    <strong>opérationnelle</strong>
                </h2>

                <p class="formation-intro__text">
                    Axé sur l’architecture intérieure et le design, le Bachelor forme des professionnels
                    créatifs et opérationnels, prêts à exercer la fonction de collaborateur ou d’assistant
                    en architecture intérieure et design.
                </p>

                <p class="formation-intro__text">
                    À travers une approche concrète et responsable, cette formation développe les
                    compétences nécessaires pour concevoir, transformer et valoriser les environnements
                    intérieurs avec sens, méthode et responsabilité.
                </p>

                <a href="#" class="btn btn--outline formation-intro__cta">
                    Télécharger la brochure
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
