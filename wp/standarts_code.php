<?php
/*--------------------------------------------- search in multidimensional arrays ------*/
/*--------------------------------------------- Поиск по многомерному масиву ------*/

function search_r($array, $key, $value)
{
    if (!is_array($array)) {
        return;
    }

    if (isset($array[$key]) && $array[$key] == $value) {
        return true;
    }

    foreach ($array as $subarray) {
        search_r($subarray, $key, $value, $results);
    }
    return false;
}

/*--------------------------------------------- Quantity of quary and time of load page ------*/
/*--------------------------------------------- колическво запросов и время загрузки страницы ------*/
 echo get_num_queries(); ?> queries in <?php timer_stop(1); ?> seconds.

<?php
 /*-------------------------------------- Excerpt ---------------------------*/
 /*-------------------------------------- Обрезка отрывка контента по количеству символов  ---------------------------*/

 function new_excerpt_more($more) {  
    return '...';  
}  
add_filter('excerpt_more', 'new_excerpt_more');  


function clever_excerpt( $charlength, $excerpt='' ){
    if($excerpt==''){ $excerpt = get_the_excerpt(); }
    $charlength++;

//    echo '<p>';
    if ( mb_strlen( $excerpt ) > $charlength ) {
        $subex = mb_substr( $excerpt, 0, $charlength - 5 );
        $exwords = explode( ' ', $subex );
        $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
        if ( $excut < 0 ) {
            echo mb_substr( $subex, 0, $excut );
        } else {
            echo $subex;
        }
        echo '...';
    } else {
        echo $excerpt .'...';
    }
//    echo '</p>';
}

/*------------------------------------------------Sidebar---------------------------------------*/

function keyweb_widgets_init() {
  register_sidebar( array(
    'name' => __( 'Main Sidebar', 'keyweb' ),
    'id' => 'sidebar-1',
    'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'keyweb' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
  ) );

}
add_action( 'widgets_init', 'keyweb_widgets_init' );



/*------------------------------------Search form ------------------------*/

function my_search_form( $form ) {

    $form = '
    <form name="search" action="' . home_url( '/' ) . '" method="get" class="form-inline form-search">
                <div class="input-group">
                <input type="hidden" value="product" name="post_type" />
                    <input class="form-control inputSearch" value="' . get_search_query() . '" id="searchInput" type="text" name="s" placeholder="What are you looking for?">
                    <div class="input-group-btn">
                        <button type="submit" class="button buttonSearch">SEARCH</button>
                    </div>
                </div>
            </form>';

    return $form;             

}


/*------------------------------------ Pre get posts------------------------*/
add_action( 'pre_get_posts', 'custom_pre_get_posts_query' );
 
function custom_pre_get_posts_query( $query ) {

    /* !important check  is_main_query() */
 
    if ( ! is_admin() && is_shop() && $query->is_main_query()) {
 
        $query->set( 'meta_query', array(array(
            'key' => '_subscription_price',
            'compare' => 'NOT EXISTS'
        )));

    }
 
 
}

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;


/*------------------------------------ Ajax -------------------------------*/

    /** Include ajax url to header for js files **/
    add_action('wp_head','add_ajaxurl');
    function add_ajaxurl() { 
        $biggSissUser = getBiggSissUser();
        $user = $biggSissUser['show_user']->ID;
        $user_data = get_user_meta( $user );
        $show_tooltibs = 0;
        if($user_data['tooltibs'][0] == 1) {
            $show_tooltibs = 1;
        }
        ?>
        <script type="text/javascript">
            ajaxurl = '<?= admin_url("admin-ajax.php"); ?>';
            logouuturl = '<?= wp_logout_url(home_url()) ?>';
            showtooltibs = '<?= $show_tooltibs ?>';
        </script><?php
    }
    /* OR create global variable */
    wp_enqueue_script( 'theme-script', get_template_directory_uri() . '/js/template.js', array( 'jquery' ) );
    wp_localize_script( 'theme-script', 'ajaxurl', admin_url('admin-ajax.php') );
    wp_localize_script( 'theme-script', 'home', home_url('/') );

    /* ajax for authorized users and no */

    add_action('wp_ajax_forgot_pass', 'forgot_pass');
    add_action('wp_ajax_nopriv_forgot_pass', 'forgot_pass');
    function forgot_pass(){
        //$json = array();
        $result =array(
            'error'=>true,
            'msg'=>'I don\'t know what the trouble'
        );
        $r = custom_retrieve_password();
        if($r === true) {
            echo 'ok';
            //$json['success'] = 1;
        } else if($r === false) {
            echo 'false';
            //$json['success'] = 1;
        } else {
            if( is_object($r)){
                $res = array();
                foreach ($r->errors as $key => $value) {
                    foreach ($value as $k => $v) {
                        $res[] = $v;
                    }
                }
                echo '<div id="login_error">'.implode($res).'</div>';
            } else {
                //$json['error'] = $res;
                //$json['error'] = $r->errors['invalidcombo'];
                echo '<div id="login_error">'.$r.'</div>';
            }
        }
                //print_r($r);
        //wp_send_json($json);
        exit;
    }

