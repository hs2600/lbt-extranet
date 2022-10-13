@extends('layouts.app')

@section('content')

<style>
  .series-info {
    color: #ffffff;
    font-size: 20px;
    font-family: "Times New Roman";
  }

  .series-info h2 {
    text-transform: uppercase;
    margin: 0px;
    font-family: "Times New Roman";
    font-size: 30px;
  }
</style>

<div class="header-container" style="background-image: url(/assets/images/bg.png) !important;/* background-size: 91%; */background-position: top;background-repeat: repeat;">
  <div style="background-color: rgba(206,162,157,0.85);padding: 10px 0px;margin-bottom: 20px;">
    <div class="container series-info">
      <div class="col-md-3" style="vertical-align: top;">
        <h2>Series overview</h2>
      </div>
      <div class=" col-md-9">
        <p>Geological patterns are the rock stars of today's design. As the name suggests, the Agate glass series is evocative of the semi-precious stone found in volcanic formations. Agate's colorful, handcrafted banding visually combines the solidarity of stone, t</p>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="panel-body" style="padding: 0px 15px;">
      @foreach ($products as $product)
      <a href="/collections">Collections</a>
      / <a href="/collections/{{ strtolower($product->material) }}">{{ $product->material }}</a>
      / <a href="/collections/{{ strtolower($product->material) }}/{{ strtolower(str_replace('Ã©', 'é', $product->series)) }}">{{ str_replace('Ã©', 'é', $product->series) }}</a>
      / <a href="/collections/{{ strtolower($product->material) }}/{{ strtolower(str_replace('Ã©', 'é', $product->series)) }}/{{ strtolower(str_replace('/', '_', $product->size)) }}">{{ $product->size }}</a>
      @endforeach
    </div>
    <hr>

    <div class="col-md-6" style="padding-bottom: 15px; padding-left: 0px;">
      <div style="max-height: 495px; overflow: hidden; border: 1px solid #efefef; border-radius: 5px;">

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

        $qty = number_format($product->qty, 2);
        $uofm = strtolower(str_replace('each', 'piece', strtolower($product->uofm)));

        if (str_replace('each', 'piece', strtolower($product->uofm)) == 'piece') {
          $qty = number_format($product->qty, 0);
          $uofm = $uofm . 's';
        }

        $current_item = $product->sku;

        $image = str_replace('é', 'e', $image);

        ?>

        <img src="{{ $image }}" alt="{{ $product->sku }} product image" class="image img-responsive">

      </div>
    </div>

    <div class="col-md-6" style="padding-right: 0px;">
      <span class="product-title">{{ ucwords(strtolower($product->description)) }}</span>
      <hr style="margin-top: 10px; border: 0.5px solid #999;">

      <div class="row" style="padding: 10px; margin: 0px; margin-bottom: 15px; background-color: #efefef;">
        <div class="col-sm-6">
          <label class="">Material:</label>
          <span>{{ $product->material }}</span>
        </div>
        <div class="col-sm-6">
          <label class="">Series:</label>
          <span>{{ str_replace('Ã©', 'é', $product->series) }}</span>
        </div>
        <div class="col-sm-6">
          <label class="">Size:</label>
          <span>{{ $product->size }}</span>
        </div>
        <div class="col-sm-6">
          <label class="">Color:</label>
          <span>{{ $product->color }}</span>
        </div>
        <div class="col-sm-6">
          <label class="">Finish:</label>
          <span>{{ $product->finish }}</span>
        </div>
      </div>
      <p class="product-description">{{ $product->series_desc }}</p>

      <div style="background-color: #fafafa; padding: 5px; margin-bottom: 20px;
        border-bottom: 1px solid #ddd;">
        <div class="">
          <span class="product-price"><b><i>{{ $qty }} {{ $uofm }} </b> in stock in Harbor City</i></span>
        </div>
      </div>

      @endforeach

      <div class="row justify-content-md-center">
        <div class="col-md-8 col-sm-7" style="padding-bottom: 5px;">
          <button type="button" class="btn btn-info disabled" style="width: 100%; border-bottom: 5px solid rgb(136, 41, 41);">
            ADD TO CART
          </button>
          <br><br>
        </div>

        <div class="col-md-4 col-sm-5" style="padding-bottom: 5px;">
          <button type="button" class="btn btn-default disabled" style="width: 100%;  border-bottom: 5px solid rgb(136, 41, 41);">CART <i class="fa fa-shopping-cart"></i></button>
        </div>
      </div>


      <div style="border: 0px solid #e9e9e9;  ">

        <ul class="cate">
          <li class="drop-menu">
            <a style="cursor: pointer;" class="title collapsed" aria-expanded="false" data-toggle="collapse" data-target="#Cat">
              <span class="navbar-toggler-icon">
                <h5 style="color: black;">DOCUMENTATION</h5>
              </span> </a>
            <div class="collapsed collapse" id="Cat" aria-expanded="false" style="padding-left: 10px; line-height: 30px;">
              Series Brochures &nbsp;<span class="fa fa-download"></span><BR>
              Applications & Testing &nbsp;<span class="fa fa-download"></span><BR>
              Care & Maintenance &nbsp;<span class="fa fa-download"></span><BR>
            </div>
          </li>
        </ul>
      </div>

    </div>
  </div>
</div>

<div class="container">
  <div class="col-md">

    @if (count($product_colors) > 0)
    <div class="panel panel-default">
      <div class="panel-heading">
        Color Variations
      </div>

      <div class="panel-body">
        <table class="table table-striped task-table">
          <thead>
            <th>SKU</th>
            <th>Item</th>
            <th>Description</th>
            <th>Series</th>
            <th>Size</th>
            <th>Color</th>
            <th>Finish</th>
            <th>Site</th>
            <th>Qty</th>
            <th>UofM</th>
          </thead>
          <tbody>
            @foreach ($product_colors as $product)
            <tr>
              <td class="table-text">
                <?php

                $series = str_replace('Ã©', 'é', $product->series);

                if ($current_item == $product->sku) {
                  echo '<div><b><span style="color: #999;"> ' . $product->sku . '</span></b></div>';
                } else {
                  echo '<div><a href="/products/' . $product->sku . '">' . $product->sku . '</a></div>';
                }

                ?>
              </td>
              <td class="table-text">
                <div>{{ $product->item }}</div>
              </td>
              <td class="table-text">
                <div>{{ $product->description }}</div>
              </td>
              <td class="table-text">
                <div>{{ $series }}</div>
              </td>
              <td class="table-text">
                <div>{{ $product->size }}</div>
              </td>
              <td class="table-text">
                <div>{{ $product->color }}</div>
              </td>
              <td class="table-text">
                <div>{{ $product->finish }}</div>
              </td>
              <td class="table-text">
                <div>{{ $product->site }}</div>
              </td>
              <td class="table-text">
                <div>{{ number_format($product->qty,0) }}</div>
              </td>
              <td class="table-text">
                <div>{{ $product->uofm }}</div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
    @endif
  </div>
</div>
@endsection

