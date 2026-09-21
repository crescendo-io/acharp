<?php
$theme_uri = get_stylesheet_directory_uri();
?>

<section class="histoire">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-7 histoire__mosaic-col">
                <div class="histoire__mosaic">
                    <figure class="histoire__mosaic-item histoire__mosaic-item--main">
                        <img
                            src="<?= esc_url($theme_uri . '/images/histoire-facade.jpg'); ?>"
                            alt="Façade de l’Académie Charpentier"
                            width="1600"
                            height="2845"
                        >
                    </figure>
                    <figure class="histoire__mosaic-item histoire__mosaic-item--salon">
                        <img
                            src="<?= esc_url($theme_uri . '/images/histoire-salon.jpg'); ?>"
                            alt="Espace de vie de l’école"
                            width="1600"
                            height="2400"
                        >
                    </figure>
                    <figure class="histoire__mosaic-item histoire__mosaic-item--escalier">
                        <img
                            src="<?= esc_url($theme_uri . '/images/histoire-escalier.jpg'); ?>"
                            alt="Escalier intérieur de l’école"
                            width="1600"
                            height="1067"
                        >
                    </figure>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="histoire__content">
                    <p class="histoire__kicker">L’Académie Charpentier</p>
                    <h2 class="histoire__title">
                        Une histoire, une école,<br>
                        une <strong>vision</strong>
                    </h2>
                    <p class="histoire__text">
                        Fondée il y a plus de 60 ans, l’Académie Charpentier est installée au cœur du 15<sup>e</sup> arrondissement de Paris. Notre école à taille humaine place l’étudiant au centre de son projet pédagogique, avec une approche concrète, créative et professionnalisante.
                    </p>
                    <a href="#" class="btn btn--primary">
                        Découvrir l’académie
                        <span class="btn__icon" aria-hidden="true">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 8h10M9.5 4.5 13 8l-3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
