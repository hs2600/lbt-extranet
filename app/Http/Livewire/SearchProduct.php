<?php

namespace App\Http\Livewire;

use App\Models\Product;
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
        $productsAll = Product::where('description','like', '%'.$this->search.'%')
                ->orWhere('item', 'like', '%'.$this->search.'%')
                ->get();
        $items = Product::where('item','=', $this->search)->get();

        if($this->search == ''){
            return view('livewire.search-product',['products' => $this->search]);
        } else {
            return view('livewire.search-product')
            ->with(['products' => $products])
            ->with(['items' => $items])
            ->with('search', $this->search)
            ->with('count', $productsAll->count())
            ;
    }}
}
