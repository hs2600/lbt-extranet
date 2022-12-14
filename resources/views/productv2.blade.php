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

<style>
  .nav-pills .nav-link {
    padding: 0px 10px 5px 10px;
    margin-right: 10px;
  }

  .nav-pills .nav-link.active,
  .nav-pills .show>.nav-link {
    padding: 0px 10px 5px 10px;
    border: 1px solid #a9a9a9;
    color: #666;
    background-color: #fcfcfc;
  }

  .nav {
    --bs-nav-link-hover-color: #198754;
  }
</style>

<div class="breadcrumb-sticky d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center 
 pt-3 mb-2 border-bottom">

  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/collections/">Collections</a></li>
      <li class="breadcrumb-item"><a href="/collections/material">Material</a></li>
      <li class="breadcrumb-item"><a href="/collections/{{ strtolower($product->material) }}">{{ $product->material }}</a></li>
      <li class="breadcrumb-item"><a href="/collections/{{ strtolower($product->material) }}/{{ strtolower(str_replace('Ã©', 'é', $product->series)) }}">{{ ucwords(str_replace('Ã©', 'é', $product->series)) }}</a></li>
      <li class="breadcrumb-item"><a href="/collections/{{ strtolower($product->material) }}/{{ strtolower(str_replace('Ã©', 'é', $product->series)) }}/{{ strtolower(str_replace('/', '_', $product->size)) }}">{{ $product->size }}</a></li>
      <!-- <li class="breadcrumb-item active" aria-current="page">{{ $product->item }}</li> -->
    </ol>
  </nav>

</div>


