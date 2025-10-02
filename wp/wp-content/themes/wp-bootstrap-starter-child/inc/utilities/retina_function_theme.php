<?php
/**
 * Theme utilities and hooks configuration.
 *
 * @package WP_Bootstrap_Starter_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'wp_bootstrap_starter_child_enqueue_assets' ) ) {
    /**
     * Enqueue parent and child assets.
     */
    function wp_bootstrap_starter_child_enqueue_assets() {
        $child_theme  = wp_get_theme();
        $parent_theme = wp_get_theme( get_template() );
        $theme_version = method_exists( $child_theme, 'get' ) ? $child_theme->get( 'Version' ) : null;
        $parent_version = method_exists( $parent_theme, 'get' ) ? $parent_theme->get( 'Version' ) : null;

        wp_enqueue_style(
            'wp-bootstrap-starter-parent-style',
            get_template_directory_uri() . '/style.css',
            array(),
            $parent_version
        );

        wp_enqueue_style(
            'wp-bootstrap-starter-child-fonts',
            'https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap',
            array(),
            null
        );

        wp_enqueue_style(
            'wp-bootstrap-starter-child-style',
            get_stylesheet_uri(),
            array( 'wp-bootstrap-starter-parent-style', 'wp-bootstrap-starter-child-fonts' ),
            $theme_version
        );

        $assets_uri = get_stylesheet_directory_uri() . '/assets/js';

        wp_enqueue_script(
            'wp-bootstrap-starter-child-slick',
            $assets_uri . '/vendor/slick.min.js',
            array( 'jquery' ),
            '1.8.1',
            true
        );

        wp_enqueue_script(
            'wp-bootstrap-starter-child-scripts',
            $assets_uri . '/custom.js',
            array( 'jquery', 'wp-bootstrap-starter-child-slick' ),
            $theme_version,
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'wp_bootstrap_starter_child_enqueue_assets' );

if ( ! function_exists( 'wp_bootstrap_starter_child_admin_styles' ) ) {
    /**
     * Load admin-side styles for branding the editor.
     */
    function wp_bootstrap_starter_child_admin_styles() {
        $child_theme = wp_get_theme();
        $theme_version = method_exists( $child_theme, 'get' ) ? $child_theme->get( 'Version' ) : null;

        wp_enqueue_style(
            'wp-bootstrap-starter-child-admin',
            get_stylesheet_directory_uri() . '/admin.css',
            array(),
            $theme_version
        );
    }
}
add_action( 'admin_enqueue_scripts', 'wp_bootstrap_starter_child_admin_styles' );

add_action( 'init', 'retina_custom_post_type', 60 );
add_action( 'init', 'retina_custom_tax', 70 );
add_action( 'init', 'retina_add_custom_taxonomies', 90 );

if ( ! function_exists( 'retinafilter' ) ) {
    /**
     * Filter callback placeholder to override custom post type args.
     *
     * @param array  $args Arguments for the custom post type.
     * @param string $type Registered post type key.
     *
     * @return array
     */
    function retinafilter( $args, $type ) {
        return $args;
    }
}
add_filter( 'retina_custom_posttype_args_filter', 'retinafilter', 10, 2 );

if ( ! function_exists( 'retina_custom_post_type' ) ) {
    /**
     * Register custom post types.
     */
    function retina_custom_post_type() {}
}

if ( ! function_exists( 'retina_custom_tax' ) ) {
    /**
     * Register custom taxonomies.
     */
    function retina_custom_tax() {}
}

if ( ! function_exists( 'retina_add_custom_taxonomies' ) ) {
    /**
     * Associate taxonomies to post types.
     */
    function retina_add_custom_taxonomies() {}
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedConstantFound
if ( ! defined( 'WPMS_ON' ) ) {
    define( 'WPMS_ON', true );
}

if ( ! defined( 'WPMS_SMTP_HOST' ) ) {
    define( 'WPMS_SMTP_HOST', 'mail.smtp2go.com' );
}

if ( ! defined( 'WPMS_SMTP_PORT' ) ) {
    define( 'WPMS_SMTP_PORT', '2525' );
}

if ( ! defined( 'WPMS_SSL' ) ) {
    define( 'WPMS_SSL', 'TLS' );
}

if ( ! defined( 'WPMS_SMTP_AUTH' ) ) {
    define( 'WPMS_SMTP_AUTH', true );
}

if ( ! defined( 'WPMS_SMTP_USER' ) ) {
    define( 'WPMS_SMTP_USER', getenv( 'WPMS_SMTP_USER' ) ?: 'grupporetina.com' );
}

if ( ! defined( 'WPMS_SMTP_PASS' ) ) {
    define( 'WPMS_SMTP_PASS', getenv( 'WPMS_SMTP_PASS' ) ?: 'Retina@2020' );
}
// phpcs:enable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedConstantFound

