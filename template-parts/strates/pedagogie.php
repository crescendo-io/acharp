<?php
$kicker = get_field('pedagogie_kicker') ?: 'Notre pédagogie';
$title  = acharp_inline_html(get_field('pedagogie_title'));
$text   = acharp_inline_html(get_field('pedagogie_text'));
$cta    = acharp_link(get_field('pedagogie_cta'), '#', 'Candidater');

if (!$title) {
    $title = 'Une pédagogie à<br> <strong>taille humaine</strong> et tournée vers l’avenir';
}

if (!$text) {
    $text = 'Depuis sa création, l’Académie Charpentier a su conserver sa taille humaine et valoriser le potentiel artistique de chaque étudiant à travers une pédagogie innovante et singulière. S’appuyant sur un corps professoral hautement qualifié, elle revendique une expertise pédagogique incontestable, tout en formant ses étudiants aux enjeux écologiques et sociétaux contemporains.';
}
?>

<section class="pedagogie">
    <span class="pedagogie__shape pedagogie__shape--triangle" aria-hidden="true"></span>
    <span class="pedagogie__shape pedagogie__shape--circle" aria-hidden="true"></span>

    <div class="pedagogie__inner">
        <?php if ($kicker) : ?>
            <p class="pedagogie__kicker"><?= esc_html($kicker); ?></p>
        <?php endif; ?>

        <h2 class="pedagogie__title"><?= $title; ?></h2>

        <?php if ($text) : ?>
            <p class="pedagogie__text"><?= $text; ?></p>
        <?php endif; ?>

        <a <?= acharp_link_attrs($cta); ?> class="btn btn--primary pedagogie__cta">
            <?= esc_html($cta['title']); ?>
            <?= acharp_arrow(); ?>
        </a>
    </div>
</section>
