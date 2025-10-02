<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package WP_Bootstrap_Starter_Child
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
    return;
}

$layout = get_theme_mod( 'retina_layout', 'right' );

if ( 'none' !== $layout ) :
    ?>
        <aside id="secondary" class="widget-area col-sm-12 col-lg-4" role="complementary">
            <?php dynamic_sidebar( 'sidebar-1' ); ?>
        </aside><!-- #secondary -->
    <?php
endif;
