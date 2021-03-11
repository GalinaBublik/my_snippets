

<section class="services__tiles">
    <?php if( have_rows('features') ): ?>
        <div class="services__tiles_grid">
            <?php while( have_rows('features') ): the_row();  ?>
                <div class="services__tiles_grid_tile_box">
                    <div class="services__tiles_grid_tile_box_inner">
                        <a href="<?php the_sub_field('link'); ?>" class="services__tiles_grid_tile_box_inner_link"></a>
                        <div class="services__tiles_grid_tile_box_inner_overlay wave-overlay">
                            <?php get_template_part('svg/bg', 'lwaves'); ?>
                        </div>
                        <div class="services__tile_info">
                            <div class="services__tile_info_inner">
                            
                                <div class="services__tile_info_icon_box">
                                    <img src="<?php the_sub_field('icon'); ?>" alt="">
                                </div>
                                <h3 class="services__tile_info_title"><?php the_sub_field('title'); ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</section>