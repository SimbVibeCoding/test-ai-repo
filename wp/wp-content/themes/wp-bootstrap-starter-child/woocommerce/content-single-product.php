<?php
/**
 * Single Product content override
 *
 * Custom layout:
 * - Left column: default Woo gallery (thumbnails, zoom, etc.)
 * - Right column: top-level categories (image preferred), title, SKU, attribute values, description, and a CTA button
 * - Below: three blocks rendering ACF fields (scheda_dati, info_tecniche, tablepress)
 * - Finally: product list from same category
 */

defined('ABSPATH') || exit;

global $product;

if (empty($product) || ! $product->is_visible()) {
    return;
}

do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    return;
}

// Helper: get top-level categories associated with this product (de-duplicated)
$product_terms = get_the_terms($product->get_id(), 'product_cat');
$top_level_terms = [];
if (!is_wp_error($product_terms) && !empty($product_terms)) {
    foreach ($product_terms as $term) {
        $ancestors = get_ancestors($term->term_id, 'product_cat');
        if (!empty($ancestors)) {
            $top_id = end($ancestors);
            $top_term = get_term($top_id, 'product_cat');
        } else {
            $top_term = $term;
        }
        if ($top_term && !is_wp_error($top_term)) {
            $top_level_terms[$top_term->term_id] = $top_term; // de-duplicate by ID
        }
    }
}

?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('product product-custom', $product); ?>>
  <!-- Full-width breadcrumbs row -->
  <div class="product-breadcrumbs">
    <div class="container">
      <?php if (function_exists('woocommerce_breadcrumb')) : ?>
        <?php woocommerce_breadcrumb([
          'delimiter'   => ' / ',
          'wrap_before' => '<nav class="woocommerce-breadcrumb" aria-label="Breadcrumbs">',
          'wrap_after'  => '</nav>',
          'home'        => _x('Home', 'breadcrumb', 'woocommerce'),
        ]); ?>
      <?php endif; ?>
    </div>
  </div>
  <div class="container">
    <div class="row align-items-start">
      <!-- Gallery left (default Woo output) -->
      <div class="col-12 col-md-6 order-md-1 product-gallery">
        <?php
        /**
         * This action includes the default WooCommerce product images/gallery
         * (same as classic template):
         * - woocommerce_show_product_images
         */
        do_action('woocommerce_before_single_product_summary');
        ?>
      </div>

      <!-- Summary right -->
      <div class="col-12 col-md-6 order-md-2 product-summary">
        <div class="product-summary__inner">
          <?php if (!empty($top_level_terms)) : ?>
            <div class="product-top-categories">
              <?php foreach ($top_level_terms as $t) :
                  $thumb_id = get_term_meta($t->term_id, 'thumbnail_id', true);
                  $term_link = get_term_link($t, 'product_cat');
                  if (!is_wp_error($term_link)) : ?>
                    <a href="<?php echo esc_url($term_link); ?>" class="product-top-category" title="<?php echo esc_attr($t->name); ?>">
                      <?php if ($thumb_id) :
                          echo wp_get_attachment_image($thumb_id, 'medium', false, [
                              'class' => 'product-cat-thumb',
                              'alt'   => esc_attr($t->name),
                          ]);
                      else : ?>
                          <span class="product-cat-name"><?php echo esc_html($t->name); ?></span>
                      <?php endif; ?>
                    </a>
              <?php endif; endforeach; ?>
            </div>
          <?php endif; ?>

          <h1 class="product_title entry-title"><?php the_title(); ?></h1>

          <?php if ($product->get_sku()) : ?>
            <div class="product-sku">SKU: <span><?php echo esc_html($product->get_sku()); ?></span></div>
          <?php endif; ?>

          <?php
          // Output attribute values as spans with class equal to attribute slug
          $attributes = $product->get_attributes();
          if (!empty($attributes)) : ?>
            <div class="product-attributes">
              <?php foreach ($attributes as $attr) :
                  if ($attr->get_visible() === false) {
                      continue;
                  }
                  $name = $attr->get_name(); // taxonomy (e.g. pa_color) or custom name
                  $slug_class = sanitize_html_class($name);
                  $values = [];
                  if ($attr->is_taxonomy()) {
                      $values = wc_get_product_terms($product->get_id(), $name, ['fields' => 'names']);
                  } else {
                      // Custom attribute values are stored as option IDs or text
                      $values = array_map('wc_clean', $attr->get_options());
                  }
                  foreach ($values as $val) : ?>
                    <span class="<?php echo esc_attr($slug_class); ?> attr-<?php echo esc_attr($slug_class); ?>"><?php echo esc_html($val); ?></span>
                  <?php endforeach; ?>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <?php
          // Product description (short description preferred)
          $short_description = $product->get_short_description();
          if (!empty($short_description)) : ?>
            <div class="product-short-description">
              <?php echo apply_filters('woocommerce_short_description', $short_description); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
          <?php endif; ?>

          <div class="product-cta">
            <a href="#" class="btn btn-primary select-material">Seleziona materiale</a>
          </div>
        </div>
      </div>
    </div>

    <!-- ACF Blocks -->
    <div class="product-acf-blocks">
      <?php if (function_exists('get_field')) : ?>
        <?php $scheda = get_field('scheda_dati'); if (!empty($scheda)) : ?>
          <div class="product-block product-block--scheda-dati">
            <?php echo apply_filters('the_content', $scheda); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
          </div>
        <?php endif; ?>

        <?php $info = get_field('info_tecniche'); if (!empty($info)) : ?>
          <div class="product-block product-block--info-tecniche">
            <?php echo apply_filters('the_content', $info); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
          </div>
        <?php endif; ?>

        <?php $tablepress = get_field('tablepress'); if (!empty($tablepress)) : ?>
          <div class="product-block product-block--tablepress">
            <?php echo apply_filters('the_content', $tablepress); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
          </div>
        <?php endif; ?>
      <?php endif; ?>
    </div>

    <!-- Products from same category -->
    <?php
    // Build a list of category IDs to query related products
    $cat_ids = [];
    if (!empty($top_level_terms)) {
        $cat_ids = array_map(static function($t){ return (int) $t->term_id; }, $top_level_terms);
    } elseif (!is_wp_error($product_terms) && !empty($product_terms)) {
        $cat_ids = array_map(static function($t){ return (int) $t->term_id; }, $product_terms);
    }

    if (!empty($cat_ids)) {
        $args = [
            'post_type'           => 'product',
            'posts_per_page'      => 12,
            'post__not_in'        => [get_the_ID()],
            'ignore_sticky_posts' => 1,
            'tax_query'           => [
                [
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $cat_ids,
                ],
            ],
        ];
        $related = new WP_Query($args);
        if ($related->have_posts()) : ?>
          <section class="related-by-category">
            <h2 class="section-title">Prodotti nella stessa categoria</h2>
            <?php woocommerce_product_loop_start(); ?>
            <?php while ($related->have_posts()) : $related->the_post(); ?>
              <?php wc_get_template_part('content', 'product'); ?>
            <?php endwhile; ?>
            <?php woocommerce_product_loop_end(); ?>
          </section>
        <?php endif; wp_reset_postdata();
    }
    ?>

  </div>
</div>

<?php do_action('woocommerce_after_single_product'); ?>
