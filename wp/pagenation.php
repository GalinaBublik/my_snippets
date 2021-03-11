<?php /**----------------------After loop */
if($projects->max_num_pages >1 ){  ?>
<div class="more">
	<a href="javascript:void(0);" data-type="project"  class="btn pagenavy_btn" data-max="<?php echo $projects->max_num_pages; ?>" data-page="2">load more
	</a>
</div>
<?php } ?>
<script type="text/javascript">
	function infinity_pagenation(){
		let page = 0;
		let spage = 0;

		if( $('.pagenavy_btn').length >0 ){
			doc.on('click', '.pagenavy_btn', function(){
				let pn = $(this);
				let pagenum = pn.attr('data-page');
				let pt = pn.offset().top;
				// console.log(pt);
				let $page = pn.attr('data-page');
				let $type = pn.attr('data-type');
				let $block = pn.closest('.preview__grid').find('.result__list');
				let $filter = '';
				if( pn.closest('.filters__segment').find('.filter_form').length >0 ){
					$filter = pn.closest('.filters__segment').find('.filter_form').serialize();
				}
				// console.log(st);
				// console.log(pt);
				if( !page ){
					page = 1;
					$('.infinity-loader').show(10);
					$.ajax({
						url:ajaxurl,
						data: { action: 'getNextPagenation' , page: $page, type: $type, filter: $filter },
			            dataType: 'html',
						type: "POST",
						success:function(data){
							page = 0;
							// if( data.success ==1 ){
								//add new posts to you posts wrapper
							$('.result__list').append(data);
							pagenum++;
							pn.attr('data-page', pagenum);
							if(pagenum > pn.data('max')){
								pn.hide();
							}
							// } 
							// console.log(data);
							$('.infinity-loader').hide(10);
						}
					});
				} 
			}, );
		}
		if( $('.pagenavy').length >0 ){
			let pn = $('.pagenavy');
			let pagenum = pn.attr('data-page');
			win.on('scroll', function(){
				let st = $(this).scrollTop();
				let pt = pn.offset().top;
				// console.log(pt);
				let $page = pn.attr('data-page');
				let $type = pn.attr('data-type');
				let $block = pn.closest('.tab-pane').find('.result-wrapper');
				let $filter = '';
				if( pn.closest('.tab-pane').find('.filter_form').length >0 ){
					$filter = pn.closest('.tab-pane').find('.filter_form').serializeArray();
				}
				// console.log(st);
				// console.log(pt);
				if( !page && st >= pt-(win.height()+700) ){
					page = 1;
					$('.infinity-loader').show(10);
					$.ajax({
						url:ajaxurl,
						data: { action: 'getNextPagenation' , page: $page, type: $type, filter: $filter },
			            dataType: 'html',
						type: "POST",
						success:function(data){
							page = 0;
							// if( data.success ==1 ){
							$('.result__list').append(data);
							pagenum++;
							pn.attr('data-page', pagenum);
							if(pagenum > pn.data('max')){
								pn.hide();
							}
							// } 
							// console.log(data);
							$('.infinity-loader').hide(10);
						}
					});
				} else {
					// $('.infinity-loader').hide(10);
				}
			}, );
		}

			$('.search__results_box_inner_bottom').unbind('scroll');
			$('.search__results_box_inner_bottom').off('scroll');
		if( $('.search_pagy').length >0 ){
			// console.log('111111111');
			let pn = $('.search_pagy');
			let pagenum = pn.attr('data-page');
			$('.search__results_box_inner_bottom').on('scroll', function(){

				let st = $(this).scrollTop();
				let pt = $('.result__list').height();
				// console.log(st);
				// console.log(pt);
				let $page = pn.attr('data-page');
				let $block = $('.result__list');
				// console.log(spage);
				
				// console.log(st);
				// console.log(pt);
				if( !spage && st >= pt-win.height() ){
					spage = 1;
					$('.infinity-loader').show(10);
					$.ajax({
						url:ajaxurl,
						data: { action: 'getNextPagenation' , page: $page, s: $('#search').val()  },
			            dataType: 'html',
						type: "POST",
						success:function(data){
							
							// if( data.success ==1 ){
							$('.result__list').append(data);
							pagenum++;
							pn.attr('data-page', pagenum);
							if(pagenum > pn.data('max')){
								pn.hide();
							}
							spage = 0;
							// } 
							// console.log(data);
							$('.infinity-loader').hide(10);
						}
					});
				} else {
					// $('.infinity-loader').hide(10);
				}
			}, {passive: true});
		}
	}
</script>
<?php 
/**----------------------functions.php */
	add_action( 'wp_ajax_getNextPagenation', 'getNextPagenation' );
    add_action( 'wp_ajax_nopriv_getNextPagenation', 'getNextPagenation' );
    
    function getNextPagenation() {
        // $sticky = get_option( 'sticky_posts' );
        $args = array(
            'paged' => $_POST['page'],
            'post_status'=> 'publish',
            
            'posts_per_page' => 2,
            // 'ignore_sticky_posts' => 1,
            // 'offset' => 2
        );
        if( isset($_POST['type']) && !empty($_POST['type']) ){
            $args['post_type'] = $_POST['type'];
            $type = $_POST['type'];
        }
        if( isset($_POST['s']) && !empty($_POST['s']) ){
            $args['s'] = $_POST['s'];
            $args['post_type'] = 'any';
            $type = 'search';
        }
        if( isset($_POST['filter']) && !empty($_POST['filter']) ){
            parse_str( $_POST['filter'] , $filter );
            $terms = array();
            foreach ($filter as $key => $query) {
                
                if( !empty($query) ){
                    if( $key == 'order' ){
                        $order = explode('-', $query);
                        $args['orderby'] = $order[0];
                        $args['order'] = $order[1];
                    } else {
                        $terms[] = array(
                            'taxonomy' => $key,
                            'field'    => 'id',
                            'terms'    => array( $query ),
                            'operator' => 'IN',
                        );
                    }
                }

                # code...
            }
            if(!empty($terms)){
                $terms['relation'] = 'AND';
                $args['tax_query'] = $terms;
            }
            

        }

        /*if($_POST['type'] == 'project'){
            $args['post_type'] = 'project';

            $args['tax_query'] = array(
                'relation' => 'OR',
                 array(
                    'taxonomy' => 'project_category',
                    'field' => 'id',
                    'terms' => $_POST['cat']

                ));

        } else {
            $args['cat'] = $_POST['cat'];
            $args['pagename'] = 'blog';
            $args['is_posts_page'] = 1;

        }*/
        $posts = new WP_Query($args);
        echo '<pre style="display:none;">111111';
        print_r($filter);
        print_r($posts);
        echo '</pre>';
        if ( $posts->have_posts() ) : $i=0; ?>
                <?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
                   
                    <?php get_template_part( 'content', $type ); ?>

                <?php $i++; endwhile; // end of the loop. ?>
            <?php endif;
        wp_die();

    }