<?php 
/* Custom function of get archive values */
/*----------------------------------------------------- Functions.php -------------------------------------------*/

    function oneplsone_get_archives( $args = '' ) {
        global $wpdb, $wp_locale;

        $defaults = array(
            'type'            => 'monthly',
            'limit'           => '',
            'format'          => 'html',
            'before'          => '',
            'after'           => '',
            'show_post_count' => false,
            'echo'            => 1,
            'order'           => 'DESC',
            'post_type'       => 'post',
            'year'            => get_query_var( 'year' ),
            'monthnum'        => get_query_var( 'monthnum' ),
            'day'             => get_query_var( 'day' ),
            'w'               => get_query_var( 'w' ),
        );

        $parsed_args = wp_parse_args( $args, $defaults );

        $post_type_object = get_post_type_object( $parsed_args['post_type'] );
        if ( ! is_post_type_viewable( $post_type_object ) ) {
            return;
        }
        $parsed_args['post_type'] = $post_type_object->name;

        if ( '' == $parsed_args['type'] ) {
            $parsed_args['type'] = 'monthly';
        }

        if ( ! empty( $parsed_args['limit'] ) ) {
            $parsed_args['limit'] = absint( $parsed_args['limit'] );
            $parsed_args['limit'] = ' LIMIT ' . $parsed_args['limit'];
        }

        $order = strtoupper( $parsed_args['order'] );
        if ( $order !== 'ASC' ) {
            $order = 'DESC';
        }

        // this is what will separate dates on weekly archive links
        $archive_week_separator = '&#8211;';

        $sql_where = $wpdb->prepare( "WHERE post_type = %s AND post_status = 'publish'", $parsed_args['post_type'] );

        $where = apply_filters( 'getarchives_where', $sql_where, $parsed_args );

        $join = apply_filters( 'getarchives_join', '', $parsed_args );

        $output = '';

        $last_changed = wp_cache_get_last_changed( 'posts' );

        $limit = $parsed_args['limit'];

        if ( 'monthly' == $parsed_args['type'] ) {
            $query   = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date $order $limit";
            $key     = md5( $query );
            $key     = "wp_get_archives:$key:$last_changed";
            $results = wp_cache_get( $key, 'posts' );
            if ( ! $results ) {
                $results = $wpdb->get_results( $query );
                wp_cache_set( $key, $results, 'posts' );
            }
            $monthes = array();
            if ( $results ) {
                echo '<pre style="display:none;">';
                print_r($results);
                echo '</pre>';
                $after = $parsed_args['after'];
                foreach ( (array) $results as $result ) {
                    // $url = get_month_link( $result->year, $result->month );
                    // if ( 'post' !== $parsed_args['post_type'] ) {
                    //     $url = add_query_arg( 'post_type', $parsed_args['post_type'], $url );
                    // }
                    $url = $result->month;
                    // $text = sprintf( __( '%1$s %2$d' ), $wp_locale->get_month( $result->month ), $result->year );
                    $text = sprintf( __( '%1$s' ), $wp_locale->get_month( $result->month ) );
                    if ( $parsed_args['show_post_count'] ) {
                        $parsed_args['after'] = '&nbsp;(' . $result->posts . ')' . $after;
                    }
                    // $selected = is_archive() && (string) $parsed_args['year'] === $result->year && (string) $parsed_args['monthnum'] === $result->month;
                    $monthes[$url] = $text;
                }
                ksort($monthes, SORT_NUMERIC );
                reset($monthes);
                foreach( $monthes as $m => $month ){
                    $selected = get_query_var( 'monthnum' ) === $m ;

                    $output  .= get_archives_value( $m, $month, $parsed_args['format'], $parsed_args['before'], $parsed_args['after'], $selected );

                }
            }
        } elseif ( 'yearly' == $parsed_args['type'] ) {
            $query   = "SELECT YEAR(post_date) AS `year`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date) ORDER BY post_date $order $limit";
            $key     = md5( $query );
            $key     = "wp_get_archives:$key:$last_changed";
            $results = wp_cache_get( $key, 'posts' );
            if ( ! $results ) {
                $results = $wpdb->get_results( $query );
                wp_cache_set( $key, $results, 'posts' );
            }
            if ( $results ) {
                $after = $parsed_args['after'];
                foreach ( (array) $results as $result ) {
                    // $url = get_year_link( $result->year );
                    // if ( 'post' !== $parsed_args['post_type'] ) {
                    //     $url = add_query_arg( 'post_type', $parsed_args['post_type'], $url );
                    // }
                    $url = $result->year;
                    $text = sprintf( '%d', $result->year );
                    if ( $parsed_args['show_post_count'] ) {
                        $parsed_args['after'] = '&nbsp;(' . $result->posts . ')' . $after;
                    }
                    // $selected = is_archive() && (string) $parsed_args['year'] === $result->year;
                    $selected = get_query_var( 'year' );

                    $output  .= get_archives_value( $url, $text, $parsed_args['format'], $parsed_args['before'], $parsed_args['after'], $selected );
                }
            }
        } elseif ( 'daily' == $parsed_args['type'] ) {
            $query   = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, DAYOFMONTH(post_date) AS `dayofmonth`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date), DAYOFMONTH(post_date) ORDER BY post_date $order $limit";
            $key     = md5( $query );
            $key     = "wp_get_archives:$key:$last_changed";
            $results = wp_cache_get( $key, 'posts' );
            if ( ! $results ) {
                $results = $wpdb->get_results( $query );
                wp_cache_set( $key, $results, 'posts' );
            }
            if ( $results ) {
                $after = $parsed_args['after'];
                foreach ( (array) $results as $result ) {
                    // $url = get_day_link( $result->year, $result->month, $result->dayofmonth );
                    // if ( 'post' !== $parsed_args['post_type'] ) {
                    //     $url = add_query_arg( 'post_type', $parsed_args['post_type'], $url );
                    // }
                    $url = $result->dayofmonth;
                    $date = sprintf( '%1$d-%2$02d-%3$02d 00:00:00', $result->year, $result->month, $result->dayofmonth );
                    $text = mysql2date( get_option( 'date_format' ), $date );
                    if ( $parsed_args['show_post_count'] ) {
                        $parsed_args['after'] = '&nbsp;(' . $result->posts . ')' . $after;
                    }
                    $selected = is_archive() && (string) $parsed_args['year'] === $result->year && (string) $parsed_args['monthnum'] === $result->month && (string) $parsed_args['day'] === $result->dayofmonth;
                    $selected = get_query_var( 'year' );

                    $output  .= get_archives_value( $url, $text, $parsed_args['format'], $parsed_args['before'], $parsed_args['after'], $selected );
                }
            }
        } elseif ( 'weekly' == $parsed_args['type'] ) {
            $week    = _wp_mysql_week( '`post_date`' );
            $query   = "SELECT DISTINCT $week AS `week`, YEAR( `post_date` ) AS `yr`, DATE_FORMAT( `post_date`, '%Y-%m-%d' ) AS `yyyymmdd`, count( `ID` ) AS `posts` FROM `$wpdb->posts` $join $where GROUP BY $week, YEAR( `post_date` ) ORDER BY `post_date` $order $limit";
            $key     = md5( $query );
            $key     = "wp_get_archives:$key:$last_changed";
            $results = wp_cache_get( $key, 'posts' );
            if ( ! $results ) {
                $results = $wpdb->get_results( $query );
                wp_cache_set( $key, $results, 'posts' );
            }
            $arc_w_last = '';
            if ( $results ) {
                $after = $parsed_args['after'];
                foreach ( (array) $results as $result ) {
                    if ( $result->week != $arc_w_last ) {
                        $arc_year       = $result->yr;
                        $arc_w_last     = $result->week;
                        $arc_week       = get_weekstartend( $result->yyyymmdd, get_option( 'start_of_week' ) );
                        $arc_week_start = date_i18n( get_option( 'date_format' ), $arc_week['start'] );
                        $arc_week_end   = date_i18n( get_option( 'date_format' ), $arc_week['end'] );
                        $url            = add_query_arg(
                            array(
                                'm' => $arc_year,
                                'w' => $result->week,
                            ),
                            home_url( '/' )
                        );
                        if ( 'post' !== $parsed_args['post_type'] ) {
                            $url = add_query_arg( 'post_type', $parsed_args['post_type'], $url );
                        }
                        $text = $arc_week_start . $archive_week_separator . $arc_week_end;
                        if ( $parsed_args['show_post_count'] ) {
                            $parsed_args['after'] = '&nbsp;(' . $result->posts . ')' . $after;
                        }
                        $selected = is_archive() && (string) $parsed_args['year'] === $result->yr && (string) $parsed_args['w'] === $result->week;
                        $output  .= get_archives_value( $url, $text, $parsed_args['format'], $parsed_args['before'], $parsed_args['after'], $selected );
                    }
                }
            }
        } elseif ( ( 'postbypost' == $parsed_args['type'] ) || ( 'alpha' == $parsed_args['type'] ) ) {
            $orderby = ( 'alpha' == $parsed_args['type'] ) ? 'post_title ASC ' : 'post_date DESC, ID DESC ';
            $query   = "SELECT * FROM $wpdb->posts $join $where ORDER BY $orderby $limit";
            $key     = md5( $query );
            $key     = "wp_get_archives:$key:$last_changed";
            $results = wp_cache_get( $key, 'posts' );
            if ( ! $results ) {
                $results = $wpdb->get_results( $query );
                wp_cache_set( $key, $results, 'posts' );
            }
            if ( $results ) {
                foreach ( (array) $results as $result ) {
                    if ( $result->post_date != '0000-00-00 00:00:00' ) {
                        $url = get_permalink( $result );
                        if ( $result->post_title ) {
                            $text = strip_tags( apply_filters( 'the_title', $result->post_title, $result->ID ) );
                        } else {
                            $text = $result->ID;
                        }
                        $selected = $result->ID === get_the_ID();
                        $output  .= get_archives_value( $url, $text, $parsed_args['format'], $parsed_args['before'], $parsed_args['after'], $selected );
                    }
                }
            }
        }
        if ( $parsed_args['echo'] ) {
            echo $output;
        } else {
            return $output;
        }
    }

    function get_archives_value( $url, $text, $format = 'html', $before = '', $after = '', $selected = false ) {
        $text         = wptexturize( $text );
        $url          = esc_attr( $url );
        $aria_current = $selected ? ' aria-current="page"' : '';

        if ( 'link' === $format ) {
            $link_html = "\t<link rel='archives' title='" . esc_attr( $text ) . "' href='$url' />\n";
        } elseif ( 'option' === $format ) {
            $selected_attr = $selected ? " selected='selected'" : '';
            $link_html     = "\t<option value='$url'$selected_attr>$before $text $after</option>\n";
        } elseif ( 'html' === $format ) {
            $link_html = "\t<li>$before<a href='$url'$aria_current>$text</a>$after</li>\n";
        } else { // Custom.
            $link_html = "\t$before<a href='$url'$aria_current>$text</a>$after\n";
        }
        return $link_html;
    }



