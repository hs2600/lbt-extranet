<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Address;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * Dealer locator
     */
    public function dealerLocator($zip)
    {
        error_log("INFO: get /");
        return view('dealer_locator', [
            'showrooms' => Address::orderBy('zip', 'asc')
                ->where('zip', '=', $zip)
                ->limit(1)
                ->get()
        ]);
    }

    /**
     * Dealer locator JS
     */
    public function dealerLocatorJS($zip)
    {
        error_log("INFO: get /");

        $zip4 = substr($zip,0,4);

        $showrooms = Address::orderBy('zip', 'asc')
        ->where('zip', 'like', $zip4.'%')
        ->limit(5)
        ->get();

        return view('dealer_locator_js')
        ->with('showrooms', $showrooms)
        ->with('zip', $zip);
    }    

}
