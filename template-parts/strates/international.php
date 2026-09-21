<?php
$theme_uri = get_stylesheet_directory_uri();
?>

<section class="international">
    <div class="international__grid">
        <figure class="international__media">
            <img
                src="<?= esc_url($theme_uri . '/images/international-paris.jpg'); ?>"
                alt="Vue sur les toits de Paris et la tour Eiffel"
                width="1900"
                height="1267"
            >
        </figure>

        <div class="international__content">
            <p class="international__kicker">International</p>
            <h2 class="international__title">
                Étudier à&nbsp;<strong>Paris</strong>
            </h2>
            <p class="international__text">
                Nous accueillons des étudiants internationaux dans les mêmes formations que les étudiants français. Niveau de français B2 requis.
            </p>
            <a href="#" class="btn btn--primary">
                En savoir plus
                <span class="btn__icon" aria-hidden="true">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 8h10M9.5 4.5 13 8l-3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </a>
        </div>
    </div>
</section>
