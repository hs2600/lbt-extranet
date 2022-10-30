@extends('layouts.dashboard')

@section('content')


<section class="section dashboard">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-header">

          <h4 class="card-title">Collections</h4>

        </div>
        <div class="card-body" style="padding: 10px;">

          <div class="row" style="--bs-gutter-x: 0rem;">


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
                  $image = '/assets/images/products/' . $collection->material . '/' . $image . '.png';

                  $path = strtolower($path);
                  $image = strtolower($image);

                  if (file_exists($_SERVER["DOCUMENT_ROOT"] . $image) == false) {
                    $image = "/assets/images/products/blank.png";
                  }

              } else {
                  $category = $collection->material;
                  $image = '/assets/images/products/' . str_replace(' ', '_', $category) . '_h.png';
                  $path = strtolower($category);
                  $image = strtolower($image);
              }

              // if ($collection->img_url != '') {
              //   $image = $collection->img_url;
              // }
              
            ?>

            <div class="col-lg-3 img-container"
             style="
              padding: 5px;
              min-height: 300px;
              overflow: hidden;
              ">

              <span class="{{ $featured }}">{{ ucwords($featured) }}</span>

              <a href="/collections/{{ $path }}">
                <img src="{{ $image }}" class="img-preview"
                style="
                width: 100%;
                height: 100%;
                object-fit: cover;
                border: 1px solid #efefef;
                border-radius: 5px;
                ">
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
      </div>
    </div>
  </div>
</section>

@endsection