/*----------------------------------------------------- filter form hmtl -------------------------------------------*/

    global $projects;
    $request = $_REQUEST;
    unset($request['order']);
    $request = remove_empty($request);
    // echo '<pre style="display:none;">';
    // print_r($request);
    // echo '</pre>';
?>

<!-- filter_head -->
<div class="filter_head">
<div class="filters__results <?php if(isset($request) && !empty($request) ){ echo 'filtered'; } ?>">
    <h6 class="filters__results_title">Use Filters</h6>
    <div class="filters__results_info">
        <h6 class="filters__results_title">Found Projects</h6>
        <div class="filters__results_count">
            <span><?php echo $projects->found_posts; ?></span>
        </div>
        <a href="javascript:void(0);" class="reset__filters">Reset Filters</a>
    </div>
</div>
</div>
<!-- filter_head -->
<form class="filters__selectors filter_form ajax_submit" id="pr_fil" method="get" action="<?php the_permalink(); ?>">

        <?php $taxonomies = get_taxonomies( array(
            'object_type' => array('project')
        ), 'objects' ); 
        if($taxonomies){ 
        foreach ($taxonomies as $key => $tax) { 
            // echo '<pre style="display:none;">';
            // print_r($tax);
            // echo '</pre>'; ?>
            <div class="selector">
                <span class="selector__title"><?php echo $tax->labels->singular_name; ?></span>
                <select name="<?php echo $tax->name; ?>" id="<?php echo $tax->name; ?>" >
                    <option value="">All</option>
                    <?php $terms = get_terms( array(
                        'taxonomy'      => $tax->name,
                        'orderby'       => 'id', 
                        'order'         => 'ASC',
                        'hide_empty'    => true, 
                        'object_ids'    => null,
                        'number'        => '', 
                        'fields'        => 'all', 
                        'parent'         => 0,
                        'hierarchical'  => false, 
                        'child_of'      => 0, 
                    ) ); 
                    if( $terms ){
                        foreach ($terms as $k => $term ) { ?>
                            <option value="<?php echo $term->term_id; ?>" <?php if( isset($_REQUEST[$tax->name]) ){ selected($_REQUEST[$tax->name], $term->term_id); } ?>><?php echo $term->name; ?></option>
                        <?php }
                    } ?>
                </select>
            </div>
        <?php }  } ?>
        
        <div class="selector">
            <span class="selector__title">sort by</span>
            <select name="order" id="">
                <option value="date-DESC" <?php if( isset($_REQUEST['order']) ){ selected('date-DESC', $_REQUEST['order']); } ?>>Newest First</option>
                <option value="date-ASC" <?php if( isset($_REQUEST['order']) ){ selected('date-ASC', $_REQUEST['order']); } ?>>Oldest First</option>
                <option value="title-ASC" <?php if( isset($_REQUEST['order']) ){ selected('title-ASC', $_REQUEST['order']); } ?>>Project Name: A-Z</option>
                <option value="title-DESC" <?php if( isset($_REQUEST['order']) ){ selected('title-DESC', $_REQUEST['order']); } ?>>Project Name: Z-A</option>
            </select>
        </div>
