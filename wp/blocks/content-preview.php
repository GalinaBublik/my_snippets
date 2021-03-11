<?php $image = get_sub_field('image'); ?>
<section class="preview__segment lighten">
	<div class="preview__segment_content">
		<div class="preview__segment_content_overlay">
			<div class="preview__segment_content_overlay_inner" style="background-image: url('<?php echo $image['sizes']['medium']; ?>')"></div>
		</div>
		<div class="preview__segment_content_text">
			<div class="preview__segment_content_text_inner">
				<h2 class="preview__segment_content_text_title"><?php the_sub_field('title'); ?> </h2>
				<?php the_sub_field('content'); ?>
			</div>
		</div>
	</div>
</section>