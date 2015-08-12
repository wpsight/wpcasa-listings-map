<?php
/**
 * Listings Map Template
 */
global $map_query, $args; ?>

<style>
#map-canvas {
	width: <?php echo $args['width']; ?>;
	height: <?php echo $args['height']; ?>;
}
#map-canvas img {
	max-width: none;
}
</style>
<script src="https://maps.googleapis.com/maps/api/js"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js"></script>
<script>
function initialize() {

	// add code

	var mapOptions = {
	    mapTypeId: google.maps.MapTypeId.<?php echo esc_js( $args['map_type'] ); ?>,
	    mapTypeControl: <?php echo esc_js( $args['control_type'] ); ?>,
	    scrollwheel: <?php echo esc_js( $args['scrollwheel'] ); ?>,
	    streetViewControl: <?php echo esc_js( $args['streetview'] ); ?>
	}
	  
	var bounds = new google.maps.LatLngBounds();
	var loc, infobox;
	  
	var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	<?php
	
	while( $map_query->have_posts() ) : $map_query->the_post();
		
		$lat  = get_post_meta( get_the_id(), '_geolocation_lat', true );
		$long = get_post_meta( get_the_id(), '_geolocation_long', true );
		
		$icon = apply_filters( 'wpsight_listings_map_icon', array(
			'url' 	 => WPSIGHT_LISTINGS_MAP_PLUGIN_URL . '/assets/img/listings-map-marker.png',
			'size' 	 => array(24,37),
			'origin' => array(0,0),
			'anchor' => array(12,37),
			'scaled' => array(24,37)
		), get_the_id() );
		
		if( $lat && $long ) : ?>

		// Post ID <?php the_ID(); ?>: <?php the_title(); ?>

		loc = new google.maps.LatLng("<?php echo $lat; ?>","<?php echo $long; ?>");
		var image = {
			url: '<?php echo esc_js( $icon['url'] ); ?>',
			size: new google.maps.Size(<?php echo esc_js( intval( $icon['size'][0] ) ); ?>,<?php echo esc_js( intval( $icon['size'][1] ) ); ?>),
			origin: new google.maps.Point(<?php echo esc_js( intval( $icon['origin'][0] ) ); ?>,<?php echo esc_js( intval( $icon['origin'][1] ) ); ?>),
			anchor: new google.maps.Point(<?php echo esc_js( intval( $icon['anchor'][0] ) ); ?>,<?php echo esc_js( intval( $icon['anchor'][1] ) ); ?>),
			scaledSize: new google.maps.Size(<?php echo esc_js( intval( $icon['scaled'][0] ) ); ?>,<?php echo esc_js( intval( $icon['scaled'][1] ) ); ?>)
		};
		bounds.extend(loc);
		addMarker(loc, '<?php the_title(); ?>', image);
		<?php
		
		endif;
	
	endwhile; ?>	
	map.fitBounds(bounds);
	map.panToBounds(bounds);    
	
	function addMarker(location, name, image) {
		
		var marker = new google.maps.Marker({
			position: location,
			map: map,
			icon: image,
			title: name,
			status: "active"
		});
	    
		var boxText = document.createElement("div");
		boxText.style.cssText = "color: #fff; font-size: 16px; background-color: rgba(32,32,32,.75); padding: 20px;";
		boxText.innerHTML = "Here!";
		
		var myOptions = {
             content: boxText
            ,disableAutoPan: false
            ,maxWidth: 0
            ,pixelOffset: new google.maps.Size(-140, 0)
            ,zIndex: null
            ,boxStyle: {
              opacity: 0.75,
              width: "280px"
             }
            ,closeBoxMargin: "-20px"
            ,closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif"
            ,infoBoxClearance: new google.maps.Size(1, 1)
            ,isHidden: false
            ,pane: "floatPane"
            ,enableEventPropagation: false
    	};
    	
    	var ib = new InfoBox(myOptions);
		
    	google.maps.event.addListener(marker, "click", function (e) {
    		ib.close();
			ib.setOptions(myOptions);
			ib.open(map, this);
    	});
    	
    	return marker;
	    
	}

}
	
google.maps.event.addDomListener(window, 'load', initialize);
</script>

<div id="map-canvas"></div>
