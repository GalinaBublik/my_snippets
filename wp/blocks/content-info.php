<?php $current = get_queried_object(); 
// echo '<pre style="display:none;">';
// print_r($current);
// echo '</pre>';
if( isset($args['class']) && !empty($args['class']) ){
	$type = $args['class'];
} else if( !$current->post_parent ){
	$type = get_sub_field('type_of_2_column');
} else {
	switch (get_sub_field('type_of_2_column')) {
		case 'firm__initiatives':
			$type = 'left-wide people__intro';
			if( is_page('culture') ){
				$type = 'core__values';
			}
			if( is_page_template('page-people.php') ){
				$type = 'relative';
			}
			break;

		case 'firm__culture':

			$type = 'left-wide init__intro';
			if( is_page('culture') ){
				$type = 'left-wide culture__intro';
			}
			break;
		case 'firm__intro':

			$type = 'ph';
			
			break;
		case 'firm__people':

			$type = 'firm__people';
			
			break;
		default:
			$type = 'relative';
			break;
	}
} ?>
<div class="two__sides_segment <?php echo $type; ?>">
	<div class="two__sides_segment_content">
		<div class="two__sides_segment_content_side">
			<div class="two__sides_segment_content_side_inner">
				<h2><?php the_sub_field('title'); ?></h2>
				<?php the_sub_field('content'); ?>
				<?php if( get_sub_field('button') && get_sub_field('button_link') ) { ?>
				<a href="<?php the_sub_field('button_link'); ?>" class="<?php echo get_link_class( get_sub_field('button_type')); ?>" <?php echo get_target_link(get_sub_field('button_link')); ?>>
					<?php the_link_content(get_sub_field('button_type'), get_sub_field('button')); ?>
				</a>
				<?php } ?>
			</div>
		</div>
		<div class="two__sides_segment_content_side">
			<div class="two__sides_segment_content_side_inner">
				<?php if($type == 'ph'){
					get_template_part('content', 'ph');
				} ?>

				<?php if(get_sub_field('title_2_col')){ ?>
					<h2><?php the_sub_field('title_2_col'); ?></h2>
				<?php } ?>
				<?php if(get_sub_field('text')){ ?>
					<?php the_sub_field('text'); ?>
				<?php } ?>
				<?php if(get_sub_field('gallery')){ ?>
				<ul class="logos__list">
					<?php foreach( get_sub_field('gallery') as $img ){ ?>
					<li>
						<div class="logo__item">
							<img src="<?php echo $img['url']; ?>" alt="">
						</div>
					</li>
					<?php } ?>
				</ul>
				<?php } ?>
				<?php if(get_sub_field('people')){ ?>
				<ul class="people__list">
					<?php foreach( get_sub_field('people') as $people ){ 
						// echo '<pre style="display:none;">';
						// print_r($people);
						// echo '</pre>'; ?>
					<li>
						<div class="logo__item">
							<img src="<?php echo get_the_post_thumbnail_url( $people, 'thubnail'); ?>" alt="">
						</div>
					</li>
					<?php } ?>
				</ul>
				<?php } else if( get_sub_field('type_of_2_column') == 'firm__people' ){ 
					$args = array(
						'post_type' => 'staff',
						'post_status' => 'publish',
						'posts_per_page' => -1
					);
					$people = new WP_Query($args); 
					if( $people->have_posts() ){ ?>
					<ul class="people__list">
						<?php while ( $people->have_posts() ) : $people->the_post(); 
							if(has_post_thumbnail()){ 
							    $url = wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID()  ), 'thumbnail'); 
							} else { 
							    $url = wp_get_attachment_image_url( get_field('default_image', 'options'), 'thumbnail');
							} ?>
							<li>
								<div class="people__list_item" style="background-image: url('<?php echo $url; ?>')"></div>
							</li>
		    			<?php endwhile; wp_reset_postdata(); ?>
					</ul>
					<?php }  ?>
				<?php } ?>
				<?php if(get_sub_field('features')){ ?>
				<ul class="<?php echo ( !$current->post_parent && !is_front_page() ) ? 'left__icons_list' : 'adv__list' ; ?>">
					<?php foreach( get_sub_field('features') as $features ){ ?>
					<li>
						<?php if( !$current->post_parent && !is_front_page() ){ ?>
							<div class="left__icons_list_item">
								<?php if( $features['link'] ) { ?><a href="<?php echo $features['link']; ?>" class="" <?php echo get_target_link($features['link']); ?>></a><?php } ?>
								<div class="icon">
									<img src="<?php echo $features['icon']; ?>" alt="">
								</div>
								<div class="text"><?php echo $features['title']; ?></div>
							</div>
						<?php } else { ?>
						<div class="adv__item">
							<?php if( $features['link'] ) { ?><a href="<?php echo $features['link']; ?>" class="" <?php echo get_target_link($features['link']); ?>></a><?php } ?>
							<div class="adv__item_icon_box">
								<div class="icon">
									<img src="<?php echo $features['icon']; ?>" alt="">
								</div>
							</div>
							<div class="adv__item_text_box">
								<h3><?php echo $features['title']; ?></h3>
							</div>
						</div>
						<?php } ?>
					</li>
					<?php } ?>
				</ul>
				<?php } ?>
				<?php if(get_sub_field('links')){ ?>
				<ul class="two__columns_list">
					<?php foreach( get_sub_field('links') as $link ){ ?>
					<li>
						<?php if($link['link']){ ?>
						<a href="<?php echo $link['link']; ?>">
						<?php } ?>
							<?php echo $link['title']; ?>
						<?php if($link['link']){ ?>
						</a>
						<?php } ?>
					</li>
					<?php } ?>
				</ul>
				<?php } ?>
				<?php if( get_sub_field('button_text') && get_sub_field('button_link_right') ) { ?>
				<a href="<?php the_sub_field('button_link_right'); ?>" class="<?php echo get_link_class( get_sub_field('button_type_right')) ;  ?>"<?php echo get_target_link(get_sub_field('button_link_right')); ?>>
					<?php the_link_content(get_sub_field('button_type_right'), get_sub_field('button_text')); ?>
				</a>
				<?php } ?>
			</div>
		</div>
	</div>
</div>