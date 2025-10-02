<?php
/**
 * Theme footer template.
 *
 * @package WP_Bootstrap_Starter_Child
 */

if ( ! is_page_template( 'blank-page.php' ) && ! is_page_template( 'blank-page-with-container.php' ) ) :
    ?>
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- #content -->
    <?php
endif;
?>

    <footer id="colophon" class="site-footer <?php echo esc_attr( function_exists( 'wp_bootstrap_starter_bg_class' ) ? wp_bootstrap_starter_bg_class() : '' ); ?>" role="contentinfo">
        <?php
        if ( function_exists( 'display_block_pattern' ) ) {
            display_block_pattern( 'footer' );
        }
        ?>
    </footer><!-- #colophon -->
</div><!-- #page -->
<?php do_action( 'bootstrap_child_after_site' ); ?>
<?php wp_footer(); ?>
</body>
</html>

