<?php
/**
 * WooCommerce Product Archive (Shop + Category) Template
 *
 * Custom layout with:
 * - Hero header (no background image here; add via CSS later)
 * - Left sidebar: top-level categories (icon + name) and subcategories of current category
 * - Right content: standard WooCommerce product loop for current query
 *
 * No CSS included; only PHP + HTML as requested.
 */

defined( 'ABSPATH' ) || exit;

// Load site header
// Use a special full-width header just for the archive page
get_header( 'shop-full' );

// Resolve WPML-translated strings using the same domain used elsewhere in the theme
$domain = 'wp-bootstrap-starter-child';

// Ensure strings are registered for WPML String Translation
do_action( 'wpml_register_single_string', $domain, 'shop_hero_title', 'Prodotti' );
do_action( 'wpml_register_single_string', $domain, 'shop_hero_intro', 'Progettiamo e realizziamo raccorderia tecnica per reti idriche, gas, irrigazione, fognature, impianti antincendio ed energie alternative. Ogni settore richiede soluzioni specifiche; per questo offriamo una gamma completa di prodotti affidabili, personalizzabili e conformi alle normative, pensata per installatori, progettisti e operatori del settore.' );
do_action( 'wpml_register_single_string', $domain, 'shop_sidebar_filter_title', 'Filtra prodotti' );
do_action( 'wpml_register_single_string', $domain, 'shop_sidebar_sectors_title', 'Settori prodotto' );
do_action( 'wpml_register_single_string', $domain, 'shop_sidebar_subcategories_title', 'Sottocategorie' );

// Register defaults (actual registration happens in functions.php, this is a fallback)
$hero_title_default   = 'Prodotti';
$hero_intro_default   = 'Progettiamo e realizziamo raccorderia tecnica per reti idriche, gas, irrigazione, fognature, impianti antincendio ed energie alternative. Ogni settore richiede soluzioni specifiche; per questo offriamo una gamma completa di prodotti affidabili, personalizzabili e conformi alle normative, pensata per installatori, progettisti e operatori del settore.';
$sidebar_filter_title = 'Filtra prodotti';
$sidebar_sectors      = 'Settori prodotto';
$sidebar_subcats      = 'Sottocategorie';

// Fetch translated strings via WPML if available; gracefully fallback otherwise
$hero_title = esc_html( apply_filters( 'wpml_translate_single_string', $hero_title_default, $domain, 'shop_hero_title' ) );
$hero_intro = esc_html( apply_filters( 'wpml_translate_single_string', $hero_intro_default, $domain, 'shop_hero_intro' ) );
$t_filter   = esc_html( apply_filters( 'wpml_translate_single_string', $sidebar_filter_title, $domain, 'shop_sidebar_filter_title' ) );
$t_sectors  = esc_html( apply_filters( 'wpml_translate_single_string', $sidebar_sectors, $domain, 'shop_sidebar_sectors_title' ) );
$t_subcats  = esc_html( apply_filters( 'wpml_translate_single_string', $sidebar_subcats, $domain, 'shop_sidebar_subcategories_title' ) );

// Helper: current queried product category (if any)
$current_term = null;
if ( is_product_category() ) {
    $qo = get_queried_object();
    if ( $qo && ! is_wp_error( $qo ) && isset( $qo->term_id ) ) {
        $current_term = $qo;
    }
}

// Fetch top-level product categories (Sectors)
$top_level_cats = get_terms( array(
    'taxonomy'   => 'product_cat',
    'parent'     => 0,
    'hide_empty' => false,
    'orderby'    => 'name',
    'order'      => 'ASC',
));

// Fetch subcategories of the current category, if present
$child_cats = array();
if ( $current_term ) {
    $child_cats = get_terms( array(
        'taxonomy'   => 'product_cat',
        'parent'     => (int) $current_term->term_id,
        'hide_empty' => false,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ));
}
?>

<div class="macplast-shop" role="main">
    <header class="shop-hero" aria-labelledby="shop-hero-title">
        <div class="shop-hero__inner">
            <h1 id="shop-hero-title"><?php echo $hero_title; ?></h1>
            <p class="shop-hero__intro"><?php echo $hero_intro; ?></p>
        </div>
    </header>

    <div class="shop-layout">
        <aside class="shop-sidebar" aria-labelledby="shop-sidebar-title">
            <div class="shop-sidebar__inner">
                <h2 id="shop-sidebar-title"><?php echo $t_filter; ?></h2>

                <section class="shop-sidebar__sectors" aria-labelledby="shop-sectors-title">
                    <h3 id="shop-sectors-title"><?php echo $t_sectors; ?></h3>
                    <?php if ( ! empty( $top_level_cats ) && ! is_wp_error( $top_level_cats ) ) : ?>
                        <ul class="shop-sectors__list">
                            <?php foreach ( $top_level_cats as $term ) : ?>
                                <?php
                                $thumb_id = (int) get_term_meta( $term->term_id, 'thumbnail_id', true );
                                $img      = $thumb_id ? wp_get_attachment_image( $thumb_id, 'thumbnail', false, array(
                                    'alt'   => esc_attr( $term->name ),
                                    'class' => 'shop-sectors__icon'
                                )) : '';
                                $link     = get_term_link( $term );
                                ?>
                                <li class="shop-sectors__item">
                                    <a class="shop-sectors__link" href="<?php echo esc_url( $link ); ?>">
                                        <?php if ( $img ) { echo $img; } // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                        <span class="shop-sectors__name"><?php echo esc_html( $term->name ); ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </section>

                <?php if ( $current_term && ! empty( $child_cats ) && ! is_wp_error( $child_cats ) ) : ?>
                    <section class="shop-sidebar__subcats" aria-labelledby="shop-subcats-title">
                        <h3 id="shop-subcats-title"><?php echo $t_subcats; ?></h3>
                        <ul class="shop-subcats__list">
                            <?php foreach ( $child_cats as $child ) : ?>
                                <li class="shop-subcats__item">
                                    <a class="shop-subcats__link" href="<?php echo esc_url( get_term_link( $child ) ); ?>">
                                        <span class="shop-subcats__name"><?php echo esc_html( $child->name ); ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                <?php endif; ?>
            </div>
        </aside>

        <section class="shop-content" aria-label="Products">
            <?php if ( woocommerce_product_loop() ) : ?>
                <?php do_action( 'woocommerce_before_shop_loop' ); ?>

                <?php woocommerce_product_loop_start(); ?>

                <?php if ( wc_get_loop_prop( 'total' ) ) : ?>
                    <?php while ( have_posts() ) : ?>
                        <?php the_post(); ?>
                        <?php do_action( 'woocommerce_shop_loop' ); ?>
                        <?php wc_get_template_part( 'content', 'product' ); ?>
                    <?php endwhile; ?>
                <?php endif; ?>

                <?php woocommerce_product_loop_end(); ?>

                <?php do_action( 'woocommerce_after_shop_loop' ); ?>
            <?php else : ?>
                <?php do_action( 'woocommerce_no_products_found' ); ?>
            <?php endif; ?>
        </section>
    </div>
</div>

<?php
// Load site footer
// Use the matching full-width footer
get_footer( 'shop-full' );
?>
