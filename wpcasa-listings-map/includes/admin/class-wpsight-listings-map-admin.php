<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * WPSight_Listings_Map_Admin class
 */
class WPSight_Listings_Map_Admin {

	/**
	 *	Constructor
	 */
	public function __construct() {
		
		// Add addon options to general plugin settings
		add_filter( 'wpsight_options', array( $this, 'options' ) );
		
		// Add meta box option to exclude listing
		add_filter( 'wpsight_meta_box_listing_location_fields', array( $this, 'meta_box' ) );

	}

	/**
	 *	listings_map_options()
	 *	
	 *	Add add-on options to settings page
	 *
	 *	@param	array	$options	Registered options	
	 *	@return	array	$options
	 *	
	 *	@since 1.0.0
	 */
	public function options( $options ) {
		
		$options_listings_map = array(
			
			'listings_map_page' => array(
				'name' 		=> __( 'Map Page', 'wpcasa-listings-map' ),
				'desc' 		=> __( 'Please select the page that contains the listings map shortcode.', 'wpcasa-listings-map' ),
				'id'   		=> 'listings_map_page',
				'type' 		=> 'pages'
			),
			'listings_map_panel' => array(
				'name'     	=> __( 'Listings Panel', 'wpcasa-listings-map' ),
				'cb_label' 	=> __( 'Show toggle link in listings panel', 'wpcasa-listings-map' ),
				'desc'     	=> __( 'Will show a link in the listings panel (next to orderby options) and the map below when clicked.', 'wpcasa-listings-map' ),
				'id'       	=> 'listings_map_panel',
				'type'     	=> 'checkbox',
			),
			'listings_map_panel_link' => array(
				'name'     	=> __( 'Link Text', 'wpcasa-listings-map' ),
				'desc'     	=> __( 'Please enter the text for the listings panel link.', 'wpcasa-listings-map' ),
				'id'       	=> 'listings_map_panel_link',
				'type'     	=> 'text',
				'default'	=> __( 'Toggle Map', 'wpcasa-listings-map' ),
			),
			'listings_map_nr' => array(
				'name' 		=> __( 'Number', 'wpcasa-listings-map' ),
				'desc' 		=> __( 'Please enter the maximum number of listings (<code>-1</code> to show all).', 'wpcasa-listings-map' ),
				'id'   		=> 'listings_map_nr',
				'type' 		=> 'text',
				'default'	=> 50,
			),
			'listings_map_width' => array(
				'name' 		=> __( 'Width', 'wpcasa-listings-map' ),
				'desc' 		=> __( 'Please enter the default width of the map (in <code>px</code> or <code>%</code>).', 'wpcasa-listings-map' ),
				'id'   		=> 'listings_map_width',
				'type' 		=> 'text',
				'default'	=> '100%',
			),
			'listings_map_height' => array(
				'name' 		=> __( 'Height', 'wpcasa-listings-map' ),
				'desc' 		=> __( 'Please enter the default height of the map (in <code>px</code>).', 'wpcasa-listings-map' ),
				'id'   		=> 'listings_map_height',
				'type' 		=> 'text',
				'default'	=> '600px',
			),
			'listings_map_type' => array(
				'name' 		=> __( 'Type', 'wpcasa-listings-map' ),
				'desc'		=> __( 'Please select the default map type.', 'wpcasa-listings-map' ),
				'options'	=> array(
					'ROADMAP'   => __( 'Roadmap', 'wpcasa-listings-map' ),
					'SATELLITE' => __( 'Sattelite', 'wpcasa-listings-map' ),
					'HYBRID'    => __( 'Hybrid', 'wpcasa-listings-map' ),
					'TERRAIN'   => __( 'Terrain', 'wpcasa-listings-map' )
				),
				'id'   		=> 'listings_map_type',
				'type' 		=> 'select',
				'default'	=> 'ROADMAP',
			),
			'listings_map_control_type' => array(
				'name'     	=> __( 'Type Control', 'wpcasa-listings-map' ),
				'cb_label' 	=> __( 'Display type control', 'wpcasa-listings-map' ),
				'desc'     	=> __( 'Let the user change the map type.', 'wpcasa-listings-map' ),
				'id'       	=> 'listings_map_control_type',
				'type'     	=> 'checkbox',
				'default'	=> '1',
			),
			'listings_map_style' => array(
				'name' 		=> __( 'Style', 'wpcasa-listings-map' ),
				'desc' 		=> __( 'Please select the style of the listings map. Styles will only apply to ROADMAP or TERRAIN map type.', 'wpcasa-listings-map' ),
				'id'   		=> 'listings_map_style',
				'type' 		=> 'select',
				'options'	=> WPSight_Listings_Map_Styles::get_map_styles_choices( true ),
			),
			'listings_map_scrollwheel' => array(
				'name'     	=> __( 'Scrollwheel', 'wpcasa-listings-map' ),
				'cb_label' 	=> __( 'Enable scroll wheel', 'wpcasa-listings-map' ),
				'desc'     	=> __( 'Let the user change the map zoom using the scrollwheel.', 'wpcasa-listings-map' ),
				'id'       	=> 'listings_map_scrollwheel',
				'type'     	=> 'checkbox',
			),
			'listings_map_streetview' => array(
				'name'     	=> __( 'Streetview', 'wpcasa-listings-map' ),
				'cb_label' 	=> __( 'Enable streetview', 'wpcasa-listings-map' ),
				'desc'     	=> __( 'Let the user activate streetview on the map.', 'wpcasa-listings-map' ),
				'id'       	=> 'listings_map_streetview',
				'type'     	=> 'checkbox',
				'default'	=> '1',
			),

		);
		
		$options['listings_map'] = array(			
			__( 'Map', 'wpcasa-listings-map' ),
			apply_filters( 'wpsight_listings_map_options', $options_listings_map )
		);

		return $options;

	}
	
	/**
	 *	meta_box()
	 *	
	 *	Add exclude option to location meta box
	 *	
	 *	@param	array	$fields	Registered meta box fields
	 *	@return	array	$fields
	 *	
	 *	@since 1.0.0
	 */
	public static function meta_box( $fields ) {
		
		$fields['exclude'] = array(
			'name'      => __( 'Listings Map', 'wpcasa-listings-map' ),
			'id'        => '_map_exclude',
			'type'      => 'checkbox',
			'desc'		=> __( 'Exclude from listings map', 'wpcasa-listings-map' ),
			'priority'  => 70
		);
		
		return $fields;
	
	}

}
