<?php $img = get_sub_field('image'); ?>
<?php $slider = get_sub_field('slider'); 
if($slider){ ?>
<section class="horisontal__info_segment">
	<div class="horisontal__info_segment_content">
		<div class="horisontal__info_segment_content_inner">

			<div class="horisontal__info_segment_images">
				<?php while( have_rows('slider') ): the_row();  ?>
				<div class="image" style="background-image: url('<?php $image = get_sub_field('image');
							echo $image['sizes']['medium']; ?>"></div>
				<?php endwhile; ?>
			</div>

			<div class="horisontal__info_segment_text">
				<ul>
					<?php while( have_rows('slider') ): the_row();  ?>
					<li class="<?php if( get_row_index() ==1 ){ echo 'active'; }?>"><span><?php the_sub_field('text'); ?></span></li>
					<?php endwhile; ?>
				</ul>
			</div>

		</div>
	</div>


	<div class="preview__segment lighten no-parallax">
		<div class="preview__segment_content">
			<div class="preview__segment_content_overlay">
				<div class="preview__segment_content_overlay_inner" style="background-image: url('<?php echo $img['sizes']['large']; ?>')"></div>
			</div>
			<div class="preview__segment_content_text">
				<div class="preview__segment_content_text_inner">
					<h2 class="preview__segment_content_text_title"><?php the_sub_field('text'); ?></h2>
				</div>
			</div>
		</div>
	</div>

</section>
<div class="space space-25"></div>
<?php } ?>
