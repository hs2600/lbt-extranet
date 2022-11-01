@extends('layouts.dashboard')

@section('content')

<?php

$image_path = '/assets/images/products/';
$server_root = $_SERVER["DOCUMENT_ROOT"];
$cdn_url = 'https://cdn.lunadabaytile.com/portal';

if (strpos($_SERVER['HTTP_HOST'], '8000') == false) {
  $server_root = '/portal';
}

?>

<div class="breadcrumb-sticky d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center 
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
            $default_finish = $collection->default_finish;
            $default_color_str = '';

            if ($default_color != '') {
              $default_color_str = 'Color shown: ' . $default_color;
            }

            ?>

            <div style="max-height: 200px; max-width: 610px;
              overflow: hidden;
              border-radius: 5px;
              box-shadow: 1px 1px #ccc;
              float: left;
              margin-right: 20px;">
              <img src="{{ $collection->img_url }}" alt="{{ $collection->series }}" class="product-image">
            </div>
            <p style="font-size: 20px;
              font-family: Playfair Display,Georgia,Times New Roman,serif;">
              {{ $collection->description }}
              @endforeach
            </p>
          </div>

        </div>
        <div class="card-body" style="padding: 10px;">

          <div class="row" style="--bs-gutter-x: 0rem;">

            <div class="col" style="padding: 3px 10px;"><span style="float: right; color: #999;">{{ $default_color_str }} </span></div>
          </div>

          <div class="row" style="--bs-gutter-x: 0rem;">
            @foreach ($products as $product)
            <?php
            //generate image path

            $image = $product->img_url;
            $material_desc = $product->material_desc;
            $series = str_replace('Ã©', 'é', $product->series);
            $series = str_replace('é', 'e', $series);
            $size = $product->size_technical_name;

            if (is_null($size) == true) {
              $size = $product->size;
            }

            //if item image url is blank, use local image if exists, otherwise use series image
            if ($product->img_url == '') {
              $image = $product->material . '/' . $series;
              $image = $image_path . $image;
              $finish = $default_finish;

              if ($finish == '') {
                $finish = '-';
              }

              $filename = $image . '/' . $series . '_' . $size . '_' . $default_color . '_' . $finish . '.jpg';
              $filename = str_replace('é', 'e', $filename);
              $filename = str_replace(' ', '_', $filename);
              $filename = str_replace('_-', '', $filename);
              $full_filename = strtolower($server_root . $filename);

              $exists = false;
              if (file_exists($full_filename)) {
                $image = $filename;
                $exists = true;
                //echo 'file exists!';
              } else {
                $image = $image . '.png';
                //echo 'not exists!';
                if (file_exists($server_root . $image) == false) {
                  $image = $image_path . "blank.png";
                }
              }
            }

            $image = $cdn_url . strtolower($image);

            //if item has image url and is not located on http path, use local path
            if ($product->img_url != '' and strpos($product->img_url, 'http') === false) {
              $image = $product->material . '/' . $series . '/' . $product->img_url;
              $image = $image_path . $image;
            }

            //if item has image url and is located on http path, use image url
            if ($product->img_url != '' and strpos($product->img_url, 'http') != 0) {
              $image = $product->img_url;
            }

            // //if item image url is blank and series image url exists, use series url path
            // if ($product->img_url == '' and $exists == false and $product->series_img_url != '') {
            //   $image = $product->series_img_url;
            // }

            ?>

            <div class="col-lg-2 img-container" Style="padding: 3px; margin: 0px; border-radius: 4px;">
              <div>
                <div class="img-thumbnail">
                  <a href="/collections/{{ strtolower($product->material) }}/{{ strtolower(str_replace('Ã©', 'é', $product->series)) }}/{{ strtolower(str_replace('/', '_', $product->size)) }}">
                    <img src="{{$image}}" style="
                         border: 0px; padding: 0px;" alt="{{ ucwords(strtolower($product->description)) }}">
                  </a>

                  <div class="w-100 ph1 pv2 tc f2" style="border-top: 1px solid #efefef;">
                    <span class="db gray5 hover-blue7" style=" width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: inline-block;" title="{{ $product->description }}">
                      <a href="/collections/{{ strtolower($product->material) }}/{{ strtolower(str_replace('Ã©', 'é', $product->series)) }}/{{ strtolower(str_replace('/', '_', $product->size)) }}">
                        {{$product->size}}
                      </a>
                    </span>
                  </div>
                </div>

              </div>
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