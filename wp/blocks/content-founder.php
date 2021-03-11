<section class="founder__segment">
	<div class="founder__segment_content container">
		<div class="founder__segment_content_top">
			<h2 class="founder__segment_content_title"><?php the_sub_field('title'); ?></h2>
		</div>
		<div class="founder__segment_content_bottom">
			<div class="founder__segment_grid">

				<?php while( have_rows('founders') ): the_row();  ?>
				<div class="founder__segment_grid_column">
					<div class="person__card">
						<div class="person__card_image">
							<div class="person__card_image_inner" style="background-image: url('<?php $image = get_sub_field('photo');
							echo $image['sizes']['medium']; ?>')"></div>
						</div>
						<div class="person__card_description">
							<h3 class="person__card_title"><?php the_sub_field('name'); ?></h3>
							<span class="person__card_note"><?php the_sub_field('staff'); ?></span>
						</div>
					</div>
				</div>
				<?php endwhile; ?>


			</div>
		</div>
	</div>
</section>