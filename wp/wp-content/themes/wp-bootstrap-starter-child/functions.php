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
