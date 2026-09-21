<?php
$intro = get_field('chiffres_intro');
$items = acharp_rows(get_field('chiffres_items'));

if (!$intro) {
    $intro = "Une école<br>à taille humaine";
} else {
    $intro = wp_kses($intro, array('br' => array()));
}

if (!$items) {
    $items = array(
        array('value' => '+60', 'label' => 'ans d’expérience', 'shape' => 'triangle', 'color' => 'pink'),
        array('value' => '≈60', 'label' => 'étudiants accueillis chaque année', 'shape' => 'half', 'color' => 'green'),
        array('value' => '6', 'label' => 'formations diplômantes du post-bac au bac+5', 'shape' => 'triangle', 'color' => 'blue'),
        array('value' => '92%', 'label' => 'taux d’insertion à 6 mois *', 'shape' => 'three-quarter', 'color' => 'orange'),
    );
}
?>

<section class="chiffres-cles">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-12 col-lg">
                <p class="chiffres-cles__intro"><?= $intro; ?></p>
            </div>

            <?php foreach ($items as $item) : ?>
                <?php
                $shape = $item['shape'] ?? 'triangle';
                $color = $item['color'] ?? 'pink';
                ?>
                <div class="col-12 col-lg">
                    <article class="chiffres-cles__item">
                        <span class="chiffres-cles__shape chiffres-cles__shape--<?= esc_attr($shape); ?> chiffres-cles__shape--<?= esc_attr($color); ?>" aria-hidden="true"></span>
                        <p class="chiffres-cles__text">
                            <strong><?= esc_html($item['value'] ?? ''); ?></strong>
                            <?= esc_html($item['label'] ?? ''); ?>
                        </p>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
