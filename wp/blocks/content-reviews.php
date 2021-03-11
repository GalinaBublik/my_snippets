<?php 
$className = ' reviews ';
$className .= ' bg-'.get_sub_field('bg');

?>
<section class="<?php echo esc_attr($className); ?>"  >
    <?php if( have_rows('icons') ):
        while ( have_rows('icons') ) : the_row();?>
            <div class="block">
            <?php if(get_sub_field('link') ){ ?><a class="abs_link" href="<?php the_sub_field('link'); ?>"  <?php if( get_sub_field('open') == '_blank'){ echo 'target="_blank"'; } ?>></a><?php } ?>
              <div class="block-pic">
                <img src="<?php the_sub_field('icon'); ?>">
              </div>
              <p><?php the_sub_field('text'); ?></p>
            </div>        
        <?php endwhile;
    endif; ?>
</section>