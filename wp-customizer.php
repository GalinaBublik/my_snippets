<?php
/**
 * Smplfy Dolphins Theme Customizer
 *
 * @package calc_battle
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function calc_battle_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
	// custom code
	$wp_customize->remove_section('colors');
	$wp_customize->remove_section('header_image');
	$wp_customize->remove_section('custom_css');
	$wp_customize->remove_section('background_image');
	
	$transport = 'postMessage';
	$wp_customize->add_section(
		'top_header_options', 
		array(
			'title'     => __( 'Header', 'calc-battle' ),
			'priority'  => 20,
			'description' => ''
		)
	);
		$wp_customize->add_setting(
			'calc_battle_directions_title', 
			array(
				'default'      => 'directions <span>555.555.5555</span>', 
				'transport'    => $transport
			)
		);
		$wp_customize->add_control(
			'calc_battle_directions_title',
			array(
				'section'  => 'top_header_options',
				'label'    => 'Directions title',
				'type'     => 'text'
			)
		);
		$wp_customize->add_setting(
			'calc_battle_directions_email', 
			array(
				'default'      => '#', 
				'transport'    => $transport
			)
		);
		$wp_customize->add_control(
			'calc_battle_directions_email',
			array(
				'section'  => 'top_header_options',
				'label'    => 'Directions email',
				'type'     => 'email'
			)
		);
		$wp_customize->add_setting(
			'calc_battle_credit_app_title', 
			array(
				'default'      => '1Credit app', 
				'transport'    => $transport
			)
		);
		$wp_customize->add_control(
			'calc_battle_credit_app_title',
			array(
				'section'  => 'top_header_options',
				'label'    => '1Credit app title',
				'type'     => 'text'
			)
		);
		$wp_customize->add_setting(
			'calc_battle_credit_app_email', 
			array(
				'default'      => '#', 
				'transport'    => $transport
			)
		);
		$wp_customize->add_control(
			'calc_battle_credit_app_email',
			array(
				'section'  => 'top_header_options',
				'label'    => '1Credit app email',
				'type'     => 'email'
			)
		);
		$wp_customize->add_setting(
			'calc_battle_get_quote_title', 
			array(
				'default'      => 'Get a Quote', 
				'transport'    => $transport
			)
		);
		$wp_customize->add_control(
			'calc_battle_get_quote_title',
			array(
				'section'  => 'top_header_options',
				'label'    => 'Get a Quote title',
				'type'     => 'text'
			)
		);
		$wp_customize->add_setting(
			'calc_battle_get_quote_email', 
			array(
				'default'      => '#', 
				'transport'    => $transport
			)
		);
		$wp_customize->add_control(
			'calc_battle_get_quote_email',
			array(
				'section'  => 'top_header_options',
				'label'    => 'Get a Quote email',
				'type'     => 'email'
			)
		);
		$wp_customize->add_setting(
			'calc_battle_page_title', 
			array(
				'default'      => 'bottled water', 
				'transport'    => $transport
			)
		);
		$wp_customize->add_control(
			'calc_battle_page_title',
			array(
				'section'  => 'top_header_options',
				'label'    => 'Page title',
				'type'     => 'text'
			)
		);
		$wp_customize->add_setting(
			'calc_battle_page_desc', 
			array(
				'default'      => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 
				'transport'    => $transport
			)
		);
		$wp_customize->add_control(
			'calc_battle_page_desc',
			array(
				'section'  => 'top_header_options',
				'label'    => 'Page description',
				'type'     => 'textarea'
			)
		);
		$wp_customize->add_setting(
			'calc_battle_page_background', 
			array(
				'default'      => '', 
				'transport'    => $transport
			)
		);
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,
			'calc_battle_page_background',
			array(
				'section'  => 'top_header_options',
				'label'    => 'Page background',
				'type'     => 'image'
			)
		) );
	
	$wp_customize->add_section(
			'contact_display_options', 
			array(
				'title'     => __( 'Footer', 'calc-battle' ),
				'priority'  => 110,
				'description' => ''
			)
	);
		
		$wp_customize->add_setting(
			'calc_battle_footer_contact', 
			array(
				'default'      => '', 
				'transport'    => $transport
			)
		);
		$wp_customize->add_control(
			'calc_battle_footer_contact',
			array(
				'section'  => 'contact_display_options',
				'label'    => 'Title contact',
				'type'     => 'text'
			)
		);
		$wp_customize->add_setting(
			'calc_battle_footer_menu', 
			array(
				'default'      => 'Menu', 
				'transport'    => $transport
			)
		);
		$wp_customize->add_control(
			'calc_battle_footer_menu',
			array(
				'section'  => 'contact_display_options',
				'label'    => 'Title menu',
				'type'     => 'text'
			)
		);
		$wp_customize->add_setting(
			'calc_battle_footer_info', 
			array(
				'default'      => 'Information', 
				'transport'    => $transport
			)
		);
		$wp_customize->add_control(
			'calc_battle_footer_info',
			array(
				'section'  => 'contact_display_options',
				'label'    => 'Title information',
				'type'     => 'text'
			)
		);
		$wp_customize->add_setting(
			'calc_battle_company',
			array(
				'default'     => 'Kimbro Water Company<br />2200 Clifton Avenue <br />Nashville, TN 37203', 
				'transport'   => $transport
			)
		);
		$wp_customize->add_control(
			'calc_battle_company',
			array(
				'section'  => 'contact_display_options',
				'label'    => 'Company',
				'type'     => 'textarea'
			)
		);
		$wp_customize->add_setting(
			'calc_battle_phone', 
			array(
				'default'      => '615-320-8720', 
				'transport'    => $transport
			)
		);
		$wp_customize->add_control(
			'calc_battle_phone',
			array(
				'section'  => 'contact_display_options',
				'label'    => 'Phone',
				'type'     => 'text'
			)
		);
		$wp_customize->add_setting(
			'calc_battle_fax',
			array(
				'default'     => '615-320-5916', 
				'transport'   => $transport
			)
		);
		$wp_customize->add_control(
			'calc_battle_fax',
			array(
				'section'  => 'contact_display_options',
				'label'    => 'Fax',
				'type'     => 'text'
			)
		);
		$wp_customize->add_setting(
			'calc_battle_bottled_by',
			array(
				'default'     => 'Bottled by CJR Bottling Company, Pall Mall, Tennessee.', 
				'transport'   => $transport
			)
		);
		$wp_customize->add_control(
			'calc_battle_bottled_by',
			array(
				'section'  => 'contact_display_options',
				'label'    => 'Bottled by',
				'type'     => 'text'
			)
		);
		$wp_customize->add_setting(
			'calc_battle_distributed',
			array(
				'default'     => 'Distributed by Kimbro Water Company.', 
				'transport'   => $transport
			)
		);
		$wp_customize->add_control(
			'calc_battle_distributed',
			array(
				'section'  => 'contact_display_options',
				'label'    => 'Distributed',
				'type'     => 'text'
			)
		);
		
		$wp_customize->add_setting(
			'calc_battle_facebook', 
			array(
				'default'      => 'https://facebook.com/', 
				'transport'    => $transport
			)
		);
		$wp_customize->add_control(
			'calc_battle_facebook',
			array(
				'section'  => 'contact_display_options',
				'label'    => 'Facebook',
				'type'     => 'email'
			)
		);
		$wp_customize->add_setting(
			'calc_battle_linkedin', 
			array(
				'default'      => 'https://linkedin.com/', 
				'transport'    => $transport
			)
		);
		$wp_customize->add_control(
			'calc_battle_linkedin',
			array(
				'section'  => 'contact_display_options',
				'label'    => 'Linkedin',
				'type'     => 'email'
			)
		);
		$wp_customize->add_setting(
			'calc_battle_twiter', 
			array(
				'default'      => 'https://twiter.com/', 
				'transport'    => $transport
			)
		);
		$wp_customize->add_control(
			'calc_battle_twiter',
			array(
				'section'  => 'contact_display_options',
				'label'    => 'Twiter',
				'type'     => 'email'
			)
		);
		
		$wp_customize->add_setting(
			'calc_battle_copyright', 
			array(
				'default'      => 'Copyright 2020 Kimbro Water Company. A Division of Kimbro Oil Company', 
				'transport'    => $transport
			)
		);
		$wp_customize->add_control(
			'calc_battle_copyright',
			array(
				'section'  => 'contact_display_options',
				'label'    => 'Copyright',
				'type'     => 'textarea'
			)
		);
}
add_action( 'customize_register', 'calc_battle_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function calc_battle_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function calc_battle_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function calc_battle_customize_preview_js() {
	wp_enqueue_script( 'calc-battle-customizer', get_template_directory_uri() . '/dist/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'calc_battle_customize_preview_js' );
