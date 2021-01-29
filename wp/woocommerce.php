<?php 
/*-------------------------- % Sale add to price --------------------------------*/

add_filter('woocommerce_get_price_html', 'add_percents_of_sale', 10, 2);

function add_percents_of_sale( $price, $product ){
	if( $product->is_type( 'simple' ) ){
		if ( $product->is_on_sale() ) {
			$percent = floor(( ($product->get_regular_price()-$product->get_sale_price())/$product->get_regular_price() )*100);

			$price = $price. ' Sale ' . $percent.'%' ;
		}
	} else if( $product->is_type( 'variable' ) ){
		$prices = $product->get_variation_prices( true );

		if ( empty( $prices['price'] ) ) {
			$price = apply_filters( 'woocommerce_variable_empty_price_html', '', $product );
		} else {
			$sales = array();
			foreach ($prices['price'] as $key => $value) {
				if( $prices['regular_price'][$key] != $prices['sale_price'][$key] ){
					$sales[] = floor((($prices['regular_price'][$key]-$prices['sale_price'][$key])/$prices['regular_price'][$key] )*100);
				}
			}
			sort($sales);
			$min_sale = current( $sales );
			$max_sale = end( $sales );

			if ( $min_sale !== $max_sale ) {
				$price = $price. ' Sale ' .$min_sale.'% - '.$max_sale.'%' ;
			} elseif ( $product->is_on_sale() && $min_sale === $max_sale ) {
				$price = $price. ' Sale ' . $min_sale.'%' ;
			}

			$price = apply_filters( 'woocommerce_variable_price_html', $price . $product->get_price_suffix(), $product );
		}
	}
	return $price;
}

/*-------------------------- Sale first --------------------------------*/

add_action( 'pre_get_posts', 'sales_first_hook' );
function sales_first_hook( $query ){
  // / && $query->product_cat()
  // echo '<pre style="display:none;">';
  // print_r($query);
  // echo '</pre>';
  if( !is_admin() && $query->is_main_query() && $query->is_tax() ){
  
    $cat = $query->queried_object;
    $terms = get_terms( array(
      'taxonomy' => 'product_cat',
      'parent'     => $cat->term_id
    ) );

    if( $cat->taxonomy == 'product_cat' && !$terms ){
        // $query->set( 'post_type', 'product' );

        $query->set( 'orderby', array('_sale_price'=>'DESC', 'title'=>'ASC') );
        // $query->set( 'meta_key', '_sale_price' );
        $query->set( 'order', 'DESC' );
        $meta_query = array(
            'relation' => 'OR',
          array(
            'key' => '_sale_price',
            'compare' => 'EXISTS'
          ),
        );
        $query->set( 'meta_query', $meta_query );

      //   echo '<pre style="display:none;">';
      // print_r($query);
      // echo '</pre>';
      // die();
    }

  }
    
}



add_action( 'save_post_product', 'action_function_name_85245', 10, 3 );
function action_function_name_85245( $post_ID, $post, $update ) {
	$product = wc_get_product( $post_ID ); 
	if( $product->is_on_sale() && $product->is_type( 'variable' ) ) {
	    $prices = $product->get_variation_prices( true );
	    $big = '';
	    if($prices){
	    	foreach ($prices['sale_price'] as $key => $value) {
	    		if($big<$value){
	    			$big = $value;
	    		}
	    	}
	    }
	    update_post_meta($post_ID, '_sale_price', $sale_price );
	} else if( !isset($_POST['_sale_price']) ){
		update_post_meta($post_ID, '_sale_price', '' );
	} else {
		update_post_meta($post_ID, '_sale_price', $_POST['_sale_price'] );
	}
}