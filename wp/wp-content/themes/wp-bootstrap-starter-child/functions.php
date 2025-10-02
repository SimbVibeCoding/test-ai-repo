<?php
/**
 * Theme bootstrap for wp-bootstrap-starter-child.
 *
 * Loads dependencies and wires up the child theme features.
 *
 * @package WP_Bootstrap_Starter_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$child_theme_includes = array(
    'customizer/customizer.php',
    'utilities/retina_function_posttype.php',
    'utilities/retina_function_theme.php',
    'installation/install_theme_functions.php'
);

foreach ( $child_theme_includes as $relative_path ) {
    $file_path = __DIR__ . '/inc/' . $relative_path;

    if ( file_exists( $file_path ) ) {
        require_once $file_path;
    }
}

unset( $child_theme_includes, $relative_path, $file_path );

if ( ! function_exists( 'wp_bootstrap_starter_child_setup' ) ) {
    /**
     * Child theme setup hook.
     */
    function wp_bootstrap_starter_child_setup() {
        load_child_theme_textdomain( 'wp-bootstrap-starter-child', get_stylesheet_directory() . '/languages' );
    }
}
add_action( 'after_setup_theme', 'wp_bootstrap_starter_child_setup' );