/*-------------------------------------Incert google maps to page with settings from admin-panel ------------------*/
    if( is_page_template('page-contact.php') ){
            wp_enqueue_script( 'google-map', '//maps.googleapis.com/maps/api/js?key={YOUR_API_KEY}', array() , true );
            wp_enqueue_script( 'map', get_theme_file_uri( '/js/map.js' ), array('jquery', 'google-map'), true );

            wp_localize_script( 'map', 'localVars', get_local_vars() );
        }
    //funtion get_field from plugin ACF
    function get_local_vars(){
        $vars = array();
        $vars['zoom'] = (get_field('zoom', 'options'))? get_field('zoom', 'options') : '12'; 
        $vars['address'] = get_field('address', 'options');

        return $vars;
    }

/** ---------------------------------------Remove width & height images attributes ----------------------------------*/
        function remove_images_width_height($content) {
            $content = preg_replace('/<img(.*?)(width=\"\d+\")(.*?)>/iu', "<img$1 $3>", $content);
            $content = preg_replace('/<img(.*?)(height=\"\d+\")(.*?)>/iu', "<img$1 $3>", $content);
            return $content;
        }
        add_filter('the_content', 'remove_images_width_height');
        add_filter('post_thumbnail_html', 'remove_images_width_height');

/*-----------------------------------------------------Shortcode-------------------------------------------*/
    
    
    add_shortcode('button','get_button_shortcode');

    function get_button_shortcode($atts){
        ob_start(); //on buffer if html will big or use get_template part
        $atts = shortcode_atts(array(
            'link' => home_url('/'),
            'text' => 'Go to'
        ), $atts);
        extract($atts); //convert associative array to variables  ?>
            <a href="<?php echo $text; ?>" class="btn"><?php echo $text; ?></a>
        <?php 
        $content .= ob_get_clean();
        return $content; //shortcode must return html but NOT print!
    }
/*-----------------------------------------------------Post types-------------------------------------------*/

    add_action( 'init', 'create_post_type' );
    function create_post_type() {

        register_post_type( 'faq', array(
            'label' => 'FAQs',
            'singular_label' => 'FAQ',
            'description' => 'For the faq',
            'public' => TRUE,
            'has_archive'=>false,
            'exclude_from_search' => false,
            'publicly_queryable' => TRUE,
            'show_ui' => TRUE,
            'query_var' => TRUE,
            'rewrite' => TRUE,
            'taxonomy'=> 'faq_post',
            'capability_type' => 'post',
            'hierarchical' => FALSE,
            'menu_position' => NULL,
            'menu_icon'=> 'dashicons-hammer',
            'supports' => array('title', 'editor', 'page-attributes'),
            'rewrite' => array(
            'slug' => 'service',
            'with_front' => FALSE,
            ),
        ));


    }

    add_action('init', 'create_new_taxonomy', 0);
    function create_new_taxonomy() {
      $labels = array(
          'name' => _x('Categories', 'taxonomy general name'),
          'singular_name' => _x('Category', 'taxonomy singular name'),
          'search_items' => __('Search Categories'),
          'popular_items' => __('Most'),
          'all_items' => __('All Categories'),
          'parent_item' => '',
          'parent_item_colon' => '',
          'edit_item' => __('Edit Category'),
          'update_item' => __('Update Category'),
          'add_new_item' => __('Add New Category'),
          'new_item_name' => __('New Category Name'),
    );
    /*------------ name of taxonomy ↓  -- ↓ post_types ---*/
        register_taxonomy('faq_post', array('faq'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'show_admin_column' => true,
            'rewrite' => array('slug' => 'faq_post'),
        ));

    }

/*------------------------------------ Woocommerce weight as required field ------------------------*/
/*------------------------------------ Если товары требуют доставки, но поля габаритов не заполняются вручную ------------------------*/


add_action( 'woocommerce_process_product_meta', 'wc_custom_save_custom_fields', 100 );
function wc_custom_save_custom_fields( $post_id ) {
    

    if( !$_POST['_weight'] ){
        update_post_meta( $post_id, '_weight', '1' );
    }
    if( !$_POST['_length'] ){
        update_post_meta( $post_id, '_length', '1' );
    }
    if( !$_POST['_width'] ){
        update_post_meta( $post_id, '_width', '1' );
    }
    if( !$_POST['_height'] ){
        update_post_meta( $post_id, '_height', '1' );
    }
}

/*-----------------------------------------------------Excerpt-------------------------------------------*/

    function new_excerpt_more($more) {  
        return '...';  
    }  
    add_filter('excerpt_more', 'new_excerpt_more');  


    function clever_excerpt( $charlength=120, $excerpt='' ){
        if($excerpt==''){ $excerpt = get_the_excerpt(); } 
        //else { $excerpt = apply_filters('the_content', $excerpt); }
        $charlength++;

        if ( mb_strlen( $excerpt ) > $charlength ) {
            $subex = mb_substr( $excerpt, 0, $charlength - 5 );
            $exwords = explode( ' ', $subex );
            $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
            if ( $excut < 0 ) {
                echo mb_substr( $subex, 0, $excut );
            } else {
                echo $subex;
            }
            echo '...';
        } else {
            echo $excerpt;
        }
    }