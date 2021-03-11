<?php 
global $post;

$children = get_pages(array(
	'sort_order'   => 'ASC',
	'sort_column'  => 'menu_order',
	'parent'       => $post->post_parent
)); ?>
<section class="sidebar__template_segment services mobile-sticky">
	<div class="sidebar__template_segment_inner container">
		<div class="sidebar__template_segment_content">
			<div class="sidebar__template_segment_content_inner">
				
				<div class="resources__content_box services__box">
					
					<?php the_sub_field('content'); ?>

					<?php if( have_rows('services') ): $i=0;?>
					<div class="services__unit">
						<h2 class="services__unit_title">Our Services</h2>
						<ul class="services__unit_list">
							<?php while ( have_rows('services') ) : the_row(); ?>
							<li><?php the_sub_field('title'); ?></li>
							<?php endwhile; ?>
						</ul>
					</div>
					<?php endif; ?>
					
				</div>

			</div>
		</div>
		<?php if($children){ ?>
		<div class="sidebar__template_segment_sidebar">
			<div class="sidebar__template_segment_sidebar_inner">
				<div class="sidebar__template_segment_sidebar_navigation_selected">
					<span></span>
				</div>
				<ul class="sidebar__template_segment_sidebar_navigation_list">
					<?php foreach($children as $k => $child ){ ?>
					<li <?php  if( is_page( $child->ID )  ){ echo 'class="active"';} ?>>
						<a href="<?php echo get_permalink($child->ID); ?>">
							<span class="icon"><img src="<?php echo get_field('icon', $child->ID); ?>" alt=""></span>
							<?php echo $child->post_title; ?>
						</a>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<?php } ?>
	</div>
</section>