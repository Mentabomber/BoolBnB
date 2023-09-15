<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Apartment;
use App\Models\Service;
use App\Models\Address;
use App\Models\Message;

class ApiController extends Controller
{
    public function apartmentIndex() {
        $apartments = Apartment :: with('address', 'services')->get();
        return response()->json([
            'apartments' => $apartments,
        ]);
    }

    public function receiveMessage(Request $request) {

        $data = [

            'message' => $request['message'],
            'name' => $request['name'],
            'surname' => $request['surname'],
            'email' => $request['email'],
            'apartment_id' => $request['apartment_id'],
        ];

        Message :: create($data);
    }

    public function showApartment($id) {
        $apartment = Apartment::where('id', $id)->with(["services", "address"])->get();
        
        return response()->json(['apartment' => $apartment]);
    }

    public function filteredApartment(Request $request) {

        $data = $request -> all();

        $latitude = $data['latitude'];
        $longitude = $data['longitude'];
        $selectedServices = [1, 3];
        
        // if($data['servicesFilter'] == "") {
        //     $selectedServices = 0;
        // }else {
        // }
        
        if($data['bedsFilter'] == "") {
            $beds = 0;

        } else {
            $beds = $data['bedsFilter'];
        }

        if($data['roomsFilter'] == "") {
            $rooms = 0;

        } else {
            $rooms = $data['roomsFilter'];
        }

        if($data['kmFilter'] == 20) {
               $radius = 20; // in chilometri
        } else {
            $radius = $data['kmFilter'];
       }

        $apartments = Apartment::select('*')
            ->selectRaw(
                '(6371 * acos(cos(radians(' . $latitude . '))
                * cos(radians(addresses.latitude))
                * cos(radians(addresses.longitude)
                - radians(' . $longitude . '))
                + sin(radians(' . $latitude . '))
                * sin(radians(addresses.latitude)))) AS distance'
            )
            ->with('services')
            ->join('apartment_service', 'apartments.id', '=', 'apartment_service.apartment_id')
            ->join('addresses', 'addresses.apartment_id', '=', 'apartments.id')
            ->having('distance', '<=', $radius)
            ->having('beds', '>=', $beds)
            ->having('rooms', '>=', $rooms)
            ->where('apartment_service.service_id', $selectedServices)
            ->orderBy('distance', 'asc')
            ->get();
    
        return response()->json(['latitude' => $latitude, 'longitude' => $longitude, 'apartments' => $apartments]);
    }

    public function serviceList() {

        $services = Service::all();

        return response()-> json(['services' => $services]);
    }

}
