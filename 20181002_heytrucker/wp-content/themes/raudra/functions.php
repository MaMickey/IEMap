<?php
	
/*
*
*	Raudra - i-excel Child Theme
*	------------------------------------------------
*	These functions will override the parent theme
*	functions.
*
*
*/
	
add_action( 'wp_enqueue_scripts', 'raudra_enqueue_styles' );
function raudra_enqueue_styles() {
    wp_enqueue_style( 'raudra-parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'raudra-custom-style', get_stylesheet_directory_uri() . '/css/custom-style.css' );	
	
	// Loads JavaScript file with functionality specific to raudra
	wp_enqueue_script( 'raudra-script', get_stylesheet_directory_uri() . '/js/functions.js', array( 'jquery' ), '2013-07-18', true );
	wp_localize_script( 'raudra-script', 'raudra_url', get_stylesheet_directory_uri() );
	
		
    $color = get_theme_mod( 'primary_color', '#c8367d' ); //E.g. #FF0000
    $custom_css = '

					.tx-service.curved .tx-service-icon span, 
					.tx-service.square .tx-service-icon span {
						background-color: ' . $color . ';
					}
					.tx-service .tx-service-icon span:hover i:before {
						color:  ' . $color . '!important;
					}
					.tx-service.curved .tx-service-icon span:hover, 
					.tx-service.square .tx-service-icon span:hover {
						border: 6px solid ' . $color . ';
					}					
				
				';
    wp_add_inline_style( 'raudra-custom-style', $custom_css );		
}



/*********************************
	After theme switch default customizer settings value change
**********************************/

function raudra_setup_options () {
	
	if( get_theme_mod('child_default_settings', 0) != 1 ) {
		
		set_theme_mod( 'blog_trans_header', '1' );		
		set_theme_mod( 'itrans_align', 'nxs-left' );		
		set_theme_mod( 'itrans_overlay', 'nxs-excel19' );		
		set_theme_mod( 'boxed-icons', '1' );
		set_theme_mod( 'slider_height', '100' );		
		set_theme_mod( 'slider_reduction', '32' );	
		
		set_theme_mod( 'logo', esc_url(get_stylesheet_directory_uri() . '/images/logo-black.png') );		
		set_theme_mod( 'logo_trans', esc_url(get_stylesheet_directory_uri() . '/images/logo-white.png') );
					
	}
	
	//End of settings adjustment
	set_theme_mod( 'child_default_settings', '1' );
}
add_action('after_switch_theme', 'raudra_setup_options');


/* Pre settings value change */
function raudra_body_class( $classes ) {	
	// Pre setting adjustment
	if( get_theme_mod('child_default_settings', 0) != 1 ) {
		$classes[] = 'nx-fullscreen';
		$classes[] = 'pre-raudra-setup';
	}
	return $classes;
}
add_filter( 'body_class', 'raudra_body_class' );


function raudra_custom_setting( $controls ) {
	
	$controls[] = array(
		'type'        => 'switch',
		'settings'     => 'child_default_settings',
		'label'       => esc_attr__( 'Overwrites Custom Settings', 'raudra' ),
		'description' => esc_attr__( 'Keep it turned ON, or default values will override certain values.', 'raudra' ),
		'section'     => 'nxpromo',
		'default'  	  => 0,		
		'priority'    => 100,
	);		 	
	
	
    return $controls;
}
add_filter( 'kirki/controls', 'raudra_custom_setting' );


