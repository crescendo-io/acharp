<?php
$kicker   = acharp_field('alumni_kicker') ?: 'Alumni';
$title    = acharp_inline_html(acharp_field('alumni_title'));
$profiles = acharp_get_alumni_profiles(6);
$projects = acharp_get_diploma_projects(12);

if (!$title) {
    $title = 'Nos anciens élèves<br> <strong>et leurs projets</strong>';
}
?>

<section id="alumni" class="alumni-showcase">
    <div class="container-fluid">
        <header class="alumni-showcase__header">
            <p class="alumni-showcase__kicker"><?= esc_html($kicker); ?></p>
            <h2 class="alumni-showcase__title"><?= $title; ?></h2>
            <p class="alumni-showcase__intro">La page Alumni peut être enrichie au fil du temps depuis le back-office (profils Alumni et projets de la promotion).</p>
        </header>

        <?php if ($profiles) : ?>
            <ul class="alumni-showcase__profiles">
                <?php foreach ($profiles as $profile) : ?>
                    <li class="alumni-showcase__profile">
                        <figure><?= get_the_post_thumbnail($profile, 'medium'); ?></figure>
                        <h3><?= esc_html(get_the_title($profile)); ?></h3>
                        <?php if (has_excerpt($profile)) : ?>
                            <p><?= esc_html(get_the_excerpt($profile)); ?></p>
                        <?php endif; ?>
                        <?php $linkedin = get_field('alumni_linkedin', $profile->ID); ?>
                        <?php if ($linkedin) : ?>
                            <a href="<?= esc_url($linkedin); ?>" target="_blank" rel="noopener">LinkedIn</a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if ($projects) : ?>
            <div class="alumni-showcase__projects">
                <?php foreach ($projects as $project) : ?>
                    <figure class="alumni-showcase__project">
                        <?= get_the_post_thumbnail($project, 'large'); ?>
                        <figcaption><?= esc_html(get_the_title($project)); ?></figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
