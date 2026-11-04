<?php
$post_id = get_queried_object_id();

if (!is_singular('cursus') || acharp_cursus_catalog_rank($post_id) !== 2) {
    return;
}

$kicker = acharp_field('cursus_alt_kicker') ?: '5ᵉ année';
$title  = acharp_inline_html(acharp_field('cursus_alt_title'));
$text   = acharp_field('cursus_alt_text');
$page   = get_page_by_path('alternance');
$cta    = acharp_link(
    acharp_field('cursus_alt_link'),
    $page ? get_permalink($page) : home_url('/alternance/'),
    'Découvrir l’alternance'
);

if (!$title) {
    $title = 'Préparer le même diplôme <strong>en alternance</strong>';
}

if (!is_string($text) || trim($text) === '') {
    $text = 'En 5ᵉ année, le contrat de professionnalisation permet de suivre la formation en entreprise, avec un statut salarié. Les frais de scolarité sont financés par l’employeur, et le diplôme délivré reste le Titre RNCP 38011, niveau 7.';
}

$facts = array();

foreach (acharp_rows(acharp_field('cursus_alt_facts')) as $row) {
    $value = trim((string) ($row['value'] ?? ''));
    $label = trim((string) ($row['label'] ?? ''));

    if ($value !== '' || $label !== '') {
        $facts[] = array('value' => $value, 'label' => $label);
    }
}

if (!$facts) {
    $facts = array(
        array('value' => '1 an', 'label' => 'Uniquement en 5ᵉ année'),
        array('value' => 'Pris en charge', 'label' => 'Frais financés par l’employeur'),
        array('value' => 'Rémunéré', 'label' => 'Un salaire pendant le contrat'),
    );
}
?>

<section id="cursus-alternance" class="cursus-alternance">
    <div class="container-fluid">
        <div class="cursus-alternance__panel">
            <div class="cursus-alternance__copy">
                <?php if ($kicker) : ?>
                    <p class="cursus-alternance__kicker"><?= esc_html($kicker); ?></p>
                <?php endif; ?>
                <h2 class="cursus-alternance__title"><?= $title; ?></h2>
                <p><?= esc_html(trim($text)); ?></p>
                <?php if ($cta['url']) : ?>
                    <a <?= acharp_link_attrs($cta); ?> class="btn btn--primary">
                        <?= esc_html($cta['title']); ?>
                        <?= acharp_arrow(); ?>
                    </a>
                <?php endif; ?>
            </div>
            <ul class="cursus-alternance__facts">
                <?php foreach ($facts as $fact) : ?>
                    <li>
                        <strong><?= esc_html($fact['value']); ?></strong>
                        <span><?= esc_html($fact['label']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>
