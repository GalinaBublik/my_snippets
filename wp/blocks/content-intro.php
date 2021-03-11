<?php 

$className = 'intro home ';
if( is_page_template('page-form.php') ){
	$className .= ' form-thanks hidden ';
}
$className .= ' bg-'.get_sub_field('bg');

// if( !get_sub_field('show_section') ){
// 	$className .= ' hidden_section ' ;
// }

?>
<section class="<?php echo esc_attr($className); ?>"  >
  <div class="container row">
  	<div class="col-2">
    	<?php the_sub_field('text'); ?>
	</div>
  </div>
    <div class="col-2 main-pic"><?php $image = get_sub_field('image'); ?>
    	<img src="<?php echo $image['sizes']['large']; ?>" />
    </div>
</section>
