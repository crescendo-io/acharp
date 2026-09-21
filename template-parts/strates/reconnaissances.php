<?php
$theme_uri = get_stylesheet_directory_uri();

$logos = array(
    array(
        'file'   => '/images/logo-qualiopi.png',
        'alt'    => 'Qualiopi, processus certifié',
        'width'  => 92,
        'height' => 40,
    ),
    array(
        'file'   => '/images/logo-france-competences.png',
        'alt'    => 'France compétences',
        'width'  => 119,
        'height' => 36,
    ),
    array(
        'file'   => '/images/logo-ministere-culture.png',
        'alt'    => 'Ministère de la Culture',
        'width'  => 85,
        'height' => 62,
    ),
    array(
        'file'   => '/images/logo-diplomes-reconnus.png',
        'alt'    => 'Diplômes reconnus par l’État',
        'width'  => 58,
        'height' => 67,
    ),
    array(
        'file'   => '/images/logo-campus-france.png',
        'alt'    => 'Campus France, établissement membre',
        'width'  => 109,
        'height' => 41,
    ),
);
?>

<section class="reconnaissances" aria-labelledby="reconnaissances-title">
    <div class="reconnaissances__line" aria-hidden="true"></div>
    <h2 id="reconnaissances-title" class="reconnaissances__title">
        Reconnaissances &amp; accréditations
    </h2>

    <ul class="reconnaissances__logos">
        <?php foreach ($logos as $logo) : ?>
            <li class="reconnaissances__logo">
                <img
                    src="<?= esc_url($theme_uri . $logo['file']); ?>"
                    alt="<?= esc_attr($logo['alt']); ?>"
                    width="<?= esc_attr($logo['width']); ?>"
                    height="<?= esc_attr($logo['height']); ?>"
                >
            </li>
        <?php endforeach; ?>
    </ul>

    <span class="reconnaissances__accent reconnaissances__accent--orange" aria-hidden="true"></span>
    <span class="reconnaissances__accent reconnaissances__accent--green" aria-hidden="true"></span>
</section>
