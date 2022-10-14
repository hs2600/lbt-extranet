<div>



<form style="padding-bottom: 10px;">
    <div class="row">
      <div class="col">
        <input type="search" class="form-control" placeholder="Material" wire:model="material">
      </div>
      <div class="col">
        <input type="search" class="form-control" placeholder="Series" wire:model="series">
      </div>
      <div class="col">
        <input type="search" class="form-control" placeholder="Size" wire:model="size">
      </div>
      <div class="col">
        <input type="search" class="form-control" placeholder="Color" wire:model="color">
      </div>
      <div class="col">
        <input type="search" class="form-control" placeholder="Finish" wire:model="finish">
      </div>
      <div class="col-1">
      <a href="/products"><button type="button" class="btn btn-outline-warning">Clear</button></a>
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

      <div class="card" style="margin-bottom: 20px;">
        <div class="card-body">
          @if($products->isEmpty())

          No results
          @else

          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Item</th>
                <th scope="col" class="d-none d-md-block">Description</th>
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
                <td class="d-none d-md-block">
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

          if ($count > 50) {
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