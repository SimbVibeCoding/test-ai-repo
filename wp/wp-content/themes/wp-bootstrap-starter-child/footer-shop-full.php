<?php
/**
 * Footer (Shop Full Width)
 *
 * Companion to header-shop-full.php. Closes only #content (no row/container)
 * and renders the site footer.
 */
?>
        </div><!-- #content -->
        <footer id="colophon" class="site-footer <?php echo wp_bootstrap_starter_bg_class(); ?>" role="contentinfo">
            <div class="wp-block-group full-boxed has-white-color has-text-color has-background has-link-color">
                <div class="wp-block-group__inner-container is-layout-constrained wp-block-group-is-layout-constrained">
                    <?php if ( function_exists( 'display_block_pattern' ) ) { display_block_pattern( 'footer' ); } ?>
                </div>
            </div>
        </footer><!-- #colophon -->
    </div><!-- #page -->
<?php do_action('bootstrap_child_after_site'); ?>
<?php wp_footer(); ?>
</body>
</html>

