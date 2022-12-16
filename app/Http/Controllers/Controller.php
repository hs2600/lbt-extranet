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

            $distance_calc = '(6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians(' . $lon . ') - radians(lon) ) + sin( radians(' . $lat . ') ) * sin( radians(lat) ) ))';

            $field_list = 'customer_name, address1, address2, city, state, zip, phone1, locator_priority, ifnull(' . $distance_calc . ',1) as distance, ifnull(' . $distance_calc . ',10) * locator_priority as distance_priority';

            $showrooms = DB::table('addresses')
                ->selectRaw($field_list)
                ->orderBy('distance_priority')
                ->limit(1)
                ->get();
        }

        return view('find-dealer.dealer_locator_zip')
        ->with('showrooms', $showrooms)
        ->with('zip', $zip)
        ->with('error', $error);
    }

    /**
    * Dealer locator JS
    */
    public function dealerLocatorJS()
    {

        $error = '';
        $zip = '';
        $JA = '';
        $TB = '';

        if(isset($_GET['location'])){
            $zip = $_GET['location'];
        }

        if(isset($_GET['JA'])){
            $JA = 'JA';
        }
        
        if(isset($_GET['TB'])){
            $TB = 'TB';
        }

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

            $distance_calc = '(6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians(' . $lon . ') - radians(lon) ) + sin( radians(' . $lat . ') ) * sin( radians(lat) ) ))';

            $field_list = 'customer_name, address1, address2, city, state, zip, locator_priority, ifnull(' . $distance_calc . ',1) as distance, ifnull(' . $distance_calc . ',10) * locator_priority as distance_priority, authorized';

            $showrooms = DB::table('addresses')
                ->selectRaw($field_list)
                ->Where('authorized', 'like', '%'.$JA.'%')
                ->Where('authorized', 'like', '%'.$TB.'%')
                ->orderBy('distance_priority')
                ->limit(5)
                ->get();
        }

        if($JA == 'JA'){
            $JA = 'checked';
        }

        if($TB == 'TB'){
            $TB = 'checked';
        }

        return view('find-dealer.dealer_locator')
        ->with('showrooms', $showrooms)
        ->with('zip', $zip)
        ->with('JA', $JA)
        ->with('TB', $TB)
        ->with('error', $error);

    }

}
