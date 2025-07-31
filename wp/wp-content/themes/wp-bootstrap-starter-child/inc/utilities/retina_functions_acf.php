<?php
function my_acf_load_field_revslider( $field ) {
    if ( class_exists( 'RevSlider' ) ) {
      $slider = new RevSlider();
      $sliders = $slider->get_sliders();
        if(count($sliders) > 0) {
            foreach($sliders as $slider)
            {
                $field['choices'][$slider->alias] = $slider->title;
            }
        } else {
            $field['choices'] = array( 'none' => 'No sliders exist. You must create one first.' );
        }
    } else {
        $field['choices'] = array( 'none' => 'Slider Revolution plugin was not found.' );
    }
    return $field;
}
function my_acf_load_field_pagine( $field ) {
  $field['choices']['uno'] = 'uno';
  // global $post;
  // if(is_page()){
  //   if(get_pages()){
  //     $args=array(
  //       'child_of' => 0,
  //       'parent' =>0,
  //       'hierarchical'=> 'true',
  //       'post_type' => 'page',
  //       'post_status' => 'publish',
  //     );
  //     $pages=get_pages($atts );
  //     $field['choices']['uno'] = 'uno';
  //     foreach($pages as $page)
  //     {
  //       $field['choices'][$page->slug] = $page->title;
  //     }
  //   } else {
  //       $field['choices'] = array( 'none' => 'Non ci sono pagine disponibili.' );
  //   }
  // }
    return $field;
}
