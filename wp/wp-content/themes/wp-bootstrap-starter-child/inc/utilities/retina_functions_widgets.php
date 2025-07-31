<?php


//create_menu($menus);

function retina_create_widget($names){
  if(is_array($names)){
    foreach($names as $name){
      retina_register_widget($name);
    }
  }else{
    retina_register_widget($names);
  }
}


// //$add_post_types= array('slider','realizzazioni');
// add_filter('retina_register_widget_args', function () use ($add_post_types) {
//   create_posttype_multi($add_post_types) ;
// });
//

function retina_filter_register_widget($args,$name){
  if (('footer form')==$name || ('footer form lavoro')==$name){
    $args['before_title']='<h1 class="widget-title">';
    $args['after_title']='</h1>';
  }
   return $args;
}

add_filter('retina_register_widget_args','retina_filter_register_widget',10,2);
function retina_register_widget($name){
  $args= array(
    'name' => $name,
    'id' => sanitize_title($name),
    'description' => 'Retina custom widget',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
    );
    $args=apply_filters('retina_register_widget_args',$args,$name);
    register_sidebar($args );

}

function create_custom_widget($name,$classes="section",$section=true) {
  if ( is_active_sidebar( sanitize_title($name) )) : ?>
  <?php if($section):?>
    <section id=  <?php echo sanitize_title($name); ?> class="widget <?php echo $classes; ?>">
      <div class="section-content">
        <div class="content-widget">
        <?php endif ?>
            <?php dynamic_sidebar( sanitize_title($name) ); ?>
  <?php if($section):?>
        </div>
      </div>
    </section>
  <?php endif ?>
  <?php
else:
  echo "creare o popolare il widget ".sanitize_title($name);
endif;
}
//registro un area per widget aggiuntivi
