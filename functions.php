<?php

require_once get_stylesheet_directory() . '/inc/content.php';

add_filter('acf/settings/save_json', function () {
    return get_stylesheet_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function ($paths) {
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
});


function add_hreflang_tags() {
    // Définir l'URL de la version par défaut (x-default) du site
    $default_url = get_home_url(); // ou mettre une URL spécifique

    // Obtenir l'URL actuelle
    $current_url = home_url( add_query_arg( NULL, NULL ) );

    // Si la langue est française
    if ( get_locale() == 'fr_FR' ) {
        echo '<link rel="alternate" hreflang="fr" href="' . esc_url( $current_url ) . '" />' . "\n";
    }

    // Pour la version x-default
    echo '<link rel="alternate" hreflang="x-default" href="' . esc_url( $default_url ) . '" />' . "\n";
}
add_action( 'wp_head', 'add_hreflang_tags' );


function add_self_canonical_tag() {
    // Obtenir l'URL de la page actuelle
    $current_url = home_url( add_query_arg( NULL, NULL ) );

    // Ajouter la balise canonical
    echo '<link rel="canonical" href="' . esc_url( $current_url ) . '" />' . "\n";
}
add_action( 'wp_head', 'add_self_canonical_tag' );

add_action( 'wp_enqueue_scripts', 'wpm_enqueue_styles' );
function wpm_enqueue_styles(){
    //wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/styles/theme.css' );
    wp_enqueue_style('lightbox', get_stylesheet_directory_uri() . '/styles/lightbox.css', array(), filemtime(get_stylesheet_directory() . '/styles/lightbox.css'));
    wp_enqueue_style('theme', get_stylesheet_directory_uri() . '/styles/theme.css', array(), filemtime(get_stylesheet_directory() . '/styles/theme.css'));
    wp_enqueue_script(
        'beforeafter', // Identifiant unique du script
        get_stylesheet_directory_uri() . '/js/beforeafter.js', // URL du fichier JS
        array( 'jquery' ), // Dépendances (si besoin, ici 'jquery')
        null, // Version du script (null pour désactiver la gestion des versions)
        true // Charger dans le footer (true) ou dans le header (false)
    );

    wp_enqueue_script(
        'script', // Identifiant unique du script
        get_stylesheet_directory_uri() . '/js/script.js', // URL du fichier JS
        array( 'jquery' ), // Dépendances (si besoin, ici 'jquery')
        filemtime( get_stylesheet_directory() . '/js/script.js' ), // Version du script (cache busting)
        true // Charger dans le footer (true) ou dans le header (false)
    );

    if ( is_post_type_archive( 'actualite' ) || is_tax( 'type_actualite' ) ) {
        wp_enqueue_script(
            'acharp-actualites',
            get_stylesheet_directory_uri() . '/js/actualites.js',
            array(),
            filemtime( get_stylesheet_directory() . '/js/actualites.js' ),
            true
        );

        wp_localize_script( 'acharp-actualites', 'acharpActualites', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'acharp_actualites' ),
        ) );
    }
}


