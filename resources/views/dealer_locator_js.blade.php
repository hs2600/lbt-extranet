@extends('layouts.dashboard')

@section('content')

<style>
    .text-center {
        text-align: center;
    }

    #map {
        width: "100%";
        height: 70vh;
    }
</style>
<h1 class="text-center">Dealer Locator</h1>
<div id="map"></div>

<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap&v=weekly" defer></script>

<script>
    let map, markers = [];
    var geocoder;
    var zip = <?php echo '"' . $zip . '"' ?>;

    /* ----------------------------- Initialize Map ----------------------------- */
    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 12,
            mapId: 'd17a10fca4693276'
        });

        geocoder = new google.maps.Geocoder();

        map.addListener("click", function(event) {
            mapClicked(event);
        });

        initMarkers();
        centerZip(zip);

    }

    /* --------------------------- Initialize Markers --------------------------- */
    function initMarkers() {
        const initialMarkers = <?php echo json_encode($showrooms); ?>;
        address = '';
        customer = '';

        for (let index = 0; index < initialMarkers.length; index++) {
            const markerData = initialMarkers[index];
            address = markerData.address1.trim() + ' ' + markerData.address2.trim() + ', ' +
                markerData.city.trim() + ', ' + markerData.state.trim() + '  ' + markerData.zip.trim();
            customer = markerData.ship_to_name.trim();

            codeAddress(address, customer, (index + 1).toString());

            console.log(address + ' - ' + customer);

        }
    }

    /* ------------------------- Handle Map Click Event ------------------------- */
    function mapClicked(event) {
        console.log(event.latLng.lat(), event.latLng.lng());
    }


    //Call this to place marker based on address
    function codeAddress(address, label, index) {
        const image =
            "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";

        geocoder.geocode({
            'address': address
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var marker = new google.maps.Marker({
                    position: results[0].geometry.location,
                    label: {
                        color: "black",
                        text: index
                    },
                    title: label,
                    map: map
                });

                const contentString =
                    '<div id="content">' +
                    '<div id="siteNotice">' +
                    "</div>" +
                    '<h5 id="firstHeading" class="firstHeading">'+ label + '</h5>' +
                    '<div id="bodyContent">' +
                    "<p style='font-size: 16px;'>" + address + "</p>" +
                    "</div>" +
                    "</div>";

                const infowindow = new google.maps.InfoWindow({
                    content: contentString
                });

                marker.addListener("click", () => {
                    infowindow.open({
                        anchor: marker,
                        map,
                    });
                });
            }
        });
    }

    //Call this to center on a zip code
    function centerZip(zipCode) {
        geocoder.geocode({
            'address': zipCode
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
            }
        });
    }
</script>

@endsection