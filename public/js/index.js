(function ($) {
    //
    // Variables
    //  
    var map;
    var panorama;

    //
    // Methods
    //
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

    var initMap = function(latitude, longitude, pano, heading, pitch, pano_zoom, map_selector, pano_selector) {
        
        var processSharedEyeshot = function(data, status) {

            if ( pano !== '' || typeof pano !== 'undefined' ) {
    
                $('.loader').css('display', 'none');
                $('#sv-pano').css('display', 'block');
          
                panorama.setPano(pano);
                panorama.setPov({
                    heading: heading,
                    pitch: pitch,
                    zoom: pano_zoom
                });
                panorama.setVisible(true);
          
            } else {
                takeMeSomewhereIDontBelong();
            }
        }

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
            gestureHandling: 'greedy'
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
        }, processSharedEyeshot);

        // Look for a nearby Street View panorama when the map is clicked.
        // getPanorama will return the nearest pano when the given
        // radius is 100 meters or less.
        map.addListener('click', function (event) {
            sv.getPanorama({
                location: event.latLng,
                radius: 100
            }, processSharedEyeshot);
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

        var setupMap = function() {
            
            map = new google.maps.Map(document.getElementById('sv-map'), { // Map selector
                center: loc,
                zoom: 16,
                zoomControl: false,
                mapTypeControl: false,
                streetViewControl: true,
                gestureHandling: 'greedy'
            });

            map.setStreetView(panorama);

            // Look for a nearby Street View panorama when the map is clicked.
            // getPanorama will return the nearest pano when the given
            // radius is 200 meters or less.
            map.addListener('click', function (event) {
                sv.getPanorama({
                    location: event.latLng,
                    radius: 200
                }, function( data, status ) {
                    if( status === 'OK' ) {
                        panorama.setPano(data.location.pano);
                        panorama.setPov({
                            heading: 270,
                            pitch: 0,
                            zoom: 0
                        });
                        panorama.setVisible(true);
                    }
                });
            });
        }

        var processEyeshot = function(data, status) {

            if (status === 'OK') {
                
                panorama = new google.maps.StreetViewPanorama(
                    document.getElementById('sv-pano'), // Pano Selector
                    {
                        pano: data.location.pano,
                        panControl: true,
                        fullscreenControl: true,
                        linksControl: false,
                        zoomControl: false,
                        addressControl: false,
                        enableCloseButton: false
                    }
                );

                panorama.setPov({
                    heading: 270,
                    pitch: 0,
                    zoom: 0
                });

                initPanoId(panorama.getPano());

                panorama.addListener('pano_changed', function() {
                    var panoId = panorama.getPano();
                    initPanoId(panoId);
                });

                setupMap();

                $('.loader').css('display', 'none');
                $('#sv-pano').css('display', 'block');
          
            } else {
                // Keep searching, you'll surely end up somewhere!
                takeMeSomewhereIDontBelong();
            }
        }
        
        var sv = new google.maps.StreetViewService();

        // Set the initial Street View camera to the center of the map
        sv.getPanorama({
            location: loc,
            radius: 50
        }, processEyeshot);
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

        $('.loader').css('display', 'block');
        $('#sv-pano').css('display', 'none');

        // TODO: Add more NOICE radials
        var radialPoints = [
            // it's not what it looks like. Here: https://github.com/actuallyakash/eyeshot#how-randomizer-works
            [], // Empty
            [43.0772733, -79.0659442, 2500], // Niagara Falls, New York
            [37.869085, -122.254775, 2500], // Berkeley, California -
            [51.5286416, -0.1015987, 30000], // London, England
            [47.3721915, 8.5425051, 40000], // Zürich, Zurich
            [46.7972162, 9.8334775, 40000], // Davos, Switzerland
            [-4.3586009, 55.8407455, 2800], // La Digue Island, Seychelles
            [-4.3235718, 55.7260027, 7000], // Grand Anse Island, Seychelles
            [22.1090709, -159.3986365, 300], // Makaleha Stream
            [64.0565557, -19.8680213, 100], // Þjófafoss River, Iceland
            [36.0612757, -112.0867052, 2000], // Grand Canyon
            [25.1972018, 55.2721877, 2000], // Burj Khalifa, Dubai -
            [32.628183, 129.7385157, 800], // Hashima Islands
            [44.132559, 9.7011111, 500], // CINQUE TERRE, Italy
            [45.4376252, 12.3238643, 1500], // Venice, Italy
            [40.7504527, -73.9870021, 2000], // Times Square
            [46.4096518, 10.0222048, 2000], // Lago Bianco, Switzerland -
            [68.133029, -149.475559, 500], // Atigun Pass, Alaska
            [46.6688604, 8.0249095, 2000], // Bachalpsee, Switzerland -
            [-17.490441, -149.767722, 1500], // Tema'e, French Polynesia
            [-25.348539, 131.028638, 1200], // Uluru, Australia
            [11.966825, 121.926576, 2000], // Boracay
            [10.975765, 76.736885, 900], // Isha Yoga Centre, Coimbatore
            [35.7127983, 139.7718079, 2000], // Taito City, Tokyo -
            [-13.898551, -71.282604, 20000], // Vinicunca Rainbow Mountain
            [49.1957991, 20.0653766, 20000], // Rysy, Slovaki
            [45.8145547, 15.9786655, 20000], // Zagreb, Slovenia
            [29.057055, 110.467770, 2200], // Tianmen Mountain cave, China
            [-22.951311, -43.211112, 500], // Christ the Redeemer, Rio de Janerio
            [48.859953, 2.292047, 1000], // Eiffel Tower Nearby
            [], // Empty
        ];
        
        var radial = radialPoints[Math.floor((Math.random() * (radialPoints.length-1)) + 1)];
        console.log(radial[2]);
        var randomGeoPoints = generateRandomPoint({'lat':radial[0], 'lng':radial[1]}, radial[2]);
        
        var latitude = Number(randomGeoPoints['lat']);
        var longitude = Number(randomGeoPoints['lng']);

        $('#landing-pano #sv-pano .gm-style').remove(); // Clean old pano's instance

        randomLoc( latitude, longitude );
    }
    
    // Fav/Unfav Ops
    var favouriteOps = function(panoId, ops, element) {

        $("#favouriteBox .eyeshot-title").val('');
        var locationName = map.streetView.location.description;
        var latitude = map.center.lat();
        var longitude = map.center.lng();
        var panoHeading = panorama.getPov().heading;
        var panoPitch = panorama.getPov().pitch;
        var panoZoom = panorama.zoom;
        if( typeof locationName !== 'undefined' && locationName !== "") {
            $("#favouriteBox .location-name").html('Exploring: <b>' + locationName + '</b>');
        } else {
            locationName = null;
        }
        
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
        
        /* Waking up tooltips */
        $('[data-tooltip="tooltip"]').tooltip();

        /* Waking up Disqus */
        (function () { // DON'T EDIT BELOW THIS LINE
            var d = document,
                s = d.createElement('script');
            s.src = 'https://eyeshot.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();

        if($( "#landing-pano" ).length) {
            takeMeSomewhereIDontBelong();
        }
        
        if($( "#shared-pano" ).length) {

            var mapSelector = document.querySelector('#shared-pano #sv-map'),
                panoSelector = document.querySelector('#shared-pano #sv-pano');
            
            if ( (new URL(window.location.href)).pathname.indexOf('/shot/') > -1 ) { // User's Eyeshot
                var eyeshot = (new URL(window.location.href)).pathname.split('/')[3];
                $.ajax({
                    type: 'GET',
                    url: '/get/'+eyeshot+'/details',
                    success: function( data ) {
                        if( data != 0 ) {
                            var latitude = data.latitude,
                                longitude = data.longitude;
                            initPanoId(data.pano_id);
                            initMap( Number(latitude), Number(longitude), data.pano_id, Number(data.pano_heading), Number(data.pano_pitch), Number(data.pano_zoom), mapSelector, panoSelector );
                        } else {
                            console.log('No eyeshot found!');
                        }
                    }
                });
            } else { // Shared Eyeshot
                var params = (new URL(window.location.href)).searchParams.get('s'),
                    decode = atob(params),
                    details = decode.split(':');
                initPanoId(details[2]);
                initMap( Number(details[0]), Number(details[1]), details[2], Number(details[3]), Number(details[4]), Number(details[5]), mapSelector, panoSelector );
                setTimeout(function () {
                    if ( typeof map.streetView.location.description !== 'undefined' ) {
                        $('#shared-pano').after('<div class="details text-center"><h3 class="eyeshot-info"> <span class="text-muted">Location: </span>' + map.streetView.location.description + '</h3></div>');
                        $('meta.meta-title').attr('content', map.streetView.location.description + " | Eyeshot");
                        $('meta.meta-keywords').attr('content', map.streetView.location.description);
                        $('meta.meta-image').attr('content', "https://maps.googleapis.com/maps/api/streetview?size=600x400&pano=" + details[2] + "&heading=" + details[3] + "&pitch=" + details[4] + "&key=" + key);
                    }
                }, 2000);
            }
        }
        
        $("#landing-pano").on('click', function() {
            $('html, body').animate({
                scrollTop: ($("#landing-pano").offset().top)
            }, 100);
        });

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
        var user = $(this).data('user');
        $('#viewEyeshot #sv-pano .gm-style').remove(); // Clean old pano's instance
        $('#viewEyeshot').modal('show');

        // Updating Page URL for Modal
        history.pushState({pageID: 'Eyeshot'}, 'Eyeshot', '/' + user + '/shot/' + eyeshot);

        // Disqus for Discussion
        var PAGE_URL = "http://eyeshot.xyz/" + user + "/shot/" + eyeshot;
        var PAGE_IDENTIFIER = eyeshot;
        DISQUS.reset({
            reload: true,
            config: function () {
                this.page.identifier = PAGE_IDENTIFIER;  
                this.page.url = PAGE_URL;
            }
        });

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
                    
                    var latitude = data.latitude,
                        longitude = data.longitude;

                    $("#viewEyeshot .eyeshot-avatar img").attr('src', data.user_avatar.replace('http://', 'https://'));
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

                    initMap( Number(latitude), Number(longitude), data.pano_id, Number(data.pano_heading), Number(data.pano_pitch), Number(data.pano_zoom), mapSelector, panoSelector );

                    $('#viewEyeshot .loader').css('display', 'none');
                    $('#viewEyeshot .modal-content').css('display', 'block');

                } else {
                    console.log('No eyeshot found!');
                }
            }
        });
    });

    $("#viewEyeshot").on("hidden.bs.modal", function () {
        history.pushState({pageID: 'Home'}, 'Eyeshot - Homepage', '/');
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
        var twitter = "https://twitter.com/share?url="+url+"&via=eyeshotHQ&text=Exploring%20Random%20Place";

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
                $(this).prev().append($(this).children('.eyeshot'));
                $(this).remove();
            }
        });
    });

    /* PWA */
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            navigator.serviceWorker.register('/sw.js');
        });
    }
    
    if (! window.matchMedia('(display-mode: standalone)').matches) {
        let deferredPrompt,
            alerted,
            pwaNotif = $("#pwa-snackbar");

        window.addEventListener('beforeinstallprompt', (e) => {
            deferredPrompt = e;
        });

        alerted = sessionStorage.getItem('eyeshot-pwa-notif') || '';
        if (alerted != 'yes') {
            setTimeout(function () {
                pwaNotif.addClass('show');
            }, 60000);
            sessionStorage.setItem('eyeshot-pwa-notif', 'yes');
        }

        $(pwaNotif).on('click', '.close', function(e) {
            pwaNotif.removeClass('show');
        });

        $('#pwa-snackbar').on('click', '.pwa-body', function() {
            deferredPrompt.prompt();
            pwaNotif.removeClass('show');
        });
        $('#app-install .pwa-install').on('click', function() {
            deferredPrompt.prompt();
        });
    }
        
})(jQuery);
