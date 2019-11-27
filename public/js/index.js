(function ($) {
    //
    // Variables
    //  
    var map;
    var panorama;


    //
    // Methods
    //
    /* Waking up tooltips */
    $(function () {
        $('[data-tooltip="tooltip"]').tooltip()
    });

    var initMap = function() {
        var loc = {
            lat: 37.869085,
            lng: -122.254775
            // lat: takeMeSomewhereIDontBelong(-180, 180, 5),
            // lng: takeMeSomewhereIDontBelong(-180, 180, 5)
        };
        
        var sv = new google.maps.StreetViewService();

        // Set up the map.
        map = new google.maps.Map(document.getElementById('sv-map'), {
            center: loc,
            zoom: 16,
        });

        panorama = new google.maps.StreetViewPanorama(
          document.getElementById('sv-pano'), {
                position: location,
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

        panorama.addListener('pano_changed', function() {
            var panoId = panorama.getPano();
            var element = $('#sv-pano .cta-street-view');
            element.attr('data-id', 'fav-'+panoId);
            // Hotfix for removing old panoId
            var oldPano = "";
            if ( oldPano = element.attr("class").match(/fav-\S+/g) ) {
                element.removeClass(oldPano);
            }
            element.addClass('fav-'+panoId);
            $.ajax({
                type: 'GET',
                url: '/location/'+panoId+'/status',
                success: function(data) {
                    if( data == 1 ) {
                        element.attr('title', 'Unfavourite');
                        element.attr('data-original-title', 'Unfavourite');
                        element.removeClass('unfavourite-sv').addClass('favourite-sv');
                        element.children('i').removeClass('far').addClass('fas');
                    } else {
                        element.attr('title', 'Favourite');
                        element.attr('data-original-title', 'Favourite');
                        element.removeClass('favourite-sv').addClass('unfavourite-sv');
                        element.children('i').removeClass('fas').addClass('far');
                    }
                }
            });
        });
    }

    var processSVData = function(data, status) {
        if (status === 'OK') {

            panorama.setPano(data.location.pano);
            panorama.setPov({
                heading: 270, // here comes the POV details
                pitch: -1
            });
            panorama.setVisible(true);

        } else {
            console.error('Street View data not found for this location.');
        }
    }

    var takeMeSomewhereIDontBelong = function(center, radius) {
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
    
    // Fav/Unfav Ops
    var favouriteOps = function(panoId, ops, element) {
        // panorama.getPano()                   // pano_id
        // panorama.getPov().heading;           // Heading
        // panorama.getPov().pitch;             // Pitch
        // map.center.lat();                    // Latitude
        // map.center.lng();                    // Longitude
        // map.streetView.location.description; // Location Name
        var locationName = map.streetView.location.description;
        var latitude = map.center.lat();
        var longitude = map.center.lng();
        var panoHeading = panorama.getPov().heading;
        var panoPitch = panorama.getPov().pitch;
        
        switch(ops) {
            case 'favourite':
                $.ajax({
                    type: 'GET',
                    url: '/location/favourite/'+locationName+'/'+latitude+'/'+longitude+'/'+panoId+'/'+panoHeading+'/'+panoPitch,
                    success: function(data) {
                        if(data == 1) {
                            element.attr('title', 'Unfavourite');
                            element.attr('data-original-title', 'Unfavourite');
                            element.removeClass('unfavourite-sv').addClass('favourite-sv');
                            element.children('i').removeClass('far').addClass('fas');
                        } else {
                            console.log('#12 Something went wrong! Can\'t favourite location.');
                        }
                    }
                });
            break;

            case 'unfavourite':
                $.ajax({
                    type: 'DELETE',
                    url: '/location/'+panoId+'/unfavourite/',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(data) {
                        if(data == 1) {
                            console.log('in unfavourite');
                            element.attr('title', 'Favourite');
                            element.attr('data-original-title', 'Favourite');
                            element.removeClass('favourite-sv').addClass('unfavourite-sv');
                            element.children('i').removeClass('fas').addClass('far');
                        } else {
                            console.log('#13 Something went wrong! Can\'t unfavourite location.');
                        }
                    }
                });
            break;
        }
    }


    //
    // Inits & Event Listeners
    //
    $(document).ready(function() {
      initMap();
    });

    // Favourite/Unfavourite ops
    $("div#sv-pano").on('click', 'button.unfavourite-sv', function() {
        var panoId = $(this).attr('data-id').replace('fav-', '');
        var element = $('button.fav-'+panoId);
        favouriteOps(panoId, 'favourite', element);
    });
    $("div#sv-pano").on('click', 'button.favourite-sv', function() {
        var panoId = $(this).attr('data-id').replace('fav-', '');
        var element = $('button.fav-'+panoId);
        favouriteOps(panoId, 'unfavourite', element);
    });

})(jQuery);
