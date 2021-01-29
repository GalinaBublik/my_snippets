<?php 
/* Custom function of get archive values */
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

    /**
     * Filters the SQL WHERE clause for retrieving archives.
     *
     * @since 2.2.0
     *
     * @param string $sql_where Portion of SQL query containing the WHERE clause.
     * @param array  $parsed_args         An array of default arguments.
     */
    $where = apply_filters( 'getarchives_where', $sql_where, $parsed_args );

    /**
     * Filters the SQL JOIN clause for retrieving archives.
     *
     * @since 2.2.0
     *
     * @param string $sql_join    Portion of SQL query containing JOIN clause.
     * @param array  $parsed_args An array of default arguments.
     */
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
        if ( $results ) {
            $after = $parsed_args['after'];
            foreach ( (array) $results as $result ) {
                $url = get_month_link( $result->year, $result->month );
                if ( 'post' !== $parsed_args['post_type'] ) {
                    $url = add_query_arg( 'post_type', $parsed_args['post_type'], $url );
                }
                /* translators: 1: Month name, 2: 4-digit year. */
                // $text = sprintf( __( '%1$s %2$d' ), $wp_locale->get_month( $result->month ), $result->year );
                $text = sprintf( __( '%1$s' ), $wp_locale->get_month( $result->month ) );
                if ( $parsed_args['show_post_count'] ) {
                    $parsed_args['after'] = '&nbsp;(' . $result->posts . ')' . $after;
                }
                $selected = is_archive() && (string) $parsed_args['year'] === $result->year && (string) $parsed_args['monthnum'] === $result->month;
                $output  .= get_archives_link( $url, $text, $parsed_args['format'], $parsed_args['before'], $parsed_args['after'], $selected );
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
                $url = get_year_link( $result->year );
                if ( 'post' !== $parsed_args['post_type'] ) {
                    $url = add_query_arg( 'post_type', $parsed_args['post_type'], $url );
                }
                $text = sprintf( '%d', $result->year );
                if ( $parsed_args['show_post_count'] ) {
                    $parsed_args['after'] = '&nbsp;(' . $result->posts . ')' . $after;
                }
                $selected = is_archive() && (string) $parsed_args['year'] === $result->year;
                $output  .= get_archives_link( $url, $text, $parsed_args['format'], $parsed_args['before'], $parsed_args['after'], $selected );
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
                $url = get_day_link( $result->year, $result->month, $result->dayofmonth );
                if ( 'post' !== $parsed_args['post_type'] ) {
                    $url = add_query_arg( 'post_type', $parsed_args['post_type'], $url );
                }
                $date = sprintf( '%1$d-%2$02d-%3$02d 00:00:00', $result->year, $result->month, $result->dayofmonth );
                $text = mysql2date( get_option( 'date_format' ), $date );
                if ( $parsed_args['show_post_count'] ) {
                    $parsed_args['after'] = '&nbsp;(' . $result->posts . ')' . $after;
                }
                $selected = is_archive() && (string) $parsed_args['year'] === $result->year && (string) $parsed_args['monthnum'] === $result->month && (string) $parsed_args['day'] === $result->dayofmonth;
                $output  .= get_archives_link( $url, $text, $parsed_args['format'], $parsed_args['before'], $parsed_args['after'], $selected );
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
                    $output  .= get_archives_link( $url, $text, $parsed_args['format'], $parsed_args['before'], $parsed_args['after'], $selected );
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
                        /** This filter is documented in wp-includes/post-template.php */
                        $text = strip_tags( apply_filters( 'the_title', $result->post_title, $result->ID ) );
                    } else {
                        $text = $result->ID;
                    }
                    $selected = $result->ID === get_the_ID();
                    $output  .= get_archives_link( $url, $text, $parsed_args['format'], $parsed_args['before'], $parsed_args['after'], $selected );
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