<?php
/**
 * Theme customizer additions.
 *
 * @package WP_Bootstrap_Starter_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once ABSPATH . WPINC . '/class-wp-customize-setting.php';
require_once ABSPATH . WPINC . '/class-wp-customize-section.php';
require_once ABSPATH . WPINC . '/class-wp-customize-control.php';

if ( ! class_exists( 'Storefront_Custom_Radio_Image_Control' ) ) {
    /**
     * Radio image control for the Customizer.
     */
    class Storefront_Custom_Radio_Image_Control extends WP_Customize_Control {

        /**
         * Control type.
         *
         * @var string
         */
        public $type = 'radio-image';

        /**
         * Enqueue scripts for the control.
         */
        public function enqueue() {
            wp_enqueue_script( 'jquery-ui-button' );
        }

        /**
         * Render the control content.
         */
        public function render_content() {
            if ( empty( $this->choices ) ) {
                return;
            }

            $name = '_customize-radio-' . $this->id;
            ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>

            <?php if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
            <?php endif; ?>

            <div id="input_<?php echo esc_attr( $this->id ); ?>" class="image">
                <?php foreach ( $this->choices as $value => $label ) : ?>
                    <input
                        class="image-select"
                        type="radio"
                        value="<?php echo esc_attr( $value ); ?>"
                        id="<?php echo esc_attr( $this->id . $value ); ?>"
                        name="<?php echo esc_attr( $name ); ?>"
                        <?php
                        $this->link();
                        checked( $this->value(), $value );
                        ?>
                    >
                        <label for="<?php echo esc_attr( $this->id ) . esc_attr( $value ); ?>">
                            <img src="<?php echo esc_url( $label ); ?>" alt="<?php echo esc_attr( $value ); ?>" title="<?php echo esc_attr( $value ); ?>">
                        </label>
                    </input>
                <?php endforeach; ?>
            </div>

            <script>
                jQuery( function( $ ) {
                    $( '#input_<?php echo esc_js( $this->id ); ?>' ).buttonset();
                } );
            </script>
            <?php
        }
    }
}

if ( ! class_exists( 'Retina_Customizer' ) ) {
    /**
     * Hooks Customizer additions for the theme.
     */
    class Retina_Customizer {
        /**
         * Bootstrap the class by wiring hooks.
         */
        public function __construct() {
            add_filter( 'body_class', array( $this, 'layout_class' ) );
            add_action( 'customize_register', array( $this, 'retina_customize_register' ), 999 );
        }

        /**
         * Register customizer controls and settings.
         *
         * @param WP_Customize_Manager $wp_customize Customizer object.
         */
        public function retina_customize_register( $wp_customize ) {
            $wp_customize->add_section(
                'retina_layout',
                array(
                    'title'    => __( 'Layout', 'storefront' ),
                    'priority' => 50,
                )
            );

            $wp_customize->add_setting(
                'retina_layout',
                array(
                    'default'           => apply_filters( 'storefront_default_layout', is_rtl() ? 'left' : 'right' ),
                    'sanitize_callback' => 'storefront_sanitize_choices',
                )
            );

            $wp_customize->add_control(
                new Storefront_Custom_Radio_Image_Control(
                    $wp_customize,
                    'retina_layout',
                    array(
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
        }

        /**
         * Append layout class to the body tag.
         *
         * @param array $classes Existing body classes.
         *
         * @return array
         */
        public function layout_class( $classes ) {
            $left_or_right = get_theme_mod( 'retina_layout', 'right' );
            $classes[]     = $left_or_right . '-sidebar';

            return $classes;
        }
    }
}

new Retina_Customizer();

if ( ! function_exists( 'storefront_sanitize_choices' ) ) {
    /**
     * Sanitize select/radio options.
     *
     * @param string                $input   Selected option.
     * @param WP_Customize_Setting  $setting Control setting instance.
     */
    function storefront_sanitize_choices( $input, $setting ) {
        $input   = sanitize_key( $input );
        $choices = $setting->manager->get_control( $setting->id )->choices;

        return array_key_exists( $input, $choices ) ? $input : $setting->default;
    }
}
