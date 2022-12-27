<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Address;
use Illuminate\Http\Request;
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
        $JA_checked = '';
        $TB_checked = '';

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

            $field_list = 'customer_name, address1, address2, city, state, zip, phone1, website, appointment, locator_priority, ifnull(' . $distance_calc . ',1) as distance, ifnull(' . $distance_calc . ',10) * locator_priority as distance_priority, authorized';

            $showrooms = DB::table('addresses')
                ->selectRaw($field_list)
                ->Where('authorized', 'like', '%'.$JA.'%')
                ->Where('authorized', 'like', '%'.$TB.'%')
                ->orderBy('distance_priority')
                ->limit(5)
                ->get();
        }

        if($JA == 'JA'){
            $JA_checked = 'checked';
        }

        if($TB == 'TB'){
            $TB_checked = 'checked';
        }

        return view('find-dealer.dealer_locator')
        ->with('showrooms', $showrooms)
        ->with('zip', $zip)
        ->with('JA_checked', $JA_checked)
        ->with('TB_checked', $TB_checked)
        ->with('error', $error);

    }

    /**
    * Dealer locator for LBT website (iframe)
    */
    public function dealerLocatorLBT()
    {

        $error = '';
        $zip = '';
        $JA = '';
        $TB = '';
        $JA_checked = '';
        $TB_checked = '';

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

            $field_list = 'customer_name, address1, address2, city, state, zip, phone1, website, appointment, locator_priority, ifnull(' . $distance_calc . ',1) as distance, ifnull(' . $distance_calc . ',10) * locator_priority as distance_priority, authorized';

            $showrooms = DB::table('addresses')
                ->selectRaw($field_list)
                ->Where('authorized', 'like', '%'.$JA.'%')
                ->Where('authorized', 'like', '%'.$TB.'%')
                ->orderBy('distance_priority')
                ->limit(5)
                ->get();
        }

        if($zip == ''){
            $error = 'blank';
        }

        if($JA == 'JA'){
            $JA_checked = 'checked';
        }

        if($TB == 'TB'){
            $TB_checked = 'checked';
        }

        return view('find-dealer.dealer-locator-lbt')
        ->with('showrooms', $showrooms)
        ->with('zip', $zip)
        ->with('JA_checked', $JA_checked)
        ->with('TB_checked', $TB_checked)
        ->with('error', $error);

    }    

    /**
    * Dealer locator API
    */
    public function dealerLocatorAPI_ZIP($zip)
    {

        $JA = '';
        $TB = '';

        $latlon = DB::table('zip_lat_lon')
            ->where('zip', '=', $zip)
            ->first();

        if (is_null($latlon) || strlen($zip) < 5) {
            $showrooms = array();
        } else {
            $zip =  substr($latlon->zip, 0, 5);
            $lat =  $latlon->lat;
            $lon =  $latlon->lon;

            $distance_calc = '(6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians(' . $lon . ') - radians(lon) ) + sin( radians(' . $lat . ') ) * sin( radians(lat) ) ))';
            $JA_col = "case when authorized like '%JA%' then 'true' else 'false' end";
            $TB_col = "case when authorized like '%TB%' then 'true' else 'false' end";

            $field_list = 'customer_name, address1, address2, city, state, zip, phone1, website, appointment, locator_priority, ifnull(' . $distance_calc . ',1) as distance, ifnull(' . $distance_calc . ',10) * locator_priority as distance_priority, ' . $JA_col . ' as authorized_ja, ' . $TB_col . ' as authorized_tb';

            $showrooms = DB::table('addresses')
                ->selectRaw($field_list)
                ->Where('authorized', 'like', '%'.$JA.'%')
                ->Where('authorized', 'like', '%'.$TB.'%')
                ->orderBy('distance_priority')
                ->limit(5)
                ->get();
        }

        return $showrooms;

    }

    public function dealerLocatorAPI(Request $request)
    {

        $zip = $request->zip;
        $auth_ja = $request->auth_ja;
        $auth_tb = $request->auth_tb;

        $latlon = DB::table('zip_lat_lon')
            ->where('zip', '=', $zip)
            ->first();

        if (is_null($latlon) || strlen($zip) < 5) {
            $showrooms = array();
        } else {
            $zip =  substr($latlon->zip, 0, 5);
            $lat =  $latlon->lat;
            $lon =  $latlon->lon;

            $distance_calc = '(6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians(' . $lon . ') - radians(lon) ) + sin( radians(' . $lat . ') ) * sin( radians(lat) ) ))';
            $JA_col = "case when authorized like '%JA%' then 1 else 0 end";
            $TB_col = "case when authorized like '%TB%' then 1 else 0 end";

            $field_list = 'customer_name, address1, address2, city, state, zip, phone1, website, appointment, locator_priority, ifnull(' . $distance_calc . ',1) as distance, ifnull(' . $distance_calc . ',10) * locator_priority as distance_priority, ' . $JA_col . ' as authorized_ja, ' . $TB_col . ' as authorized_tb';

            $showrooms = DB::table('addresses')
                ->selectRaw($field_list)
                ->Where('authorized', 'like', '%'.$auth_ja.'%')
                ->Where('authorized', 'like', '%'.$auth_tb.'%')
                ->orderBy('distance_priority')
                ->limit(5)
                ->get();
        }

        if(!$showrooms){
            return response()->json([
                'message' => 'incorrect zip code',
                'status' => true
            ],202);
        } else {
            return $showrooms;
        }


    }    


}
