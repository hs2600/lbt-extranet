@extends('layouts.blank')

@section('content')

<style>
    .text-center {
        text-align: center;
    }

    #map {
        width: 100%;
        height: calc(100vh - 0px);
    }

    #main {
    margin: 0px;
    padding: 0px;
  }

    .marker-position {
        bottom: 0;
        left: 0;
        position: relative;
    }

    [type=checkbox]:checked,
    [type=radio]:checked {
        background-color: #04403c;
    }

    [type=checkbox],
    [type=radio] {
        color: #cea29d;
        background-color: #fff;
    }

    .no-outline:focus {
        border: 2px solid #04403c;
        box-shadow: none;
    }

    ::-webkit-scrollbar {
    width: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
    background: #ccc; 
    }

    @media only screen and (max-width: 825px) {
        #map {
        display: none;
        }

        #back-to-top {
        display: none;
        }    
    }

</style>

<section class="section dashboard">

    <div class="row" style="margin: 0px;">

        <div class="col-lg-3">

            <div style="padding-bottom: 5px;
            position: sticky;
            top: 0px;
            background: white;
            z-index: 3;
            padding-top: 15px;
                ">
                <h5 style="font-size: 1.35rem;">
                    <b>LBT Authorized Dealers</b>
                </h5>
                <div style="border: 1px solid #999;
                    padding: 10px;
                    border-radius: 5px;
                    background-color: #f8f9fa;">
                <form method="GET" action="/dealer-locator">
                    <input style="margin-right: 10px; margin-bottom: 5px;" type="text" class="no-outline" name="location" placeholder="Search by ZIP" value="{{ $zip }}" autocomplete="on" required="" size="10">
                    <button type="submit" class="btn btn-outline-primary" style="transition: all .3s ease-out 0s;
                    margin-bottom: 4px;
                    background-color: #04403c;
                    color: #FFF;
                    border: none;
                    ">Update</button><br>
                    <h6 style="margin-top: 10px;"><b>Filter by partnership:</b></h6>
                    <div style="display: flex;">
                        <input style="margin: 5px;" type="checkbox" name="JA" value="1" {{ $JA_checked }}>
                        <label for="JA"> Jonathan Adler</label>
                        <img src="/assets/images/JA_icon.png" style="border-radius: 15px; margin: 5px; margin-left: 12px; width: 16px; height: 16px;" title="Jonathan Adler">                        
                    </div>
                    <div style="display: flex;">
                        <input style="margin: 5px;" type="checkbox" name="TB" value="1" {{ $TB_checked }}>
                        <label for="TB"> Tommy Bahama</label>
                        <img src="/assets/images/TB_logo.jpg" style="border: 1px solid #122A4F; border-radius: 15px; margin: 5px; width: 16px; height: 16px;" title="Tommy Bahama">                        
                    </div>
                </form>
                </div>
                @if ($error == 'invalid')
                <span style="color: red;"><i> Please enter a valid US ZIP Code</i></span>
                <div style="border: 1px solid red; color: red; padding: 5px; margin-top: 5px;">
                    For customers outside of US, please use the 
                    <a target="_blank" href="https://lunadabaytile.com/pages/contact" style="color: red;"><b>Contact Form</b></a> to find nearest dealer.
                </div>
                @endif
                <div data-lastpass-icon-root="true" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
            </div>

            @foreach ($showrooms as $showroom)

            <?php

            $JA_display = 'none';
            $TB_display = 'none';
            $phone_display = 'none';
            $website_display = 'none';
            $app_only = '';

            if ($showroom->appointment == 1) {
                $app_only = 'By appointment only';
            }

            $phone = '+1' . $showroom->phone1;
            $website_url = $showroom->website;
            $website = str_replace("https://", "", $website_url);
            $website = str_replace("http://", "", $website);
            $website = str_replace("www.", "", $website);

            if ($showroom->phone1 != '') {
                $phone_display = 'block';
            }
            if ($showroom->website != '') {
                $website_display = 'block';
            }

            if (strpos($showroom->authorized, 'JA') !== false) {
                $JA_display = 'block';
            }

            if (strpos($showroom->authorized, 'TB') !== false) {
                $TB_display = 'block';
            }

            if (preg_match('/^\+\d(\d{3})(\d{3})(\d{4})$/', $phone,  $matches)) {
                $phone_formatted = '(' . $matches[1] . ') ' . $matches[2] . '-' . $matches[3];
            }

            ?>

            <div class="card" style="font-family: Montserrat,sans-serif; line-height: 1.5;">
                <div class="card-body" style="padding-bottom: 10px; padding-left: 15px; padding-top: 5px;">
                    <h5 class="card-title" style="padding: 8px 0 0px 0; color: #043F51;">
                        {{ ucwords(strtolower($showroom->customer_name)) }}
                    </h5>
                    <div>
                        <span class="position-absolute top-0 left-0 translate-middle badge rounded-pill text-light" style="top: 4px !important; left: 6px; font-size: 9px; z-index: 2; position: relative !important;">
                            {{ $loop->iteration }}</span>

                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" viewBox="0 0 26 37" style="grid-area: 1 / auto / auto / auto; z-index: 1; display: inline; position: relative !important; left: -25px;" class="position-absolute top-0 left-0">
                            <g fill="none" fill-rule="evenodd" style="pointer-events: auto;">
                                <path class="RIFvHW-maps-pin-view-background" fill="#04403c" d="M13.0167 35C12.7836 35 12.7171 34.9346 12.3176 33.725C11.9848 32.6789 11.4854 31.0769 10.1873 29.1154C8.92233 27.1866 7.59085 25.6173 6.32594 24.1135C3.36339 20.5174 1 17.7057 1 12.6385C1.03329 6.19808 6.39251 1 13.0167 1C19.6408 1 25 6.23078 25 12.6385C25 17.7057 22.6699 20.55 19.6741 24.1462C18.4425 25.65 17.1443 27.2193 15.8793 29.1154C14.6144 31.0442 14.0818 32.6135 13.749 33.6596C13.3495 34.9346 13.2497 35 13.0167 35Z"></path>
                            </g>
                        </svg>

                        <i><span style="margin-left: -15px; font-size: 14px; color: #777;">{{ round($showroom->distance,2) }} miles
                            </span></i>

                    </div>
                    <div style="margin-top: 5px; margin-bottom: 5px;">
                        <address style="margin-bottom: 5px;">
                            {{ ucwords(strtolower($showroom->address1 . ' ' . $showroom->address2)) }}<br>
                            {{ ucwords(strtolower($showroom->city)) . ', ' . $showroom->state . '  ' . $showroom->zip }}<br>
                        </address>

                        <address style="margin-bottom: 10px;">
                            <span style="display: {{ $website_display }}">
                                <a target="_blank" href="{{ $website_url }} " style="color: #043F51;"><i class="bi bi-globe" style="font-size: 14px;"></i>
                                    <b> {{ $website }}</b></a></span>

                            <span style="display: {{ $phone_display }}">
                                <a href="tel: {{ $phone }} " style="color: #043F51;"><i class="bi bi-telephone" style="font-size: 14px;"></i>
                                    <b> {{ $phone_formatted }}</b></a></span>

                            <span style="font-size: 14px; color: #777;">
                                {{ $app_only }}</span>

                        </address>
                    </div>

                    <div style="display: flex;">
                        <img src="/assets/images/JA_icon.png" style="display: {{ $JA_display }}; border-radius: 15px; margin-right: 10px;" width="24px" title="Jonathan Adler">
                        <img src="/assets/images/TB_logo.jpg" style="display: {{ $TB_display }}; border: 1px solid #122A4F; border-radius: 15px;" width="24px" title="Tommy Bahama">
                    </div>
                </div>
            </div>

            @endforeach
        
            <!-- <a href="#" class="back-to-top d-flex align-items-center justify-content-center"
             style="display: none; visibility: visible; opacity: 1; right: 100px; position: relative; left: 290px; bottom: 70px;">
             <i class="bi bi-arrow-up-short"></i></a>             -->
        
        </div>

        <div class="col-lg-9" style="
        align-self: flex-start;
        position: sticky;
        top: 0px;
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
            scrollwheel: false
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

            //console.log("(" + markerData.locator_priority + ")" + customer + "(" + address + ")");

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
        var labelOriginHole = new google.maps.Point(12, 15);
        var pinSVGFilled = "M 12,2 C 8.1340068,2 5,5.1340068 5,9 c 0,5.25 7,13 7,13 0,0 7,-7.75 7,-13 0,-3.8659932 -3.134007,-7 -7,-7 z";
        var labelOriginFilled = new google.maps.Point(12, 9);


        var markerImage = { // https://developers.google.com/maps/documentation/javascript/reference/marker#MarkerLabel
            path: pinSVGFilled,
            anchor: new google.maps.Point(12, 17),
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
            origin: new google.maps.Point(0, 0), // origin
            anchor: new google.maps.Point(0, 0) // anchor
        };

        const icon = document.createElement("div");

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
        zoom = 11;

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
        zoom = 11;

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