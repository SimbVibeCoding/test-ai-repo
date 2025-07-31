<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

?>



			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- #content -->
 	<footer id="colophon" class="site-footer <?php echo wp_bootstrap_starter_bg_class(); ?>" role="contentinfo">
      
  <div 
  
    class="wp-block-group full-boxed has-white-color has-text-color has-background has-link-color wp-elements-247159b9ee5108be27366b36de042c19"
>
    <div
        class="wp-block-group__inner-container is-layout-constrained wp-block-group-is-layout-constrained">
        
        <?php display_block_pattern( 'footer' ); ?>

	</footer><!-- #colophon -->
</div><!-- #page -->
  <?php  do_action('bootstrap_child_after_site'); ?>
<?php wp_footer(); ?>
</body>
</html>
