@extends('layouts.dashboard')

@section('content')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center 
 pt-3 pb-2 mb-2 border-bottom">

  @foreach ($products as $product)
  <nav aria-label="breadcrumb" style="padding-top: 10px; margin-bottom: -5px;">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/collections/">Collections</a></li>
      <li class="breadcrumb-item"><a href="/collections/{{ strtolower($product->material) }}">{{ $product->material }}</a></li>
      <li class="breadcrumb-item"><a href="/collections/{{ strtolower($product->material) }}/{{ strtolower(str_replace('Ã©', 'é', $product->series)) }}">{{ ucwords(str_replace('Ã©', 'é', $product->series)) }}</a></li>
      <li class="breadcrumb-item"><a href="/collections/{{ strtolower($product->material) }}/{{ strtolower(str_replace('Ã©', 'é', $product->series)) }}/{{ strtolower(str_replace('/', '_', $product->size)) }}">{{ $product->size }}</a></li>
      <!-- <li class="breadcrumb-item active" aria-current="page">{{ $product->item }}</li> -->
    </ol>
  </nav>
  @endforeach

</div>


<div class="container" style="background-color: white; 
padding: 10px; border: 1px solid #eee; border-radius: 5px; margin-top: 20px;">
  <div class="row">

    <div class="col-md-6" style="padding-bottom: 15px;">
      <div style="max-height: 495px; overflow: hidden; border: 1px solid #ccc; border-radius: 5px;">

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


        <img id="myImg" src="{{ $image }}" alt="{{ $product->description }}" class="product-image img-responsive">

      </div>
    </div>

    <div class="col-md-6">
      <span class="product-title">{{ ucwords(strtolower($product->description)) }}</span>
      <hr style="margin-top: 10px; border: 0.5px solid #999;">

      <div class="row" style="padding: 10px; margin: 0px; margin-bottom: 15px; background-color: #efefef;">
        <div class="col-sm-6">
          <label class=""><B>Material:</B></label>
          <span>{{ $product->material }}</span>
        </div>
        <div class="col-sm-6">
          <label class=""><B>Series:</B></label>
          <span>{{ str_replace('Ã©', 'é', $product->series) }}</span>
        </div>
        <div class="col-sm-6">
          <label class=""><B>Size:</B></label>
          <span>{{ $product->size }}</span>
        </div>
        <div class="col-sm-6">
          <label class=""><B>Color:</B></label>
          <span>{{ $product->color }}</span>
        </div>
        <div class="col-sm-6">
          <label class=""><B>Finish:</B></label>
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




      <div class="accordion accordion-flush" id="accordionPanelsStayOpenExample" style="--bs-accordion-active-bg: #fefefe;
       --bs-accordion-btn-focus-border-color: #efefef;
       --bs-accordion-btn-padding-y: 0.5rem;
       --bs-accordion-active-color: #000;
       --bs-accordion-body-padding-y: 0.5rem;       
       ">
        <div class="accordion-item">
          <h2 class="accordion-header" id="panelsStayOpen-headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
              DOCUMENTATION
            </button>
          </h2>
          <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
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

  if ($product->material_desc != "") {
  ?>


    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Series overview</h5>
        <p class="card-text">{{ $product->material_desc }}</p>
      </div>
    </div>


  <?php
  }

  ?>



  @if (count($product_colors) > 0)


  <div class="card">
    <div class="card-header">
      <h5 class="card-title">Color Variations</h5>
    </div>
    <div class="card-body">
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
          @foreach ($product_colors as $product)
          <tr>
            <td scope="row">
              <?php

              $series = str_replace('Ã©', 'é', $product->series);

              if ($current_item == $product->sku) {
                echo '<div><b><span style="color: #999;"> ' . $product->item . '</span></b></div>';
              } else {
                echo '<div><a href="/products/' . $product->sku . '">' . $product->item . '</a></div>';
              }

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
  @endif

  <!-- The Modal -->
  <div id="myModal" class="modal">
    <span class="close">&times;</span>
    <!-- <a href="" id="img_href"> -->
    <img class="modal-content" id="img01">
    <!-- </a> -->
    <div id="caption"></div>
  </div>

</div>

<script src="/assets/js/imgpreview.js"></script>

@endsection