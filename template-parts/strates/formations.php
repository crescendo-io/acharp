<?php
$theme_uri = get_stylesheet_directory_uri();
$arrow = '<span class="formations__arrow" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 8h10M9.5 4.5 13 8l-3.5 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>';
?>

<section class="formations">
    <div class="container-fluid">
        <div class="formations__header">
            <div class="formations__intro">
                <p class="formations__kicker">Nos formations</p>
                <h2 class="formations__title">
                    Trouvez le parcours<br>
                    qui <strong>vous ressemble</strong>
                </h2>
            </div>
            <a href="#" class="formations__all">
                Voir toutes les formations
                <?= $arrow; ?>
            </a>
        </div>

        <div class="row">
            <div class="col-12 col-lg-4">
                <article class="formations__card">
                    <figure class="formations__media">
                        <img
                            src="<?= esc_url($theme_uri . '/images/formation-prepa.jpg'); ?>"
                            alt="Travail de maquette en classe préparatoire"
                            width="1600"
                            height="1067"
                        >
                    </figure>
                    <div class="formations__body">
                        <h3 class="formations__name">Classe préparatoire</h3>
                        <p class="formations__meta">post-bac — 1 ou 2 ans</p>
                        <p class="formations__text">
                            Se préparer aux études supérieures en architecture intérieure, design et métiers de l’espace.
                        </p>
                        <a href="#" class="formations__link">
                            Découvrir nos formations
                            <?= $arrow; ?>
                        </a>
                    </div>
                </article>
            </div>

            <div class="col-12 col-lg-4">
                <article class="formations__card">
                    <figure class="formations__media">
                        <img
                            src="<?= esc_url($theme_uri . '/images/formation-bachelor.jpg'); ?>"
                            alt="Étudiants autour d’une maquette d’architecture"
                            width="1600"
                            height="1067"
                        >
                    </figure>
                    <div class="formations__body">
                        <h3 class="formations__name">Bachelor</h3>
                        <p class="formations__meta">post-bac — 3 ans</p>
                        <p class="formations__text">
                            Acquérir les fondamentaux du design et de l’architecture intérieure par la pratique et les projets.
                        </p>
                        <a href="#" class="formations__link">
                            Découvrir nos formations
                            <?= $arrow; ?>
                        </a>
                    </div>
                </article>
            </div>

            <div class="col-12 col-lg-4">
                <article class="formations__card">
                    <figure class="formations__media">
                        <img
                            src="<?= esc_url($theme_uri . '/images/formation-master.jpg'); ?>"
                            alt="Maquette architecturale éclairée"
                            width="1600"
                            height="1067"
                        >
                    </figure>
                    <div class="formations__body">
                        <h3 class="formations__name">Master</h3>
                        <p class="formations__meta">bac+3 — 2 ans</p>
                        <p class="formations__text">
                            Se spécialiser et développer une expertise pour concevoir des projets complexes.
                        </p>
                        <a href="#" class="formations__link">
                            Découvrir nos formations
                            <?= $arrow; ?>
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
