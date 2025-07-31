<?php
function post_list_shortcode($atts, $content = null)
{

  global $post;

  $atts = shortcode_atts(
      array(
    'max' => '-1',
    'taxonomy' => '',
    'post_type'=>'post',
    'post_status' => 'publish',
    'offset'=>0,
	'meta_key'=> null,
    'orderby' => 'date',
    'order' => 'DESC',
    'container_custom_classes' => '',
    'container_custom_id' => '',
    'item_custom_classes' => 'item-list ',
    'template' => 'shortcode-loop',
    'category_name' => '',
    'category_id' => '',
    'category__in' => '',
    'category__not_in' => '',
    'post__not_in'=> null,
    'post__in'=>null,
    'background_image' =>1,
    'thumb_size' => 'shortcode',
    'exclude_current'=>0,
    'columns' => 3,
    'slide' =>false,

     'item_per_slide' =>9,
       ),
      $atts,
      'elenco_post'
  );
  $atts['slide'] = filter_var($atts['slide'],FILTER_VALIDATE_BOOLEAN);
  $atts['background_image'] = filter_var($atts['background_image'],FILTER_VALIDATE_BOOLEAN);
  $atts['exclude_current'] = filter_var($atts['exclude_current'],FILTER_VALIDATE_BOOLEAN);


  $term = get_term_by( 'name',$atts['category_name'], $atts['taxonomy'] );
  $status = explode(',', $atts['post_status']);
  $post_type = (isset($atts['post_type']) && strlen($atts['post_type']))?explode(',', $atts['post_type']):array('post');

  $category__not_in = (isset($atts['category__not_in']) && strlen($atts['category__not_in']))?explode(',', $atts['category__not_in']):array();
  $category__in = (isset($atts['category__in']) && strlen($atts['category__in']))?explode(',', $atts['category__in']):array();
  $post__not_in = (isset($atts['post__not_in']) && strlen($atts['post__not_in']))?explode(',', $atts['post__not_in']):array();
  $post__in = (isset($atts['post__in']) && strlen($atts['post__in']))?explode(',', $atts['post__in']):array();
  $category__name = (isset($atts['category_name']) && strlen($atts['category_name']))?explode(',', $atts['category_name']):array();
  $taxonomy= (isset($atts['taxonomy']) && strlen($atts['taxonomy']))?$atts['taxonomy']:'cat-business-area';
  $thumbsize = $atts['thumb_size'];

  $args = array(
    //(isset($atts['xxx']) && strlen($atts['xxx']))?
    'post_type'=>$post_type,
    'posts_per_page'=>(isset($atts['max']) && strlen($atts['max']))?$atts['max']:-1,
    'category_id'=>(isset($atts['category_id']) && strlen($atts['category_id']))?$atts['category_id']:'',
    'orderby'=>(isset($atts['orderby']) && strlen($atts['orderby']))?$atts['orderby']:'',
    'order'=>(isset($atts['order']) && strlen($atts['order']))?$atts['order']:'',
	//  'orderby'=>'meta_value_num ',
    //'order'=>'ASC',
		//'meta_key'=>$atts['meta_key'],
    'post_status' =>$status,
    'paged' => '1',
    'offset'=>$atts['offset'],
    'post__in'=>$post__in,
    'post__not_in'=>$post__not_in,

  );
if (isset($atts['meta_key']) && strlen($atts['meta_key'])) {
    $args['meta_key' ] = $atts['meta_key'];
    };
  if (!isset($atts['exclude_current']) && !$atts['exclude_current']) {
    $args['post__not_in'] = array($post->ID);
  }

  if (isset($atts['category__in']) && strlen($atts['category__in'])) {
      $args['tax_query'] = array(
          array(
              'taxonomy' =>$taxonomy,
              'field' => 'term_id',
              'terms' => $category__in,
          ),
      );
  };

  if (isset($atts['category_name']) && strlen($atts['category_name'])) {
      $args['tax_query'] = array(
          array(
              'taxonomy' =>$taxonomy,
              'field' => 'slug',
              'terms' => $category__name,
          ),
      );
  };
   if (isset($atts['meta_key']) && strlen($atts['meta_key'])) {

   }
  $content = '';

  $query = new WP_Query($args);
  $content='';
  //((bool) $atts['background_image'])?'background-image':''


 if($atts['background_image']){
   $atts['container_custom_classes'] = $atts['container_custom_classes']." background-image";
 }
 if($atts['slide']){
   $i=$atts['item_per_slide'];
    $atts['container_custom_classes'] = $atts['container_custom_classes']." paginate-slide";
 }

  $content .='<div id="'.$atts['container_custom_id'].'" class="shortcode post-list '. $atts['post_type'] ." ".$atts['container_custom_classes'].'">';
  if ($query->have_posts()) {
    //$content .='<div class="row">';
    // Start looping over the query results.
    if ('' != locate_template('template-parts/'.$atts['template'].'.php')){
      if($atts['slide']){
        $newslide=true;
        $content .="<div class = slide>";
      }
      while ($query->have_posts()) {
        if($atts['slide']){
          $i--;
        }
        $query->the_post();
       //var_dump($atts['post__in']);
       if (isset($atts['taxonomy'])&& strlen($atts['taxonomy'])) {
         $terms = wp_get_post_terms(get_the_ID(), $atts['taxonomy']);
         if (count($terms)) {
            $term =$terms[0];
            if(  class_exists('ACF') ) :
              $color =  get_field('colore', $term);
            endif;
         }
       }
       ob_start();
       include(locate_template('template-parts/'.$atts['template'].'.php'));
       $content .= ob_get_clean();
       // Contents of the queried post results go here.
        if($atts['slide']){
         if(0 ===$i){
           $i=$atts['item_per_slide'];
           $content .="</div><!-- chiudi slide-->";
           $content .="<div class = slide>";
         }
       }
      }
      if($atts['slide']){
        $content .="</div><!-- chiudi slide-->";
      }

    }else{
      echo 'verificare che il template template-parts/'.$atts['template'].' esista';
      //$content .='</div><!-- end loop row -->';
    };
    wp_reset_query();
    wp_reset_postdata();
  }else{
    ?>
    <span class="message"> Non ci sono articoli per la categoria   <?php //echo $atts['category_name']; ?></span>
    <?php
  }
  $content .='</div><!-- end shortcode -->';
  apply_filters('after_shortcode_container',$content );

  return $content;
}
add_shortcode('post_list_shortcode', 'post_list_shortcode');

