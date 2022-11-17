<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class Price extends Component
{

    public $price = 0;
    public $customer = '';
    public $sku;

    public function render()
    {
        $cust = session()->get('cust');

        if ($this->customer != "") {
            $cust = $this->customer;
        }

        $customer = Customer::where('customer', $cust)->first();

        $customer_list = Customer::orderby('custname')
            ->where('customer', '!=', $cust)
            ->select('customer', 'custname')
            ->get();

        $price_level = '57';

        if (is_null($customer) == false) {
            session(['cust' => $customer->customer]);
            session(['custname' => $customer->custname]);
            if (is_null($customer->pricelevel) == false) {
                $price_level = $customer->pricelevel;
            }
        }

        $product = Product::where('sku', '=', $this->sku)
            ->selectraw('sku, uofm, pl_' . $price_level . ' as price')
            ->first();

        $this->price = $product->price;

        return view('livewire.price')
            ->with(['customers' => $customer_list])
            ->with(['product' => $product]);
    }
}
