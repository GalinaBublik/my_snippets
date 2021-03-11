<?php $image = get_sub_field('image'); 
if($image){ ?>
<div class="simple__image_segment">
	<div class="simple__image_segment_content">
		<div class="simple__image_segment_content_inner">
			<div class="image" style="background-image: url('<?php echo $image['sizes']['large']; ?>')"></div>
		</div>
	</div>
</div>
<?php } ?>