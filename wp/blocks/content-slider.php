<?php $slider = get_sub_field('slider'); 
if($slider){ ?>
<section class="info__slider_segment no-desktop-arrows">
	<div class="info__slider_segment_content container">

		<div class="service__box">
			<div class="service__box_inner">
				<div class="slides__cont">
					<span class="current">1</span>
					<span class="dr">/</span>
					<span class="total"><?php echo count($slider); ?></span>
				</div>
				<div class="dots__wrapper"></div>
			</div>
		</div>

		<div class="arrows__wrapper_outer">
			<div class="arrows__wrapper">
				<button class="btn btn-icon slick-prev slick-control">
					<span>
						<?php get_template_part('svg/waves', 'three'); ?>
					</span>
				</button>
				<button class="btn btn-icon slick-next slick-control">
					<span>
						<?php get_template_part('svg/waves', 'three'); ?>
					</span>
				</button>
			</div>
		</div>

		<div class="title__box">
			<h2 class="title"><?php the_sub_field('title'); ?></h2>
		</div>
		

		<div class="info__slider" data-arrows="false">
			<?php while( have_rows('slider') ): the_row();  ?>
			<div class="slide__item">
				<div class="slide__item_content">
					<div class="slide__item_content_side left">
						<!-- <div class="title__box">
							<h2 class="title"><?php the_sub_field('title'); ?></h2>
						</div> -->
						<div class="image__box">
							<div class="image" style="background-image: url(<?php $image = get_sub_field('image');
							echo $image['sizes']['medium']; ?>)"></div>
						</div>
					</div>
					<div class="slide__item_content_side right">
						
						<div class="side__inner">
							<?php the_sub_field('text'); ?>
							<div class="button__wrapper">
								<a href="<?php the_sub_field('link'); ?>" class="btn">
									<i><?php the_sub_field('button'); ?></i>
									<?php get_template_part('svg/btn', 'waves'); ?>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
            <?php endwhile; ?>
		</div>
	</div>
</section>
<?php } ?>
