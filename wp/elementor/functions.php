<?php 


function divi_child_theme_setup() {
    if ( ! class_exists('ET_Builder_Module') ) {
        return;
    }

    get_template_part( 'custom-modules/fullportfolio' );

    $cfwpm = new Child_ET_Builder_Module_Fullwidth_Portfolio();
    // remove_shortcode( 'et_pb_fullwidth_portfolio' );
    
    add_shortcode( 'et_pb_fullwidth_portfolio', array($cfwpm, 'shortcode_callback') );

    get_template_part( 'custom-modules/blog' );

    $cfwpm = new Child_ET_Builder_Module_Blog();

    // remove_shortcode( 'et_pb_blog' ); //if we want rewrite parent shortcode
    
    add_shortcode( 'et_pb_blog', array($cfwpm, 'shortcode_callback') );
    
}

add_action( 'wp', 'divi_child_theme_setup', 9999 );


add_filter( 'et_epanel_layout_data', 'child_options' );

function child_options( $options ) {
    $part1 = array_slice($options, 0, 5 );
    $part2 = array_slice($options, 5 );
    $part1[] = array(
                "name"              => esc_html__( "Soe test field", $themename ),
                "id"                => "et_google_api_settings_api_key",
                "std"               => "",
                "type"              => "text",
                "validation_type"   => "nohtml",
                'is_global'         => true,
                'main_setting_name' => 'et_google_api_settings',
                'sub_setting_name'  => 'api_key',
                "desc"              => et_get_safe_localization( sprintf( __( 'The Maps module uses the Google Maps API and requires a valid Google API Key to function. Before using the map module, please make sure you have added your API key here. Learn more about how to create your Google API Key <a target="_blank" href="%1$s">here</a>.', $themename ), 'http://www.elegantthemes.com/gallery/divi/documentation/map/' ) ),
            ) ;


    $options = array_merge($part1, $part2);
    // echo '<pre style="display:none;">'; print_r($options); echo '</pre>';
    return $options;
}
