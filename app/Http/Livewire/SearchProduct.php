<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class SearchProduct extends Component
{
    public $search = '';

    public function render()
    {
        sleep(1);
        if($this->search == ''){
            return view('livewire.search-product',['products' => $this->search]);
        } else {
        return view('livewire.search-product', [
            'products' => Product::where('description','like', '%'.$this->search.'%')
            ->paginate(50),
            ])
            ->with('search', $this->search)
            ;
    }}
}
