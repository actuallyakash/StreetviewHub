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

    var initPanoId = function( panoId ) {
        var element = $('#sv-pano .cta-street-view');
        
        if ( element.length ) {
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
            // $.ajax({
            //     type: 'GET',
            //     url: '/get/'+panoId+'/pioneer',
            //     success: function( data ) {
            //         if( data != 0 ) {
            //             $("#content .first-explorer").show();
            //             $("#content span.pioneer").text(data.name);
            //         } else {
            //             $("#content .first-explorer").hide();
            //         }
            //     }
            // });
        }
    }

    var processEyeshot = function(data, status) {
        
        if (status === 'OK') {

            $('#landing-pano .loader').css('display', 'none');
            $('#landing-pano #sv-pano').css('display', 'block');
      
            panorama.setPano(data.location.pano);
            panorama.setPov({
                heading: 270,
                pitch: 0
            });
            panorama.setVisible(true);
      
        } else {
            // $('.sv-not-found').toast({delay: 2000});
            // $('.sv-not-found').toast('show');
            // Keep searching, you'll surely end up somewhere!
            takeMeSomewhereIDontBelong();
        }
    }

    var initMap = function(latitude, longitude, pano, heading, pitch, pano_zoom, map_selector, pano_selector) {
        var loc = {
            lat: latitude,
            lng: longitude
        };
        
        var sv = new google.maps.StreetViewService();
        
        // Set up the map.
        map = new google.maps.Map(map_selector, { // Map selector
            center: loc,
            zoom: 16,
            zoomControl: false,
            mapTypeControl: false,
            streetViewControl: true,
        });

        panorama = new google.maps.StreetViewPanorama(
            pano_selector, // Pano Selector
            {
                position: loc,
                panControl: true,
                fullscreenControl: true,
                linksControl: false,
                zoomControl: false,
                addressControl: false,
                enableCloseButton: false
            }
        );
        
        map.setStreetView(panorama);

        // Set the initial Street View camera to the center of the map
        sv.getPanorama({
            location: loc,
            radius: 50
        }, processEyeshot);

        // Look for a nearby Street View panorama when the map is clicked.
        // getPanorama will return the nearest pano when the given
        // radius is 100 meters or less.
        map.addListener('click', function (event) {
            sv.getPanorama({
                location: event.latLng,
                radius: 100
            }, processEyeshot);
        });

        panorama.addListener('pano_changed', function() {
            var panoId = panorama.getPano();
            initPanoId(panoId);
        });
    }

    var randomLoc = function( latitude, longitude ) {
        
        var loc = {
            lat: latitude,
            lng: longitude
        };
        
        var sv = new google.maps.StreetViewService();

        // Set up the map.
        map = new google.maps.Map(document.getElementById('sv-map'), { // Map selector
            center: loc,
            zoom: 16,
            zoomControl: false,
            mapTypeControl: false,
            streetViewControl: true,
        });

        panorama = new google.maps.StreetViewPanorama(
            document.getElementById('sv-pano'), // Pano Selector
            {
                position: loc,
                panControl: true,
                fullscreenControl: true,
                linksControl: false,
                zoomControl: false,
                addressControl: false,
                enableCloseButton: false
            }
        );
        
        map.setStreetView(panorama);

        // Set the initial Street View camera to the center of the map
        sv.getPanorama({
            location: loc,
            radius: 50
        }, processEyeshot);

        // Look for a nearby Street View panorama when the map is clicked.
        // getPanorama will return the nearest pano when the given
        // radius is 100 meters or less.
        map.addListener('click', function (event) {
            sv.getPanorama({
                location: event.latLng,
                radius: 100
            }, processEyeshot);
        });

        panorama.addListener('pano_changed', function() {
            var panoId = panorama.getPano();
            initPanoId(panoId);
        });

        $("#landing-pano").on('click', function() {
            $('html, body').animate({
                scrollTop: ($("#landing-pano").offset().top)
            }, 100);
        });
    }
    
    function generateRandomPoint(center, radius) {
        // https://stackoverflow.com/questions/31192451/generate-random-geo-coordinates-within-specific-radius-from-seed-point
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

        return {
            'lat': y + y0,
            'lng': xp + x0
        };
    }

    function takeMeSomewhereIDontBelong() {

        $('#landing-pano .loader').css('display', 'block');
        $('#landing-pano #sv-pano').css('display', 'none');

        // TODO: Add more NOICE radials
        var radialPoints = [
            [43.0822473, -79.0635906], // Niagara Falls, New York
            [37.869085, -122.254775], // Berkeley, California
            [51.5286416, -0.1015987], // London, England
            [47.3721915, 8.5425051], // Zürich, Zurich
            [46.7972162, 9.8334775], // Davos, Switzerland
            [55.6993533, 12.5423634], // Superkilen Park
            [38.470495, -78.7748714], // Shenandoah National Park, Virginia
            [37.42197, -122.084373], // GooglePlex
            [-4.3538688,55.8300366] // La Digue Island, Seychelles 
        ];
        
        var radial = radialPoints[Math.floor((Math.random() * (radialPoints.length-1)) + 1)];
        var randomGeoPoints = generateRandomPoint({'lat':radial[0], 'lng':radial[1]}, 2000);
        
        var latitude = Number(randomGeoPoints['lat']);
        var longitude = Number(randomGeoPoints['lng']);

        $('#landing-pano #sv-pano .gm-style').remove(); // Clean old pano's instance

        randomLoc( latitude, longitude );
    }
    
    // Fav/Unfav Ops
    var favouriteOps = function(panoId, ops, element) {

        var locationName = map.streetView.location.description;
        var latitude = map.center.lat();
        var longitude = map.center.lng();
        var panoHeading = panorama.getPov().heading;
        var panoPitch = panorama.getPov().pitch;
        var panoZoom = panorama.zoom;
        $("#favouriteBox .eyeshot-title").attr('value', locationName);
        
        switch(ops) {
            case 'favourite':
                $.ajax({
                    type: 'GET',
                    url: '/location/favourite/'+locationName+'/'+latitude+'/'+longitude+'/'+panoId+'/'+panoHeading+'/'+panoPitch+'/'+panoZoom,
                    success: function(data) {
                        if( data == 1 ) {
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
    var saveFavouriteInfo = function( panoId, title, status, tags ) {
        $.ajax({
            type: 'POST',
            url: '/favourite/details',
            data:{panoId:panoId, title:title, status:status, tags:tags},
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
        if($( "#landing-pano" ).length) {
            takeMeSomewhereIDontBelong();
        }
        
        if($( "#shared-pano" ).length) {
            var params = (new URL(window.location.href)).searchParams.get('s'),
                decode = atob(params),
                details = decode.split(':'),
                mapSelector = document.querySelector('#shared-pano #sv-map'),
                panoSelector = document.querySelector('#shared-pano #sv-pano');
            initPanoId(details[2]);

            initMap( Number(details[0]), Number(details[1]), details[2], Number(details[3]), Number(details[4]), Number(details[5]), mapSelector, panoSelector );
            setTimeout(function(){ $('#shared-pano').after('<div class="details text-center"><h3 class="eyeshot-info"> <span class="text-muted">Location: </span>' + map.streetView.location.description + '</h3></div>');
            $('meta.meta-title').attr('content', map.streetView.location.description+" | Eyeshot");
            $('meta.meta-keywords').attr('content', map.streetView.location.description);
            $('meta.meta-image').attr('content', "https://maps.googleapis.com/maps/api/streetview?size=600x400&pano="+ details[2] +"&heading="+ details[3] +"&pitch="+ details[4] +"&key=AIzaSyDTJbCnWZ2ZpG9ZAkf66SNfvLb9sUchknw");
            }, 2000);
        }

        console.log("%c🌏", "font-size:20px;");
        console.log("%cHaving fun using Eyeshot? Wanna contribute or maybe give a star 😁. Join us:\nhttp://github.com/actuallyakash/eyeshot", "color: #6697FE; font-size: 12px;");
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

    // favourite eyeshot details
    $("div#favouriteBox").on('click', 'button.btn-fav-info', function(e) {
        e.preventDefault();

        var panoId = $("div#sv-pano button.cta-street-view").attr('data-id').replace('fav-', '');
        var title = $("input[name=title]").val();
        var status = $('textarea.status').val();
        var tags = $("input[name=tags]").val();
        saveFavouriteInfo(panoId, title, status, tags);
    });

    // Tagify
    var input = document.querySelector('#favouriteBox input[name="tags"]');
    (input !== null) ? tagify = new Tagify(input) : '';
    

    // View Eyeshot
    $("div.eyeshot-container-fluid").on('click', '.eyeshot .eyeshot-media', function() {
        var eyeshot = $(this).data('eyeshot').replace('eyeshot-','');
        $('#viewEyeshot #sv-pano .gm-style').remove(); // Clean old pano's instance
        $('#viewEyeshot').modal('show');

        $("#viewEyeshot .eyeshot-location").text('');
        $("#viewEyeshot .eyeshot-status").text('');
        $("#viewEyeshot .eyeshot-tags").text('');
        $('#viewEyeshot .loader').css('display', 'block');
        $('#viewEyeshot .modal-content').css('display', 'none');

        $.ajax({
            type: 'GET',
            url: '/get/'+eyeshot+'/details',
            success: function( data ) {
                if( data != 0 ) {
                    
                    var latitude = Number(data.latitude);
                    var longitude = Number(data.longitude);

                    $("#viewEyeshot .eyeshot-avatar img").attr('src', data.user_avatar);
                    $("#viewEyeshot .eyeshot-user .eyeshot-username").html("by <a href='"+data.user_nickname+"'>"+data.eyeshot_by+"</a>");
                    $("#viewEyeshot .eyeshot-location").text(data.location_name);
                    if ( data.tags !== null ) {
                        $("#viewEyeshot .eyeshot-title").text(data.title);
                    } else {
                        $("#viewEyeshot .eyeshot-title").text("Eyeshot by "+data.eyeshot_by);
                    }
                    $("#viewEyeshot .eyeshot-status").text(data.status);
                    if ( data.tags !== null ) {
                        var tags = data.tags.split(",");
                        tags.map(tag => $("#viewEyeshot .eyeshot-tags").append("<a href='/search?q="+tag+"' class='eyeshot-tag badge'>"+tag+"</a>"));
                    } else {
                        $("#viewEyeshot .eyeshot-tags").append("<a href='/search?q=eyeshot' class='eyeshot-tag badge'>Eyeshot</a>")
                    }
                    $("#viewEyeshot .eyeshot-location").text(data.location_name);
                    $("#viewEyeshot .eyeshot-published").text(data.created_at);
                    $("#viewEyeshot .eyeshot-saves").text(data.eyeshot_saves+" saves");

                    initPanoId(data.pano_id);
                    let mapSelector = document.querySelector('#viewEyeshot #sv-map'),
                        panoSelector = document.querySelector('#viewEyeshot #sv-pano');
                    initMap( latitude, longitude, data.pano_id, Number(data.pano_heading), Number(data.pano_pitch), data.pano_zoom, mapSelector, panoSelector );

                    $('#viewEyeshot .loader').css('display', 'none');
                    $('#viewEyeshot .modal-content').css('display', 'block');

                } else {
                    console.log('No eyeshot found!');
                }
            }
        });
    });

    // Randomizer
    var randomClick = 0;
    $("div#sv-pano").on('click', 'button.randomize-eyeshot', function() {
        takeMeSomewhereIDontBelong();
        ( randomClick++ === 5) ? $("#loginSignupModal").modal('show') : '';
    });

    // Copying Sharing url in clipboard
    $("#shareEyeshot .copy-eyeshot-url").on('click', function() {
        $("#shareEyeshot .eyeshot-url").select();
        document.execCommand("copy");
        alert('Copied!');
    });

    $("#sv-pano .share-eyeshot").on('click', function() {
        $("#shareEyeshot").modal('show');
        
        var latitude = panorama.getPosition().lat(),
            longitude = panorama.getPosition().lng(),
            panoId = panorama.getPano(),
            heading = panorama.getPov().heading,
            pitch = panorama.getPov().pitch,
            zoom = panorama.getPov().zoom;

        var encode = btoa(latitude +":"+ longitude +":"+ panoId +":"+ heading +":"+ pitch +":"+ zoom);

        var url = "http://eyeshot.xyz?s="+encode;
        var facebook = "https://www.facebook.com/sharer/sharer.php?u="+url;
        var twitter = "https://twitter.com/share?url="+url+"&via=eyeshot.xyz&text=roamingAtUnknownPlace";

        $("#shareEyeshot .share-url input").val(url);
        $("#shareEyeshot a.share-facebook").attr('href', facebook);
        $("#shareEyeshot a.share-twitter").attr('href', twitter);
    });

    $(".sort-eyeshots select").on('change', function() {
        window.location = "/"+$(this).val();        
    });

     /* Pagination || Infinite Scroll */
     $(function() {
        $('.eyeshot-container-fluid').jscroll({
            autoTrigger: true,
            loadingHtml: '<div class="text-center"><span class="eyeshot-loader">🌏</span></div>',
            nextSelector: 'ul.pagination li.active + li a',
            contentSelector: 'div.eyeshot',
            pagingSelector: 'ul.pagination',
            callback: function() {
                $('ul.pagination:visible:first').hide();
            }
        });
    });

})(jQuery);
