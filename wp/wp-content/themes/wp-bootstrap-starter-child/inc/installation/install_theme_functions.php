<?php
/**
 * Handles reusable block pattern imports and rendering helpers.
 *
 * @package WP_Bootstrap_Starter_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'WP_BOOTSTRAP_STARTER_CHILD_PATTERN_TRANSIENT' ) ) {
    define( 'WP_BOOTSTRAP_STARTER_CHILD_PATTERN_TRANSIENT', 'wp_bootstrap_starter_child_pattern_messages' );
}

if ( ! defined( 'WP_BOOTSTRAP_STARTER_CHILD_PATTERN_CATEGORY' ) ) {
    define( 'WP_BOOTSTRAP_STARTER_CHILD_PATTERN_CATEGORY', 'simbiosi' );
}

add_action( 'after_switch_theme', 'wp_bootstrap_starter_child_import_patterns_on_activation' );
add_action( 'admin_notices', 'wp_bootstrap_starter_child_admin_pattern_notices' );

if ( ! function_exists( 'wp_bootstrap_starter_child_import_patterns_on_activation' ) ) {
    /**
     * Import block patterns bundled with the child theme.
     */
    function wp_bootstrap_starter_child_import_patterns_on_activation() {
        if ( ! function_exists( 'register_block_pattern' ) ) {
            wp_bootstrap_starter_child_store_pattern_messages( array( 'Block pattern API not available. Enable the block editor to import patterns.' ) );
            return;
        }

        $patterns_dir = trailingslashit( get_stylesheet_directory() ) . 'patterns';

        if ( ! is_dir( $patterns_dir ) ) {
            wp_bootstrap_starter_child_store_pattern_messages( array( 'The pattern directory does not exist: ' . $patterns_dir ) );
            return;
        }

        $pattern_files = glob( $patterns_dir . '/*.json' );

        if ( empty( $pattern_files ) ) {
            wp_bootstrap_starter_child_store_pattern_messages( array( 'No JSON files found in: ' . $patterns_dir ) );
            return;
        }

        register_block_pattern_category(
            WP_BOOTSTRAP_STARTER_CHILD_PATTERN_CATEGORY,
            array( 'label' => __( 'Simbiosi', 'wp-bootstrap-starter-child' ) )
        );

        $messages   = array();
        $messages[] = sprintf( 'Registered pattern category "%s".', WP_BOOTSTRAP_STARTER_CHILD_PATTERN_CATEGORY );

        foreach ( $pattern_files as $file_path ) {
            $pattern_content = file_get_contents( $file_path );

            if ( false === $pattern_content ) {
                $messages[] = 'Unable to read pattern file: ' . $file_path;
                continue;
            }

            $pattern_data = json_decode( $pattern_content, true );

            if ( ! is_array( $pattern_data ) ) {
                $messages[] = 'JSON decode error in ' . $file_path . ': ' . json_last_error_msg();
                continue;
            }

            $title   = isset( $pattern_data['title'] ) ? sanitize_text_field( $pattern_data['title'] ) : '';
            $content = isset( $pattern_data['content'] ) ? $pattern_data['content'] : '';

            if ( '' === $title || '' === $content ) {
                $messages[] = 'Missing title or content in ' . $file_path;
                continue;
            }

            if ( get_page_by_title( $title, OBJECT, 'wp_block' ) ) {
                $messages[] = sprintf( 'Pattern "%s" already exists. Skipping import.', $title );
                continue;
            }

            $post_id = wp_insert_post(
                array(
                    'post_title'   => $title,
                    'post_content' => $content,
                    'post_status'  => 'publish',
                    'post_type'    => 'wp_block',
                ),
                true
            );

            if ( is_wp_error( $post_id ) || ! $post_id ) {
                $messages[] = sprintf( 'Pattern import failed for "%s".', $title );
                continue;
            }

            $pattern_slug = sanitize_title( $title );

            register_block_pattern(
                $pattern_slug,
                array(
                    'title'       => $title,
                    'description' => isset( $pattern_data['description'] ) ? sanitize_text_field( $pattern_data['description'] ) : '',
                    'content'     => $content,
                    'categories'  => array( WP_BOOTSTRAP_STARTER_CHILD_PATTERN_CATEGORY ),
                )
            );

            $messages[] = sprintf( 'Pattern "%s" imported and registered.', $title );
        }

        if ( count( $messages ) === 1 ) {
            $messages[] = 'No patterns were imported.';
        } else {
            $messages[] = 'Pattern import completed.';
        }

        wp_bootstrap_starter_child_store_pattern_messages( $messages );
    }
}

if ( ! function_exists( 'wp_bootstrap_starter_child_store_pattern_messages' ) ) {
    /**
     * Persist import messages in a transient to show them once.
     *
     * @param array $messages Messages to display in wp-admin.
     */
    function wp_bootstrap_starter_child_store_pattern_messages( array $messages ) {
        set_transient( WP_BOOTSTRAP_STARTER_CHILD_PATTERN_TRANSIENT, $messages, MINUTE_IN_SECONDS * 10 );
    }
}

if ( ! function_exists( 'wp_bootstrap_starter_child_admin_pattern_notices' ) ) {
    /**
     * Prints import debug messages in the dashboard when available.
     */
    function wp_bootstrap_starter_child_admin_pattern_notices() {
        $messages = get_transient( WP_BOOTSTRAP_STARTER_CHILD_PATTERN_TRANSIENT );

        if ( empty( $messages ) || ! is_array( $messages ) ) {
            return;
        }

        delete_transient( WP_BOOTSTRAP_STARTER_CHILD_PATTERN_TRANSIENT );

        echo '<div class="notice notice-info is-dismissible"><h3>' . esc_html__( 'Pattern import', 'wp-bootstrap-starter-child' ) . '</h3><ul>';

        foreach ( $messages as $message ) {
            echo '<li>' . esc_html( $message ) . '</li>';
        }

        echo '</ul></div>';
    }
}

if ( ! function_exists( 'display_block_pattern' ) ) {
    /**
     * Outputs a reusable block content by title.
     *
     * @param string $pattern_title Reusable block title.
     */
    function display_block_pattern( $pattern_title ) {
        $pattern_title = sanitize_text_field( $pattern_title );

        if ( '' === $pattern_title ) {
            return;
        }

        $query = new WP_Query(
            array(
                'post_type'      => 'wp_block',
                'post_status'    => 'publish',
                'title'          => $pattern_title,
                'posts_per_page' => 1,
                'no_found_rows'  => true,
            )
        );

        if ( ! $query->have_posts() ) {
            wp_reset_postdata();
            return;
        }

        $query->the_post();

        echo do_blocks( get_the_content() );

        wp_reset_postdata();
    }
}

