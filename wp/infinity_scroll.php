<?php /* ------------------------------------------------Ajax -------------------------------------------------*/

    add_action( 'wp_ajax_getNextPage', 'getNextPage' );
    add_action( 'wp_ajax_nopriv_getNextPage', 'getNextPage' );
    
    function getNextPage() {
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            // 'orderby' => $orderby,
            // 'order' => $order,
            // 'posts_per_page' => $count,
            'meta_query'=> array(
                array(
                    'key'     => '_regular_price',
                    'value'   => '0',
                    'compare' => '>'
                )
            ),
            'paged' => $_POST['page'],
        );
        $products = new WP_Query($args);
        if ( $products->have_posts() ) : 

            //woocommerce_product_loop_start(); ?>

                <?php while ( $products->have_posts() ) : $products->the_post(); ?>

                    <?php
                        /**
                         * woocommerce_shop_loop hook.
                         *
                         * @hooked WC_Structured_Data::generate_product_data() - 10
                         */
                        do_action( 'woocommerce_shop_loop' );
                    ?>

                    <?php wc_get_template_part( 'content', 'product' ); ?>

                <?php endwhile; // end of the loop. ?>

            <?php //woocommerce_product_loop_end(); 
        endif;
        die();

    }
?>
