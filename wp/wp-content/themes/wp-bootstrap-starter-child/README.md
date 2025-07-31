# README #
DEV 2.0
# TODO #

- [] Customizer

## Customizer ##
https://codex.wordpress.org/Theme_Customization_API#Part_1:_Defining_Settings.2C_Controls.2C_Etc.
https://www.html.it/pag/57001/il-theme-customizer-di-wordpress/ (ITA)


add_setting()	=>  Memorizza una nuova impostazione nel database
add_section() =>	Aggiunge una nuova sezione (gruppo di controlli) al Customizer
add_control()	=>  Aggiunge un controllo HTML
get_setting()	=>  Recupera un’impostazione dal database

vedi anche codice di storefront

```
// necessaria funzione nell'hook "customize_register"

add_action( 'customize_register', 'retina_customize_register',  999 );
function retina_customize_register ($wp_customize){
  // add section
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
  // add control
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



```

# List of all theme customizer control types #
* **WP_Customize_Control**
  * **text**
  * **checkbox**
  * **radio**
  * **select**
  * **dropdown-pages**

* **WP_Customize_Color_Control** - extends the built in WP_Customize_Control class. It adds the color wheel jazz to places where color selection is needed.
* **WP_Customize_Upload_Control** – This gives you an upload box, for allowing file uploads. However, you probably won’t use this directly, you’ll extend it for other things… like:
* **WP_Customize_Image_Control** – This gives the image picker and the uploader box. It extends the upload controller. You can see it in action on the custom background piece, where a user can upload a new file to be the background image.
* **WP_Customize_Header_Image_Control** – Because of the resizing action of the header piece, it needs a bit of special handling and display, so the * **WP_Customize_Header_Image_Control** extends the WP_Customize_Image_Control to add that functionality. You can see it in action on the custom header piece, where a user can upload a new file to be the header image.


* **WP_Customize_Background_Image_Control**

```php
$wp_customize->add_control(
    new WP_Customize_Control(
        $wp_customize,
        'your_setting_id',
        array(
            'label'          => __( 'Dark or light theme version?', 'theme_name' ),
            'section'        => 'your_section_id',
            'settings'       => 'your_setting_id',
            'type'           => 'radio',
            'choices'        => array(
                'dark'   => __( 'Dark' ),
                'light'  => __( 'Light' )
            )
        )
    )
);
```
```php
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
	'label'      => __( 'Header Color', 'mytheme' ),
	'section'    => 'your_section_id',
	'settings'   => 'your_setting_id',
) ) );
```
