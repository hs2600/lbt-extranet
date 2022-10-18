<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Str;

class SearchProductv2 extends Component
{
    public $material = '';
    public $series = '';
    public $size = '';
    public $color = '';
    public $finish = '';
    
    public function render()
    {
        sleep(1);
        $null = 0;

        if (
            trim($this->material) == '' && trim($this->series) == '' && trim($this->size) == ''
            && trim($this->color) == '' && trim($this->finish) == ''
        ) {
            $null = 1;
        }

        $products = Product::orderBy('item', 'asc')
            ->Where('item','=',1)
            ->simplePaginate(50);

        $productsAll = Product::orderBy('item', 'asc')
            ->get();

        $productsFiltered = Product::where('material', 'like', $this->material.'%')
            ->Where('series', 'like', $this->series.'%')
            ->Where('size', 'like', '%'.$this->size.'%')
            ->Where('color', 'like', '%'.$this->color.'%')
            ->Where('finish', 'like', $this->finish.'%')
            ->simplePaginate(50);

        $productsFilteredAll = Product::where('material', 'like', $this->material.'%')
            ->Where('series', 'like', $this->series.'%')
            ->Where('size', 'like', '%'.$this->size.'%')
            ->Where('color', 'like', '%'.$this->color.'%')
            ->Where('finish', 'like', $this->finish.'%')
            ->get();

        if ($null == 0) {
            return view('livewire.search-product_v2')
                ->with(['products' => $productsFiltered])
                ->with('count', $productsFiltered->count())
                ->with('null', $null);
        } else {
            return view('livewire.search-product_v2')
                ->with(['products' => $products])
                ->with('count', 0)
                ->with('null', $null);
        }
    }

    public function resetFilters()
    {
        $this->material = '';
        $this->series = '';
        $this->size = '';
        $this->color = '';
        $this->finish = '';
    
    }
}