function get_categories_with_image($atts, $content = null)
{
    $atts = shortcode_atts(array(
    'max' => '99',
    'columns' => '3',
    'depth' => '2',
    'show_posts' => false,
    'post_type' => 'post',
    'taxonomy' => 'category',
    'category_name' => '',
    'parent' => '0',
    'hide_empty' => false,
    'exclude' => null,
    'include' => null,
    'fields' => 'all',
    'template' => 'shortcode-category-loop',
    'image_size' => 'thumbnail',
    'background_image' => true,
    'thumb_size' => 'shortcode',
    'exclude_current' =>false,
    'slide' =>true,
    'item_per_slide' =>9,
    'container_custom_classes' => 'shortcode cat-list',
    'meta_key'          => null,
    'orderby'           => 'meta_value_num',
    'order'             => 'ASC',
    ), $atts, 'categories_list_shortcode');

    if($atts['exclude'])$exclude = explode(',', $atts['exclude']);
    if($atts['include'])$include = explode(',', $atts['include']);
    // TODO rendere multilingia gli id passati come parametri
    $args=array(
    'taxonomy' => $atts['taxonomy'],
    'fields' => $atts['fields'],
    'hide_empty' => (bool)$atts['hide_empty'],
    'include' =>$include,
    'exclude' =>'3,4,5',
    'parent' => apply_filters( 'wpml_object_id',$atts['parent'],$atts['taxonomy'] ),
    'name'=> $atts['category_name'],
    'number'=> $atts['max'],
  );
  $atts['slide'] = filter_var($atts['slide'],FILTER_VALIDATE_BOOLEAN);
  $atts['background_image'] = filter_var($atts['background_image'],FILTER_VALIDATE_BOOLEAN);
  $atts['exclude_current'] = filter_var($atts['exclude_current'],FILTER_VALIDATE_BOOLEAN);

  if (isset($atts['meta_key']) && strlen($atts['meta_key'])) {
    $args['meta_key' ] = $atts['meta_key'];
    $args['orderby' ] = $atts['orderby'];
    $args['order'  ]  = $atts['order'];
  };
  $thumbsize = $atts['thumb_size'];
  var_dump($args);
  $terms = get_terms( $args );

   if($atts['background_image']){
        $atts['container_custom_classes'] = $atts['container_custom_classes']." background-image";
      }
  $content = '<div  class="shortcode post-list custom-shortcode '.$atts['container_custom_classes'].' ">';
  foreach( $terms as $term ) :


    $inhome= get_field('evidenza',$term);
    $image =  get_field('immagine',$term);
    $color =  get_field('colore',$term);
    $image_size =  $atts['image_size'];
    $children = get_term_children( $term->term_id,  $atts['taxonomy'] );
      if( '' != locate_template( 'template-parts/'.$atts['template'].'.php' ) ):
        ob_start();
        include(locate_template('template-parts/'.$atts['template'].'.php'));
        $content .= ob_get_clean();
      else:
        echo 'verificare che il template template-parts/'.$atts['template'].' esista';
      endif;

    endforeach;
    $content .='</div>';
    wp_reset_query();
 return $content;
}
add_shortcode('categories_list_shortcode', 'get_categories_with_image');



