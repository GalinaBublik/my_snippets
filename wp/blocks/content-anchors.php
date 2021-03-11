<?php $anchors = get_sub_field('anchors');
if($anchors){ ?>
<section class="anchors__segment">
	<div class="anchors__segment_content container">
		<div class="anchors__segment_content_side left">
			<div class="side__inner">
				<div class="anchors__segment_indicators">
					<div class="slides__cont">
						<span class="current">1</span>
						<span class="dr">/</span>
						<span class="total"><?php echo count($anchors); ?></span>
					</div>
					<ul class="slick-dots">
						<?php foreach ($anchors as $key => $slide) { ?>
							<li class="<?php if(!$key ){ echo 'active'; } ?>">
								<button type="button"></button>
							</li>
						<?php } ?>
					</ul>
				</div>

				<div class="anchors__segment_tab_panels">
					<?php foreach ($anchors as $key => $slide) { ?>
					<div class="tab__panel <?php if(!$key ){ echo 'active'; } ?>">
						<div class="mobile__content">
							<div class="icon">
								<img src="<?php echo $slide['icon']; ?>" alt="">
							</div>
							<h3><?php echo $slide['title']; ?></h3>
						</div>
						<h6 class="body-30"><?php echo $slide['title']; ?></h6>
						<?php echo $slide['text']; ?>
					</div>

					<?php } ?>

				</div>
			</div>
		</div>
		<div class="anchors__segment_content_side right">
			<div class="side__inner">
				<ul class="adv__list">
					<?php foreach ($anchors as $key => $slide) { ?>
					<li class="<?php if(!$key ){ echo 'active'; } ?>">
						<div class="adv__item">
							<div class="adv__item_icon_box">
								<div class="icon">
									<img src="<?php echo $slide['icon']; ?>" alt="">
								</div>
							</div>
							<div class="adv__item_text_box">
								<h3><?php echo $slide['name']; ?></h3>
							</div>
						</div>
					</li>
					<?php } ?>
					
				</ul>
			</div>
		</div>
	</div>
</section>	
<?php } ?>
