<?php 
$className = 'faqs ';
$className .= ' bg-'.get_sub_field('bg');
// if( !get_sub_field('show_section') ){
// 	$className .= ' hidden_section ' ;
// }


?>
<section class="<?php echo esc_attr($className); ?>"  >
   <div class="center-text container">
      <h3><?php the_sub_field('title'); ?></h3>
    </div>
    <div class="container">
        <div class="faqs-block">
        <?php if( have_rows('faqs') ):
        while ( have_rows('faqs') ) : the_row();?>
            <div class="faq">
              <h4 class="small"><?php the_sub_field('question'); ?></h4>
              <div class="body">
                <?php the_sub_field('answer'); ?>
              </div>
              <span class="button"></span>
            </div>
            <?php endwhile;
        endif; ?>
        </div>
        <?php if( have_rows('button') ): ?>
            <div class="btn-overlay">
            <?php while ( have_rows('button') ) : the_row();?>
                <a href="<?php the_sub_field('link'); ?>" class="btn btn-<?php echo get_sub_field('style'); if( get_sub_field('open') == '_popup'){ echo ' anchor__link'; } ?>" <?php if( get_sub_field('open') == '_blank'){ echo 'target="_blank"'; } ?>><?php the_sub_field('text'); ?></a>
              <?php endwhile; ?>
            </div>
        <?php   endif; ?>
    </div>
</section>