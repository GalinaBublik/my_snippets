(function($) {


/*--------------------------------------------------Custom map---------------------------------------------*/

/*------------------------Simple map-------------------------------*/

/*
var map;
function initMap() {
	var chicago = new google.maps.LatLng(41.850, -87.650);
	map = new google.maps.Map(document.getElementById('map'), {
		center: chicago,
		//center: {lat: -34.397, lng: 150.644},
		zoom: 8
	});
	var marker = new google.maps.Marker({
	    position: chicago,
	    map: map,
	    title: 'Hello World!'
	});

	var infowindow = new google.maps.InfoWindow({
		content: marker.title
	});

	marker.addListener('click', function() {
	    infowindow.open(map, marker);
	});
}
*/
/*------------------------END Simple map-------------------------------*/

/*------------------------Geocoder map-------------------------------*/


	var map;
    var geocoder = new google.maps.Geocoder();
	var chicago = new google.maps.LatLng(41.850, -87.650);

    function initMap() {

        var styles = [
        //     {
        //         featureType: "all",
        //         elementType: "all",
        //         stylers: [
        //             { saturation: -100 } 
        //         ]
        //     }
        ];


        var mapOptions = {
            zoom: 16,//parseInt(localVars.zoom),
            center: chicago,
            styles: styles
        };


        map = new google.maps.Map(document.getElementById('map'),
                mapOptions);

        geocoder.geocode( { 'address': "5010 US Highway 27 Clermont, FL 34714" }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
	            map.setCenter(results[0].geometry.location);
	            var marker = new google.maps.Marker({
	                map: map,
	                position: results[0].geometry.location
	            });
	            var infowindow = new google.maps.InfoWindow({
					content: "5010 US Highway 27 Clermont, FL 34714"//localVars.address
				});

				marker.addListener('click', function() {
				    infowindow.open(map, marker);
				});

            } else {
              console.log('Geocode was not successful for the following reason:' + status);
            }
        });
    }



/*------------------------END Geocoder map-------------------------------*/
/*------------------------Multypins map-------------------------------*/

/*
//	console.log(localVars.repeater);
	var map;
    var geocoder = new google.maps.Geocoder();
    var image = (localVars.image)? localVars.image : '';
    var bounds = new google.maps.LatLngBounds();

    function initMap() {
        var mapOptions = {
            scrollwheel: false,
        };
        map = new google.maps.Map(document.getElementById('map'), mapOptions);
        for (var i = 0; i< localVars.repeater.length;  i++) {
            get_coords(i);
            /*if(i+1==localVars.repeater.length){
                map.fitBounds(bounds);
            }*//*
        };
    }

    function get_coords(_i){
        var title = localVars.repeater[_i].title;
        $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+localVars.repeater[_i].address+'&sensor=false', null, function (data) {
            if (data.status == 'OK') {
                add_marker_to_map( data.results[0].geometry.location, title);
            } else {
                console.log('Can\'t find coordinates for '+localVars.repeater[_i].address);
            }

        });
        /*
        geocoder.geocode( { 'address': localVars.repeater[_i].address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                add_marker_to_map( results[0].geometry.location, title);
            } else {
                alert('<?php echo __("Geocode was not successful for the following reason:", "direct" ); ?>' + status);
            }
        });
        *//*
    }

    function add_marker_to_map( place, title ){
        var marker = new google.maps.Marker({
            icon: image,
            position: place,
        });

        var contentString = '<div id="content"><h5>'+title+'</h5></div>';
        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });
        // To add the marker to the map, call setMap();
        marker.setMap(map);
        bounds.extend(marker.position);

        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
        });

        map.fitBounds(bounds);
        //map.setZoom(4);
    }
*/

/*------------------------End Multypins map-------------------------------*/

