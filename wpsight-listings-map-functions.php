<?php
/**
 * wpsight_listings_map()
 *
 * Create a Google map displaying
 * the latest listings.
 *
 * @param array $atts Array of arguments for the map display *
 * @uses wp_parse_args()
 * @uses wpsight_get_option()
 * @uses intval()
 * @uses sanitize_text_field()
 * @uses tag_escape()
 * @uses wpsight_get_listings()
 * @uses wpsight_get_template_part()
 *
 * @return mixed Listings map output
 *
 * @since 1.0.0
 */
function wpsight_listings_map( $atts = array() ) {
	global $map_query, $args;
		
	// Define defaults
	
	$defaults = array(
	    'nr'	 	 	=> '',
	    'width'		 	=> '',
	    'height'	 	=> '',
	    'map_type'		=> '',
		'control_type'	=> '',
		'scrollwheel'	=> '',
	    'streetview' 	=> ''
	);
	
	// Parse incoming $atts into an array and merge it with $defaults
	$args = wp_parse_args( $atts, $defaults );
	
	// Check number of listings
	
	if( ! $args['nr'] ) {	        
	    $option = wpsight_get_option( 'listings_map_nr' );
	    $args['nr'] = intval( $option );	        
	} else {	        
	    $args['nr'] = intval( $args['nr'] );	        
	}
	
	// Check default width
	
	if( ! $args['width'] ) {	        
	    $option = wpsight_get_option( 'listings_map_width' );
	    $args['width'] = sanitize_text_field( $option );	        
	} else {	        
	    $args['width'] = sanitize_text_field( $args['width'] );	        
	}
	
	// Check default height
	
	if( ! $args['height'] ) {	        
	    $option = wpsight_get_option( 'listings_map_height' );	        
	    $args['height'] = tag_escape( $option );	        
	} else {	        
	    $args['height'] = tag_escape( $args['height'] );	        
	}
	
	// Check default option 'map_type'
	
	if( ! $args['map_type'] ) {	        
	    $option = wpsight_get_option( 'listings_map_type' );	        
	    if( $option ) {		        
	        $args['map_type'] = in_array( $option, array( 'ROADMAP', 'SATELLITE', 'HYBRID', 'TERRAIN' ) ) ? $option : $defaults['map_type'];		        
	    } else {		        
	        $args['map_type'] = 'ROADMAP';		        
	    }	        
	}
	
	// Check default option 'control_type'
	
	if( ! $args['control_type'] ) {	        
	    $option = wpsight_get_option( 'listings_map_control_type' );	        
	    $args['control_type'] = $option ? 'true' : 'false';	        
	} else {
		$args['control_type'] = in_array( $args['control_type'], array( 'true', 'false' ) ) ? $args['control_type'] : $defaults['control_type'];
	}
	
	// Check default option 'scrollwheel'
	
	if( ! $args['scrollwheel'] ) {	        
	    $option = wpsight_get_option( 'listings_map_scrollwheel' );	        
	    $args['scrollwheel'] = $option ? 'true' : 'false';	        
	} else {
		$args['scrollwheel'] = in_array( $args['scrollwheel'], array( 'true', 'false' ) ) ? $args['scrollwheel'] : $defaults['scrollwheel'];
	}
	
	// Check default option 'streetview'
	
	if( ! $args['streetview'] ) {	        
	    $option = wpsight_get_option( 'listings_map_streetview' );	        
	    $args['streetview'] = $option ? 'true' : 'false';	        
	} else {
		$args['streetview'] = in_array( $args['streetview'], array( 'true', 'false' ) ) ? $args['streetview'] : $defaults['streetview'];
	}
	
	// Get map listings
	$map_query = wpsight_get_listings( array( 'nr' => $args['nr'] ) );
	
	ob_start();
	
	if( $map_query->have_posts() ) {			
		wpsight_get_template_part( 'listings', 'map', $args, WPSIGHT_LISTINGS_MAP_PLUGIN_DIR . '/templates/' );		
	} else {			
		wpsight_get_template_part( 'listings', 'no', $args, WPSIGHT_LISTINGS_MAP_PLUGIN_DIR . '/templates/' );		    
	}
	
	return apply_filters( 'wpsight_listings_map', ob_get_clean(), $args );
	
}
