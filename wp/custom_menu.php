<?php 
/*--------------------------------------------------------Menus-----------------------------------------------*/
    class Menu_With_Description extends Walker_Nav_Menu {
      function start_el(&$output, $item, $depth, $args) {
        global $wp_query;
        $item->menu_settings = Menu_Icons_Settings::get_menu_settings( $item->ID );
        $settings = apply_filters( 'the_title', $item->title, $item->ID );
        //print_r($settings);

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        
        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';

        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

        $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        //$item_output .= print_r($item); apply_filters( 'the_title', $item->title, $item->ID )

        $item_output .= $args->link_before;
        $item_output .= '<div class="icon-container" >'. $settings .'</div>';
        $item_output .= '<div class="menu-name">' . $item->title .'</div>';
        $item_output .= '<div class="menu-subname">' . $item->description .'</div>';
        $item_output .= $args->link_after;

        /*if($item->menu_item_parent >0){
          $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        } else {
          $item_output .= '<div class="'.$link_class.'">'. $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after.'</div>';
        }
        if(!empty($item->description)  ){
            $item_output .= '<div class="subTitle">' . $item->description . '</div>';
        } */
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
      }
    }

    class standartMenu extends Walker_Nav_Menu {
      function start_el(&$output, $item, $depth, $args) {
        global $wp_query;
        $item->menu_settings = Menu_Icons_Settings::get_menu_settings( $item->ID );
        $settings = apply_filters( 'the_title', $item->title, $item->ID );
        //print_r($settings);

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        
        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';

        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

        $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
        $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        //$item_output .= print_r($item); apply_filters( 'the_title', $item->title, $item->ID )

        $item_output .= $args->link_before;
        //$item_output .= '<div class="icon-container" >'. $settings .'</div>';
        //$item_output .= preg_replace('/\s+/', '_', $item->title);
        $item_output .= $item->title;
        //$item_output .= '<div class="menu-name">' . $item->title .'</div>';
        //$item_output .= '<div class="menu-subname">' . $item->description .'</div>';
        $item_output .= $args->link_after;

        /*if($item->menu_item_parent >0){
          $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        } else {
          $item_output .= '<div class="'.$link_class.'">'. $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after.'</div>';
        }
        if(!empty($item->description)  ){
            $item_output .= '<div class="subTitle">' . $item->description . '</div>';
        } */
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
      }
    }
?>
    <?php $walker = new standartMenu; ?>
    <?php wp_nav_menu( array('container'=> 0, 'menu_id'=>'subpageMenu', 'menu_class' => 'subpage-menu', 'walker' => $walker ) ); ?>
