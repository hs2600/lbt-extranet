<div>
  <input id="txtSearch" type="search" class="form-control txtShowDiv" placeholder="Search" wire:model="search">

  <div id="divSearch" class="searchDiv" style=" z-index: 1;
  position: absolute;
  padding: 0px;
  margin: -200px;
  margin-top: 15px;
  ">


    <div class="search" wire:loading>

      <div class="d-flex justify-content-center">
        <div class="spinner-grow" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>

    </div>
    <div wire:loading.remove>
      <!-- 
            notice that $term is available as a public 
            variable, even though it's not part of the 
            data array 
        -->
      @if ($search == "")
      <div class="text-gray-500 text-sm">
      </div>
      @else

      @if($items->isEmpty())

      @if($products->isEmpty())
      <div class="search text-gray-500 text-sm">
        No matching result found for '{{ $search }}'
      </div>
      @else
      <div id="search-inner" class="search">
        <ul>
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
          echo '<b><i>Showing 50 of ' . $count . ' results.</b></i>';
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