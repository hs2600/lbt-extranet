@extends('layouts.dashboard')

@section('content')



<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center 
 pt-3 mb-2 border-bottom">

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/collections/">Collections</a></li>
      <li class="breadcrumb-item"><a href="/collections/material">Material</a></li>
      <li class="breadcrumb-item"><a href="/collections/{{ $material }}">{{ $material }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ ucwords($series) }}</li>
    </ol>
  </nav>

</div>


<section class="section dashboard">
  <div class="row">
    <div class="col-lg-12">


      @if (count($products) > 0)

      <div class="card">
        <div class="card-header">
          <!-- <h6 class="card-title">{{ ucwords(str_replace('Ã©', 'é', $series)) }} Items by Size</h6> -->

          <h4 class="card-title">{{ ucwords(str_replace('Ã©', 'é', $series)) }}</h4>

          <div class="d-none d-md-block">

            @foreach ($collection as $collection)
            <?php
            $default_color = $collection->default_color;
            ?>

            <div style="max-height: 200px; max-width: 450px;
              overflow: hidden;
              border-radius: 5px;
              box-shadow: 1px 1px #ccc;
              float: left;
              margin-right: 20px;">
              <img src="{{ $collection->img_url }}" alt="{{ $collection->series }}" class="product-image">
            </div>

            {{ $collection->description }}
            @endforeach
          </div>

        </div>
        <div class="card-body" style="padding: 10px;">

          <div class="row" style="--bs-gutter-x: 0rem;">

            <div class="col" style="padding: 3px 10px;"><span style="float: right;">Color shown: {{ $default_color }} </span></div>
          </div>

          <div class="row" style="--bs-gutter-x: 0rem;">
            @foreach ($products as $product)
            <?php
            //generate image path

            $image = $product->img_url;
            $series = str_replace('Ã©', 'é', $product->series);

            //if item image url is blank, use local image if exists, otherwise use series image
            if ($product->img_url == '') {
              $image = $product->material . '/' . $series;
              $image = '/assets/images/products/' . $image;
              $finish = $product->finish;

              if ($finish == '') {
                $finish = '-';
              }

              $filename = $image . '/' . $series . '_' . $product->size . '_' . $default_color . '_' . $finish . '.jpg';
              $filename = strtolower(str_replace(' ', '_', $filename));
              $filename = str_replace('_-', '', $filename);
              $filename = str_replace('hexagon', 'hex', $filename);
              $filename = str_replace('japonaise', 'japon', $filename);

              // echo $filename;

              $full_filename = $_SERVER["DOCUMENT_ROOT"] . $filename;

              $exists = false;
              if (file_exists($full_filename)) {
                $image = $filename;
                $exists = true;
                //echo 'file exists!';
              } else {
                $image = $image . '.png';
                //echo 'not exists!';
              }
              $image = strtolower(str_replace(' ', '_', $image));
            }

            //if item has image url and is not located on http path, use local path
            if ($product->img_url != '' and strpos($product->img_url, 'http') === false) {
              $image = $product->material . '/' . $series . '/' . $product->img_url;
              $image = strtolower(str_replace(' ', '_', $image));
              $image = '/assets/images/products/' . $image;
            }

            //if item has image url and is located on http path, use image url
            if ($product->img_url != '' and strpos($product->img_url, 'http') != 0) {
              $image = $product->img_url;
            }

            //if item image url is blank and series image url exists, use series url path
            // if ($product->img_url == '' and $exists == false and $product->series_img_url != '') {
            //   $image = $product->series_img_url;
            // }

            $image = str_replace('é', 'e', $image);

            ?>
            <div class="col-2 img-container" Style="padding:5px;">
              <a href="/collections/{{ strtolower($product->material) }}/{{ strtolower(str_replace('Ã©', 'é', $product->series)) }}/{{ strtolower(str_replace('/', '_', $product->size)) }}">
                <img class="img-thumbnail" src="{{$image}}" width="400" height="400"></a>
              {{$product->size}}
            </div>
            @endforeach
          </div>

          <div class="row" style="--bs-gutter-x: 0rem; padding: 6px 6px;">

            {{ $products->links() }}
          </div>

        </div>

      </div>
      @endif

    </div>

  </div>

</section>

@endsection