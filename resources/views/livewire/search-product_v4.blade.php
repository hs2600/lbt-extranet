<div>

  <style>
    .sticky-header {
      position: sticky;
      top: 60px;
      background-color: #fff;
      box-shadow: 0px 2px 0px rgb(1 41 112 / 10%);
    }
  </style>

  <section class="section dashboard">
    <div class="row">

      <form style="padding-bottom: 10px;">
        <div class="row">

          <div class="col-sm">
            <label for="input">Material</label>
            <select id="sites" class="form-control" wire:model.debounce.500ms="material">
              <option value="">All</option>
              <option value="Ceramic">Ceramic</option>
              <option value="Concrete">Concrete</option>
              <option value="Glass">Glass</option>
            </select>
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
            <label for="input">Size</label>
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

          <div class="col-sm">
            <label for="input">Site</label>
            <select class="form-control" wire:model.lazy="site">
              <option value="">All</option>
              <option value="HC">HC</option>
              <option value="PA">PA</option>
            </select>
          </div>

          <div class="col-sm-1">
            <label for="input">Min. Qty</label>
            <input type="search" class="form-control" placeholder="Qty" wire:model.lazy="qty">
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
                <thead class="sticky-header">
                  <tr>
                    <th scope="col">Item</th>
                    <th scope="col">Site</th>
                    <th scope="col">Lot</th>
                    <th scope="col">SQFT</th>
                    <th scope="col">Boxes</th>
                    <th scope="col">Pieces</th>
                    <th scope="col">Sheets</th>
                    <th scope="col">UofM</th>
                    <th scope="col">Promise Date</th>
                    <th scope="col">Promise Qty</th>
                    <th scope="col">Series</th>
                    <th scope="col">Size</th>
                    <th scope="col">Color</th>
                    <th scope="col">Finish</th>
                    <th scope="col">Dimms</th>
                  </tr>
                </thead>
                <tbody>

                  @foreach ($products as $product)
                  <tr>
                    <td scope="row">
                      <div>
                        <a href="/products/{{ $product->sku }}" target="blank">
                          <i class="fa-solid fa-arrow-up-right-from-square" style="color: #228be6;"></i>
                        </a> &nbsp;
                        <?php
                        $series = str_replace('Ã©', 'é', $product->series);
                        echo '<a href="/products/' . $product->sku . '">' . $product->item . '</a>';
                        ?>
                      </div>
                    </td>
                    <td>
                      <div>{{ $product->site }}</div>
                    </td>
                    <td>
                      <div>{{ $product->lot }}</div>
                    </td>
                    <td>
                      <div>{{ number_format($product->sqft) }}</div>
                    </td>
                    <td>
                      <div>{{ number_format($product->boxes) }}</div>
                    </td>
                    <td>
                      <div>{{ number_format($product->pieces) }}</div>
                    </td>
                    <td>
                      <div>{{ number_format($product->sheets) }}</div>
                    </td>
                    <td>
                      <div>{{ strtolower($product->uom) }}</div>
                    </td>
                    <td>
                      <div>
                        <?php
                        if ($product->promise_date != '1900-01-01') {
                          echo  date('m-d-y', strtotime($product->promise_date));
                        } else {
                          echo '-';
                        }
                        ?>
                      </div>
                    </td>
                    <td>
                      <div>{{ number_format($product->promise_qty) }}</div>
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
                      <div>{{ $product->dimms }}</div>
                    </td>

                  </tr>
                  @endforeach
                </tbody>
              </table>

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