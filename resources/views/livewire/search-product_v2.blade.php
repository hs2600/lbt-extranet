<div>

  <section class="section dashboard">
    <div class="row">

      <form style="padding-bottom: 10px;">
        <div class="row">
          <div class="col-sm">
            <input type="search" class="form-control" placeholder="Material" wire:model="material">
          </div>
          <div class="col-sm">
            <input type="search" class="form-control" placeholder="Series" wire:model="series">
          </div>
          <div class="col-sm">
            <input type="search" class="form-control" placeholder="Size/Pattern" wire:model="size">
          </div>
          <div class="col-sm">
            <input type="search" class="form-control" placeholder="Color" wire:model="color">
          </div>
          <div class="col-sm">
            <input type="search" class="form-control" placeholder="Finish" wire:model="finish">
          </div>
          <div class="col-sm-1">
            <button type="button" class="btn btn-outline-warning" style="position: relative;float: right; width: 100%;" wire:click="resetFilters()">Clear</button>
          </div>
        </div>
      </form>


      <div>

        <div wire:loading>

          <div class="d-flex justify-content-center">
            <div class="spinner-grow" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>

        </div>
        <div wire:loading.remove>

          <div class="card">
            <div class="card-body" style="padding: 10px 20px;">
              @if($products->isEmpty())


              @if($null == 1)
              Enter search criteria
              @else


              <div class="d-flex justify-content-center" style="padding-top: 20px;">
                <div>
                  <img src="https://res.cdn.office.net/scc-resources/resources/ww/msec/wicd-ine/static/5aec0b54c606cd1930bc9481dcf184d7186f61a3_hash/search-page-no-data.svg" alt="No items found" style="padding-bottom: 30px;">

                  <h4>No items found</h4>
                  <p>Use the full category descriptions and try again</p>
                </div>
              </div>


              @endif

              @else

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
              <?php

              if ($count >= 50) {
                echo '<b><i>50+ items</b></i>';
              } else {
                echo '<b><i>Items found: ' . $count . '</b></i><br>';
              }
              ?>

            </div>
          </div>


          @endif


        </div>
      </div>

    </div>

  </section>

</div>