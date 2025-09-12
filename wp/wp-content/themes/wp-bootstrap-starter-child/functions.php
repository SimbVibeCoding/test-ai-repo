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
    do_action('wpml_register_single_string', 'macplast-theme', 'product_card_cta', 'Scopri di più');
    do_action('wpml_register_single_string', 'macplast-theme', 'product_badge_new', 'Novità');
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

