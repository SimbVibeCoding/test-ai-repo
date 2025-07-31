
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
