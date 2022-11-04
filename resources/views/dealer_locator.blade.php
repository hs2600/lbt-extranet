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
                    $phone = $showroom->phone1;

                    ?>
                <div class="card-header">

                    <h3 class="card-title" style="margin-bottom: 0px; padding: 0px;">{{ ucwords(Strtolower($showroom->ship_to_name)) }}</h3>
                    <h5 class="card-title" style="margin-top: 0px; padding: 0px;">{{ ucwords(Strtolower($address)) . ', ' . ucwords(Strtolower($city)) . ',  ' . $state . ' ' . $zip }}<BR>
                    {{ '(' . substr($phone,0,3) . ') ' . substr($phone,3,3) . '-' . substr($phone,6,4) }}
                    </h5>

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