@extends('layouts.app')

@section('content')

<div class="header-container" style="background-image: url(/assets/images/hd2_bg.png) !important; background-size: 100%; background-position: bottom; background-repeat: repeat;">
  <div style="background-color: rgba(5,64,60,0.65); padding: 20px 0px;">
    <div class="container">
      <div class="row center-block">
        <h1>{{ ucwords(str_replace('Ã©', 'é', $series)) }}</h1>
      </div>
      <div class="center-block text-justify">
        <h4 style="font-family: Times New Roman;">
          @foreach ($collection as $collection)
          {{ $collection->description }}
          @endforeach
        </h4>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="col-md">

    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/collections/">Collections</a></li>
        <li class="breadcrumb-item"><a href="/collections/material">Material</a></li>
        <li class="breadcrumb-item"><a href="/collections/{{ $material }}">{{ $material }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ ucwords($series) }}</li>
      </ol>
    </nav>

    @if (count($products) > 0)

    <div class="card">
      <div class="card-header">
        <h6 class="card-title">{{ ucwords(str_replace('Ã©', 'é', $series)) }} Items by Size</h6>
      </div>
      <div class="container text-center">
        <div class="row">
          @foreach ($products as $product)
          <?php
          //generate image path

          $image = $product->img_url;
          $material_desc = $product->material_desc;
          $series = str_replace('Ã©', 'é', $product->series);
          //$series = $product->series;
          //print_r($_SERVER);

          //if item image url is blank, use local image if exists, otherwise use series image
          if ($product->img_url == '') {
            $image = $product->material . '/' . $series;
            $image = '/assets/images/products/' . $image;
            $finish = $product->finish;

            if ($finish == '') {
              $finish = '-';
            }

            $filename = $image . '/' . $series . '_' . $product->size . '_' . $product->color . '_' . $finish . '.jpg';
            $filename = strtolower(str_replace(' ', '_', $filename));
            $filename = str_replace('_-', '', $filename);
            $filename = str_replace('hexagon', 'hex', $filename);
            $filename = str_replace('japonaise', 'japon', $filename);
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
          if ($product->img_url == '' and $exists == false and $product->series_img_url != '') {
            $image = $product->series_img_url;
          }


          $current_item = $product->sku;

          $image = str_replace('é', 'e', $image);

          ?>
          <div class="col-2" Style="padding:5px;">
          <a href="/collections/{{ strtolower($product->material) }}/{{ strtolower(str_replace('Ã©', 'é', $product->series)) }}/{{ strtolower(str_replace('/', '_', $product->size)) }}">
          <img src="{{$image}}" width="400" height="400"></a>
            {{$product->size}}
          </div>
          @endforeach
        </div>
      </div>


      <!-- <div class="card-body">
        <table class="table table-striped task-table">
          <thead>
            <th>Size</th>
          </thead>
          <tbody>
            @foreach ($products as $product)
            <tr>
              <td class="table-text">
                <div><a href="/collections/{{ strtolower($product->material) }}/{{ strtolower(str_replace('Ã©', 'é', $product->series)) }}/{{ strtolower(str_replace('/', '_', $product->size)) }}"> {{ $product->size }} </a></div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table> -->
    </div>
  </div>
  @endif
</div>
</div>
@endsection