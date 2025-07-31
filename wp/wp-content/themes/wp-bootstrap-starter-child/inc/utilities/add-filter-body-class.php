<?php /**
* @snippet Product Category > Body CSS Class | WooCommerce
* @how-to Watch tutorial @ https://businessbloomer.com/?p=19055
* @sourcecode https://businessbloomer.com/?p=21507
* @author Rodolfo Melogli
* @testedwith WooCommerce 3.4
*/

add_filter( 'body_class', 'bbloomer_wc_product_cats_css_body_class' );

function bbloomer_wc_product_cats_css_body_class( $classes ){
  if( is_singular( 'product' ) )
  {
    $custom_terms = get_the_terms(0, 'product_cat');
    if ($custom_terms) {
      foreach ($custom_terms as $custom_term) {
        $classes[] = 'product_cat_' . $custom_term->slug;
      }
    }
  }
  return $classes;
}

?>
