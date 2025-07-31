<?php
function get_localized_term_object($id,$tax,$languageCode=ICL_LANGUAGE_CODE){
  $localizedID   = icl_object_id($id, $tax, false, $languageCode);
  $localizedObject = get_term( (icl_object_id(  $localizedID , $tax, false,$languageCode)),$tax);
  return $id;
}
/**
 * [retina_icl_adjust_id_url_filter_off description]
 * @method retina_icl_adjust_id_url_filter_off
 * @return [type]                              [interrompe la traduzione forzata da parte di WPML]
 */
function retina_icl_adjust_id_url_filter_off(){
  global $icl_adjust_id_url_filter_off;
  $orig_flag_value = $icl_adjust_id_url_filter_off;
  $icl_adjust_id_url_filter_off = true;
      // codice
      $cat = get_term_by('slug', $tipo, 'tipo_doc');
      $cat_it_id = apply_filters( 'wpml_object_id', $cat->term_id, 'tipo_doc', false, 'it' );
      $cat_it=(get_term($cat_it_id,'tipo_doc'));
      $tipo = $cat_it->slug;
      //fine codice
  	$icl_adjust_id_url_filter_off = $orig_flag_value;
}
