<?php
$immagine =get_field('immagine',$term);
$link = get_category_link($term);
if($atts['background_image']){
   ?>
    <div class="loop-item-cat cat  <?php echo $atts['item_custom_classes']; ?> matcheight backgroundimage" style="background-image:url(<?php echo $image['sizes'][ $image_size ]; ?>)">';
   <?php
}else{
   ?>
     <div class="loop-item-cat cat" style="--color:<?php echo $color ?>">
   <?php
}
  if(!$atts['background_image']){
    ?>
    <div class="loop-item-image"> <img  src="<?php echo $image['sizes'][ $image_size ]; ?>"></div>
    <?php
  }
  ?>
    <div class="loop-item-text">
      <h3 class="loop-item-title"><?php echo $term->name ;?></h3>
      <h2 class="loop-item-excerpt"> <?php echo  $term->description; ?></h2>
      <a class="readmore" href="'.$link.'">Scopri di più</a>
    </div>
</div>
