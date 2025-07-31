
<?php
 add_action( 'customize_register', 'retina_customize_register',  999 );
 function retina_customize_register ($wp_customize){
   $wp_customize->add_section(
       'retinalayout',
       array(
           'title' => __( 'Retina Layouts', 'wp-bootstrap-starter' ),
           'description' => __( 'Layout generale del sito', 'wp-bootstrap-starter' ),
           'priority' => 99,
       )
   );
   $wp_customize->add_setting( 'retinalayout_setting' , array(
     'default'     => 'left',
     'transport'   => 'refresh',
   ) );
   $wp_customize->add_control(
       new WP_Customize_Control(
           $wp_customize,
           'retina_layout',
           array(
               'label'          => __( 'layouts', 'wp-bootstrap-starter' ),
               'section'        => 'retinalayout',
               'settings'       => 'retinalayout_setting',
               'type'           => 'radio',
               'choices'        => array(
                 'right' => 'right sidebar',
                 'left'  => 'left sidebar',
                 'no'  => 'full no sidebar',
               )
           )
       )
   );

  //  $wp_customize->get_control('retina_layout')->choices = array(
  //   'right' => get_template_directory_uri() . '/assets/images/customizer/controls/2cr.png',
  //   'left'  => get_template_directory_uri() . '/assets/images/customizer/controls/2cl.png',
  //   'no'  => get_stylesheet_directory_uri() . '/assets/images/customizer/controls/full.png',
  // );
   return $wp_customize;
 }
 /**
  * Custom controls
  */
 require_once dirname( __FILE__ ) . '/class-storefront-customizer-control-radio-image.php';
 require_once dirname( __FILE__ ) . '/class-storefront-customizer-control-arbitrary.php';

 if ( apply_filters( 'storefront_customizer_more', true ) ) {
   require_once dirname( __FILE__ ) . '/class-storefront-customizer-control-more.php';
 }


 $wp_customize->add_setting(
   'retinalayout', array(
     'default'           => apply_filters( 'storefront_default_layout', $layout = is_rtl() ? 'left' : 'right' ),
     //'sanitize_callback' => 'storefront_sanitize_choices',
   )
 );
