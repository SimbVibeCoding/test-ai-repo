<?php
$post_id=get_the_ID();
$col= 12/$atts['columns'];
$cols = "col-".$col;
?>
<div class=" <?php echo $atts['item_custom_classes'];?> <?php echo $cols;?> ">
<div class="wrapper">
   <div class="loop-item-title">
     <?php
   the_title();
   ?>
   </div><!-- end loop item-title -->
   <div class="loop-item-image">
     <?php
   the_post_thumbnail();
   ?>
   </div><!-- end loop item-image -->
   <div class="loop-item-excerpt">
   <?php
   the_excerpt();
   ?>
   </div><!-- end loop item-title -->
 </div><!-- end wrapper -->
 </div><!-- end loop item -->
