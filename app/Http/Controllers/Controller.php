<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Address;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * Dealer locator
     */
    public function dealerLocator($zip)
    {
        error_log("INFO: get /");

        $field_list = 'min(abs('. $zip. '-zip)) as diff, customer, ship_to_name, address1, address2, city, state, zip, phone1';

        $showrooms = DB::table('addresses')
        ->selectRaw($field_list)
        ->groupBy('customer')
        ->groupBy('ship_to_name')
        ->groupBy('address1')
        ->groupBy('address2')        
        ->groupBy('city')
        ->groupBy('state')
        ->groupBy('zip')
        ->groupBy('phone1') 
        ->orderBy('diff')
        ->limit(1)
        ->get();

        return view('dealer_locator')
        ->with('showrooms', $showrooms)
        ->with('zip', $zip);
    }

    /**
     * Dealer locator JS
     */
    public function dealerLocatorJS($zip)
    {
        error_log("INFO: get /");

        $field_list = 'min(abs('. $zip. '-zip)) as diff, customer, ship_to_name, address1, address2, city, state, zip';

        $showrooms = DB::table('addresses')
        ->selectRaw($field_list)
        ->groupBy('customer')
        ->groupBy('ship_to_name')
        ->groupBy('address1')
        ->groupBy('address2')        
        ->groupBy('city')
        ->groupBy('state')
        ->groupBy('zip')
        ->orderBy('diff')
        ->limit(5)
        ->get();

        return view('dealer_locator_js')
        ->with('showrooms', $showrooms)
        ->with('zip', $zip);
    }    

}
