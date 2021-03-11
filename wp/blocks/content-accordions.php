<?php if( have_rows('sections') ): $i=0;?>
<section class="accordions__segment">
	<div class="accordions__segment_content container">
	<?php while ( have_rows('sections') ) : the_row(); ?>
		<div class="accordion__box"> 
			<div class="accordion__box_side left">
				<h2><?php the_sub_field('title'); ?></h2>
			</div>
			<div class="accordion__box_side right">
				<div class="accordion">
					<?php while ( have_rows('accordions') ) : the_row(); ?>
					<div class="accordion__item <?php if(!$i ){ echo 'expanded'; } ?>">
						<a href="javascript:void(0);" class="accordion__item_title"><?php the_sub_field('title'); ?></a>
						<div class="accordion__item_text">
							<?php the_sub_field('text'); ?>
							<?php if( get_sub_field('link_text') && get_sub_field('link') ) { ?>
							<a href="<?php the_sub_field('link'); ?>" class="link type-1 type-3 ext">
								<i><?php the_sub_field('link_text'); ?></i> 
								<span>
									<?php get_template_part('svg/hover', 'wave'); ?>
								</span>
							</a>
							<?php } ?>
						</div>
					</div>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
		<?php  $i++;   endwhile; ?>
		</div>
	</section>
<?php     endif; ?>
