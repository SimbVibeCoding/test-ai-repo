<?php


//create_menu($menus);

function retina_register_menus($names){
  if(is_array($names)){
    foreach($names as $name){
      retina_register_custom_nav_menu($name);
    }
  }elseif(is_string($names)){
    retina_register_custom_nav_menu($names);
  }else{
    retina_register_custom_nav_menu('pippo');
  }
}

function retina_register_custom_nav_menu($name){
  register_nav_menus(
    array(
      'menu-'.$name => __('Menu '.$name)
    )
  );
}
/**
 * [retina_create_custom_nav description]
 * @method retina_create_custom_nav
 * 'menu' (int|string|WP_Term) Desired menu. Accepts a menu ID, slug, name, or object.
 *  'menu_class'  *  (string) CSS class to use for the ul element which forms the menu. Default 'menu'.
  * 'menu_id'   * (string) The ID that is applied to the ul element which forms the menu. Default is the menu slug, incremented.
  * 'container'   * (string) Whether to wrap the ul, and what to wrap it with. Default 'div'.
  * 'container_class'   * (string) Class that is applied to the container. Default 'menu-{menu slug}-container'.
  * 'container_id'   * (string) The ID that is applied to the container.
  * 'fallback_cb'   * (callable|bool) If the menu doesn't exists, a callback function will fire. Default is 'wp_page_menu'. Set to false for no fallback.
  * 'before' (string) Text before the link markup.
  * 'after'  (string) Text after the link markup.
  * 'link_before' (string) Text before the link text.
  * 'link_after'   * (string) Text after the link text.
  * 'echo'   * (bool) Whether to echo the menu or return it. Default true.
  * 'depth'   * (int) How many levels of the hierarchy are to be included. 0 means all. Default 0.
  * 'walker'   * (object) Instance of a custom walker class.
  * 'theme_location'   * (string) Theme location to be used. Must be registered with register_nav_menu() in order to be selectable by the user.
  * 'items_wrap'   * (string) How the list items should be wrapped. Default is a ul with an id and class. Uses printf() format with numbered placeholders.
  * 'item_spacing'   * (string) Whether to preserve whitespace within the menu's HTML. Accepts 'preserve' or 'discard'. Default 'preserve'.
 * @param  [string, array]                   $name [description]
 * @return [menu]                         [description]
 */
function retina_create_custom_nav($name) {
  wp_nav_menu( array(
    'theme_location'   => 'menu-'.$name,
    'fallback_cb' => 'false',
    'menu_id' => 'menu-custom-'.$name,
    'container_class' => 'menu-custom-container',
    'container_id' => 'menu-custom-conteiner-'.$name,
    'link_before' => '',
    'link_after' => '',
    'before' => '',
    'after' => '',
    //'echo' => false, //Whether to echo the menu or return it. Default true.
  ));
}

// aggiungo pagine di woocommerce ad un menu
function add_loginout_link( $items, $args ) {
   if ($args->theme_location == 'menu-contatti') {
     //var_dump($items);
     if (is_user_logged_in() ) {
         $items .= '<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-type-custom-woocommerce  menu-item-type-custom-woocommerce-login"><a href="'. wp_logout_url( get_permalink( woocommerce_get_page_id( 'myaccount' ) ) ) .'">Log Out</a></li>';
     }
     elseif (!is_user_logged_in() ) {
         $items .= '<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-type-custom-woocommerce  menu-item-type-custom-woocommerce-login"><a href="' . get_permalink( woocommerce_get_page_id( 'myaccount' ) ) . '">'.__('Accedi').'</a></li>';
     }
     //$items .= '<li><a href="'. WC()->cart->get_cart_url().'">Cart</a></li>';
    if (WC()->cart->cart_contents_count ) {
       $items .= '<li class="cart_totals menu-item menu-item-type-custom menu-item-object-custom menu-item-type-custom-woocommerce menu-item-type-custom-woocommerce-cart"><a href="'. WC()->cart->get_cart_url().'">Cart '.WC()->cart->get_cart_total().'<i >'.WC()->cart->cart_contents_count.'</i></a></li>';
     }else{
        $items .= '<li class "empty-cart menu-item menu-item-type-custom menu-item-object-custom menu-item-type-custom-woocommerce menu-item-type-custom-woocommerce-cart">'.__('il tuo carrello è vuoto', 'storefront-child').'</li>';
     }
   }

   return $items;

}
function wp_filter_GetNavMenuItems( $items, $menu, $args ) {
  if("principale" == $menu->slug):
    //var_dump($items[0]);
   foreach($items as $key=>$value):
       //var_dump($value->object);
   endforeach;
   return $items;
 endif;
}

 //add_filter( "wp_get_nav_menu_items", 'wp_filter_GetNavMenuItems', 10, 3 );

 //(wp_get_nav_menu_items("principale"), array());



// MANIPOLAZIONE OUTPUT EL MENU USANDO IL WOLKER DEFAULT
  // add_filter( 'wp_setup_nav_menu_item', 'retina_wp_setup_nav_menu_item' );//Decorates a menu item object with the shared navigation menu item properties.: https://developer.wordpress.org/reference/functions/wp_setup_nav_menu_item/
  // add_filter( 'nav_menu_link_attributes','retina_nav_menu_link_attributes_filter' , 10, 4 );//https://developer.wordpress.org/reference/hooks/nav_menu_link_attributes/
  // add_filter( 'nav_menu_item_title', 'retina_nav_menu_item_title_filter' , 10, 4 );//https://developer.wordpress.org/reference/hooks/nav_menu_item_title/
  // add_filter( 'manage_nav-menus_columns',  'retina_nav_menu_manage_columns' , 11 );// ????????????

//
//  function retina_wp_setup_nav_menu_item( $menu_item  ) {
//    /**
//     *
//     * @param object $menu_item
//     * */
//        //var_dump($menu_item  );
//        return($menu_item);
// }
//  function retina_nav_menu_link_attributes_filter(  $atts,  $item,  $args,  $depth  ) {
//    /**
//     *
//     * @param array $atts
//     * @param WP_Post $item
//     * @param stdClass $args
//     * @param int $depth
//     *
//     */
//     // var_dump($atts );
//     // var_dump($item );
//     // var_dump($args );
//     // var_dump($depth );
//
//     return($item);
// }
// function retina_nav_menu_item_title_filter(  $title,  $item,  $args,  $depth  ) {
//   /**
//   *
//   * @param string $title
//   * @param WP_Post $item
//   * @param stdClass $args
//   * @param int $depth
//   *
//   */
//   return($title);
// }
//  function retina_nav_menu_manage_columns(    ) {
//    /**
//     *
//     * @param string $title
//     * @param WP_Post $item
//     * @param stdClass $args
//     * @param int $depth
//     *
//     */
//      return($columns);
// }
//

 // override storefront primary menu
 function storefront_primary_navigation() {
   ?>
   <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'storefront' ); ?>">
   <button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false"><span><?php echo esc_attr( apply_filters( 'storefront_menu_toggle_text', __( 'Menu', 'storefront' ) ) ); ?></span></button>
     <?php
     wp_nav_menu(
       array(
         'theme_location'  => 'primary',
         'container_class' => 'primary-navigation',
         'walker' => new retina_Walker()
       )
     );

     wp_nav_menu(
       array(
         'theme_location'  => 'handheld',
         'container_class' => 'handheld-navigation',
       )
     );
     ?>
   </nav><!-- #site-navigation -->
   <?php
 }

 //https://codex.wordpress.org/Class_Reference/Walker
 class retina_Walker extends Walker_Nav_Menu {
   // function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) {
   //     var_dump($output);
   // }
 }
