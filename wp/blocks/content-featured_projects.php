<?php $projects = get_sub_field('featured_projects');
// echo '<pre style="display:none;">';
// print_r($projects);
// echo '</pre>';
if( $projects ){ ?>
<section class="featured__projects">
	<div class="featured__projects_content">
		<div class="featured__projects_images_controls"></div>
		<div class="featured__projects_images">
			<?php foreach ($projects as $key => $pr) { 
				if( has_post_thumbnail($pr->ID) ){
					$image = wp_get_attachment_image_url( get_post_thumbnail_id( $pr->ID ), 'medium');
				} else if( get_field('after', $pr->ID ) ){ 
					$image = get_field('after', $pr->ID );
					$image = $image['sizes']['medium'];
				} else {
					 $image = wp_get_attachment_image_url( get_field('default_image', 'options'), 'medium');
				} ?>
				<div class="featured__project_image" style="background-image: url('<?php echo $image; ?>')"></div>
			<?php } ?>
		</div>

		<div class="featured__projects_text_box">
			
			<div class="featured__projects_texts">

				<div class="featured__projects_texts_pretitle">
					<h4><?php the_sub_field('title'); ?></h4>
				</div>

				<div class="featured__projects_texts_slider">

					<?php foreach ($projects as $key => $pr) { ?>
					<div class="featured__projects_text" data-link-url="<?php echo get_permalink($pr->ID); ?>">
						<h2 class="featured__projects_text_title"><?php echo $pr->post_title; ?></h2>
						<div class="featured__projects_text_category">
							<span>
							<?php $link = ( strpos(get_sub_field('all_button'), '?') !== false  ) ? get_sub_field('all_button').'&' : get_sub_field('all_button').'?' ;

							foreach ( get_the_category($pr->ID) as $category ) {
								printf(
									'<a href="%s" class="link link_text">%s</a>', 
									esc_url( $link .'services[]='.$category->term_id  ), 
									esc_html( $category->name )
								);
							} ?>
							</span>
						</div>
					</div>
					<?php } ?>
				</div>

				<div class="featured__projects_texts_actions">
					<a href="javascript:void(0);" class="btn">
						<i>show project</i>
						<span>
							<span>
								<?php get_template_part('svg/btn', 'waves'); ?>
							</span>
						</span>
					</a>
					<a href="<?php the_sub_field('link'); ?>" class="link type-2"><?php the_sub_field('all_button'); ?></a>
				</div>
				
			</div>
		</div>

	</div>
</section>
<?php } ?>