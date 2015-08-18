<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

class WPSight_Listings_Map_Shortcode {

	/**
	 * __construct()
	 *
	 * @access public
	 */
	public function __construct() {
		add_shortcode( 'wpsight_listings_map', array( $this, 'shortcode_listings_map' ) );
	}

	/**
	 * shortcode_favorites()
	 *
	 * Show the listings search form.
	 *
	 * @param array   $attr Shortcode attributes
	 * @uses wpsight_search()
	 * @uses wp_kses_allowed_html()
	 *
	 * @return string $output Entire shortcode output
	 *
	 * @since 1.0.0
	 */
	public function shortcode_listings_map( $attr ) {

		// Define defaults

		$defaults = array(
			'nr'           => '',
			'width'        => '',
			'height'       => '',
			'map_type'     => '',
			'control_type' => '',
			'scrollwheel'  => '',
			'streetview'   => '',
			'before'       => '',
			'after'        => '',
			'wrap'         => 'div',
			'map_id'       => 'map-canvas'
		);

		// Merge shortcodes atts with defaults
		$atts = shortcode_atts( $defaults, $attr, 'wpsight_listings_map' );

		// Get the listings map with shortocde atts
		$listings_map = wpsight_listings_map( $atts );

		// Create shortcode output
		$output = sprintf( '%1$s%3$s%2$s', wp_kses_post( $atts['before'] ), wp_kses_post( $atts['after'] ), $listings_map );

		// Optionally wrap shortcode in HTML tags

		if ( ! empty( $atts['wrap'] ) && $atts['wrap'] != 'false' )
			$output = sprintf( '<%2$s class="wpsight-listings-map-sc">%1$s</%2$s>', $output, tag_escape( $atts['wrap'] ) );

		return apply_filters( 'wpsight_shortcode_listings_map', $output, $attr );

	}

}

new WPSight_Listings_Map_Shortcode();
