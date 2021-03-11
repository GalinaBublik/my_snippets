<?php 
$className = 'testimonials ';
$className .= ' bg-'.get_sub_field('bg');
// if( !get_sub_field('show_section') ){
// 	$className .= ' hidden_section ' ;
// }
$image = get_sub_field('image');


?>
<section class="<?php echo esc_attr($className); ?>"  >
    <div class="container">
        <div class="center-text">
            <h3 class="small"><?php the_sub_field('title'); ?></h3>
        </div>
        <div class="testimonials-slider">
        <?php if( have_rows('testimonials') ):
        while ( have_rows('testimonials') ) : the_row();?>
            <div class="slide">
              <div class="quotes">
                <img src="<?php echo get_stylesheet_directory_uri();?>/img/quotes.svg" />
              </div>
              <h2><?php the_sub_field('text'); ?></h2>
              <div>
                <h5><?php the_sub_field('name'); ?></h5>
                <p><?php the_sub_field('address'); ?></p>
              </div>
            </div>
            <?php endwhile;
        endif; ?>
        </div>
        <div class="testimonials-img">
            <img src="<?php echo $image['sizes']['large']; ?>" />
        </div>
    </div>
</section>