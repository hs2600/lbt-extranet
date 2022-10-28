<div>
  <!-- <input id="txtSearch" type="search" 
  class="form-control txtShowDiv" 
  placeholder="Search" wire:model="search" style="width: 300px;"> -->


  <div class="search-bar">
    <form class="search-form d-flex align-items-center">
      <input id="txtSearch" type="search" placeholder="Search" title="Enter search keyword" wire:model="search" class="txtShowDiv" style="padding: 7px 10px;">
    </form>


    <div id="divSearch" class="searchDiv" style="z-index: 1;
    position: absolute;
    min-width: 380px;
    ">

      <div class="search" wire:loading style="position: absolute;
      min-width: 360px;">

        <div class="d-flex justify-content-center">
          <div class="spinner-grow" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>

      </div>
      <div wire:loading.remove style="position: relative;
        top: 0px;">
        <!-- 
            notice that $term is available as a public 
            variable, even though it's not part of the 
            data array 
        -->
        @if ($search == "")
        <div class="text-gray-500 text-sm">
        </div>
        @else

        <div id="search-inner" class="search">

          @if (count($series) > 0)
          <i>Collections:</i>
          <ul style="padding: 0px;">
            @foreach($series as $series)
            <li><a href="/collections/{{ $series->material }}/{{ $series->series }}">{{ $series->series }}</a>
            </li>
            @endforeach
          </ul>

          <hr>
          @endif

          @if($items->isEmpty())

          @if($products->isEmpty())
          <div style="padding: 20px;">
            No matching results found for '{{ $search }}'
          </div>
          @else
          <!-- <div id="search-inner" class="search"> -->
          <i>Products:</i>
          <ul style="padding: 0px;">
            @foreach($products as $product)

            <?php
            $qty = number_format($product->qty, 2);
            $uofm = strtolower(str_replace('each', 'piece', strtolower($product->uofm)));

            if (str_replace('each', 'piece', strtolower($product->uofm)) == 'piece') {
              $qty = number_format($product->qty, 0);
              $uofm = $uofm . 's';
            }
            ?>

            <li><a href="/products/{{ $product->sku }}">{{ $product->description }}</a>
              - ({{ $qty }} {{ $uofm }})
            </li>
            @endforeach
          </ul>
          <?php
          if ($count > 50) {
            echo '<b><i>50+ results </b></i>';
          } else {
            echo '<b><i>Items found: ' . $count . '</b></i>';
          }
          ?>
        </div>
        @endif

        @else

        <div class="search">
          @foreach($items as $item)

          <?php
          $qty = number_format($item->qty, 2);
          $uofm = strtolower(str_replace('each', 'piece', strtolower($item->uofm)));

          if (str_replace('each', 'piece', strtolower($item->uofm)) == 'piece') {
            $qty = number_format($item->qty, 0);
            $uofm = $uofm . 's';
          }
          ?>

          <a href="/products/{{ $item->sku }}">{{ $item->item }}</a>

          <span class="product-title" style="font-size: 30px;">{{ ucwords(strtolower($item->description)) }}</span>
          <hr style="margin-top: 10px; border: 0.5px solid #999;">

          <div class="row" style="padding: 10px; margin: 0px; margin-bottom: 15px; background-color: #efefef;">
            <div class="col-sm-6">
              <label class="">Material:</label>
              <span>{{ $item->material }}</span>
            </div>
            <div class="col-sm-6">
              <label class="">Series:</label>
              <span>{{ str_replace('Ã©', 'é', $item->series) }}</span>
            </div>
            <div class="col-sm-6">
              <label class="">Size:</label>
              <span>{{ $item->size }}</span>
            </div>
            <div class="col-sm-6">
              <label class="">Color:</label>
              <span>{{ $item->color }}</span>
            </div>
            <div class="col-sm-6">
              <label class="">Finish:</label>
              <span>{{ $item->finish }}</span>
            </div>
          </div>
          <p class="product-description">{{ $item->series_desc }}</p>

          <div style="background-color: #fafafa; padding: 5px; margin-bottom: 20px;
              border-bottom: 1px solid #ddd;">
            <div class="">
              <span class="product-price"><b><i>{{ $qty }} {{ $uofm }} </b> in stock in Harbor City</i></span>
            </div>
          </div>

          @endforeach
          </ul>
        </div>

        @endif

        @endif

      </div>
    </div>
  </div>
</div>