<?php

defined('ABSPATH') || exit;

function acharp_register_content_cpts() {
    register_post_type('alumni', array(
        'labels' => array(
            'name'          => 'Alumni',
            'singular_name' => 'Alumni',
            'menu_name'     => 'Alumni',
            'add_new_item'  => 'Ajouter un profil',
            'edit_item'     => 'Modifier le profil',
        ),
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-groups',
        'supports'           => array('title', 'editor', 'thumbnail', 'revisions'),
        'has_archive'        => false,
        'show_in_rest'       => true,
        'capability_type'    => 'post',
    ));

    register_post_type('projet_diplome', array(
        'labels' => array(
            'name'          => 'Projets diplômés',
            'singular_name' => 'Projet diplômé',
            'menu_name'     => 'Projets diplômés',
            'add_new_item'  => 'Ajouter un projet',
            'edit_item'     => 'Modifier le projet',
        ),
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => array('title', 'editor', 'thumbnail', 'revisions'),
        'has_archive'        => false,
        'show_in_rest'       => true,
        'capability_type'    => 'post',
    ));

    register_post_type('enseignant', array(
        'labels' => array(
            'name'          => 'Équipe pédagogique',
            'singular_name' => 'Enseignant',
            'menu_name'     => 'Équipe pédagogique',
            'add_new_item'  => 'Ajouter un enseignant',
            'edit_item'     => 'Modifier l’enseignant',
        ),
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-welcome-learn-more',
        'supports'           => array('title', 'editor', 'thumbnail', 'revisions', 'page-attributes'),
        'has_archive'        => false,
        'show_in_rest'       => true,
        'capability_type'    => 'post',
    ));
}
add_action('init', 'acharp_register_content_cpts');

function acharp_get_alumni_profiles($limit = 0) {
    $args = array(
        'post_type'      => 'alumni',
        'post_status'    => 'publish',
        'posts_per_page' => $limit ?: -1,
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
    );

    return get_posts($args);
}

function acharp_get_diploma_projects($limit = 0) {
    $args = array(
        'post_type'      => 'projet_diplome',
        'post_status'    => 'publish',
        'posts_per_page' => $limit ?: -1,
        'orderby'        => 'date title',
        'order'          => 'DESC',
    );

    return get_posts($args);
}

function acharp_get_enseignants($limit = 0) {
    $args = array(
        'post_type'      => 'enseignant',
        'post_status'    => 'publish',
        'posts_per_page' => $limit ?: -1,
        'orderby'        => 'menu_order title',
        'order'          => 'ASC',
    );

    return get_posts($args);
}
