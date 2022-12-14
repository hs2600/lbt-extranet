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
        <div class="card-header" style="padding: 0px;">

          <div class="row" style="padding: 8px 16px;">
            <div class="col-lg-8">
              <span class="card-title" style="padding: 0px; font-size: 1.5rem;">
                {{ ucwords(str_replace('_', '/', $size)) }}
              </span>
            </div>
            <div class="col-lg-4">
              <!-- Size variation sub tabs -->
              <ul class="nav nav-pills" style="float: right;" id="mySizeTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="size-table-tab" data-bs-toggle="tab" data-bs-target="#size-table-tab-pane" type="button" role="tab" aria-controls="size-table-tab-pane" aria-selected="true">
                    <i class="bi bi-table" style="font-size: 20px;"></i></button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="size-grid-tab" data-bs-toggle="tab" data-bs-target="#size-grid-tab-pane" type="button" role="tab" aria-controls="size-grid-tab-pane" aria-selected="false">
                    <i class="bi bi-grid-fill" style="font-size: 20px;"></i></button>
                </li>
              </ul>
            </div>

          </div>

          <div class="row" style="padding: 10px 30px; padding-top: 0px;">
            @foreach ($collection as $collection)
            {{ $collection->description }}
            @endforeach
          </div>

        </div>

        <div class="tab-content" id="mySizeTabContent">

          <div class="tab-pane fade" id="size-table-tab-pane" role="tabpanel" aria-labelledby="table-tab" tabindex="0">

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

                      $series = str_replace('????', '??', $product->series);

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

          <div class="tab-pane fade show active" id="size-grid-tab-pane" role="tabpanel" aria-labelledby="size-grid-tab" tabindex="0">

            <div class="card-body" style="padding: 10px;">

              <div class="row" style="--bs-gutter-x: 0rem;">
                @foreach ($products as $product)
                <?php
                //generate image path

                $image = $product->img_url;
                $material_desc = $product->material_desc;
                $series = str_replace('????', '??', $product->series);
                $series = str_replace('??', 'e', $series);

                $size = str_replace('/','_',$product->size);
                $size = str_replace(' ','_',$size);
                $size = str_replace('"','',$size);

                // echo $size;
                                
                //if item image url is blank, use local image if exists, otherwise use series image
                if ($product->img_url == '') {
                  $image = strtolower($product->material . '/' . $series);
                  $image = $image_path . $image;
                  $finish = str_replace('glazed','',strtolower($product->finish));
                  $finish = str_replace('mix','',$finish);
    
                  if ($finish == '') {
                    $finish = '-';
                  }
    
                  $filename = strtolower($image . '/' . $series . '_' . $size . '_' . $product->color . '_' . $finish . '.jpg');
                  $filename = str_replace('??', 'e', $filename);
                  $filename = str_replace(' ', '_', $filename);
                  $filename = str_replace('_-', '', $filename);
                  $full_filename = strtolower($server_root . $filename);

                  // echo $filename;

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

                // echo $image;
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

                $qty = $product->qty;
                $uofm = strtolower(str_replace('each', 'piece', strtolower($product->uofm)));

                if (str_replace('each', 'piece', strtolower($product->uofm)) == 'piece') {
                  $uofm = $uofm . 's';
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
                        <span class="db gray5 hover-blue7" style=" width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: inline-block;" title="{{ $product->description }}">
                          {{$product->size . ' ' . $product->color . ' ' . str_replace('-', '', $product->finish) }} &nbsp;
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
      </div>

      @endif
    </div>
  </div>
</section>

@endsection