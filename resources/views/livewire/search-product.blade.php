<div>
  <!-- <input id="txtSearch" type="search" 
  class="form-control txtShowDiv" 
  placeholder="Search" wire:model="search" style="width: 300px;"> -->


  <div class="search-bar">
    <form class="search-form d-flex align-items-center">
      <input id="txtSearch" type="search" placeholder="Search" title="Enter search keyword" wire:model="search" class="txtShowDiv" style="padding: 7px 10px;" autocomplete="off">
    </form>


    <div id="divSearch" class="searchDiv" style="z-index: 1;
    position: absolute;
    min-width: 360px;
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
          <div class="text-gray-500 text-sm"
           style="max-width: 315px;">
            <p>No matching results found for '{{ $search }}'</p>
            <p><b><i>Search tips:</i></b> search by series, item number, or item description</p>
            <img src="/assets/images/search.png" alt="Enter search criteria" style="padding-bottom: 30px; width: 200px;">
          </div>

          @else
          <!-- <div id="search-inner" class="search"> -->
          <i>Products:</i>
          <ul style="padding: 0px;">
            @foreach($products as $product)

            <?php
            $qty = $product->qty_p;
            $uofm = strtolower(str_replace('each', 'piece', strtolower($product->uofm)));
  
            if ($uofm == 'piece') {
              $uofm = $uofm . 's';
            }

            $qty_str = $qty . ' ' . $uofm;
            $span_color = '#000';
            if($qty == 0){
              $span_color = '#FF0000';
              $qty_str = 'out of stock';
            }

            ?>

            <li><a href="/products/{{ $product->sku }}">{{ $product->description }}</a>
              - (<span style="color: {{ $span_color }};">{{ $qty_str }}<span>)
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

        <div style="max-width: 500px;">
          @foreach($items as $item)

          <?php
          $qty = $item->qty_p;
          $uofm = strtolower(str_replace('each', 'piece', strtolower($item->uofm)));

          if ($uofm == 'piece') {
            $uofm = $uofm . 's';
          }
          ?>

          <a href="/products/{{ $item->sku }}">{{ $item->item }}</a>

          <span class="product-title" style="font-size: 30px;">{{ ucwords(strtolower($item->description)) }}</span>
          <hr style="margin-top: 10px; border: 0.5px solid #999;">

          <div class="row" style="padding: 10px; margin: 0px; margin-bottom: 15px;
           background-color: #efefef;
           --bs-gutter-x: 0px;           
           ">
            <div class="col-sm-6">
              <label><b>Material:</b></label>
              <span>{{ $item->material }}</span>
            </div>
            <div class="col-sm-6">
              <label><b>Series:</b></label>
              <span>{{ str_replace('Ã©', 'é', $item->series) }}</span>
            </div>
            <div class="col-sm-6">
              <label><b>Size:</b></label>
              <span>{{ $item->size }}</span>
            </div>
            <div class="col-sm-6">
              <label><b>Color:</b></label>
              <span>{{ $item->color }}</span>
            </div>
            <div class="col-sm-6">
              <label><b>Finish:</b></label>
              <span>{{ $item->finish }}</span>
            </div>
          </div>
          <p class="product-description" style="font-size: 17px;">{{ $item->size_desc }}</p>

          <div style="background-color: #fafafa; padding: 5px; margin-bottom: 20px;
            border-bottom: 1px solid #ddd;">
            <div class="">
              @if ($qty > 0)
              <span class="product-price"><b><i>{{ $qty }} {{ $uofm }} </b> stocked in Harbor City</i></span>
              @else
              <span class="product-price" style="color: #d35d5d;"><b><i>Item is currently out of stock.</b></i></span>
              @endif
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