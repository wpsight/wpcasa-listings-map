function initialize() {

	var mapOptions = {
	    mapTypeId: google.maps.MapTypeId[wpsightMap.map.mapTypeId],
	    mapTypeControl: wpsightMap.map.mapTypeControl,
	    scrollwheel: wpsightMap.map.scrollwheel,
	    streetViewControl: wpsightMap.map.streetViewControl
	},
	bounds = new google.maps.LatLngBounds(), 
	map = new google.maps.Map(document.getElementById(wpsightMap.map.id), mapOptions),
	markers = [];

	for ( var i = wpsightMap.map.markers.length - 1; i >= 0; i-- ) {

		var marker = markers[i] = new google.maps.Marker({
			position: new google.maps.LatLng(parseFloat(wpsightMap.map.markers[i].lat), parseFloat(wpsightMap.map.markers[i].lng)),
			map: map,
			icon: {
				url: wpsightMap.map.markers[i].icon.url,
				size: new google.maps.Size(parseInt(wpsightMap.map.markers[i].icon.size[0]), parseInt(wpsightMap.map.markers[i].icon.size[1])),
				origin: new google.maps.Point(parseInt(wpsightMap.map.markers[i].icon.origin[0]), parseInt(wpsightMap.map.markers[i].icon.origin[1])),
				anchor: new google.maps.Point(parseInt(wpsightMap.map.markers[i].icon.anchor[0]), parseInt(wpsightMap.map.markers[i].icon.anchor[1])),
				scaledSize: new google.maps.Size(parseInt(wpsightMap.map.markers[i].icon.scaledSize[0]), parseInt(wpsightMap.map.markers[i].icon.scaledSize[1]))
			},
			title: wpsightMap.map.markers[i].title,
			status: "active"
		});
    	
    	markers[i].infobox = new InfoBox({ 
    		content: wpsightMap.map.markers[i].infobox.content,
    		pixelOffset: new google.maps.Size(-140, 0)
    	});
		
    	google.maps.event.addListener(markers[i], "mouseover", function (e) {
    		for (var j = markers.length - 1; j >= 0; j--) {
    			markers[j].infobox.close();
    		};
			marker.infobox.open(map, this);
    	});

		bounds.extend(markers[i].position);
	};


	map.fitBounds(bounds);
	map.panToBounds(bounds); 
}

google.maps.event.addDomListener(window, 'load', initialize);

console.log(wpsightMap) 