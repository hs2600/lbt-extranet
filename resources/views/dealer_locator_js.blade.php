@extends('layouts.dashboard')

@section('content')

<style>
    .text-center {
        text-align: center;
    }

    #map {
        width: "100%";
        height: 400px;
    }
   
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
  }    

</style>
<h1 class="text-center">Laravel Google Maps</h1>
<div id="map"></div>

<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap&v=weekly"
      defer
    ></script>
<script>
    let map, activeInfoWindow, markers = [];

    /* ----------------------------- Initialize Map ----------------------------- */
    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: 28.626137,
                lng: 79.821603,
            },
            zoom: 15
        });

        map.addListener("click", function(event) {
            mapClicked(event);
        });

        initMarkers();
    }

    /* --------------------------- Initialize Markers --------------------------- */
    function initMarkers() {
        const initialMarkers = <?php echo json_encode($initialMarkers); ?>;

        const marker = new google.maps.Marker({
            position: {
                lat: 28.625043,
                lng: 79.810135
            },
            label: {
                color: "white",
                text: "P4"
            },
            draggable: true,
            map
        });
        markers.push(marker);

        for (let index = 0; index < initialMarkers.length; index++) {

            const markerData = initialMarkers[index];
            const marker = new google.maps.Marker({
                position: markerData.position,
                label: markerData.label,
                draggable: markerData.draggable,
                map
            });
            markers.push(marker);

            const infowindow = new google.maps.InfoWindow({
                content: `<b>${markerData.position.lat}, ${markerData.position.lng}</b>`,
            });
        }
    }


</script>

@endsection