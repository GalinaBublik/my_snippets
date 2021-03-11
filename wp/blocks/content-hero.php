<?php 
$project = '';
if(get_sub_field('featured_project')){
    $project = get_sub_field('featured_project');
} else {
    $posts = get_posts( array(
        'numberposts' => 1,
        'category'    => 0,
        'orderby'     => 'date',
        'order'       => 'DESC',
        'include'     => array(),
        'exclude'     => array(),
        'meta_key'    => '',
        'meta_value'  =>'',
        'post_type'   => 'project',
        'suppress_filters' => true, 
    ) );
    if($posts){
        $project = $posts[0];
    }
} 
$fpost = '';
if(get_sub_field('featured_post')){
    $fpost = get_sub_field('featured_post');
} else {
    $posts = get_posts( array(
        'numberposts' => 1,
        'category'    => 0,
        'orderby'     => 'date',
        'order'       => 'DESC',
        'include'     => array(),
        'exclude'     => array(),
        'meta_key'    => '',
        'meta_value'  =>'',
        'post_type'   => 'post',
        'suppress_filters' => true, 
    ) );
    if($posts){
        $fpost = $posts[0];
    }
} 

// echo '<pre style="display:none;">';
// print_r($fpost);
// echo '</pre>';
                    ?>
<section class="main__hero">
    <div class="main__hero_video_overlay">
        <video src="<?php the_sub_field('video'); ?>" autoplay="autoplay" loop muted></video>
    </div>

    <div class="main__hero_content">
        <div class="main__hero_content_inner">
            <div class="main__hero_content_inner_left">
        <?php if( have_rows('slider') ): ?>

                <div class="main__hero_slider">

                <?php while( have_rows('slider') ): the_row(); ?>
                    <div class="slide__item">
                        <h2 class="title"><?php the_sub_field('title'); ?></h2>
                        <?php the_sub_field('text'); ?>
                        <div class="btn__wrapper">
                            <a href="<?php the_sub_field('link'); ?>" class="btn btn-white">
                                <i><?php the_sub_field('button'); ?></i>
                                <span>
                                    <?php get_template_part('svg/btn', 'waves'); ?>
                                </span>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
                </div>
        <?php endif; ?>
            </div>

            <div class="main__hero_content_inner_right">
                <div class="popular__projects_box">

                    <?php 
                    if($project){ 
                        if( has_post_thumbnail($project->ID) ){
                            $img = wp_get_attachment_image_url( get_post_thumbnail_id( $project->ID ), 'thumbnail');
                        } else {
                            $img = wp_get_attachment_image_url( get_field('default_image', 'options'), 'thumbnail');
                        }
                        ?>
                    <div class="popular__project">
                        <a href="<?php echo get_permalink($project->ID); ?>" class="popular__project_link"></a>
                        <div class="popular__project_image_side">
                            <div class="popular__project_image" style="background-image: url(<?php echo $img; ?>)"></div>
                        </div>
                        <div class="popular__project_text_side">
                            <span class="category">Projects</span>
                            <h5 class="title"><?php clever_excerpt( 45, $project->post_title ); ?></h5>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($fpost){  
                        if( has_post_thumbnail($fpost->ID) ){
                            $img = wp_get_attachment_image_url( get_post_thumbnail_id( $fpost->ID ), 'thumbnail');
                        } else {
                            $img = wp_get_attachment_image_url( get_field('default_image', 'options'), 'large');
                        }
                        ?>

                    <div class="popular__project">
                        <a href="<?php echo get_permalink($fpost->ID); ?>" class="popular__project_link"></a>
                        <div class="popular__project_image_side">
                            <div class="popular__project_image" style="background-image: url(<?php echo $img; ?>)"></div>
                        </div>
                        <div class="popular__project_text_side">
                            <span class="category">Blog</span>
                            <h5 class="title"><?php clever_excerpt( 45, $fpost->post_title ); ?></h5>
                        </div>
                    </div>

                    <?php } ?>

                </div>

            </div>
            
        </div>
    </div>
    

</section>
