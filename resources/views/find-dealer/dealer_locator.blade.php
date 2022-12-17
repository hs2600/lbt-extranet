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

    .marker-position {
    bottom: 0;
    left: 0;
    position: relative;
    }

    [type=checkbox]:checked,[type=radio]:checked {
	background-color: #04403c;
    }    

    [type=checkbox],[type=radio] {
	color: #cea29d;
	background-color: #fff;
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
                LBT Authorized Dealers
                </h3>
                <form method="GET" action="/dealer_locator">
                    <input type="text" name="location" placeholder="Search by ZIP" value="{{ $zip }}" autocomplete="on" required="" size="10">
                    <button type="submit" class="btn btn-outline-primary" style="margin-left: 10px; transition: all .3s ease-out 0s;
                    padding: 5px;
                    margin-bottom: 4px;
                    ">Update</button><br>
                    <input type="checkbox" name="JA" value="1" {{ $JA }}>
                    <label for="JA"> Jonathan Adler</label><br>

                    <input type="checkbox" name="TB" value="1" {{ $TB }}>
                    <label for="TB"> Tommy Bahama</label><br>                    
                </form>
                <span style="color: red;"><i>@if ($error == 'invalid') Please enter a valid US ZIP Code @endif
                    </i></span>
                <div data-lastpass-icon-root="true" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
            </div>

            @foreach ($showrooms as $showroom)

            <div class="card" style="margin-top: 20px;">
                <div class="card-body" style="padding-bottom: 10px;">
                    <h5 class="card-title" style="padding: 8px 0 0px 0;">
                        <span class="position-absolute top-0 left-0 translate-middle badge rounded-pill text-light" style="background-color: #04403c99;">
                            {{ $loop->iteration }}</span>
                        {{ ucwords(strtolower($showroom->customer_name)) }}</h6>
                        <i><span style="font-size: 14px; color: #555;"><b>{{ round($showroom->distance,2) }}</b> miles away
                            </span></i><br>
                        <span class="card-text">{{ ucwords(strtolower($showroom->address1 . ' ' . $showroom->address2)) }}</span><br>
                        <span class="card-text">{{ ucwords(strtolower($showroom->city)) . ', ' . $showroom->state . '  ' . $showroom->zip }}</span>
                        <br>
                        <span class="card-text"><i>[test/ {{ $showroom->authorized }} ]</i></span>
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

<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&v=beta&libraries=marker&callback=initMap" defer></script>

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
            customer = toTitleCase(markerData.customer_name.trim());
            zip = markerData.zip.trim();
            lat = markerData.lat;
            distance = markerData.distance;

            codeAddress(address, customer, distance, (index + 1).toString());

            console.log("(" + markerData.locator_priority + ")" + customer + "(" + address + ")");

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
    function codeAddress(address, customer, distance, index) {

        var pinColor = "#04403c";
    
        // Pick your pin (hole or no hole)
        var pinSVGHole = "M12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5M12,2A7,7 0 0,0 5,9C5,14.25 12,22 12,22C12,22 19,14.25 19,9A7,7 0 0,0 12,2Z";
        var labelOriginHole = new google.maps.Point(12,15);
        var pinSVGFilled = "M 12,2 C 8.1340068,2 5,5.1340068 5,9 c 0,5.25 7,13 7,13 0,0 7,-7.75 7,-13 0,-3.8659932 -3.134007,-7 -7,-7 z";
        var labelOriginFilled =  new google.maps.Point(12,9);


        var markerImage = {  // https://developers.google.com/maps/documentation/javascript/reference/marker#MarkerLabel
            path: pinSVGFilled,
            anchor: new google.maps.Point(12,17),
            fillOpacity: 1,
            fillColor: pinColor,
            strokeWeight: 2,
            strokeColor: "white",
            scale: 2,
            labelOrigin: labelOriginFilled
        };

        const svgMarker = {
        path: "M10.453 14.016l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM12 2.016q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
        fillColor: "#04403c",
        fillOpacity: 1,
        strokeWeight: 0,
        rotation: 0,
        scale: 2,
        anchor: new google.maps.Point(15, 30),
    };
        
        const pin = "https://img.icons8.com/cotton/512/shipping-location.png";

        const icon_ = {
            url: "http://maps.gstatic.com/mapfiles/ridefinder-images/mm_20_green.png", // url
            scaledSize: new google.maps.Size(0, 0), // scaled size
            opacity: 1,
            origin: new google.maps.Point(0,0), // origin
            anchor: new google.maps.Point(0, 0) // anchor
        };

        const icon = document.createElement("div");

        //icon.innerHTML = '<i class="fa-solid fa-store"></i>';
        icon.innerHTML = index;

        // Change the background color.
        const pinViewBackground = new google.maps.marker.PinView({
        background: "#04403c",
        borderColor: "#cea29d",
        glyphColor: "#fff",
        glyph: icon,
        });

        geocoder.geocode({
            'address': address
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var marker = new google.maps.marker.AdvancedMarkerView({
                    position: results[0].geometry.location,
                    title: customer,
                    //icon: pin,
                    content: pinViewBackground.element,
                    map
                });

                const contentString =
                    '<div id="content">' +
                    '<div id="siteNotice">' +
                    "</div>" +
                    '<h5 id="firstHeading" class="firstHeading">' + customer + '</h5>' +
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