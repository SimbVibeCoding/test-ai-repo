
 <?php
/**
 * [visualizza il nome del template utilizzato]
 * @method retina_helper_debug_template
 */
    function retina_helper_debug_template()
   {
     /* make sure i've got $template */
     global $template;
     /* print the active template path and filename */
     ?>
     <message class="helper template">
     <?php echo("template name: ". $template);?>
     </message>
     <?php
     // usare conditional-tag per arginare a specifiche pagine
     // //https://docs.woocommerce.com/document/conditional-tags/ )
     // https://codex.wordpress.org/Conditional_Tags


   }
add_action('bootstrap_child_after_site', 'retina_helper_debug_template', 999);

function add_image_size_normalizzata($w,$h,$wf,$label){
  $units = normalizza_dimensioni_immagine_w($w,$h,$wf);
  $units['label'] = $label;
  //add_image_size($label, $units['wf'], $units['hf'], true);
   return $units;
}
function normalizza_dimensioni_immagine_w($w,$h,$wf){
  $ratio = $w/$h;
  // $w:$wfinale = $h:$hfinale $wfinale+$h/$w
  $hf = $wf*$h/$w;
   return array('rapporto'=>$ratio,'w'=>$w,'h'=>$h,'wf'=>$wf,'hf'=>round($hf)) ;
}

//var_dump(add_image_size_normalizzata(1500,1000,960,'product-hot-point'));


   // $fullPath2= get_home_path()."wp-content/themes/".get_template();
   // $fullPath = __DIR__;
   // $dirs = $files = array();
   // //var_dump( (get_included_files()));
   // $directory = new RecursiveDirectoryIterator($fullPath, FilesystemIterator::SKIP_DOTS);
   // foreach (new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::SELF_FIRST) as $path ) {
      //$path->isDir() ? $dirs[] = $path->__toString() : $files[] = realpath($path->__toString());
      //
      // if( strpos(file_get_contents($path),"storefront_header") !== false) {
      //       $files[] = realpath($path->__toString());
      //     }
        //$handle = fopen($path, "r");
   //}


   //retina_helper_get_plugin_hook_caller_file('woocommerce');
//retina_helper_get_theme_hook_caller_file('storefront_header');
// function retina_helper_get_theme_hook_caller_file($hook){
//   foreach (new DirectoryIterator($themeChildPath()) as $info) {
//     if ($info->isFile ()) {
//           $files [$info->__toString ()] = $info;
//       } elseif (!$info->isDot ()) {
//           $list = array($info->__toString () => retina_helper_get_theme_hook_caller_file(
//                       $directory.DIRECTORY_SEPARATOR.$info->__toString ()
//           ));
//           if(!empty($files))
//               $files = array_merge_recursive($files, $filest);
//           else {
//               $files = $list;
//           }
//       }
//   }
// }
//

/*--------------------------------------------*/
//add_action('storefront_content_top', 'retina_helper_debug_show_hook_callbacks', 1000,2);
/**
 * [mostra a scermo le action collegate ad un hook]
 * @method retina_helper_caller_debug_show_hook_callbacks
 * @param  String                                       $tag [Hook da visualizzare]
 */
function retina_helper_caller_debug_show_hook_callbacks($tag){
  add_action('init', function () use ($tag) {
    retina_helper_debug_show_hook_callbacks($tag) ;
  });
}

function retina_helper_debug_show_all_Hook() {
  var_dump( count(func_get_args()));
  global $debug_tags;
  if(isset($debug_tags)){
   if ( in_array( $tag, $debug_tags )) {
    return;
  };
   $debug_tags[] = $tag;
   retina_helper_debug_show_hook_callbacks($tag);
 }
   //$wp_filter[$tag]
   //foreach($wp_filter as $hook_name ){
  //    var_dump ($hook_name->callbacks);
  //  }

}


function retina_helper_debug_show_hook_callbacks($tags){
  //var_dump( count(func_get_args()));
  global $wp_filter;
  if(is_array($tags)){
    if(!count($tags)){
        return;
    }
  }else{
    $tags = array($tags);
  }
  echo  '<div class="hooks" >';
foreach($tags as $tag){
  $callbacks = ($wp_filter[$tag]->callbacks);
  if(isset($callbacks)){
      echo  '<div class="hook" >';
      echo  '<div class="tag">'.($tag).': </div>';
      echo( '<ul class="callback">');
    foreach($callbacks as $priority=>$hook ){
      foreach($hook as $name=>$params ){
        echo( '<li class="callback">');
        echo  '<span class="name">'.($name).': </span>';
        echo '<span class="priority">'.$priority.'. </span>';
        echo '</li>';
      }
    }
    echo '</ul>';
    echo '</div>';
  }
}
echo '</div>';
}


/*
 * Check for thumb of $size and generate it if it doesn't exist.
 * https://developer.wordpress.org/reference/functions/wp_generate_attachment_metadata/
 * @param int $post_id Post ID for which you want to retrieve thumbnail
 * @param string $size Name of thumbnail size to check for; same as
 *     the slug used to add custom thumb sizes with add_image_size().
 * @return array An array containing: array( 0 => url, 1 => width, 2 => height )
 *
 */
function otf_get_attachment_image_src($post_id, $size = 'thumbnail', $force = false) {
    $attachment_id = get_post_thumbnail_id($post_id);
    $attachment_meta = wp_get_attachment_metadata($attachment_id);

    $sizes = array_keys($attachment_meta['sizes']);
    if ( in_array($size, $sizes) && empty($force) )
        return wp_get_attachment_image_src($attachment_id, $size);
    else {
        include_once ABSPATH . '/wp-admin/includes/image.php';
        $generated = wp_generate_attachment_metadata(
            $attachment_id, get_attached_file($attachment_id));

        $updated = wp_update_attachment_metadata($attachment_id, $generated);

        return wp_get_attachment_image_src($attachment_id, $size);
    }
}

function show_registered_widgets_list(){
  $widgets =(get_option('sidebars_widgets'));
  foreach($wp_registered_sidebars as $name=>$value){
  	//echo $value['name']."<br>";
  	echo "<p>".$value['id']."<br>";
  	$value = ( $widgets[$value['id']]);

  	//echo $value['name']."<br>";
  	//echo $value['id']."<br>";

  	foreach($value as $name=>$value){
  		echo $value."<br>";
  	}
  	echo "</p>";
  }
}
