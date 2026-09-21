<?php
$theme_uri = get_stylesheet_directory_uri();
?>

<section class="hero">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5">
                <div class="hero__content">
                    <p class="hero__kicker">École d’architecture intérieure &amp; design à Paris</p>
                    <h1 class="hero__title">
                        Imaginez les
                        espaces
                        de <strong>demain</strong>
                    </h1>
                    <p class="hero__text">
                        Depuis plus de 60 ans, l’Académie Charpentier forme à Paris les futurs professionnels de l’architecture intérieure et du design.
                    </p>
                    <div class="hero__actions">
                        <a href="#" class="btn btn--primary">
                            Candidater
                            <span class="btn__icon" aria-hidden="true">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 8h10M9.5 4.5 13 8l-3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </a>
                        <a href="#" class="btn btn--outline">
                            Découvrir nos formations
                            <span class="btn__icon" aria-hidden="true">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 8h10M9.5 4.5 13 8l-3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="hero__visual">
                    <div class="hero__media">
                        <img
                            src="<?= esc_url($theme_uri . '/images/hero-atelier.jpg'); ?>"
                            alt="Atelier de l’Académie Charpentier"
                            width="1920"
                            height="1281"
                            class="bg"
                        >
                        <span class="hero__accent" aria-hidden="true"></span>


                        <article class="push-actu">
                            <button type="button" class="push-actu__close" aria-label="Fermer l’actualité">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M1 1l10 10M11 1 1 11" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                                </svg>
                            </button>
                            <a href="#" class="push-actu__link">
                                <span class="push-actu__thumb">
                                    <img
                                        src="<?= esc_url($theme_uri . '/images/push-portes-ouvertes.jpg'); ?>"
                                        alt=""
                                        width="160"
                                        height="160"
                                    >
                                </span>
                                <span class="push-actu__body">
                                    <time class="push-actu__date" datetime="2024-05-24">24 mai 2024</time>
                                    <span class="push-actu__title">Journée porte ouverte</span>
                                    <span class="push-actu__excerpt">Rencontrez nos équipes et découvrez nos formations et nos ateliers.</span>
                                </span>
                            </a>
                        </article>
                    </div>
                
                    
                </div>
            </div>
        </div>
    </div>
</section>
