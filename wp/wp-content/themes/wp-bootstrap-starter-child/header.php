<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
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
  <?php  do_action('bootstrap_child_before_site'); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wp-bootstrap-starter' ); ?></a>
    <?php if(!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' )): ?>
      <header class="site-header">  

        <?php display_block_pattern( 'header' ); ?>

        </header><!-- #masthead -->

        <?php
        // Hero header for all pages except the front page
        if ( is_page() && ! is_front_page() ) :
            $featured_img_url = get_the_post_thumbnail_url( get_queried_object_id(), 'full' );
        ?>
            <div class="page-hero" <?php if ( $featured_img_url ) : ?>style="background-image: url('<?php echo esc_url( $featured_img_url ); ?>');"<?php endif; ?>>
                <div class="page-hero__inner">
                    <h1 class="page-hero__title"><?php echo esc_html( get_the_title( get_queried_object_id() ) ); ?></h1>
                </div>
            </div>
        <?php endif; ?>
    
	<div id="content" class="site-content">
		<div class="container">
			<div class="row">
                <?php endif; ?>
