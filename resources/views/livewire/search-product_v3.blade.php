<div>

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
                    <button class="nav-link active" id="table-tab" data-bs-toggle="tab" data-bs-target="#table-tab-pane" type="button" role="tab" aria-controls="table-tab-pane" aria-selected="true">
                      <i class="fa-solid fa-list" style="font-size: 20px; color: #000;"></i></button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="grid-tab" data-bs-toggle="tab" data-bs-target="#grid-tab-pane" type="button" role="tab" aria-controls="grid-tab-pane" aria-selected="false"><i class="fa-solid fa-border-all" style="font-size: 20px; color: #000;"></i></button>
                  </li>
                </ul>
              </div>
              <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="table-tab-pane" role="tabpanel" aria-labelledby="table-tab" tabindex="0">

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

                <div class="tab-pane fade" id="grid-tab-pane" role="tabpanel" aria-labelledby="grid-tab" tabindex="0">

                  <div class="row" style="--bs-gutter-x: 0rem;">
                    @foreach ($products as $product)
                    <?php
                    //generate image path

                    $image = $product->img_url;
                    $material_desc = $product->material_desc;
                    $series = str_replace('Ã©', 'é', $product->series);
                    $series = str_replace('1/2', '0.5', $series);
                    $series = str_replace('1/4', '0.25', $series);

                    //$series = $product->series;
                    //print_r($_SERVER);

                    //if item image url is blank, use local image if exists, otherwise use series image
                    if ($product->img_url == '') {

                      // print_r($product);

                      $image = $product->material . '/' . $series;
                      $image = '/assets/images/products/' . $image;
                      $finish = $product->finish;

                      if ($finish == '') {
                        $finish = '-';
                      }

                      $filename = $image . '/' . $series . '_' . $product->size . '_' . $product->color . '_' . $finish . '.jpg';
                      // echo $filename;
                      $filename = strtolower(str_replace(' ', '_', $filename));
                      $filename = str_replace('_-', '', $filename);
                      $filename = str_replace('hexagon', 'hex', $filename);
                      $filename = str_replace('japonaise', 'japon', $filename);
                      $full_filename = $_SERVER["DOCUMENT_ROOT"] . $filename;

                      // echo $full_filename;

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


                    $image = str_replace('é', 'e', $image);

                    ?>

                    <div class="col-lg-2 img-container" Style="padding: 5px;
                        ">
                      <a href="/products/{{ $product->sku }}">
                        <img class="img-thumbnail" src="{{$image}}" style="
                          border-radius: 5px;" alt="{{ ucwords(strtolower($product->description)) }}">
                      </a>
                      {{ $product->description }}
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