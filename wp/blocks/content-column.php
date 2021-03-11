<?php 
$className = 'about-block ';
$className .= ' bg-'.get_sub_field('bg');



?>
<section class="<?php echo esc_attr($className); ?>"  >
    <div class="center-text container">
        <?php the_sub_field('title'); ?>
        <?php /*if( have_rows('button') ):
              while ( have_rows('button') ) : the_row();?>
                <a href="<?php the_sub_field('link'); ?>" class="btn btn-<?php echo get_sub_field('style'); if( get_sub_field('open') == '_popup'){ echo ' anchor__link'; } ?>" <?php if( get_sub_field('open') == '_blank'){ echo 'target="_blank"'; } ?>><?php the_sub_field('text'); ?></a>
              <?php endwhile;
          endif; */?>
    </div>
    <div class="container">
        <div class="row">
        <?php $count = count(get_sub_field('columns'));
        if( have_rows('columns') ):
            while ( have_rows('columns') ) : the_row();?>
                <div class="col-<?php echo $count; ?> background-overlay">
                    <div class="column-header">
                        <?php the_sub_field('text'); ?>
                    </div>
                    <?php if( have_rows('list') ): ?>
                        <div class="list">
                        <?php while ( have_rows('list') ) : the_row();?>
                            <div>
                              <h4 class="small"><?php the_sub_field('title'); ?></h4>
                              <p><?php the_sub_field('description'); ?></p>
                            </div>
                        <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endwhile;
        endif; ?>
        </div>
    </div>
</section>
        
    
</div>