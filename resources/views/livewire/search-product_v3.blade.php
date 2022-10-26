<div>

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
              @endif

            </div>
          </div>

        </div>
      </div>

    </div>

  </section>

</div>