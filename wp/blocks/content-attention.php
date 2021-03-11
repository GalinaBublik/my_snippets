<div class="attention">
	<div class="attention__content">
		<div class="attention__content_side left">
			<div class="side__inner">
				<?php if(get_sub_field('title_1')){ ?>
					<h2 class="title"><?php the_sub_field('title_1'); ?></h2>
				<?php } ?>
				<?php if(get_sub_field('column_1')){ ?>
					<?php the_sub_field('column_1'); ?>
				<?php } ?>
			</div>
		</div>
		<div class="attention__content_side right">
			<div class="side__inner">
				<?php if(get_sub_field('title_2')){ ?>
					<h2><?php the_sub_field('title_2'); ?></h2>
				<?php } ?>
				<?php if(get_sub_field('column_2')){ ?>
					<?php the_sub_field('column_2'); ?>
				<?php } ?>
				<?php the_sub_field('content'); ?>
				<?php if( get_sub_field('button_text') && get_sub_field('button_link') ) { ?>
				<a href="<?php the_sub_field('button_link'); ?>" class="<?php echo get_link_class( get_sub_field('button_type')); if( strpos(get_sub_field('button_link'), '#') === 0 ){ echo ' modal__open'; }?>" <?php echo get_target_link(get_sub_field('button_link')); ?>>
					<?php the_link_content(get_sub_field('button_type'), get_sub_field('button_text')); ?>
				</a>
				<?php } ?>
			</div>
		</div>
	</div>
</div>