<div class="container" style="padding: 0px; margin-top: 20px;">
  <div class="row" style="margin: 0px;
    padding: 10px 0px;
    border-radius: 5px;
    box-shadow: 1px 1px 2px #888;">

    <div class="col-md-6" style="padding-bottom: 15px;">
      <div style="max-height: 495px; overflow: hidden;
       border-radius: 5px;
       box-shadow: 1px 1px #ccc;
       ">

        <?php

        //generate image path

        $image = $product->img_url;
        $series = str_replace('Ã©', 'é', $product->series);
        $series = str_replace('é', 'e', $series);

        $size = $product->size_technical_name;

        if (is_null($size) == true) {
          $size = $product->size;
        }

        //$series = $product->series;
        //print_r($_SERVER);

        //if item image url is blank, use local image if exists, otherwise use series image
        if ($product->img_url == '') {

          $image = strtolower($product->material . '/' . $series);
          $image = $image_path . $image;
          $finish = $product->finish;

          if ($finish == '') {
            $finish = '-';
          }

          $filename = strtolower($image . '/' . $series . '_' . $size . '_' . $product->color . '_' . $finish . '.jpg');
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

        //if item image url is blank and series image url exists, use series url path
        if ($product->img_url == '' and $exists == false and $product->series_img_url != '') {
          $image = $product->series_img_url;
        }

        $qty = $product->qty;
        $uofm = strtolower(str_replace('each', 'piece', strtolower($product->uofm)));

        if (str_replace('each', 'piece', strtolower($product->uofm)) == 'piece') {
          $uofm = $uofm . 's';
        }

        $current_item = $product->sku;

        ?>


        <img id="myImg" src="{{ $image }}" alt="{{ ucwords(strtolower($product->description)) }}" class="product-image img-responsive">

      </div>
    </div>

    <div class="col-md-6">
      <span class="product-title">{{ ucwords(strtolower($product->description)) }}</span>
      <hr style="margin: 10px 0px; border: 0.5px solid #999;">
      <span class="product-price" style="padding-bottom: 10px;"><b> {{ '$'.number_format(sprintf("%.2f", $product->price),2) }}</b> / <i> {{ strtolower($product->uofm) }}</i></span>
      &nbsp;&nbsp;<span><i> ([TEST] Price shown is for PL 57)</i>

        <div class="row" style="padding: 10px; margin: 0px; margin-bottom: 15px; margin-top: 10px; background-color: #efefef;">
          <div class="col-sm-6">
            <label><B>Material:</B></label>
            <span>{{ $product->material }}</span>
          </div>
          <div class="col-sm-6">
            <label><B>Series:</B></label>
            <span>{{ str_replace('Ã©', 'é', $product->series) }}</span>
          </div>
          <div class="col-sm-6">
            <label><B>Size:</B></label>
            <span>{{ $product->size }}</span>
          </div>
          <div class="col-sm-6">
            <label><B>Color:</B></label>
            <span>{{ $product->color }}</span>
          </div>
          <div class="col-sm-6">
            <label><B>Finish:</B></label>
            <span>{{ $product->finish }}</span>
          </div>
        </div>
        <p class="product-description">{{ $size_desc }}</p>


        @if (count($product_lots) > 0 && $qty > 0)

        <div class="accordion accordion-flush" id="accordionPanelsStayOpenQty" style="padding-bottom: 20px;">
          <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne" style="border-bottom: 0.5px solid #e2e2e2;">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-Qty" aria-expanded="false" aria-controls="panelsStayOpen-Qty" style="
             
             padding: 10px;">
                <span class="product-qty"><b><i>{{ number_format($qty) }} {{ $uofm }} </b> stocked in Harbor City</i></span>
              </button>
            </h2>
            <div id="panelsStayOpen-Qty" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
              <div class="accordion-body" style="padding: 0px 20px;
                border: 1px solid #efefef;
                padding-top: 5px;
                border-top: 0px;
                border-radius: 5px;">

                <table class="table" style="font-size: 14px;">
                  <thead>
                    <tr>
                      <th style="padding: 5px;" scope="col">Lot</th>
                      <th style="padding: 5px;" scope="col">Qty</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    $lotm = 0;
                    ?>

                    @foreach ($product_lots as $lot)

                    <?php

                    $qty = $lot->qty;
                    $uofm = strtolower(str_replace('each', 'piece', strtolower($product->uofm)));

                    if (str_replace('each', 'piece', strtolower($product->uofm)) == 'piece') {
                      $qty = $lot->qty;
                      $uofm = $uofm . 's';
                    }

                    if (strpos($lot->lot, 'M') == true) {
                      $lotm = 1;
                    }

                    ?>

                    <tr>
                      <td style="padding: 5px;">{{ str_replace('M','*', $lot->lot) }}</td>
                      <td style="padding: 5px;">{{ number_format($qty) }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>

                <?php
                if ($lotm == 1) {
                  echo '<p>Distinct lots must be installed in separate areas due to color variation across batches. <br> * Lot must be sampled prior to sale. Color is <i>extra</i> unique.</p>';
                }
                ?>

              </div>
            </div>
          </div>

        </div>

        @else
        <div style="background-color: #fafafa; padding: 5px; margin-bottom: 20px;
        border-bottom: 1px solid #ddd;">
          <div class="">
            @if ($qty > 0)
            <span class="product-qty"><b><i>{{ number_format($qty) }} {{ $uofm }} </b> stocked in Harbor City</i></span>
            @else
            <span class="product-qty" style="color: #d35d5d;"><b><i>Item is currently out of stock.</b></i></span>
            @endif
          </div>
        </div>

        @endif


        <!-- <div class="row justify-content-md-center">
        <div class="col-md-8 col-sm-7" style="padding-bottom: 5px;">
          <button type="button" class="btn btn-info disabled" style="width: 100%; border-bottom: 5px solid rgb(136, 41, 41);">
            ADD TO CART
          </button>
          <br><br>
        </div>

        <div class="col-md-4 col-sm-5" style="padding-bottom: 5px;">
          <button type="button" class="btn btn-default disabled" style="width: 100%;  border-bottom: 5px solid rgb(136, 41, 41);">CART <i class="fa fa-shopping-cart"></i></button>
        </div>
      </div> -->


        <div class="accordion accordion-flush" id="accordionPanelsStayOpenQty" style="padding-bottom: 20px;">
          <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne" style="border-bottom: 0.5px solid #e2e2e2;">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-Docs" aria-expanded="false" aria-controls="panelsStayOpen-Docs" style="
             padding: 10px;">
                DOCUMENTATION
              </button>
            </h2>
            <div id="panelsStayOpen-Docs" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
              <div class="accordion-body">

                Series Brochures &nbsp;
                <!-- <i class="fa-solid fa-arrow-up-right-from-square"></i> -->
                <i class="fa fa-download"></i><BR>
                Applications & Testing &nbsp;<span class="fa fa-download"></span><BR>
                Care & Maintenance &nbsp;<span class="fa fa-download"></span><BR>

              </div>
            </div>
          </div>

        </div>


    </div>
  </div>

  <?php

  if ($series_desc != "") {
  ?>


    <div class="card" style="margin-top: 20px;">
      <div class="card-body" style="padding-bottom: 10px;">
        <h5 class="card-title">Series overview</h5>
        <p class="card-text">{{ $series_desc }}</p>
      </div>
    </div>


  <?php
  }

  ?>

  <!-- Size and color variation tabs -->
  <ul class="nav nav-tabs" style="margin-top:20px; border: 0px;" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="size-tab" data-bs-toggle="tab" data-bs-target="#size-tab-pane" type="button" role="tab" aria-controls="size-tab-pane" aria-selected="true">
        Size Variations
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="color-tab" data-bs-toggle="tab" data-bs-target="#color-tab-pane" type="button" role="tab" aria-controls="color-tab-pane" aria-selected="false">
        Color Variations
      </button>
    </li>
  </ul>
  <!-- Size and color variation content -->
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="size-tab-pane" role="tabpanel" aria-labelledby="size-tab" tabindex="0">

      <!-- Size variations -->
      @if (count($product_sizes) > 0)

      <div class="card" style="margin: 0px;">

        <div class="tab-pane fade show active" id="size-grid-tab-pane" role="tabpanel" aria-labelledby="size-grid-tab" tabindex="0">

          <div class="card-body" style="padding: 10px;">

            <div class="row" style="--bs-gutter-x: 0rem;">
              @foreach ($product_sizes as $product)
              <?php
              //generate image path

              $image = $product->img_url;
              $series = str_replace('Ã©', 'é', $product->series);
              $series = str_replace('é', 'e', $series);

              $size = $product->size_technical_name;

              if (is_null($size) == true) {
                $size = $product->size;
              }

              //if item image url is blank, use local image if exists, otherwise use series image
              if ($product->img_url == '') {
                $image = strtolower($product->material . '/' . $series);
                $image = $image_path . $image;
                $finish = $product->finish;

                if ($finish == '') {
                  $finish = '-';
                }

                $filename = strtolower($image . '/' . $series . '_' . $size . '_' . $product->color . '_' . $finish . '.jpg');
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

              //if item image url is blank and series image url exists, use series url path
              if ($product->img_url == '' and $exists == false and $product->series_img_url != '') {
                $image = $product->series_img_url;
              }

              ?>
              <div class="col-lg-2 img-container" Style="padding: 3px;
                  margin: 0px; border-radius: 4px;
                  ">
                <div>
                  <div class="img-thumbnail">
                    <a href="/products/{{ $product->sku }}">
                      <div style="min-height: 195px;">
                        <img src="{{$image}}" style="
                         border: 0px; padding: 0px;" alt="{{ ucwords(strtolower($product->description)) }}">
                      </div>
                    </a>

                    <div class="w-100 ph1 pv2 tc f2" style="border-top: 1px solid #efefef;">
                      <span class="db gray5 hover-blue7" style=" width: 135px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: inline-block;" title="{{ $product->description }}">
                        {{$product->size . ' ' . str_replace('-', '', $product->finish)}}
                      </span>
                    </div>
                  </div>

                  <a href="#" class="absolute top-075 right-075 gray4 hover-gray7" data-bs-toggle="modal" data-bs-target="#exModal" onclick="fileMenu('{{ $product }}','{{ $product->sku }}')"> <span data-balloon="More" data-balloon-pos="left" class="relative badge hover-bg-gray4 gray5 hover-gray7">
                      <i class="fas fa-ellipsis-h" style="font-size: 12px;"></i>
                    </span> </a>

                  <!-- <span class="favorite-button absolute bottom-1 right-025 gray2 hover-yellow3" style="background-color: transparent; border: 0; cursor: pointer;">
                      <i class="fas fa-star" style="font-size: 12px;"></i>
                    </span> -->

                </div>
              </div>
              @endforeach
            </div>

          </div>
        </div>

      </div>
      @endif
    </div>

    <div class="tab-pane fade" id="color-tab-pane" role="tabpanel" aria-labelledby="color-tab" tabindex="0">

      <!-- Color variations -->
      @if (count($product_colors) > 0)

      <div class="card" style="margin: 0px;">

        <div class="tab-pane fade show active" id="color-grid-tab-pane" role="tabpanel" aria-labelledby="color-grid-tab" tabindex="0">

          <div class="card-body" style="padding: 10px;">

            <div class="row" style="--bs-gutter-x: 0rem;">
              @foreach ($product_colors as $product)
              <?php
              //generate image path

              $image = $product->img_url;
              $series = str_replace('Ã©', 'é', $product->series);
              $series = str_replace('é', 'e', $series);

              $size = $product->size_technical_name;

              if (is_null($size) == true) {
                $size = $product->size;
              }

              //if item image url is blank, use local image if exists, otherwise use series image
              if ($product->img_url == '') {
                $image = strtolower($product->material . '/' . $series);
                $image = $image_path . $image;
                $finish = $product->finish;

                if ($finish == '') {
                  $finish = '-';
                }

                $filename = strtolower($image . '/' . $series . '_' . $size . '_' . $product->color . '_' . $finish . '.jpg');
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

              //if item image url is blank and series image url exists, use series url path
              if ($product->img_url == '' and $exists == false and $product->series_img_url != '') {
                $image = $product->series_img_url;
              }

              ?>
              <div class="col-lg-2 img-container" Style="padding: 3px;
                  margin: 0px; border-radius: 4px;
                  ">
                <div>
                  <div class="img-thumbnail">
                    <a href="/products/{{ $product->sku }}">
                      <div style="min-height: 195px;">
                        <img src="{{$image}}" style="
                         border: 0px; padding: 0px;" alt="{{ ucwords(strtolower($product->description)) }}">
                      </div>
                    </a>

                    <div class="w-100 ph1 pv2 tc f2" style="border-top: 1px solid #efefef;">
                      <span class="db gray5 hover-blue7" style=" width: 135px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: inline-block;" title="{{ $product->description }}">
                        {{$product->color . ' ' . str_replace('-', '', $product->finish)}}
                      </span>
                    </div>
                  </div>

                  <a href="#" class="absolute top-075 right-075 gray4 hover-gray7" data-bs-toggle="modal" data-bs-target="#exModal" onclick="fileMenu('{{ $product }}','{{ $product->sku }}')"> <span data-balloon="More" data-balloon-pos="left" class="relative badge hover-bg-gray4 gray5 hover-gray7">
                      <i class="fas fa-ellipsis-h" style="font-size: 12px;"></i>
                    </span> </a>

                  <!-- <span class="favorite-button absolute bottom-1 right-025 gray2 hover-yellow3" style="background-color: transparent; border: 0; cursor: pointer;">
                      <i class="fas fa-star" style="font-size: 12px;"></i>
                    </span> -->

                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>

      </div>
      @endif

    </div>
  </div>
</div>

<!-- Image Modal -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <!-- <a href="" id="img_href"> -->
  <img class="modal-content" id="img01">
  <!-- </a> -->
  <div id="caption"></div>
</div>

<script src="/assets/js/imgpreview.js"></script>

@endsection