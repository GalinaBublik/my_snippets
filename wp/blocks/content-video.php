<?php $video = get_sub_field('video');
if($video){
?>
<section class="preview__segment">
	<div class="preview__segment_content">
		<div class="preview__segment_content_overlay video__box"	
		<?php if(get_sub_field('youtube')){
			$youtube = explode('/', get_sub_field('youtube'));
			if( is_array($youtube) ){
				$youtube = array_pop($youtube);
			}
			echo 'data-plyr-provider="youtube" 
			data-plyr-embed-id="'.$youtube.'"'; } ?>>
						<a href="javascript:void(0);" class="video__box_link"></a>
						<div class="video__box_icon">
							<div class="video__box_icon_inner">
								<img src="<?php the_theme_image('play-icon.svg'); ?>" alt="play video icon">
							</div>
						</div>
			<div class="preview__segment_content_overlay_inner">
				<video src="<?php echo $video['url']; ?>" muted loop autoplay="autoplay"></video>
			</div>
		</div>
		<div class="preview__segment_content_text">
			<div class="preview__segment_content_text_inner">
				<?php the_sub_field('content'); ?>
				<?php if( get_sub_field('button') && get_sub_field('button_link') ) { ?>
				<?php if( strpos(get_sub_field('button_link'), 'youtu')  ){$youtube = explode('/', get_sub_field('button_link'));
					if( is_array($youtube) ){
						$youtube = array_pop($youtube);
					} ?>
					<div class="video__box" data-plyr-provider="youtube" data-plyr-embed-id="<?php echo $youtube; ?>">
				<?php } ?>
				<a href="<?php the_sub_field('button_link'); ?>" <?php echo get_target_link(get_sub_field('button_link')); ?> class="<?php echo get_link_class( get_sub_field('button_type')); ?>">
					<?php the_link_content(get_sub_field('button_type'), get_sub_field('button')); ?>
				</a>
				<?php if( strpos(get_sub_field('button_link'), 'youtu')  ){ ?>
				</div>
				<?php } ?>
				<?php } ?>
			</div>
		</div>
	</div>
</section>
<?php } ?>