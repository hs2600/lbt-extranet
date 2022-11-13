<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class DealerLocator extends Component
{

    public $zip;
    public $lat;
    public $lon;
    public $showrooms = array();
    public $latlon;
    public $error;

    protected $rules = [
        'zip' => 'required|min:5',
    ];

    public function locator()
    {

        $latlon = DB::table('zip_lat_lon')
            ->where('zip', '=', $this->zip)
            ->first();

        if (is_null($latlon) || strlen($this->zip) < 5) {
            $this->error = 'invalid';
            $this->showrooms = array();
        } else {
            $this->error = '';
            $this->zip =  substr($latlon->zip, 0, 5);
            $this->lat =  $latlon->lat;
            $this->lon =  $latlon->lon;

            $distance_calc = '(6371 * acos( cos( radians(' . $this->lat . ') ) * cos( radians( lat ) ) * cos( radians(' . $this->lon . ') - radians(lon) ) + sin( radians(' . $this->lat . ') ) * sin( radians(lat) ) ))';

            $field_list = 'customer_name, address1, address2, city, state, zip, locator_priority, ifnull(' . $distance_calc . ',1) as distance, ifnull(' . $distance_calc . ',10) * locator_priority as distance_priority';

            $this->showrooms = DB::table('addresses')
                ->selectRaw($field_list)
                ->orderBy('distance_priority')
                ->limit(5)
                ->get();
        }
        $this->validate();
    }

    public function render()
    {

        $this->dispatchBrowserEvent('contentChanged', $this->showrooms);

        return view('livewire.dealer-locator');
    }
}
