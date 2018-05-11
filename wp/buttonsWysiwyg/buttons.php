<?php 

/* --- Shortcode -----*/
add_shortcode('row','row_shortcode');
add_shortcode('column','column_shortcode');
add_shortcode('list','list_shortcode');
add_shortcode('slider','slider_shortcode');


function row_shortcode ($atts, $content = null) {  
      $atts = shortcode_atts(array(
        ), $atts);
        extract($atts);

        $output = '<div class="row">'.  do_shortcode($content). '</div>';

        return $output;
        
    }
function column_shortcode ($atts, $content = null) {  
      $atts = shortcode_atts(array(
        'lg' => '3',
        'md' => '4',
        'sm'=> '6',
        'xs'=> '1'
        ), $atts);
        extract($atts);
        $class = '';
        foreach ($atts as $key => $attr) {
          $class .= 'col-'.$key.'-'.$attr.' ';
        }

        $output = '<div class="'.$class.'">'.  do_shortcode($content). '</div>';

        return $output;
        
    }

function slider_shortcode ($atts, $content = null) {  
    global $post, $wp_query;
    $current = $post;
    $currentquery = $wp_query;
        $atts = shortcode_atts(array(
            "column" => 3,
            "type" => 'post',
            "count" => -1,
            'orderby'=> 'date',
            'order' => 'DESC',
            'bullets' => 0,
        ), $atts);
        extract($atts);
        $output = '';
        $args = array(
            'post_type' => $type,
            'post_status' => 'publish',
            'orderby' => $orderby,
            'order' => $order,
            'posts_per_page' => $count,
            'paged' => (get_query_var('paged'))?get_query_var('paged'): 1
            );
        $posts = query_posts($args);
        //$posts = new WP_Query($args);
        if( $posts ):
        ob_start();
        $class = 'col-xs-12 ';
         ?>
         <div class="<?php echo $type; ?>SliderWrapper">
            <div id="<?php echo $type; ?>Slider" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                <?php $i=0; while ( have_posts() ) : the_post(); ?>
                    <li data-target="#<?php echo $type; ?>Slider" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i==0)? 'active':''; ?>"></li>
                <?php $i++;  endwhile; ?>
                </ol>
                
                <div class="carousel-inner">
        <?php //echo '<pre style="display:none;">'; print_r( $posts ); echo '</pre>'; ?>
            <?php 
            switch ($column) {
                case '1':
                    break;
                case '2':
                    $class .= ' col-sm-6 col-md-6';
                    break;
                case '3':
                    $class .= ' col-sm-6 col-md-4';
                    break;
                
                case '4': default:
                    $class .= ' col-sm-6 col-md-3';
                    break;
            } ?>
                <div class="item active">
            <?php $i=0;
            while(have_posts() ): the_post(); ?>
            <?php if($i%$column==0 && $i>0){ 
                echo '</div>';
                echo '<div class="item">';
            }
                ?>

                <?php echo '<div class="'.$class.'">';
                    get_template_part('content', $type);
                echo '</div>';?>
            <?php $i++; endwhile; ?>
                </div>
            </div>
            <?php if( $bullets ){?>
                <a class="left carousel-control" href="#<?php echo $type; ?>Slider" role="button" data-slide="prev">
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </a>
                <a class="right carousel-control" href="#<?php echo $type; ?>Slider" role="button" data-slide="next">
                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                </a>
            <?php }             ?>
            </div></div>
        <?php 
        wp_reset_postdata();
        wp_reset_query();
        $post = $current;
        $wp_query = $currentquery;
        $output .= ob_get_clean();
        endif;

        return $output;
}