/*------------------------Interactive map-------------------------------*/
/*
	var map;
    var image = (localVars.image)? localVars.image : '';
    var bounds = new google.maps.LatLngBounds();
    var geocoder = new google.maps.Geocoder();
    var markersArray = [];
    var directionsDisplay = new google.maps.DirectionsRenderer();
    var directionsService = new google.maps.DirectionsService();

    function initMap() {
        var mapOptions = {
            scrollwheel: false,
        };
        map = new google.maps.Map(document.getElementById('map'), mapOptions);
        var mcOptions = {gridSize: 50, maxZoom: 15, imagePath: localVars.clusters };

        for (var i = 0; i< localVars.locations.length;  i++) {
        	var place = new google.maps.LatLng( parseInt(localVars.locations[i].lat), parseInt(localVars.locations[i].lon));
        	add_marker_to_map(place, localVars.locations[i]);
            if(i+1==localVars.locations.length){
                map.fitBounds(bounds);
				var markerCluster = new MarkerClusterer(map, markersArray, mcOptions);
            }
        };
    }

    function add_marker_to_map( place, location ){
        var marker = new google.maps.Marker({
            icon: image,
            position: place,
        });

        var contentString = '<div id="content"><h5>'+location.title+'</h5><p>'+location.s_street+', '+location.s_city+', '+location.s_state+', '+location.s_zip_code+'</p></div>';
        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });
        markersArray.push(marker);
        // To add the marker to the map, call setMap();
        marker.setMap(map);
        bounds.extend(marker.position);

        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
        });
    }


    $('#letsgo').click(function(){
    	geocoder.geocode( { 'address': $('#address').val() }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                map.setZoom(8);
            } else {
            	$('#address').addClass('error');
                console.log('<?php echo __("Geocode was not successful for the following reason:", "direct" ); ?>' + status);
            }
    	});
    });

    $('#letsdrow').click(function(){
		if($('#from').val()!='' && $('#to').val()!='' ){
			var origin = $('#from').val();
			var destination = $('#to').val();
            
            calcRoute(origin, destination);
			
			//calculateDistances(origin, destination);

		} else {
	    	if($('#from').val() ==''){ $('#from').addClass('error').attr('placeholder', 'Can\'t be empty'); }
	    	if($('#to').val() ==''){ $('#to').addClass('error').attr('placeholder', 'Can\'t be empty'); }
	    }
	});

    $('#getDist').click(function(){
        if($('#from').val()!='' && $('#to').val()!='' ){
            var origin = $('#from').val();
            var destination = $('#to').val();
            
            calculateDistances(origin, destination);
            
            //calculateDistances(origin, destination);

        } else {
            if($('#from').val() ==''){ $('#from').addClass('error').attr('placeholder', 'Can\'t be empty'); }
            if($('#to').val() ==''){ $('#to').addClass('error').attr('placeholder', 'Can\'t be empty'); }
        }
    });

/*------------------------END Interactive map-------------------------------*/

$(window).on('load', function(){
	initMap();
});
/*
function calculateDistances(origin, destination) {

    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix({
        origins: [origin],
        destinations: [destination],
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC,
        avoidHighways: false,
        avoidTolls: false
    }, callback);

}

function calcRoute(origin, destination) {

    var request = {
        origin: origin,
        destination: destination,
        travelMode: google.maps.TravelMode.DRIVING
    };

    directionsDisplay.setMap(map);

    directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });
}

function callback(response, status) {
    //console.log(response.rows);
    if (status != google.maps.DistanceMatrixStatus.OK) {
            alert('Error was: ' + status);
    } else {
        var origins = response.originAddresses;
        var destinations = response.destinationAddresses;

        for (var i = 0; i < origins.length; i++) {
            var results = response.rows[i].elements;
            for (var j = 0; j < results.length; j++) {
                if(results[j]['status'] == 'OK' ){
                    $('.distance').html(results[j].distance.text); 
                } else {
                    $('.distance').html('Error was: ' + status); 
                }
            }
        }
    }
}



	// Sets the map on all markers in the array.
function setMapOnAll(map) {
  for (var i = 0; i < markersArray.length; i++) {
    markersArray[i].setMap(map);
  }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
  	setMapOnAll(null);
}

function deleteMarkers() {

  clearMarkers();
  markersArray = [];
}




/*-----------------------------------------------END Custom map---------------------------------------------*/


})(jQuery);