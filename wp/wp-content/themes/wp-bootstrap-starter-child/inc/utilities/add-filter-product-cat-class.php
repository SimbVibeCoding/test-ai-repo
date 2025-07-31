<?php
add_filter( 'product_cat_class', 'filter_product_cat_class_archive', 15, 3 );
function filter_product_cat_class_archive( $classes, $class, $category ){
  //$classes = array();
  if( is_home() || is_front_page()) {
    if ($category->taxonomy == 'product_cat' ) {
      $classes[] = 'product_cat_' . $category->slug;
        }
      }
    return $classes;
}

 ?>
