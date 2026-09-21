<?php
$title = get_field('handicap_title') ?: 'Guide de sensibilisation au handicap';
$text  = acharp_inline_html(get_field('handicap_text'));
$file  = get_field('handicap_file');
$cta   = acharp_link(get_field('handicap_cta'), '', 'Télécharger le guide de sensibilisation au handicap');

if (is_array($file) && !empty($file['url'])) {
    $cta = acharp_link(array(
        'url'    => $file['url'],
        'title'  => $cta['title'] ?: 'Télécharger le guide de sensibilisation au handicap',
        'target' => '_blank',
    ));
}

if (!$cta['url']) {
    $cta = acharp_link(array(), '#', 'Télécharger le guide de sensibilisation au handicap');
}

if (!$text) {
    $text = 'Dans le cadre de sa démarche qualité, l’Académie Charpentier désormais certifiée Qualiopi, est soucieuse de sensibiliser l’ensemble de ses partenaires aux handicaps. Nous souhaitons partager nos connaissances avec vous, étudiants, salariés ou enseignants.';
}
?>

<section class="guide-handicap">
    <div class="container-fluid">
        <div class="guide-handicap__card">
            <h2 class="guide-handicap__title"><?= esc_html($title); ?></h2>

            <?php if ($text) : ?>
                <p class="guide-handicap__text"><?= $text; ?></p>
            <?php endif; ?>

            <a <?= acharp_link_attrs($cta); ?> class="btn btn--primary guide-handicap__cta">
                <?= esc_html($cta['title']); ?>
                <?= acharp_arrow(); ?>
            </a>
        </div>
    </div>
</section>
