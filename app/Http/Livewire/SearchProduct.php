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
        sleep(1);
        $products = Product::where('description','like', '%'.$this->search.'%')
                ->orWhere('item', 'like', '%'.$this->search.'%')
                ->paginate(50);

        $series = Collection::where('series','like', '%'.$this->search.'%')
        ->where('category', '=', 'series')
        ->limit(5)
        ->get();

        $productsAll = Product::where('description','like', '%'.$this->search.'%')
                ->orWhere('item', 'like', '%'.$this->search.'%')
                ->get();

        $items = Product::where('item','=', $this->search)
            ->leftjoin('collections as series', function ($join) {
            $join->on('products.material', '=', 'series.material')
              ->On('products.series', '=', 'series.series')
              ->where('series.category', '=', 'series');
            })
            ->selectRaw('products.*, series.size_desc')
            ->limit(1)
            ->get();

        if($this->search == ''){
            return view('livewire.search-product',['products' => $this->search]);
        } else {
            return view('livewire.search-product')
            ->with(['products' => $products])
            ->with(['items' => $items])
            ->with('search', $this->search)
            ->with(['series' => $series])
            ->with('count', $productsAll->count())
            ;
    }}
}
