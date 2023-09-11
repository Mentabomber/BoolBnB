<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Apartment;

use GeoIP;


class GuestController extends Controller
{
    // Restituisce la lista di tutti gli appartamenti presenti nel db
    public function index() {

        $apartments = Apartment :: all();

        return view('welcome', compact('apartments'));
    }

    public function cercaAppartamenti(Request $request) {
        $data = $request -> all();
        // dd($data);

        $latitudeSt = $data['latitude'];
        $longitudeSt = $data['longitude'];
        $radius = 20; // in chilometri

        $apartments = Apartment::select('*')
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

        return view('advanced-search', compact('apartments'));
    }
}
