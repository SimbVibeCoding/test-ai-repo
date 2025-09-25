<?php

// Include i file PHP per la personalizzazione del tema e le utility.
include ('inc/customizer/customizer.php');
include ('inc/utilities/retina_function_posttype.php');
include ('inc/utilities/retina_function_theme.php');
include ('inc/installation/install_theme_functions.php');



// Shortcode: [categorie_prodotti_vetrina]
function mostra_categorie_prodotti_vetrina() {
    // Prendi solo categorie prodotto di primo livello (parent = 0)
    $args = array(
        'taxonomy'     => 'product_cat',
        'parent'       => 0,
        'orderby'      => 'name',
        'order'        => 'ASC',
        'hide_empty'   => false, // Mostra solo se ci sono prodotti dentro
    );
    $categories = get_terms($args);

    if (empty($categories) || is_wp_error($categories)) {
        return '<p>Nessuna categoria trovata.</p>';
    }

    $output = '<ul class="categorie-prodotti-vetrina">';
    foreach ($categories as $category) {
        // Ottieni immagine categoria (thumbnail)
        $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
        $image_url = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : wc_placeholder_img_src();

        $output .= '<li class="categoria-prodotto">';
        $output .= '<a href="' . esc_url(get_term_link($category)) . '">';
        $output .= '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($category->name) . '"  />';
        $output .= '<span>' . esc_html($category->name) . '</span>';
        $output .= '</a>';
        $output .= '</li>';
    }
    $output .= '</ul>';

    return $output;
}
add_shortcode('categorie_prodotti_vetrina', 'mostra_categorie_prodotti_vetrina');

// Register translatable strings for WPML/Polylang (CTA + badge)
add_action('init', function() {
    // These actions are safe no-ops if WPML is not active
    do_action('wpml_register_single_string', 'macplast-theme', 'product_card_cta', 'Scopri di piu');
    do_action('wpml_register_single_string', 'macplast-theme', 'product_badge_new', 'Novita');
});

// 1) (Consigliato) Disabilita i template a blocchi di WooCommerce
add_filter( 'woocommerce_has_block_template', '__return_false', 999 );

/**
 * 2) Forza TUTTI gli archivi prodotti ad usare /woocommerce/archive-product.php del child theme
 *    - Shop principale (/negozio)
 *    - Archivio post type product
 *    - Categorie (product_cat), tag (product_tag)
 *    - Attributi prodotto (pa_*)
 */
add_filter( 'template_include', function( $template ) {

    // Prendi oggetto tassonomia se presente
    $q = get_queried_object();

    // Riconosciamo tutti i casi "archivio prodotti"
    $is_product_archive =
        is_shop() ||
        is_post_type_archive( 'product' ) ||
        is_tax( array( 'product_cat', 'product_tag' ) ) ||
        ( is_tax() && $q && isset( $q->taxonomy ) && strpos( $q->taxonomy, 'pa_' ) === 0 );

    if ( $is_product_archive ) {
        $forced = get_stylesheet_directory() . '/woocommerce/archive-product.php';
        if ( file_exists( $forced ) ) {
            return $forced;
        }
    }

    return $template;
}, 50 );


if ( ! function_exists( 'macplast_is_product_search_query' ) ) {
    function macplast_is_product_search_query( $query ) {
        if ( is_admin() || ! $query instanceof \WP_Query ) {
            return false;
        }

        if ( ! $query->is_main_query() || ! $query->is_search() ) {
            return false;
        }

        $post_types = $query->get( 'post_type' );

        if ( empty( $post_types ) ) {
            return false;
        }

        if ( is_array( $post_types ) ) {
            return in_array( 'product', $post_types, true );
        }

        return 'product' === $post_types;
    }
}

function macplast_extend_product_search_join( $join, $query ) {
    if ( ! macplast_is_product_search_query( $query ) ) {
        return $join;
    }

    global $wpdb;

    if ( false === strpos( $join, 'macp_tr' ) ) {
        $join .= " LEFT JOIN {$wpdb->term_relationships} macp_tr ON ({$wpdb->posts}.ID = macp_tr.object_id)";
        $join .= " LEFT JOIN {$wpdb->term_taxonomy} macp_tt ON (macp_tr.term_taxonomy_id = macp_tt.term_taxonomy_id)";
        $join .= " LEFT JOIN {$wpdb->terms} macp_t ON (macp_tt.term_id = macp_t.term_id)";
    }

    return $join;
}
add_filter( 'posts_join', 'macplast_extend_product_search_join', 10, 2 );

function macplast_extend_product_search_where( $search, $query ) {
    if ( ! macplast_is_product_search_query( $query ) ) {
        return $search;
    }

    global $wpdb;

    $term = $query->get( 's' );

    if ( empty( $term ) ) {
        return $search;
    }

    $like = '%' . $wpdb->esc_like( $term ) . '%';
    $attribute_clause = $wpdb->prepare( '(macp_tt.taxonomy LIKE %s AND macp_t.name LIKE %s)', 'pa_%', $like );

    if ( trim( $search ) === '' ) {
        return ' AND ' . $attribute_clause;
    }

    $updated = preg_replace( '/\)\s*$/', ' OR ' . $attribute_clause . ')', $search, 1 );

    if ( null !== $updated ) {
        return $updated;
    }

    return $search . ' OR ' . $attribute_clause;
}
add_filter( 'posts_search', 'macplast_extend_product_search_where', 10, 2 );

function macplast_extend_product_search_distinct( $distinct, $query ) {
    if ( macplast_is_product_search_query( $query ) ) {
        return 'DISTINCT';
    }

    return $distinct;
}
add_filter( 'posts_distinct', 'macplast_extend_product_search_distinct', 10, 2 );


// Shortcode: [macplast_recent_products]
function macplast_recent_products_shortcode($atts = array()) {
    $atts = shortcode_atts(
        array(
            'per_page' => 4,
            'title'    => esc_html__( 'Ultimi prodotti inseriti', 'wp-bootstrap-starter-child' ),
        ),
        $atts,
        'macplast_recent_products'
    );

    $per_page = (int) $atts['per_page'];
    if ($per_page <= 0) {
        $per_page = 4;
    } elseif ($per_page > 12) {
        $per_page = 12;
    }

    $query = new WP_Query(
        array(
            'post_type'           => 'product',
            'post_status'         => 'publish',
            'posts_per_page'      => $per_page,
            'orderby'             => 'date',
            'order'               => 'DESC',
            'ignore_sticky_posts' => 1,
            'no_found_rows'       => true,
        )
    );

    if (!$query->have_posts()) {
        wp_reset_postdata();
        return '';
    }

    ob_start();

   

    $title = trim($atts['title']);
    if ($title !== '') {
        echo '<h3>' . esc_html($title) . '</h3>';
        echo '<hr class="wp-block-separator has-alpha-channel-opacity spazietto">';
    }

    wc_set_loop_prop('name', 'macplast_recent_products');
    wc_set_loop_prop('is_shortcode', true);

    woocommerce_product_loop_start();

    while ($query->have_posts()) {
        $query->the_post();
        wc_get_template_part('content', 'product');
    }

    woocommerce_product_loop_end();

  echo '<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex"><div class="wp-block-button button-grigio"><a href="/prodotti" class="wp-block-button__link wp-element-button">'. esc_html__( 'Tutti i prodotti', 'wp-bootstrap-starter-child' ) .'</a></div></div>';
    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('macplast_recent_products', 'macplast_recent_products_shortcode');