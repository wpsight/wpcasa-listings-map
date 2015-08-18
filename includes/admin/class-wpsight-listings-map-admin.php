<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * WPSight_Listings_Map_Admin class
 */
class WPSight_Listings_Map_Admin {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_filter( 'wpsight_settings', array( $this, 'listings_map_settings' ) );
	}

	public function listings_map_settings( $options ) {

		$options['listings_map'] = array(

			__( 'Map', 'wpsight' ),
			array(
				'listings_map_page' => array(
					'name' => __( 'Page', 'wpsight-listings-map' ),
					'desc' => __( 'Please select the page that contains the listings page shortcode.', 'wpsight-listings-map' ),
					'id'   => 'listings_map_page',
					'type' => 'pages'
				),
				'listings_map_nr' => array(
					'name' => __( 'Number', 'wpsight-listings-map' ),
					'desc' => __( 'Please enter the default number of listings shown on the map (<code>-1</code> to show all).', 'wpsight-listings-map' ),
					'id'   => 'listings_map_nr',
					'type' => 'text'
				),
				'listings_map_width' => array(
					'name' => __( 'Width', 'wpsight-listings-map' ),
					'desc' => __( 'Please enter the default width of the map (in <code>px</code> or <code>%</code>).', 'wpsight-listings-map' ),
					'id'   => 'listings_map_width',
					'type' => 'text'
				),
				'listings_map_height' => array(
					'name' => __( 'Height', 'wpsight-listings-map' ),
					'desc' => __( 'Please enter the default height of the map (in <code>px</code>).', 'wpsight-listings-map' ),
					'id'   => 'listings_map_height',
					'type' => 'text'
				),
				'listings_map_type' => array(
					'name'  => __( 'Type', 'wpsight-listings-map' ),
					'desc'  => __( 'Please select the default map type.', 'wpsight-listings-map' ),
					'options' => array(
						'ROADMAP'   => __( 'Roadmap', 'wpsight-listings-map' ),
						'SATELLITE' => __( 'Sattelite', 'wpsight-listings-map' ),
						'HYBRID'    => __( 'Hybrid', 'wpsight-listings-map' ),
						'TERRAIN'   => __( 'Terrain', 'wpsight-listings-map' )
					),
					'id'   => 'listings_map_type',
					'type' => 'select'
				),
				'listings_map_control_type' => array(
					'name'     => __( 'Type Control', 'wpsight-listings-map' ),
					'cb_label' => __( 'Display type control', 'wpsight-listings-map' ),
					'desc'     => __( 'Let the user change the map type.', 'wpsight-listings-map' ),
					'id'       => 'listings_map_control_type',
					'type'     => 'checkbox'
				),
				'listings_map_scrollwheel' => array(
					'name'     => __( 'Scrollwheel', 'wpsight-listings-map' ),
					'cb_label' => __( 'Enable scroll wheel', 'wpsight-listings-map' ),
					'desc'     => __( 'Let the user change the map zoom using the scrollwheel.', 'wpsight-listings-map' ),
					'id'       => 'listings_map_scrollwheel',
					'type'     => 'checkbox'
				),
				'listings_map_streetview' => array(
					'name'     => __( 'Streetview', 'wpsight-listings-map' ),
					'cb_label' => __( 'Enable streetview', 'wpsight-listings-map' ),
					'desc'     => __( 'Let the user activate streetview on the map.', 'wpsight-listings-map' ),
					'id'       => 'listings_map_streetview',
					'type'     => 'checkbox'
				)
			)

		);

		return $options;

	}
}

// Call class
new WPSight_Listings_Map_Admin();