add_shortcode('retina-shortcode-header-image', 'retina_header_image');
function retina_header_image($atts, $content = null){
  global $post;

  $atts = shortcode_atts(array(
    'template' => 'shortcode-header-image',
    'container_custom_classes' => 'retina-shortcode-header-image',
    ), $atts, 'retina-shortcode-header-image');

    $content = '<div  class="custom-shortcode '.$atts['container_custom_classes'].' ">';
  if( '' != locate_template( 'template-parts/'.$atts['template'].'.php' ) ):
    ob_start();
    include(locate_template('template-parts/'.$atts['template'].'.php'));
    $content .= ob_get_clean();
  else:
    echo 'verificare che il template template-parts/'.$atts['template'].' esista';
  endif;
  $content .='</div>';
 return $content;
}


add_shortcode('my-login-form', 'my_login_form_shortcode');
function my_login_form_shortcode($atts=null)
{

  $atts = shortcode_atts(array(
      'form_id' => 'loginform',
      'form_title' => __('Accedi','wp-bootstrap-child'),
    ), $atts, 'my_login_form_shortcode');

    if (is_user_logged_in()) {
      /*
      TODO: crare html per utenti loggati, meglio sarebbe un apply_filter
       */
        return '';
    }
    $html='  <div class="login-form">';

    $html .=  '<div class="login-form-intro"><h3>';
    $title = apply_filters("form_login_header",__('Non sei autorizzato, devi effettuare il login', 'wp-bootstrap-child'));
    if($atts['form_title']){
      $title = $atts['form_title'];
      //var_dump($atts['form_title'])
    }
    $html .=    __($title,'wp-bootstrap-child');
    $html .=  '</h3></div>';
    $html .=  '<div class="login-form-content">';
    $html .=      wp_login_form(array( 'echo' => false , 'form_id' => $atts['form_id'] ));
    $html .='  </div>
            </div>
          ';
    return $html;
}



add_shortcode('ACF-gallery-slider', 'slider_from_image_array');
function slider_from_image_array($atts){
  $atts = shortcode_atts(
      array(
        'acf_field'=>'slider',
        'container_custom_classes' => 'shortcode slider-image-gallery slider',
        'container_custom_id' => '',
        'item_custom_classes' => 'item-list',
        'template' => 'shortcode-loop_image_array',
       'background_image' => true,
       'thumb_size' => 'thumb'
  ),
      $atts
  );
  $slider=get_field($atts['acf_field']);
  $content = '<div  class="custom-shortcode '.$atts['container_custom_classes'].' ">';
  if($slider){
      if ('' != locate_template('template-parts/'.$atts['template'].'.php')):
        foreach($slider as $slide){


           ob_start();
           include(locate_template('template-parts/'.$atts['template'].'.php'));
           $content .= ob_get_clean();
       }
      else:
       echo 'verificare che il template template-parts/'.$atts['template'].' esista';
      endif;
  }else{

   $content .='<span class="message"> Non ci sono articoli per la categoria</span>';

  }
  $content .='</div><!-- end shortcode -->';
  return $content;
}

