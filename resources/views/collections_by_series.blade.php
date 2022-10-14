@extends('layouts.app')

@section('content')

<div class="header-container" style="background-image: url(/assets/images/hd2_bg.png) !important; background-size: 100%; background-position: top; background-repeat: no-repeat;">
  <div style="background-color: rgba(5,64,60,0.65); padding: 50px 0px;">

    <div class="container">
      <div class="row center-block">
        <h1>Collections by Series</h1>
      </div>
    </div>
  </div>
</div>

<div class="container" style="padding-bottom: 20px;">

  <div class="row" style="border: 0px solid red; padding: 0px; margin-top: 10px; margin-bottom: 20px;">

    @if (count($collections) > 0)
    @foreach ($collections as $collection)
    <?php
    $image = '';
    $category = '';
    $path = '';
    $featured = '';

    if ($collection->status == 3) {
      $featured = 'new';
    } elseif ($collection->status == 2) {
      $featured = 'featured';
    }

    if ($collection->material != '-') {
      //if category is series
      $category = $collection->series;
      $path = $collection->material . '/' . str_replace('/', '_', $category);
      $image = $collection->series;
      $image = str_replace(' ', '_', $image);
      $image = '/assets/images/products/'.$collection->material . '/' . $image . '.png';

      $path = strtolower($path);
      $image = strtolower($image);
    } else {
      $category = $collection->material;
      $image = '/assets/images/products/'.str_replace(' ', '_', $category) . '_h.png';
      $path = strtolower($category);
      $image = strtolower($image);
    }

    if ($collection->img_url != ''){
      $image = $collection->img_url;
    }
    ?>

    <div class="col-md-4 img-container" style="border: 1px solid #efefef; padding: 0px; min-height: 200px;">
      <span class="{{ $featured }}">{{ ucwords($featured) }}</span>

      <a href="/collections/{{ $path }}">
        <img src="{{ $image }}" class="img-preview" style="width: 100%;">
        <span class="middle-vis">
          {{ $category }} <span class="fa fa-arrow-circle-right"></span>
        </span>
      </a>
    </div>
    @endforeach
    @endif

  </div>

  {{ $collections->onEachSide(2)->links() }}


</div>

@endsection