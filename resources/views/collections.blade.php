@extends('layouts.app')

@section('content')

<div class="header-container" style="background-image: url(/assets/images/hd_bg.png) !important; background-size: 100%; background-position: top; background-repeat: no-repeat;">
  <div style="background-color: rgba(20,64,60,0.75); padding: 50px 0px;">

    <div class="container">
      <div class="row center-block">
        <h1>Collections</h1>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row" style="border: 0px solid red; padding: 0px; margin-top: 10px; margin-bottom: 20px;">

    @if (count($collections) > 0)
    @foreach ($collections as $collection)

    <div class="col-md-6 img-container" style="border: 1px solid #efefef; padding: 0px; min-height: 200px;">
      <a href="/collections/{{ $collection->material }}">
      <?php
        $image = $collection->series;
        if($image == "-") {
          $image = $collection->material;
        }
        $image = strtolower(str_replace(" ","_",$image))."_h.png";
      ?>
      <img src="/assets/images/products/{{ $image }}" class="img-preview" style="width: 100%;">
        <span class="middle-vis">
          {{ $collection->material }} <span class="fa fa-arrow-circle-right"></span>
        </span>
      </a>
    </div>

    @endforeach
    @endif

  </div>
</div>

@endsection