<div>
    <input id="txtSearch" type="text" class="txtShowDiv" placeholder="Search Items" wire:model="search" style="border-radius: 0px; border: 1px solid #ccc; 
  float: right;">

<div id = "divSearch" class="searchDiv" style=" z-index: 1;
  position: absolute;
  padding: 0px;
  margin: -40px;
  margin-top: 40px;
  ">
  
  
    <div class="search"    
    wire:loading>searching...</div>
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
        @if($products->isEmpty())
        <div class="search text-gray-500 text-sm">
            No matching result found for '{{ $search }}'
        </div>
        @else
        <div class="search">
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
        </div>
        @endif
        @endif
    </div>
    </div>

</div>

