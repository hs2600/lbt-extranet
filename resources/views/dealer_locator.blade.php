@extends('layouts.dashboard')

@section('content')


<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                @foreach ($showrooms as $showroom)
                <?php
                    $address = $showroom->address1;
                    $city = $showroom->city;
                    $state = $showroom->state;
                    $zip = $showroom->zip;

                    ?>
                <div class="card-header">

                    <h3 class="card-title">{{ $showroom->ship_to_name }}</h3>
                    <h5 class="card-title">{{ $address . ', ' . $city . ',  ' . $state . ' ' . $zip }}</h5>

                </div>
                <div class="card-body" style="padding: 10px;">

                    <iframe width="100%" style="border:0; height: 60vh;" loading="lazy" allowfullscreen src="https://www.google.com/maps/embed/v1/search?q={{ $address. ' ' . $city. ' ' . $state. ' ' . $zip. ' ' }}USA&key=AIzaSyCFX6HB-zkjkqf4KNSDjOTNHCl4wGBdpwU"></iframe>

                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>


@endsection