</form>

<!-- /*----------------------------------------------------- filter form hmtl -------------------------------------------*/ -->
<script type="text/javascript">
( function( $ ) {
    let doc = $(document);
    let win = $(window);

    function get_filter_result(pageurl, order = false){
        // console.log('send form', order);

        $.get(pageurl).done(function (data) {
            // console.log(data);
            let head = data.split('<!-- filter_head -->');

            if( head.length >2 ){
                $('.filter_head').html(head[1]);
            }

            let part = data.split('<!-- result-wrapper -->')
            $( '.content-wrapper' ).html(part[1]);
            let test = new RegExp('<!-- filter_head -->');
            if( test.test(data) && !order ){
                let part = data.split('<!-- filter_head -->')
                $( '.filter_head' ).html(part[1]);
            }

            slide_initiate();
            window.history.pushState({path:pageurl},'',pageurl);
            if( $('.modal__window_close').length >0 ){
                $('.modal__window_close').trigger('click'); 
            }
            
            //barba.Pjax.goTo(pageurl);
        });
    }

    function auto_submit_form(){
        $('.ajax_submit input, .ajax_submit select, .ajax_submit textarea').unbind('change').off('change');
        $('.ajax_filter input, .ajax_filter select, .ajax_filter textarea').unbind('change').off('change');
        $('.ajax_filter').unbind('submit').off('submit');

        $('.ajax_submit input, .ajax_submit select, .ajax_submit textarea').on('change', function(){
            // console.log($(this).attr('name'), $(this).val());
            let order = false;
            if( $(this).attr('name') == 'order' ){
                order = true;
            }
            if( $('.filters__results_list').length >0 && $(this).prop('checked') ){
                if( !$(this).val() ){
                    $('.filter_category').prop('checked', false).removeAttr('checked').removeClass('checked');
                    $('.filters__results_list').html('');
                } else {
                    $('.all_category').prop('checked', false).removeAttr('checked').removeClass('checked');
                    $('.filters__results_list').append(`<li>
                        <a href="javascript:void(0);" class="btn-filter remove_category" data-id="`+$(this).val()+`">
                            `+$(this).closest('label').text()+`
                            <img src="`+theme+`/img/close-icon-small.svg" alt="">
                        </a>
                    </li>`);
                }
            }

            let form = $(this).closest('form');
            // let jsForm = document.getElementById(form.attr('id'));
            let url = form.attr("action");
            let formData = $(form).serialize();
            // let formData = new FormData(jsForm)
            let test = new RegExp(/\?/);

                // const queryString = new URLSearchParams(formData).toString();

                // console.log(url);
                // console.log(formData);
                // console.log(queryString);
            let pageurl = ( test.test(url+formData) ) ? url+formData : url+'?'+formData;
            // stop();
            setTimeout(function(){
                // console.log('timeout before send', order);

                get_filter_result(pageurl, order);
                $('#blog_filter .filters__results').stop().addClass('filtered');
            }, 500);
        });
        $('.ajax_filter').on('submit', function(e){
            e.preventDefault();
            let form = $(this).closest('form');
            let url = form.attr("action");
            let formData = $(form).serialize();
            let test = new RegExp(/\?/);
            let pageurl = ( test.test(url+formData) ) ? url+formData : url+'?'+formData;
            get_filter_result(pageurl, false);

        });

        $('.ajax_filter input, .ajax_filter select, .ajax_filter textarea').on('change', function(){
            if( $('.filters__results_list').length >0 && $(this).prop('checked') ){
                if( !$(this).val() ){
                    $('.filter_category').prop('checked', false).removeAttr('checked').removeClass('checked');
                } else {
                    $('.all_category').prop('checked', false).removeAttr('checked').removeClass('checked');
                }
            }
            let form = $(this).closest('form');
            // let jsForm = document.getElementById(form.attr('id'));
            let url = form.attr("action");
            let formData = $(form).serialize();
            // let formData = new FormData(jsForm)
            let test = new RegExp(/\?/);
                // const queryString = new URLSearchParams(formData).toString();

                // console.log(url);
                // console.log(formData);
                // console.log(queryString);
            let pageurl = ( test.test(url+formData) ) ? url+formData : url+'?'+formData;
            // stop();
            // setTimeout(function(){
                $.get(pageurl).done(function (data) {
                    // console.log(data);
                    let count = data.split('<!-- count -->');

                    if( count.length >2 ){
                        $('.count').html(count[1]);
                    }
                });
            // }, 500);
            
        });

        $(document).on( 'click', '.remove_category', function(){
            let id = $(this).attr('data-id');
            // console.log(id, '!!!!!!!!!!');

            $('[value="'+id+'"]').removeAttr('checked').prop('checked', false);
            $('[value="'+id+'"]').closest('div.filter_category').removeClass('checked');
            $(this).closest('li').remove();
        });

        doc.on('click', '.reset__filters', function(){
            $('.filters__results').stop().removeClass('filtered');
            let form = $(this).closest('#main').find('.ajax_submit');
            form[0].reset();
            
            form.trigger('reset');
            $('option').removeAttr('selected');
            $('input').removeAttr('checked').prop('checked', false);
            if( $('.filters__results_list').length > 0 ){
                $('.filters__results_list').html('');
            }
            
                        // let id = $(this).closest('#main').find('.ajax_submit').attr('id');
            // document.getElementById('pr_fil').reset();
            $('input, select').trigger('refresh');
            // window.location = form.attr('action');
            // window.history.pushState({path:form.attr('action')},'',);
            if( $('.selector__options_list').length  ){
                $('.all_category').addClass('checked');
                $('.selector__options_list input:first').prop('checked', true).attr('checked', 'checked');
            }
            get_filter_result(form.attr('action'));
            // $('select').styler('destroy');
            // setTimeout(function() {
            //  $('select').styler();
            // }, 1);
            // .trigger('reset');
        });
    }

    go_event_functions = function(){
        auto_submit_form();

    }

    $( document ).ready( function() {
        go_event_functions();
    });
    $( document ).ajaxComplete( function() {
        console.log('complete');
        go_event_functions();


    });

</script>