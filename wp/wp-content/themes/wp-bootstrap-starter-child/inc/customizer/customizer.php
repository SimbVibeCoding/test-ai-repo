
<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


require_once( ABSPATH . WPINC . '/class-wp-customize-setting.php' );
require_once( ABSPATH . WPINC . '/class-wp-customize-section.php' );
require_once( ABSPATH . WPINC . '/class-wp-customize-control.php' );
/**
 * The radio image class.
 */
class Storefront_Custom_Radio_Image_Control extends WP_Customize_Control {

	/**
	 * Declare the control type.
	 *
	 * @var string
	 */
	public $type = 'radio-image';


	/**
	 * Enqueue scripts and styles for the custom control.
	 *
	 * Scripts are hooked at {@see 'customize_controls_enqueue_scripts'}.
	 *
	 * Note, you can also enqueue stylesheets here as well. Stylesheets are hooked
	 * at 'customize_controls_print_styles'.
	 */
	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-button' );
	}

	/**
	 * Render the control to be displayed in the Customizer.
	 */
	public function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}

		$name = '_customize-radio-' . $this->id; ?>

		<span class="customize-control-title">
			<?php echo esc_attr( $this->label ); ?>
		</span>

		<?php if ( ! empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<?php endif; ?>

		<div id="input_<?php echo esc_attr( $this->id ); ?>" class="image">
			<?php foreach ( $this->choices as $value => $label ) : ?>
				<input class="image-select" type="radio" value="<?php echo esc_attr( $value ); ?>" id="<?php echo esc_attr( $this->id . $value ); ?>" name="<?php echo esc_attr( $name ); ?>"
					<?php
					$this->link();
					checked( $this->value(), $value );
					?>
				>
					<label for="<?php echo esc_attr( $this->id ) . esc_attr( $value ); ?>">
						<img src="<?php echo esc_html( $label ); ?>" alt="<?php echo esc_attr( $value ); ?>" title="<?php echo esc_attr( $value ); ?>">
					</label>
				</input>
			<?php endforeach; ?>
		</div>

		<script>jQuery(document).ready(function($) { $( '[id="input_<?php echo esc_attr( $this->id ); ?>"]' ).buttonset(); });</script>
		<?php
	}
}

if ( ! class_exists( 'Retina_Customizer' ) ) :

	/**
	 * The Storefront Customizer class
	 */
	class Retina_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			// add_action( 'customize_register', array( $this, 'customize_register' ), 10 );
			add_filter( 'body_class', array( $this, 'layout_class' ) );
			// add_action( 'customize_controls_print_styles', array( $this, 'customizer_custom_control_css' ) );
			// add_action( 'customize_register', array( $this, 'edit_default_customizer_settings' ), 99 );
			// add_action( 'enqueue_block_assets', array( $this, 'block_editor_customizer_css' ) );
			// add_action( 'init', array( $this, 'default_theme_mod_values' ), 10 );
			// add_action( 'wp_enqueue_scripts', array( $this, 'add_customizer_css' ), 130 );
			add_action( 'customize_register', array($this,'retina_customize_register'),  999 );
		}

		public function retina_customize_register ($wp_customize){
			/**
			 * Layout
			 */
			$wp_customize->add_section(
				'retina_layout', array(
					'title'    => __( 'Layout', 'storefront' ),
					'priority' => 50,
				)
			);

			$wp_customize->add_setting(
				'retina_layout', array(
					'default'           => apply_filters( 'storefront_default_layout', $layout = is_rtl() ? 'left' : 'right' ),
					'sanitize_callback' => 'storefront_sanitize_choices',
				)
			);

			$wp_customize->add_control(
				new Storefront_Custom_Radio_Image_Control(
					$wp_customize, 'retina_layout', array(
						'settings' => 'retina_layout',
						'section'  => 'retina_layout',
						'label'    => __( 'General Layout', 'storefront' ),
						'priority' => 1,
						'choices'  => array(
							'right' => get_stylesheet_directory_uri() . '/assets/images/customizer/controls/2cr.png',
							'left'  => get_stylesheet_directory_uri() . '/assets/images/customizer/controls/2cl.png',
							'none'  => get_stylesheet_directory_uri() . '/assets/images/customizer/controls/full.png',
						),
					)
				)
			);


		  return $wp_customize;
		}
		/**
		 * Layout classes
		 * Adds 'right-sidebar' and 'left-sidebar' classes to the body tag
		 *
		 * @param  array $classes current body classes.
		 * @return string[]          modified body classes
		 * @since  1.0.0
		 */
		public function layout_class( $classes ) {
			$left_or_right = get_theme_mod( 'retina_layout' );

			$classes[] = $left_or_right . '-sidebar';

			return $classes;
		}
}
endif;
/**
* Sanitizes choices (selects / radios)
* Checks that the input matches one of the available choices
*
* @param array $input the available choices.
* @param array $setting the setting object.
* @since  1.3.0
*/
function storefront_sanitize_choices( $input, $setting ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
return new Retina_Customizer();
