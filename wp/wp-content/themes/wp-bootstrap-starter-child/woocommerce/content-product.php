<?php
/**
 * Template part for displaying products in a loop.
 *
 * Place this file in your child theme at:
 * wp-content/themes/your-child-theme/woocommerce/content-product.php
 *
 * Markup tailored for image + hr + title + CTA, with parent category icons
 * and a conditional "Novità" badge for products published within 30 days.
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

// Helper: detect if product is new (<= 30 days old)
$is_new = false;
$post_date_gmt = get_post_field( 'post_date_gmt', $product->get_id() );
if ( $post_date_gmt ) {
    $timestamp = strtotime( $post_date_gmt . ' GMT' );
    if ( $timestamp ) {
        $is_new = ( time() - $timestamp ) <= ( 30 * DAY_IN_SECONDS );
    }
}

// Build list of unique top-level (root) categories assigned to the product
$root_parent_terms = array();
$terms = get_the_terms( $product->get_id(), 'product_cat' );
if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
    foreach ( $terms as $term ) {
        $root = $term;
        // climb to root parent
        while ( $root && $root->parent ) {
            $root = get_term( (int) $root->parent, 'product_cat' );
            if ( is_wp_error( $root ) ) {
                break;
            }
        }
        if ( $root && ! is_wp_error( $root ) ) {
            $root_parent_terms[ $root->term_id ] = $root; // de-duplicate by key
        }
    }
}

// Translatable strings (WPML-friendly via String Translation, fallback to gettext)
$label_new_raw  = apply_filters( 'wpml_translate_single_string', 'Novità', 'macplast-theme', 'product_badge_new' );
$label_more_raw = apply_filters( 'wpml_translate_single_string', 'Scopri di più', 'macplast-theme', 'product_card_cta' );
$label_new  = esc_html( $label_new_raw );
$label_more = esc_html( $label_more_raw );

// Override domain to the child theme and (re)register strings for WPML
$__wpml_domain = 'wp-bootstrap-starter-child';
do_action( 'wpml_register_single_string', $__wpml_domain, 'product_badge_new', 'Novità' );
do_action( 'wpml_register_single_string', $__wpml_domain, 'product_card_cta', 'Scopri di più' );
$label_new_raw  = apply_filters( 'wpml_translate_single_string', 'Novità', $__wpml_domain, 'product_badge_new' );
$label_more_raw = apply_filters( 'wpml_translate_single_string', 'Scopri di più', $__wpml_domain, 'product_card_cta' );
$label_new      = esc_html( $label_new_raw );
$label_more     = esc_html( $label_more_raw );
?>

<li <?php wc_product_class( 'product-card', $product ); ?>>
    <div class="product-card__inner">
        <div class="product-card__media">
            <?php if ( $is_new ) : ?>
                <span class="product-card__badge" aria-label="<?php echo esc_attr( $label_new ); ?>"><?php echo esc_html( $label_new ); ?></span>
            <?php endif; ?>

            <?php if ( ! empty( $root_parent_terms ) ) : ?>
                <div class="product-card__icons" aria-hidden="true">
                    <?php foreach ( $root_parent_terms as $root_term ) : ?>
                        <?php
                        $thumb_id = get_term_meta( $root_term->term_id, 'thumbnail_id', true );
                        $icon     = $thumb_id ? wp_get_attachment_image( $thumb_id, 'thumbnail', false, array(
                            'class' => 'product-card__cat-icon',
                            'alt'   => esc_attr( $root_term->name )
                        ) ) : '';
                        if ( $icon ) {
                            echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        }
                        ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <a class="product-card__image-link" href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                <div class="product-card__image">
                    <?php
                    // Show only the main (featured) image at original size
                    if ( has_post_thumbnail( $product->get_id() ) ) {
                        echo get_the_post_thumbnail( $product->get_id(), 'full' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    } else {
                        echo wc_placeholder_img( 'full' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    }
                    ?>
                </div>
            </a>
        </div>

        <hr class="product-card__divider" />

        <div class="product-card__content">
            <h2 class="product-card__title woocommerce-loop-product__title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h2>
            <div class="button-azzurro product-card__cta">
                 <a href="<?php the_permalink(); ?>"><?php echo esc_html( $label_more ); ?></a>
            </div>
        </div>
    </div>
</li>