function egp_custom_post_type() {
    $labels = array(
        'name'                => __( 'Galerie', 'lsd_lang'),
        'singular_name'       => __( 'Galerie', 'lsd_lang'),
        'menu_name'           => __( 'Galerie', 'lsd_lang'),
        'all_items'           => __( 'Tous les types de Galerie', 'lsd_lang'),
        'view_item'           => __( 'Voir tous les types de Galerie', 'lsd_lang'),
        'add_new_item'        => __( 'Ajouter une Galerie', 'lsd_lang'),
        'add_new'             => __( 'Ajouter', 'lsd_lang'),
        'edit_item'           => __( 'Editer un type la Galerie', 'lsd_lang'),
        'update_item'         => __( 'Modifier un type la galerie', 'lsd_lang'),
        'not_found'           => __( 'Non trouvée', 'lsd_lang'),
        'not_found_in_trash'  => __( 'Non trouvée dans la corbeille', 'lsd_lang'),
    );

    $args = array(
        'label'               => __( 'Types de Galerie', 'lsd_lang'),
        'description'         => __( 'Toutes les Galerie', 'lsd_lang'),
        'labels'              => $labels,
        'supports'            => array( 'title', 'author', 'revisions', 'custom-fields' ),
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-admin-home',
        'hierarchical'        => true,
        'public'              => true,
        'publicly_queryable' => true,
        'has_archive'         => 'galerie',
        'rewrite' => array(
            'with_front' => true
        )
    );

    register_post_type( 'galerie', $args );

    // Product


    $labels = array(
        'name'               => __( 'Actualités', 'lsd_lang' ),
        'singular_name'      => __( 'Actualité', 'lsd_lang' ),
        'menu_name'          => __( 'Actualités', 'lsd_lang' ),
        'all_items'          => __( 'Toutes les actualités', 'lsd_lang' ),
        'view_item'          => __( 'Voir l’actualité', 'lsd_lang' ),
        'add_new_item'       => __( 'Ajouter une actualité', 'lsd_lang' ),
        'add_new'            => __( 'Ajouter', 'lsd_lang' ),
        'edit_item'          => __( 'Modifier l’actualité', 'lsd_lang' ),
        'update_item'        => __( 'Mettre à jour l’actualité', 'lsd_lang' ),
        'search_items'       => __( 'Rechercher une actualité', 'lsd_lang' ),
        'not_found'          => __( 'Aucune actualité trouvée', 'lsd_lang' ),
        'not_found_in_trash' => __( 'Aucune actualité dans la corbeille', 'lsd_lang' ),
    );

    $args = array(
        'label'               => __( 'Actualités', 'lsd_lang' ),
        'description'         => __( 'Actualités et évènements', 'lsd_lang' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields' ),
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-megaphone',
        'hierarchical'        => false,
        'public'              => true,
        'publicly_queryable'  => true,
        'has_archive'         => 'actualites',
        'rewrite'             => array(
            'slug'       => 'actualites',
            'with_front' => false,
        ),
    );

    /**
     * Enregistrée avant le type : l’URL des étiquettes est imbriquée sous
     * /actualites/, et les règles de réécriture sont générées dans l’ordre
     * d’enregistrement. Après le type, les règles de pièce jointe du CPT
     * captureraient /actualites/type/xxx avant la taxonomie.
     */
    register_taxonomy(
        'type_actualite',
        'actualite',
        array(
            'label'             => __( 'Étiquettes', 'lsd_lang' ),
            'labels'            => array(
                'name'          => __( 'Étiquettes', 'lsd_lang' ),
                'singular_name' => __( 'Étiquette', 'lsd_lang' ),
                'all_items'     => __( 'Toutes les étiquettes', 'lsd_lang' ),
                'add_new_item'  => __( 'Ajouter une étiquette', 'lsd_lang' ),
                'edit_item'     => __( 'Modifier l’étiquette', 'lsd_lang' ),
                'search_items'  => __( 'Rechercher une étiquette', 'lsd_lang' ),
                'not_found'     => __( 'Aucune étiquette trouvée', 'lsd_lang' ),
            ),
            'hierarchical'      => false,
            'public'            => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'query_var'         => true,
            'rewrite'           => array(
                'slug'       => 'actualites/type',
                'with_front' => false,
            ),
        )
    );

    register_post_type( 'actualite', $args );

    $labels = array(
        'name'               => __( 'Cursus', 'lsd_lang' ),
        'singular_name'      => __( 'Cursus', 'lsd_lang' ),
        'menu_name'          => __( 'Cursus', 'lsd_lang' ),
        'all_items'          => __( 'Tous les cursus', 'lsd_lang' ),
        'view_item'          => __( 'Voir le cursus', 'lsd_lang' ),
        'add_new_item'       => __( 'Ajouter un cursus', 'lsd_lang' ),
        'add_new'            => __( 'Ajouter', 'lsd_lang' ),
        'edit_item'          => __( 'Modifier le cursus', 'lsd_lang' ),
        'update_item'        => __( 'Mettre à jour le cursus', 'lsd_lang' ),
        'search_items'       => __( 'Rechercher un cursus', 'lsd_lang' ),
        'not_found'          => __( 'Aucun cursus trouvé', 'lsd_lang' ),
        'not_found_in_trash' => __( 'Aucun cursus dans la corbeille', 'lsd_lang' ),
    );

    $args = array(
        'label'               => __( 'Cursus', 'lsd_lang' ),
        'description'         => __( 'Parcours de formation', 'lsd_lang' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'excerpt', 'thumbnail', 'revisions', 'custom-fields', 'page-attributes' ),
        'show_in_rest'        => true,
        'menu_icon'           => 'dashicons-welcome-learn-more',
        'hierarchical'        => false,
        'public'              => true,
        'publicly_queryable'  => true,
        'has_archive'         => 'cursus',
        'rewrite'             => array(
            'slug'       => 'cursus',
            'with_front' => false,
        ),
    );

    register_post_type( 'cursus', $args );

}

add_action( 'init', 'egp_custom_post_type', 0 );

function acharp_cursus_archive_query( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( $query->is_post_type_archive( 'cursus' ) ) {
        $query->set( 'posts_per_page', -1 );
        $query->set( 'orderby', 'menu_order title' );
        $query->set( 'order', 'ASC' );
    }

    if ( $query->is_post_type_archive( 'actualite' ) || $query->is_tax( 'type_actualite' ) ) {
        $query->set( 'posts_per_page', 9 );
        $query->set( 'orderby', 'date' );
        $query->set( 'order', 'DESC' );
    }
}
add_action( 'pre_get_posts', 'acharp_cursus_archive_query' );

/**
 * Filtrage AJAX de la liste des actualités. Rend exactement le même partiel
 * que le serveur, pour garantir un rendu identique.
 */
function acharp_ajax_filter_actualites() {
    check_ajax_referer( 'acharp_actualites', 'nonce' );

    $slug  = isset( $_POST['term'] ) ? sanitize_title( wp_unslash( $_POST['term'] ) ) : '';
    $paged = isset( $_POST['paged'] ) ? max( 1, (int) $_POST['paged'] ) : 1;

    $query_args = array(
        'post_type'      => 'actualite',
        'post_status'    => 'publish',
        'posts_per_page' => 9,
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $term = $slug ? get_term_by( 'slug', $slug, 'type_actualite' ) : null;

    if ( $slug && ! $term ) {
        wp_send_json_error( array( 'message' => 'Étiquette inconnue.' ), 404 );
    }

    if ( $term ) {
        $query_args['tax_query'] = array(
            array(
                'taxonomy' => 'type_actualite',
                'field'    => 'term_id',
                'terms'    => $term->term_id,
            ),
        );
    }

    $query    = new WP_Query( $query_args );
    $base_url = $term ? get_term_link( $term ) : get_post_type_archive_link( 'actualite' );

    if ( is_wp_error( $base_url ) || ! $base_url ) {
        $base_url = get_post_type_archive_link( 'actualite' ) ?: home_url( '/' );
    }

    ob_start();
    get_template_part( 'template-parts/general/resultats-actualites', null, array(
        'query'    => $query,
        'base_url' => $base_url,
        'paged'    => $paged,
    ) );

    wp_send_json_success( array(
        'html'  => ob_get_clean(),
        'url'   => $paged > 1 ? trailingslashit( $base_url ) . 'page/' . $paged . '/' : $base_url,
        'title' => $term ? $term->name : 'Actualités',
        'found' => (int) $query->found_posts,
    ) );
}
add_action( 'wp_ajax_acharp_filter_actualites', 'acharp_ajax_filter_actualites' );
add_action( 'wp_ajax_nopriv_acharp_filter_actualites', 'acharp_ajax_filter_actualites' );

/**
 * Une archive n’a pas de champs propres : le hero de /actualites/ est piloté
 * depuis cette page d’options, lue par la strate via post_id.
 */
function acharp_acf_options_pages() {
    if ( ! function_exists( 'acf_add_options_sub_page' ) ) {
        return;
    }

    acf_add_options_sub_page( array(
        'page_title'      => __( 'Navigation du site', 'lsd_lang' ),
        'menu_title'      => __( 'Navigation du site', 'lsd_lang' ),
        'menu_slug'       => 'acharp-header-navigation',
        'parent_slug'     => 'themes.php',
        'post_id'         => 'header_options',
        'capability'      => 'edit_theme_options',
        'update_button'   => __( 'Enregistrer la navigation', 'lsd_lang' ),
        'updated_message' => __( 'Navigation mise à jour.', 'lsd_lang' ),
    ) );

    acf_add_options_sub_page( array(
        'page_title'      => __( 'Hero de l’archive', 'lsd_lang' ),
        'menu_title'      => __( 'Hero de l’archive', 'lsd_lang' ),
        'menu_slug'       => 'acharp-actualites-archive',
        'parent_slug'     => 'edit.php?post_type=actualite',
        'post_id'         => 'actualite_archive',
        'capability'      => 'edit_posts',
        'update_button'   => __( 'Enregistrer', 'lsd_lang' ),
        'updated_message' => __( 'Hero mis à jour.', 'lsd_lang' ),
    ) );
}
add_action( 'acf/init', 'acharp_acf_options_pages' );

function acharp_flush_rewrite_on_switch() {
    egp_custom_post_type();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'acharp_flush_rewrite_on_switch' );





function egp_taxonomy() {
    register_taxonomy(
        'typo_client',
        'galerie',
        array(
            'hierarchical' => true,
            'show_admin_column' => true,
            'label' => __( 'Marques', 'lsd_lang'),
            'query_var' => true
        )
    );

    register_taxonomy(
        'typo_product',
        'galerie',
        array(
            'hierarchical' => true,
            'show_admin_column' => true,
            'label' => __( 'Prestations', 'lsd_lang'),
            'query_var' => true
        )
    );

}
add_action( 'init', 'egp_taxonomy');


add_image_size('600_600', 600, 600, true);


// Hide native post type
function hide_post_type_from_admin_menu() {
    // Pour masquer les articles (post)
    remove_menu_page('edit.php');
    // Pour masquer les pages
    // remove_menu_page('edit.php?post_type=page');
}
add_action('admin_menu', 'hide_post_type_from_admin_menu');

function hide_post_type_from_frontend($args, $post_type) {
    if ($post_type === 'post') {  // Remplacez 'post' par le post type que vous voulez masquer
        $args['public'] = false;  // Rend le post type privé
        $args['publicly_queryable'] = false;  // Empêche les requêtes sur le front-end
        $args['show_ui'] = false;  // Masque du menu d'administration
        $args['exclude_from_search'] = true;  // Exclut des résultats de recherche
    }
    return $args;
}
add_filter('register_post_type_args', 'hide_post_type_from_frontend', 10, 2);


// Fil d'ariane

function custom_breadcrumb() {
    // Start the breadcrumb with a link to the home page
    if (!is_front_page()) {
        echo '<nav class="breadcrumb">';
        echo '<a href="' . home_url() . '">Accueil</a> ';

        // If we're on a single post, custom post type or page
        if (is_singular()) {
            global $post;
            $post_type = get_post_type_object(get_post_type());

            // If the post type is not 'post', show the post type archive link
            if ($post_type && $post_type->has_archive) {
                echo '<a href="' . get_post_type_archive_link($post_type->name) . '">' . $post_type->labels->name . '</a> ';
            }

            // Get ancestors of the current post to show hierarchy
            $ancestors = array_reverse(get_post_ancestors($post));

            foreach ($ancestors as $ancestor) {
                echo '<a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a> ';
            }

            // Finally, the current post title
            echo '<span>' . get_the_title() . '</span>';
        }
        // If we're on a post type archive page
        elseif (is_post_type_archive()) {
            $post_type = get_post_type_object(get_post_type());
            if ($post_type) {
                echo '<span>' . $post_type->labels->name . '</span>';
            }
        }
        // If we're on a category or custom taxonomy archive page
        elseif (is_category() || is_tag() || is_tax()) {
            $term = get_queried_object();
            echo '<span>' . $term->name . '</span>';
        }
        // If we're on an archive page like date, author, etc.
        elseif (is_archive()) {
            if (is_date()) {
                if (is_day()) {
                    echo '<span>' . get_the_date() . '</span>';
                } elseif (is_month()) {
                    echo '<span>' . get_the_date('F Y') . '</span>';
                } elseif (is_year()) {
                    echo '<span>' . get_the_date('Y') . '</span>';
                }
            } elseif (is_author()) {
                echo '<span>' . get_the_author() . '</span>';
            }
        }
        // For 404 pages
        elseif (is_404()) {
            echo '<span>Erreur 404</span>';
        }
    }

    // Close nav tag
    echo '</nav>';
}

add_image_size( 'relsize', 1920, 1080, true );
add_image_size( 'crosslink', 900, 900, true );
