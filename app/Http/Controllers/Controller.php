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

        $initialMarkers = [
            [
                'position' => [
                    'lat' => 28.625485,
                    'lng' => 79.821091
                ],
                'label' => [ 'color' => 'white', 'text' => 'P1' ],
                'draggable' => true
            ],
            [
                'position' => [
                    'lat' => 28.625293,
                    'lng' => 79.817926
                ],
                'label' => [ 'color' => 'white', 'text' => 'P2' ],
                'draggable' => false
            ],
            [
                'position' => [
                    'lat' => 28.625182,
                    'lng' => 79.81464
                ],
                'label' => [ 'color' => 'white', 'text' => 'P3' ],
                'draggable' => true
            ]
        ];

        return view('dealer_locator_js')
        ->with('initialMarkers', $initialMarkers);
    }    

}
