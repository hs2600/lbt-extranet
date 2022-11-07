@extends('layouts.dashboard')

@section('content')

<style>
    .text-center {
        text-align: center;
    }

    #map {
        width: 100%;
        height: calc(100vh - 125px);
    }
</style>

<section class="section dashboard">
    <!-- <div class="row">
        <div class="col">
            <h1 class="text-center">Dealer Locator</h1>
        </div>
    </div> -->
    <div class="row">

        <div class="col-lg-3">

            <div style="margin: 20px 0px 30px 0px;
                border-bottom: 1px solid #c1c1c1;
                padding-bottom: 20px;
                ">
                <h3 style="font-size: 1.35rem;">
                    @if ($error != 'invalid' && $zip != '')
                    Dealers near {{ $zip }}
                    @endif
                    &nbsp;</h3>
                <form method="GET" action="/dealer_locator">
                    <input type="text" name="location" placeholder="Search by ZIP" title="Search by ZIP code" autocomplete="off" required="">
                    <button type="submit" class="btn btn-outline-primary" style="transition: all .3s ease-out 0s;
                    padding: 5px;
                    margin-bottom: 4px;
                    ">
                        Update</button><br>
                </form>
                <span style="color: red;"><i>@if ($error == 'invalid') Please enter a valid ZIP Code @endif
                    </i></span>
                <div data-lastpass-icon-root="true" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
            </div>


            @foreach ($showrooms as $showroom)

            <div class="card" style="margin-top: 20px;">
                <div class="card-body" style="padding-bottom: 10px;">
                    <h5 class="card-title" style="padding: 8px 0 0px 0;">
                        <span class="position-absolute top-0 left-0 translate-middle badge rounded-pill bg-primary text-light">
                            {{ $loop->iteration }}</span>
                        {{ ucwords(strtolower($showroom->ship_to_name)) }}</h6>
                        <i><span style="font-size: 14px; color: #555;"><b>{{ round($showroom->distance,2) }}</b> miles away
                            </span></i><br>
                        <span class="card-text">{{ ucwords(strtolower($showroom->address1 . ' ' . $showroom->address2)) }}</span><br>
                        <span class="card-text">{{ ucwords(strtolower($showroom->city)) . ', ' . $showroom->state . '  ' . $showroom->zip }}</span>
                </div>
            </div>

            @endforeach
        </div>

        <div class="col-lg-9" style="
        align-self: flex-start;
        position: sticky;
        top: 70px;
        height: auto;
        ">

            <div id="map"></div>

        </div>
    </div>
</section>

<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap&v=weekly" defer></script>

<script>
    let map, markers = [];
    var geocoder;
    var zip = <?php echo '"' . $zip . '"' ?>;
    const initialMarkers = <?php echo json_encode($showrooms); ?>;

    /* ----------------------------- Initialize Map ----------------------------- */
    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: 33.799904,
                lng: -118.298661,
            },
            zoom: 9,
            mapId: '2ea9fe570296658e',
            gestureHandling: 'greedy',
            mapTypeControl: false,
            scrollwheel: true
        });

        geocoder = new google.maps.Geocoder();

        map.addListener("click", function(event) {
            mapClicked(event);
        });

        initMarkers();

    }

    /* --------------------------- Initialize Markers --------------------------- */
    function initMarkers() {
        customer = '';
        address = '';
        zip = '';
        lat = '';
        distance = '';

        for (let index = 0; index < initialMarkers.length; index++) {
            const markerData = initialMarkers[index];
            address = toTitleCase((markerData.address1.trim() + ' ' + markerData.address2.trim()).trim()) + '<br>' +
                toTitleCase(markerData.city.trim()) + ', ' + markerData.state.trim() + '  ' + markerData.zip.trim();
            customer = toTitleCase(markerData.ship_to_name.trim());
            zip = markerData.zip.trim();
            lat = markerData.lat;
            distance = markerData.distance;

            codeAddress(address, customer, distance, (index + 1).toString());

            // console.log(address + ' - ' + customer);

            if (index == 0) {
                centerZip(zip);
            }

            if (index + 1 == initialMarkers.length) {
                mapZoom(distance);
            }

        }
    }

    /* ------------------------- Handle Map Click Event ------------------------- */
    function mapClicked(event) {
        console.log(event.latLng.lat(), event.latLng.lng());
    }


    //Call this to place marker based on address
    function codeAddress(address, label, distance, index) {
        const image =
            "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";

        geocoder.geocode({
            'address': address
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var marker = new google.maps.Marker({
                    position: results[0].geometry.location,
                    label: {
                        color: "white",
                        text: index
                    },
                    title: label,
                    distance: distance,
                    map: map
                });

                const contentString =
                    '<div id="content">' +
                    '<div id="siteNotice">' +
                    "</div>" +
                    '<h5 id="firstHeading" class="firstHeading">' + label + '</h5>' +
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
        zoom = 12;

        geocoder.geocode({
            'address': zipCode
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                map.setZoom(zoom);
            }
        });

    }

    //Call this to zoom map
    function mapZoom(distance) {
        zoom = 12;

        if (parseInt(distance) > 200) {
            zoom = 7;
        }

        /* zoom levels
        19 = street intersection
        18 = address
        17 = street block
        16 = street
        15 = small road
        14
        13 = village
        12 = town
        11 = city
        10
        9  = large metro area
        8
        7  = US state
        */

        map.setZoom(zoom);

    }
</script>

<script>
    function toTitleCase(str) {
        return str.replace(
            /\w\S*/g,
            function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            }
        );
    }
    // example
    toTitleCase("the pains and gains of self study");
    // "The Pains And Gains Of Self Study"
</script>

@endsection