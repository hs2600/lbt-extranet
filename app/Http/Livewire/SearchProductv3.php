<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SearchProductv3 extends Component
{
    public $material = '';
    public $series = '';
    public $size = '';
    public $color = '';
    public $finish = '';
    public $qty = '';
    
    public function render()
    {
        // sleep(1);
        $null = 0;

        if (
            trim($this->material) == '' && trim($this->series) == '' && trim($this->size) == ''
            && trim($this->color) == '' && trim($this->finish) == '' && trim($this->qty) == ''
        ) {
            $null = 1;
        }

        $products = Product::orderBy('item', 'asc')
            ->Where('item','=',1)
            ->simplePaginate(50);

        $productsAll = Product::orderBy('item', 'asc')
            ->get();

        $productsFiltered = Product::where('material', 'like', $this->material.'%')
            ->Where('series', 'like', '%'.$this->series.'%')
            ->Where('size', 'like', '%'.$this->size.'%')
            ->Where('color', 'like', '%'.$this->color.'%')
            ->Where('finish', 'like', $this->finish.'%')
            ->Where('qty', '>', $this->qty)
            ->simplePaginate(50);

        $productsFilteredAll = Product::where('material', 'like', $this->material.'%')
            ->Where('series', 'like', $this->series.'%')
            ->Where('size', 'like', '%'.$this->size.'%')
            ->Where('color', 'like', '%'.$this->color.'%')
            ->Where('finish', 'like', $this->finish.'%')
            ->get();

        $materials = DB::table('collections')
        ->selectRaw('count(*) as count, material as name')
        ->where('category', '=', 'material')
        ->groupBy('material')
        ->orderBy('name', 'asc')
        ->limit(5)
        ->get();
        
        $series = DB::table('products')
        ->leftjoin('collections as series', function ($join) {
            $join->on('products.material', '=', 'series.material')
                ->On('products.series', '=', 'series.series')
                ->where('series.category', '=', 'series')
                ->where('series.status', '!=', 1);
        })
        ->selectRaw('count(*) as count, products.series as name, series.status as status')
        ->Where('products.material', 'like', $this->material.'%')
        ->Where('products.series', 'like', '%'.$this->series.'%')
        ->Where('products.size', 'like', '%'.$this->size.'%')
        ->Where('products.color', 'like', '%'.$this->color.'%')
        ->Where('products.finish', 'like', $this->finish.'%')
        ->groupBy('products.series')
        ->groupBy('series.status')
        ->orderBy('series.status', 'desc')
        ->orderBy('name', 'asc')        
        ->limit(15)
        ->get();

        $size = DB::table('products')
        ->selectRaw('count(*) as count, size as name')
        ->Where('material', 'like', $this->material.'%')
        ->Where('series', 'like', '%'.$this->series.'%')
        ->Where('size', 'like', '%'.$this->size.'%')
        ->Where('color', 'like', '%'.$this->color.'%')
        ->Where('finish', 'like', $this->finish.'%')        
        ->groupBy('size')
        ->orderBy('name', 'asc')
        ->limit(15)
        ->get();

        $color = DB::table('products')
        ->selectRaw('count(*) as count, color as name')
        ->Where('material', 'like', $this->material.'%')
        ->Where('series', 'like', '%'.$this->series.'%')
        ->Where('size', 'like', '%'.$this->size.'%')
        ->Where('color', 'like', '%'.$this->color.'%')
        ->Where('finish', 'like', $this->finish.'%')
        ->groupBy('color')
        ->orderBy('name', 'asc')
        ->limit(15)
        ->get();

        $finish = DB::table('products')
        ->selectRaw('count(*) as count, finish as name')
        ->Where('finish', '!=', '-')
        ->Where('material', 'like', $this->material.'%')        
        ->Where('series', 'like', '%'.$this->series.'%')
        ->Where('size', 'like', '%'.$this->size.'%')        
        ->Where('color', 'like', '%'.$this->color.'%')
        ->groupBy('finish')
        ->orderBy('name', 'asc')
        ->limit(15)
        ->get();

        if ($null == 0) { //return results
            return view('livewire.search-product_v3')
                ->with(['products' => $productsFiltered])
                ->with('count', $productsFiltered->count())
                ->with(['filter_materials' => $materials])
                ->with(['filter_series' => $series])
                ->with(['filter_size' => $size])
                ->with(['filter_color' => $color])
                ->with(['filter_finish' => $finish])
                ->with('null', $null);
        } else { //return nothing
            return view('livewire.search-product_v3')
                ->with(['products' => $products])
                ->with('count', 0)
                ->with(['filter_materials' => $materials])
                ->with(['filter_series' => $series])
                ->with(['filter_size' => $size])
                ->with(['filter_color' => $color])
                ->with(['filter_finish' => $finish])
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
        $this->qty = '';
    
    }
}
