<?php 
$className = 'two__sides_segment ';
// if( !empty($block['className']) ) {
//     $className .= $block['className'];
// }
$className .= ' '.get_sub_field('style').' ' 

?>
<div class="<?php echo esc_attr($className); ?>">
  <div class="two__sides_segment_content">
    <div class="two__sides_segment_content_side">
      <div class="two__sides_segment_content_side_inner">
        <?php the_sub_field('column_1'); ?>
      </div>
    </div>
    <div class="two__sides_segment_content_side">
      <div class="two__sides_segment_content_side_inner">
        <?php the_sub_field('column_2'); ?>
      </div>
    </div>
  </div>
</div>