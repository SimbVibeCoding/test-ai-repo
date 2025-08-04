<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php do_action('retina_single_content_before_thumb');?>
	<div class="post-thumbnail">
		<?php the_post_thumbnail(); ?>
	</div>
	<?php do_action('retina_content_before_entry_content');?>
	<div class="entry-content">
		<?php do_action('retina_content_before_entry_header');?>
		
		<?php
      do_action('retina_content_before_content');
        if ( is_single() ) :
			       the_content();
        else :
            the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'wp-bootstrap-starter' ) );
        endif;
        do_action('retina_content_after_content');
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp-bootstrap-starter' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
<?php do_action('retina_content_before_entry_footer');?>
	<footer class="entry-footer">
		<?php wp_bootstrap_starter_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
