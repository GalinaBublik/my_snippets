<?php 
$className = 'text-block ';
if( !empty($block['className']) ) {
    $className .= $block['className'];
}
if( !get_sub_field('show_section') ){
	$className .= ' hidden_section ' ;
}


?>
<div class="bg-grey reach-out">
    <h2><?php the_sub_field('text'); ?></h2>
        <?php if(get_sub_field('link') && get_sub_field('button')){ ?>

            <a href="<?php echo get_sub_field('link'); ?>" class="btn btn-outline"><?php the_sub_field('button'); ?></a>
        <?php } ?>

</div>