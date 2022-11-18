<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Collection;
use Livewire\Component;
use Illuminate\Support\Str;

class SearchProduct extends Component
{
    public $search = '';

    public function render()
    {
        // sleep(1);

        if ($this->search == '') {
            return view('livewire.search-product')
            ->with('search', $this->search);
        } else {

            $products = Product::where('series.status', '!=', 1)
            ->leftjoin('collections as series', function ($join) {
                $join->on('products.material', '=', 'series.material')
                    ->On('products.series', '=', 'series.series')
                    ->where('series.category', '=', 'series')
                    ->where('series.status', '!=', 1);
            })
            ->select(
                'products.sku',
                'products.item',
                'products.description',
                'products.qty_p as qty',
                'products.uofm'
            )
            ->where(function ($query) {
                $query
                    ->where('products.description', 'like', '%' . $this->search . '%')
                    ->orWhere('products.item', 'like', '%' . $this->search . '%');
            })
            ->paginate(50);

        $series = Collection::where('series', 'like', '%' . $this->search . '%')
            ->where('category', '=', 'series')
            ->where('status', '!=', 1)
            ->limit(5)
            ->get();

        $items = Product::where('item', '=', $this->search)
            ->where('status', '=', 0)
            ->limit(1)
            ->get();

            return view('livewire.search-product')
                ->with(['products' => $products])
                ->with(['items' => $items])
                ->with('search', $this->search)
                ->with(['series' => $series]);
        }
    }
}
