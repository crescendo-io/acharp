<?php
if (!get_field('anchors_enable')) {
    return;
}

$items = array();

foreach (acharp_rows(get_field('anchors_items')) as $row) {
    $label  = trim($row['label'] ?? '');
    $target = trim($row['target'] ?? '');
    $target = ltrim($target, '#');

    if (!$label || !$target) {
        continue;
    }

    $items[] = array(
        'label' => $label,
        'id'    => $target,
    );
}

if (!$items) {
    return;
}
?>

<nav class="ancres" aria-label="Sommaire de la page">
    <div class="ancres__inner">
        <ul class="ancres__list">
            <?php foreach ($items as $index => $item) : ?>
                <li>
                    <a
                        href="#<?= esc_attr($item['id']); ?>"
                        class="ancres__link<?= $index === 0 ? ' is-active' : ''; ?>"
                        data-ancre="<?= esc_attr($item['id']); ?>"
                    >
                        <?= esc_html($item['label']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>
