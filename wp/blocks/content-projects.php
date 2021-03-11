<?php $projects = get_sub_field('featured_projects');
// echo '<pre style="display:none;">';
// print_r($projects);
// echo '</pre>';
if( $projects ){ ?>
<section class="related__segment">
	<div class="related__segment_content container">
		<div class="related__segment_content_top">
			<h2 class="related__segment_title"><?php the_sub_field('title'); ?></h2>
			<a href="<?php the_sub_field('link'); ?>" class="link type-2"><?php the_sub_field('all_button'); ?></a>
		</div>
		<div class="related__segment_content_bottom">
			<div class="preview__grid">
			<?php foreach ($projects as $key => $pr) { 
				if( has_post_thumbnail($pr->ID) ){
					$image = wp_get_attachment_image_url( get_post_thumbnail_id( $pr->ID ), 'medium');
				} else if( get_field('after', $pr->ID ) ){ 
					$image = get_field('after', $pr->ID );
					$image = $image['sizes']['medium'];
				} else {
					 $image = wp_get_attachment_image_url( get_field('default_image', 'options'), 'medium');
				} ?>
				<div class="preview__grid_column">
					<div class="preview__card">
						<a href="javascript:void(0);" class="preview__card_link"></a>
						<div class="preview__card_image" style="background-image: url('<?php echo $image; ?>')"></div>
						<div class="preview__card_info">
							<div class="autor"><span></span>
								<?php $locations = get_the_terms( $pr->ID, 'location' );  
								//$location = array_shift( $locations ); 
								// if( $location ){ 
								// }
								if( $locations ){ 
									foreach( $locations as $key=>$location ){ 
										if($key){ echo '<br>'; }?>
										<?php echo $location->name; ?>
								<?php  } } ?>
							</div>
							<div class="preview__card_info_text">
								<h3 class="preview__card_info_title"><?php echo $pr->post_title; ?></h3>
								<h6 class="preview__card_info_note">
									<?php 
									$service = get_top_term('services', $pr->ID);
									if( $service ){ 
									?>
										<span><?php echo $service->name; ?></span>
									<?php }
									/*$services = get_the_terms( get_the_ID(), 'services' );  
									//$term = array_shift( $terms ); 
									if( $services ){ 
										foreach( $services as $service ){ ?>
											<span><?php echo $service->name; ?></span>
									<?php  } } */?>
								</h6>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			</div>
		</div>

	</div>
</section>
<?php } ?>