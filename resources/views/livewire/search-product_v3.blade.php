<?php

$image_path = '/assets/images/products/';
$server_root = $_SERVER["DOCUMENT_ROOT"];
$cdn_url = 'https://cdn.lunadabaytile.com/portal';

if(strpos($_SERVER ['HTTP_HOST'],'8000') == false){
  $server_root = '/portal';
}

?>

<div>

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

  <section class="section dashboard">
    <div class="row">

      <form style="padding-bottom: 10px;">
        <div class="row">

          <div class="col-sm">
            <label for="input">Material</label>
            <input type="search" class="form-control" placeholder="Material" wire:model="material" list="materials">
            <datalist id="materials">
              @foreach ($filter_materials as $filter)
              <option value="{{ $filter->name }}">
                @endforeach
            </datalist>
          </div>

          <div class="col-sm">
            <label for="input">Series</label>
            <input type="search" class="form-control" placeholder="Series" wire:model="series" list="series">
            <datalist id="series">
              @foreach ($filter_series as $filter)
              <option value="{{ $filter->name }}">
                @endforeach
            </datalist>
          </div>

          <div class="col-sm">
            <label for="input">Size/Pattern</label>
            <input type="search" class="form-control" placeholder="Size" wire:model="size" list="sizes">
            <datalist id="sizes">
              @foreach ($filter_size as $filter)
              <option value="{{ $filter->name }}">
                @endforeach
            </datalist>
          </div>

          <div class="col-sm">
            <label for="input">Color</label>
            <input type="search" class="form-control" placeholder="Color" wire:model="color" list="colors">
            <datalist id="colors">
              @foreach ($filter_color as $filter)
              <option value="{{ $filter->name }}">
                @endforeach
            </datalist>
          </div>

          <div class="col-sm">
            <label for="input">Finish</label>
            <input type="search" class="form-control" placeholder="Finish" wire:model="finish" list="finishes">
            <datalist id="finishes">
              @foreach ($filter_finish as $filter)
              <option value="{{ $filter->name }}">
                @endforeach
            </datalist>
          </div>

          <div class="col-sm-1">
            <label for="input">Min. Qty</label>
            <input type="search" class="form-control" placeholder="Qty" wire:model="qty">
          </div>

          <div class="col-sm-1">
            <label for="input">&nbsp;</label>
            <button type="button" class="btn btn-outline-warning" style="position: relative;float: right; width: 100%;" wire:click="resetFilters()">Clear</button>
          </div>

        </div>
      </form>


      <div>

        <div wire:loading>
          <div class="text-center pt-6">
            <div class="spinner-border text-secondary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
            <div>
              <p style="font-size: 12px; color: #666;">loading...</p>
            </div>
          </div>
        </div>

        <div wire:loading.remove>

          <div class="card">
            <div class="card-body" style="padding: 10px 20px; min-height: 290px;">
              @if($products->isEmpty())

              @if($null == 1)
              <div class="d-flex justify-content-center" style="padding-top: 20px;">
                <img src="/assets/images/search.png" alt="Enter search criteria" style="padding-bottom: 30px; width: 300px;">
              </div>
              @else

              <div class="d-flex justify-content-center" style="padding-top: 20px;">
                <div>
                  <img src="/assets/images/search-page-no-data.svg" alt="No items found" style="padding-bottom: 30px;">
                  <h4>No items found</h4>
                  <p>Use the full category descriptions and try again</p>
                </div>
              </div>

              @endif

              @else

              <div>
                <!-- Table/Grid section -->
                <ul class="nav nav-pills" style="padding-bottom: 10px;" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="table-tab" data-bs-toggle="tab" data-bs-target="#table-tab-pane" type="button" role="tab" aria-controls="table-tab-pane" aria-selected="true">
                      <i class="bi bi-table" style="font-size: 20px;"></i></button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="grid-tab" data-bs-toggle="tab" data-bs-target="#grid-tab-pane" type="button" role="tab" aria-controls="grid-tab-pane" aria-selected="false">
                      <i class="bi bi-grid-fill" style="font-size: 20px;"></i></button>
                  </li>
                </ul>
              </div>
              <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade" id="table-tab-pane" role="tabpanel" aria-labelledby="table-tab" tabindex="0">

                  <table class="table table-striped table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">Item</th>
                        <th scope="col">Description</th>
                        <th scope="col">Series</th>
                        <th scope="col">Size</th>
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
                          <div>{{ $product->series }}</div>
                        </td>
                        <td>
                          <div>{{ $product->size }}</div>
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
                          <div>{{ $product->qty }}</div>
                        </td>
                        <td>
                          <div>{{ $product->uofm }}</div>
                        </td>

                      </tr>
                      @endforeach
                    </tbody>
                  </table>

                </div>

                <div class="tab-pane fade show active" id="grid-tab-pane" role="tabpanel" aria-labelledby="grid-tab" tabindex="0">

                  <div class="row" style="--bs-gutter-x: 0rem;">
                    @foreach ($products as $product)
                    <?php
                    //generate image path

                    $image = $product->img_url;
                    $material_desc = $product->material_desc;
                    $series = str_replace('Ã©', 'é', strtolower($product->series));
                    $series = str_replace('é', 'e', $series);

                    $size = $product->size_technical_name;

                    if (is_null($size) == true) {
                      $size = $product->size;
                    }

                    //if item image url is blank, use local image if exists, otherwise use series image
                    if ($product->img_url == '') {

                      // print_r($product);

                      $image = $product->material . '/' . $series;
                      $image = $image_path . $image;
                      $finish = $product->finish;
            
                      if ($finish == '') {
                        $finish = '-';
                      }

                      $filename = $image . '/' . $series . '_' . $size . '_' . $product->color . '_' . $finish . '.jpg';

                      $filename = str_replace('é', 'e', $filename);
                      $filename = str_replace(' ', '_', $filename);
                      $filename = str_replace('_-', '', $filename);
                      $full_filename = strtolower($server_root . $filename);

                      //  echo $full_filename;

                      $exists = false;
                      if (file_exists($full_filename)) {
                        $image = $filename;
                        $exists = true;
                        //echo 'file exists!';
                      } else {
                        $image = $image . '.png';
                        //echo 'not exists!';
                        if (file_exists($server_root . $image) == false) {
                          $image = $image_path."blank.png";
                        }                    
                      }
                    }

                    $image = $cdn_url. strtolower($image);                    

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

                    ?>

                    <div class="col-lg-2 img-container" Style="padding: 3px;
                      margin: 0px; border-radius: 4px;
                      ">
                      <div>
                        <div class="img-thumbnail">
                          <a href="/products/{{ $product->sku }}">
                            <img src="{{$image}}" style="
                         border: 0px; padding: 0px;" alt="{{ ucwords(strtolower($product->description)) }}">
                          </a>

                          <div class="w-100 ph1 pv2 tc f2">
                            <span class="db gray5 hover-blue7" style=" width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: inline-block;" title="{{ $product->description }}">
                              {{ ucwords(strtolower($product->description)) }}
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

              <?php

              if ($count >= 50) {
                echo '<p><b><i>50+ items</b></i></p>';
              } else {
                echo '<p><b><i>Items found: ' . $count . '</b></i></p>';
              }
              ?>
              @endif

            </div>
          </div>

        </div>
      </div>

    </div>

  </section>

</div>