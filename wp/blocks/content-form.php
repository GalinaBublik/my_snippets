<?php 
$className = 'contact-block ';
$className .= ' bg-'.get_sub_field('bg');



?>
<section class="<?php echo esc_attr($className); ?>"  >
    <div class="container">
      <div class="row">
        <div class="col-2">
          <div class="contact-overlay">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/envelope.svg" />
            <?php  the_sub_field('form_title'); ?>
            <?php the_sub_field('form'); ?>
          </div>
        </div>
        <div class="col-2">
          <div>
            <h4 class="small"><?php  the_sub_field('title'); ?></h4>
            <?php $show = get_sub_field('show');
            if( $show ){
                foreach ($show as $value) {
                    if($value == 'email'){ ?>
                        <a href="mailto:<?php the_field('email', 'options'); ?>" class="btn btn-img btn-white"><i class="fas fa-envelope"></i><?php the_field('email', 'options'); ?></a>
                    <?php } else if( $value == 'phone'){ ?>
                        <a href="tel:<?php the_field('phone', 'options'); ?>" class="btn btn-img btn-white"><i class="fas fa-phone-alt"></i><?php the_field('phone', 'options'); ?></a>
                    <?php }  else if( $value == 'address'){ ?>
                        <a href="tel:<?php the_field('address', 'options'); ?>" class="btn btn-img btn-white"><i class="fas fa-map-marked-alt"></i><?php the_field('address', 'options'); ?></a>
                    <?php } else { ?>
                        <p><?php echo $value; ?></p>
                    <?php }
                }

            } ?>
          </div>
          <div>
            <?php  the_sub_field('info'); ?>
          </div>
        </div>
      </div>
    </div>

</section>
  