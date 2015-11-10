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
		
		// Add addon license to licenses page
		add_filter( 'wpsight_licenses', array( $this, 'license' ) );
		
		// Add plugin updater
		add_action( 'admin_init', array( $this, 'update' ), 0 );

	}

	/**
	 *	listings_map_options()
	 *	
	 *	Add addon options to settings page
	 *
	 *	@param	array	$options	Registered options	
	 *	@return	array	$options	Updated options
	 *	
	 *	@since 1.0.0
	 */
	public function options( $options ) {
		
		$options_listings_map = array(
			
			'listings_map_page' => array(
				'name' 		=> __( 'Page', 'wpcasa-listings-map' ),
				'desc' 		=> __( 'Please select the page that contains the listings map shortcode.', 'wpcasa-listings-map' ),
				'id'   		=> 'listings_map_page',
				'type' 		=> 'pages'
			),
			'listings_map_nr' => array(
				'name' 		=> __( 'Number', 'wpcasa-listings-map' ),
				'desc' 		=> __( 'Please enter the default number of listings shown on the map (<code>-1</code> to show all).', 'wpcasa-listings-map' ),
				'id'   		=> 'listings_map_nr',
				'type' 		=> 'text',
				'default'	=> 50
			),
			'listings_map_width' => array(
				'name' 		=> __( 'Width', 'wpcasa-listings-map' ),
				'desc' 		=> __( 'Please enter the default width of the map (in <code>px</code> or <code>%</code>).', 'wpcasa-listings-map' ),
				'id'   		=> 'listings_map_width',
				'type' 		=> 'text',
				'default'	=> '100%'
			),
			'listings_map_height' => array(
				'name' 		=> __( 'Height', 'wpcasa-listings-map' ),
				'desc' 		=> __( 'Please enter the default height of the map (in <code>px</code>).', 'wpcasa-listings-map' ),
				'id'   		=> 'listings_map_height',
				'type' 		=> 'text',
				'default'	=> '600px'
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
				'default'	=> 'ROADMAP'
			),
			'listings_map_control_type' => array(
				'name'     	=> __( 'Type Control', 'wpcasa-listings-map' ),
				'cb_label' 	=> __( 'Display type control', 'wpcasa-listings-map' ),
				'desc'     	=> __( 'Let the user change the map type.', 'wpcasa-listings-map' ),
				'id'       	=> 'listings_map_control_type',
				'type'     	=> 'checkbox',
				'default'	=> '1'
			),
			'listings_map_scrollwheel' => array(
				'name'     	=> __( 'Scrollwheel', 'wpcasa-listings-map' ),
				'cb_label' 	=> __( 'Enable scroll wheel', 'wpcasa-listings-map' ),
				'desc'     	=> __( 'Let the user change the map zoom using the scrollwheel.', 'wpcasa-listings-map' ),
				'id'       	=> 'listings_map_scrollwheel',
				'type'     	=> 'checkbox'
			),
			'listings_map_streetview' => array(
				'name'     	=> __( 'Streetview', 'wpcasa-listings-map' ),
				'cb_label' 	=> __( 'Enable streetview', 'wpcasa-listings-map' ),
				'desc'     	=> __( 'Let the user activate streetview on the map.', 'wpcasa-listings-map' ),
				'id'       	=> 'listings_map_streetview',
				'type'     	=> 'checkbox',
				'default'	=> '1'
			)

		);
		
		$options['listings_map'] = array(			
			__( 'Map', 'wpcasa-listings-map' ),
			apply_filters( 'wpsight_listings_map_options', $options_listings_map )
		);

		return $options;

	}
	
	/**
	 *	license()
	 *	
	 *	Add addon license to licenses page
	 *	
	 *	@return	array	$options_licenses
	 *	
	 *	@since 1.0.0
	 */
	public static function license( $licenses ) {
		
		$licenses['listings_map'] = array(
			'name' => WPSIGHT_LISTINGS_MAP_NAME,
			'desc' => sprintf( __( 'For premium support and seamless updates for %s please activate your license.', 'wpcasa-listings-map' ), WPSIGHT_LISTINGS_MAP_NAME ),
			'id'   => wpsight_underscores( WPSIGHT_LISTINGS_MAP_DOMAIN )
		);
		
		return $licenses;
	
	}
	
	/**
	 *	update()
	 *	
	 *	Set up EDD plugin updater.
	 *	
	 *	@uses	class_exists()
	 *	@uses	get_option()
	 *	@uses	wpsight_underscores()
	 *	
	 *	@since 1.0.0
	 */
	function update() {
		
		if( ! class_exists( 'EDD_SL_Plugin_Updater' ) )
			return;

		// Get license option
		$licenses = get_option( 'wpsight_licenses' );		
		$key = wpsight_underscores( WPSIGHT_LISTINGS_MAP_DOMAIN );
	
		// Setup the updater
		$edd_updater = new EDD_SL_Plugin_Updater( WPSIGHT_SHOP_URL, WPSIGHT_LISTINGS_MAP_PLUGIN_DIR . '/wpcasa-listings-map.php', array(
				'version' 	=> WPSIGHT_LISTINGS_MAP_VERSION,
				'license' 	=> isset( $licenses[ $key ] ) ? trim( $licenses[ $key ] ) : false,
				'item_name' => WPSIGHT_LISTINGS_MAP_NAME,
				'author' 	=> WPSIGHT_AUTHOR
			)
		);
	
	}

}
