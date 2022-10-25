@extends('layouts.dashboard')

@section('content')


<style>
  .nav-pills .nav-link {
    padding: 5px 10px 2px 10px;
    margin-right: 10px;
  }

  .nav-pills .nav-link.active,
  .nav-pills .show>.nav-link {
    padding: 5px 10px 2px 10px;
    border: 1px solid #a9a9a9;
    color: #666;
    background-color: #fcfcfc;
  }
</style>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center 
 pt-3 mb-2 border-bottom">

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">

      <li class="breadcrumb-item"><a href="/collections/">Collections</a></li>
      <li class="breadcrumb-item"><a href="/collections/material">Material</a></li>
      <li class="breadcrumb-item"><a href="/collections/{{ $material }}">{{ $material }}</a></li>
      <li class="breadcrumb-item"><a href="/collections/{{ $material }}/{{ $series }}">{{ ucwords($series) }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ str_replace('_', '/', $size) }}</li>
    </ol>
  </nav>

</div>


<section class="section dashboard">
  <div class="row">
    <div class="col-lg-12">


      @if (count($products) > 0)


      <div class="card" style="margin: 0px;">
        <div class="card-header">

        <div class="row" style="padding: 0px;">
        <div class="col-lg-8">
          <h4 class="card-title" style="padding: 0px;">{{ ucwords(str_replace('1/2','0.5', str_replace('_', '/', $size))) }}</h4>
        </div>
        <div class="col-lg-4">
          <!-- Size variation sub tabs -->
          <ul class="nav nav-pills" style="float: right;" id="mySizeTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="size-table-tab" data-bs-toggle="tab" data-bs-target="#size-table-tab-pane" type="button" role="tab" aria-controls="size-table-tab-pane" aria-selected="true">
                <i class="fa-solid fa-list" style="font-size: 20px; color: #000;"></i></button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="size-grid-tab" data-bs-toggle="tab" data-bs-target="#size-grid-tab-pane" type="button" role="tab" aria-controls="size-grid-tab-pane" aria-selected="false"><i class="fa-solid fa-border-all" style="font-size: 20px; color: #000;"></i></button>
            </li>
          </ul></div>

        </div>
        </div>

        <div class="tab-content" id="mySizeTabContent">

          <div class="tab-pane fade show active" id="size-table-tab-pane" role="tabpanel" aria-labelledby="table-tab" tabindex="0">

            <div class="card-body" style="padding-top: 10px;">
              <table class="table table-striped table-borderless datatable">
                <thead>
                  <tr>
                    <th scope="col">Item</th>
                    <th scope="col">Description</th>
                    <th scope="col">Color</th>
                    <th scope="col">Finish</th>
                    <th scope="col">Site</th>
                    <th scope="col">Qty</th>
                    <th scope="col">UofM</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($products as $product)
                  <tr>
                    <td scope="row">
                      <?php

                      $series = str_replace('Ã©', 'é', $product->series);

                      echo '<div><a href="/products/' . $product->sku . '">' . $product->item . '</a></div>';

                      ?>
                    </td>
                    <td>
                      <div>{{ $product->description }}</div>
                    </td>
                    <td>
                      <div>{{ $product->color }}</div>
                    </td>
                    <td>
                      <div>{{ $product->finish }}</div>
                    </td>
                    <td>
                      <div>{{ $product->site }}</div>
                    </td>
                    <td>
                      <div>{{ number_format($product->qty,0) }}</div>
                    </td>
                    <td>
                      <div>{{ $product->uofm }}</div>
                    </td>

                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

          </div>

          <div class="tab-pane fade" id="size-grid-tab-pane" role="tabpanel" aria-labelledby="size-grid-tab" tabindex="0">

            <div class="card-body" style="padding: 10px;">

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

                $image = str_replace('é', 'e', $image);

                ?>
                <div class="col-lg-2 img-container" Style="padding: 5px;
                  ">
                  <a href="/products/{{ $product->sku }}">
                    <img class="img-thumbnail" src="{{$image}}" style="
                    border-radius: 5px;">
                  </a>
                  {{$product->size . ' ' . $product->color . ' ' . str_replace('-', '', $product->finish)}}
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>

      @endif
    </div>
  </div>
</section>

@endsection