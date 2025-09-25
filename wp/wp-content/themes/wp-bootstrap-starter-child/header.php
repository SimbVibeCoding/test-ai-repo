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

        <div id="ricerca-panel" class="header-search-panel" aria-hidden="true">
            <div class="header-search-panel__inner">
                <button type="button" class="header-search-panel__close" aria-label="<?php esc_attr_e( 'Chiudi la barra di ricerca', 'wp-bootstrap-starter' ); ?>">&times;</button>
                <form role="search" method="get" class="header-search-panel__form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <label for="ricerca-input" class="header-search-panel__label screen-reader-text"><?php esc_html_e( 'Cerca prodotti', 'wp-bootstrap-starter' ); ?></label>
                    <input type="search" id="ricerca-input" name="s" class="header-search-panel__field" placeholder="<?php esc_attr_e( 'Cerca tra i prodotti...', 'wp-bootstrap-starter' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" required />
                    <input type="hidden" name="post_type" value="product" />
                    <?php do_action( 'wpml_add_language_form_field' ); ?>
                    <button type="submit" class="header-search-panel__submit"><?php esc_html_e( 'Cerca', 'wp-bootstrap-starter' ); ?></button>
                </form>
            </div>
        </div>

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
