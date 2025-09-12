<?php
/**
 * Header (Shop Full Width)
 *
 * Used only by WooCommerce archive page in the child theme
 * to render a full-width layout without the Bootstrap container.
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
    
</head>
<body <?php body_class(); ?>>
<?php do_action('bootstrap_child_before_site'); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wp-bootstrap-starter-child' ); ?></a>
    <?php if ( ! is_page_template( 'blank-page.php' ) && ! is_page_template( 'blank-page-with-container.php' ) ) : ?>
        <header class="site-header">
            <?php if ( function_exists( 'display_block_pattern' ) ) { display_block_pattern( 'header' ); } ?>
        </header>
        <div id="content" class="site-content">
            <!-- Full-width content: no .container/.row here by design -->
    <?php endif; ?>

