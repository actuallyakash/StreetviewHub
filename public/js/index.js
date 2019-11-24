// (function ($) {
// 	//
// 	// Variables
// 	//
	

// 	//
// 	// Methods
// 	//

// 	//
// 	// Inits & Event Listeners
// 	//

// })(jQuery);

var map;
var panorama;

function initMap() {
  // console.log(takeMeSomewhereIDontBelong(60, 50));
  // var loc = takeMeSomewhereIDontBelong(60, 50);
  var loc = {
    lat: 37.869085,
    lng: -122.254775
    // lat: takeMeSomewhereIDontBelong(-180, 180, 5),
    // lng: takeMeSomewhereIDontBelong(-180, 180, 5)
  };
  console.log(loc);
  var sv = new google.maps.StreetViewService();

  // Set up the map.
  map = new google.maps.Map(document.getElementById('sv-map'), {
    center: loc,
    zoom: 16,
  });

  panorama = new google.maps.StreetViewPanorama(
    document.getElementById('sv-pano'), {
      position: location,
      pov: {
        heading: 80,
        pitch: 1
      },
      panControl: true,
      fullscreenControl: true,
      linksControl: false,
      zoomControl: false,
      addressControl: false,
      enableCloseButton: false
    });

  map.setStreetView(panorama);

  // Set the initial Street View camera to the center of the map
  sv.getPanorama({
    location: loc,
    radius: 50
  }, processSVData);

  // Look for a nearby Street View panorama when the map is clicked.
  // getPanorama will return the nearest pano when the given
  // radius is 100 meters or less.
  map.addListener('click', function (event) {
    sv.getPanorama({
      location: event.latLng,
      radius: 100
    }, processSVData);
  });
}

function processSVData(data, status) {
  if (status === 'OK') {

    panorama.setPano(data.location.pano);
    panorama.setPov({
      heading: 270,
      pitch: 0
    });
    panorama.setVisible(true);

  } else {
    console.error('Street View data not found for this location.');
    initMap();
  }
}


function takeMeSomewhereIDontBelong(center, radius) {
  var x0 = center.lng;
  var y0 = center.lat;
  // Convert Radius from meters to degrees.
  var rd = radius / 111300;

  var u = Math.random();
  var v = Math.random();

  var w = rd * Math.sqrt(u);
  var t = 2 * Math.PI * v;
  var x = w * Math.cos(t);
  var y = w * Math.sin(t);

  var xp = x / Math.cos(y0);

  // Resulting point.
  return {
    'lat': y + y0,
    'lng': xp + x0
  };
}