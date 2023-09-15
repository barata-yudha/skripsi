<script src="https://cdnjs.cloudflare.com/ajax/libs/js-marker-clusterer/1.0.0/markerclusterer_compiled.js"></script>
<script>
    var map = null;
    var marker;

    function showlocation() {
        if ("geolocation" in navigator) {
            /* geolocation is available */
            // One-shot position request.
            navigator.geolocation.getCurrentPosition(callback, error);
        } else {
            /* geolocation IS NOT available */
            console.warn("geolocation IS NOT available");
        }
    }

    function error(err) {
        console.warn('ERROR(' + err.code + '): ' + err.message);
    };

    function callback(position) {

        var lat = position.coords.latitude;
        var lon = position.coords.longitude;
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lon;
        var latLong = new google.maps.LatLng(lat, lon);
        map.setZoom(8);
        map.setCenter(latLong);
    }
    google.maps.event.addDomListener(window, 'load', initMap);

    function initMap() {
        var mapOptions = {
            center: new google.maps.LatLng(latitude, longitude),
            zoom: 15,
            cluster: false,
        };
        document.getElementById('latitude').value = latitude;
        document.getElementById('longitude').value = longitude;
        map = new google.maps.Map(document.getElementById("gmap"),
            mapOptions);
        google.maps.event.addListener(map, 'center_changed', function() {
            document.getElementById('latitude').value = map.getCenter().lat();
            document.getElementById('longitude').value = map.getCenter().lng();
        });
        $('<div/>').addClass('centerMarker').appendTo(map.getDiv())
            //do something onclick
            .click(function() {
                var that = $(this);
                if (!that.data('win')) {
                    that.data('win', new google.maps.InfoWindow({
                        content: '<p class="marker_title text-black">Lokasi</p>'
                    }));
                    that.data('win').bindTo('position', map, 'center');
                }
                that.data('win').open(map);
            });

        var input = document.getElementById('searchTextField');
        var autocomplete = new google.maps.places.Autocomplete(input);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            // document.getElementById('city2').value = place.name;
            document.getElementById('latitude').value = place.geometry.location.lat();
            document.getElementById('longitude').value = place.geometry.location.lng();
            //alert("This function is working!");
            //alert(place.name);
            // alert(place.address_components[0].long_name);
            var lat = place.geometry.location.lat();
            var lng = place.geometry.location.lng();
            var latLong = new google.maps.LatLng(lat, lng);
            map.setCenter(latLong);
        });
        // console.clear();
    }
</script>