add_shortcode('retina_page_list', 'retina_page_list');

function retina_page_list($atts, $content = null){
  global $post;
  if(is_page()){
    if(get_pages( array( 'child_of' => $post->ID) )){
      $atts = shortcode_atts(
          array(
          'number' => '0',
          //(int) The number of pages to return. Default 0, or all pages.
          'parent' => $post->ID,
          // (int) Page ID to return direct children of. Default -1, or no restriction.
          'template' => 'shortcode-pages-loop',
          'container_custom_classes' => '',
          'container_custom_id' => '',
          'item_custom_classes' => 'item-list',
          'child_of'=>$post->ID,
          // (int) Page ID to return child and grandchild pages of. Note: The value of $hierarchical has no bearing on whether $child_of returns hierarchical results. Default 0, or no restriction.
          'sort_order'=> '',
          // (string) How to sort retrieved pages. Accepts 'ASC', 'DESC'. Default 'ASC'.
          'sort_column'=> '',
          // (string) What columns to sort pages by, comma-separated. Accepts 'post_author', 'post_date', 'post_title', 'post_name', 'post_modified', 'menu_order', 'post_modified_gmt', 'post_parent', 'ID', 'rand', 'comment*count'. 'post*' can be omitted for any values that start with it. Default 'post_title'.
          'hierarchical'=> 'false',
          // (bool) Whether to return pages hierarchically. If false in conjunction with $child_of also being false, both arguments will be disregarded. Default true.
          'exclude'=> '',
          // (int[]) Array of page IDs to exclude.
          'include'=> '',
          // (int[]) Array of page IDs to include. Cannot be used with $child_of, $parent, $exclude, $meta_key, $meta_value, or $hierarchical.
          'meta_key'=> '',
          // (string) Only include pages with this meta key.
          'meta_value'=> '',
          // (string) Only include pages with this meta value. Requires $meta_key.
          'authors' => '',
          // (string) A comma-separated list of author IDs.
          'exclude_tree' => '',
          // (string|int[]) Comma-separated string or array of page IDs to exclude.
          'offset' => '',
          //(int) The number of pages to skip before returning. Requires $number. Default 0.
          'post_type'=> 'page',
          //(string) The post type to query. Default 'page'.
          'post_status'=>'publish',
          //(string|array) A comma-separated list or array of post statuses to include. Default 'publish'.
          'background_image' => true,
          'thumb_size' => 'project-archive',
          'exclude_current'=>false,
          'columns' => 3
           ),
          $atts
      );

      $pages=get_pages($atts );

      $content = '<div  class=" shortcode page-list custom-shortcode '.$atts['container_custom_classes'].' ">';
      if( '' != locate_template( 'template-parts/'.$atts['template'].'.php' ) ):
        foreach ( $pages as $post ) {
          ob_start();
          include(locate_template('template-parts/'.$atts['template'].'.php'));
          $content .= ob_get_clean();
        }
      else:
        echo 'verificare che il template template-parts/'.$atts['template'].' esista';
      endif;
      $content .='</div>';
     return $content;
    };
  }
}
// Function that will return our WordPress menu
function list_menu($atts, $content = null) {
    extract(shortcode_atts(array(
        'menu'            => '',
        'container'       => 'div',
        'container_class' => '',
        'container_id'    => '',
        'menu_class'      => 'menu custom-shortcode',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'depth'           => 0,
        'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
        'walker'          => new wp_bootstrap_navwalker(),
        'theme_location'  => ''),
        $atts));

    return wp_nav_menu( array(
        'menu'            => $menu,
        'container'       => $container,
        'container_class' => $container_class,
        'container_id'    => $container_id,
        'menu_class'      => $menu_class,
        'menu_id'         => $menu_id,
        'echo'            => false,
        'fallback_cb'     => $fallback_cb,
        'before'          => $before,
        'after'           => $after,
        'link_before'     => $link_before,
        'link_after'      => $link_after,
        'depth'           => $depth,
        'walker'          => $walker,
        'theme_location'  => $theme_location));
}
//Create the shortcode
add_shortcode("listmenu", "list_menu");