function list_shortcode ($atts, $content = null) {  
    global $post, $wp_query;
    $current = $post;
    $currentquery = $wp_query;
        $atts = shortcode_atts(array(
            "column" => 3,
            "type" => 'post',
            "count" => -1,
            'orderby'=> 'date',
            'order' => 'DESC',
            'pagenavi' => 0,
        ), $atts);
        extract($atts);
        $output = '';
        $args = array(
            'post_type' => $type,
            'post_status' => 'publish',
            'orderby' => $orderby,
            'order' => $order,
            'posts_per_page' => $count,
            'paged' => (get_query_var('paged'))?get_query_var('paged'): 1
            );
        $posts = query_posts($args);
        //$posts = new WP_Query($args);
        if( $posts ):
        ob_start();
        // $class = 'col-xs-12 ';
         ?>
            <div class="container <?php echo $type; ?>-block">
            <div class="<?php echo $type; ?>-flex row">
        <?php //echo '<pre style="display:none;">'; print_r( $posts ); echo '</pre>'; ?>
            <?php 
            // switch ($column) {
            //     case '1':
            //         break;
            //     case '2':
            //         $class .= ' col-sm-6 col-md-6';
            //         break;
            //     case '3':
            //         $class .= ' col-sm-6 col-md-4';
            //         break;
                
            //     case '4': default:
            //         $class .= ' col-sm-6 col-md-3';
            //         break;
            // } ?>
            <?php 
            while(have_posts() ): the_post();
            //while( $posts->have_posts() ): $posts->the_post();
                // echo '<div class="'.$class.'">';
                    get_template_part('content', $type);
                // echo '</div>';
            endwhile;
            if( $pagenavi ){
                if( function_exists('wp_pagenavi') ){ 
                    wp_pagenavi(); 
                } else { 
                    the_posts_pagination( array(
                        'screen_reader_text' => '  ' ,
                        'mid_size' => 4,
                        'prev_text' => __( '< Back', 'keyweb' ),
                        'next_text' => __( 'Next >', 'keyweb' ),
                    ) ); 
                }
            }
            ?>
            </div></div>
        <?php 
        wp_reset_postdata();
        wp_reset_query();
        $post = $current;
        $wp_query = $currentquery;
        $output .= ob_get_clean();
        endif;

        return $output;
        
    }


/*------Add button-----*/

add_action( 'admin_init', 'nexa_buttons' );
function nexa_buttons() {
    add_filter( "mce_external_plugins", "nexa_add_buttons" );
    add_filter( 'mce_buttons', 'nexa_register_buttons' );
}
function nexa_add_buttons( $plugin_array ) {
    //$plugin_array['wpnexabutton'] = get_template_directory_uri() . '/shortcodes/test.js';
    $plugin_array['column'] = get_template_directory_uri() . '/shortcodes/column.js';
    $plugin_array['list'] = get_template_directory_uri() . '/shortcodes/list.js';
    $plugin_array['sliders'] = get_template_directory_uri() . '/shortcodes/slider.js';
    $plugin_array['argoFont'] = get_template_directory_uri() . '/shortcodes/argoFont.js';
    return $plugin_array;
}
function nexa_register_buttons( $buttons ) {
    array_push( $buttons, 'column' ); 
    array_push( $buttons, 'list' ); 
    array_push( $buttons, 'sliders' ); 
    array_push( $buttons, 'argoFont' ); 
    return $buttons;
}

/*------Add Dialog script for button-----*/


  function button_scripts_styles() {

    wp_enqueue_style("wp-jquery-ui-dialog");
    wp_enqueue_style( 'wp-color-picker' ); 

    wp_enqueue_script('jquery-ui-dialog');
    wp_enqueue_script('wp-color-picker');

      
  }
  add_action( 'admin_enqueue_scripts', 'button_scripts_styles' );

//add_filter('widget_text', 'do_shortcode');

function get_field_info(){
  $fields = get_field( $name, 'options' );
  
}


    add_action('admin_head', 'my_print_shortcodes_in_js' );

    function my_print_shortcodes_in_js(){
        $args=array(
        'public'   => true,
        '_builtin' => false
        );
        $post_types = get_post_types($args);
        if(!empty($post_types)){
            $first = true;
            foreach($post_types as $type){
                if(!$first) $shortcodes .= ',';
                $shortcodes.="'".$type."'";
                $first = false;
            }
        }

        ?>
        <script type="text/javascript">
            var post_types = [<?php echo $shortcodes; ?>];
        </script>
        <?php
    }
