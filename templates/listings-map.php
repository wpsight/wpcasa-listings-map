<?php
/**
 * Listings Map Template
 */
global $map_query, $args;

$map_options = array( 
	'map' => array( 
		'mapTypeId'         => esc_js( $args['map_type'] ),
		'mapTypeControl'    => $args['control_type'],
		'scrollwheel'       => esc_js( $args['scrollwheel'] ),
		'streetViewControl' => esc_js( $args['streetview'] ),
		'id'                => 'map-canvas',
		'markers'           => array()
	),
);

while( $map_query->have_posts() ) : $map_query->the_post();

	$map_options['map']['markers'][] = array(
		'title' => esc_js( get_the_title()),
		'lat' => esc_js( get_post_meta( get_the_id(), '_geolocation_lat', true )),
		'lng' => esc_js( get_post_meta( get_the_id(), '_geolocation_long', true )),
		'icon' => array(
			'url' 	 => WPSIGHT_LISTINGS_MAP_PLUGIN_URL . '/assets/img/listings-map-marker.png',
			'size' 	 => array( 24, 37),
			'origin' => array( 0, 0),
			'anchor' => array( 12, 37),
			'scaledSize' => array( 24, 37)
		),
		'infobox' => array(
			'content' => apply_filters( 'wpsight_listings_map_infobox', wpsight_listings_map_infobox() )
		)
	);

endwhile;

function wpsight_listings_map_infobox( ) { 
	ob_start(); ?>
	<div class="wpsight-infobox" id="wpsight-infobox-<?php get_the_ID() ?>">
		<?php the_post_thumbnail( ) ?>
	</div>
<?php 
	return ob_get_clean();
}

wp_enqueue_script( 'wpsight-map-frontend' );
wp_localize_script( 'wpsight-map-frontend', 'wpsightMap', apply_filters( 'wpsight_listings_map_options', $map_options ) ); 

?>
<div id="map-canvas" style="width: <?php echo $args['width']; ?>; height: <?php echo $args['height']; ?>"></div>
