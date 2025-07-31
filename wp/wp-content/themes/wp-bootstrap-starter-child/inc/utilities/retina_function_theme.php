<?php

/**
 * Aggiunge gli stili e gli script del tema child.
 * 
 * Questa funzione carica gli stili del tema parent e gli script personalizzati del tema child.
 */
function wp_bootstrap_starter_child_enqueue_styles()
{
  // Carica lo stile del tema parent.
  wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
  
  // Carica lo script Slick (carosello) del tema child.
  wp_enqueue_script( 'child-slick', get_stylesheet_directory_uri() . '/assets/js/vendor/slick.min.js',array('jquery'));


  // Carica uno script personalizzato per il tema child.
  wp_enqueue_script( 'child-custom', get_stylesheet_directory_uri() . '/assets/js/custom.js',array('jquery'));
}
add_action('wp_enqueue_scripts', 'wp_bootstrap_starter_child_enqueue_styles');

/**
 * Carica gli stili personalizzati nell'area di amministrazione di WordPress.
 */
function admin_style() {
  wp_enqueue_style('admin-styles', get_stylesheet_directory_uri().'/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');

// Registra i tipi di post personalizzati e le tassonomie al momento dell'inizializzazione.
add_action('init','retina_custom_post_type',60);
add_action('init','retina_custom_tax',70);
add_action('init','retina_add_custom_taxonomies',90);

/**
 * Filtra gli argomenti per i tipi di post personalizzati.
 * in base al post type posso modificare i parametri per customizzarlo ad esempio modifico il supporto al solo titolo nel custom post type "prodotti"
 *
 * @param array $args Argomenti per il tipo di post personalizzato.
 * @param string $type Il tipo di post personalizzato.
 * @return array Argomenti modificati.
 */
function retinafilter($args,$type){
  //
  // if("prodotti" == $type){
  //   $args['supports'] = array('title');
  // }
  // return $args;
}
add_filter('retina_custom_posttype_args_filter','retinafilter',10, 2);

/**
 * Registra tipi di post personalizzati.
 * es: create_posttype_multi(array('slider','prodotti'));
 */
function retina_custom_post_type() {
  
}

/**
 * Registra tassonomie personalizzate.
 * il post-type deve essere gia registrato
 * es. retina_register_taxonomy ('tipologia','rivenditori','Tipologia');
 */
function retina_custom_tax() {

}

/**
 * Associa tassonomie ai tipi di post personalizzati.
 *  associazione di una stessa tassonomia esistente a piu tipi di post diversi, i term sono quindi li stessi per tutti i post type es. tax Anno per post Auto, Aoto ecc .
 * es. retina_assoc_taxonomies_to_posttype('posizione', 'rivenditori','slider', );
 */
function retina_add_custom_taxonomies() {

}

// Definisce le costanti per la configurazione dell'invio di email personalizzato.
define( 'WPMS_ON', true );
define( 'WPMS_SMTP_HOST', 'mail.smtp2go.com');
define( 'WPMS_SMTP_PORT', '2525');
define( 'WPMS_SSL', 'TLS');
define( 'WPMS_SMTP_AUTH', true);
define( 'WPMS_SMTP_USER', 'grupporetina.com');
define( 'WPMS_SMTP_PASS', 'Retina@2020' );

?>