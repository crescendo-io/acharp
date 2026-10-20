<?php
$kicker = acharp_field('insertion_kicker') ?: 'Réalités du métier';
$title  = acharp_inline_html(acharp_field('insertion_title'));
$text   = acharp_field('insertion_text');
$logos  = acharp_rows(acharp_field('insertion_logos'));

if (!$title) {
    $title = 'Insertion professionnelle<br> <strong>et conférences</strong>';
}

if (!$text) {
    $text = 'L’Académie Charpentier organise des conférences d’insertion professionnelle avec ses partenaires : le Théâtre de l’Odéon, la SNCF et Matériaux Archi. Des professionnels partagent leur pratique avec les étudiants, toutes années confondues.';
}

if (!$logos) {
    $logos = array(
        array('name' => 'Théâtre de l’Odéon'),
        array('name' => 'SNCF'),
        array('name' => 'ICADE'),
        array('name' => 'Matériaux Archi'),
    );
}
?>

<section id="insertion-professionnelle" class="insertion-pro">
    <div class="container-fluid">
        <header class="insertion-pro__header">
            <p class="insertion-pro__kicker"><?= esc_html($kicker); ?></p>
            <h2 class="insertion-pro__title"><?= $title; ?></h2>
            <?php if ($text) : ?>
                <p class="insertion-pro__text"><?= esc_html($text); ?></p>
            <?php endif; ?>
        </header>

        <ul class="insertion-pro__logos" aria-label="Partenaires insertion professionnelle">
            <?php foreach ($logos as $logo) : ?>
                <li class="insertion-pro__logo">
                    <?php if (!empty($logo['image'])) : ?>
                        <?= acharp_image_html($logo['image'], 'medium'); ?>
                    <?php else : ?>
                        <span><?= esc_html($logo['name'] ?? ''); ?></span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
