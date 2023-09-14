<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Apartment;
use App\Models\Service;
use App\Models\Message;

use GeoIP;


class GuestController extends Controller
{

    public function index() {

        $apartments = Apartment :: all();

        return view('welcome', compact('apartments'));
    
    }

    public function cercaAppartamenti(Request $request) {
        $data = $request -> all();
        
        $services = Service :: all();
        // dd($data);

        $latitudeSt = $data['latitude'];
        $longitudeSt = $data['longitude'];
        $radius = 50; // in chilometri

        $apartments = Apartment::where('*')
            ->selectRaw(
                '(6371 * acos(cos(radians(' . $latitudeSt . '))
                * cos(radians(addresses.latitude))
                * cos(radians(addresses.longitude)
                - radians(' . $longitudeSt . '))
                + sin(radians(' . $latitudeSt . '))
                * sin(radians(addresses.latitude)))) AS distance'
            )
            ->join('addresses', 'addresses.apartment_id', '=', 'apartments.id')
            ->having('distance', '<=', $radius)
            ->orderBy('distance', 'asc')
            ->get();
       
               
        
        return view('advanced-search', compact('apartments', 'services','latitudeSt','longitudeSt'));
    }

    public function message(Request $request, $id) {
        
        $data = $request -> all();
        $data['apartment_id'] = $id;
        $message = Message :: create($data);
        return redirect() -> route('guest.apartments.show', $id);
    }
}

