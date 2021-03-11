<?php $blog = get_sub_field('featured_postss');
// echo '<pre style="display:none;">';
// print_r($blog);
// echo '</pre>';
$style = (is_front_page())? '' : 'no-sticky';
if( $blog ){ ?>
<?php if(!$style){ ?><div class="space space-25"></div><?php } ?>
<section class="articles__sticky <?php echo $style; ?>">
	<div class="articles__sticky_inner">
		<div class="articles__sticky_title_box container">
			<h2 class="title"><?php the_sub_field('title'); ?></h2>
			<a href="<?php the_sub_field('link'); ?>" class="link type-3 type-4">
				<i><?php the_sub_field('all_button'); ?></i> 
				<span>
					<?php get_template_part('svg/hover', 'wave'); ?>
				</span>
			</a>
		</div>
		<div class="articles__sticky_content_box container">
			<div class="articles__grid">
				<?php foreach ($blog as $key => $p) { 
					if( has_post_thumbnail($p->ID) ){
					$image = wp_get_attachment_image_url( get_post_thumbnail_id( $p->ID ), 'thumbnail');
				} else {
					 $image = wp_get_attachment_image_url( get_field('default_image', 'options'), 'thumbnail');
				} ?>
				<div class="articles__grid_segment">
					<div class="article__item">
						<a href="<?php echo get_permalink($p->ID); ?>" class="article__item_link"></a>
						<div class="article__item_image">
							<div class="article__item_image_inner" style="background-image: url('<?php echo $image; ?>')"></div>
						</div>
						<div class="article__item_description">
							<span class="pre__info text-18">Posted on <?php the_time('F d, Y');?> by <?php the_author(); ?></span>
							<h4 class="article__item_title"><a href="<?php echo get_permalink($p->ID); ?>"><?php clever_excerpt(120, $p->post_title); ?></a></h4>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<?php if($style){ ?><div class="articles__grid_controls"></div><?php } ?>
			<div class="articles__grid_more">

				<a href="<?php the_sub_field('link'); ?>" class="btn">
					<i>View More</i> 
					<?php get_template_part('svg/btn', 'waves'); ?>
				</a>
			</div>

		</div>
	</div>
</section>
<?php } ?>
