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
            // Checking likes
            $.ajax({
                type: 'GET',
                url: '/location/'+panoId+'/status',
                success: function(data) {
                    if( data == 1 ) {
                        element.attr('title', 'Unlike');
                        element.attr('data-original-title', 'Unlike');
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

            // Checking pioneer
            $.ajax({
                type: 'GET',
                url: '/get/'+panoId+'/pioneer',
                success: function( data ) {
                    if( data != 0 ) {
                        $("#content .first-explorer").show();
                        $("#content span.pioneer").text(data.name);
                    } else {
                        $("#content .first-explorer").hide();
                    }
                }
            })
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
            $('.sv-not-found').toast({delay: 2000});
            $('.sv-not-found').toast('show');
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

        var locationName = map.streetView.location.description;
        var latitude = map.center.lat();
        var longitude = map.center.lng();
        var panoHeading = panorama.getPov().heading;
        var panoPitch = panorama.getPov().pitch;
        var panoZoom = panorama.zoom;
        
        switch(ops) {
            case 'favourite':
                $.ajax({
                    type: 'GET',
                    url: '/location/favourite/'+locationName+'/'+latitude+'/'+longitude+'/'+panoId+'/'+panoHeading+'/'+panoPitch+'/'+panoZoom,
                    success: function(data) {
                        if(data == 1) {
                            element.attr('title', 'Unlike');
                            element.attr('data-original-title', 'Unlike');
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
                            element.attr('title', 'Like');
                            element.attr('data-original-title', 'Like');
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

    // Save fav info
    var saveFavouriteInfo = function( panoId, status, tags ) {
        $.ajax({
            type: 'POST',
            url: '/favourite/details',
            data:{panoId:panoId, status:status, tags:tags},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if(data == 1) {
                    $('#favouriteBox').modal('hide');
                    $('#favouriteBox textarea.status').val('');
                    tagify.removeAllTags();
                    $('.toast-location-share').toast({delay: 2000});
                    $('.toast-location-share').toast('show');
                } else {
                    console.log('#212 Something went wrong! Can\'t save details.');
                }
            }
        });
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
        $('#favouriteBox').modal();
        favouriteOps(panoId, 'favourite', element);
    });
    $("div#sv-pano").on('click', 'button.favourite-sv', function() {
        var panoId = $(this).attr('data-id').replace('fav-', '');
        var element = $('button.fav-'+panoId);
        favouriteOps(panoId, 'unfavourite', element);
    });

    // favourite view details
    $("div#favouriteBox").on('click', 'button.btn-fav-info', function(e) {
        e.preventDefault();

        var panoId = $("div#sv-pano button.cta-street-view").attr('data-id').replace('fav-', '');
        var status = $('textarea.status').val();
        var tags = $("input[name=tags]").val();
        saveFavouriteInfo(panoId, status, tags);
    });

    // Tagify
    var input = document.querySelector('input[name="tags"]'),
    tagify = new Tagify(input);

})(jQuery);
