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

        return view('find-dealer.dealer_locator_zip')
        ->with('showrooms', $showrooms)
        ->with('zip', $zip);
    }

    /**
    * Dealer locator JS
    */
    public function dealerLocatorJS()
    {

        $zip = '';
        if(isset($_GET['location'])){
            $zip = $_GET['location'];
        }
        $error = '';

        $latlon = DB::table('zip_lat_lon')
            ->where('zip', '=', $zip)
            ->first();

        if (is_null($latlon) || strlen($zip) < 5) {
            $error = 'invalid';
            $showrooms = array();
        } else {
            $error = '';
            $zip =  substr($latlon->zip, 0, 5);
            $lat =  $latlon->lat;
            $lon =  $latlon->lon;

            $field_list = 'ship_to_name, address1, address2, city, state, zip, lat, (6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians(' . $lon . ') - radians(lon) ) + sin( radians(' . $lat . ') ) * sin( radians(lat) ) )) as distance';

            $showrooms = DB::table('addresses')
                ->selectRaw($field_list)
                ->orderBy('distance')
                ->limit(5)
                ->get();
        }

        return view('find-dealer.dealer_locator')
        ->with('showrooms', $showrooms)
        ->with('zip', $zip)
        ->with('error', $error);

    }

}
